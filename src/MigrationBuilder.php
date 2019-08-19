<?php

namespace KhanCode\LaravelRestBuilder;

use Illuminate\Support\Facades\Schema;
use KhanCode\LaravelRestBuilder\Models\SystemTables;

class MigrationBuilder
{    

    /**
     * create migration
     *
     * @param [type] $name
     * @param [type] $table
     * @param array $column
     * @param [type] $with_timestamp
     * @param [type] $with_authstamp
     * @param [type] $with_ipstamp
     * @return void
     */
    static function build( $name, $table, array $column )
    {
        $table_exist = SystemTables::where('name',$table)->first();

        if( $table_exist == NULL ) {
            // create new table
            SystemTables::create([
                'name'  =>  $table
            ])->id;
        }

        // jika table belum di buat
        if( !Schema::hasTable($table) )
        {
            $migration_file_name = date('Y_m_d_His').'_create_'.$name.'_table'.date('His');
            $migration_class_name = ucfirst(camel_case('create_'.$name.'_table'.date('His')));
            $base_migration = file_get_contents(__DIR__.'/../base/migration/migration.php', FILE_USE_INCLUDE_PATH);

            $base_migration = str_replace('{{migration_name}}',$migration_class_name,$base_migration);
            $base_migration = str_replace('{{table}}',$table,$base_migration);

            $code_column_text = self::generateMigrationColumn($column);
            $base_migration = str_replace('// end list column',$code_column_text."\t\t\t// end list column",$base_migration);
        }
        // jika table sudah di buat
        else
        {
            // check perbedaan nya antara table yg akan di tambahkan
            $check_for_add_column = [];
            $check_for_change_column = [];
            $column_exist = [];
            foreach ($column as $key_column => $value_column) {
                $column_check = self::checkColumnExist($value_column,$table);                
                if(!$column_check) {
                    if( $key_column != 0 ) {
                        $value_column['after'] = $column[$key_column-1]['name'];
                    }
                    $check_for_add_column[] = $value_column;
                }
                else
                {
                    $column_exist[] = $column_check[0]->COLUMN_NAME;                                        
                    $list_column_var[] = $value_column;                    
                }
            }

            // cek kolom yg berubah
            foreach ($list_column_var as $key_column => $value_column) {                
                $column_check_change = self::checkColumnChange($value_column,$table);
                if(!$column_check_change) {
                    if( !empty($list_column_var[$key_column-1]) ) $value_column['after'] = $list_column_var[$key_column-1]['name'];
                    $check_for_change_column[] = $value_column;
                }
            }            
            
            // check perbedaan nya antara table yg akan di drop            
            $check_for_drop_column = self::checkColumnForDrop($column_exist,$table);         
            
            // check for change to timestamp, dbal laravel not supported
            // The following column types can not be "changed": 
            // char, double, enum, mediumInteger, timestamp, tinyInteger, ipAddress, json, jsonb, macAddress, mediumIncrements, morphs, nullableMorphs, nullableTimestamps, softDeletes, timeTz, timestampTz, timestamps, timestampsTz, unsignedMediumInteger, unsignedTinyInteger, uuid.
            $unableChanged = [
                "char",
                "double",
                "enum",
                "mediumInteger",
                "timestamp",
                "tinyInteger",
                "ipAddress",
                "json",
                "jsonb",
                "macAddress",
                "mediumIncrements",
                "morphs",
                "nullableMorphs",
                "nullableTimestamps",
                "softDeletes",
                "timeTz",
                "timestampTz",
                "timestamps",
                "timestampsTz",
                "unsignedMediumInteger",
                "unsignedTinyInteger",
                "uuid",
            ];
            $unableChanged = array_flip($unableChanged);
            foreach ($check_for_change_column as $key_check_for_change_column => $value_check_for_change_column) {
                if( !empty($unableChanged[$value_check_for_change_column['type']]) ) {
                    $check_for_drop_column[] = $value_check_for_change_column;
                    unset($check_for_change_column[$key_check_for_change_column]);
                    $check_for_add_column[] = $value_check_for_change_column;
                }
            }

            // excute for build
            if( !empty($check_for_drop_column) || !empty($check_for_add_column) || !empty($check_for_change_column) )
            {
                $migration_file_name = date('Y_m_d_His').'_update_'.$name.'_table'.date('His');
                $migration_class_name = ucfirst(camel_case('update_'.$name.'_table'.date('His')));
                $base_migration = file_get_contents(__DIR__.'/../base/migration/update_migration.php', FILE_USE_INCLUDE_PATH);
                $base_migration = str_replace('{{migration_name}}',$migration_class_name,$base_migration);
                $base_migration = str_replace('{{table}}',$table,$base_migration);
                
                $code_column_drop_text = '';
                $code_column_drop = file_get_contents(__DIR__.'/../base/migration/drop_column.php', FILE_USE_INCLUDE_PATH);
                
                if(!empty($check_for_drop_column))
                {
                    foreach ($check_for_drop_column as $key => $value) {
                        $code_column_for_drop = str_replace('{{name}}',$value['name'],$code_column_drop);
                        $code_column_drop_text .= (($key != 0) ? "\t\t\t":"").$code_column_for_drop.(($key != (count($column)+1)) ? "\r\n":"");
                    }
                    
                    $base_migration = str_replace('// end list droped column',$code_column_drop_text."\t\t\t// end list droped column",$base_migration);
                }
                
                $code_column_text = '';
                if( !empty($check_for_change_column) ) {
                    $code_column_text .= self::generateMigrationColumn($check_for_change_column,'alter');
                }
                $code_column_text .= self::generateMigrationColumn($check_for_add_column,'add'); 

                // if(count($check_for_change_column)+count($check_for_add_column) > 1) {
                //     $code_column_text .= "\t\t\t";
                // }
                
                if(!empty($code_column_text)) $base_migration = str_replace('// end list new column',$code_column_text."\t\t\t// end list new column",$base_migration);
            }
        }
        
        if(!empty($base_migration))
        {            
            // create migration file
            return FileCreator::create( $migration_file_name, 'database/migrations', $base_migration, 'migration' );
        }
    }

