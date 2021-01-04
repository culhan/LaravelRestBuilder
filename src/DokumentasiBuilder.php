<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelRestBuilder\Models\Endpoint;

class DokumentasiBuilder
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function dokumentasi()
    {
        return view('khancode::dokumentasi', [
                'data'  =>  [
                    'tambah_dokumentasi' =>   1,
                    'jumlah_endpoint'   => Endpoint::getAll()->where('type','!=','folder')->count(),
                ],
                'projects'   =>  Projects::userData()->get(),
                'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
            ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function listEndpoint()
    {        
        return Endpoint::getAll()
            ->orderBy('parent')
            ->orderBy('position')
            ->where('parent',0)
            ->get();
        
    }

    /**
     * for children
     *
     * @param [type] $id
     * @return void
     */
    public function listEndpointChildren($id)
    {        
        return Endpoint::getAll()
            ->orderBy('parent')
            ->orderBy('position')
            ->where('parent',$id)
            ->get();
        
    }
    
    /**
     * for endpoint detail
     *
     * @param [type] $id
     * @return void
     */
    public function endpoint($id)
    {        
        return Endpoint::getAll()
            ->where('id',$id)
            ->firstOrFail();
        
    }

    /**
     * for endpoint detail
     *
     * @param [type] $id
     * @return void
     */
    public function deleteEndpoint($id)
    {                
        $data = Endpoint::getAll()
            ->where('id',$id)
            ->firstOrFail();

        if($data->children){
            $dataChild = Endpoint::getAll()
                ->where('parent',$id)
                ->get();
            
            foreach ($dataChild as $key => $value) {
                $this->deleteEndpoint($value->id);
            }
        }

        if($data->delete()){
            return [
                'error' => 0
            ];
        }
        
        return [
            'error' => 1
        ];
    }
    
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function updatePositionApi()
    {
        $input = Request::all();
        
        $child = explode(',',$input['child']);

        foreach ($child as $key => $value) {
            $this->endpoint($value)->update([
                'parent'    => $input['parent'],
                'position'  => $key,
            ]);
        }

        return 'ok';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function renameEndpoint($id)
    {
        $input = Request::all();

        $endpoint = Endpoint::getAll()->where('id',$id)->firstOrFail();
        $result = $endpoint->update([            
            'name'  => !empty($input['name'])?$input['name']:'',
        ]);

        return $this->endpoint($id);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function tambahFolder()
    {
        $input = Request::all();
        $result = Endpoint::create([
            'parent'    => !empty($input['parent'])?$input['parent']:0,
            'name'  => !empty($input['name'])?$input['name']:'',
            'type'  => 'folder',
            'position'  => Endpoint::getAll()->where('parent', (!empty($input['parent'])?$input['parent']:0) )->count()+1,
        ]);

        return $this->endpoint($result->id);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function saveEndpoint()
    {        
        $input = Request::all();
        
        if( empty($input['id']) ) {
            $result = Endpoint::create([
                'data'  => json_encode($input),
                'type'  => 'file-'.$input['method'],
                'parent'    => !empty($input['parent'])?$input['parent']:0,
                'url'   => !empty($input['url'])?$input['url']:'',
                'name'  => !empty($input['name'])?$input['name']:0,
                'position'  => Endpoint::getAll()->where('parent', (!empty($input['parent'])?$input['parent']:0) )->count()+1
            ]);

            $input['id'] = $result->id;
        }else {
            $endpoint = Endpoint::getAll()->where('id',$input['id'])->firstOrFail();
            $result = $endpoint->update([
                'data'  => json_encode($input),
                'type'  => 'file-'.$input['method'],
                // 'parent'    => !empty($input['parent'])?$input['parent']:0,
                'url'   => !empty($input['url'])?$input['url']:'',
                'name'  => !empty($input['name'])?$input['name']:'',
                // 'position'  => !empty($input['position'])?$input['position']:9999,
            ]);
        }

        return $this->endpoint($input['id']);
    }

    /**
     * call api function
     *
     * @param Type $var
     * @return void
     */
    public function callApi()
    {                
        // set header
        $header_data = [];
        if(Request::has('headers')) {            
            foreach (Request::get('headers') as $key => $value) {
                if( !empty($value['key']) ) {
                    $header_data[$value['key']] = $value['value'];
                }
            }
        }
        
        $param_data = [];
        if(Request::has('query_params')) {            
            foreach (Request::get('query_params') as $key => $value) {
                if( !empty($value['key']) ) {
                    $param_data[$value['key']] = $value['value'];
                }
            }
        }

        $raw_data = [];
        if(Request::has('raw_data')) {            
            $raw_data = Request::get('raw_data');
        }
        
        $postData = [];
        if(Request::get('method') == 'post') {
            if(Request::has('bodies')) {                
                foreach (Request::get('bodies') as $key => $value) {                    
                    if( empty($value['key']) ) continue;
                    if( $value['type'] == 'text' ) {
                        $postData[] = [
                            'name'  => $value['key'],
                            'contents'  => $value['value']
                        ];                 
                    }else {
                        Storage::put($value->getClientOriginalName().date('YmdHis'), file_get_contents($value->getRealPath()));
                        $postData[] = [
                            'name'  => $value['key'],
                            'contents'  => Storage::get($value->getClientOriginalName().date('YmdHis')) 
                        ];
                    }
                }                
                
            }
        }
        
        $client = new \GuzzleHttp\Client();
        try {      
            if( empty(Request::get('bodies_raw')) ){      
                    $res = $client->request(Request::get('method'), Request::get('url'), [
                        'headers' => $header_data,
                        'query' => $param_data,
                        'multipart'   => $postData,                    
                        'http_errors'   => false,
                        'request.options'   => [
                            'exceptions'    => false,
                        ]
                    ]+(  !empty($raw_data)?['body'  => $raw_data]:[]  ));
            }else if( !empty(Request::get('bodies_raw')) ){      
                    $res = $client->request(Request::get('method'), Request::get('url'), [
                        'headers' => $header_data,
                        'query' => $param_data,
                        'json'  => json_decode(Request::get('bodies_raw'),true),
                        'http_errors'   => false,
                        'request.options'   => [
                            'exceptions'    => false,
                        ]
                    ]);
            }
            
            if(Request::has('bodies')) {
                foreach (Request::get('bodies') as $key => $value) {
                    if( $value['type'] == 'file' ) {                
                        Storage::delete($value->getClientOriginalName().date('YmdHis'));            
                    }
                }
            }

        } catch (\Exception  $exception) {
            return [
                'data'  => '',
                'error' => 1,
                'message'   => $exception->getMessage()
            ];
        }        
        
        $body = $res->getBody();

        if(Request::has('show_html')) {
            return mb_convert_encoding($body->getContents(), 'UTF-8', 'UTF-8');
        }

        return [
                'data'  => mb_convert_encoding($body->getContents(), 'UTF-8', 'UTF-8'),
                'error' => 0,
                'message'   => ''
        ];        
    }

    /**
     * Undocumented function
     *
     * @param Type $var
     * @return void
     */
    public function getEnv()
    {
        $key = 'laravelrestbuilder.'.config('laravelrestbuilder.project_id');
        if( Cache::has($key) ){
            return Cache::get($key);
        }
        return response()->json();
    }

    /**
     * Undocumented function
     *
     * @param Type $var
     * @return void
     */
    public function saveEnv()
    {
        Cache::put('laravelrestbuilder.'.config('laravelrestbuilder.project_id'),request('env_params'));

        return $this->getEnv();
    }

    /**
     * Undocumented function
     *
     * @param Type $var
     * @return void
     */
    public function addEnv()
    {
        $currentEnv = $this->getEnv();

        $filled = 0;
        foreach ($currentEnv as $key => $value) {
            if($value['key'] == request('key')){
                $currentEnv[$key]['value'] = request('value');
                $filled = 1;
            }
        }

        if( empty($filled) ){
            $currentEnv[] = [
                'key'   => request('key'),
                'value' => request('value')
            ];
        }

        Cache::put('laravelrestbuilder.'.config('laravelrestbuilder.project_id'), $currentEnv);

        return $this->getEnv();
    }

    /**
     * Undocumented function
     *
     * @param Type $var
     * @return void
     */
    public function importPostman()
    {
        \DB::beginTransaction();
        
        $this->saveFolderImportPostman(json_decode(Request::get('json'), true));
        
        \DB::commit();
    }

    /**
     * saveImportPostman
     *
     * @param Type $var
     * @return void
     */
    public function saveFolderImportPostman($arr_postman, $parent = 0)
    {
        if( isset($arr_postman['item']) ){

            if( isset($arr_postman['info']) ){
                
                // save name from info
                $result = Endpoint::create([
                    'parent'    => $parent,
                    'name'  => $arr_postman['info']['name'],
                    'type'  => 'folder',
                    'position'  => Endpoint::getAll()->where('parent', $parent )->count()+1,
                ]);

            }else if( isset($arr_postman['name']) ){
                
                // save name from name
                $result = Endpoint::create([
                    'parent'    => $parent,
                    'name'  => $arr_postman['name'],
                    'type'  => 'folder',
                    'position'  => Endpoint::getAll()->where('parent', $parent )->count()+1,
                ]);

            }

            foreach ($arr_postman['item'] as $key => $value) {
                $this->saveFolderImportPostman($value, $result->id);
            }

        }else{

            $data_query_params = [];
            if( isset($arr_postman['request']['url']['query']) ){
                foreach ($arr_postman['request']['url']['query'] as $key => $value) {
                    $data_query_params[] = [
                        'key'   => $value['key'],
                        'value' => $value['value'],
                        'desc'  => $value['description']??'',
                    ];
                }
            }

            $data_headers = [];
            if( isset($arr_postman['request']['header']) ){
                foreach ($arr_postman['request']['header'] as $key => $value) {
                    $data_headers[] = [
                        'key'   => $value['key'],
                        'value' => $value['value'],
                        'desc'  => $value['description']??'',
                    ];
                }
            }

            $data_bodies = [];
            $data_bodies_raw = [];
            if( isset($arr_postman['request']['body']) ){
                if( $arr_postman['request']['body']['mode'] == 'formdata' ){
                    foreach ($arr_postman['request']['body']['formdata'] as $key => $value) {
                        $data_bodies[] = [
                            'key'   => $value['key'],
                            'value' => $value['value'],
                            'type'  => $value['type'],
                            'desc'  => $value['description']??'',
                        ];
                    }
                }else if( $arr_postman['request']['body']['mode'] == 'raw' ){
                    $data_bodies_raw = $arr_postman['request']['body']['raw'];
                }
            }

            $description = '';
            if( isset($arr_postman['description']) ) {
                $description = $arr_postman['description']??'';
            }else if( isset($arr_postman['request']) ) {
                $description = $arr_postman['request']['description']??'';
            }else if( isset($arr_postman['info']) ) {
                $description = $arr_postman['info']['description']??'';
            }

            $name = '';
            if( isset($arr_postman['name']) ) {
                $description = $arr_postman['name']??'';
            }else if( isset($arr_postman['info']) ) {
                $description = $arr_postman['info']['name']??'';
            }

            $data_input = [
                'name'  => $name,
                'description'   => $description,
                'method'    => strtolower( $arr_postman['request']['method'] ),
                'url'   => $arr_postman['request']['url']['raw'],
                'query_params'  => $data_query_params,
                'headers'   => $data_headers,
                'bodies'    => $data_bodies,
                'bodies_raw'    => $data_bodies_raw,
            ];

            $result = Endpoint::create([
                'data'  => json_encode($data_input),
                'type'  => 'file-'.strtolower( $arr_postman['request']['method'] ),
                'parent'    => $parent,
                'url'   => $arr_postman['request']['url']['raw'],
                'name'  => $arr_postman['name'],
                'position'  => Endpoint::getAll()->where('parent', $parent )->count()+1
            ]);

        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getJumlahEndpoint()
    {
        return Endpoint::getAll()->where('type','!=','folder')->count();
    }
}
