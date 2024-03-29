<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelBaseRest\Helpers;
use KhanCode\LaravelBaseRest\ValidationException;

class ProjectBuilder
{    
    static function setProjectSession()
    {
        $data = Request::all();

        \KhanCode\LaravelRestBuilder\Models\Moduls::validate($data,[
                'select_project'    => ['required']
            ]);

        if( !empty( Helpers::is_error() ) ) throw new ValidationException( Helpers::get_error() );

        session(['project'   => \KhanCode\LaravelRestBuilder\Models\Projects::find($data['select_project'])->toArray() ]);
    }

    /**
     * setProject function
     *
     * @return void
     */
    public function setProject($id)
    {        
        session(['project'   => Projects::find($id)->toArray() ]);

        LaravelRestBuilder::setLaravelrestbuilderConnection();

        return redirect(Request::get('previous'));
    }

    /**
     * get function
     *
     * @return void
     */
    public function get()
    {
        return view('khancode::listProject', [
                'data'  =>  [
                    'tambah_project' =>   1
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
    public function createProject() 
    {
        return view('khancode::createProject', [
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
    public function updateProjects($id) 
    {
        $project    = Projects::find($id)->toArray();        
        if(session('project')['id'] == $id) {
            session(['project' => $project]);
        }

        return view('khancode::createProject', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
            'data'=>[
                'simpan_api'    =>  1,                
            ]+$project,
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
    public function projects()
    {   
        \Request::merge([
            'search' => \Request::get('search')['value'],
            'sort_column'   =>  'nomor_baris',
            'sort_type'   =>  \Request::get('order')[0]['dir'],
            ]);
                    
        $model = new Projects;
        
        \DB::connection( $model->connection )->statement(\DB::raw('set @nomorbaris = 0;'));
        
        $data['data'] = $model
            ->userData()
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
        $data['recordsTotal'] = $model->userData()->count();
        $data['recordsFiltered'] = $model
            ->setSortableAndSearchableColumn(['name'=>'name'])
            ->userData()
            ->search()            
            ->count();

        return $data;
        
    }
}
