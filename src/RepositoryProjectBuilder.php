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
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $check_changes = shell_exec('cd '.$folder.' && git log HEAD..origin/master --oneline 2>&1');        
        if( !empty($check_changes) ) {
            $returnPull .= self::write($check_changes).'<br>';
        	$exec = 'cd '.$folder.' 2>&1 && git pull origin master 2>&1';
        	$commit_hash = shell_exec($exec);
        	file_put_contents('/var/www/html/deploy.log', date('m/d/Y h:i:s a') . " Deployed branch: master Commit: " . $commit_hash . "\n", "0");
        	$returnPull .= 'PULL status <br> - repository pulled <br>';
        }else {
        	$returnPull .= 'PULL status <br> - repository updated <br>';
        }   
        
        return [
            'branch'    => shell_exec('cd '.$folder.' && git rev-parse --abbrev-ref HEAD 2>&1'),
            'pull' => $returnPull,
            'changes'   => self::status()
        ];
    }

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
    
    static function push()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        $file_add = Request::get('changes');
        $file_add = implode(" ",$file_add);  
        
        $push_exec = shell_exec('cd '.$folder.' && git config user.name "'.auth()->guard('laravelrestbuilder_auth')->user()->name.'" && git add '.$file_add.' && git commit -m "'.addslashes(Request::get('message')).'" && git push origin master 2>&1');
        return self::write($push_exec);
    }

    static function write($data,$append = '')
    {
        return $append.str_replace("\n","<br>".$append,$data);
    }

    static function composerUpdate()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        if( !file_exists($folder."/composerUpdateIsRunning") ){            
            shell_exec("cd ".$folder." && folder=".$folder." /home/composerUpdate.sh >/dev/null 2>&1 &");
            echo 'process running';
        }else {
            echo 'another process still running';
        }
    }

    static function composerUpdateResult()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to');
        return [
            'status'    => (file_exists($folder."/composerUpdateIsRunning")) ? 'run':'done',
            'result'    => self::write(file_get_contents($folder."/processBuilder.txt"))
        ];
    }
}
