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
        $base_route = file_get_contents(__DIR__.'/../base/route/base.php', FILE_USE_INCLUDE_PATH);
        $route_code = '<?php'."\r\n";
        foreach ($route as $key => $value) {
            $route_code .= $base_route."\r\n";
            $route_code = str_replace('{{Name}}',ucwords($name),$route_code);
            $route_code = str_replace('{{name_route}}',$name.'/'.$value['name'],$route_code);
            $route_code = str_replace('{{name}}',$name.'/'.$value['name'],$route_code);
            $route_code = str_replace('{{name_function}}',$value['name'],$route_code);
            $route_code = str_replace('{{method}}',$value['method'],$route_code);

            if( !empty($value['param']) )
            {
                $param = '';
                foreach ($value['param'] as $key_param => $value_param) {
                    $param .= '/{'.$value_param.'}';
                }
                $route_code = str_replace('{{param}}',$param,$route_code);
            }
            else
            {
                $route_code = str_replace('{{param}}','',$route_code);
            }
        }
        
        $system_route = file_get_contents(base_path().'/routes/api.php', FILE_USE_INCLUDE_PATH);        
        
        if (strpos($system_route, "include '".$route_file.".php';") === false) {
            $system_route = str_replace('// include file route',"include '".$route_file.".php';\r\n\r\n// include file route",$system_route);
            FileCreator::create( 'api', 'routes', $system_route );
        }        

        FileCreator::create( $route_file, 'routes', $route_code );
    }

}