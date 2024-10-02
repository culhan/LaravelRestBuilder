<?php

namespace KhanCode\LaravelRestBuilder;

use KhanCode\LaravelRestBuilder\Models\ModulFiles;
use KhanCode\LaravelRestBuilder\Models\EmailFiles;
use KhanCode\LaravelRestBuilder\Models\EventFiles;
use PhpCsFixer\RuleSet\Sets\PhpCsFixerSet;

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

        if($type == 'email') {
            $file_model = new EmailFiles;
            $file_key = 'email_id';
            $data_file_key = config('laravelrestbuilder.email')['id'];
        }elseif($type == 'event') {
            $file_model = new EventFiles;
            $file_key = 'event_id';
            $data_file_key = config('laravelrestbuilder.event')['id'];
        }elseif($type != 'migration'){
            $file_model = new ModulFiles;
            $file_key = 'modul_id';
            $data_file_key = config('laravelrestbuilder.modul')['id'];
        }

        $folder = config('laravelrestbuilder.copy_to')."/".$folder;        
        if ( file_exists(base_path()."/".$folder."/".$name_file.".php") )
        {        
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
                    $rep = "\001".preg_quote('// start custom code'.$this_custom_code."\t".'// end custom code')."\001";
                    $old_file = preg_replace($rep, " ", $old_file, 1);
                }

                $index = 0;                
                $content = preg_replace_callback("\001".preg_quote("// start custom code")."\001",function ($m) use ($custom_code,&$index,$type) {                    
                    if(!empty($custom_code[$index]))
                    {        
                        // hapus \r\n
                        if( $type != "routes" ) {
                            $custom_code[$index] = substr($custom_code[$index], 0, -6);
                        }else {
                            $custom_code[$index] = substr($custom_code[$index], 0, -1);
                        }
                        $custom_code[$index] = trim($custom_code[$index]," ");

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

            if($name_file != 'api') {
                $old_data   = $file_model->where('name', $file_folder."/".$name_file.".php")
                    ->where($file_key, $data_file_key)
                    ->whereNull('deleted_by')
                    ->first();

                // jika kosong
                if( empty($old_data) ){
                    $file_model->create([
                        'name'  =>  $file_folder."/".$name_file.".php",
                        $file_key    =>    $data_file_key,
                        'code'  =>  $content,
                    ]);

                    self::$file['created'][] = base_path()."/".$folder."/".$name_file.".php";
                }else { // jika sudah ada                    

                    if( $old_data->code != $content ) {
                        $file_model->updateOrCreate([
                            'name'  =>  $file_folder."/".$name_file.".php",
                            $file_key    =>  $data_file_key,
                            'deleted_by'    => null
                        ],[
                            'code'  =>  $content
                        ]);
                        
                        // jika old data code beda dengan file asli
                        if( $old_file != $old_data->code ){
                            self::$file['updated'][] = base_path()."/".$folder."/".$name_file.".php (file di update di luar system)";
                        }else {
                            self::$file['updated'][] = base_path()."/".$folder."/".$name_file.".php";
                        }
                    }

                }
            }else {
                self::$file['updated'][] = base_path()."/".$folder."/".$name_file.".php";
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

                $file_model->create([
                    'name'  => $file_folder."/".$name_file.".php",
                    $file_key    =>  $data_file_key,
                    'code'  => $content
                ]);
            }
        }

        config(['laravelrestbuilder.file'   =>  self::$file]);

        $fp = fopen(base_path()."/".$folder."/".$name_file.".php","wb");
        fwrite($fp,$content);
        fclose($fp);

        $rules = [
            'array_syntax' => ['syntax' => 'short'],
            'array_indentation' => true,
            'no_unused_imports' => true,
            'blank_line_after_namespace' => true,
            'blank_line_after_opening_tag' => true,
            'braces' => true,
            'cast_spaces' => true,
            'concat_space' => [
                'spacing' => 'none',
            ],
            'declare_equal_normalize' => true,
            'elseif' => true,
            'encoding' => true,
            'full_opening_tag' => true,
            'fully_qualified_strict_types' => true, // added by Shift
            'function_declaration' => true,
            'function_typehint_space' => true,
            'heredoc_to_nowdoc' => true,
            'include' => true,
            'increment_style' => ['style' => 'post'],
            'indentation_type' => true,
            'linebreak_after_opening_tag' => true,
            'line_ending' => true,
            'lowercase_cast' => true,
            'lowercase_keywords' => true,
            'lowercase_static_reference' => true, // added from Symfony
            'magic_method_casing' => true, // added from Symfony
            'magic_constant_casing' => true,
            'method_argument_space' => true,
            'native_function_casing' => true,
            // 'no_alias_functions' => true,
            'no_extra_blank_lines' => [
                'tokens' => [
                    'extra',
                    'throw',
                    'use',
                    'use_trait',
                ],
            ],
            'no_blank_lines_after_class_opening' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_closing_tag' => true,
            'no_empty_phpdoc' => true,
            'no_empty_statement' => true,
            'no_leading_import_slash' => true,
            'no_leading_namespace_whitespace' => true,
            'no_mixed_echo_print' => [
                'use' => 'echo',
            ],
            'no_multiline_whitespace_around_double_arrow' => true,
            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'no_multi_line',
            ],
            'no_short_bool_cast' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_after_function_name' => true,
            'no_spaces_inside_parenthesis' => true,
            'no_trailing_comma_in_list_call' => true,
            'no_trailing_comma_in_singleline_array' => true,
            'no_trailing_whitespace' => true,
            'no_trailing_whitespace_in_comment' => true,
            // 'no_unreachable_default_argument_value' => true,
            'no_useless_return' => true,
            'no_whitespace_before_comma_in_array' => true,
            'no_whitespace_in_blank_line' => true,
            'normalize_index_brace' => true,
            'not_operator_with_successor_space' => true,
            'object_operator_without_whitespace' => true,
            'phpdoc_indent' => true,
            'phpdoc_no_access' => true,
            'phpdoc_no_package' => true,
            'phpdoc_no_useless_inheritdoc' => true,
            'phpdoc_scalar' => true,
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_summary' => true,
            'phpdoc_to_comment' => true,
            'phpdoc_trim' => true,
            'phpdoc_types' => true,
            'phpdoc_var_without_name' => true,
            // 'self_accessor' => true,
            'short_scalar_cast' => true,
            'simplified_null_return' => false, // disabled by Shift
            'single_blank_line_at_eof' => true,
            'single_blank_line_before_namespace' => true,
            'single_import_per_statement' => true,
            'single_line_after_imports' => true,
            'single_line_comment_style' => [
                'comment_types' => ['hash'],
            ],
            'single_quote' => true,
            'space_after_semicolon' => true,
            'standardize_not_equals' => true,
            'switch_case_semicolon_to_colon' => true,
            'switch_case_space' => true,
            'ternary_operator_spaces' => true,
            'trim_array_spaces' => true,
            'unary_operator_spaces' => true,
            'whitespace_after_comma_in_array' => true,
        
            // php-cs-fixer 3: Renamed rules
            'constant_case' => ['case' => 'lower'],
            'general_phpdoc_tag_rename' => true,
            'phpdoc_inline_tag_normalizer' => true,
            'phpdoc_tag_type' => true,
            // 'psr_autoloading' => true,
            'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        
            // php-cs-fixer 3: Changed options
            'binary_operator_spaces' => [
                'default' => 'single_space',
                'operators' => ['=>' => null],
            ],
            'blank_line_before_statement' => [
                'statements' => ['return'],
            ],
            'class_attributes_separation' => [
                'elements' => [
                    'const' => 'one',
                    'method' => 'one',
                    'property' => 'one',
                ],
            ],
            'class_definition' => [
                'multi_line_extends_each_single_line' => true,
                'single_item_single_line' => true,
                'single_line' => true,
            ],
            'ordered_imports' => [
                'sort_algorithm' => 'alpha',
            ],
        
            // php-cs-fixer 3: Removed rootless options (*)
            'no_unneeded_control_parentheses' => [
                'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
            ],
            'no_spaces_around_offset' => [
                'positions' => ['inside', 'outside'],
            ],
            'visibility_required' => [
                'elements' => ['property', 'method', 'const'],
            ],
        
        ];       

        // exec("/var/www/html/rest_builder/vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix " . base_path()."/".$folder."/".$name_file.".php --rules='".json_encode($rules)."'", $output_format);        
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
        if (is_dir($path)) {
            return true;
        }else {
            $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
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