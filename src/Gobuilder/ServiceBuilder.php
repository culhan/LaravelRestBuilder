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
    static function build( $name, $column, $column_function, $route, $relation, $hidden )
    {
        $class = [];
        $Name = UCWORDS($name);
        $service_file_name = 'S_'.$Name;
        $base_service = file_get_contents(__DIR__.'/../../base-go/service/base.stub', FILE_USE_INCLUDE_PATH);
        
        $list_file = scandir(__DIR__.'/../../base-go/service', SCANDIR_SORT_DESCENDING);
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
                        $param_function .= ', '.((!empty($value_param['name'])) ? $value_param['name']:$value_param).' string';
                    }
                }
                
                $code_function = file_get_contents(__DIR__.'/../../base-go/service/'.$function_name, FILE_USE_INCLUDE_PATH);
                
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
                
                $base_service = str_replace('// end list function',$code_function,$base_service);
            }            
        }

        if( array_get($column, "0.type", "integer") == "integer" ){
            $class["strconv"] = "strconv";
            $class["olsera.com/kikota/exceptions"] = "olsera.com/kikota/exceptions";
            $code_type_first_column = file_get_contents(__DIR__.'/../../base-go/service/code_type_first_column.stub', FILE_USE_INCLUDE_PATH);
            $base_service = str_replace('{{code_type_first_column}}', $code_type_first_column,$base_service);
        }else{
            $base_service = str_replace('{{code_type_first_column}}',"this_model.Id = id",$base_service);
        }

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
            $base = str_replace('{{class}}','"' . $value . '"' . "\n" . "{{class}}",$base);
        }

        $base = str_replace('{{class}}', "",$base);

        return $base;
    }

}