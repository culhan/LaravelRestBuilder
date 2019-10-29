<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Hash;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelRestBuilder\Models\SystemTables;
use KhanCode\LaravelRestBuilder\Models\MigrationFiles;

class TableBuilder
{
    /**
     * Undocumented function
     *
     * @return void
     */
    static function buildMigration() 
    {
        DB::beginTransaction();

        $data = Request::all();        
        $data = ColumnBuilder::build($data,'column');
        $data['name'] = camel_case($data['table']);
        
        $return = MigrationBuilder::build( $data['name'], $data['table'], $data['column'], $data['list_index'] );

        $data_system_table = SystemTables::where('name',$data['table'])->first();
        if(empty($data_system_table)) {
            $data_system_table = SystemTables::create([
                'name'  =>  $data['table']
            ]);
        }

        $data['id'] = $data_system_table->id;

        // hanya akan migrate 1
        if( !empty($return) ) {
            MigrationFiles::create([
                'name'  =>  $return['migration'][0],
                'system_table_id'   =>  $data['id'],
                'column'    =>  json_encode($data['column']),
            ]);
        }

        LaravelRestBuilder::setLaravelrestbuilderConnection();
        if( !empty(config('laravelrestbuilder.copy_to')) ) {
            $migration_result = \Artisan::call('migrate',['--path' => config('laravelrestbuilder.copy_to').'/database/migrations','--force' => true]);
        }else {
            $migration_result = \Artisan::call('migrate',['--force' => true]);
        }        

        // reorder column, use manual query generator
        $reorder = MigrationBuilder::reorderColumn( $data['column'], $data['table'] );
        LaravelRestBuilder::setDefaultLaravelrestbuilderConnection();

        // hanya akan migrate 1
        if( !empty($reorder) ) {            
            $return = $reorder;
            MigrationFiles::create([
                'name'  =>  $reorder['migration'][0],
                'system_table_id'   =>  $data['id'],
                'column'    =>  json_encode($data['column']),
            ]);
        }
        
        LaravelRestBuilder::setLaravelrestbuilderConnection();
        if( !empty(config('laravelrestbuilder.copy_to')) ) {
            $migration_result = \Artisan::call('migrate',['--path' => config('laravelrestbuilder.copy_to').'/database/migrations','--force' => true]);
        }else {
            $migration_result = \Artisan::call('migrate',['--force' => true]);
        }
        LaravelRestBuilder::setDefaultLaravelrestbuilderConnection();
        
        DB::commit();
        
        return $return;            
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function updateTable($id) 
    {        
        return view('khancode::createTable', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::get(),
            'data'=>[
                'simpan_api'    =>  1,                
            ]+SystemTables::find($id)->toArray()
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function createTable() 
    {
        return view('khancode::createTable', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::get(),
            'data'=>[
                'simpan_api'    =>  1
            ],
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function listTable() 
    {
        return view('khancode::listTable', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::get(),
            'data'=>[
                'tambah_tabel'    =>  1
            ],
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function systemTable()
    {   
        \Request::merge([
            'search' => \Request::get('search')['value'],
            'sort_column'   =>  'nomor_baris',
            'sort_type'   =>  \Request::get('order')[0]['dir'],
            ]);
                    
        $model = new SystemTables;
        
        \DB::connection( $model->connection )->statement(\DB::raw('set @nomorbaris = 0;'));
        
        $data['data'] = $model
            ->select('*')
            ->addSelect([
                \DB::raw('@nomorbaris := @nomorbaris+1 as nomor_baris'),
            ])
            ->setSortableAndSearchableColumn([
                'id'    =>  'id',
                'name'  =>  'name',
                'nomor_baris'   =>  'nomor_baris',
                ])
            ->search()
            ->sort()
            ->distinct()
            ->take(request('length'))            
            ->skip(request('start'))
            ->get();
        
        $data['draw'] = request('draw');
        $data['recordsTotal'] = $model->count();
        $data['recordsFiltered'] = $model
            ->setSortableAndSearchableColumn(['name'=>'name'])
            ->search()            
            ->count();

        return $data;
        
    }
}