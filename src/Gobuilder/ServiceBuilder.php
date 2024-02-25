<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

use KhanCode\LaravelBaseRest\Helpers;
use Illuminate\Support\Facades\Schema;
use KhanCode\LaravelBaseRest\ValidationException;

class ServiceBuilder
{
    /**
     * default class
     */
    static $default_class = [
        "olsera.com/kikota/app/models",
        "olsera.com/kikota/app/repositories",
        "olsera.com/kikota/app/resources",
        "olsera.com/kikota/exceptions",
        "olsera.com/kikota/helpers",
        "olsera.com/kikota/customvalidator",        
        "encoding/json",
        "net/http",
	    "strings",
        "io/ioutil",
        "time",
        "fmt",
        "github.com/twinj/uuid",
        "golang.org/x/crypto/bcrypt",
        "strconv",
        "encoding/base64",
        "reflect",
        "os",
        "github.com/aws/aws-sdk-go/aws/credentials",
        "github.com/aws/aws-sdk-go/aws/session",
        "github.com/aws/aws-sdk-go/aws",
        "github.com/aws/aws-sdk-go/service/s3",
        "bytes",
        "errors",
        "image",
        "github.com/nfnt/resize",
        "image/png",
        "github.com/shopspring/decimal",
        "math/big",
        "html/template",
        "github.com/bojanz/currency",
        "github.com/huaweicloud/huaweicloud-sdk-go-obs/obs",
        "golang.org/x/text/cases",
        "golang.org/x/text/language",
        "encoding/csv",
        // "gorm.io/gorm", sudah ada di base
    ];

