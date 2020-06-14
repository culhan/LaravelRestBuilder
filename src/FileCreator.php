<?php

namespace KhanCode\LaravelRestBuilder;

class FileCreator   
{

    /**
     * static list file created
     */
    static $file = [];

    /**
     * create file function
     *
     * @param [type] $name_file
     * @param [type] $folder
     * @param string $content
     * @return void
     */
    static function create( $name_file, $folder, $content = "some text here", $type = 'modul', $copy = true )
    {
        $file_folder = $folder;
        $folder = config('laravelrestbuilder.copy_to')."/".$folder;        
        if ( file_exists(base_path()."/".$folder."/".$name_file.".php") )
        {           
            if($name_file != 'api') {
                $modul_files_status = \KhanCode\LaravelRestBuilder\Models\ModulFiles::updateOrCreate([
                    'name'  =>  $file_folder."/".$name_file.".php",
                    'modul_id'    =>  config('laravelrestbuilder.modul')['id']                    
                ],[
                    'code'  =>  $content
                ]);
                
                if( $modul_files_status->wasRecentlyCreated ) {
                    self::$file['created'][] = base_path()."/".$folder."/".$name_file.".php";
                }
                if( $modul_files_status->wasRecentlyUpdated ) {
                    self::$file['updated'][] = base_path()."/".$folder."/".$name_file.".php";
                }
            }else {
                self::$file['updated'][] = base_path()."/".$folder."/".$name_file.".php";
            }            
            
            $old_file = self::getFile($name_file, $folder);
            $custom_code = [];
            if(strpos($old_file, '// start custom code') !== false)
            {
                $count_mathces = 0;
                preg_replace_callback('#'.preg_quote("// start custom code")."#",function ($m) use (&$count_mathces) {
                    $count_mathces++;
                    return $m[0];
                }, $old_file);
                
                for ($i=0; $i < $count_mathces ; $i++) { 
                    $this_custom_code = self::get_string_between($old_file,'// start custom code', '// end custom code');
                    $custom_code[] = $this_custom_code;
                    $old_file = preg_replace('#'.preg_quote('// start custom code'.$this_custom_code.'// end custom code')."#", " ", $old_file, 1);
                }

                $index = 0;                
                $content = preg_replace_callback('#'.preg_quote("// start custom code")."#",function ($m) use ($custom_code,&$index,$type) {                    
                    if(!empty($custom_code[$index]))
                    {                        
                        // hapus \r\n
                        if( $type != "routes" ) {
                            $custom_code[$index] = substr($custom_code[$index], 0, -6);
                        }else {
                            $custom_code[$index] = substr($custom_code[$index], 0, -1);
                        }

                        // remove if only whitespace
                        if (ctype_space($custom_code[$index])) {
                            $custom_code[$index] = '';
                        }

                        $return = $m[0].$custom_code[$index];                        
                        $index++;
                        return $return;                                                
                    }
                    return "// start custom code";
                }, $content);

                // if(strpos($folder, 'app/Http/Repositories') !== false) {
                //     dd( $custom_code[0], substr($custom_code[0], 0, -4) );
                // }
            }
        }else {
            self::createPath(base_path()."/".$folder);
            if($type == 'migration') {
                self::$file['migration'][] = base_path()."/".$folder."/".$name_file.".php";
                // if( !empty(config('laravelrestbuilder.copy_to')) && $copy){
                //     self::$file['migration'][] = base_path()."/".config('laravelrestbuilder.copy_to')."/".$folder."/".$name_file.".php";
                // }
            }else {
                self::$file['created'][] = base_path()."/".$folder."/".$name_file.".php";
                \KhanCode\LaravelRestBuilder\Models\ModulFiles::create([
                    'name'  => $file_folder."/".$name_file.".php",
                    'modul_id'    =>  config('laravelrestbuilder.modul')['id'],
                    'code'  => $content
                ]);
            }
        }

        config(['laravelrestbuilder.file'   =>  self::$file]);

        $fp = fopen(base_path()."/".$folder."/".$name_file.".php","wb");
        fwrite($fp,$content);
        fclose($fp);

        // if( !empty(config('laravelrestbuilder.copy_to')) && $copy)
        // {
        //     $fp = fopen(base_path().config('laravelrestbuilder.copy_to')."/".$folder."/".$name_file.".php","wb");
        //     fwrite($fp,$content);
        //     fclose($fp);
        // }

        return self::$file;
    }

    /**
     * get file
     *
     * @param [type] $name_file
     * @return void
     */
    static function getFile( $name_file, $folder )
    {
        return file_get_contents(base_path()."/".$folder."/".$name_file.".php", FILE_USE_INCLUDE_PATH);
    }

    /** 
     * recursively create a long directory path
     */
    static function createPath($path) 
    {
        if (is_dir($path)) return true;
        $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
        $return = self::createPath($prev_path);
        return ($return && is_writable($prev_path)) ? mkdir($path, 0755, true) : false;
    }

    /**
     * Undocumented function
     *
     * @param [type] $string
     * @param [type] $start
     * @param [type] $end
     * @return void
     */
    static function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}