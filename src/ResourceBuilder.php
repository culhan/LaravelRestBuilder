<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class ResourceBuilder
{

    /**
     * resource builder function
     *
     * @param [type] $name
     * @param [type] $column
     * @param [type] $column_function
     * @param [type] $relation
     * @return void
     */
    static function build( $name, $column, $column_function, $relation, $hidden, $hidden_relation )
    {
        $base = config('laravelRestBuilder.base');
        $resource_file = ucwords($name).'Resource';        
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

}