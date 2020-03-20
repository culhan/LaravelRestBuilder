@extends('khancode::base')

@section('title', 'List Language')

@section('content')
    <div class="col-lg">        
        <table id="table_list" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Lang</th>
                    <th scope="col">Key</th>
                    <th scope="col">Value</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>    
@endsection

@section('script_add_on')
    <script>
        $( document ).ready(function() {
                list_table = $( "#table_list" ).DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    "processing": true,
                    "data": {!! json_encode($data['lang']) !!},
                    columns: [
                        { data: 'lang' },
                        { data: 'key' },
                        { data: 'value' },
                        { 
                            data: {
                                key: 'key',
                                lang: 'lang',
                                value: 'value',
                            },
                            "render": function ( data, type, row, meta ) {
                                return '<a href="{{url('/')}}/updateLang?key='+data.key+'&lang='+data.lang+'&value='+data.value+'"><button type="button" class="btn btn-primary float-right btn-sm" style="margin-right: 15px;"><svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg></button></a>';
                            }
                        }
                    ]
                });
            });
    </script>    
@endsection

    