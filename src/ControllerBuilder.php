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
     * @param [type] $column_function
     * @param [type] $route
     * @return void
     */
    static function build( $name, $column, $column_function, $route, $relation, $hidden, $custom_folder = '' )
    {
        $name = UCWORDS($name);
        $controller_file_name = $name.'Controller';
        $base_controller = file_get_contents(__DIR__.'/../base/controller/controller.stub', FILE_USE_INCLUDE_PATH);
        $base_controller = str_replace([
            '{{name}}',
            '{{custom_folder}}',
            '{{custom_folder_namespace}}',
        ],[
            $name,
            $custom_folder,
            str_replace('/','\\',$custom_folder)
        ],$base_controller);

        $list_file = scandir(__DIR__.'/../base/controller', SCANDIR_SORT_DESCENDING);
        foreach ($route as $key => $value) {
            if($value['name'] == 'system_data') {
                continue;
            }

            $value['name'] = str_replace('/','',$value['name']);

            $function_name = 'function_'.$value['process'].'.stub';
            if(in_array($function_name,$list_file))
            {
                $param = '';
                $param_function = '';
                if(!empty($value['param']))
                {
                    foreach ($value['param'] as $key_param => $value_param) {
                        if($key_param!=0) {
                            $param .= ',';
                        }
                        $param .= ((!empty($value_param['class'])) ? $value_param['class']:'').' $'.((!empty($value_param['name'])) ? $value_param['name']:$value_param);
                        $param_function .= ',$'.((!empty($value_param['name'])) ? $value_param['name']:$value_param);
                    }
                }
                
                $code_function = file_get_contents(__DIR__.'/../base/controller/'.$function_name, FILE_USE_INCLUDE_PATH);
                $code_function = str_replace('{{param}}',$param,$code_function);
                $code_function = str_replace('{{param_function}}',$param_function,$code_function);
                $code_function = str_replace('{{name}}',$value['name'],$code_function);
                $code_function = str_replace('{{Name}}',UCWORDS($value['name']),$code_function);                
                $code_function = str_replace('{{Modul_name}}',UCWORDS($name),$code_function);                
                $base_controller = str_replace('// end list function',$code_function,$base_controller);
            }            
        }
        
        $cols = '';
        $hidden = array_flip($hidden);        
        foreach ($column as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) && !isset($hidden[ $value['name'] ]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_controller = str_replace('// end list column',$cols,$base_controller);
            }
        }
        
        foreach ($column_function as $key => $value) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_controller = str_replace('// end list column',$cols,$base_controller);
            }
        }

        foreach ($relation as $key => $value) {
            $value['name'] = empty($value['name_param']) ? $value['name'] : $value['name_param'];
            $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list relation column";
            $base_controller = str_replace('// end list relation column',$cols,$base_controller);
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
                $base_controller = str_replace('// end list column',$cols,$base_controller);
            }
        }

        $base_controller = str_replace([
            '{{custom_folder}}',
            '{{custom_folder_namespace}}',
        ],[
            $custom_folder,
            str_replace('/','\\',$custom_folder)
        ],$base_controller);

        FileCreator::create( $controller_file_name, 'app/Http/Controllers/Api'.$custom_folder, $base_controller );
    }

}