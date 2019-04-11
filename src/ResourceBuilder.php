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
    static function build( $name, $column, $column_function, $relation )
    {
        $resource_file = ucwords($name).'Resource';        
        $base_resource = file_get_contents(__DIR__.'/../base/resource/base.php', FILE_USE_INCLUDE_PATH);

        $base_resource = str_replace('{{Name}}',$name,$base_resource);

        $code_column = '';
        foreach ($column as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $code_column .= (($key!=0) ? "\t\t\t":"").'$this->mergeWhen(\Request::get("show_'.$value['name'].'",1)==1, [
                    "'.$value['name'].'"    =>  $this->'.$value['name'].',
                ])'.",\r\n";
            }
        }
        
        foreach ($column_function as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $code_column .= (($key!=0) ? "\t\t\t":"").'$this->mergeWhen(\Request::get("show_'.$value['name'].'",1)==1, [
                    "'.$value['name'].'"    =>  $this->'.$value['name'].',
                ])'.",\r\n";
            }
        }
        
        $base_resource = str_replace('// end list column',$code_column."\t\t\t"."// end list column",$base_resource);

        $i = 0;
        $code_relation = '';
        foreach ($relation as $key => $value_relation) {
            $code_relation .= (($i!=0) ? "\t\t\t":"").'$this->mergeWhen(\Request::get("show_'.$value_relation['name'].'",1)==1, [
                "'.$value_relation['name'].'"    =>  json_decode($this->'.$value_relation['name'].'),
            ])'.",\r\n";                
            $i++;
        }
        $base_resource = str_replace('// end list relation',$code_relation."\t\t\t"."// end list relation",$base_resource);

        FileCreator::create( $resource_file, 'app/Http/Resources', $base_resource );
    }

}