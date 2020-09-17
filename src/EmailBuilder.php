<?php

namespace KhanCode\LaravelRestBuilder;

use DB;
use Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use KhanCode\LaravelRestBuilder\Models\Projects;
use KhanCode\LaravelRestBuilder\Models\EmailFiles;
use KhanCode\LaravelRestBuilder\Models\Emails;
use KhanCode\LaravelBaseRest\Helpers;
use KhanCode\LaravelBaseRest\ValidationException;

class EmailBuilder
{    
    /**
     * get function
     *
     * @return void
     */
    public function get()
    {
        return view('khancode::listEmail', [
                'data'  =>  [
                    'tambah_Email' =>   1
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
        return Emails::getAll()
            ->where('id',$id)
            ->first();
        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function createEmail() 
    {
        return view('khancode::createEmail', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
            'data'=>[
                'simpan_email'    =>  1
            ],
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function updateEmail($id) 
    {
        $data    = Emails::getAll()->where('id',$id)->first();

        if( empty($data) ) {
            $data = [
                'error_not_found'   => 1
            ];
        }else {
            $data = $data->toArray();
        }
        
        return view('khancode::createEmail', [
            'user'  =>  auth()->guard('laravelrestbuilder_auth')->user(),
            'projects'   =>  Projects::userData()->get(),
            'data'=>[
                'simpan_email'    =>  1,                
            ]+$data,
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function buildEmail() 
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
            Emails::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('emails','name')
                            ->whereNull('deleted_at')
                            ->where('project_id', $data['select_project']??config('laravelrestbuilder.project_id'))
                            ->ignore($data['id'])
                    ],
                'variable' => [
                        'required'
                    ],
                'view' => [
                        'required'
                    ],
            ]);

            $old_data   = Emails::find($data['id']);

            // jika beda nama
            if($data['name'] != $old_data->name) {
                $files = EmailFiles::getAll()->where('email_id',$data['id'])->whereNull('deleted_by')->get();
                
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

            $return = Emails::find($data['id']);

        }else {
            Emails::validate($data,[
                'name' => [
                        'required', 
                        \Illuminate\Validation\Rule::unique('emails','name')
                            ->whereNull('deleted_at')
                            ->where('project_id', $data['select_project']??config('laravelrestbuilder.project_id'))
                    ],
                'variable' => [
                        'required'
                    ],
                'view' => [
                        'required'
                    ],
            ]);
            
            $return = Emails::create($data);
        }        

        config(['laravelrestbuilder.email'   =>  $return]);

        $base = config('laravelRestBuilder.base');
        $base_email = file_get_contents(__DIR__.'/../base'.$base.'/email/base.stub', FILE_USE_INCLUDE_PATH); 
        $base_email = str_replace([
                '{{Name}}',
                '{{name}}',
                '{{before_code}}',
                '{{after_code}}',
            ],[
                ucwords( camel_case($data['name']) ),
                camel_case($data['name']),
                str_replace("\n", "\n\t\t", $data['before_code']),
                $data['after_code'],
            ],$base_email);

        $base_variable = file_get_contents(__DIR__.'/../base'.$base.'/email/variable.stub', FILE_USE_INCLUDE_PATH);
        $base_variable_code = file_get_contents(__DIR__.'/../base'.$base.'/email/variable_code.stub', FILE_USE_INCLUDE_PATH);
        
        $variable_initialization = '';
        foreach (json_decode($data['variable'],true) as $key => $value) {
            $variable_initialization .= (!empty($variable_initialization)?"\t":"").str_replace('{{name}}',$value['name'],$base_variable);
        }
        $base_email = str_replace('{{variable_initialization}}',$variable_initialization,$base_email);

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
        $base_email = str_replace('{{variable_code}}',$variable_code,$base_email);

        $parameter_code = '';
        foreach (json_decode($data['parameter'],true) as $key => $value) {
            $parameter_code .= (!empty($parameter_code)?", ":"")."$".$value['code'];
        }
        $base_email = str_replace('{{parameter}}',$parameter_code,$base_email);

        FileCreator::create( ucwords( camel_case($data['name']) ), 'app/Mail', $base_email, 'email' );
        FileCreator::create( camel_case($data['name']).'.blade', 'resources/views/emails', $data['view'], 'email' );

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
                    
        $model = new Emails;
        
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
        $data    = Emails::getAll()->where('id',$id)->first();

        \URL::forceRootUrl('https://zenwelecommerce.builder.my.id/');   

        if( empty($data) ) {
            $data = [
                'error_not_found'   => 1
            ];
        }

        $folder = config('laravelrestbuilder.copy_to')."/resources/views";
        
        $finder = new \Illuminate\View\FileViewFinder(app()['files'], array(base_path()."/".$folder."/"));
        view()->setFinder($finder);
        
        return view('emails.'.$data->name);
    }
}
