<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class RouteBuilder
{

    /**
     * builder route function
     *
     * @param [type] $name
     * @param [type] $route
     * @return void
     */
    static function build( $name, $route )
    {
        $route_file = $name;        
        $base_route = file_get_contents(__DIR__.'/../base/route/base.stub', FILE_USE_INCLUDE_PATH);
        $route_code = '<?php'."\r\n";
        foreach ($route as $key => $value) {
            if($value['process'] == 'system_data') {
                continue;
            }
            $route_code .= $base_route."\r\n";
            $route_code = str_replace('{{Name}}',ucwords($name),$route_code);
            $route_code = str_replace('{{name_route}}',$value['prefix'].$name.'/'.$value['name'],$route_code);
            $route_code = str_replace('{{name}}',$name.'/'.$value['name'],$route_code);
            $route_code = str_replace('{{name_function}}',$value['name'],$route_code);
            $route_code = str_replace('{{method}}',$value['method'],$route_code);
            
            if( !empty($value['param']) )
            {
                $param = '';
                foreach ($value['param'] as $key_param => $value_param) {                    
                    if( strpos( $value['prefix'], '{'.$value_param.'}' ) === false ) {
                        $param .= '/{'.$value_param.'}';                        
                    }                    
                }
                $route_code = str_replace('{{param}}',$param,$route_code);
            }else {
                $route_code = str_replace('{{param}}','',$route_code);
            }
            
            if( !empty($value['middleware']) )
            {
                $middleware = "";
                foreach ($value['middleware'] as $key_param => $value_param) {
                    $middleware .= '"'.$value_param;
                    if( !empty($value['middleware_parameter'][$value_param]) ) {
                        $middleware .= ':'.$value['middleware_parameter'][$value_param];
                    }
                    $middleware .= '"';
                    if( !empty($value['middleware'][$key_param+1]) ) {
                        $middleware .= ",";
                    }
                }
                $route_code = str_replace('{{middleware}}',$middleware,$route_code);
            }else {
                $route_code = str_replace('{{middleware}}','',$route_code);
            }
        }
        
        $system_route = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/routes/api.php', FILE_USE_INCLUDE_PATH);
        
        if (strpos($system_route, "include '".$route_file.".php';") === false) {
            // $system_route = str_replace('// include file route',"include '".$route_file.".php';\r\n\r\n// include file route",$system_route);
            $system_route = $system_route."\r\n\r\n"."include '".$route_file.".php';";
            FileCreator::create( 'api', 'routes', $system_route, 'route', false );
        }
        
        // untuk route bukan copy file, tapi append
        // if( !empty(config('laravelrestbuilder.copy_to')) )
        // {
        //     $system_route = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/routes/api.php', FILE_USE_INCLUDE_PATH);            
        //     if (strpos($system_route, "include '".$route_file.".php';") === false) {                
        //         $system_route = $system_route."\r\n\r\n"."include '".$route_file.".php';";
        //         FileCreator::create( 'api', config('laravelrestbuilder.copy_to').'/routes', $system_route, 'route', false );                
        //     }
        // }

        FileCreator::create( $route_file, 'routes', $route_code );
    }

}