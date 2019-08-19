<?php

namespace KhanCode\LaravelRestBuilder;

use Request;
use Session;
use Illuminate\Support\Facades\Hash;
use \KhanCode\LaravelRestBuilder\Models\Users;

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
     */
    public function __construct() {
        $this->setLaravelrestbuilderConnection();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function list() {                
        return view('khancode::list', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'data'  =>  [
                'tambah_modul' =>   1
            ],
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function dataList() {
        \Request::merge([
            'search' => \Request::get('search')['value'],
            'sort_column'   =>  'nomor_baris',
            'sort_type'   =>  \Request::get('order')[0]['dir'],
            ]);
                    
        $model = new \KhanCode\LaravelRestBuilder\Models\Moduls;
        
        \DB::connection( $model->connection )->statement(\DB::raw('set @nomorbaris = 0;'));
        
        $data['data'] = $model
            ->getAll()
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        return view('khancode::create', [
            'data'=>[
                'simpan_api'    =>  1
            ],
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function update($id)
    {        
        return view('khancode::create', [
            'data'  => [
                'id'    =>  $id,
                'simpan_api'    =>  1
            ],
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
        ]);
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
    public function setLaravelrestbuilderConnection()
    {
        config(['database.connections.laravelrestbuilder_mysql'   =>  config('laravelrestbuilder.database')]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function modul($id)
    {
        $data = \KhanCode\LaravelRestBuilder\Models\Moduls::getAll()
            ->where('id',$id)
            ->first();

        return $data;
    }

    /**
     * get middleware function
     *
     * @return void
     */
    public function middleware()
    {
        $kernel = (array) app()->{'Illuminate\Contracts\Http\Kernel'};
        foreach ($kernel as $key => $value) {
            $key = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $key);
            if($key == '*routeMiddleware') {
                $middleware = $value;
            }
        }

        return array_values(array_flip($middleware));
    }

    /**
     * [push description]
     * @return [type] [description]
     */
    public function build()
    {                

        $data = Request::all();

        if( !empty($data['id']) ) {
            \KhanCode\LaravelRestBuilder\Models\Moduls::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('laravelrestbuilder_mysql.moduls','name')->ignore($data['id'])
                    ],
            ]);
        }else {
            \KhanCode\LaravelRestBuilder\Models\Moduls::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('laravelrestbuilder_mysql.moduls','name')
                    ],
            ]);
        }

        $data = ColumnBuilder::build($data,'column');
        $data['name'] = camel_case($data['name']);
        if(empty($data['column_function'])) $data['column_function'] = [];
        if(empty($data['relation'])) $data['relation'] = [];
        if(empty($data['hidden'])) $data['hidden'] = [];
        
        TableBuilder::buildMigration();
        
        ControllerBuilder::build(
            $data['name'],
            $data['column'],
            $data['column_function'],
            $data['route'],
            $data['relation']
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
            $data['key'],
            $data['column'],
            $data['column_function'],
            $data['route'],
            $data['with_timestamp'],
            $data['with_authstamp'],
            $data['with_ipstamp'],
            $data['with_companystamp'],
            $data['custom_filter'],
            $data['relation'],
            $data['hidden']
        );        

        RepositoryBuilder::build(
            $data['name'],
            $data['table']
        );

        ResourceBuilder::build(
            $data['name'],
            $data['column'],
            $data['column_function'],
            $data['relation'],
            $data['hidden']
        );
        
        RouteBuilder::build(
            $data['name'],
            $data['route']
        );
        
        // $file_modul = self::getArrayFile('modul', 'storage');
        // $file_table = self::getArrayFile('table', 'storage');        

        // create list modul file
        // FileCreator::create( 'modul', 'storage', '<?php return ' . var_export([$data['name'] => array_except($data,['column'])]+$file_modul, true) . ';' );
        
        // create list table
        // FileCreator::create( 'table', 'storage', '<?php return ' . var_export([$data['table'] => $data['column']]+$file_table, true) . ';' );

        // save to moduls table
        $detail_data = json_encode( array_except($data,['column']) );

        if( !empty($data['id']) ) {

            $old_data = \KhanCode\LaravelRestBuilder\Models\Moduls::find($data['id']);
            if( $detail_data != $old_data->detail_data ) {            
                $old_data->update([
                    'name'  =>  $data['name'],
                    'detail'    =>  $detail_data,
                ]);

                \KhanCode\LaravelRestBuilder\Models\ModulHistories::create([
                    'name'  =>  $data['name'],
                    'detail'    =>  $detail_data,
                    'modul_id'  =>  $data['id'],
                ]);
            }
        }else {
            $modul = \KhanCode\LaravelRestBuilder\Models\Moduls::create([
                'name'  =>  $data['name'],
                'detail'    =>  $detail_data,
            ]);

            $data['id'] = $modul->id;
        }
        
        // save new file to files table
        if( !empty(config('laravelrestbuilder.file.created')) ) {
            foreach (config('laravelrestbuilder.file.created') as $key => $value) {
                \KhanCode\LaravelRestBuilder\Models\ModulFiles::create([
                    'name'  =>  $value,
                    'modul_id'    =>  $data['id'],
                ]);             
            }
        }

        return [
            'data'  =>  \KhanCode\LaravelRestBuilder\Models\Moduls::find($data['id'])
        ]+config('laravelrestbuilder.file');
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