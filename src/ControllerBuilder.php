<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class ControllerBuilder
{

    /**
     * controller builder function
     *
     * @param [type] $name
     * @param [type] $column
     * @param [type] $route
     * @return void
     */
    static function build( $name, $column, $route )
    {
        $name = UCWORDS($name);
        $controller_file_name = $name.'Controller';
        $base_controller = file_get_contents(__DIR__.'/../base/controller/controller.php', FILE_USE_INCLUDE_PATH);
        $base_controller = str_replace('{{name}}',$name,$base_controller);

        $list_file = scandir(__DIR__.'/../base/controller', SCANDIR_SORT_DESCENDING);
        foreach ($route as $key => $value) {
            $function_name = 'function_'.$value['process'].'.php';
            if(in_array($function_name,$list_file))
            {
                $param = '';
                if(!empty($value['param']))
                {
                    foreach ($value['param'] as $key_param => $value_param) {
                        $param .= ',$'.$value_param;
                    }
                }
                $code_function = file_get_contents(__DIR__.'/../base/controller/'.$function_name, FILE_USE_INCLUDE_PATH);
                $code_function = str_replace('{{param}}',$param,$code_function);
                $code_function = str_replace('{{name}}',$value['name'],$code_function);
                $code_function = str_replace('{{Name}}',UCWORDS($value['name']),$code_function);                
                $code_function = str_replace('{{Modul_name}}',UCWORDS($name),$code_function);                
                $base_controller = str_replace('// end list function',$code_function,$base_controller);
            }            
        }
        
        $cols = '';
        foreach ($column as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_controller = str_replace('// end list column',$cols,$base_controller);
            }
        }        
        
        FileCreator::create( $controller_file_name, 'app/Http/Controllers/Api', $base_controller );
    }

}