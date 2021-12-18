<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class RepositoryBuilder
{

    /**
     * createRepository function
     *
     * @param [type] $name
     * @param [type] $table
     * @return void
     */
    static function build( $name, $table, $repositories, $custom_folder = '' )
    {
        $base = config('laravelRestBuilder.base');                

        $repository_file_name = ucwords($name).'Repository';
        $name = UCWORDS($name);

        if( !empty($table) ){
            $base_repository = file_get_contents(__DIR__.'/../base'.$base.'/repository/base.stub', FILE_USE_INCLUDE_PATH);
        }else {
            $base_repository = file_get_contents(__DIR__.'/../base'.$base.'/repository/base_without_model.stub', FILE_USE_INCLUDE_PATH);
        }
        
        $base_function_repository = file_get_contents(__DIR__.'/../base'.$base.'/repository/function.stub', FILE_USE_INCLUDE_PATH);
        $base_repository = str_replace([
            '{{Name}}',
            '{{custom_folder}}',
            '{{title_case_name}}',
            '{{custom_folder_namespace}}',
        ],[
            $name,
            $custom_folder,
            Helper::camelToTitle($name),
            str_replace('/','\\',$custom_folder),
        ],$base_repository);

        $function_code = '';
        foreach ($repositories as $repository) {

            $params = '';
            if( !empty($repository['param']) ) {
                foreach ($repository['param'] as $param_key => $param) {
                    $params .= '$'.$param;
                    if( $param_key+1 != count($repository['param']) ){
                        $params .= ', ';
                    }
                }
            }

            $repository['code'] = str_replace("\n","\n\t\t",$repository['code']);

            $function_code .= str_replace([
                "{{name}}",
                "{{code}}",
                "{{param}}",
            ],
            [
                $repository['name'],
                $repository['code'],
                $params
            ],$base_function_repository);
        }
        
        $base_repository = str_replace('// end function',$function_code."// end function",$base_repository);
             
        $base_repository = str_replace([
            '{{custom_folder}}',
            '{{custom_folder_namespace}}',
        ],[
            $custom_folder,
            str_replace('/','\\',$custom_folder),
        ],$base_repository);

        FileCreator::create( $repository_file_name, 'app/Http/Repositories'.$custom_folder, $base_repository );
    }
    
}