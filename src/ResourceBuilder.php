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
    static function build( $name, $column, $column_function, $relation, $hidden )
    {
        $resource_file = ucwords($name).'Resource';        
        $base_resource = file_get_contents(__DIR__.'/../base/resource/base.stub', FILE_USE_INCLUDE_PATH);
        $base_column = file_get_contents(__DIR__.'/../base/resource/column.stub', FILE_USE_INCLUDE_PATH);
        $base_column_with_json = file_get_contents(__DIR__.'/../base/resource/column_with_json.stub', FILE_USE_INCLUDE_PATH);

        $base_resource = str_replace('{{Name}}',$name,$base_resource);

        $code_column = '';
        $hidden = array_flip($hidden);
        $jumlah_column = 0;
        foreach ($column as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) && !isset($hidden[$value['name']]) )
            {
                $code_column .= (($jumlah_column!=0) ? "\t\t\t":"").str_replace('{{name}}', $value['name'], $base_column);
                $jumlah_column++;
            }
        }
        
        foreach ($column_function as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $code_column .= (($jumlah_column!=0) ? "\t\t\t":"").( empty($value['json'])?str_replace('{{name}}', $value['name'], $base_column):str_replace('{{name}}', $value['name'], $base_column_with_json) );
                $jumlah_column++;
            }
        }
        
        $base_resource = str_replace('// end list column',$code_column."\t\t\t"."// end list column",$base_resource);
        
        $i = 0;
        $code_relation = '';
        foreach ($relation as $key => $value) {
            $code_relation .= (($i!=0) ? "\t\t\t":"").str_replace('{{name}}', $value['name'], $base_column_with_json);                
            $i++;
        }
        $base_resource = str_replace('// end list relation',$code_relation."\t\t\t"."// end list relation",$base_resource);

        FileCreator::create( $resource_file, 'app/Http/Resources', $base_resource );
    }

}