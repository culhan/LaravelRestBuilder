<?php
namespace KhanCode\LaravelRestBuilder;

use Arr;
use Request;
use Session;
use Illuminate\Support\Facades\Hash;
use KhanCode\LaravelRestBuilder\Models\Users;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelBaseRest\Helpers;
use KhanCode\LaravelRestBuilder\Gobuilder\ModelBuilder as GoModelBuilder;
use KhanCode\LaravelRestBuilder\Gobuilder\RepositoryBuilder as GoRepositoryBuilder;
use KhanCode\LaravelRestBuilder\Gobuilder\ResourceBuilder as GoResourceBuilder;
use KhanCode\LaravelRestBuilder\Gobuilder\ControllerBuilder as GoControllerBuilder;
use KhanCode\LaravelRestBuilder\Gobuilder\ServiceBuilder as GoServiceBuilder;
use KhanCode\LaravelRestBuilder\Gobuilder\RouteBuilder as GoRouteBuilder;
use KhanCode\LaravelBaseRest\ValidationException;

class LaravelRestBuilder
{
    static $forbidden_column_name = [
        // "com_id"    => 'com_id',
        // "created_time"  => 'created_time',
        // "modified_time" => 'modified_time',
        // "deleted_time"  => 'deleted_time',
        // "created_by"    => 'created_by',
        // "modified_by"   => 'modified_by',
        // "deleted_by"    => 'deleted_by',
        // "created_from"  => 'created_from',
        // "modified_from" => 'modified_from',
        // "deleted_from"  => 'deleted_from',
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
        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function list() {                
        return view('khancode::list', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
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
        
        ProjectBuilder::setProjectSession();
        
        \Request::merge([
                'search' => \Request::get('search')['value'],
                'sort_column'   =>  \Request::get('order')[0]['column'],
                'sort_type'   =>  \Request::get('order')[0]['dir'],
            ]);
        
        $column_mapping = [
            'id',
            'name',
        ];

        if( isset($column_mapping[\Request::get('sort_column')]) ){
            \Request::merge(['sort_column'  => $column_mapping[\Request::get('sort_column')]]);
        }
            
        $model = new \KhanCode\LaravelRestBuilder\Models\Moduls;

        $model->validate(request()->all(),[
                'start' => [
                        'numeric',
                    ],
            ]);
        
        \DB::connection( $model->connection )->statement(\DB::raw('set @nomorbaris = '.request('start').';'));
        
        $data['data'] = $model
            ->getAll()
            ->addSelect([
                \DB::raw('@nomorbaris := @nomorbaris+1 as nomor_baris'),
                // \DB::raw('ROW_NUMBER() OVER (order BY '.\Request::get('sort_column').' '.\Request::get('sort_type').') as nomor_baris')
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
        $data['recordsTotal'] = $model->getAll()->count();
        $data['recordsFiltered'] = $model
            ->getAll()
            ->setSortableAndSearchableColumn(['name'=>'name'])
            ->search()            
            ->count();

        return $data;
    }

    /** 
     * 
     */
    public function getFileFolder($folder, $level = 0)
    {
        if( session('project')['lang'] == 'php' ){
            $models = [];
            $select2_data = [];

            $dir = "";
            if( empty($level) ){
                $dir = app_path().'/../../'.session('project')['folder'].'/app/';
            }
            $files = scandir($dir.$folder.'/');
            $namespace = "\App\\".$folder."\\";
            foreach($files as $file) {

                $file_path = $dir.$folder.'/'.$file;
                if( $file != '.' && $file != '..' ){
                    if( is_dir($file_path)){
                        $return_from_dir = $this->getFileFolder($file_path, $level+1);
                        $models = array_merge($models, $return_from_dir['models']);
                        $select2_data = array_merge($select2_data, $return_from_dir['select2_data']);
                    }
                }
                
                //skip current and parent folder entries and non-php files
                if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)){
                    continue;
                }else{
                    
                    if (strpos(strtolower($namespace), 'model') !== false) {
                        
                        $select2_data[] = [
                            'id'    => preg_replace('/.php$/', '', $file),
                            'text'  => preg_replace('/.php$/', '', $file)
                        ];
                    }

                    $namespace = str_replace( [
                        app_path().'/../../'.session('project')['folder'].'/app/',
                        '/',
                        'Api\\',
                        'v1\\',
                    ],[
                        '',
                        '\\',
                        '',
                        '',
                    ], $namespace);

                    $models[] = $namespace . str_replace("/", "\\", (preg_replace('/.php$/', '', $file)));
                }
            }
        }else if( session('project')['lang'] == 'go' ){
            $models[] = "strconv";
            $models[] = "olsera.com/kikota/exceptions";

            $dir = app_path().'/../../'.session('project')['folder'].'/app/';

            $files = [];
            $select2_data = [];
            if( file_exists($dir.'models/') ){
                $files = scandir($dir.'models/');
            }            

            $namespace = '';
            foreach($files as $file) {
                //skip current and parent folder entries and non-php files
                if ($file == '.' || $file == '..' || !preg_match('/.go/', $file)) continue;
                    $models[] = $namespace . preg_replace('/.go$/', '', $file);
                    
                    $select2_data[] = [
                        'id'    => preg_replace('/.go$/', '', $file),
                        'text'  => preg_replace('/.go$/', '', $file)
                    ];
            }
        }

        return [
            'models'    => $models,
            'select2_data'  => $select2_data,
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        $mapping_file_folder = $this->getFileFolder('Http');

        return view('khancode::create', [
            'data'=>[
                'simpan_api'    =>  1
            ],
            'models'    => $mapping_file_folder['models'],
            'select2_data'    => $mapping_file_folder['select2_data'],
            'projects'   =>  Projects::userData()->get(),
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
        $mapping_file_folder = $this->getFileFolder('Http');

        return view('khancode::create', [
            'data'  => [
                'id'    =>  $id,
                'simpan_api'    =>  1
            ],
            'models'    => $mapping_file_folder['models'],
            'select2_data'    => $mapping_file_folder['select2_data'],
            'projects'   =>  Projects::userData()->get(),
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function table($tab_name = '')
    {        
        // set external db
        self::setLaravelrestbuilderConnection();

        $table_name = Request::get('table',$tab_name);

        if (str_contains($table_name, ' ')) { 
            return [
                    'column'    => [],
                    'forbidden_column_name' => [],
            ];
        }

        $table = MigrationBuilder::getColumnExist($table_name);
        $table['column'] = isset($table[$table_name]) ? $table[$table_name]:[];
        $index = MigrationBuilder::getIndexExist($table_name);
        return $index+$table+['forbidden_column_name'=>self::$forbidden_column_name];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function setLaravelrestbuilderConnection()
    {            
        
        config([
            'database.connections.mysql'   =>  [
                'driver' => 'mysql',
                'host' => Arr::get(session('project'),'db_host','localhost'),
                'port' => Arr::get(session('project'),'db_port','3306'),
                'database' => Arr::get(session('project'),'db_name',env('DB_DATABASE')),
                'username' => Arr::get(session('project'),'db_username',env('DB_DATABASE')),
                'password' => Arr::get(session('project'),'db_password',env('DB_DATABASE')),
                'unix_socket' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => false,
                'engine' => null,
            ],
            'laravelRestBuilder.base'    =>  (Arr::get(session('project'),'base_version',NULL) != NULL) ? '-'.Arr::get(session('project'),'base_version'):NULL,
            'laravelRestBuilder.mysql_version'    =>  !empty(Arr::get(session('project'),'mysql_version',NULL)) ? Arr::get(session('project'),'mysql_version'):NULL,
        ]);
        
        \DB::purge('mysql');
        \DB::reconnect('mysql');        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static function setDefaultLaravelrestbuilderConnection()
    {            
        config(['database.connections.mysql'   =>  [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => env('DB_STRICT', true),
            'engine' => null,
            'options' => array_filter([
                \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]),
        ] 
        ]);
        
        \DB::purge('mysql');
        \DB::reconnect('mysql');        
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

        // if(empty($data)){
        //     return [];
        // }

        $detail = json_decode($data->detail);    
        
        $files = \KhanCode\LaravelRestBuilder\Models\ModulFiles::getAll()
                        ->select([
                            'id',
                            // 'code',
                            'name'
                        ])
                        ->where('modul_id',$data['id'])
                        ->get();

        return ($data->toArray())+[
            'table' => ($detail->table??''),
            'files' => $files
        ];
    }

    /**
     * modulFile function
     *
     * @return void
     */
    public function modulFile($id)
    {
        return \KhanCode\LaravelRestBuilder\Models\ModulFiles::getAll()
                        ->select([
                            'id',
                            'code',
                            'name'
                        ])
                        ->where('id',$id)
                        ->firstOrFail();
    }

    /**
     * get middleware function
     *
     * @return void
     */
    public function middleware()
    {
        if( session('project')['lang'] == 'php'){
            $file = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/app/Http/Kernel.php');
            $list = $this->get_string_between($file,'$routeMiddleware = [','];');
            eval('$routeMiddleware = ['.$list.'];');        
            
            return array_values( array_flip($routeMiddleware) );
        }elseif( session('project')['lang'] == 'go'){
            $arr_middleware = [];
            $dataFile = scandir(base_path().config('laravelrestbuilder.copy_to').'/app/middleware');
            foreach ($dataFile as $key => $value) {
                if( $value == '.' || $value == '..' || !preg_match('/.go/', $value) ) continue;
                $file = file_get_contents(base_path().config('laravelrestbuilder.copy_to').'/app/middleware/'.$value);
                $middleware = $this->get_string_between($file, 'func ', '(');
                if( preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $middleware) ){
                    $arr_middleware[] = $middleware;
                }
            }

            return $arr_middleware;
        }
    }

    /**
     * 
     */
    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * [push description]
     * @return [type] [description]
     */
    public function build()
    {                
        $data = Request::all();                

        ProjectBuilder::setProjectSession();

        if( !empty($data['id']) ) {
            \KhanCode\LaravelRestBuilder\Models\Moduls::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('moduls','name')
                            ->whereNull('deleted_at')
                            ->where('project_id',config('laravelrestbuilder.project_id'))
                            ->ignore($data['id'])
                    ],
                'select_project'    => ['required']
            ]);
        }else {            
            \KhanCode\LaravelRestBuilder\Models\Moduls::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('moduls','name')
                            ->whereNull('deleted_at')
                            ->where('project_id',config('laravelrestbuilder.project_id'))
                    ],
                'select_project'    => ['required']
            ]);
        }                

        if( Helpers::is_error() ) throw new ValidationException( Helpers::get_error() );

        $data = ColumnBuilder::build($data,'column');
        $data['name'] = camel_case($data['name']);
        if(empty($data['column'])) $data['column'] = [];
        if(empty($data['column_function'])) $data['column_function'] = [];
        if(empty($data['relation'])) $data['relation'] = [];
        if(empty($data['hidden'])) $data['hidden'] = [];
        if(empty($data['hidden_relation'])) $data['hidden_relation'] = [];
        if(empty($data['repositories'])) $data['repositories'] = [];
        if(empty($data['casts'])) $data['casts'] = [];
        if(empty($data['get_company_code'])) $data['get_company_code'] = NULL;        
        $old_name = '';
        $old_custom_folder = '';

        // save to moduls table
        $detail_data = json_encode( array_except($data,['column']) );                

        // update modul
        if( !empty($data['id']) ) {

            $old_data = \KhanCode\LaravelRestBuilder\Models\Moduls::getAll()->where('id',$data['id'])->first();
            
            $old_name = $old_data->name;
            $old_custom_folder = (json_decode($old_data->detail)->custom_folder)??'';

            // jika beda nama
            if($data['name'] != $old_data->name || $data['custom_folder'] != $old_data->custom_folder) {
                $files = \KhanCode\LaravelRestBuilder\Models\ModulFiles::getAll()
                    ->where('modul_id',$data['id'])
                    ->where('name','not like', "%main.go")
                    ->get();
                
                foreach ($files as $key => $value) {
                    // chown($value->name, 666); //Insert an Invalid UserId to set to Nobody Owern; 666 is my standard for "Nobody" 
                    $folder = base_path()."/".config('laravelrestbuilder.copy_to')."/";
                    if ( file_exists($folder.$value->name) ){
                        unlink($folder.$value->name);
                    }
                    $value->delete();
                }
            }
            
            // jika detail modul beda
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
            // create modul
            $modul = \KhanCode\LaravelRestBuilder\Models\Moduls::create([
                'name'  =>  $data['name'],
                'detail'    =>  $detail_data,
            ]);

            $data['id'] = $modul->id;
        }        

        config(['laravelrestbuilder.modul'   =>  $data]);

        $class = [];
        if( !empty($data['classtab']) ){
            foreach ($data['classtab'] as $key_class => $value_class) {
                if( empty($class[$value_class['modul']]) ) {
                    $class[$value_class['modul']] = [];
                }
                $class[$value_class['modul']][] = $value_class['class_path'];
            }
        }

        if(!empty($data['custom_folder'])) $data['custom_folder'] = '/'.ucfirst($data['custom_folder']);

        if( session('project')['lang'] == 'php'){
            if( !empty($data['table']) && !empty($data['column']) ) {
                TableBuilder::buildMigration();
            }
            
            if( !empty($data['route']) ) {
                ControllerBuilder::build(
                    $data['name'],
                    $data['column']??[],
                    $data['column_function'],
                    $data['route'],
                    $data['relation'],
                    $data['hidden'],
                    $data['custom_folder']
                );
            }
            
            if( !empty($data['route']) ) {
                ServiceBuilder::build(
                    $data['name'],
                    $data['table'],
                    $data['column']??[],
                    $data['key'],
                    $data['route'],
                    $data['relation'],
                    $data['custom_folder'],
                );
            }
            
            if( !empty($data['table']) ) {
                ModelBuilder::build(
                    $data['name'],
                    $data['table'],
                    $data['key'],
                    $data['increment_key'],
                    $data['column'],
                    $data['column_function'],
                    $data['with_timestamp'],
                    $data['with_authstamp'],
                    $data['with_ipstamp'],
                    $data['with_companystamp'],
                    $data['custom_filter'],
                    $data['custom_group'],
                    $data['custom_union'],
                    $data['custom_union_model']??NULL,
                    $data['custom_join'],
                    $data['relation'],
                    $data['hidden'],
                    $data['with_company_restriction'],
                    $data['with_delete_restriction'],
                    $data['casts'],
                    $data['with_authenticable'],
                    $data['get_company_code'],
                    $data['get_custom_creating'],
                    $data['get_custom_updating'],
                    $data['get_custom_deleting'],
                    $data['hidden_relation'],
                    $data['with_timestamp_details'],
                    $data['with_authstamp_details'],
                    $data['with_ipstamp_details'],
                    $data['custom_folder'],
                );    
            }

            RepositoryBuilder::build(
                $data['name'],
                $data['table']??NULL,
                $data['repositories']??[],
                $data['custom_folder'],
            );

            if( !empty($data['table']) && !empty($data['route']) ) {
                ResourceBuilder::build(
                    $data['name'],
                    $data['column']??[],
                    $data['column_function'],
                    $data['relation'],
                    $data['hidden'],
                    $data['hidden_relation'],
                    $data['custom_folder'],
                );

            }
            
            if( !empty($data['route']) ) {
                RouteBuilder::build(
                    $data['name'],
                    $data['route'],
                    $old_name,
                    $data['custom_folder'],
                    $old_custom_folder
                );
            }
            
            // $file_modul = self::getArrayFile('modul', 'storage');
            // $file_table = self::getArrayFile('table', 'storage');        

            // create list modul file
            // FileCreator::create( 'modul', 'storage', '<?php return ' . var_export([$data['name'] => array_except($data,['column'])]+$file_modul, true) . ';' );
            
            // create list table
            // FileCreator::create( 'table', 'storage', '<?php return ' . var_export([$data['table'] => $data['column']]+$file_table, true) . ';' );
            
            // save new file to files table
            // if( !empty(config('laravelrestbuilder.file.created')) ) {
            //     foreach (config('laravelrestbuilder.file.created') as $key => $value) {
            //         \KhanCode\LaravelRestBuilder\Models\ModulFiles::create([
            //             'name'  =>  $value,
            //             'modul_id'    =>  $data['id'],
            //         ]);             
            //     }
            // }
            
            return [
                'data'  => \KhanCode\LaravelRestBuilder\Models\Moduls::find($data['id']),
                'files' => \KhanCode\LaravelRestBuilder\Models\ModulFiles::getAll()
                            ->select([
                                'id',
                                'name'
                            ])            
                            ->where('modul_id',$data['id'])
                            ->get()
            ]+config('laravelrestbuilder.file');
        }elseif( session('project')['lang'] == 'go'){

            if( !empty($data['table']) ) {
                GoModelBuilder::build(
                    $data['name'],
                    $data['table'],
                    $data['key'],
                    $data['increment_key'],
                    $data['column'],
                    $data['column_function'],
                    $data['with_timestamp'],
                    $data['with_authstamp'],
                    $data['with_ipstamp'],
                    $data['with_companystamp'],
                    $data['custom_filter'],
                    $data['custom_union'],
                    $data['custom_union_model']??NULL,
                    $data['custom_join'],
                    $data['relation'],
                    $data['hidden'],
                    $data['with_company_restriction'],
                    $data['with_delete_restriction'],
                    $data['casts'],
                    $data['with_authenticable'],
                    $data['get_company_code'],
                    $data['get_custom_creating'],
                    $data['get_custom_updating'],
                    $data['get_custom_deleting'],
                    $data['hidden_relation'],
                    $data['with_timestamp_details'],
                    $data['with_authstamp_details'],
                    $data['with_ipstamp_details'],
                    $class['model']??[],
                );    
            }

            if( !empty($data['table']) ) {
                GoRepositoryBuilder::build(
                        $data['name'],
                        $data['table']??NULL,
                        $data['repositories']??[],
                    );
            }

            if( !empty($data['table']) ) {
                GoResourceBuilder::build(
                    $data['name'],
                    $data['column']??[],
                    $data['column_function'],
                    $data['relation'],
                    $data['hidden'],
                    $data['hidden_relation'],
                    $class['resource']??[],
                );
            }

            if( !empty($data['route']) ) {
                GoControllerBuilder::build(
                    $data['name'],
                    $data['column']??[],
                    $data['column_function'],
                    $data['route'],
                    $data['relation'],
                    $data['hidden']
                );

                GoServiceBuilder::build(
                    $data['name'],
                    $data['column']??[],
                    $data['column_function'],
                    $data['route'],
                    $data['relation'],
                    $data['hidden'],
                    $class['service']??[],
                    $data['with_timestamp_details'],
                    $data['with_authstamp_details'],
                    $data['with_ipstamp_details']
                );

                GoRouteBuilder::build(
                    $data['name'],
                    $data['route'],
                    $old_name,
                    $class['controller']??[],
                );
            }

            return [
                'data'  => \KhanCode\LaravelRestBuilder\Models\Moduls::find($data['id']),
                'files' => \KhanCode\LaravelRestBuilder\Models\ModulFiles::getAll()
                            ->select([
                                'id',
                                'name'
                            ])            
                            ->where('modul_id',$data['id'])
                            ->get()
            ]+config('laravelrestbuilder.file');
        }

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
        if (file_exists(base_path()."/".$folder."/".$name_file.".stub")) 
            return include(base_path()."/".$folder."/".$name_file.".stub");

        return [];
    }
}