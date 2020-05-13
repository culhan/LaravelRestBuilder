<?php

namespace KhanCode\LaravelRestBuilder;

use Request;
use KhanCode\LaravelRestBuilder\Models\Projects;

class LanguageBuilder
{

    /**
     * [getDirContents description]
     *
     * @param   [type]  $dir       [$dir description]
     * @param   [type]  &$results  [&$results description]
     *
     * @return  [type]             [return description]
     */
    public function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

    /**
     * [index description]
     *
     * @return  [type]      [return description]
     */
    public function index()
    {
        $folder = base_path()."/".config('laravelrestbuilder.copy_to')."/resources/lang";
        
        $list_files = $this->getDirContents($folder);
        
        $arr_langs = [];
        foreach ($list_files as $file) {
            if (strpos($file, '.php') !== false) {
                // dd($this->readComment($file));
                $file_key = str_replace('.php','',$file);
                
                // untuk windows
                if (strpos($file_key, 'resources\lang\\') !== false) {
                    $file_key = explode("resources\lang\\",$file_key);
                    $file_key = explode("\\",$file_key[1]);
                    $lang = $file_key[0];
                    unset($file_key[0]);
                    $file_key = implode('/',$file_key);
                }
                
                // untuk unix
                if (strpos($file_key, 'resources/lang/') !== false) {
                    $file_key = explode("resources/lang/",$file_key);
                    $file_key = explode("/",$file_key[1]);
                    $lang = $file_key[0];
                    unset($file_key[0]);
                    $file_key = implode('/',$file_key); 
                }                

                $arr_langs = array_merge($this->buildLangArr(include $file,$lang,$file_key),$arr_langs);                
            }
        }

        return view('khancode::listLang', [
                'data'  =>  [
                    'tambah_lang' =>   1,
                    'lang'  => $arr_langs
                ],
                'projects'   =>  Projects::get(),
                'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
            ]);
    
    }

    /**
     * [buildLangArr description]
     *
     * @param   [type]  $file      [$file description]
     * @param   [type]  $lang      [$lang description]
     * @param   [type]  $file_key  [$file_key description]
     *
     * @return  [type]             [return description]
     */
    public function buildLangArr($file,$lang,$file_key)
    {
        $arr_lang = [];        
        foreach ($file as $key => $value) {
            if(is_array($value) ) {                
                $arr_lang = array_merge($arr_lang, $this->buildLangArr($value,$lang,$file_key.'.'.$key));

                // $arr_lang[] = [
                //     'lang' => $lang,
                //     'key' => $file_key.'.'.$key,
                //     'value' => json_encode($value),
                // ];
            }else {
                $arr_lang[] = [
                    'lang' => $lang,
                    'key' => $file_key.'.'.$key,
                    'value' => $value,
                ];   
            }            
        }

        return $arr_lang;        
    }

