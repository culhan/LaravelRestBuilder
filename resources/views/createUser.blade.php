@extends('khancode::base'.config('laravelrestbuilder.theme'))

@if (array_has($data,'name'))
    @section('title', 'Update User '.Arr::get($data, 'name', ''))
@else
    @section('title', 'Create User ')
@endif

@section('content')
    <div class="col-lg-12">        
        <form id="modul">
             
            <input type="" class="form-control d-none" name='id' value='{{ Arr::get($data, 'id', '0') }}'>

            <div class="form-group">                
                <label>Nama</label>                    
                <input type="" class="form-control" id="user_name" placeholder="nama User" name='name' value='{{ Arr::get($data, 'name', '') }}'>
            </div>
            
            <div class="form-group">                
                <label>Email</label>
                <input type="" class="form-control" placeholder="email" name='email' value='{{ Arr::get($data, 'email', '') }}'>
            </div>

            <div class="form-group">                
                <label>Password</label>
                <input type="password" class="form-control" name='password'>
            </div>

            <div class="form-group">                
                <label>Role</label>
                <select class="form-control" data-live-search="true" name='role_id'>
                    @foreach($roles as $role)
                        @if( $role->id == Arr::get($data, 'role_id', NULL) )
                        <option value={{$role->id}} selected>{{$role->name}}</option>
                        @else
                        <option value={{$role->id}}>{{$role->name}}</option>
                        @endif
                    @endforeach
                </select> 
            </div>

            <div class="form-group">                
                <label>Projects</label>
                <select class="form-control" multiple data-live-search="true" name='projects[]'>
                    <?php
                        $arr_project = [];
                        if( !empty($data['projects']) ) {
                            $arr_project    = array_flip( $data['projects'] );
                        }
                    ?>
                    @foreach($projects as $project)
                        @if( isset($arr_project[$project->id]) )
                        <option value={{$project->id}} selected>{{$project->name}}</option>
                        @else
                        <option value={{$project->id}}>{{$project->name}}</option>
                        @endif
                    @endforeach
                </select> 
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
    <script>
        function simpanKeApiUser() {
            
            objModul = $('#modul').serializeJSON()

            $.ajax({
                url: '{{url('/')}}/createUser',
                type: "POST",
                data: JSON.stringify(Object.assign({}, objModul )),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    window.location.href = '{{url('/')}}/user'
                },
                error: function(data) {
                    if (data.responseJSON) {
                        if (jsonObj = IsJsonString(data.responseJSON.message)){
                            setErrorColumn(jsonObj)
                        }
                        if (jsonObj = data.responseJSON.error.error){
                            setErrorColumn(jsonObj)
                        }
                        // else {
                        //     str_error = data.responseJSON.message;
                        //     str_error = str_error.replace(/(?:\r\n|\r|\n)/g, '<br>');
                        //     $("#modal_1 .modal-body").html(str_error);
                        //     $("#launch_modal_1").click();
                        // }                
                    } else {
                        $("#modal_1 .modal-body").html("Tidak ada perubahan");
                        $("#launch_modal_1").click();
                    }            
                }
            });
        }
    </script>
    <script>
        $( document ).ready(function() {
            $(".loading").hide();
        });
    </script>

    <script src="<?php echo URL::to('/vendor/khancode/js/submit.js');?>"></script>
@endsection