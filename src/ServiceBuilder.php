<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;

class ServiceBuilder
{
    /**
     * build service function
     *
     * @param [type] $name
     * @param [type] $table
     * @param [type] $column
     * @param [type] $route
     * @param [type] $relation
     * @return void
     */
    static function build( $name, $table, $column, $route, $relation)
    {
        $name = UCWORDS($name);
        $service_file_name = $name.'Service';
        $base_service = file_get_contents(__DIR__.'/../base/service/service.stub', FILE_USE_INCLUDE_PATH);
        $base_service = str_replace('{{Name}}',$name,$base_service);        
        
        $list_file = scandir(__DIR__.'/../base/service', SCANDIR_SORT_DESCENDING);
        $traits_arr = [];
        foreach ($route as $key => $value) {
            $function_name = 'function_'.$value['process'].'.stub';
            if(in_array($function_name,$list_file))
            {
                $cols_table_model = "";
                $cols_table_model_validation = "";
                $code_data_filter = '';
                $code_data_validation = '';

                foreach ($column as $key_column => $value_column) {
                    if( empty(LaravelRestBuilder::$forbidden_column_name_for_service[$value_column['name']]) )
                    {
                        $cols_table_model .= '"'.$value_column['name'].'"';
                        if( !empty($cols_table_model) )
                        {
                            $cols_table_model .= ",\r\n\t\t\t";
                        }
                    }
                }
                
                if(!empty($value['traits']))
                {                    
                    foreach ($value['traits'] as $key_traits => $value_traits) {                        
                        $traits_arr[$value_traits['path']] = $value_traits['path'];
                    }                    
                }

                if(!empty($value['advanced_validation'])) {
                    $code_data_validation = $value['advanced_validation_code'];
                }else {
                    if(!empty($value['validation']))
                    {
                        $data_validation_code = file_get_contents(__DIR__.'/../base/service/data_validation.stub', FILE_USE_INCLUDE_PATH);
                        foreach ($value['validation'] as $key_validation => $value_validation) {
                            $cols_table_model_validation .= '"'.$value_validation['name'].'"'."\t=>\t".'"'.$value_validation['statement'].'"';
                            if( !empty($cols_table_model_validation) )
                            {
                                $cols_table_model_validation .= ",\r\n\t\t\t";
                            }
                        }

                        $code_data_validation = str_replace([
                            "{{column_validation}}",
                        ],
                        [
                            substr($cols_table_model_validation, 0, -5)
                        ],$data_validation_code);
                    }
                }

                if(!empty($value['dataFilter'])) {
                    $data_merge_code = file_get_contents(__DIR__.'/../base/service/data_merge.stub', FILE_USE_INCLUDE_PATH);
                    $data_filter_code = file_get_contents(__DIR__.'/../base/service/data_filter.stub', FILE_USE_INCLUDE_PATH);                                        

                    $column_data_filter = '';
                    $default_data_filter = '';
                    foreach ($value['dataFilter'] as $key_dataFilter => $value_dataFilter) {
                        $column_data_filter .= '"'.$value_dataFilter['name'].'"';
                        
                        if( !empty($value_dataFilter['default']) ) {                            
                            $default_data_filter .= '"'.$value_dataFilter['name'].'"'."\t=>\t".$value_dataFilter['default'];
                        }

                        if( !empty($column_data_filter) && isset($value['dataFilter'][$key_dataFilter+1])) {
                            $column_data_filter .= ",\r\n\t\t\t";
                        }
                    }

                    $data_merge_filter_code = $data_filter_code;
                    if( !empty($default_data_filter) ) {
                        $data_merge_filter_code = $data_merge_code."\r\n\t\t".$data_filter_code;
                    }

                    $code_data_filter = str_replace([
                        "{{column}}",
                        "{{default}}"
                    ],
                    [
                        $column_data_filter,
                        $default_data_filter
                    ],$data_merge_filter_code);                    
                }
                
                $has_many_code = '';
                $has_one_code = '';
                $belongs_to_code = '';
                $belongs_to_many_code = '';
                $belongs_to_many_delete_code = '';
                $ihas_many_code = 0;
                $ihas_one_code = 0;
                $ibelongs_to_code = 0;
                $ibelongs_to_many = 0;
                foreach ($relation as $key_relation => $value_relation) {
                    if( empty($value_relation['simpan_data']) && $value_relation['type']!='belongs_to' ) {
                        continue;
                    }
                    $cols_table_model .= '"'.$value_relation['name'].'"';
                    if( !empty($cols_table_model) )
                    {
                        $cols_table_model .= ",\r\n\t\t\t";
                    }                    
                    // $cols_table_model_validation .= '"'.$value_relation['name'].'"'."\t=>\t".'""';
                    // if( !empty($cols_table_model_validation) )
                    // {
                    //     $cols_table_model_validation .= ",\r\n\t\t\t";
                    // }
                    

                    // has many create data
                    if( $value_relation['type'] == 'has_many' )
                    {
                        
                        $base_create_code = file_get_contents(__DIR__.'/../base/service/has_many_create_data.stub', FILE_USE_INCLUDE_PATH);
                        $base_create_code = str_replace('{{name_has_many}}',$value_relation['name'],$base_create_code);
                        $base_create_code = str_replace('{{foregin_key}}',$value_relation['foreign_key'],$base_create_code);
                        $base_create_code = str_replace('{{service_name}}',((!empty($value_relation['model_name'])) ? ucwords($value_relation['model_name']) : ucwords($value_relation['name'])),$base_create_code);                        
                        
                        $has_many_code .= (($ihas_many_code!=0) ? "\t\t":"").$base_create_code;
                        $ihas_many_code++;
                    }

                    // has one create data
                    if( $value_relation['type'] == 'has_one' )
                    {                        
                        
                        $base_create_code = file_get_contents(__DIR__.'/../base/service/has_one_create_data.stub', FILE_USE_INCLUDE_PATH);
                        $base_create_code = str_replace('{{name_has_one}}',$value_relation['name'],$base_create_code);
                        $base_create_code = str_replace('{{foregin_key}}',$value_relation['foreign_key'],$base_create_code);
                        $base_create_code = str_replace('{{service_name}}',((!empty($value_relation['model_name'])) ? ucwords($value_relation['model_name']) : ucwords($value_relation['name'])),$base_create_code);
                        
                        $has_one_code .= (($ihas_one_code!=0) ? "\t\t":"").$base_create_code;
                        $ihas_one_code++;
                    }

                    // belongs to create check data
                    if( $value_relation['type'] == 'belongs_to' )
                    {                        
                        
                        $base_create_code = file_get_contents(__DIR__.'/../base/service/belongs_to_check_data.stub', FILE_USE_INCLUDE_PATH);
                        
                        // $base_create_code = str_replace('{{name_belongs_to}}',$value_relation['name'],$base_create_code);
                        // $base_create_code = str_replace('{{foregin_key}}',$value_relation['foreign_key'],$base_create_code);
                        // $base_create_code = str_replace('{{service_name}}',,$base_create_code);
                        
                        $base_create_code = str_replace([
                                '{{check_data_function}}',
                                '{{name_belongs_to}}',
                                '{{foreign_key}}',
                                '{{service_name}}'
                            ],[
                                (!empty($value_relation['check_data_function']) ? $value_relation['check_data_function']:'getSingleData'),
                                ucwords(Helper::camelToTitle($value_relation['name'])),
                                $value_relation['foreign_key'],
                                ((!empty($value_relation['model_name'])) ? ucwords($value_relation['model_name']) : ucwords($value_relation['name']))
                            ],
                        $base_create_code);
                        
                        $belongs_to_code .= (($ibelongs_to_code!=0) ? "\t\t":"").$base_create_code;

                        if( !empty($value_relation['membuat_data']) ) {
                            $base_create_code = file_get_contents(__DIR__.'/../base/service/belongs_to_create_data.stub', FILE_USE_INCLUDE_PATH);
                            $base_create_code = str_replace('{{name_belongs_to}}',$value_relation['name'],$base_create_code);
                            $base_create_code = str_replace('{{foreign_key}}',$value_relation['foreign_key'],$base_create_code);
                            $base_create_code = str_replace('{{service_name}}',((!empty($value_relation['model_name'])) ? ucwords($value_relation['model_name']) : ucwords($value_relation['name'])),$base_create_code);
                            
                            $belongs_to_code .= (($ibelongs_to_code!=0) ? "\t\t":"").$base_create_code;
                        }

                        $ibelongs_to_code++;
                    }

                    // belongs to many create check data
                    if( $value_relation['type'] == 'belongs_to_many' )
                    {                        
                        
                        $base_create_code = file_get_contents(__DIR__.'/../base/service/belongs_to_many_create_data.stub', FILE_USE_INCLUDE_PATH);
                        $base_create_code = str_replace('{{name_belongs_to_many}}',$value_relation['name'],$base_create_code);                            
                        $base_create_code = str_replace('{{service_name}}',((!empty($value_relation['service_name'])) ? ucwords($value_relation['service_name']) : '{{service_name}}'),$base_create_code);
                        $base_create_code = str_replace('{{service_name}}',((!empty($value_relation['model_name'])) ? ucwords($value_relation['model_name']) : ucwords($value_relation['name'])),$base_create_code);
                        
                        $belongs_to_many_code .= (($ibelongs_to_many!=0) ? "\t\t":"").$base_create_code;
                        
                        $base_delete_code = file_get_contents(__DIR__.'/../base/service/belongs_to_many_delete_data.stub', FILE_USE_INCLUDE_PATH);
                        $base_delete_code = str_replace('{{name_belongs_to_many}}',$value_relation['name'],$base_delete_code);                            
                        $base_delete_code = str_replace('{{service_name}}',((!empty($value_relation['model_name'])) ? ucwords($value_relation['model_name']) : ucwords($value_relation['name'])),$base_delete_code);                        
                        
                        $belongs_to_many_delete_code .= (($ibelongs_to_many!=0) ? "\t\t":"").$base_delete_code;
                        $ibelongs_to_many++;
                    }
                }
                
                $code_function = file_get_contents(__DIR__.'/../base/service/'.$function_name, FILE_USE_INCLUDE_PATH);
                
                if( !empty($has_one_code) )
                {
                    $code_function = str_replace('// end list has one create',$has_one_code."\r\n\t\t// end list has one create",$code_function);
                }

                if( !empty($has_many_code) )
                {
                    $code_function = str_replace('// end list has many create',$has_many_code."\r\n\t\t// end list has many create",$code_function);
                }
                
                if( !empty($belongs_to_code) )
                {
                    $code_function = str_replace('// end list belongs to check create',$belongs_to_code."\r\n\t\t// end list belongs to check create",$code_function);
                }

                if( !empty($belongs_to_many_code) )
                {
                    $code_function = str_replace('// end list belongs to many create',$belongs_to_many_code."\r\n\t\t// end list belongs to many create",$code_function);
                }

                if( !empty($belongs_to_many_delete_code) )
                {
                    $code_function = str_replace('// end list belongs to many delete',$belongs_to_many_delete_code."\r\n\t\t// end list belongs to many delete",$code_function);
                }

                $code_function = str_replace('{{column}}',substr($cols_table_model, 0, -5),$code_function);
                $code_function = str_replace('{{data-validation}}',$code_data_validation,$code_function);
                $code_function = str_replace('{{data-filter}}',$code_data_filter,$code_function);
                $code_function = str_replace('{{name}}',$value['name'],$code_function);
                $code_function = str_replace('{{Name}}',UCWORDS($value['name']),$code_function);                
                $code_function = str_replace('{{Modul_name}}',UCWORDS($name),$code_function);                

                if(!empty($value['custom_function']))
                {
                    $value['custom_function'] = str_replace("\n","\n\t\t",$value['custom_function']);
                    $code_function = str_replace('// end code',$value['custom_function']."\r\n\t\t// end code",$code_function);
                }
                
                if(!empty($value['system_function']))
                {
                    $value['system_function'] = str_replace("\n","\n\t\t",$value['system_function']);
                    $code_function = str_replace('// end code',$value['system_function']."\r\n\t\t// end code",$code_function);
                }

                // check lock 
                if(!empty($value['lock']))
                {            
                    $lock_code = file_get_contents(__DIR__.'/../base/service/function_locking.stub', FILE_USE_INCLUDE_PATH);
                    $unlock_code = file_get_contents(__DIR__.'/../base/service/function_unlocking.stub', FILE_USE_INCLUDE_PATH);
                    $lock_code = str_replace('{{lock_key}}',$value['lock'],$lock_code);                
                    $code_function = str_replace('// locking function',$lock_code,$code_function);
                    $code_function = str_replace('// unlocking function',$unlock_code,$code_function);
                }

                $param = '';
                $param_function = '';
                if(!empty($value['param']))
                {
                    foreach ($value['param'] as $key_param => $value_param) {
                        if($key_param!=0) {
                            $param .= ',';
                        }
                        $param .= '$'.((!empty($value_param['name'])) ? $value_param['name']:$value_param);
                        $param_function .= ',$'.((!empty($value_param['name'])) ? $value_param['name']:$value_param)." = NULL";
                    }
                }                                

                $code_function = str_replace('{{param}}',$param,$code_function);
                $code_function = str_replace('{{param_function}}',$param_function,$code_function);
                
                $value['custom_code_before'] = (!empty($value['custom_code_before'])) ? $value['custom_code_before'] : '';
                $value['custom_code_after'] = (!empty($value['custom_code_after'])) ? $value['custom_code_after'] : '';
                
                $code_function = str_replace('{{custom_code_before}}',$value['custom_code_before'],$code_function);
                $code_function = str_replace('{{custom_code_after}}',$value['custom_code_after'],$code_function);

                $base_service = str_replace('// end list function',$code_function,$base_service);
            }            
        }

        // traits
        $traits = '';
        foreach ($traits_arr as $key_traits => $value_traits) {
            $traits .= "use ".$value_traits;
            if( !empty($traits) )
            {
                $traits .= ";\r\n\t\t\t";
            }
        }
        $base_service   = str_replace("{{traits}}",$traits,$base_service);

        FileCreator::create( $service_file_name, 'app/Http/Services', $base_service );
    }

}