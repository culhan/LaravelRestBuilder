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
                    'tambah_dokumentasi' =>   1
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
            ->first();
        
    }

    /**
     * call api function
     *
     * @param Type $var
     * @return void
     */
    public function callApi()
    {        
        //Initialise the cURL var
        $ch = curl_init();

        //Get the response from cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
        //Set the Url
        curl_setopt($ch, CURLOPT_URL, Request::get('url'));
        
        // set header
        if(Request::has('headers')) {
            $header_data = [];
            foreach (Request::get('headers') as $key => $value) {
                $header_data[$key] = $value['key'].':'.$value['value'];
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);            
        }
        
        // set method
        if(Request::get('method') == 'put') {                        
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        }
                
        // Create a POST array with the file in it
        if(Request::get('method') == 'post') {
            if(Request::has('bodies')) {
                $postData = [];
                foreach (Request::get('bodies') as $key => $value) {
                    if( $value['type'] == 'text' ) {
                        $postData[$value['key']] = $value['value'];    
                    }else {
                        Storage::put($value->getClientOriginalName().date('YmdHis'), file_get_contents($value->getRealPath()));
                        $postData[$key] = Storage::get($value->getClientOriginalName().date('YmdHis'));
                    }
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }
        }

        // Execute the request
        $return = curl_exec($ch);

        foreach (Request::get('bodies') as $key => $value) {
            if( $value['type'] == 'file' ) {                
                Storage::delete($value->getClientOriginalName().date('YmdHis'));            
            }
        }

        // Check the return value of curl_exec(), too
        if ($return === false) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }

        return $return;
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
