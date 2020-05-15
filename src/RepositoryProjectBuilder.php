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
        $check_changes = shell_exec('cd '.$folder.' && git fetch origin && git log HEAD..origin/master --oneline 2>&1');        
        if( !empty($check_changes) ) {
            $returnPull .= self::write($check_changes).'<br>';
        	$exec = 'cd '.$folder.' 2>&1 && git pull origin master 2>&1';
        	$commit_hash = shell_exec($exec);        	
            $returnPull .= 'PULL status <br> - repository pulled <br> <br>';
            if( !empty($commit_hash) ) {
                $returnPull .= 'Result <br>'.self::write($commit_hash);
            }
        }else {
            $git_status = self::execute("git status 2>&1",$folder);
        	$returnPull .= 'PULL status <br> - repository updated <br>'.self::write($git_status['out']).self::write($git_status['err']);
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

    /**
     * Executes a command and reurns an array with exit code, stdout and stderr content
     * @param string $cmd - Command to execute
     * @param string|null $workdir - Default working directory
     * @return string[] - Array with keys: 'code' - exit code, 'out' - stdout, 'err' - stderr
     */
    static function execute($cmd, $workdir = null) {

        if (is_null($workdir)) {
            $workdir = __DIR__;
        }

        $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin
        1 => array("pipe", "w"),  // stdout
        2 => array("pipe", "w"),  // stderr
        );

        $process = proc_open($cmd, $descriptorspec, $pipes, $workdir, null);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        return [
            'code' => proc_close($process),
            'out' => trim($stdout),
            'err' => trim($stderr),
        ];
    }
}
