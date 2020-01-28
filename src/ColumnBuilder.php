<?php

namespace KhanCode\LaravelRestBuilder;

class ColumnBuilder
{

    /**
     * Column builder function
     *
     * @param [type] $data
     * @param [type] $key_arr
     * @return void
     */
    static function build( $data, $key_arr )
    {
        // remove kolom yg berada di forbidden
        $has_company_stamp = 0;
        
        if( empty($data[$key_arr]) ) {
            $data['column'] = [];
            return $data;
        }

        foreach ($data[$key_arr] as $key => $value) {
            if( !empty(LaravelRestBuilder::$forbidden_column_name[$value['name']]) ) {
                unset($data[$key_arr][$key]);
            }
            if( $value['name'] == 'com_id' ) {
                $has_company_stamp = 1;
            }
        }

        if(!empty($data['with_companystamp']))
        {        
            if( $data['with_companystamp'] == 1 && empty($has_company_stamp) )
            {   
                array_splice( $data[$key_arr], 1, 0, [
                    [
                        "name"  =>  "com_id",
                        "type"  =>  "integer",
                    ] 
                ]);                 
            }
        }

        if(!empty($data['with_timestamp']))
        {
            if( $data['with_timestamp'] == 1 )
            {
                $data[$key_arr] = array_merge($data[$key_arr],[
                    [
                        "name"  =>  "created_time",
                        "type"  =>  "timestamp",
                        "default"   =>  'CURRENT_TIMESTAMP',
                        "nullable"   =>  0
                    ],
                    [
                        "name"  =>  "modified_time",
                        "type"  =>  "timestamp",
                        "nullable"   =>  1
                    ],
                    [
                        "name"  =>  "deleted_time",
                        "type"  =>  "timestamp",
                        "nullable"   =>  1
                    ],
                ]);            
            }
        }

        if(!empty($data['with_authstamp']))
        {
            if( $data['with_authstamp'] == 1 )
            {
                $data[$key_arr] = array_merge($data[$key_arr],[
                    [
                        "name"  =>  "created_by",
                        "type"  =>  "string",
                        "nullable"   =>  1
                    ],
                    [
                        "name"  =>  "modified_by",
                        "type"  =>  "string",
                        "nullable"   =>  1
                    ],
                    [
                        "name"  =>  "deleted_by",
                        "type"  =>  "string",
                        "nullable"   =>  1
                    ],
                ]);
            }
        }

        if(!empty($data['with_ipstamp']))
        {
            if( $data['with_ipstamp'] == 1 )
            {
                $data[$key_arr] = array_merge($data[$key_arr],[
                    [
                        "name"  =>  "created_from",
                        "type"  =>  "string",
                        "nullable"   =>  1
                    ],
                    [
                        "name"  =>  "modified_from",
                        "type"  =>  "string",
                        "nullable"   =>  1
                    ],
                    [
                        "name"  =>  "deleted_from",
                        "type"  =>  "string",
                        "nullable"   =>  1
                    ],
                ]);
            }
        }
        
        $data['list_index'] = empty($data['list_index']) ? [] : $data['list_index'];
        
        return $data;
    }
}
