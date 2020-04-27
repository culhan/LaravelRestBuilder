@extends('khancode::base'.config('laravelrestbuilder.theme'))

@section('title', 'List Modul')

@section('content')
    <div class="col-lg">        
        <table id="table_list" class="table table-striped table-bordered" style="width:100%">
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

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin Akan Hapus ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" id="confirm_delete">Ya</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('script_add_on')
    <script>
        $( document ).ready(function() {
                list_table = $( "#table_list" ).DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{url('/')}}/dataList",
                        "dataSrc": 'data'
                    },
                    columns: [
                        { data: 'nomor_baris' },
                        { data: 'name' },
                        { 
                            data: 'id',
                            "render": function ( data, type, row, meta ) {
                                html    =   ''
                                html    +=  '<a href="{{url('/')}}/update/'+data+'"><button type="button" class="btn btn-primary float-right btn-sm" style="margin-right: 15px;"><svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg></button></a>'
                                html    +=  '<button href="{{url('/')}}/delete/modul/'+data+'" type="button" class="btn btn-danger float-right btn-sm" style="margin-right: 15px;" onclick="deleteModal(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                return html
                            }
                        }
                    ]
                });                
            });

            function deleteModal(ele){
                $( "#deleteModal" ).modal('show')
                $( "#confirm_delete" ).attr('href',$(ele).attr('href'))
            }

            $( "#confirm_delete" ).click(function(){
                $.ajax({
                    type: 'DELETE',
                    url: $(this).attr('href'),
                    dataType: 'json',
                    success: function(json) {                        
                        list_table.ajax.reload( null, false )
                        $( "#deleteModal" ).modal('hide')
                    },
                    error: function(e) {
                        alert('gagal hapus data')
                    }
                });
            })
    </script>    
@endsection

    