    /**
     * service builder function
     *
     * @param [type] $name
     * @param [type] $column
     * @param [type] $column_function
     * @param [type] $route
     * @return void
     */
    static function build( $name, $column, $column_function, $route, $relation, $hidden, $class, $with_timestamp_details, $with_authstamp_details, $with_ipstamp_details )
    {
        $Name = UCWORDS($name);
        $service_file_name = 'S_'.$Name;
        $base_service = file_get_contents(__DIR__.'/../../base-go/service/base.stub', FILE_USE_INCLUDE_PATH);

        $list_type_var = [
            'increment' => 'int',
            'bigIncrement'  => 'int64',
            'integer'   => 'int',
            'bigint'    => 'int64',
            'smallInteger'  => 'int',
            'tinyInteger'   => 'int',
            'boolean'   => 'int',
            'decimal'   => 'decimal.Decimal',
            'datetime'  => 'time.Time',
            'date'  => 'string',
            'timestamp' => 'time.Time',
            'string'    => 'string',
            'char'  => 'string',
            'text'  => 'string',
            'time'  => 'string'
        ];
        
        $list_file = scandir(__DIR__.'/../../base-go/service', SCANDIR_SORT_DESCENDING);
        foreach ($route as $key => $value) {
            
            if( $value["process"] == 'create_data' || $value["process"] == 'update_data' ){
                \KhanCode\LaravelRestBuilder\Models\Moduls::validate($value,[
                    'dataFilter' => [
                            'required', 
                        ],
                ],[
                    'dataFilter.required'   => "Pemabatasan Data harus di isi untuk route ".$value["name"]
                ]);

                if( Helpers::is_error() ) throw new ValidationException( Helpers::get_error() );
            }

            $function_name = 'function_'.$value['process'].'.stub';
            
            if(in_array($function_name,$list_file))
            {
                // base code function   
                $code_function = file_get_contents(__DIR__.'/../../base-go/service/'.$function_name, FILE_USE_INCLUDE_PATH);

                // custom_check_single_data
                if( !empty($value['custom_check_single_data']) ){
                    
                    $value['custom_check_single_data'] = str_replace("\n", "\n\t",$value['custom_check_single_data']);
                    $code_function = str_replace('{{custom_check_single_data}}', $value['custom_check_single_data'],$code_function);
                }

                // assign validation
                $param_validation = '';
                if( !empty($value['validation']) ){
                    $code_validation = file_get_contents(__DIR__.'/../../base-go/service/code_validation.stub', FILE_USE_INCLUDE_PATH);
                    $code_validation = str_replace("\n", "\n\t",$code_validation);

                    $code_function = str_replace('{{code_validation}}',$code_validation,$code_function);
                    
                    $type_column_assertion = 'string';
                    foreach ($value['validation'] as $validation_key => $validation_value) {
                        foreach ($column as $c_key => $c_value) {
                            if( $c_value["name"] == $validation_value["name"] ){
                                $type_column_assertion = $list_type_var[$c_value["type"]]??"string";
                            }
                        }

                        $param_validation .= ucfirst($validation_value['name']) . ' ' . $type_column_assertion . ' `json:"'.lcfirst($validation_value['name']).'" validate:"' . $validation_value['statement'] . '"`';
                        if( $validation_key != count($value['validation'])-1 ){
                            $param_validation .= "\n\t\t";
                        }
                    }
                }else{
                    if( !empty($value['advanced_validation']) ){
                        $value['advanced_validation_code'] = str_replace("\n", "\n\t", $value['advanced_validation_code']);
                        $code_function = str_replace('{{code_validation}}', $value['advanced_validation_code'],$code_function);
                    }else {
                        $code_function = str_replace('{{code_validation}}', '',$code_function);
                    }
                }
                $code_function = str_replace('{{param_validate}}',$param_validation,$code_function);

                // make param function
                $param_function = '';
                if(!empty($value['param']))
                {
                    foreach ($value['param'] as $key_param => $value_param) {
                        $param_function .= ', '.((!empty($value_param['name'])) ? $value_param['name']:$value_param).' string';
                    }
                }

                // make data sanitation                
                $code_filter = '';
                $column_sanitated = '';
                if( !empty($value['dataFilter']) ){
                    $code_filter = "raw_column := []string{}\n";
                    $code_filter .= "\tthis_model := models.{{ModulName}}Model{}\n";
                    foreach ($value['dataFilter'] as $key_filter => $value_filter) {
                        $column_sanitated .= "`".$value_filter["name"]."`";
                        if( $key_filter != count($value['dataFilter'])-1 ){
                            $column_sanitated .= ', ';
                        }

                        $type_column_assertion = 'string';
                        foreach ($column as $c_key => $c_value) {
                            if( $c_value["name"] == $value_filter["name"] ){
                                $type_column_assertion = $list_type_var[$c_value["type"]]??"string";
                            }
                        }
                        
                        $code_filter .= "\tif _, ok := data[\"".$value_filter['name']."\"]; ok {\n";
                        if( $type_column_assertion == 'int' ){
                            $code_filter .= "\t\t".'this_model.' . ucfirst($value_filter['name']) . ' = helpers.ConvertToInt(data["'.$value_filter['name'].'"])' . "\n";
                        }else if( $type_column_assertion == 'int64' ){
                            $code_filter .= "\t\t".'this_model.' . ucfirst($value_filter['name']) . ' = helpers.ConvertToInt64(data["'.$value_filter['name'].'"])' . "\n";
                        }else if( $type_column_assertion == 'decimal.Decimal'){
                            $code_filter .= "\t\t".'val_param_'.$value_filter['name'].', err := decimal.NewFromString(helpers.ConvertToString(data["'.$value_filter['name'].'"]))' . "\n";
                            $code_filter .= "\t\tif err != nil {\n";
                                $code_filter .= "\t\terrorState := exceptions.ErrorException(500, fmt.Sprintf(\"could not decode to decimal %s\",err))\n";
		                        $code_filter .= "\t\treturn nil, errorState\n";
                            $code_filter .= "\t\t}\n";
                            $code_filter .= "\t\t".'this_model.' . ucfirst($value_filter['name']) . ' = val_param_' . $value_filter['name'] . "\n";
                        }else {
                            $code_filter .= "\t\t".'this_model.' . ucfirst($value_filter['name']) . ' = helpers.ConvertToString(data["'.$value_filter['name'].'"])' . "\n";
                        }
                        $code_filter .= "\t\traw_column = append(raw_column, \"".$value_filter['name']."\")\n";
                        $code_filter .= "\t}\n\t";
                    }
                }
                $code_function = str_replace([
                    '{{code_sanitation}}',
                    '{{column_sanitated}}'
                ],[
                    $code_filter,
                    $column_sanitated
                ],$code_function);

                // make relation code
                $code_relation = '';
                if( !empty($relation) ){
                    foreach ($relation as $rel_key => $rel_value) {
                        
                        $base_code_relation = file_get_contents(__DIR__.'/../../base-go/service/code_'.$rel_value['type'].'.stub', FILE_USE_INCLUDE_PATH)."\n";
                        
                        $model_name_function = str_replace_first('Model','',$rel_value["model_name"]??$rel_value["name"]);
                        $base_code_relation = str_replace([
                            "{{parameter_name}}",
                            "{{ucfirst_parameter_name}}",
                            "{{function_name_create}}",
                            "{{function_name_update}}",
                            "{{function_name_delete}}",
                            "{{column_foreign_key}}",
                            "\n",
                            "{{ucfirst_column_foreign_key}}",
                            "{{model_name}}",
                            "{{function_name_create_intermediate_table}}",
                            "{{foreign_key_model}}",
                            "{{foreign_key_joining_model}}"
                        ],[
                            $rel_value["name"],
                            ucfirst($rel_value["name"]),
                            UCWORDS(($model_name_function).ucfirst($value["fungsi_relasi"][$rel_value["name"]]??'create')),
                            UCWORDS(($model_name_function).ucfirst($value["fungsi_relasi_update"][$rel_value["name"]]??'update')),
                            UCWORDS(($model_name_function).ucfirst($value["fungsi_relasi_delete"][$rel_value["name"]]??'delete')),
                            $rel_value["foreign_key"]??NULL,
                            "\n\t",
                            ucfirst($rel_value["foreign_key"]??NULL),
                            $rel_value["model_name"]??$rel_value["name"],
                            UCWORDS((str_replace_first('Model','',$rel_value["modul_intermediate_table"]??NULL)).ucfirst( (empty(array_get($value,"fungsi_relasi.".$rel_value["name"],NULL))?"Create":array_get($value,"fungsi_relasi.".$rel_value["name"],NULL))) ),
                            $rel_value["foreign_key_model"]??NULL,
                            $rel_value["foreign_key_joining_model"]??NULL,
                        ], $base_code_relation);
                        $code_relation .= $base_code_relation;
                    }
                }
                // {{relation_function}}
                
                $custom_code_modified_column = "";
                if( !empty($with_timestamp_details['update']) && ($value['process'] == "update_data" or $value['process'] == "create_update_data") ){
                    $custom_code_modified_column = "raw_column = append(raw_column, \"modified_time\")\n\t\t".$custom_code_modified_column;
                    $custom_code_modified_column = "raw_column = append(raw_column, \"modified_by\")\n\t\t".$custom_code_modified_column;
                    $custom_code_modified_column = "raw_column = append(raw_column, \"modified_from\")\n\t\t".$custom_code_modified_column;
                }

                if(!empty($value['custom_code_before'])){
                    $custom_code_before = "\n\t".str_replace("\n", "\n\t", $value['custom_code_before'])."\n";
                }else {
                    $custom_code_before = NULL;
                }

                if(!empty($value['custom_code_after'])){
                    $custom_code_after = "\n\t".str_replace("\n", "\n\t", $value['custom_code_after'])."\n";
                }else {
                    $custom_code_after = NULL;
                }

                // replace param umum
                $code_function = str_replace([
                    "{{UrlParam}}",
                    "{{ModulName}}",
                    "{{Name}}",
                    "{{relation_function}}",
                    "{{custom_function}}",
                    "{{custom_code_before}}",
                    "{{custom_code_after}}",
                    "{{system_function}}",
                    "{{custom_code_modified_column}}"
                ],[
                    $param_function,
                    $Name,
                    ucwords($value['name']),
                    $code_relation,
                    str_replace("\n", "\n\t", $value['custom_function']??""),
                    $custom_code_before,
                    $custom_code_after,
                    str_replace("\n", "\n\t", $value['system_function']??""),
                    $custom_code_modified_column,
                ],$code_function);

                if( $key != count($route)-1 ){
                    $code_function = str_replace('// end list function',"\n" . '// end list function',$code_function);
                }

                // assign function to base
                $base_service = str_replace('// end list function',$code_function,$base_service);
            }
        }

        // if( array_get($column, "0.type", "integer") == "integer" ){
        //     $class["strconv"] = "strconv";
        //     $class["olsera.com/kikota/exceptions"] = "olsera.com/kikota/exceptions";
        //     $code_type_first_column = file_get_contents(__DIR__.'/../../base-go/service/code_type_first_column.stub', FILE_USE_INCLUDE_PATH);
        //     $base_service = str_replace('{{code_type_first_column}}', $code_type_first_column,$base_service);
        // }else{
        //     $base_service = str_replace('{{code_type_first_column}}',"this_model.Id = id",$base_service);
        // }

        $base_service = self::generateClass($base_service, $class);
        
        FileCreator::create( $service_file_name, 'app/services', $base_service );
        return;
        dd($base_service);


        $cols = '';
        $hidden = array_flip($hidden);        
        foreach ($column as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) && !isset($hidden[ $value['name'] ]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_service = str_replace('// end list column',$cols,$base_service);
            }
        }
        
