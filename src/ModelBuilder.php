<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class ModelBuilder
{

    /**
     * Undocumented function
     *
     * @param [type] $name_model
     * @param [type] $table
     * @param [type] $key
     * @param [type] $increment_key
     * @param [type] $column
     * @param array $column_function
     * @param [type] $with_timestamp
     * @param [type] $with_authstamp
     * @param [type] $with_ipstamp
     * @param [type] $with_companystamp
     * @param [type] $with_delete_restriction
     * @param [type] $custom_filter
     * @param [type] $custom_union
     * @param [type] $custom_join
     * @param [type] $relation
     * @param [type] $hidden
     * @param [type] $with_company_restriction
     * @param [type] $casts
     * @param [type] $with_authenticable
     * @param [type] $get_company_code
     * @param [type] $custom_creating
     * @param [type] $custom_updating
     * @param [type] $hidden_relation
     * @return void
     */
    static function build( $name_model, $table, $key, $increment_key, $column, $column_function = [], $with_timestamp, $with_authstamp, $with_ipstamp, $with_companystamp, $custom_filter, $custom_group, $custom_union, $custom_union_model, $custom_join, $relation, $hidden, $with_company_restriction, $with_delete_restriction, $casts, $with_authenticable, $get_company_code = NULL, $custom_creating, $custom_updating, $custom_deleting, $hidden_relation, $with_timestamp_details, $with_authstamp_details, $with_ipstamp_details, $custom_folder = '' )
    {
        $base = config('laravelRestBuilder.base');
        $mysql_version = config('laravelRestBuilder.mysql_version');

        if( $mysql_version > 5.6 ){
            $mysql_version = '';
        }else {
            $mysql_version = '_'.$mysql_version;
        }
        
        $model_file_name = UCWORDS($name_model);
        $name = UCWORDS($name_model);
        if( $with_authenticable == 1) {
            $base_model = file_get_contents(__DIR__.'/../base'.$base.'/model/base_authenticable.stub', FILE_USE_INCLUDE_PATH);    
        }else {
            $base_model = file_get_contents(__DIR__.'/../base'.$base.'/model/base.stub', FILE_USE_INCLUDE_PATH);
        }
        
        $base_model = str_replace([
            '{{Name}}',
            '{{custom_folder}}',
            '{{custom_folder_namespace}}',
        ],[
            $name,
            $custom_folder,
            str_replace('/','\\',$custom_folder),
        ],$base_model);

        $function_accessor = file_get_contents(__DIR__.'/../base'.$base.'/model/function_accessor.stub', FILE_USE_INCLUDE_PATH);
        
        if( !empty($casts) ) {
            $column_casts = '';
            foreach ($casts as $casts_value) {
                if( !empty($column_casts) ) $column_casts   .= ",\n\t\t";
                $column_casts   .= "'".$casts_value['column']."'\t=> '".$casts_value['data_type']."'";
            }
            $option_casts = file_get_contents(__DIR__.'/../base'.$base.'/model/option_casts.stub', FILE_USE_INCLUDE_PATH);
            $option_casts = str_replace("{{column_casts}}",$column_casts,$option_casts);
            $base_model = str_replace('// end list option',$option_casts,$base_model);
        }

        if( !empty($custom_join) ) {
            $option_custom_join = file_get_contents(__DIR__.'/../base'.$base.'/model/option_query_custom_join.stub', FILE_USE_INCLUDE_PATH);
            $custom_join = str_replace("\n","\n\t\t\t\t",$custom_join);
            $option_custom_join = str_replace('{{custom_join}}',$custom_join,$option_custom_join);
            $base_model = str_replace('// end raw join query',$option_custom_join,$base_model);
        }

        if( $with_timestamp == 1 ) {

            if( empty($with_delete_restriction) ) {
                $option_timestamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_query_timestamp.stub', FILE_USE_INCLUDE_PATH);
                $base_model = str_replace('// end list query option',$option_timestamp,$base_model);
            }

            $option_timestamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_timestamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list option',$option_timestamp,$base_model);
        }

        if( $with_authstamp == 1 ) {

            if( empty($with_delete_restriction) ) {
                $option_authstamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_query_authstamp.stub', FILE_USE_INCLUDE_PATH);
                $base_model = str_replace('// end list query option',$option_authstamp,$base_model);
            }

            $option_authstamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_updating_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list updating option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_creating_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list option',$option_authstamp,$base_model);
        }
        
        if( $with_companystamp == 1 ) {

            if( !empty($with_company_restriction) ) {
                $option_companystamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_query_companystamp.stub', FILE_USE_INCLUDE_PATH);
                $base_model = str_replace('// end list query option',$option_companystamp,$base_model);
            }
            
            $option_companystamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_creating_companystamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_companystamp,$base_model);
        }
        
        if( $with_ipstamp == 1 ) {
            $option_ipstamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_creating_ipstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_ipstamp,$base_model);
            $option_ipstamp = file_get_contents(__DIR__.'/../base'.$base.'/model/option_updating_ipstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list updating option',$option_ipstamp,$base_model);
        }

        if( !empty($key) ) {
            $option_key = file_get_contents(__DIR__.'/../base'.$base.'/model/option_key.stub', FILE_USE_INCLUDE_PATH);
            $option_key = str_replace('{{key}}',$key,$option_key);
            $base_model = str_replace('// end list option',$option_key,$base_model);
        }

        if( empty($increment_key) ) {            
            $option_key = file_get_contents(__DIR__.'/../base'.$base.'/model/option_increment_key.stub', FILE_USE_INCLUDE_PATH);
            $option_key = str_replace('{{key}}',$key,$option_key);
            $base_model = str_replace('// end list option',$option_key,$base_model);
        }

        if( !empty($custom_filter) ) {
            $option_custom_filter = file_get_contents(__DIR__.'/../base'.$base.'/model/option_query_custom_filter.stub', FILE_USE_INCLUDE_PATH);
            $custom_filter = str_replace("\n","\n\t\t\t\t",$custom_filter);
            $option_custom_filter = str_replace('{{custom_filter}}',$custom_filter,$option_custom_filter);
            $base_model = str_replace('// end list query option',$option_custom_filter,$base_model);
        }

        if( !empty($custom_group) ) {
            $option_custom_group = file_get_contents(__DIR__.'/../base'.$base.'/model/option_query_custom_group.stub', FILE_USE_INCLUDE_PATH);
            $custom_group = str_replace("\n","\n\t\t\t\t",$custom_group);
            $option_custom_group = str_replace('{{custom_group}}',$custom_group,$option_custom_group);
            $base_model = str_replace('// end list query group',$option_custom_group,$base_model);
        }

        if( !empty($custom_creating) ) {
            $custom_creating = str_replace("\n","\n\t\t\t",$custom_creating."\n\n// end list creating option");
            $base_model = str_replace('// end list creating option',$custom_creating,$base_model);
        }

        if ( !empty($custom_updating) ) {
            $custom_updating = str_replace("\n","\n\t\t\t",$custom_updating."\n\n// end list updating option");
            $base_model = str_replace('// end list updating option',$custom_updating,$base_model);
        }

        if ( !empty($custom_deleting) ) {
            $custom_deleting = str_replace("\n","\n\t\t\t",$custom_deleting."\n\n// end list deleting option");
            $base_model = str_replace('// end list deleting option',$custom_deleting,$base_model);
        }

        $cols_table_model = "";        
        $fillable_table_model = "";
        $appends_table_model = "";
        $hidden = array_flip($hidden);
        $base_column_function_query = file_get_contents(__DIR__.'/../base'.$base.'/model/query_column_function.stub', FILE_USE_INCLUDE_PATH);
        $base_column_function_query = str_replace('\t',"\t",$base_column_function_query);
        $option_isJson = file_get_contents(__DIR__.'/../base'.$base.'/model/option_isJson.stub', FILE_USE_INCLUDE_PATH);
        $base_set_bindings = "{{column}}";
        $column_set_bindings = "";
        $list_name_cols = [];

        foreach ($column as $key => $value) {     
            $list_name_cols[$value['name']] = $value['name'];       
            // jika bukan forbidden column dan hidden masukkan ke query global
            if( !isset(LaravelRestBuilder::$forbidden_column_name[$value['name']]) && !isset($hidden[$value['name']]) )
            {
                $column_query = str_replace([
                    '{{column_function_name}}',
                    '{{function_query}}'
                ],[
                    $value['name'],
                    '{{table}}.'.$value['name']
                ],$base_column_function_query);

                $cols_table_model .= (!empty($cols_table_model) ? "\t\t":'').$column_query;
                // $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'')."\"".'{{table}}.'.$value['name']."\",\r\n";
                $column_set_bindings .= 'Arr::get($data, "show_'.$value['name'].'", 1),'."\r\n\t\t\t\t\t";
            }

            $fillable_table_model .= "\t\t\"".$value['name']."\",";
            if( !empty($column[$key+1]) ) {
                $fillable_table_model .= "\r\n";
            }            
        }
        
        foreach ($column_function as $key_column_function => $value_column_function) {
            $list_name_cols[$value_column_function['name']] = $value_column_function['name'];
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value_column_function['name']]) && isset($value_column_function['function']) ){      
                $column_function_query = str_replace([
                    '{{column_function_name}}',
                    '{{function_query}}'
                ],[
                    $value_column_function['name'],
                    str_replace("\n","\n\t\t\t\t\t",$value_column_function['function'])
                ],$base_column_function_query);

                $cols_table_model .= (!empty($cols_table_model) ? "\t\t":'').$column_function_query;          
                // $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'')."\DB::raw(\"".str_replace("\n","\n\t\t\t\t\t",$value_column_function['function'])." as ".$value_column_function['name']."\"),\r\n";
                $column_set_bindings .= 'Arr::get($data, "show_'.$value_column_function['name'].'", 1),'."\r\n\t\t\t\t\t";
            }

            if( empty(LaravelRestBuilder::$forbidden_column_name[$value_column_function['name']]) ) {                                                
                
                // if( !empty($value_column_function['json']) ) {
                //     $value_column_function['response_code'] = !empty($value_column_function['response_code']) ? $value_column_function['response_code'] : $value_column_function['name'];
                //     $json_converter = str_replace("{{json}}",$value_column_function['response_code'],$option_isJson);
                // }else {
                //     $value_column_function['response_code'] = !empty($value_column_function['response_code']) ? $value_column_function['response_code'] : '$this->attributes[\''.$value_column_function['name'].'\']';
                // }

                $value_column_function['response_code'] = !empty($value_column_function['response_code']) ? $value_column_function['response_code'] : '($this->attributes[\''.$value_column_function['name'].'\']??NULL)';
                $json_converter = str_replace("{{json}}",$value_column_function['response_code'],$option_isJson);

                $value_column_function['response_code'] = !empty($value_column_function['json']) ? $json_converter : $value_column_function['response_code']; 

                // check response code
                $last_str = substr(preg_replace('/\s+/', '', $value_column_function['response_code']), -1);

                if( $last_str != ";" && !strpos($value_column_function['response_code'], "\n")){
                    $value_column_function['response_code'] = "return ".$value_column_function['response_code'].";";
                }

                // column accessor
                $current_function_accessor = $function_accessor;
                $current_function_accessor = str_replace([
                        '{{camel_case_name}}',
                        '{{value}}'
                    ],[
                        ucwords(camel_case($value_column_function['name'])),
                        str_replace("\n","\n\t\t",$value_column_function['response_code'])
                    ],$current_function_accessor);
                
                $base_model = str_replace('// end list accessor function',$current_function_accessor,$base_model);
            }

            if( !empty($appends_table_model) ){
                $appends_table_model .= "\r\n";
            }
            $appends_table_model .= "\t\t\"".$value_column_function['name']."\",";
        }
        
        // fillable
        $option_fillable = file_get_contents(__DIR__.'/../base'.$base.'/model/option_fillable.stub', FILE_USE_INCLUDE_PATH);
        $option_fillable = str_replace('{{column_fillable}}',$fillable_table_model,$option_fillable);
        $base_model = str_replace('// end list option',$option_fillable,$base_model);
        
        if( !empty($relation) )
        {
            if( !empty($hidden_relation) ) {
                $hidden_relation = array_flip($hidden_relation);
            }

            foreach ($relation as $key_relation => $value_relation) {                     

                $value_relation['name'] = empty($value_relation['name_param']) ? $value_relation['name'] : $value_relation['name_param'];
                $column_set_bindings .= 'Arr::get($data, "show_'.$value_relation['name'].'", 1),'."\r\n\t\t\t\t\t";
                $value_relation['custom_order'] = str_replace("\n","\n\t\t\t\t\t\t\t\t",$value_relation['custom_order']);
                $value_relation['custom_join'] = str_replace("\n","\n\t\t\t\t\t\t\t\t",$value_relation['custom_join']);
                $value_relation['custom_option'] = str_replace("\n","\n\t\t\t\t\t\t\t\t",$value_relation['custom_option']);
                                
                // yang hidden tanpa accessor
                if( !isset($hidden_relation[$value_relation['name']]) ) {
                    $json_converter = str_replace([
                        "{{json}}"
                    ],[
                        '($this->attributes[\''.$value_relation['name'].'\']??NULL)'
                    ],$option_isJson);
                    
                    // check response code
                    $last_str = substr(preg_replace('/\s+/', '', $json_converter), -1);

                    if( $last_str != ";" ){
                        $json_converter = "return ".$json_converter.";";
                    }

                    $current_function_accessor = $function_accessor;
                    $current_function_accessor = str_replace([
                            '{{camel_case_name}}',
                            '{{value}}'
                        ],[
                            ucwords(camel_case((empty($value_relation['name_param']) ? $value_relation['name'] : $value_relation['name_param']))),
                            $json_converter
                        ],$current_function_accessor);
                    
                    $base_model = str_replace('// end list accessor function',$current_function_accessor,$base_model);                

                    if( !empty($appends_table_model) ){
                        $appends_table_model .= "\r\n";
                    }
                    $appends_table_model .= "\t\t\"".$value_relation['name']."\",";
                }

                // belongs to query
                if($value_relation['type']=='belongs_to')
                {                    
                        
                    //function belongs to
                    $function = file_get_contents(__DIR__.'/../base'.$base.'/model/function_belongs_to.stub', FILE_USE_INCLUDE_PATH);                    
                    if( empty($value_relation['model_name']) )
                    {
                        $function = str_replace('{{belongs_to_name_model}}',ucwords(camel_case($value_relation['name'])),$function);
                    }
                    else 
                    {
                        $function = str_replace('{{belongs_to_name_model}}',ucwords(camel_case($value_relation['model_name'])),$function);
                    }
                    $function = str_replace('{{belongs_to_name}}',ucwords($value_relation['name']),$function);
                    $function = str_replace('{{column_belongs_to_foreign_key}}',$value_relation['foreign_key'],$function);                    
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    // column belongs to
                    $belongs_to_query = file_get_contents(__DIR__.'/../base'.$base.'/model/query_column_belongs_to.stub', FILE_USE_INCLUDE_PATH);
                    $column_belongs_to = self::generateColumnRelation($value_relation['select_column']);                    
                    
                    $value_relation['relation_key'] = (!empty($value_relation['relation_key']) ? $value_relation['relation_key']:'id' );
                    // auto add alias table jika tidak ada "."
                    $arr_transform = [
                        'relation_key' => '{{table_belongs_to}}.value',
                        'foreign_key'    => '{{table}}.value',
                    ];
                    foreach ($value_relation as $value_relation_key => $value_relation_value) {
                        if( isset($arr_transform[$value_relation_key]) ) {
                            if (strpos($value_relation_value, '.') === false) {
                                $value_relation[$value_relation_key] = str_replace('value', $value_relation_value, $arr_transform[$value_relation_key]);
                            }
                        }
                    }

                    $belongs_to_query = str_replace('{{column_belongs_to_relation_key}}',$value_relation['relation_key'],$belongs_to_query);
                    $belongs_to_query = str_replace('{{column_belongs_to_foreign_key}}',$value_relation['foreign_key'],$belongs_to_query);

                    $belongs_to_query = str_replace('{{column_belongs_to}}',$column_belongs_to,$belongs_to_query);
                    $belongs_to_query = str_replace('{{table_belongs_to}}',$value_relation['table'],$belongs_to_query);                    
                    $belongs_to_query = str_replace('{{belongs_to_name}}',$value_relation['name'],$belongs_to_query);                                                

                    if( !empty($value_relation['custom_join']) )
                    {
                        $belongs_to_query = str_replace('-- end list belongs to join option',$value_relation['custom_join']."\r\n\t\t\t\t\t".'-- end list belongs to join option',$belongs_to_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $belongs_to_query = str_replace('-- end list belongs to query option',$value_relation['custom_option']."\r\n\t\t\t\t\t".'-- end list belongs to query option',$belongs_to_query);
                    }
                    
                    $cols_table_model .= $belongs_to_query."\r\n";
                    
                }

                // has one query
                if($value_relation['type']=='has_one')
                {                    
                        
                    //function has one
                    $function = file_get_contents(__DIR__.'/../base'.$base.'/model/function_has_one.stub', FILE_USE_INCLUDE_PATH);
                    if( empty($value_relation['model_name']) )
                    {
                        $function = str_replace('{{has_one_name_model}}',ucwords(camel_case($value_relation['name'])),$function);
                    }
                    else 
                    {
                        $function = str_replace('{{has_one_name_model}}',ucwords(camel_case($value_relation['model_name'])),$function);
                    }
                    $function = str_replace('{{has_one_name}}',ucwords($value_relation['name']),$function);
                    $function = str_replace('{{column_has_one_foreign_key}}',$value_relation['foreign_key'],$function);                    
                    $function = str_replace('{{column_has_many_relation_key}}',$value_relation['relation_key']??'id',$function);                    
                    
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    // column has one
                    $has_one_query = file_get_contents(__DIR__.'/../base'.$base.'/model/query_column_has_one.stub', FILE_USE_INCLUDE_PATH);
                    $column_has_one = self::generateColumnRelation($value_relation['select_column']);
                    
                    $value_relation['relation_key'] = (!empty($value_relation['relation_key']) ? $value_relation['relation_key']:'id' );
                    // auto add alias table jika tidak ada "."
                    $arr_transform = [
                        'relation_key' => '{{table}}.value',
                        'foreign_key'    => '{{table_has_one}}.value',
                    ];
                    foreach ($value_relation as $value_relation_key => $value_relation_value) {
                        if( isset($arr_transform[$value_relation_key]) ) {
                            if (strpos($value_relation_value, '.') === false) {
                                $value_relation[$value_relation_key] = str_replace('value', $value_relation_value, $arr_transform[$value_relation_key]);
                            }
                        }
                    }

                    $has_one_query = str_replace('{{column_has_one_relation_key}}',$value_relation['relation_key'],$has_one_query);                    
                    $has_one_query = str_replace('{{column_has_one_foreign_key}}',$value_relation['foreign_key'],$has_one_query);                    

                    $has_one_query = str_replace('{{column_has_one}}',"".$column_has_one,$has_one_query);
                    $has_one_query = str_replace('{{table_has_one}}',$value_relation['table'],$has_one_query);                    
                    $has_one_query = str_replace('{{has_one_name}}',$value_relation['name'],$has_one_query);

                    if( !empty($value_relation['custom_join']) )
                    {
                        $has_one_query = str_replace('-- end list has one join option',$value_relation['custom_join']."\r\n\t\t\t\t\t".'-- end list has one join option',$has_one_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $has_one_query = str_replace('-- end list has one query option',$value_relation['custom_option']."\r\n\t\t\t".'-- end list has one query option',$has_one_query);
                    }
                    
                    $cols_table_model .= $has_one_query."\r\n";
                    
                }

                // has many query
                if($value_relation['type']=='has_many')
                {                    

                    // function has many                    
                    $function = file_get_contents(__DIR__.'/../base'.$base.'/model/function_has_many.stub', FILE_USE_INCLUDE_PATH);
                    if( empty($value_relation['model_name']) )
                    {
                        $function = str_replace('{{has_many_name_model}}',ucwords(camel_case($value_relation['name'])),$function);
                    }
                    else 
                    {
                        $function = str_replace('{{has_many_name_model}}',ucwords(camel_case($value_relation['model_name'])),$function);
                    }
                    $function = str_replace('{{has_many_name}}',ucwords($value_relation['name']),$function);
                    $function = str_replace('{{column_has_many_foreign_key}}',$value_relation['foreign_key'],$function);                    
                    $function = str_replace('{{column_has_many_relation_key}}',$value_relation['relation_key']??'id',$function);                    
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    // column has many
                    $has_many_query = file_get_contents(__DIR__.'/../base'.$base.'/model/query_column_has_many'.$mysql_version.'.stub', FILE_USE_INCLUDE_PATH);
                    $column_has_many = self::generateColumnRelation($value_relation['select_column']);                                                    
                    
                    $value_relation['relation_key'] = (!empty($value_relation['relation_key']) ? $value_relation['relation_key']:'id' );
                    // auto add alias table jika tidak ada "."
                    $arr_transform = [
                        'relation_key' => '{{table}}.value',
                        'foreign_key'    => '{{table_has_many}}.value',
                    ];
                    foreach ($value_relation as $value_relation_key => $value_relation_value) {
                        if( isset($arr_transform[$value_relation_key]) ) {
                            if (strpos($value_relation_value, '.') === false) {
                                $value_relation[$value_relation_key] = str_replace('value', $value_relation_value, $arr_transform[$value_relation_key]);
                            }
                        }
                    }

                    $has_many_query = str_replace('{{column_has_many_relation_key}}',$value_relation['relation_key'],$has_many_query);                    
                    $has_many_query = str_replace('{{column_has_many_foreign_key}}',$value_relation['foreign_key'],$has_many_query);
                    $has_many_query = str_replace('{{column_has_many}}',"".$column_has_many,$has_many_query);
                    $has_many_query = str_replace('{{table_has_many}}',$value_relation['table'],$has_many_query);
                    $has_many_query = str_replace('{{has_many_name}}',$value_relation['name'],$has_many_query);

                    if( !empty($value_relation['custom_join']) )
                    {
                        $has_many_query = str_replace('-- end list has many join option',$value_relation['custom_join']."\r\n\t\t\t\t\t".'-- end list has many join option',$has_many_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $has_many_query = str_replace('-- end list has many query option',$value_relation['custom_option']."\r\n\t\t\t\t\t".'-- end list has many query option',$has_many_query);
                    }
                    
                    $cols_table_model .= $has_many_query."\r\n";
                    
                }

                // belongs to many query
                if($value_relation['type']=='belongs_to_many')
                {                   
                    
                    $value_relation['intermediate_table_full'] = $value_relation['intermediate_table'];
                    // when intermediate table is union
                    if (str_contains($value_relation['intermediate_table'], ' ')) {                                                                        
                        $pieces = explode(' ', $value_relation['intermediate_table']);
                        $value_relation['intermediate_table'] = array_pop($pieces);
                        $value_relation['intermediate_table_full'] = str_replace("\r\n","\r\n\t\t\t\t\t",$value_relation['intermediate_table_full']);
                    }
                    
                    // function belongs to many
                    $function = file_get_contents(__DIR__.'/../base'.$base.'/model/function_belongs_to_many.stub', FILE_USE_INCLUDE_PATH);
                    
                    $function = str_replace([
                            '{{belongs_to_many_name}}',
                            '{{belongs_to_many_model_name}}',
                            '{{belongs_to_many_table}}',
                            '{{belongs_to_many_intermediate_table}}',
                            '{{column_belongs_to_many_foreign_key_model}}',
                            '{{column_belongs_to_many_foreign_key_joining_model}}',
                            '{{foreign_key_model}}',
                            '{{foreign_key_joining_model}}',
                        ],
                        [
                            UCWORDS($value_relation['name']),
                            (!empty($value_relation['model_name'])) ? UCWORDS($value_relation['model_name']) : UCWORDS($value_relation['name']),
                            $value_relation['table'],
                            $value_relation['intermediate_table'],
                            $value_relation['foreign_key_model'],
                            $value_relation['foreign_key_joining_model'],
                            $value_relation['foreign_key_model'],
                            $value_relation['foreign_key_joining_model']
                        ],
                    $function);

                    if( !empty($value_relation['custom_join']) )
                    {
                        $function = str_replace('-- end list belongs to many join option',$value_relation['custom_join']."\r\n\t\t\t".'-- end list belongs to many join option',$function);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $function = str_replace('-- end list belongs to many query option',$value_relation['custom_option']."\r\n\t\t\t".'-- end list belongs to many query option',$function);
                    }                    
                    
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    if(!isset($list_name_cols[$value_relation['name']])){
                        // column belongs to many
                        $belongs_to_many_query = file_get_contents(__DIR__.'/../base'.$base.'/model/query_column_belongs_to_many.stub', FILE_USE_INCLUDE_PATH);
                        $value_relation['select_column'] = array_merge($value_relation['select_column'],[
                            [
                                "name" => $value_relation['foreign_key_joining_model'],
                                "column"    => $value_relation['intermediate_table'].'.'.$value_relation['foreign_key_joining_model'],
                                "type"  =>  "integer",
                            ]
                        ]);
                        if( !empty($value_relation['column_add_on']) )
                        {
                            foreach ($value_relation['column_add_on'] as $key_add_on => $value_add_on) {
                                $value_relation['select_column'][] = [
                                    "name" => $value_add_on['name'],
                                    "column"    => $value_relation['intermediate_table'].'.'.$value_add_on['name'],
                                    "type"  =>  $value_add_on['type'],
                                ];
                            }
                        }
                        $column_belongs_to_many = self::generateColumnRelation($value_relation['select_column']);

                        $belongs_to_many_query = str_replace([
                                '{{column_belongs_to_many}}',
                                '{{belongs_to_many_intermediate_table_full}}',
                                '{{belongs_to_many_intermediate_table}}',
                                '{{belongs_to_many_table}}',
                                '{{foreign_key_model}}',
                                '{{foreign_key_joining_model}}',
                                '{{belongs_to_many_name}}',
                            ],
                            [   
                                "".$column_belongs_to_many,
                                $value_relation['intermediate_table_full'],
                                $value_relation['intermediate_table'],
                                $value_relation['table'],
                                $value_relation['foreign_key_model'],
                                $value_relation['foreign_key_joining_model'],
                                $value_relation['name'],
                            ],$belongs_to_many_query);
                            
                        // $belongs_to_many_query = str_replace('{{column_belongs_to_many}}',"".$column_belongs_to_many,$belongs_to_many_query);
                        // $belongs_to_many_query = str_replace('{{belongs_to_many_intermediate_table}}',$value_relation['intermediate_table'],$belongs_to_many_query);
                        // $belongs_to_many_query = str_replace('{{belongs_to_many_table}}',$value_relation['table'],$belongs_to_many_query);                    
                        // $belongs_to_many_query = str_replace('{{foreign_key_model}}',$value_relation['foreign_key_model'],$belongs_to_many_query);
                        // $belongs_to_many_query = str_replace('{{foreign_key_joining_model}}',$value_relation['foreign_key_joining_model'],$belongs_to_many_query);
                        // $belongs_to_many_query = str_replace('{{belongs_to_many_name}}',$value_relation['name'],$belongs_to_many_query);
                        
                        if( !empty($value_relation['custom_join']) )
                        {
                            $belongs_to_many_query = str_replace('-- end list belongs to many join option',$value_relation['custom_join']."\r\n\t\t\t\t\t".'-- end list belongs to many join option',$belongs_to_many_query);
                        }
                        if( !empty($value_relation['custom_option']) )
                        {
                            $belongs_to_many_query = str_replace('-- end list belongs to many query option',$value_relation['custom_option']."\r\n\t\t\t\t\t".'-- end list belongs to many query option',$belongs_to_many_query);
                        }
                        
                        $cols_table_model .= $belongs_to_many_query."\r\n";
                    }
                    
                    // when intermediate table is union
                    // if (!str_contains($value_relation['intermediate_table_full'], ' ')) { 
                    //     // start build migration for intermediate table                    
                    //     $intermediate_name = $name_model.'_'.$value_relation['name'];
                    //     $intermediate_table_name = $value_relation['intermediate_table'];
                        
                    //     // set default column
                    //     $value_relation['column'] = [
                    //     [
                    //         'name'  =>  $value_relation['foreign_key_model'],
                    //         'type'  =>  ($value_relation['foreign_key_model_type']??"integer"),
                    //     ],
                    //     [
                    //         'name'  =>  $value_relation['foreign_key_joining_model'],
                    //         'type'  =>  ($value_relation['foreign_key_joining_model_type']??"integer"),
                    //     ],  
                    //     ];

                    //     $value_relation = columnBuilder::build($value_relation,'column');
                        
                    //     if( !empty($value_relation['column_add_on']) )
                    //     {
                    //         $value_relation['column'] = array_merge($value_relation['column_add_on'],$value_relation['column']);
                    //     }

                    //     $index = MigrationBuilder::getIndexExist($intermediate_table_name);                    
                    //     $index = !empty($index['list_index']) ? $index['list_index']:[];
                        
                        
                    //     MigrationBuilder::build($intermediate_name,$intermediate_table_name,$value_relation['column'],$index);
                    
                    //     // migrate
                    //     LaravelRestBuilder::setLaravelrestbuilderConnection();
                    //     \Artisan::call('migrate',['--path' => config('laravelrestbuilder.copy_to').'/database/migrations','--force' => true]);                        
                        
                    //     // end build migration for intermediate table   
                    // }

                    LaravelRestBuilder::setDefaultLaravelrestbuilderConnection();
                    
                }

                if( !empty($value_relation['custom_order']) ) {                    
                    $cols_table_model = str_replace('{{custom_order}}',$value_relation['custom_order'],$cols_table_model);
                }else {
                    $cols_table_model = str_replace('{{custom_order}}','',$cols_table_model);
                }
            }                        
        }

        $option_appends = file_get_contents(__DIR__.'/../base'.$base.'/model/option_appends.stub', FILE_USE_INCLUDE_PATH);
        $option_appends = str_replace('{{column_appends}}',$appends_table_model,$option_appends);
        $base_model = str_replace('// end list option',$option_appends,$base_model);
        
        $base_set_bindings = str_replace("{{column}}",substr($column_set_bindings,0,-7),$base_set_bindings);
                
        $base_model = str_replace('{{binding_columns}}',$base_set_bindings,$base_model);
        $base_model = str_replace('{{column}}',$cols_table_model,$base_model);

        if( !empty($custom_union_model) ) {
            $union_file = file_get_contents(__DIR__.'/../base'.$base.'/model/query_union_model.stub', FILE_USE_INCLUDE_PATH);

            foreach ($custom_union_model as $arr_union_key => $arr_union_value) {
                $union = str_replace([
                    '{{union}}',
                ],[
                    $arr_union_value
                ],$union_file);

                $base_model = str_replace('// end list query union',$union."\r\n\t\t\t\t".'// end list query union',$base_model);
            }
        }else {

            if( !empty($custom_union) ) {
                $union_file = file_get_contents(__DIR__.'/../base'.$base.'/model/query_union_table.stub', FILE_USE_INCLUDE_PATH);
                $arr_union = explode('union',$custom_union);

                foreach ($arr_union as $arr_union_key => $arr_union_value) {
                    if( !empty($arr_union_value) ){
                        $union = str_replace([
                            '{{union}}',
                        ],[
                            str_replace("\n","\n\t\t\t\t\t",$arr_union_value)
                        ],$union_file);

                        $base_model = str_replace('// end list query union',$union."\r\n\t\t\t\t".'// end list query union',$base_model);
                    }
                }
            }

        }

        $base_model = str_replace('{{table}}',$table,$base_model);
        
        if(empty($get_company_code)){
            $base_model = str_replace('{{company_id_code}}',config('laravelrestbuilder.company_id_code'),$base_model);
        }else {
            $base_model = str_replace('{{company_id_code}}',$get_company_code,$base_model);
        }
        
        $base_model = str_replace('{{user_id_code}}',config('laravelrestbuilder.user_id_code'),$base_model);
        
        $base_model = str_replace([
            '{{custom_folder}}',
            '{{custom_folder_namespace}}',
        ],[
            $custom_folder,
            str_replace('/','\\',$custom_folder),
        ],$base_model);

        if( $base == '-0'){
            FileCreator::create( $model_file_name, 'app/Http/Model'.$custom_folder, $base_model );
        }elseif( $base == '-9'){
            FileCreator::create( $model_file_name, 'app/Models'.$custom_folder, $base_model );
        }else{
            FileCreator::create( $model_file_name, 'app/Http/Models'.$custom_folder, $base_model );
        }
        
    }

    /**
     * generateColumnRelation function
     *
     * @param [type] $column_to_generate
     * @return void
     */
    static function generateColumnRelation($column_to_generate)
    {
        $mysql_version = config('laravelRestBuilder.mysql_version');

        $column_code = '';
        foreach ($column_to_generate as $column_key => $column_value) {
            $column_value['column'] = str_replace("\n","\n\t\t\t\t\t\t",$column_value['column']);
            
            if( $mysql_version > 5.6 ){
                $column_code .= "\t\t\t\t\t\t\t'".$column_value['name']."', ".$column_value['column']."";
                if( count($column_to_generate)-1 != $column_key )
                {          
                    $column_code .= ",\r\n";
                }
            }else {
            
                // code mysql <= 5.6
                if($column_value['type'] =='integer')
                {
                    $name = '\"'.$column_value['name'].'\"';                
                    if( count($column_to_generate)-1 != $column_key )
                    {
                        $column_code .= "\t\t\t\t\t\t\t'".$name.": ', IFNULL(".$column_value['column'].",''), ', ";
                    }
                    else
                    {
                        $column_code .= "\t\t\t\t\t\t\t'".$name.": ', IFNULL(".$column_value['column'].",''), '', ";
                    }
                }
                if($column_value['type'] =='string')
                {
                    $name = '\"'.$column_value['name'].'\"';
                    if( count($column_to_generate)-1 != $column_key )
                    {
                        $column_value['column'] = '\"\',IFNULL('.$column_value['column'].",'')".',\'\",';
                    }
                    else
                    {
                        $column_value['column'] = '\"\',IFNULL('.$column_value['column'].",'')".',\'\"\',';
                    }
                    $column_code .= "\t\t\t\t\t\t\t'".$name.": ".$column_value['column']." ";
                }
                if( count($column_to_generate)-1 != $column_key )
                {          
                    $column_code .= "',\r\n";
                }

            }

        }

        return $column_code;
    }

}