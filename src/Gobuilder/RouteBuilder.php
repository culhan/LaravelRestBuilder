<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

use Illuminate\Support\Facades\Schema;

class RouteBuilder
{

    /**
     * default class
     */
    static $default_class = [
        "olsera.com/kikota/app/models",
        "olsera.com/kikota/app/repositories",
        "olsera.com/kikota/app/middleware",
        "olsera.com/kikota/exceptions",
        "olsera.com/kikota/helpers",
        "olsera.com/kikota/app/controllers",
        "encoding/json",
        "net/http",
	    "strings",
        "io/ioutil",
        "time",
    ];

    /**
     * builder route function
     *
     * @param [type] $name
     * @param [type] $route
     * @param [type] $old_name
     * @return void
     */
    static function build( $name, $route, $old_name, $class )
    {
        $Name = UCWORDS($name);
        $route_file = $name;        
        $base_route = file_get_contents(__DIR__.'/../../base-go/route/base.stub', FILE_USE_INCLUDE_PATH);
        $base_route_code = file_get_contents(__DIR__.'/../../base-go/route/route.stub', FILE_USE_INCLUDE_PATH);
        
        $route_code = '';
        $route_builded = 0;
        foreach ($route as $key => $value) {
            if( empty($value['tanpa_route']) ) {
                $value['tanpa_route'] = '0';                
            }
            if($value['process'] == 'system_data' || $value['tanpa_route'] == '1') {
                continue;
            }
            $route_builded++;
            $route_code = $base_route_code."\n";
            $route_code = str_replace('{{Name}}',ucwords($name),$route_code);
            $route_code = str_replace('{{name_route}}','/'.$value['prefix'].$name.'/'.$value['name'],$route_code);
            $route_code = str_replace('{{name}}',$name.'/'.$value['name'],$route_code);
            $route_code = str_replace('{{name_function}}',ucwords($value['name']),$route_code);
            $route_code = str_replace('{{method}}',strtoupper( $value['method'] ),$route_code);

            if( !empty($value['param']) )
            {
                $param = '';
                foreach ($value['param'] as $key_param => $value_param) {                    
                    if( strpos( $value['prefix'], '{'.((!empty($value_param['name'])) ? $value_param['name']:$value_param).'}' ) === false && empty($value_param['class']) ) {
                        $param .= '/{'.((!empty($value_param['name'])) ? $value_param['name']:$value_param).'}';                        
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
                   $middleware .= ", middleware.".$value_param."()";
                }
                
                $route_code = str_replace('{{middleware}}',$middleware,$route_code);
                
            }else {
                $route_code = str_replace('{{middleware}}','',$route_code);
            }

            $route_code = str_replace([
                    '{',
                    '}',
                ],[
                    ':',
                    ''
                ],
                $route_code
            );

            $base_route = str_replace("// end list function", $route_code."\t// end list function", $base_route);
        }

        $base_route = str_replace("{{ModulName}}", $Name, $base_route);

        $base_route = self::generateClass($base_route, $class);

        FileCreator::create( $Name, 'routes', $base_route, 'route', false );

        // tambah route di main
        $system_route = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/main.go', FILE_USE_INCLUDE_PATH);

        // check jika sudah ada
        if (strpos($system_route, "routes.$Name(r)") === false) {
            $system_route = str_replace("// end route list", "routes.$Name(r)"."\n\t"."// end route list", $system_route);
        }

        // hapus route lama, jika ada perubhan nama
        if( !empty($old_name) ) {
            $system_route = str_replace("\troutes.$old_name(r)\n","",$system_route);            
        }

        FileCreator::create( 'main', '', $system_route, 'route', false );

        return;
        dd($base_route);
        
        $system_route = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/routes/api.php', FILE_USE_INCLUDE_PATH);
        
        // hapus route lama, jika ada perubhan nama
        if( !empty($old_name) ) {
            $system_route = str_replace("\r\n\r\n"."include '".camel_case($old_name).".php';","",$system_route);            
        }

        if (strpos($system_route, "include '".$route_file.".php';") === false) {
            // $system_route = str_replace('// include file route',"include '".$route_file.".php';\r\n\r\n// include file route",$system_route);
            $system_route = $system_route."\r\n\r\n"."include '".$route_file.".php';";
            FileCreator::create( 'api', 'routes', $system_route, 'route', false );
        }
        
        if( empty($route_builded)  ) {
            $system_route = str_replace("\r\n\r\n"."include '".$route_file.".php';","",$system_route);
            FileCreator::create( 'api', 'routes', $system_route, 'route', false );
            if ( file_exists(base_path()."/".config('laravelrestbuilder.copy_to')."/".'routes'."/".$route_file.".php") ) {
                unlink(base_path()."/".config('laravelrestbuilder.copy_to')."/".'routes'."/".$route_file.".php");
            }            
        }else {
            $route_code .= "// start custom code\n// end custom code";
            FileCreator::create( $route_file, 'routes', $route_code, 'routes' );
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