@extends('khancode::base'.config('laravelrestbuilder.theme'))

@if (array_has($data,'name'))
    @section('title', 'Update Project '.Arr::get($data, 'name', ''))
@else
    @section('title', 'Create Project ')
@endif

@section('content')
    <div class="col-lg-12">        
        <form id="modul">
             
            <input type="" class="form-control d-none" name='id' value='{{ Arr::get($data, 'id', '0') }}'>

            <div class="form-group">                
                <label>Nama Project</label>                    
                <input type="" class="form-control" id="project_name" placeholder="nama project" name='name' value='{{ Arr::get($data, 'name', '') }}'>
            </div>
            
            <div class="form-group">                
                <label>Folder</label>
                <input type="" class="form-control" placeholder="nama folder" name='folder' value='{{ Arr::get($data, 'folder', '') }}'>
            </div>

            <div class="form-group">                
                <label>Host</label>
                <input type="" class="form-control" placeholder="host" name='db_host' value='{{ Arr::get($data, 'db_host', '') }}'>
            </div>

            <div class="form-group">                
                <label>Port</label>
                <input type="" class="form-control" placeholder="port" name='db_port' value='{{ Arr::get($data, 'db_port', '') }}'>
            </div>

            <div class="form-group">                
                <label>Database</label>
                <input type="" class="form-control" placeholder="database name" name='db_name' value='{{ Arr::get($data, 'db_name', '') }}'>
            </div>

            <div class="form-group">                
                <label>Username</label>
                <input type="" class="form-control" placeholder="database username" name='db_username' value='{{ Arr::get($data, 'db_username', '') }}'>
            </div>

            <div class="form-group">                
                <label>Password</label>
                <input type="" class="form-control" placeholder="database password" name='db_password' value='{{ Arr::get($data, 'db_password', '') }}'>
            </div>            
            
        </form>
    </div>    

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
        function simpanKeApi() {
            
            objModul = $('#modul').serializeJSON()

            $.ajax({
                url: '{{url('/')}}/project',
                type: "POST",
                data: JSON.stringify(Object.assign({}, objModul )),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    window.location.href = '{{url('/')}}/project'
                },
                error:function (data) {                    
                    if( data.responseJSON ) {
                        $( "#modal_1 .modal-body" ).html(data.responseJSON.message)
                    }else {
                        $( "#modal_1 .modal-body" ).html('Tidak ada perubahan')
                    }
                    $( "#launch_modal_1" ).click()
                }
            });
        }
    </script>
    <script>
        $( document ).ready(function() {
            $(".loading").hide();
        });
    </script>
@endsection