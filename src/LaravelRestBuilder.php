<?php

namespace KhanCode\LaravelRestBuilder;

use Request;

class LaravelRestBuilder
{
    static $forbidden_column_name = [
        "com_id"    => 'com_id',
        "created_time"  => 'created_time',
        "modified_time" => 'modified_time',
        "deleted_time"  => 'deleted_time',
        "created_by"    => 'created_by',
        "modified_by"   => 'modified_by',
        "deleted_by"    => 'deleted_by',
        "created_from"  => 'created_from',
        "modified_from" => 'modified_from',
        "deleted_from"  => 'deleted_from',
    ];
    
    static $forbidden_column_name_for_service = [
        "id"    => 'id',
        "com_id"    => 'com_id',
        "created_time"  => 'created_time',
        "modified_time" => 'modified_time',
        "deleted_time"  => 'deleted_time',
        "created_by"    => 'created_by',
        "modified_by"   => 'modified_by',
        "deleted_by"    => 'deleted_by',
        "created_from"  => 'created_from',
        "modified_from" => 'modified_from',
        "deleted_from"  => 'deleted_from',
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        return view('khancode::create', []);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function table()
    {
        $table = MigrationBuilder::getColumnExist(Request::get('table'));
        return $table+['forbidden_column_name'=>self::$forbidden_column_name];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function modul()
    {
        return self::getArrayFile('modul', 'storage');
    }

    /**
     * [push description]
     * @return [type] [description]
     */
    public function build()
    {
        $data = Request::all();        
        $data = ColumnBuilder::build($data,'column');
        $data['name'] = camel_case($data['name']);
        if(empty($data['column_function'])) $data['column_function'] = [];
        if(empty($data['relation'])) $data['relation'] = [];
        
        MigrationBuilder::build(
            $data['name'],
            $data['table'],
            $data['column']         
        );
        
        ControllerBuilder::build(
            $data['name'],
            $data['column'],
            $data['column_function'],
            $data['route']
        );
        
        ServiceBuilder::build(
            $data['name'],
            $data['table'],
            $data['column'],
            $data['route'],
            $data['relation']
        );
        
        ModelBuilder::build(
            $data['name'],
            $data['table'],
            $data['column'],
            $data['column_function'],
            $data['route'],
            $data['with_timestamp'],
            $data['with_authstamp'],
            $data['with_ipstamp'],
            $data['with_companystamp'],
            $data['relation']
        );        

        RepositoryBuilder::build(
            $data['name'],
            $data['table']
        );

        ResourceBuilder::build(
            $data['name'],
            $data['column'],
            $data['column_function'],
            $data['relation']
        );
        
        RouteBuilder::build(
            $data['name'],
            $data['route']
        );
        
        $file_modul = self::getArrayFile('modul', 'storage');
        $file_table = self::getArrayFile('table', 'storage');

        // create list modul file
        FileCreator::create( 'modul', 'storage', '<?php return ' . var_export([$data['name'] => array_except($data,['column'])]+$file_modul, true) . ';' );
        
        // create list table
        FileCreator::create( 'table', 'storage', '<?php return ' . var_export([$data['table'] => $data['column']]+$file_table, true) . ';' );

        return config('laravelrestbuilder.file');
    }

    /**
     * get Array File
     *
     * @param [type] $name_file
     * @param [type] $folder
     * @return void
     */
    static function getArrayFile( $name_file, $folder )
    {
        if (file_exists(base_path()."/".$folder."/".$name_file.".php")) 
            return include(base_path()."/".$folder."/".$name_file.".php");

        return [];
    }
}