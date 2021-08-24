<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

use Illuminate\Support\Facades\Schema;

class ServiceBuilder
{
    /**
     * service builder function
     *
     * @param [type] $name
     * @param [type] $column
     * @param [type] $column_function
     * @param [type] $route
     * @return void
     */
    static function build( $name, $column, $column_function, $route, $relation, $hidden, $class )
    {
        $Name = UCWORDS($name);
        $service_file_name = 'S_'.$Name;
        $base_service = file_get_contents(__DIR__.'/../../base-go/service/base.stub', FILE_USE_INCLUDE_PATH);

        $list_type_var = [
            'increment' => 'int',
            'bigIncrement'  => 'int',
            'integer'   => 'int',
            'bigint'    => 'int',
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
            if($value['name'] == 'system_data') {
                continue;
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
                    $class["encoding/json"] = "encoding/json";
                    $code_validation = file_get_contents(__DIR__.'/../../base-go/service/code_validation.stub', FILE_USE_INCLUDE_PATH);
                    $code_validation = str_replace("\n", "\n\t",$code_validation);

                    $code_function = str_replace('{{code_validation}}',$code_validation,$code_function);
                    
                    foreach ($value['validation'] as $validation_key => $validation_value) {
                        $param_validation .= ucfirst($validation_value['name']) . ' ' . ($column[$validation_value['name']]??'string') . ' `json:"'.lcfirst($validation_value['name']).'" validate:"' . $validation_value['statement'] . '"`';
                    }
                }else{
                    $code_function = str_replace('{{code_validation}}', '',$code_function);
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
                if( !empty($value['dataFilter']) ){
                    foreach ($value['dataFilter'] as $key_filter => $value_filter) {
                        $type_column_assertion = 'string';
                        foreach ($column as $c_key => $c_value) {
                            if( $c_value["name"] == $value_filter["name"] ){
                                $type_column_assertion = $list_type_var[$c_value["type"]]??"string";
                            }
                        }
                        $code_filter .= "if _, ok := data[\"".$value_filter['name']."\"]; ok {\n";
                        $code_filter .= "\t\t".'this_model.' . ucfirst($value_filter['name']) . ' = data["'.$value_filter['name'].'"].('. $type_column_assertion .')' . "\n";
                        $code_filter .= "\t}\n\t";
                    }
                }
                $code_function = str_replace('{{code_sanitation}}',$code_filter,$code_function);

                // make relation code
                $code_relation = '';
                if( !empty($relation) ){
                    foreach ($relation as $rel_key => $rel_value) {
                        $base_code_relation = file_get_contents(__DIR__.'/../../base-go/service/code_'.$rel_value['type'].'.stub', FILE_USE_INCLUDE_PATH)."\n";
                        
                        $base_code_relation = str_replace([
                            "{{parameter_name}}",
                            "{{function_name}}",
                            "{{column_foreign_key}}",
                            "\n",
                        ],[
                            $rel_value["name"],
                            UCWORDS(($rel_value["model_name"]??$rel_value["name"]).ucfirst($value["fungsi_relasi"][$rel_value["name"]]??'create')),
                            $rel_value["foreign_key"],
                            "\n\t",
                        ], $base_code_relation);
                        $code_relation .= $base_code_relation;
                    }
                }
                // {{relation_function}}

                // replace param umum
                $code_function = str_replace([
                    "{{UrlParam}}",
                    "{{ModulName}}",
                    "{{Name}}",
                    "{{relation_function}}",
                ],[
                    $param_function,
                    $Name,
                    ucwords($value['name']),
                    $code_relation
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
        foreach ($class as $key => $value) {
            $base = str_replace('{{class}}','"' . $value . '"' . "\n\t" . "{{class}}",$base);
        }

        $base = str_replace('{{class}}', "",$base);

        return $base;
    }

}