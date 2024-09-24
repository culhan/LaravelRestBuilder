<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

use Illuminate\Support\Facades\Schema;

class ResourceBuilder
{
    /**
     * default class
     */
    static $default_class = [
        "github.com/gin-gonic/gin",
        "{{code_name}}/app/models",
        "{{code_name}}/app/repositories",
        "{{code_name}}/exceptions",
        "{{code_name}}/helpers",
        "encoding/json",
        "net/http",
	    "strings",
        "io/ioutil",
        "time",
        "reflect",
        "math/big",
        "gorm.io/gorm",
    ];

    /**
     * resource builder function
     *
     * @param [type] $name
     * @param [type] $column
     * @param [type] $column_function
     * @param [type] $relation
     * @return void
     */
    static function build( $name, $column, $column_function, $relation, $hidden, $hidden_relation, $class )
    {
        $Name = ucwords($name);
        $resource_file = $Name.'Resource';

        $base_resource = file_get_contents(__DIR__.'/../../base-go/resource/base.stub', FILE_USE_INCLUDE_PATH);
        $base_mutation_code = file_get_contents(__DIR__.'/../../base-go/resource/mutation.stub', FILE_USE_INCLUDE_PATH);
        $base_text_column_with_check = file_get_contents(__DIR__.'/../../base-go/resource/text_column_with_check.stub', FILE_USE_INCLUDE_PATH);

        $list_type_var = [
            'increment' => 'int',
            'bigIncrement'  => 'int64',
            'integer'   => 'int',
            'bigint'    => 'int64',
            'smallInteger'  => 'int',
            'tinyInteger'   => 'int',
            'boolean'   => 'int',
            'decimal'   => 'decimal.Decimal',
            'datetime'  => 'string',
            'date'  => 'string',
            'timestamp' => 'string',
            'string'    => 'string',
            'char'  => 'string',
            'text'  => 'string',
            'time'  => 'string'
        ];

        $mutation_data_code = '';
        // $addr_text_column = '';
        // $text_column = '';
        // $text_column_attribute = '';
        $text_column_with_check = '';
        $hidden = array_flip($hidden);        
        foreach ($column as $key => $value) {
            if(isset($hidden[$value['name']])) continue;

            if( !empty($text_column_with_check) ){
                // $addr_text_column .= "\n\t";
                // $text_column .= "\n\t\t";
                // $text_column_attribute .= "\n\t\t";
                $text_column_with_check .= "\n\n\t";
            }
            // $text_column .= ucfirst($value['name'])."\tinterface{}\t".'`json:"'.$value['name'].'"`';
            // $text_column_attribute .= ucfirst($value['name']).":\t&data_".$value['name'].",";
            // $addr_text_column .= "data_".$value['name']." := data_result[\"".$value['name']."\"]";
            $text_column_with_check .= str_replace([
                "{{column}}",
                "{{code}}",
            ], [
                $value['name'],
                "singleData[\"".$value['name']."\"] = data_result[\"".$value['name']."\"]",
            ], $base_text_column_with_check);
        }

        foreach ($column_function as $key => $value) {
            if( !empty($text_column_with_check) ){
                // $addr_text_column .= "\n\t";
                // $text_column .= "\n\t\t";
                // $text_column_attribute .= "\n\t\t";
                $text_column_with_check .= "\n\n\t";
            }
            // $text_column .= ucfirst($value['name'])."\tinterface{}\t".'`json:"'.$value['name'].'"`';
            // $text_column_attribute .= ucfirst($value['name']).":\t&data_".$value['name'].",";

            $mutation_code = NULL;
            if( !empty($value["response_code"]) ){
                $mutation_code = str_replace(
                    "\n",
                    "\n\t\t",
                    $value["response_code"]
                );
            }if( isset($value['json']) ){
                $mutation_code = str_replace("{{var_name}}", $value['name'], $base_mutation_code);
                // $addr_text_column .= $mutation_code;
            }else {
                // $addr_text_column .= "data_".$value['name']." := data_result[\"".$value['name']."\"]";
            }

            $text_column_with_check .= str_replace([
                "{{column}}",
                "{{code}}",
            ], [
                $value['name'],
                $mutation_code??("singleData[\"".$value['name']."\"] = data_result[\"".$value['name']."\"]"),
            ], $base_text_column_with_check);
        }

        $hidden_relation = array_flip($hidden_relation);
        foreach ($relation as $key => $value) {
            if(isset($hidden_relation[$value['name']])) continue;
            
            // $class["encoding/json"] = "encoding/json";
            // if( $mutation_data_code != '' ){
            //     $mutation_data_code .= "\t";
            // }
            
            // $mutation_data_code .= file_get_contents(__DIR__.'/../../base-go/resource/mutation_code_'.$value["type"].'.stub', FILE_USE_INCLUDE_PATH);
            // $mutation_data_code = str_replace([
            //     "{{var_name}}",
            //     "{{relation_name}}",
            // ],[
            //     $name.$value["name"],
            //     $value["name"],
            // ],$mutation_data_code);

            if( !empty($text_column_with_check) ){
                // $text_column .= "\n\t\t";
                // $text_column_attribute .= "\n\t\t";
                $text_column_with_check .= "\n\n\t";
            }
            // $text_column .= ucfirst($value['name'])."\tinterface{}\t".'`json:"'.$value['name'].'"`';
            // $text_column_attribute .= ucfirst($value['name']).":\t&".$name.$value["name"].",";

            $text_column_with_check .= str_replace([
                "{{column}}",
                "{{code}}",
            ], [
                $value['name'],
                str_replace("{{var_name}}", $value['name'], $base_mutation_code),
            ], $base_text_column_with_check);
        }
        
        $base_resource = str_replace([
            '{{Name}}',
            // '{{addr_text_column}}',
            // '{{text_column}}',
            // '{{text_column_attribute}}',
            '{{text_column_with_check}}',
            '{{mutation_data}}',
        ],[
            $Name,
            // $addr_text_column,
            // $text_column,
            // $text_column_attribute,
            $text_column_with_check,
            $mutation_data_code,
        ],$base_resource);

        $base_resource = self::generateClass($base_resource, $class);

        FileCreator::create( $resource_file, 'app/resources', $base_resource );
        return;

        dd($base_resource);
        
        $base_resource = file_get_contents(__DIR__.'/../base'.$base.'/resource/base.stub', FILE_USE_INCLUDE_PATH);
        $base_column = file_get_contents(__DIR__.'/../base'.$base.'/resource/column.stub', FILE_USE_INCLUDE_PATH);
        // $base_column_with_json = file_get_contents(__DIR__.'/../base'.$base.'/resource/column_with_json.stub', FILE_USE_INCLUDE_PATH);

        $base_resource = str_replace('{{Name}}',ucwords($name),$base_resource);

        $code_column = '';
        $hidden = array_flip($hidden);
        $hidden_relation = array_flip($hidden_relation);
        $jumlah_column = 0;
        foreach ($column as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) && !isset($hidden[$value['name']]) )
            {
                $value['name_function'] = '$this->'.$value['name'];
                $code_column .= (($jumlah_column!=0) ? "\t\t\t":"").str_replace(['{{name}}','{{name_function}}'], [$value['name'],$value['name_function']], $base_column);
                $jumlah_column++;
            }
        }
        
        foreach ($column_function as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {                
                $value['name_function'] = '$this->'.$value['name'];

                // masuk ke accessor model
                // if(!empty($value['response_code'])) {
                //     $value['name_function']  = $value['response_code'];
                // }                
                $base_code_response = ( empty($value['json'])?str_replace(['{{name}}','{{name_function}}'], [$value['name'],$value['name_function']], $base_column):str_replace(['{{name}}','{{name_function}}'], [$value['name'],$value['name_function']], $base_column) );
                $code_column .= (($jumlah_column!=0) ? "\t\t\t":"").$base_code_response;
                $jumlah_column++;
            }
        }
        
        $base_resource = str_replace('// end list column',$code_column."\t\t\t"."// end list column",$base_resource);
        
        $i = 0;
        $code_relation = '';
        foreach ($relation as $key => $value) {
            if( !isset($hidden_relation[$value['name']]) ) {
                $value['name'] = empty($value['name_param']) ? $value['name'] : $value['name_param'];
                $value['name_function'] = '$this->'.$value['name'];
                $code_relation .= (($i!=0) ? "\t\t\t":"").str_replace(['{{name}}','{{name_function}}'], [$value['name'],$value['name_function']], $base_column);
                $i++;
            }
        }        
        $base_resource = str_replace('// end list relation',$code_relation."\t\t\t"."// end list relation",$base_resource);

        FileCreator::create( $resource_file, 'app/Http/Resources', $base_resource );
    }

    /**
     * Undocumented function
     *
     * @param [type] $base
     * @param [type] $class
     * @return void
     */
    public static function generateClass($base, $class, $custom_code = [])
    {
        foreach (self::$default_class as $key => $value) {
            $last_string = explode("/",$value);
            $string_searched = $last_string[count($last_string)-1];

            $stringToFind = [
                '*'.$string_searched.'.',
                ' '.$string_searched.')',
                ' '.$string_searched.'.',
                "\t".$string_searched.'.',
                '+'.$string_searched.'.',
                ' '.$string_searched.'.',
                '!'.$string_searched.'.',
                '('.$string_searched.'.',
            ];

            foreach ($stringToFind as $stf_value) {
                if ( strpos($base, $stf_value) !== false ){
                    $class[$value] = $value;
                } 
            }
        }

        foreach ($custom_code as $ckey => $cvalue) {
            foreach (self::$default_class as $key => $value) {
                $last_string = explode("/",$value);
                $string_searched = $last_string[count($last_string)-1];

                $stringToFind = [
                    '*'.$string_searched.'.',
                    ' '.$string_searched.')',
                    ' '.$string_searched.'.',
                    "\t".$string_searched.'.',
                    '+'.$string_searched.'.',
                    ' '.$string_searched.'.',
                    '!'.$string_searched.'.',
                    '('.$string_searched.'.',
                ];

                foreach ($stringToFind as $stf_value) {
                    if ( strpos($cvalue, $stf_value) !== false ){
                        $class[$value] = $value;
                    } 
                }
            }
        }

        foreach ($class as $key => $value) {
            $base = str_replace('{{class}}','"' . $value . '"' . "\n\t" . "{{class}}",$base);
        }

        $base = str_replace('{{class}}', "",$base);

        return $base;
    }

}