        foreach ($column_function as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_service = str_replace('// end list column',$cols,$base_service);
            }
        }

        foreach ($relation as $key => $value) {
            $value['name'] = empty($value['name_param']) ? $value['name'] : $value['name_param'];
            $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list relation column";
            $base_service = str_replace('// end list relation column',$cols,$base_service);
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_service = str_replace('// end list column',$cols,$base_service);
            }
        }
        
        FileCreator::create( $service_file_name, 'app/Http/services/Api', $base_service );
    }

    /**
     * Undocumented function
     *
     * @param [type] $base
     * @param [type] $class
     * @return void
     */
    public static function generateClass($base, $class)
    {
        foreach (self::$default_class as $key => $value) {
            $last_string = explode("/",$value);
            if (
                strpos($base, ' '.$last_string[count($last_string)-1].'.') !== false 
                || 
                strpos($base, "\t".$last_string[count($last_string)-1].'.') !== false
                ||
                strpos($base, "(".$last_string[count($last_string)-1].'.') !== false
            ) {
                $class[] = $value;
            }
        }

        foreach ($class as $key => $value) {
            $base = str_replace('{{class}}','"' . $value . '"' . "\n\t" . "{{class}}",$base);
        }

        $base = str_replace('{{class}}', "",$base);

        return $base;
    }

    function str_replace_first($from, $to, $content)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }
}