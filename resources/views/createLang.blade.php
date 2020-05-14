@extends('khancode::base'.config('laravelrestbuilder.theme'))

@if (array_has($data,'name'))
    @section('title', 'Update Project '.Arr::get($data, 'name', ''))
@else
    @section('title', 'Create Project ')
@endif

@section('content')
    <div class="col-lg-12">        
        <form id="modul">

            <div class="form-group">                
                <label>Lang</label>                    
                <input type="" class="form-control" id="lang" placeholder="lang" name='lang' value='{{ Arr::get($data, 'lang', '') }}' readonly>
            </div>
            
            <div class="form-group">                
                <label>Key</label>
                <input type="" class="form-control" placeholder="key" name='key' value='{{ Arr::get($data, 'key', '') }}'>
            </div>

            <div class="form-group">                
                <label>Value</label>
                <input type="" class="form-control" placeholder="value" name='value' value='{{ Arr::get($data, 'value', '') }}'>
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
                url: '{{url('/')}}/lang',
                type: "POST",
                data: JSON.stringify(Object.assign({}, objModul )),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    window.location.href = '{{url('/')}}/lang/list'
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