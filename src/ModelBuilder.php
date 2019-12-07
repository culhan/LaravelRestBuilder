<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class ModelBuilder
{

    /**
     * model builder function
     *
     * @param [type] $name_model
     * @param [type] $table
     * @param [type] $column
     * @param [type] $column_function
     * @param [type] $route
     * @param [type] $with_timestamp
     * @param [type] $with_authstamp
     * @param [type] $with_ipstamp
     * @param [type] $with_companystamp
     * @param [type] $relation
     * @return void
     */
    static function build( $name_model, $table, $key, $column, $column_function = [], $with_timestamp, $with_authstamp, $with_ipstamp, $with_companystamp, $custom_filter, $custom_join, $relation, $hidden, $with_company_restriction, $casts, $with_authenticable )
    {
        $model_file_name = UCWORDS($name_model);
        $name = UCWORDS($name_model);
        if( $with_authenticable == 1) {
            $base_model = file_get_contents(__DIR__.'/../base/model/base_authenticable.stub', FILE_USE_INCLUDE_PATH);    
        }else {
            $base_model = file_get_contents(__DIR__.'/../base/model/base.stub', FILE_USE_INCLUDE_PATH);
        }
        $base_model = str_replace('{{Name}}',$name,$base_model);        
        
        if( !empty($casts) ) {
            $column_casts = '';
            foreach ($casts as $casts_value) {
                $column_casts   .= "'".$casts_value['column']."'\t=> '".$casts_value['data_type']."'";
            }
            $option_casts = file_get_contents(__DIR__.'/../base/model/option_casts.stub', FILE_USE_INCLUDE_PATH);
            $option_casts = str_replace("{{column_casts}}",$column_casts,$option_casts);
            $base_model = str_replace('// end list option',$option_casts,$base_model);
        }

        if( !empty($custom_join) ) {
            $option_custom_join = file_get_contents(__DIR__.'/../base/model/option_query_custom_join.stub', FILE_USE_INCLUDE_PATH);
            $option_custom_join = str_replace('{{custom_join}}',$custom_join,$option_custom_join);
            $base_model = str_replace('// end raw join query',$option_custom_join,$base_model);
        }

        if( $with_timestamp == 1 ) {
            $option_timestamp = file_get_contents(__DIR__.'/../base/model/option_query_timestamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list query option',$option_timestamp,$base_model);

            $option_timestamp = file_get_contents(__DIR__.'/../base/model/option_timestamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list option',$option_timestamp,$base_model);
        }

        if( $with_authstamp == 1 ) {
            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_query_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list query option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_updating_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list updating option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_creating_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_authstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list option',$option_authstamp,$base_model);
        }
        
        if( $with_companystamp == 1 ) {

            if( !empty($with_company_restriction) ) {
                $option_companystamp = file_get_contents(__DIR__.'/../base/model/option_query_companystamp.stub', FILE_USE_INCLUDE_PATH);
                $base_model = str_replace('// end list query option',$option_companystamp,$base_model);
            }
            
            $option_companystamp = file_get_contents(__DIR__.'/../base/model/option_creating_companystamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_companystamp,$base_model);
        }
        
        if( $with_ipstamp == 1 ) {
            $option_ipstamp = file_get_contents(__DIR__.'/../base/model/option_creating_ipstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_ipstamp,$base_model);
            $option_ipstamp = file_get_contents(__DIR__.'/../base/model/option_updating_ipstamp.stub', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list updating option',$option_ipstamp,$base_model);
        }

        if( !empty($key) ) {
            $option_key = file_get_contents(__DIR__.'/../base/model/option_key.stub', FILE_USE_INCLUDE_PATH);
            $option_key = str_replace('{{key}}',$key,$option_key);
            $base_model = str_replace('// end list option',$option_key,$base_model);
        }

        if( !empty($custom_filter) ) {
            $option_custom_filter = file_get_contents(__DIR__.'/../base/model/option_query_custom_filter.stub', FILE_USE_INCLUDE_PATH);
            $option_custom_filter = str_replace('{{custom_filter}}',$custom_filter,$option_custom_filter);
            $base_model = str_replace('// end list query option',$option_custom_filter,$base_model);
        }

        $cols_table_model = "";        
        $fillable_table_model = "";
        $hidden = array_flip($hidden);
        $base_column_function_query = file_get_contents(__DIR__.'/../base/model/query_column_function.stub', FILE_USE_INCLUDE_PATH);
        
        foreach ($column as $key => $value) {            
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

                $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'').$column_query;
                // $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'')."\"".'{{table}}.'.$value['name']."\",\r\n";
            }

            $fillable_table_model .= "\t\t\"".$value['name']."\",";
            if( !empty($column[$key+1]) ) {
                $fillable_table_model .= "\r\n";
            }

        }

        foreach ($column_function as $key_column_function => $value_column_function) {
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value_column_function['name']]) )
            {      
                $column_function_query = str_replace([
                    '{{column_function_name}}',
                    '{{function_query}}'
                ],[
                    $value_column_function['name'],
                    str_replace("\n","\n\t\t\t\t\t",$value_column_function['function'])
                ],$base_column_function_query);

                $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'').$column_function_query;          
                // $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'')."\DB::raw(\"".str_replace("\n","\n\t\t\t\t\t",$value_column_function['function'])." as ".$value_column_function['name']."\"),\r\n";
            }
        }

        // fillable
        $option_fillable = file_get_contents(__DIR__.'/../base/model/option_fillable.stub', FILE_USE_INCLUDE_PATH);
        $option_fillable = str_replace('{{column_fillable}}',$fillable_table_model,$option_fillable);
        $base_model = str_replace('// end list option',$option_fillable,$base_model);
        
        if( !empty($relation) )
        {
            foreach ($relation as $key_relation => $value_relation) {
                
                $value_relation['custom_order'] = str_replace("\n","\n\t\t\t\t\t\t\t\t",$value_relation['custom_order']);
                $value_relation['custom_join'] = str_replace("\n","\n\t\t\t\t\t\t\t\t",$value_relation['custom_join']);
                $value_relation['custom_option'] = str_replace("\n","\n\t\t\t\t\t\t\t\t",$value_relation['custom_option']);
                
                // belongs to query
                if($value_relation['type']=='belongs_to')
                {                    
                        
                    //function belongs to
                    $function = file_get_contents(__DIR__.'/../base/model/function_belongs_to.stub', FILE_USE_INCLUDE_PATH);                    
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
                    $belongs_to_query = file_get_contents(__DIR__.'/../base/model/query_column_belongs_to.stub', FILE_USE_INCLUDE_PATH);
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
                        $belongs_to_query = str_replace('-- end list belongs to join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t\t\t".'-- end list belongs to join option',$belongs_to_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $belongs_to_query = str_replace('-- end list belongs to query option',$value_relation['custom_option']."\r\n\t\t\t\t\t\t\t\t".'-- end list belongs to query option',$belongs_to_query);
                    }
                    
                    $cols_table_model .= $belongs_to_query."\r\n";
                    
                }

                // has one query
                if($value_relation['type']=='has_one')
                {                    
                        
                    //function has one
                    $function = file_get_contents(__DIR__.'/../base/model/function_has_one.stub', FILE_USE_INCLUDE_PATH);
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
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    // column has one
                    $has_one_query = file_get_contents(__DIR__.'/../base/model/query_column_has_one.stub', FILE_USE_INCLUDE_PATH);
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
                        $has_one_query = str_replace('-- end list has one join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t\t\t".'-- end list has one join option',$has_one_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $has_one_query = str_replace('-- end list has one query option',$value_relation['custom_option']."\r\n\t\t\t\t\t\t".'-- end list has one query option',$has_one_query);
                    }
                    
                    $cols_table_model .= $has_one_query."\r\n";
                    
                }

                // has many query
                if($value_relation['type']=='has_many')
                {                    

                    // function has many                    
                    $function = file_get_contents(__DIR__.'/../base/model/function_has_many.stub', FILE_USE_INCLUDE_PATH);
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
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    // column has many
                    $has_many_query = file_get_contents(__DIR__.'/../base/model/query_column_has_many.stub', FILE_USE_INCLUDE_PATH);
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
                        $has_many_query = str_replace('-- end list has many join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t\t\t".'-- end list has many join option',$has_many_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $has_many_query = str_replace('-- end list has many query option',$value_relation['custom_option']."\r\n\t\t\t\t\t\t\t\t".'-- end list has many query option',$has_many_query);
                    }
                    
                    $cols_table_model .= $has_many_query."\r\n";
                    
                }

                // belongs to many query
                if($value_relation['type']=='belongs_to_many')
                {                    

                    // function belongs to many
                    $function = file_get_contents(__DIR__.'/../base/model/function_belongs_to_many.stub', FILE_USE_INCLUDE_PATH);
                    
                    $function = str_replace([
                            '{{belongs_to_many_name}}',
                            '{{belongs_to_many_model_name}}',
                            '{{belongs_to_many_table}}',
                            '{{belongs_to_many_intermediate_table}}',
                            '{{column_belongs_to_many_foreign_key_model}}',
                            '{{column_belongs_to_many_foreign_key_joining_model}}',
                        ],
                        [
                            UCWORDS($value_relation['name']),
                            (!empty($value_relation['model_name'])) ? UCWORDS($value_relation['model_name']) : UCWORDS($value_relation['name']),
                            $value_relation['table'],
                            $value_relation['intermediate_table'],
                            $value_relation['foreign_key_model'],
                            $value_relation['foreign_key_joining_model'],
                        ],
                    $function);

                    // $function = str_replace('{{belongs_to_many_name}}',UCWORDS($value_relation['name']),$function);
                    // if(!empty($value_relation['model_name'])) {
                    //     $function = str_replace('{{belongs_to_many_model_name}}',UCWORDS($value_relation['model_name']),$function);
                    // }else {
                    //     $function = str_replace('{{belongs_to_many_model_name}}',UCWORDS($value_relation['name']),$function);
                    // }
                    // $function = str_replace('{{belongs_to_many_table}}',$value_relation['table'],$function);
                    // $function = str_replace('{{belongs_to_many_intermediate_table}}',$value_relation['intermediate_table'],$function);
                    
                    // $function = str_replace('{{column_belongs_to_many_foreign_key_model}}',$value_relation['foreign_key_model'],$function);
                    // $function = str_replace('{{column_belongs_to_many_foreign_key_joining_model}}',$value_relation['foreign_key_joining_model'],$function);                    
                    
                    if( !empty($value_relation['custom_option']) ) {
                        $custom_option_relation = file_get_contents(__DIR__.'/../base/model/custom_option_relation_belongs_to_many.stub', FILE_USE_INCLUDE_PATH);
                        $custom_option_relation = str_replace([
                                '{{custom_option}}',
                                '{{column_belongs_to_many_foreign_key_model}}',
                                '{{belongs_to_many_intermediate_table}}'
                            ],
                            [
                                $value_relation['custom_option'],
                                $value_relation['foreign_key_model'],
                                $value_relation['intermediate_table'],
                            ],
                        $custom_option_relation);

                        $function = str_replace(';',"\n".$custom_option_relation,$function);
                    }                    
                    $base_model = str_replace('// end list relation function',$function,$base_model);

                    // column belongs to many
                    $belongs_to_many_query = file_get_contents(__DIR__.'/../base/model/query_column_belongs_to_many.stub', FILE_USE_INCLUDE_PATH);
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
                    
                    $belongs_to_many_query = str_replace('{{column_belongs_to_many}}',"".$column_belongs_to_many,$belongs_to_many_query);
                    $belongs_to_many_query = str_replace('{{belongs_to_many_intermediate_table}}',$value_relation['intermediate_table'],$belongs_to_many_query);
                    $belongs_to_many_query = str_replace('{{belongs_to_many_table}}',$value_relation['table'],$belongs_to_many_query);                    
                    $belongs_to_many_query = str_replace('{{foreign_key_model}}',$value_relation['foreign_key_model'],$belongs_to_many_query);
                    $belongs_to_many_query = str_replace('{{foreign_key_joining_model}}',$value_relation['foreign_key_joining_model'],$belongs_to_many_query);
                    $belongs_to_many_query = str_replace('{{belongs_to_many_name}}',$value_relation['name'],$belongs_to_many_query);
                    if( !empty($value_relation['custom_join']) )
                    {
                        $belongs_to_many_query = str_replace('-- end list belongs to many join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t".'-- end list belongs to many join option',$belongs_to_many_query);
                    }
                    if( !empty($value_relation['custom_option']) )
                    {
                        $belongs_to_many_query = str_replace('-- end list belongs to many query option',$value_relation['custom_option']."\r\n\t\t\t\t\t\t".'-- end list belongs to many query option',$belongs_to_many_query);
                    }
                    
                    $cols_table_model .= $belongs_to_many_query."\r\n";

                    // start build migration for intermediate table                    
                    $intermediate_name = $name_model.'_'.$value_relation['name'];
                    $intermediate_table_name = $value_relation['intermediate_table'];
                    
                    // set default column
                    $value_relation['column'] = [
                    [
                        'name'  =>  $value_relation['foreign_key_model'],
                        'type'  =>  'integer',
                    ],
                    [
                        'name'  =>  $value_relation['foreign_key_joining_model'],
                        'type'  =>  'integer',
                    ],  
                    ];

                    $value_relation = columnBuilder::build($value_relation,'column');
                    
                    if( !empty($value_relation['column_add_on']) )
                    {
                        $value_relation['column'] = array_merge($value_relation['column_add_on'],$value_relation['column']);
                    }

                    $index = MigrationBuilder::getIndexExist($intermediate_table_name);                    
                    $index = !empty($index['list_index']) ? $index['list_index']:[];
                    
                    MigrationBuilder::build($intermediate_name,$intermediate_table_name,$value_relation['column'],$index);
                    
                    // migrate
                    LaravelRestBuilder::setLaravelrestbuilderConnection();
                    \Artisan::call('migrate',['--path' => config('laravelrestbuilder.copy_to').'/database/migrations','--force' => true]);
                    LaravelRestBuilder::setDefaultLaravelrestbuilderConnection();
                    
                    // end build migration for intermediate table
                    
                }

                if( !empty($value_relation['custom_order']) ) {                    
                    $cols_table_model = str_replace('{{custom_order}}',$value_relation['custom_order'],$cols_table_model);
                }else {
                    $cols_table_model = str_replace('{{custom_order}}','',$cols_table_model);
                }
            }
        }
        
        $base_model = str_replace('{{column}}',$cols_table_model,$base_model);
        $base_model = str_replace('{{table}}',$table,$base_model);
        $base_model = str_replace('{{company_id_code}}',config('laravelrestbuilder.company_id_code'),$base_model);
        $base_model = str_replace('{{user_id_code}}',config('laravelrestbuilder.user_id_code'),$base_model);
        
        
        FileCreator::create( $model_file_name, 'app/Http/Models', $base_model );
    }

    /**
     * generateColumnRelation function
     *
     * @param [type] $column_to_generate
     * @return void
     */
    static function generateColumnRelation($column_to_generate)
    {
        $column_code = '';
        foreach ($column_to_generate as $column_key => $column_value) {
            $column_value['column'] = str_replace("\n","\n\t\t\t\t\t\t\t\t\t",$column_value['column']);
            if($column_value['type'] =='integer')
            {
                $name = '\"'.$column_value['name'].'\"';                
                if( count($column_to_generate)-1 != $column_key )
                {
                    $column_code .= "\t\t\t\t\t\t\t\t\t'".$name.": ', IFNULL(".$column_value['column'].",''), ', ";
                }
                else
                {
                    $column_code .= "\t\t\t\t\t\t\t\t\t'".$name.": ', IFNULL(".$column_value['column'].",''), '', ";
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
                $column_code .= "\t\t\t\t\t\t\t\t\t'".$name.": ".$column_value['column']." ";
            }
            if( count($column_to_generate)-1 != $column_key )
            {          
                $column_code .= "',\r\n";
            }
        }

        return $column_code;
    }

}