@extends('khancode::base'.config('laravelrestbuilder.theme'))

@if (array_has($data,'name'))
    @section('title', 'Update Email '.Arr::get($data, 'name', ''))
@else
    @section('title', 'Create Email ')
@endif

@section('content')
    <div class="col-lg-12">        
        <form id="modul">
            <input type="" class="form-control d-none" id="table_id" name='id' value='{{ Arr::get($data, 'id', 0) }}'>

            <div class="form-group">                
                <label>Nama</label>                    
                <input type="" class="form-control" placeholder="nama" name='name' value='{{ (Arr::get($data, 'name', '')) }}' onkeyup="change_code(this)">
            </div>

            <pre id="code_hint">\Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\{{ ucwords(camel_case(Arr::get($data, 'name', ''))) }}());</pre>

            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:0px">
                <li class="nav-item">
                    <a class="nav-link active" id="tabel-parameter" data-toggle="tab" href="#parameter" role="tab" aria-controls="parameter" aria-selected="true" index="parameter">Parameter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabel-variable" data-toggle="tab" href="#variable" role="tab" aria-controls="variable" aria-selected="true" index="variable">Variable</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" id="email-code" data-toggle="tab" href="#code" role="tab" aria-controls="code" aria-selected="false" index="code">Code</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" id="email-view" data-toggle="tab" href="#view" role="tab" aria-controls="view" aria-selected="false" index="view">View</a>
                </li>                            
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="parameter" role="tabpanel" aria-labelledby="tabel-parameter">
                    
                    <!-- kolom -->
                    <figure class="highlight"> 
                        
                        <div class="container ">

                            <div class="form-group">                
                                <label>Code</label>                    
                                <textarea name="parameter_sementara[code]" class="d-none"></textarea>
                                <textarea id="tab_parameter_sementara[code]"></textarea>
                            </div>

                        </div>

                        <div class="row container mb-4">
                            <input class="btn btn-primary" type="button" value="Tambah Paramter" height="10px" onclick="add('parameter')">
                            <input class="btn btn-primary d-none" type="button" value="Edit Paramter" height="10px" onclick="change('parameter')">
                            <input class="ml-1 btn btn-primary d-none" type="button" value="Ubah & Simpan" height="10px" onclick="changeAndSave('parameter')">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_cols('parameter')">
                        </div>

                        <br><br>

                        <!-- parameter -->
                        <modul_parameter>
                        </modul_parameter>

                    </figure>
                </div>
                <div class="tab-pane fade" id="variable" role="tabpanel" aria-labelledby="tabel-variable">
                    
                    <!-- kolom -->
                    <figure class="highlight"> 
                        
                        <div class="container ">

                            <div class="form-group">                
                                <label>Nama</label>                    
                                <input type="" class="form-control" id="variable_name" placeholder="nama" name="variable_sementara[name]">
                            </div>

                            <div class="form-group">                
                                <label>Code</label>                    
                                <textarea name="variable_sementara[code]" class="d-none"></textarea>
                                <textarea id="tab_variable_sementara[code]"></textarea>
                            </div>

                        </div>

                        <div class="row container mb-4">
                            <input class="btn btn-primary" type="button" value="Tambah Variable" height="10px" onclick="add('variable')">
                            <input class="btn btn-primary d-none" type="button" value="Edit Variable" height="10px" onclick="change('variable')">
                            <input class="ml-1 btn btn-primary d-none" type="button" value="Ubah & Simpan" height="10px" onclick="changeAndSave('variable')">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_cols('variable')">
                        </div>

                        <br><br>

                        <!-- variable -->
                        <modul_variable>
                        </modul_variable>

                    </figure>
                </div>
                <div class="tab-pane fade" id="code" role="tabpanel" aria-labelledby="tabel-code">
                    <!-- other -->
                    <figure class="highlight">
                        
                        <div class="form-group">
                            <label>Before</label>
                            <textarea name="before_code" class="d-none"></textarea>
                            <textarea id="tab_before_code"></textarea>
                        </div>

                        <div class="form-group">
                            <label>After</label>
                            <textarea name="after_code" class="d-none"></textarea>
                            <textarea id="tab_after_code"></textarea>
                        </div>

                    </figure>
                </div>                
                <div class="tab-pane fade" id="view" role="tabpanel" aria-labelledby="tabeloption-tab">
                    <!-- other -->
                    <figure class="highlight">
                        
                        <div class="form-group">
                            <textarea name="view" class="d-none"></textarea>
                            <textarea id="tab_view"></textarea>
                        </div>

                    </figure>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('modal')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#modal_1" id="launch_modal_1">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    
    <div class="modal"><!-- Place at bottom of page --></div>
