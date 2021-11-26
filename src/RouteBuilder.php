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
     * @param [type] $old_name
     * @return void
     */
    static function build( $name, $route, $old_name, $custom_folder = '', $old_custom_folder )
    {
        $route_file = $name;        
        $base_route = file_get_contents(__DIR__.'/../base/route/base.stub', FILE_USE_INCLUDE_PATH);
        $route_code = '<?php'."\r\n";
        $route_builded = 0;
        foreach ($route as $key => $value) {
            if( empty($value['tanpa_route']) ) {
                $value['tanpa_route'] = '0';
            }
            if($value['process'] == 'system_data' || $value['tanpa_route'] == '1') {
                continue;
            }
            $route_builded++;
            $route_code .= $base_route."\r\n";
            $route_code = str_replace([
                '{{Name}}',
                '{{name_route}}',
                '{{name}}',
                '{{name_function}}',
                '{{method}}',
                '{{custom_folder}}',
                '{{custom_folder_namespace}}',
            ],[
                ucwords($name),
                $value['prefix'].$name.'/'.$value['name'],
                $name.'/'.$value['name'],
                str_replace('/','',$value['name']),
                $value['method'],
                $custom_folder,
                str_replace('/','\\',$custom_folder)
            ],$route_code);
            
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
        
        $custom_folder_include = '';
        if( !empty($custom_folder) ){
            $custom_folder_include = str_replace('/','',$custom_folder).'/';
        }

        $old_custom_folder_include = '';
        if( !empty($old_custom_folder) ){
            $old_custom_folder_include = str_replace('/','',ucfirst($old_custom_folder)).'/';
        }

        // hapus route lama, jika ada perubhan nama
        if( !empty($old_name) || !empty($old_custom_folder_include) ) {
            
            if(empty($old_name)){
                $old_name = $route_file;
            }
            
            $system_route = str_replace("\r\n\r\n"."include '".$old_custom_folder_include.camel_case($old_name).".php';","",$system_route);            
            // dd($system_route, "\r\n\r\n"."include '".$old_custom_folder_include.camel_case($old_name).".php';");
        }

        if (strpos($system_route, "include '".$custom_folder_include.$route_file.".php';") === false) {
            // $system_route = str_replace('// include file route',"include '".$route_file.".php';\r\n\r\n// include file route",$system_route);
            $system_route = $system_route."\r\n\r\n"."include '".$custom_folder_include.$route_file.".php';";
            FileCreator::create( 'api', 'routes', $system_route, 'route', false );
        }
        
        if( empty($route_builded)  ) {
            $system_route = str_replace("\r\n\r\n"."include '".$custom_folder_include.$route_file.".php';","",$system_route);
            FileCreator::create( 'api', 'routes', $system_route, 'route', false );
            if ( file_exists(base_path()."/".config('laravelrestbuilder.copy_to')."/".'routes'.$custom_folder."/".$route_file.".php") ) {
                unlink(base_path()."/".config('laravelrestbuilder.copy_to')."/".'routes'.$custom_folder."/".$route_file.".php");
            }            
        }else {
            $route_code .= "// start custom code\n// end custom code";
            FileCreator::create( $route_file, 'routes'.$custom_folder, $route_code, 'routes' );
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

}