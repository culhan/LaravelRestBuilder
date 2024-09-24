<?php

namespace KhanCode\LaravelRestBuilder\Gobuilder;

use KhanCode\LaravelRestBuilder\Models\ModulFiles;
use KhanCode\LaravelRestBuilder\Models\EmailFiles;
use KhanCode\LaravelRestBuilder\Models\EventFiles;

class FileCreator
{
    /**
     * static list file created
     */
    public static $file = [];

    /**
     * create file function
     *
     * @param [type] $name_file
     * @param [type] $folder
     * @param string $content
     * @return string
     */
    public static function create($name_file, $folder, $content = "some text here", $type = 'modul', $copy = true)
    {
        $file_folder = $folder;
        $content = str_replace([
            "{{code_name}}",
        ], [
            \Arr::get(session('project'), 'code_name')
        ], $content);

        $file_model = new ModulFiles();
        $file_key = 'modul_id';
        $data_file_key = config('laravelrestbuilder.modul')['id'];

        if ($type == 'email') {
            $file_model = new EmailFiles();
            $file_key = 'email_id';
            $data_file_key = config('laravelrestbuilder.email')['id'];
        }

        if ($type == 'event') {
            $file_model = new EventFiles();
            $file_key = 'event_id';
            $data_file_key = config('laravelrestbuilder.event')['id'];
        }

        $folder = config('laravelrestbuilder.copy_to') . "/" . $folder;
        if (file_exists(base_path() . "/" . $folder . "/" . $name_file . ".go")) {
            $old_file = self::getFile($name_file, $folder);
            $custom_code = [];
            if (strpos($old_file, '// start custom code') !== false) {
                $count_mathces = 0;
                preg_replace_callback('#' . preg_quote("// start custom code") . "#", function ($m) use (&$count_mathces) {
                    $count_mathces++;
                    return $m[0];
                }, $old_file);

                for ($i = 0; $i < $count_mathces; $i++) {
                    $this_custom_code = self::get_string_between($old_file, '// start custom code', '// end custom code');
                    $custom_code[] = $this_custom_code;
                    $rep = "\001" . preg_quote('// start custom code' . $this_custom_code . "\t" . '// end custom code') . "\001";
                    $old_file = preg_replace($rep, " ", $old_file, 1);
                }

                $index = 0;
                $content = preg_replace_callback("\001" . preg_quote("// start custom code") . "\001", function ($m) use ($custom_code, &$index, $type) {
                    if (!empty($custom_code[$index])) {
                        // hapus \r\n
                        if ($type != "routes") {
                            $custom_code[$index] = substr($custom_code[$index], 0, -1);
                        } else {
                            $custom_code[$index] = substr($custom_code[$index], 0, -1);
                        }
                        $custom_code[$index] = trim($custom_code[$index], " ");

                        // remove if only whitespace
                        if (ctype_space($custom_code[$index])) {
                            $custom_code[$index] = '';
                        }

                        $return = $m[0] . $custom_code[$index];
                        $index++;
                        return $return;
                    }
                    return "// start custom code";
                }, $content);

                // if(strpos($folder, 'app/Http/Repositories') !== false) {
                //     dd( $custom_code[0], substr($custom_code[0], 0, -4) );
                // }
            }

            if ($name_file != 'api') {
                $old_data   = $file_model->where('name', $file_folder . "/" . $name_file . ".go")
                    ->where($file_key, $data_file_key)
                    ->whereNull('deleted_by')
                    ->first();

                // jika kosong
                if (empty($old_data)) {
                    $file_model->create([
                        'name'  =>  $file_folder . "/" . $name_file . ".go",
                        $file_key    =>    $data_file_key,
                        'code'  =>  $content,
                    ]);

                    self::$file['created'][] = base_path() . "/" . $folder . "/" . $name_file . ".go";
                } else { // jika sudah ada

                    if ($old_data->code != $content) {
                        $file_model->updateOrCreate([
                            'name'  =>  $file_folder . "/" . $name_file . ".go",
                            $file_key    =>  $data_file_key,
                            'deleted_by'    => null
                        ], [
                            'code'  =>  $content
                        ]);

                        // jika old data code beda dengan file asli
                        if ($old_file != $old_data->code) {
                            self::$file['updated'][] = base_path() . "/" . $folder . "/" . $name_file . ".go (file di update di luar system)";
                        } else {
                            self::$file['updated'][] = base_path() . "/" . $folder . "/" . $name_file . ".go";
                        }
                    }
                }
            } else {
                self::$file['updated'][] = base_path() . "/" . $folder . "/" . $name_file . ".go";
            }
        } else {
            self::createPath(base_path() . "/" . $folder);
            if ($type == 'migration') {
                self::$file['migration'][] = base_path() . "/" . $folder . "/" . $name_file . ".go";
            // if( !empty(config('laravelrestbuilder.copy_to')) && $copy){
                //     self::$file['migration'][] = base_path()."/".config('laravelrestbuilder.copy_to')."/".$folder."/".$name_file.".go";
                // }
            } else {
                self::$file['created'][] = base_path() . "/" . $folder . "/" . $name_file . ".go";

                $file_model->create([
                    'name'  => $file_folder . "/" . $name_file . ".go",
                    $file_key    =>  $data_file_key,
                    'code'  => $content
                ]);
            }
        }

        config(['laravelrestbuilder.file'   =>  self::$file]);

        $fp = fopen(base_path() . "/" . $folder . "/" . $name_file . ".go", "wb");
        fwrite($fp, $content);
        fclose($fp);

        exec("/usr/local/gopath/go/bin/gopls format -w " . base_path() . "/" . $folder . "/" . $name_file . ".go", $output_format);

        // if( !empty(config('laravelrestbuilder.copy_to')) && $copy)
        // {
        //     $fp = fopen(base_path().config('laravelrestbuilder.copy_to')."/".$folder."/".$name_file.".go","wb");
        //     fwrite($fp,$content);
        //     fclose($fp);
        // }

        return self::$file;
    }

    public static function getCustomCode($name_file, $folder)
    {
        $folder = config('laravelrestbuilder.copy_to') . "/" . $folder;
        if (file_exists(base_path() . "/" . $folder . "/" . $name_file . ".go")) {
            $old_file = self::getFile($name_file, $folder);
            $custom_code = [];
            if (strpos($old_file, '// start custom code') !== false) {
                $count_mathces = 0;
                preg_replace_callback('#' . preg_quote("// start custom code") . "#", function ($m) use (&$count_mathces) {
                    $count_mathces++;
                    return $m[0];
                }, $old_file);

                for ($i = 0; $i < $count_mathces; $i++) {
                    $this_custom_code = self::get_string_between($old_file, '// start custom code', '// end custom code');
                    $custom_code[] = $this_custom_code;
                    $rep = "\001" . preg_quote('// start custom code' . $this_custom_code . "\t" . '// end custom code') . "\001";
                    $old_file = preg_replace($rep, " ", $old_file, 1);
                }

                return $custom_code;
            }
        }

        return [];
    }

    /**
     * get file
     *
     * @param [type] $name_file
     * @return string
     */
    public static function getFile($name_file, $folder)
    {
        return file_get_contents(base_path() . "/" . $folder . "/" . $name_file . ".go", FILE_USE_INCLUDE_PATH);
    }

    /**
     * recursively create a long directory path
     */
    public static function createPath($path)
    {
        if (is_dir($path)) {
            return true;
        } else {
            $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1);
            $return = self::createPath($prev_path);
            return ($return) ? mkdir($path, 0755, true) : false;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $string
     * @param [type] $start
     * @param [type] $end
     * @return string
     */
    public static function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