    /**
     * checkColumnForDrop function
     *
     * @param [type] $column_exist
     * @param [type] $table
     * @return void
     */
    static function checkColumnForDrop( $column_exist, $table )
    {
        $check = \DB::select( \DB::raw('
                                    SELECT *
                                    FROM INFORMATION_SCHEMA.COLUMNS
                                    where TABLE_SCHEMA=\''.env('DB_DATABASE').'\'
                                    AND column_name not in ("'.implode('","',$column_exist).'")
                                    AND table_name = \''.$table.'\''
                                ));
        
        $return = [];
        if(!empty($check))
        {            
            foreach ($check as $check_key => $check_value) {
                $return[]  = [
                    'name' => $check_value->COLUMN_NAME
                ];
            }
        }

        return $return;
    }

    /**
     * checkColumnExist function
     *
     * @param [type] $column
     * @param [type] $table
     * @return void
     */
    static function checkColumnExist( $column, $table )
    {
        $check = \DB::select( \DB::raw('
                                    SELECT *
                                    FROM INFORMATION_SCHEMA.COLUMNS
                                    where TABLE_SCHEMA=\''.env('DB_DATABASE').'\'
                                    AND column_name = \''.$column['name'].'\'
                                    AND table_name = \''.$table.'\''
                                ));

        if(empty($check)) return false;

        return $check;
    }

    /**
     * check Column Change function
     *
     * @param [type] $column
     * @param [type] $table
     * @return void
     */
    static function checkColumnChange( $column, $table )
    {
        if(empty($column['type']))
        {
            throw new \Exception('data type for column'.$column['name'].' does not avilable yet');
        }

        $where = '';
        if($column['type'] == 'increment'){
            $where .= ' and extra = "auto_increment" ';
        }
        if ($column['type'] == 'integer') {
            $where .= ' and data_type = "int" ';
        }
        if ($column['type'] == 'smallInteger') {
            $where .= ' and data_type = "smallint" ';
        }
        if ($column['type'] == 'tinyInteger') {
            $where .= ' and data_type = "tinyInt" ';
        }
        if ($column['type'] == 'string') {
            $where .= ' and data_type = "varchar" ';
        }
        if ($column['type'] == 'datetime') {
            $where .= ' and data_type = "datetime" ';
        }
        if ($column['type'] == 'timestamp') {
            $where .= ' and data_type = "timestamp" ';
        }
        if ($column['type'] == 'decimal') {
            $where .= ' and data_type = "decimal" ';
        }
        if ($column['type'] == 'char') {
            $where .= ' and data_type = "char" ';
        }
        if ($column['type'] == 'text') {
            $where .= ' and data_type = "text" ';
        }
        if ($column['type'] == 'time') {
            $where .= ' and data_type = "time" ';
        }
        if ($column['type'] == 'bigint') {
            $where .= ' and data_type = "bigint" ';
        }
        if ($column['type'] == 'date') {
            $where .= ' and data_type = "date" ';
        }
        
        if(empty($where))
        {
            throw new \Exception('data type '.$column['type'].' does not avilable yet');
        }

        // untuk increment tidak mungkin null dan default tidak ada
        if( $column['type'] != 'increment' ) {
            if ( !empty($column['nullable']) ) {
                $where .= ' and is_nullable = "YES" ';
            }else {
                $where .= ' and is_nullable = "NO" ';
            }
            
            if ( isset($column['default']) ) {
                if( strtolower($column['default']) == 'null')
                {
                    $where .= ' and column_default is NULL ';
                }else {
                    $where .= ' and column_default = "'.$column['default'].'" ';
                }
            }else {
                $where .= ' and column_default is null ';
            }
        }

        if ( !empty($column['comment']) ) {
            $where .= ' and column_comment = "'.$column['comment'].'" ';
        }else {
            $where .= ' and column_comment = "" ';
        }

        $check = \DB::select( \DB::raw('
                                    SELECT *
                                    FROM INFORMATION_SCHEMA.COLUMNS
                                    where TABLE_SCHEMA=\''.env('DB_DATABASE').'\'
                                    AND column_name = \''.$column['name'].'\'
                                    AND table_name = \''.$table.'\''.$where
                                ));

        if(empty($check)) return false;

        return $check;
    }

