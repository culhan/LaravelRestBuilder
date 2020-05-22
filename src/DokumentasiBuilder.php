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
                'projects'   =>  Projects::get(),
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
            $res = $client->request(Request::get('method'), Request::get('url'), [
                    'headers' => $header_data,
                    'query' => $param_data,
                    'multipart'   => $postData,                    
                    'http_errors'   => false,
                    'request.options'   => [
                        'exceptions'    => false,
                    ]
                ]+(  !empty($raw_data)?['body'  => $raw_data]:[]  ));
            
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
        return Cache::get('laravelrestbuilder');
    }

    /**
     * Undocumented function
     *
     * @param Type $var
     * @return void
     */
    public function saveEnv()
    {
        Cache::put('laravelrestbuilder',request('env_params'));

        return $this->getEnv();
    }
}
