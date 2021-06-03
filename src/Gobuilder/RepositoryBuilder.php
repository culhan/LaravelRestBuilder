<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

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
    static function build( $name, $table, $repositories )
    {
        $repository_file_name = 'R_'.ucwords($name);
        $name = UCWORDS($name);
        $base_repository = file_get_contents(__DIR__.'/../../base-go/repository/base.stub', FILE_USE_INCLUDE_PATH);

        $base_repository = str_replace([
            '{{name}}',   
            '{{Name}}',   
        ],[
            lcfirst($name),
            ucfirst($name),
        ],
        $base_repository);

        FileCreator::create( $repository_file_name, 'app/repositories', $base_repository );
        return;
        dd($base_repository);

        $base = config('laravelRestBuilder.base');                

        $repository_file_name = ucwords($name).'Repository';
        $name = UCWORDS($name);

        if( !empty($table) ){
            $base_repository = file_get_contents(__DIR__.'/../base'.$base.'/repository/base.stub', FILE_USE_INCLUDE_PATH);
        }else {
            $base_repository = file_get_contents(__DIR__.'/../base'.$base.'/repository/base_without_model.stub', FILE_USE_INCLUDE_PATH);
        }
        
        $base_function_repository = file_get_contents(__DIR__.'/../base'.$base.'/repository/function.stub', FILE_USE_INCLUDE_PATH);
        $base_repository = str_replace('{{Name}}',$name,$base_repository);
        $base_repository = str_replace('{{title_case_name}}',Helper::camelToTitle($name),$base_repository);

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
             
        FileCreator::create( $repository_file_name, 'app/Http/Repositories', $base_repository );
    }
    
}