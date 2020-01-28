@extends('khancode::base')

@section('title', 'List Table')

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
@endsection
    
@section('script_add_on')
    <script>
        $( document ).ready(function() {
                listTable();
            });
        
        function listTable() {
            list_table = $( "#table_list" ).DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{url('/')}}/systemTable",
                        "dataSrc": 'data'
                    },
                    columns: [
                        { data: 'nomor_baris' },
                        { data: 'name' },
                        { 
                            data: 'id',
                            "render": function ( data, type, row, meta ) {
                                html = '';
                                html += '<a href="{{url('/')}}/updateTable/'+data+'"><button type="button" class="btn btn-primary float-right btn-sm" style="margin-right: 15px;"><svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg></button></a>'
                                html += '<button onclick="dropTable('+data+')" type="button" class="btn btn-danger float-right btn-sm" style="margin-right: 15px;"><i class="fa fa-trash" aria-hidden="true"></i></button></a>'
                                return html;
                            }
                        }
                    ]
                });
        }

        function dropTable(id) {
            $.ajax({
                url: '{{url('/')}}/dropTable/'+id,
                type: "GET",                
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    htmlcreated = ''
                    htmlupdated = ''
                    htmlmigration = ''
                    $.each(data,function(index,value) {
                        $.each(value,function(index_2,value_2) {
                            if(index == 'created') {
                                htmlcreated += value_2+"<br>"
                            }else if(index == 'updated') {
                                htmlupdated += value_2+"<br>"
                            }else if(index == 'migration') {
                                htmlmigration += value_2+"<br>"
                            }
                            
                        })
                    })                                        

                    html = ''
                    if(htmlcreated != '') {
                        html += 'created <br>'+htmlcreated+'<br>'
                    }
                    if(htmlupdated != '') {
                        html += 'updated <br>'+htmlupdated+'<br>'
                    }
                    if(htmlmigration != '') {
                        html += 'migrated <br>'+htmlmigration+'<br>'
                    }

                    if( html != '' ) {
                        $( "#modal_1 .modal-body" ).html(html)
                    }else {
                        $( "#modal_1 .modal-body" ).html('Tidak ada perubahan')
                    }
                    
                    list_table.ajax.reload()
                    
                    $( "#launch_modal_1" ).click()
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
@endsection

    