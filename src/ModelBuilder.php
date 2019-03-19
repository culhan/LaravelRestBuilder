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
     * @param [type] $route
     * @param [type] $with_timestamp
     * @param [type] $with_authstamp
     * @param [type] $with_ipstamp
     * @param [type] $with_companystamp
     * @param [type] $relation
     * @return void
     */
    static function build( $name_model, $table, $column, $route, $with_timestamp, $with_authstamp, $with_ipstamp, $with_companystamp, $relation )
    {
        $model_file_name = UCWORDS($name_model);
        $name = UCWORDS($name_model);
        $base_model = file_get_contents(__DIR__.'/../base/model/base.php', FILE_USE_INCLUDE_PATH);
        $base_model = str_replace('{{Name}}',$name,$base_model);        

        if( $with_timestamp == 1 )
        {
            $option_timestamp = file_get_contents(__DIR__.'/../base/model/option_query_timestamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list query option',$option_timestamp,$base_model);

            $option_timestamp = file_get_contents(__DIR__.'/../base/model/option_timestamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list option',$option_timestamp,$base_model);
        }

        if( $with_authstamp == 1 )
        {
            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_query_authstamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list query option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_updating_authstamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list updating option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_creating_authstamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_authstamp,$base_model);

            $option_authstamp = file_get_contents(__DIR__.'/../base/model/option_authstamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list option',$option_authstamp,$base_model);
        }

        if( $with_companystamp == 1 )
        {
            $option_companystamp = file_get_contents(__DIR__.'/../base/model/option_query_companystamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list query option',$option_companystamp,$base_model);
            
            $option_companystamp = file_get_contents(__DIR__.'/../base/model/option_creating_companystamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_companystamp,$base_model);
        }
        
        if( $with_ipstamp == 1 )
        {
            $option_ipstamp = file_get_contents(__DIR__.'/../base/model/option_creating_ipstamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list creating option',$option_ipstamp,$base_model);
            $option_ipstamp = file_get_contents(__DIR__.'/../base/model/option_updating_ipstamp.php', FILE_USE_INCLUDE_PATH);
            $base_model = str_replace('// end list updating option',$option_ipstamp,$base_model);
        }

        $cols_table_model = "";        
        $fillable_table_model = "";        
        foreach ($column as $key => $value) {            
            if( empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) )
            {
                $cols_table_model .= (!empty($cols_table_model) ? "\t\t\t\t\t":'')."\"".'{{table}}.'.$value['name']."\",\r\n";
            }
            $fillable_table_model .= "\t\t\"".$value['name']."\",";
            if( !empty($column[$key+1]))
            {
                $fillable_table_model .= "\r\n";
            }
        }

        // fillable
        $option_fillable = file_get_contents(__DIR__.'/../base/model/option_fillable.php', FILE_USE_INCLUDE_PATH);
        $option_fillable = str_replace('{{column_fillable}}',$fillable_table_model,$option_fillable);
        $base_model = str_replace('// end list option',$option_fillable,$base_model);
        
        if( !empty($relation) )
        {
            foreach ($relation as $key_relation => $value_relation) {
                
                // belongs to query
                if($value_relation['type']=='belongs_to')
                {
                    
                        
                        //function belongs to
                        $function = file_get_contents(__DIR__.'/../base/model/function_belongs_to.php', FILE_USE_INCLUDE_PATH);                    
                        if( empty($value_relation['service_name']) )
                        {
                            $function = str_replace('{{belongs_to_name_model}}',ucwords(camel_case($value_relation['name'])),$function);
                        }
                        else 
                        {
                            $function = str_replace('{{belongs_to_name_model}}',ucwords(camel_case($value_relation['service_name'])),$function);
                        }
                        $function = str_replace('{{belongs_to_name}}',ucwords($value_relation['name']),$function);
                        $function = str_replace('{{column_belongs_to_foreign_key}}',$value_relation['foreign_key'],$function);                    
                        $base_model = str_replace('// end list relation function',$function,$base_model);

                        // column belongs to
                        $belongs_to_query = file_get_contents(__DIR__.'/../base/model/query_column_belongs_to.php', FILE_USE_INCLUDE_PATH);
                        $column_belongs_to = self::generateColumnRelation($value_relation['select_column']);
                        
                        $belongs_to_query = str_replace('{{column_belongs_to}}',"".$column_belongs_to,$belongs_to_query);
                        $belongs_to_query = str_replace('{{table_belongs_to}}',$value_relation['table'],$belongs_to_query);
                        $belongs_to_query = str_replace('{{column_belongs_to_foreign_key}}',$value_relation['foreign_key'],$belongs_to_query);                    
                        $belongs_to_query = str_replace('{{belongs_to_name}}',$value_relation['name'],$belongs_to_query);                                                

                        if( !empty($value_relation['custom_join']) )
                        {
                            $belongs_to_query = str_replace('-- end list belongs to join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t".'-- end list belongs to join option',$belongs_to_query);
                        }
                        if( !empty($value_relation['custom_option']) )
                        {
                            $belongs_to_query = str_replace('-- end list belongs to query option',$value_relation['custom_option']."\r\n\t\t\t\t\t\t".'-- end list belongs to query option',$belongs_to_query);
                        }
                        
                        $cols_table_model .= $belongs_to_query."\r\n";
                    
                }

                // has one query
                if($value_relation['type']=='has_one')
                {
                    
                        
                        //function has one
                        $function = file_get_contents(__DIR__.'/../base/model/function_has_one.php', FILE_USE_INCLUDE_PATH);                    
                        $function = str_replace('{{has_one_name}}',ucwords($value_relation['name']),$function);
                        $function = str_replace('{{column_has_one_foreign_key}}',$value_relation['foreign_key'],$function);                    
                        $base_model = str_replace('// end list relation function',$function,$base_model);

                        // column has one
                        $has_one_query = file_get_contents(__DIR__.'/../base/model/query_column_has_one.php', FILE_USE_INCLUDE_PATH);
                        $column_has_one = self::generateColumnRelation($value_relation['select_column']);
                        
                        $has_one_query = str_replace('{{column_has_one}}',"".$column_has_one,$has_one_query);
                        $has_one_query = str_replace('{{table_has_one}}',$value_relation['table'],$has_one_query);
                        $has_one_query = str_replace('{{column_has_one_foreign_key}}',$value_relation['foreign_key'],$has_one_query);                    
                        $has_one_query = str_replace('{{has_one_name}}',$value_relation['name'],$has_one_query);
                        if( !empty($value_relation['custom_join']) )
                        {
                            $has_one_query = str_replace('-- end list has one join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t".'-- end list has one join option',$has_one_query);
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
                        $function = file_get_contents(__DIR__.'/../base/model/function_has_many.php', FILE_USE_INCLUDE_PATH);
                        $function = str_replace('{{has_many_name}}',ucwords($value_relation['name']),$function);
                        $function = str_replace('{{column_has_many_foreign_key}}',$value_relation['foreign_key'],$function);                    
                        $base_model = str_replace('// end list relation function',$function,$base_model);

                        // column has many
                        $has_many_query = file_get_contents(__DIR__.'/../base/model/query_column_has_many.php', FILE_USE_INCLUDE_PATH);
                        $column_has_many = self::generateColumnRelation($value_relation['select_column']);
                                   
                        $has_many_query = str_replace('{{column_has_many}}',"".$column_has_many,$has_many_query);
                        $has_many_query = str_replace('{{table_has_many}}',$value_relation['table'],$has_many_query);
                        $has_many_query = str_replace('{{column_has_many_foreign_key}}',$value_relation['foreign_key'],$has_many_query);                    
                        $has_many_query = str_replace('{{has_many_name}}',$value_relation['name'],$has_many_query);
                        if( !empty($value_relation['custom_join']) )
                        {
                            $has_many_query = str_replace('-- end list has many join option',$value_relation['custom_join']."\r\n\t\t\t\t\t\t".'-- end list has many join option',$has_many_query);
                        }
                        if( !empty($value_relation['custom_option']) )
                        {
                            $has_many_query = str_replace('-- end list has many query option',$value_relation['custom_option']."\r\n\t\t\t\t\t\t".'-- end list has many query option',$has_many_query);
                        }
                        
                        $cols_table_model .= $has_many_query."\r\n";
                    
                }

                // belongs to many query
                if($value_relation['type']=='belongs_to_many')
                {
                    

                        // function belongs to many
                        $function = file_get_contents(__DIR__.'/../base/model/function_belongs_to_many.php', FILE_USE_INCLUDE_PATH);
                        $function = str_replace('{{belongs_to_many_name}}',UCWORDS($value_relation['name']),$function);
                        $function = str_replace('{{belongs_to_many_table}}',$value_relation['table'],$function);
                        $function = str_replace('{{column_belongs_to_many_foreign_key_model}}',$value_relation['foreign_key_model'],$function);
                        $function = str_replace('{{column_belongs_to_many_foreign_key_joining_model}}',$value_relation['foreign_key_joining_model'],$function);                    
                        $base_model = str_replace('// end list relation function',$function,$base_model);

                        // column belongs to many
                        $belongs_to_many_query = file_get_contents(__DIR__.'/../base/model/query_column_belongs_to_many.php', FILE_USE_INCLUDE_PATH);
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

                        MigrationBuilder::build($intermediate_name,$intermediate_table_name,$value_relation['column']);
                        // end build migration for intermediate table
                    
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

        return $column_code;
    }

}