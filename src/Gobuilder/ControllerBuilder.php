<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

use Illuminate\Support\Facades\Schema;

class ControllerBuilder
{
    /**
     * static default class
     */
    static $default_class = [
        "olsera.com/kikota/app/resources",
        "olsera.com/kikota/helpers",
    ];

    /**
     * controller builder function
     *
     * @param [type] $name
     * @param [type] $column
     * @param [type] $column_function
     * @param [type] $route
     * @return void
     */
    static function build( $name, $column, $column_function, $route, $relation, $hidden )
    {
        $Name = UCWORDS($name);
        $controller_file_name = 'C_'.$Name;
        $base_controller = file_get_contents(__DIR__.'/../../base-go/controller/base.stub', FILE_USE_INCLUDE_PATH);
        
        $list_file = scandir(__DIR__.'/../../base-go/controller', SCANDIR_SORT_DESCENDING);
        foreach ($route as $key => $value) {
            if($value['name'] == 'system_data') {
                continue;
            }
            $function_name = 'function_'.$value['process'].'.stub';
            if(in_array($function_name,$list_file))
            {
                $param_function = '';
                if(!empty($value['param']))
                {
                    foreach ($value['param'] as $key_param => $value_param) {
                        $param_function .= ', c.Param(`'.((!empty($value_param['name'])) ? $value_param['name']:$value_param).'`)';
                    }
                }
                
                $code_function = file_get_contents(__DIR__.'/../../base-go/controller/'.$function_name, FILE_USE_INCLUDE_PATH);
                
                $code_function = str_replace([
                    "{{UrlParam}}",
                    "{{ModulName}}",
                    "{{Name}}",
                ],[
                    $param_function,
                    $Name,
                    ucwords($value['name']),
                ],$code_function);

                if( $key != count($route)-1 ){
                    $code_function = str_replace('// end list function',"\n" . '// end list function',$code_function);
                }
                
                $base_controller = str_replace('// end list function',$code_function,$base_controller);
            }            
        }

        $base_controller = ServiceBuilder::generateClass($base_controller, []);
        
        FileCreator::create( $controller_file_name, 'app/controllers', $base_controller );
        return;
        // dd($base_controller);
        // $cols = '';
        // $hidden = array_flip($hidden);        
        // foreach ($column as $key => $value) {
        //     if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) && !isset($hidden[ $value['name'] ]) )
        //     {
        //         $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
        //         $base_controller = str_replace('// end list column',$cols,$base_controller);
        //     }
        // }
        
        // foreach ($column_function as $key => $value) {
        //     if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
        //     {
        //         $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
        //         $base_controller = str_replace('// end list column',$cols,$base_controller);
        //     }
        // }

        // foreach ($relation as $key => $value) {
        //     $value['name'] = empty($value['name_param']) ? $value['name'] : $value['name_param'];
        //     $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list relation column";
        //     $base_controller = str_replace('// end list relation column',$cols,$base_controller);
        //     if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
        //     {
        //         $cols = '"'.$value['name'].'" => "'.$value['name'].'",'."\r\n\t\t\t\t// end list column";
        //         $base_controller = str_replace('// end list column',$cols,$base_controller);
        //     }
        // }
        
        // FileCreator::create( $controller_file_name, 'app/Http/Controllers/Api', $base_controller );
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
            if (strpos($base, ' '.$last_string[count($last_string)-1]) !== false) {
                $class[] = $value;
            }
        }

        foreach ($class as $key => $value) {
            $base = str_replace('{{class}}','"' . $value . '"' . "\n\t" . "{{class}}",$base);
        }

        $base = str_replace('{{class}}', "",$base);

        return $base;
    }

}