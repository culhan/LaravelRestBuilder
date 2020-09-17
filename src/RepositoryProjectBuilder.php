<?php

namespace KhanCode\LaravelRestBuilder;

use Request;

class RepositoryProjectBuilder
{

    /**
     * Column builder function
     *
     * @param [type] $data
     * @param [type] $key_arr
     * @return void
     */
    static function sync()
    {
        $returnPull = '';
        $pull_hash = '';
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $check_changes = shell_exec('cd '.$folder.' && git fetch origin && git log HEAD..origin/master --oneline 2>&1');        
        if( !empty($check_changes) ) {
        	$exec = 'cd '.$folder.' 2>&1 && git pull origin master 2>&1';
        	$pull_hash = shell_exec($exec);
            $returnPull .= 'PULL status <br> - repository pulled <br> <br>';            
        }else {            
        	$returnPull .= 'PULL status <br> - repository updated <br>';
        }   
        
        // jika ada pending push karena belum pull
        $push_status = Helper::execute("git push origin master 2>&1",$folder);

        $git_status = Helper::execute("git status 2>&1",$folder);        

        return [
            'branch'    => shell_exec('cd '.$folder.' && git rev-parse --abbrev-ref HEAD 2>&1'),
            'pull' => $returnPull,
            'pull_hash' => Helper::write($pull_hash),
            'git_status'    => Helper::write($git_status['out']).Helper::write($git_status['err']),
            'check_changes' => Helper::write($check_changes),
            'changes'   => self::status(),
            're_push'   => Helper::write($push_status['out']).Helper::write($push_status['err'])
        ];
    }
    
    /**
     * git status function
     *
     * @return void
     */
    static function status()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $arr_return = [];
        $status = shell_exec('cd '.$folder.' && git status --porcelain');        
        if( !empty($status) ) {            
            foreach (explode("\n",$status) as $arr_return_value) {
                if( !empty($arr_return_value) ) {
                    $arr_return_value = explode(" ",$arr_return_value);
                    if( isset($arr_return_value[2]) ) {
                        $arr_return[] = [
                                'file' => $arr_return_value[2],
                                'status' => $arr_return_value[1],
                            ];
                    }else {
                        if( $arr_return_value[1] != 'processBuilder.txt') {
                            $arr_return[] = [
                                    'file' => $arr_return_value[1],
                                    'status' => $arr_return_value[0],
                                ];
                            }
                    }
                }
            }
        }        

        return $arr_return;        
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    static function push()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $file_add = Request::get('changes');

        $file_add_command = "";
        foreach($file_add as $value){
            if( !empty($file_add_command) ) $file_add_command .= ' ';
            $file_add_command .= "'$value'";
        }
        
        $push_exec = shell_exec('cd '.$folder.' && git config --global user.name "'.auth()->guard('laravelrestbuilder_auth')->user()->name.'" 2>&1 && git config --global user.email "'.auth()->guard('laravelrestbuilder_auth')->user()->email.'" 2>&1 &&  git add '.$file_add_command.' && git commit -m "'.addslashes(Request::get('message')).'" && git push origin master 2>&1');
        return Helper::write($push_exec);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function diffFile($id)
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $dataChanges = self::status();

        if( $dataChanges[$id] ) {
            return [
                'server'    => Helper::execute("git show master:".$dataChanges[$id]['file']." 2>&1", $folder),
                'work_dir'   => Helper::execute("cat ".$dataChanges[$id]['file']." 2>&1", $folder),
                'diff'  => Helper::get_string_between(Helper::execute("git diff ".$dataChanges[$id]['file']." 2>&1",$folder)['out'],"@@ -",",")
            ];
        }

        return [
            'server'    => '',
            'work_dir'  => ''
        ];
    }
}
