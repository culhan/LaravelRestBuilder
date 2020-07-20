<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use KhanCode\LaravelRestBuilder\Models\ManageUsers;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelBaseRest\Helpers;
use KhanCode\LaravelBaseRest\ValidationException;

class UserBuilder
{    
    /**
     * get function
     *
     * @return void
     */
    public function get()
    {
        return view('khancode::listUser', [
                'data'  =>  [
                    'tambah_user' =>   1
                ],
                'projects'   =>  Projects::userData()->get(),
                'user'  =>  auth()->guard('laravelrestbuilder_auth')->user()
            ]);
    }
    
    /**
     * for show detail
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {        
        return Projects::getAll()
            ->where('id',$id)
            ->first();
        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function createUser() 
    {
        return view('khancode::createUser', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
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
    public function updateUser($id) 
    {
        $data    = ManageUsers::getAll()->where('id',$id)->first()->toArray();
        
        return view('khancode::createUser', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
            'data'=>[
                'simpan_api'    =>  1,                
            ]+$data,
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create() 
    {
        $data = Request::all();
        
        if( !empty($data['id']) ) {
            Projects::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('projects','name')->ignore($data['id'])
                    ],
                'folder' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('projects','folder')->ignore($data['id'])
                    ],
            ]);

            Projects::find($data['id'])->update($data);

            return Projects::find($data['id']);

        }else {
            Projects::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('projects','name')
                    ],
                'folder' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('projects','folder')
                    ],
            ]);

            $data = Projects::create($data);

            session(['project' => $data->toArray()]);

            return $data;
        }        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function list()
    {   
        \Request::merge([
            'search' => \Request::get('search')['value'],
            'sort_column'   =>  'nomor_baris',
            'sort_type'   =>  \Request::get('order')[0]['dir'],
            ]);
                    
        $model = new ManageUsers;
        
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