    /**
     * generate Migration Column function
     *
     * @param [type] $column
     * @param string $migration_type
     * @return void
     */
    static function generateMigrationColumn($column,$migration_type = 'create')
    {
        $list_file = scandir(__DIR__.'/../base/migration', SCANDIR_SORT_DESCENDING);
        $code_column_text = '';
        
        foreach ($column as $key => $value) {
            $file_name_column = 'column_'.$value['type'].'.php';            
            if(in_array($file_name_column,$list_file))
            {
                $code_column = file_get_contents(__DIR__.'/../base/migration/'.$file_name_column, FILE_USE_INCLUDE_PATH);
                $code_column = str_replace('{{name}}',$value['name'],$code_column);
                
                if($value['type'] == 'decimal')
                {
                    $code_column = str_replace('{{precision}}',(empty($value['precision']) ? 8:$value['precision']),$code_column);
                    $code_column = str_replace('{{scale}}',(empty($value['scale']) ? 2:$value['scale']),$code_column);
                }   
                
                // untuk increment tidak mungkin null dan default tidak ada
                if($value['type'] != 'increment') {
                    if(!empty($value['nullable'])) {
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->nullable();',$code_column);
                    }else {
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->nullable(false);',$code_column);
                    }

                    $value['default'] = isset($value['default']) ? $value['default'] : "null";
                }
                $value['comment'] = isset($value['comment']) ? $value['comment'] : "null";

                // utk increment tidak ada default
                if($value['type'] != 'increment') {
                    if(strtolower($value['default'])=='null') {
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->default(NULL);',$code_column);
                    }else {
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->default(\DB::raw("'.$value['default'].'"));',$code_column);
                    }
                }

                if(strtolower($value['comment'])=='null') {
                    $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->comment(NULL);',$code_column);
                }else {
                    $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->comment(\DB::raw("'.$value['comment'].'"));',$code_column);
                }

                if($migration_type == 'alter') {
                    if($value['type'] != 'timestamp') {                        
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->change();',$code_column);
                    }
                }
                
                if($migration_type == 'add') {
                    if(!empty($value['after'])) {
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->after("'.$value['after'].'");',$code_column);
                    }else {
                        $code_column = Helper::str_lreplace(';',"\r\n\t\t\t\t".'->first();',$code_column);
                    }
                }
                $code_column_text .= (($key > 0) ? "\t\t\t":"").$code_column.(($key != (count($column)+1)) ? "\r\n":"");
            }
            else {
                throw new DataEmptyException('File '.$value['type'].' Type tidak di temukan');
            }
        }

        return $code_column_text;
    }

    /**
     * getColumnExist function
     *
     * @param [type] $table
     * @return void
     */
    static function getColumnExist( $table )
    {
        $check = \DB::select( \DB::raw('
                                    SELECT *,CONVERT(cast(CONVERT(column_comment USING latin1) AS BINARY) USING utf8) as column_comment
                                    FROM INFORMATION_SCHEMA.COLUMNS
                                    where TABLE_SCHEMA=\''.env('DB_DATABASE').'\'
                                    AND table_name = \''.$table.'\'
                                    order by ORDINAL_POSITION ASC'
                                ));

        if(empty($check)) return [];
        
        $return = [];
        $return[$table] = [];        
        foreach ($check as $key => $value) {
            
            // get type
            if($value->EXTRA == 'auto_increment') {
               $type = 'increment'; 
            }else if ($value->DATA_TYPE == 'int') {
                $type = "integer";
            }else if ($value->DATA_TYPE == 'smallint') {
                $type = "smallInteger";
            }else if ($value->DATA_TYPE == 'varchar') {
                $type = "string";
            }else if ($value->DATA_TYPE == 'datetime') {
                $type = "datetime";
            }else if ($value->DATA_TYPE == 'timestamp') {
                $type = "timestamp";
            }else if ($value->DATA_TYPE == 'decimal') {
                $type = "decimal";
            }else if ($value->DATA_TYPE == 'char') {
                $type = "char";
            }else if ($value->DATA_TYPE == 'tinyint') {
                $type = "tinyInteger";
            }else if ($value->DATA_TYPE == 'text') {
                $type = "text";
            }else if ($value->DATA_TYPE == 'time') {
                $type = "time";
            }else if ($value->DATA_TYPE == 'bigint') {
                $type = "bigint";
            }else if ($value->DATA_TYPE == 'date') {
                $type = "date";
            }else {
                $type = "unidentified (".$value->DATA_TYPE.")";
            }

            // get default
            if ( $value->IS_NULLABLE == 'YES' ) {
                $nullable = 1;
            }else {
                $nullable = 0;
            }
            
            $return[$table][] = [
                'name' => $value->COLUMN_NAME,
                'type' => $type,
                'default' => $value->COLUMN_DEFAULT,
                'comment' => $value->COLUMN_COMMENT,
                'nullable' => $nullable,
                'precision' => $value->NUMERIC_PRECISION,
                'scale' => $value->NUMERIC_SCALE,
            ];
        }
        return $return;
    }

