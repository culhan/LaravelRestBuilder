<?php

namespace KhanCode\LaravelRestBuilder;

use Request;

class ComposerProjectBuilder
{

    /**
     * Undocumented function
     *
     * @return void
     */
    static function getVersionPackage()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $exec = Helper::execute("php composer.phar show -a \"".addslashes(Request::get('package'))."\" 2>&1",$folder);
        $get_version_package = str_replace(" ","",Helper::get_string_between($exec['out'], "\nversions :", "\n"));

        return [
            'version'  => explode(",",$get_version_package)
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function listPackage()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $list_package = "{".Helper::get_string_between(Helper::execute("php composer.phar show -i --format=json --tree 2>&1",$folder)['out'], "\n{", "\n");

        return [
            'list_package'  => json_decode($list_package)
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function composerUpdate()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        if( !file_exists($folder."/composerUpdateIsRunning") ){            
            shell_exec("cd ".$folder." && param=\"".$folder." ".config('laravelrestbuilder.project_id')." 'php composer.phar update'\" /home/composerUpdate.sh >/dev/null 2>&1 &");
            echo 'process running';
        }else {
            echo 'another process still running';
        }        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function composerUpdateResult()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        return [
            'status'    => (file_exists($folder."/composerUpdateIsRunning")) ? 'run':'done',
            'result'    => Helper::write(file_get_contents("/var/www/".config('laravelrestbuilder.project_id')."_process.txt"))
        ];        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function addPackage()
    {
        $input  = Request::all();
        $package = addslashes($input['package']);
        if( !empty($input['version']) ){
            $package .= ':'.addslashes($input['version']);
        }

        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        if( !file_exists($folder."/composerUpdateIsRunning") ){
            shell_exec("cd ".$folder." && param=\"".$folder." ".config('laravelrestbuilder.project_id')." 'php composer.phar require ".$package."'\" /home/composerUpdate.sh >/dev/null 2>&1 &");
            echo 'process running';
        }else {
            echo 'another process still running';
        }
    }
}