    /**
     * [var_export54 description]
     *
     * @param   [type]  $var     [$var description]
     * @param   [type]  $indent  [$indent description]
     *
     * @return  [type]           [return description]
     */
    function var_export54($var, $indent="") {
        switch (gettype($var)) {
            case "string":
                return "'" . addcslashes($var, "\\\$\'\r\n\t\v\f") . "'";
            case "array":
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                        . ($indexed ? "" : $this->var_export54($key) . " => ")
                        . $this->var_export54($value, "$indent    ");
                }
                return "[\n" . implode(",\n", $r) . "\n" . $indent . "]";
            case "boolean":
                return $var ? "TRUE" : "FALSE";
            default:
                return var_export($var, TRUE);
        }
    }

    /**
     * [readComment description]
     *
     * @param   [type]  $file  [$file description]
     *
     * @return  [type]         [return description]
     */
    public function readComment($file)
    {        
        $source = file_get_contents( $file );        
        
        $tokens = token_get_all( $source );
        
        $comment = array(
            T_COMMENT,      // All comments since PHP5            
            T_DOC_COMMENT   // PHPDoc comments      
        );

        $comment_arr = [];            
        foreach( $tokens as $token ) {
            if( in_array($token[0], $comment)  ){
                $comment_arr[$token[2]] = "\t".$token[1]."\n";
            }            
        }
        
        foreach (explode("\n",$source) as $s_key => $s_value) {
            if( $s_value && !trim($s_value) ) {
                $comment_arr[$s_key + 1] = $s_value."\n";
            }
        }

        ksort($comment_arr);

        return $comment_arr;
        
    }

    /**
     * [update description]
     *
     * @return  [type]  [return description]
     */
    public function update()
    {
        return view('khancode::createLang', [
                'data'  =>  Request::all()+[
                    'simpan_api'    => 1
                ],
                'projects'   =>  Projects::get(),
                'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
            ]);
    }

    /**
     * [save description]
     *
     * @return  [type]  [return description]
     */
    public function save()
    {
        $key = explode('.', Request::get('key'));
        $file = base_path()."/".config('laravelrestbuilder.copy_to')."/resources/lang/".Request::get('lang')."/".$key[0].".php";
        $comment = $this->readComment($file);
        // dd($comment);
        $isi_arr_file = include $file;
        
        unset($key[0]);
        
        $diff = 0;
        $diff_line = 0;
        // saat tambah key
        if( empty(array_get($isi_arr_file, implode('.',$key))) ){
            $isi_file_old = explode( "\n", "<?php\nreturn ".$this->var_export54( $isi_arr_file ).";" );
            array_set($isi_arr_file, implode('.',$key), Request::get('value'));
            $isi_file_new = explode( "\n", "<?php\nreturn ".$this->var_export54( $isi_arr_file ).";" );
            
            $diff = count($isi_file_old) - count($isi_file_new);
                        
            foreach($isi_file_new as $line_key =>  $line){
                if (!in_array($line, $isi_file_old)){
                    $diff_line = $line_key;
                    break;
                }
            }

        }else {
            array_set($isi_arr_file, implode('.',$key), Request::get('value'));
            $isi_file_new = explode( "\n", "<?php\nreturn ".$this->var_export54( $isi_arr_file ).";" );
        }        
                 
        foreach ($isi_file_new as $f_key => &$f_value) {
            $f_value .= "\n";
        }        

        // insert comment
        $add_on = 0;     
        $debug = [];    
        foreach ($comment as $c_key => $c_value) {
            
            if($diff_line > 0){
                $diff_line += substr_count($c_value,"\n");
            }

            if( $c_key-1 >= $diff_line && $diff_line > 0) {
                $add_on += $diff;
                $diff_line = 0;
            }
            $debug[$c_key] = $c_key-1-$add_on;
            array_splice( $isi_file_new, $c_key-1-$add_on, 0, $c_value );            
            $add_on += substr_count($c_value,"\n")-1;            
            
        }
                
        $isi_file_new = implode('',$isi_file_new);
        $isi_file_new = str_replace(" =>","\t=>",$isi_file_new);        
        
        file_put_contents($file, $isi_file_new);

        return Request::all();
    }

    /**
     * [dropLang description]
     *
     * @return  [type]  [return description]
     */
    public function dropLang()
    {
        $key = explode('.', Request::get('key'));
        $file = base_path()."/".config('laravelrestbuilder.copy_to')."/resources/lang/".Request::get('lang')."/".$key[0].".php";
        $comment = $this->readComment($file);
        
        $isi_arr_file = include $file;
        
        unset($key[0]);
        
        $diff = 0;
        $diff_line = 0;        
        
        $isi_file_old = explode( "\n", "<?php\nreturn ".$this->var_export54( $isi_arr_file ).";" );
        array_forget($isi_arr_file, implode('.',$key));
        $isi_file_new = explode( "\n", "<?php\nreturn ".$this->var_export54( $isi_arr_file ).";" );

        $diff = count($isi_file_old) - count($isi_file_new);
                    
        foreach($isi_file_new as $line_key =>  $line){
            if (!in_array($line, $isi_file_old)){
                $diff_line = $line_key;
                break;
            }
        }    
                 
        foreach ($isi_file_new as $f_key => &$f_value) {
            $f_value .= "\n";
        }        

        // insert comment
        $add_on = 0;         
        foreach ($comment as $c_key => $c_value) {
            
            if($diff_line > 0){
                $diff_line += substr_count($c_value,"\n");
            }

            if( $c_key-1 >= $diff_line && $diff_line > 0) {   
                $add_on += $diff;
                $diff_line = 0;
            }

            array_splice( $isi_file_new, $c_key-1-$add_on, 0, $c_value );            
            $add_on += substr_count($c_value,"\n")-1;
            
        }
        
        $isi_file_new = implode('',$isi_file_new);
        $isi_file_new = str_replace(" =>","\t=>",$isi_file_new);
        file_put_contents($file, $isi_file_new);

        return [
            'updated'   => [
                $file
            ]
        ];
    }

}