    /**
     * redorder column
     *
     * @param array $column
     * @param [type] $table
     * @return void
     */
    static function reorderColumn(array $column,$table) {

        $nowHis = date('His');
        $migration_file_name = date('Y_m_d_His').'_reorder_'.$table.'_table'.$nowHis;
        $migration_class_name = ucfirst(camel_case('reorder_'.$table.'_table'.$nowHis));
        $base_migration = file_get_contents(__DIR__.'/../base/migration/reorder_migration.php', FILE_USE_INCLUDE_PATH);
        $base_migration = str_replace('{{migration_name}}',$migration_class_name,$base_migration);

        $templatesQueryRaw = "\DB::statement(\"ALTER TABLE {{table}} MODIFY {{column}} {{type}} {{null}} {{extra}} {{default}} {{ordinal_position}}\");\n";
        
        $queryResult = "";
        $same_order = true;
        foreach ($column as $key => $value) {
            $dataColumn = \DB::select( \DB::raw('
                SELECT *,CONVERT(cast(CONVERT(column_comment USING latin1) AS BINARY) USING utf8) as column_comment
                FROM INFORMATION_SCHEMA.COLUMNS
                where TABLE_SCHEMA=\''.env('DB_DATABASE').'\'
                AND table_name = \''.$table.'\'
                AND column_name = \''.$value['name'].'\''
            ));

            if( empty($dataColumn[0]) ) {
                return;
            }

            if($key+1 != $dataColumn[0]->ORDINAL_POSITION) {
                $same_order = false;
            }

            $type = $dataColumn[0]->COLUMN_TYPE;
            
            $default = "default NULL";
            if( !empty($dataColumn[0]->COLUMN_DEFAULT) ) {
                $allowed_string = [
                    "CURRENT_USER",
                    "CURRENT_TIME",
                    "CURRENT_TIMESTAMP",
                    "CURRENT_DATE",
                    "CURTIME",
                ];
                $allowed_string = array_flip($allowed_string);
                if( !is_float($dataColumn[0]->COLUMN_DEFAULT) && 
                    !is_numeric($dataColumn[0]->COLUMN_DEFAULT) && 
                    !is_int($dataColumn[0]->COLUMN_DEFAULT) && 
                    empty($allowed_string[$dataColumn[0]->COLUMN_DEFAULT]) 
                ) {
                    $dataColumn[0]->COLUMN_DEFAULT = "'".$dataColumn[0]->COLUMN_DEFAULT."'";
                }
                $default = "default ".$dataColumn[0]->COLUMN_DEFAULT;
            }

            $null = "NULL";
            if( $dataColumn[0]->IS_NULLABLE == 'NO' ) {
                $null = "NOT NULL";                
            }

            if( $null == "NOT NULL" && $default == "default NULL") {
                $default = "";
            }

            $extra = $dataColumn[0]->EXTRA;
            
            if($key == 0) {
                $ordinal_position = 'FIRST';
            }else {
                $ordinal_position = 'AFTER '.$column[$key-1]['name'];
            }

            $queryResult = str_replace([
                "{{table}}",
                "{{column}}",
                "{{type}}",
                "{{null}}",
                "{{extra}}",
                "{{default}}",
                "{{ordinal_position}}",
            ],
            [
                $table,
                $value['name'],
                $type,
                $null,
                $extra,
                $default,
                $ordinal_position,
            ],$templatesQueryRaw);

            $base_migration = str_replace('// end DB Statement',$queryResult."\t\t// end DB Statement",$base_migration);
        }
        
        // create reorder jika beda
        if( !$same_order ) {
            
            // create migration file
            return FileCreator::create( $migration_file_name, 'database/migrations', $base_migration, 'migration' );
        }
                
    }
}
