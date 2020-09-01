<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelRestBuilder\Models\EventFiles;
use KhanCode\LaravelRestBuilder\Models\Events;
use KhanCode\LaravelBaseRest\Helpers;
use KhanCode\LaravelBaseRest\ValidationException;

class EventBuilder
{    
    /**
     * get function
     *
     * @return void
     */
    public function get()
    {
        return view('khancode::listEvent', [
                'data'  =>  [
                    'tambah_Event' =>   1
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
        return Events::getAll()
            ->where('id',$id)
            ->first();
        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function createEvent() 
    {
        return view('khancode::createEvent', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
            'data'=>[
                'simpan_event'    =>  1
            ],
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function updateEvent($id) 
    {
        $data    = Events::getAll()->where('id',$id)->first();

        if( empty($data) ) {
            $data = [
                'error_not_found'   => 1
            ];
        }else {
            $data = $data->toArray();
        }
        
        return view('khancode::createEvent', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
            'data'=>[
                'simpan_event'    =>  1,                
            ]+$data,
        ]);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        \DB::beginTransaction();

        $data    = Events::getAll()->where('id',$id)->first();

        if( !empty($data) ) {
            
            $files = EventFiles::getAll()->where('event_id',$id)->whereNull('deleted_by')->get();
                
            foreach ($files as $key => $value) {
                // chown($value->name, 666); //Insert an Invalid UserId to set to Nobody Owern; 666 is my standard for "Nobody" 
                $folder = base_path()."/".config('laravelrestbuilder.copy_to')."/";
                // dd($folder.$value->name);
                if ( file_exists($folder.$value->name) ){
                    unlink($folder.$value->name);
                }
                $deleted_files[] = $folder.$value->name;
                $value->delete();
            }

            // delete modul
            $data->delete();

            \DB::commit();

            return [
                'success' => 1
            ];

        }

        return [
            'success' => 0
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function buildEvent() 
    {
        $data = Request::all();

        if( isset($data['variable']) ) {
            $data['variable'] = json_encode($data['variable']);
        }

        if( isset($data['parameter']) ) {
            $data['parameter'] = json_encode($data['parameter']);
        }

        $data['code'] = json_encode([
            'before_code' => $data['before_code'],
            'after_code' => $data['after_code'],
        ]);
        
        $deleted_files = [];
        if( !empty($data['id']) ) {
            Events::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('events','name')
                            ->whereNull('deleted_at')
                            ->where('project_id', $data['select_project']??config('laravelrestbuilder.project_id'))
                            ->ignore($data['id'])
                    ],
                'variable' => [
                        'required'
                    ],
            ]);

            $old_data   = Events::find($data['id']);

            // jika beda nama
            if($data['name'] != $old_data->name) {
                $files = EventFiles::getAll()->where('event_id',$data['id'])->whereNull('deleted_by')->get();
                
                foreach ($files as $key => $value) {
                    // chown($value->name, 666); //Insert an Invalid UserId to set to Nobody Owern; 666 is my standard for "Nobody" 
                    $folder = base_path()."/".config('laravelrestbuilder.copy_to')."/";
                    // dd($folder.$value->name);
                    if ( file_exists($folder.$value->name) ){
                        unlink($folder.$value->name);
                    }
                    $deleted_files[] = $folder.$value->name;
                    $value->delete();
                }
            }

            $old_data->update($data);

            $return = Events::find($data['id']);

        }else {
            Events::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('events','name')
                            ->whereNull('deleted_at')
                            ->where('project_id', $data['select_project']??config('laravelrestbuilder.project_id'))
                    ],
                'variable' => [
                        'required'
                    ],
            ]);
            
            $return = Events::create($data);
        }        

        config(['laravelrestbuilder.event'   =>  $return]);

        $base = config('laravelRestBuilder.base');
        $base_event = file_get_contents(__DIR__.'/../base'.$base.'/event/base.stub', FILE_USE_INCLUDE_PATH); 
        $base_event = str_replace([
                '{{Name}}',
                '{{name}}',
                '{{before_code}}',
                '{{after_code}}',
            ],[
                ucwords( camel_case($data['name']) ),
                $data['name'],
                str_replace("\n", "\n\t\t", $data['before_code']),
                $data['after_code'],
            ],$base_event);

        $base_variable = file_get_contents(__DIR__.'/../base'.$base.'/event/variable.stub', FILE_USE_INCLUDE_PATH);
        $base_variable_code = file_get_contents(__DIR__.'/../base'.$base.'/event/variable_code.stub', FILE_USE_INCLUDE_PATH);
        
        $variable_initialization = '';
        foreach (json_decode($data['variable'],true) as $key => $value) {
            $variable_initialization .= (!empty($variable_initialization)?"\t":"").str_replace('{{name}}',$value['name'],$base_variable);
        }
        $base_event = str_replace('{{variable_initialization}}',$variable_initialization,$base_event);

        $variable_code = '';
        foreach (json_decode($data['variable'],true) as $key => $value) {
            $variable_code .= (!empty($variable_code)?"\t\t":"").str_replace([
                    '{{name}}',
                    '{{code}}'
                ],[
                    $value['name'],
                    $value['code']
                ],$base_variable_code);
        }
        $base_event = str_replace('{{variable_code}}',$variable_code,$base_event);

        $parameter_code = '';
        foreach (json_decode($data['parameter'],true) as $key => $value) {
            $parameter_code .= (!empty($parameter_code)?", ":"")."$".$value['code'];
        }
        $base_event = str_replace('{{parameter}}',$parameter_code,$base_event);

        FileCreator::create( ucwords( camel_case($data['name']) ), 'app/Events', $base_event, 'event' );

        return [
            'data'  => $return,
            'deleted'   => $deleted_files,
        ]+config('laravelrestbuilder.file');
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
                    
        $model = new Events;
        
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
    public function preview($id)
    {
        $data    = Events::getAll()->where('id',$id)->first();

        if( empty($data) ) {
            $data = [
                'error_not_found'   => 1
            ];
        }

        $folder = config('laravelrestbuilder.copy_to')."/resources/views";
        
        $finder = new \Illuminate\View\FileViewFinder(app()['files'], array(base_path()."/".$folder."/"));
        view()->setFinder($finder);
        
        return view('events.'.$data->name);
    }
}
