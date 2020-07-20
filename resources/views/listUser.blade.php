@extends('khancode::base'.config('laravelrestbuilder.theme'))

@section('title', 'List User')

@section('content')
    <div class="col-lg">        
        <table id="user_list" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
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
                user_list = $( "#user_list" ).DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{url('/')}}/listUser",
                        "dataSrc": 'data'
                    },
                    columns: [
                        { data: 'nomor_baris' },
                        { data: 'name' },
                        { 
                            data: 'id',
                            "render": function ( data, type, row, meta ) {
                                return '<a href="{{url('/')}}/updateUser/'+data+'"><button type="button" class="btn btn-primary float-right btn-sm" style="margin-right: 15px;"><svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg></button></a>';
                            }
                        }
                    ]
                });
            });
    </script>    
@endsection

    