@endsection

@section('script_add_on')
    <script src="<?php echo URL::to('/vendor/khancode/js/storage.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-edit-datatables.js');?>"></script>
    
    <script>
        // untuk page
        list_table = [];
        submit_url = '{{url('/')}}/buildEmail';

        function change_code(e) {
            paramString = ''
            varParameter = storage_parameter.get('parameter')

            $.each(varParameter, function (i, v) {
                if( paramString != '') {
                    paramString += ', '
                }
                paramString += '$' + v['code']
            })

            $("#code_hint").html('\\Illuminate\\Support\\Facades\\Mail::to($email)->send(new \\App\\Mail\\'+camelize(e.value)+'('+paramString+'));')
        }

        // untuk data parameter
        data_index = 'parameter';
        
        list_table[data_index] = [
            {
                'name':'Code',
                'attribute':'code',
                'show':1,
                'type':'ace',
            },
        ];

        storage_parameter.update(data_index, {!! Arr::get($data, 'parameter', '{}') !!});

        build_tabel(data_index, storage_parameter.get(data_index));

        aceGenerate({ name_cols : 'parameter_sementara[code]', mode : 'php_inline'});

        function after_build_table_parameter(data){
            if( typeof camelize === 'function') $('[name="name"]').keyup()
        }

        // untuk data variable
        data_index = 'variable';
        
        list_table[data_index] = [
            {
                'name':'Name',
                'attribute':'name',
                'show':1,
                'type':'text',
            },
            {
                'name':'Code',
                'attribute':'code',
                'show':0,
                'type':'ace',
            },
        ];

        storage_parameter.update(data_index, {!! Arr::get($data, 'variable', '{}') !!});

        build_tabel(data_index, storage_parameter.get(data_index));

        aceGenerate({ name_cols : 'variable_sementara[code]', mode : 'php_inline'});
        
        // untuk data view
        aceGenerate({ name_cols : 'view', maxLines : '100', minLines : '30', default_code : {!! json_encode(Arr::get($data, 'view', '// blade code')) !!}, mode : 'php_laravel_blade'});
        
        // untuk data code
        <?php 
            $code = json_decode(Arr::get($data, 'code', ''));
            $before_code = '';
            $after_code = '';

            if( !empty($code) ){
                $before_code = $code->before_code;
            }

            if( !empty($code) ){
                $after_code = $code->after_code;
            }
        ?>
        aceGenerate({ name_cols : 'before_code', maxLines : '100', minLines : '20', default_code : {!! json_encode($before_code) !!}, mode : 'php_inline'});
        aceGenerate({ name_cols : 'after_code', maxLines : '100', minLines : '20', default_code : {!! json_encode($after_code) !!}, mode : 'php_inline'});

    </script>

    <script src="<?php echo URL::to('/vendor/khancode/js/submit.js');?>"></script>

    <script>
        $( document ).ready(function() {
            $(".loading").hide();

            @if(!empty($data['error_not_found']))
                alert('data email tidak ada')
                window.history.back()
            @endif

            after_build_table_parameter()
        });
    </script>
@endsection