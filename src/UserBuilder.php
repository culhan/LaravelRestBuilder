<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use KhanCode\LaravelRestBuilder\Models\ManageUsers;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelRestBuilder\Models\Roles;
use KhanCode\LaravelBaseRest\Helpers;
use KhanCode\LaravelBaseRest\ValidationException;
use Illuminate\Support\Facades\Hash;

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
            'roles'   =>  Roles::getAll()->get(),
            'data'=>[
                'simpan_user'    =>  1
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
            'roles'   =>  Roles::getAll()->get(),
            'data'=>[
                'simpan_user'    =>  1,                
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
        \DB::beginTransaction();

        $data = Request::all();

        if( !empty($data['id']) ) {
            ManageUsers::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('users','name')->ignore($data['id'])
                    ],
                'email' => [
                        'required',
                        'email', 
                        \Illuminate\Validation\Rule::unique('users','email')->ignore($data['id'])
                    ],
                'password' => [
                    'nullable',
                    'min:6',
                    'max:32',
                ],
                'role_id' => [
                ]
            ]);

            if( Helpers::is_error() ) throw new ValidationException( Helpers::get_error() );

            if( empty($data['password']) ){
                unset($data['password']);
            }else {
                $data['password'] = Hash::make($data['password']);
            }

            $user = ManageUsers::find($data['id']);
            
            $user->update($data);

            $user->projects()->detach();
            if( !empty($data['projects']) ){
                $user->projects()->attach($data['projects']);
            }
            
            $return = ManageUsers::find($data['id']);

        }else {
            ManageUsers::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('users','name')
                    ],
                'email' => [
                        'required',
                        'email',
                        \Illuminate\Validation\Rule::unique('users','email')
                    ],
                'password' => [
                    'required',
                    'min:6',
                    'max:32',
                ],
                'role_id' => [
                ]
            ]);

            if( Helpers::is_error() ) throw new ValidationException( Helpers::get_error() );

            if( empty($data['password']) ){
                unset($data['password']);
            }else {
                $data['password'] = Hash::make($data['password']);
            }

            $user = ManageUsers::create($data);
            
            if( !empty($data['projects']) ){
                $user->projects()->attach($data['projects']);
            }

            $return = $user;
        }

        \DB::commit();

        return $return;
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
