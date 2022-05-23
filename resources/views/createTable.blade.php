@extends('khancode::base'.config('laravelrestbuilder.theme'))

@if (array_has($data,'name'))
    @section('title', 'Update Table '.Arr::get($data, 'name', ''))
@else
    @section('title', 'Create Table ')
@endif

@section('content')
    <style>
        .datatable-data {
            display: block
        }
        .datatable-editor {
            display: none
        }
        .show-editor .datatable-data {
            display: none
        }
        .show-editor .datatable-editor {
            display: block
        }
    </style>
    <div class="col-lg-12">        
        <form id="modul">
            <input type="" class="form-control d-none" id="table_id" name='id' value='{{ Arr::get($data, 'id', 0) }}'>
            @if (!array_has($data,'name')) 
                <div class="form-group">                
                    <label>Nama Table</label>                    
                    <input type="" class="form-control" id="table_name" placeholder="nama tabel" name='table' onkeyup="ambil_data_tabel(this)" value='{{ Arr::get($data, 'name', '') }}'>
                </div>
            @else
                <div class="form-group">                
                    <label>Nama Table</label>
                    <input type="" class="form-control" id="table_name" placeholder="nama tabel" name='table' value='{{ Arr::get($data, 'name', '') }}'>
                </div>
            @endif

            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:0px">
                <li class="nav-item">
                    <a class="nav-link active" id="tabel-data" data-toggle="tab" href="#tabdata" role="tabdata" aria-controls="tabdata" aria-selected="true">Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabel-tab" data-toggle="tab" href="#tabel" role="tab" aria-controls="tabel" aria-selected="true">Tabel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabeloption-tab" data-toggle="tab" href="#tabeloption" role="tab" aria-controls="tabeloption" aria-selected="false">Tabel Option</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="listindex-tab" data-toggle="tab" href="#listindex" role="tab" aria-controls="route" aria-selected="false">Index</a>
                </li>                                
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabdata" role="tabpanel" aria-labelledby="tabdata-tab" style="max-width: 100%;">
                    <!-- kolom -->
                    <figure class="highlight"> 

                        <input class="btn btn-primary" type="button" value="Tambah" height='10px' id='add_kolom' onclick="showModalAddData()">    
                        <br>
                        <br>

                        <list-data></list-data>
                    </figure>
                </div>
                <div class="tab-pane fade show" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">
                    
                    <!-- kolom -->
                    <figure class="highlight"> 
                        
                        <div class="container ">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Name </label>
                                        </div>
                                        <div class="col-sm">
                                            <input name="column_sementara[name]" type="text" class="form-control" placeholder="nama kolom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Type </label>
                                        </div>
                                        <div class="col-sm">
                                            <div class="input-group">
                                                <select class="form-control" onchange="ubah_type_kolom_modul_table(this)" name="column_sementara[type]">
                                                    <option value="increment">Increment</option>
                                                    <option value="bigIncrement">Big Increment</option>
                                                    <option value="integer" selected="selected">Integer</option>
                                                    <option value="bigint">Big Integer</option>
                                                    <option value="smallInteger">Small Integer</option>
                                                    <option value="tinyInteger">Tiny Integer</option>
                                                    <option value="boolean">Boolean</option>
                                                    <option value="decimal">Decimal</option>
                                                    <option value="datetime">Datetime</option>
                                                    <option value="date">Date</option>
                                                    <option value="timestamp">Timestamp</option>
                                                    <option value="string">String</option>
                                                    <option value="char">Char</option>
                                                    <option value="text">Text</option>
                                                    <option value="time">Time</option>
                                                </select>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Comment </label>
                                        </div>
                                        <div class="col-sm">
                                            <textarea class="form-control" name="column_sementara[comment]" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Nullable </label>
                                        </div>
                                        <div class="col-sm">
                                            <select class="form-control" name="column_sementara[nullable]">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1" style="padding-top:5px;">
                                    <label>Default </label>
                                </div>
                                <div class="col-sm">                                            
                                    <textarea class="form-control" name="column_sementara[default]" rows="2"></textarea>
                                </div>
                            </div>                            
                        </div>

                        <input class="btn btn-primary" type="button" value="Tambah Kolom" height='10px' id='add_kolom' onclick="tambah_kolom_modul_table_click()">
                        <input class="d-none btn btn-primary" type="button" value="Ubah Kolom" height='10px' id='ubah_kolom' onclick="ubah_kolom_modul_table_click()">
                        <br><br>

                        <!-- table -->
                        <modul_table>
                        </modul_table>

                        
                        <list_kolom>
                        </list_kolom>

                        
                        <input class="btn btn-primary d-none" type="button" value="Tambah Kolom" height='10px' id='add_kolom' onclick="tambah_kolom_click()">                        
                        
                        <list_kolom_forbidden class="d-none">
                        </list_kolom_forbidden>

                    </figure>
                </div>
                <div class="tab-pane fade" id="tabeloption" role="tabpanel" aria-labelledby="tabeloption-tab">
                    <!-- other -->
                    <figure class="highlight">
                        <div class="form-group">
                            <label for="with_timestamp">Time Stamp</label>
                            <select class="form-control" id="with_timestamp" name="with_timestamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Auth Stamp</label>
                            <select class="form-control" id="with_authstamp" name="with_authstamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">IP stamp</label>
                            <select class="form-control" id="with_ipstamp" name="with_ipstamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Company stamp</label>
                            <select class="form-control" id="with_companystamp" name="with_companystamp" onchange="companyStampChange(this)">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                    </figure>
                </div>
                <div class="tab-pane fade" id="listindex" role="tabpanel" aria-labelledby="listindex-tab">
                    <!-- relasi -->
                    <figure class="highlight">

                        <div class="container mb-4">
                            
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Name </label>
                                </div>
                                <div class="col-sm">
                                    <input type="" class="form-control" placeholder="nama index" name="index_sementara[name]">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse" data-target=".index_column" aria-expanded="true" aria-controls="index_column"><b>Kolom</b></label>
                                </div>
                            </div>

                            <div class="col-sm index_column collapse show" style="">
                                <div class="container index_column_sementara"></div>
                                <input class="btn btn-secondary mb-3" type="button" value="Tambah Kolom" height="10px" onclick="tambah_index_column_parameter(0)">
                            </div>

                        </div>

                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_index" type="button" value="Tambah Index" height="10px" onclick="tambah_list_index_table()">
                            <input class="btn btn-primary d-none" id="edit_index" type="button" value="Edit Index" height="10px" onclick="edit_list_index_table()">
                        </div>

                        <listindex_table>
                        </listindex_table>
                        <!-- <list_relasi class="d-none">
                        </list_relasi> -->

                        <!-- <br> -->
                        <!-- <input class="btn btn-primary" type="button" value="Tambah Relasi" height='10px' id='add_relasi'> -->

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

    <!-- Modal -->
    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                dataaa
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
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
                <button type="button" class="btn btn-primary" onclick="confirm_delete(this)" id="confirm_delete">Ya</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal"><!-- Place at bottom of page --></div>
@endsection

@section('script_add_on')
    <script src="<?php echo URL::to('/vendor/khancode/js/ace.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/storage.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-edit-datatables.js');?>"></script>
    
    <script>
        ;(function ($) {

        $.fn.switcher = function (filter,e) {
            
            this.each(function (i,val) {
                var $checkbox = $(val).hide(),
                    $switcher = $(document.createElement('div'))
                        .addClass('ui-switcher')
                        .attr('aria-checked', $checkbox.is(':checked'));

                if ('radio' === $checkbox.attr('type')) {
                    $switcher.attr('data-name', $checkbox.attr('name'));
                }

                toggleSwitch = function (e) {
                    if (e.target.type === undefined) {
                        $checkbox.trigger(e.type);
                    }
                    $switcher.attr('aria-checked', $checkbox.is(':checked'));
                    if ('radio' === $checkbox.attr('type')) {
                        $('.ui-switcher[data-name=' + $checkbox.attr('name') + ']')
                            .not($switcher.get(0))
                            .attr('aria-checked', false);
                    }
                };

                $switcher.on('click', toggleSwitch);
                $checkbox.on('change', toggleSwitch);

                $switcher.insertBefore($checkbox);
            });

        };

    })(jQuery);
    </script>

    <script>
        jumlah_kolom = 0;
        jumlah_kolom_fungsi = 0;
        jumlah_relasi = 0;
        jumlah_route = 0;
        index_kolom_terakhir_dibuat = 0;
        objColumn = [];
        objModul = [];
        objForbiddenCOlumn = [];
        code_editor = [];

        function tambah_kolom_click() {
            objModul = $('#modul').serializeJSON()
            objColumn = toArray(objModul.column)
            objColumn.splice(index_kolom_terakhir_dibuat, 0, {});
            objModul["column"] = objColumn
            build_kolom_tabel(objColumn,objForbiddenCOlumn);
        }

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout(timer);
                timer = setTimeout(callback,ms);
            };
        })();

        $( document ).ready(function() {                        
            @if (!empty($data['name']) )                
                ambil_data_tabel($( "[name='table']" ).get(0));
            @endif
        });
    </script>

    <script>

        var objModul;

        var modul_table = '';
        var route_table = '';

        function toArray(obj) {
            if( typeof obj === 'undefined' ) {
                return []
            }

            if( obj instanceof Object ) {                
                data = []
                i = 0
                $.each(obj, function( index_obj, value_obj ) {
                    data[i] = value_obj
                    i++
                })
                obj = data
            }
            return obj
        }

        function moveColumn(old_index, new_index) {
            objModul = $('#modul').serializeJSON()
            objColumn = objModul.column
            objColumn = move(objColumn, old_index, new_index)
            objModul['column'] = objColumn
            build_kolom_tabel(objColumn,objForbiddenCOlumn);
        }

        function move(arr, old_index, new_index) {
            arr = toArray(arr)
            arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);  
            return arr;
        }

        function removeColumn(data) {
            index_kolom_terakhir_dibuat--
            objModul = $('#modul').serializeJSON()
            objColumn = toArray(objModul.column)
            splice_multilevel_array(objModul,'column.'+data)
            splice_multilevel_array(objColumn,data)
            build_kolom_tabel(objColumn,objForbiddenCOlumn);
        }        

        function splice_multilevel_array(data,index_data) {
            i = 0;
            dataArr = []
            dataArr[i] = data
            index_data = index_data.split('.')
            $.each(index_data, function( index_splice, value_splice ) {
                if( (index_data.length-1) == index_splice ) {
                    if( data instanceof Array ) {
                        data.splice(value_splice,1)
                    }else {
                        delete data[value_splice]
                    }                    
                }else {
                    data = data[value_splice]
                }
            })
        }

        function get_data_array(data,index_data,default_return) {
            if( typeof default_return === 'undefined' ) {
                default_return = false
            }

            if( typeof data === 'object') {
                index_data = index_data.split('.')
                if( typeof data[index_data[0]] === 'undefined' ) {
                    return default_return
                }else {
                    if (index_data.length != 1) {
                        index_data_old = index_data[0]
                        index_data.shift()
                        return get_data_array(data[index_data_old],index_data.join("."),default_return)
                    }else {
                        return data[index_data]
                    }
                }
            }else {
                return default_return
            }

        }

        function ambil_data_tabel(ele) {
            delay(function(){
                $.ajax({
                    type: 'GET',
                    url: '{{url('/')}}/tables?table='+ele.value,
                    jsonpCallback: 'testing',
                    dataType: 'json',
                    success: function(json) {
                        if(json[ele.value]) {
                            objColumn = json[ele.value]
                            objModul['column'] = json[ele.value]
                            objForbiddenCOlumn = json['forbidden_column_name']
                            storage_parameter.update('list_index',json['list_index'])
                            build_kolom_tabel(objModul['column'],objForbiddenCOlumn);
                            build_tabel_option_by_column(objModul['column'])
                            build_modul_tabel(objModul['column'],objForbiddenCOlumn);
                            build_list_index_tabel(json['list_index'])
                            buildListData(objModul['column'])
                            storage_parameter.update('column_to_save',json[ele.value])
                        }else {
                            objColumn = []
                            objModul['column'] = []
                            objForbiddenCOlumn = []
                            storage_parameter.update('list_index',[])
                            build_kolom_tabel([]);
                            build_tabel_option_by_column([])
                            build_modul_tabel([]);
                            build_list_index_tabel([])
                            buildListData([])
                            storage_parameter.update('column_to_save',[])
                        }
                    },
                    error: function(e) {
                        objColumn = []
                        objModul['column'] = []
                        objForbiddenCOlumn = []
                        storage_parameter.update('list_index',[])
                        build_kolom_tabel([]);
                        build_tabel_option_by_column([])
                        build_modul_tabel([]);
                        build_list_index_tabel([])
                        buildListData([])
                    }
                });
            }, 500);
        }

        function build_kolom_tabel(data,forbidden_column_name) {
            $( "list_kolom" ).html('');
            
            i_build_kolom_tabel = 0
            window.jumlah_kolom = 0
            $.each(data, function( index, value ) {
                if(!forbidden_column_name[value['name']])
                {
                    tambah_kolom(i_build_kolom_tabel);
                    set_value_kolom(i_build_kolom_tabel,value);
                    i_build_kolom_tabel++;
                }else {
                    tambah_kolom(i_build_kolom_tabel,'d-none');
                    set_value_kolom(i_build_kolom_tabel,value);
                    i_build_kolom_tabel++;
                }                
            });            
        }        
        
        function build_tabel_option_by_column(data) {
            $( '[name="with_timestamp"]' ).val(0)
            $( '[name="with_authstamp"]' ).val(0)
            $( '[name="with_ipstamp"]' ).val(0)
            $( '[name="with_companystamp"]' ).val(0)

            $.each(data, function( index, value ) {
                if(value['name'] == 'created_time') $( '[name="with_timestamp"]' ).val(1)
                if(value['name'] == 'created_by') $( '[name="with_authstamp"]' ).val(1)
                if(value['name'] == 'created_from') $( '[name="with_ipstamp"]' ).val(1)
                if(value['name'] == 'com_id') $( '[name="with_companystamp"]' ).val(1)
            });
        }

        function build_tabel_option(data) {            
            $( '[name="with_timestamp"]' ).val(0).change();
            $( '[name="with_authstamp"]' ).val(0).change();
            $( '[name="with_ipstamp"]' ).val(0).change();
            $( '[name="with_companystamp"]' ).val(0)
            
            if(data.with_timestamp) $( '[name="with_timestamp"]' ).val(data.with_timestamp).change();
            if(data.with_authstamp) $( '[name="with_authstamp"]' ).val(data.with_authstamp).change();
            if(data.with_ipstamp) $( '[name="with_ipstamp"]' ).val(data.with_ipstamp).change();
            if(data.with_companystamp) $( '[name="with_companystamp"]' ).val(data.with_companystamp)
           
        }

        function build_kolom_tabel_modul(data) {
            if(get_data_array(data,'table')) {
                $( '[name*="table"]' ).val(data['table']).keyup();
            }else {
                $( '[name*="table"]' ).val('').keyup();
            }
        }

        
    </script>    

    <script>
        // khusus modul tabel        
        storage_parameter.add('hidden')

        function build_modul_tabel(data,forbidden_column_name) {

            tableHtml = '<table id="example" class="table table-striped table-bordered" style="width:100%">'
                tableHtml += '<thead>'
                    tableHtml += '<tr>'
                        tableHtml += '<th>#</th>'
                        tableHtml += '<th>Name</th>'
                        // tableHtml += '<th>Hide/Show</th>'
                        tableHtml += '<th>Action</th>'
                    tableHtml += '</tr>'
                tableHtml += '</thead>'
                tableHtml += '<tbody>'                

                iDataTable=0
                $.each(data, function( index_column_function, value_column_function ) {
                    index_column_function = parseInt(index_column_function)
                    if(!forbidden_column_name[value_column_function['name']])
                    {
                        tableHtml += '<tr>'
                            tableHtml += '<td>'
                                tableHtml += (iDataTable+1)
                                // tableHtml += '<i class="fas fa-arrows-alt"></i>'
                            tableHtml += '</td>'
                            tableHtml += '<td>'
                                tableHtml += value_column_function['name']
                            tableHtml += '</td>'

                            // tableHtml += '<td>'
                            // if( storage_parameter.find('hidden',value_column_function['name']) == -1 ) {                                
                            //     tableHtml += '<div class="form-check form-check-inline">'
                            //         tableHtml += '<input class="form-check-input hidden_col" type="checkbox" checked onchange="ubahHiddenInTable(this,'+index_column_function+')" >'
                            //     tableHtml += '</div>'
                            // }else {                                
                            //     tableHtml += '<div class="form-check form-check-inline">'
                            //         tableHtml += '<input class="form-check-input hidden_col" type="checkbox" onchange="ubahHiddenInTable(this,'+index_column_function+')" >'
                            //     tableHtml += '</div>'
                            // }
                            // tableHtml += '</td>'

                            tableHtml += '<td id="modul_kolom_'+iDataTable+'">'                            
                                tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="ubahColumnModulTable(\''+index_column_function+'\')" style="margin-right: 15px;">'
                                tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
                                tableHtml += '</button>'
                                tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeColumnModulTable(\''+index_column_function+'\')" style="margin-right: 15px;">'
                                tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
                                tableHtml += '</button>'
                                tableHtml += '<button type="button" class="btn btn-info float-right btn-sm" onclick="moveColumnModulTable('+(index_column_function+1)+', '+index_column_function+')" style="margin-right: 15px;">'
                                tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.5 0l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z" transform="translate(0 1)"></path></svg>'
                                tableHtml += '</button>'
                                if(iDataTable!=0){
                                    tableHtml += '<button type="button" class="btn btn-success float-right btn-sm" onclick="moveColumnModulTable('+(index_column_function-1)+', '+index_column_function+')" style="margin-right: 15px;">'
                                    tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M4 0l-4 4 1.5 1.5 2.5-2.5 2.5 2.5 1.5-1.5-4-4z" transform="translate(0 1)"></path></svg>'
                                    tableHtml += '</button>'
                                }
                            tableHtml += '</td>'
                        tableHtml += '</tr>'
                        iDataTable++
                    }
                })

                tableHtml += '<tbody>'
            tableHtml += '</table>'

            $( "modul_table" ).html(tableHtml);
            $( '.hidden_col' ).switcher();
            $( "#modul_kolom_"+(iDataTable-1)+" .btn-info" ).remove()

            page_now = 0;
            page_length = 5;
            if(modul_table != '') {
                page_now = modul_table.page.info().page
                page_length = modul_table.page.info().length
            }
            
            modul_table = $( "#example" ).DataTable({
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "rowReorder": true,
                "columnDefs": [
                    { "width": "1%", "targets": 0 }
                ]
            });

            modul_table.on( 'row-reorder', function ( e, diff, edit ) {
                position = replaceString('modul_kolom_','',$(edit.triggerRow.node()).find("[id^=modul_kolom]").attr("id"))                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    beforeData = parseInt(diff[i].oldPosition)
                    afterData = parseInt(diff[i].newPosition)
                    editData = parseInt(position)

                    if( editData == beforeData ) {
                        moveColumnModulTable( beforeData, afterData)
                    }                    
                }        
            });
            
            modul_table.page.len( page_length ).page( page_now ).draw( 'page' );

            if(page_now > (modul_table.page.info().pages-1)) {                
                page_now--
                modul_table.page( page_now ).draw( 'page' );
            }            
        }

        function removeColumnModulTable(i) {
            objModul = $('#modul').serializeJSON()
            column_sementara = objModul['column'][i]
            key_hidden = storage_parameter.find('hidden',column_sementara['name'])
            storage_parameter.remove('hidden.'+key_hidden)            

            removeColumn(i)
            build_modul_tabel(objColumn,objForbiddenCOlumn)

            storage_parameter.remove('column_to_save.' + i)

            if(column_sementara['name'] == 'com_id') {
                $( "#with_companystamp" ).val(0)
            }
        }

        function moveColumnModulTable(i,y) {
            moveColumn(i,y)
            storage_parameter.update('column_to_save', move(storage_parameter.get('column_to_save'), i, y))
            build_modul_tabel(objColumn,objForbiddenCOlumn)
        }

        function tambah_kolom_modul_table_click() {
            tambah_kolom_click();
            objModul = $('#modul').serializeJSON()
            column_sementara = objModul['column_sementara']
            
            storage_parameter.add('column_to_save', column_sementara)

            update_data_storage_hidden_column(column_sementara['name'])

            $.each(column_sementara, function( index_column_sementara, value_column_sementara ) {
                $( "[name='column["+(index_kolom_terakhir_dibuat-1)+"]["+index_column_sementara+"]']" ).val(value_column_sementara).change()
            })

            objModul = $('#modul').serializeJSON()
            objColumn = objModul['column']
            build_modul_tabel(objColumn,objForbiddenCOlumn)

            $( "[name='column_sementara[name]']" ).val('')
            $( "[name='column_sementara[default]']" ).val('')
            $( "[name='column_sementara[comment]']" ).val('')
            $( "[name='column_sementara[hidden]']" ).prop('checked', true).change()
            $( "[name='column_sementara[type]']" ).val('integer').change()
            $( "[name='column_sementara[nullable]']" ).val(1).change()

            modul_table.page( 'last' ).draw( 'page' );
            // $( ".row_modul_table_"+(index_kolom_terakhir_dibuat-1) ).removeClass( "d-none" );
        }

        function ubahColumnModulTable(i) {
            $( "#add_kolom" ).addClass('d-none')
            $( "#ubah_kolom" ).removeClass('d-none')
            $( "#ubah_kolom" ).attr("onclick","ubah_kolom_modul_table_click("+i+")")

            $.each(objColumn[i], function( index_column_sementara, value_column_sementara ) {
                $( "[name='column_sementara["+index_column_sementara+"]']" ).val(value_column_sementara).change()
            })

            $( "[name='column_sementara[hidden]']" ).prop('checked', false).change()
            if( storage_parameter.find('hidden',objColumn[i]['name']) == -1 ) {
                $( "[name='column_sementara[hidden]']" ).prop('checked', true).change()
            }

            $('html, body').animate({
                scrollTop: $( "#table_name" ).offset().top
            }, 1000, function() {
                $( "[name='column_sementara[name]']" ).focus();
            });
        }

        function ubah_kolom_modul_table_click(i) {
            objModul = $('#modul').serializeJSON()
            column_sementara = objModul['column_sementara']

            storage_parameter.update('column_to_save.' + i, column_sementara)

            update_data_storage_hidden_column(column_sementara['name'])
            
            $.each(objModul['column_sementara'], function( index_column_sementara, value_column_sementara ) {
                $( "[name='column["+i+"]["+index_column_sementara+"]']" ).val(value_column_sementara).change()
            })
            objModul = $('#modul').serializeJSON()
            objColumn = objModul['column']
            build_modul_tabel(objColumn,objForbiddenCOlumn)

            $( "[name='column_sementara[name]']" ).val('')
            $( "[name='column_sementara[default]']" ).val('')
            $( "[name='column_sementara[comment]']" ).val('')
            $( "[name='column_sementara[hidden]']" ).prop('checked', true).change()
            $( "[name='column_sementara[type]']" ).val('integer').change()
            $( "[name='column_sementara[nullable]']" ).val(1).change()

            $( "#add_kolom" ).removeClass('d-none')
            $( "#ubah_kolom" ).addClass('d-none')
        }

        function update_data_storage_hidden_column(column_sementara_name){
            
            key_hidden = storage_parameter.find('hidden',column_sementara_name)
            if( column_sementara['hidden'] ) {
                // jika di check, hapus data jika ada
                if( key_hidden != -1 ) {
                    storage_parameter.remove('hidden.'+key_hidden)
                }
            }else {
                // jika tidak di check, tambah data jika belum ada
                if( key_hidden == -1 ) {
                    storage_parameter.add('hidden',column_sementara_name)
                }
            }
        }

        function ubahHiddenInTable(ele,i) {
            if($(ele).is(':checked')) {                
                key_hidden = storage_parameter.find('hidden',objModul.column[i].name)
                storage_parameter.remove('hidden.'+key_hidden)
            }else {
                storage_parameter.add('hidden',objModul.column[i].name)
            }
        }
    </script>

    <script>
        submit_url = '{{url('/')}}/buildMigration';
        // function simpanKeApi() {
            
        //     objModul = $('#modul').serializeJSON()
        //     delete objModul['route']

        //     $.ajax({
        //         url: '{{url('/')}}/buildMigration',
        //         type: "POST",
        //         data: JSON.stringify(Object.assign({}, objModul, storage_parameter.all() )),
        //         contentType: "application/json; charset=utf-8",
        //         dataType: "json",
        //         success: function (data) {
        //             htmlcreated = ''
        //             htmlupdated = ''
        //             $.each(data,function(index,value) {
        //                 $.each(value,function(index_2,value_2) {
        //                     if(index == 'created') {
        //                         htmlcreated += value_2+"<br>"
        //                     }else {
        //                         htmlupdated += value_2+"<br>"
        //                     }
                            
        //                 })
        //             })

        //             html = ''
        //             if(htmlcreated != '') {
        //                 html += 'created <br>'+htmlcreated+'<br>'
        //             }
        //             if(htmlupdated != '') {
        //                 html += 'updated <br>'+htmlupdated+'<br>'
        //             }
                    
        //             $( "#modal_1 .modal-body" ).html(html)
        //             $( "#launch_modal_1" ).click()
        //         },
        //         error:function (data) {                    
        //             if( data.responseJSON ) {
        //                 $( "#modal_1 .modal-body" ).html(data.responseJSON.message)
        //             }else {
        //                 $( "#modal_1 .modal-body" ).html('Tidak ada perubahan')
        //             }
        //             $( "#launch_modal_1" ).click()
        //         }
        //     });
        // }
    </script>

    <script>
        function prefixChange(ele){
            $( '.'+($(ele).attr('name')).replace(/[\[\]']+/g,'') ).html('api/'+ele.value+objModul['name']+'/')
        }        
    </script>

    <script>
        function companyStampChange(ele) {
            if( ele.value == 1 ) {
                has_company_column = 0
                $.each(objColumn, function( e, v ) {
                    if(v.name == 'com_id') {
                        has_company_column = e
                    }   
                })
                if(!has_company_column) {
                    tambah_kolom_click();
                    $( "[name='column["+(index_kolom_terakhir_dibuat-1)+"][name]']" ).val('com_id').change()
                    $( "[name='column["+(index_kolom_terakhir_dibuat-1)+"][type]']" ).val('integer').change()
                    
                    storage_parameter.add('hidden','com_id')

                    objModul = $('#modul').serializeJSON()
                    objColumn = objModul['column']
                    build_modul_tabel(objColumn,objForbiddenCOlumn)
                    
                    moveColumnModulTable(index_kolom_terakhir_dibuat-1,1)
                }
            }else {
                
                index_company_column = false
                $.each(objColumn, function( e, v ) {
                    if(v.name == 'com_id') {
                        index_company_column = e
                    }   
                })

                if(index_company_column && objColumn[index_company_column]) {                    
                    removeColumnModulTable(String(index_company_column))
                }
            }
        }
    </script>

    <script>
        function deleteModal(ele){
            $( "#deleteModal" ).modal('show')
            $( "#confirm_delete" ).attr('onclick','confirm_delete('+$(ele).attr('data_id')+')')
        }

        function confirm_delete(id) {
            data = {
                'old_data': storage_parameter.get('list_data.'+id),
                'table':$( '[name*="table"]' ).val()
            }

            $.ajax({
                url: '/deleteData',
                type: 'POST',
                crossDomain: true,
                data: JSON.stringify(data),
                processData: false,
                contentType: 'application/json',
                success: function (data) {
                    list_data.ajax.reload( null, false )
                    $( "#deleteModal" ).modal('hide')
                },
                error:function (data) {
                    $('#modal_1 .modal-body').html('delete data failed')
                    $( "#modal_1" ).modal('show')
                }

            })
        }
        
        function showModalAddData() {
            
            column = storage_parameter.get('list_column')

            html = ''
            $.each(column, function( index, value ) {
                html += '<div class="form-group">'
                    html += '<label>'+value.name+'</label>'
                    html += '<input type="" class="form-control" value="" onkeyup="addToData(this)" data_name="'+value.name+'">'
                html += '</div>'
                
            })

            $('#modalData .modal-body').html(html)
            $('#modalData .btn-primary').attr('onclick','add_data()')
            $('#modalData').modal('toggle');
        }

        function add_data() {
            addDataTable({
                "data"  : storage_parameter.get('data_to_add'),
                "table" : $( '[name*="table"]' ).val()
            })
        }

        function addToData(ele) {
            if( typeof storage_parameter.get('data_to_add.'+$(ele).attr('data_name')) != 'undefined' ){
                storage_parameter.remove('data_to_add.'+$(ele).attr('data_name'))
            }

            if( $(ele).val() ) {
                storage_parameter.add('data_to_add.'+$(ele).attr('data_name'))
                storage_parameter.update('data_to_add.'+$(ele).attr('data_name'),$(ele).val())
            }
        }

        function buildListData(cols) {
            storage_parameter.update('list_column',cols)

            arr_list = [];
            html = ''
            html += '<table id="list-data" class="table table-striped table-bordered table-hover" style="width:100%;">'
                html += '<thead>'
                    html += '<tr>'
                        html += '<th scope="col">#</th>'
                        arr_list.push({ 
                            data:'nomor_baris',
                        })
                        $.each(cols, function( index, value ) {
                            html += '<th scope="col">'+value['name']+'</th>'
                            arr_list.push({ 
                                data:value['name'],
                                render: function (data, type, row, meta) {
                                    return '<span class="datatable-data">'+escapeHtml(data)+'</span><input value="'+escapeHtml(data)+'" class="datatable-editor" style="width: 100%;" data_index="'+row.nomor_baris+'" data_column="'+value.name+'">'
                                }    
                            })
                        })
                        html += '<th scope="col">Action</th>'
                    html += '</tr>'
                html += '</thead>'
                html += '<tbody>'
                html += '</tbody>'
            html += '</table>'

            $('list-data').html(html)

            arr_list.push({ 
                data: 'nomor_baris',
                "render": function ( data, type, row, meta ) {
                    return '<button type="button" onclick="deleteModal(this)" data_id="'+data+'" class="btn btn-danger float-right btn-sm" style="margin-right: 15px;"><svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg></button>';
                }
            })

            list_data = $( "#list-data" ).DataTable({
                // "sDom": "Rlfrtip",
                "scrollX": true,
                "autoWidth": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "processing": false,
                "serverSide": true,
                // "select":true,
                "ajax": {
                    "url": "{{url('/')}}/dataTable/"+$( '[name*="table"]' ).val(),
                    "dataSrc": function ( data ) {
                        data_to_index = []
                        $.each(data.data, function( index, value ) {
                            data_to_index[value.nomor_baris] = value
                        })
                        storage_parameter.update('list_data',data_to_index)
                        return data.data ;
                    },
                    "data": function ( d ) {
                        delete d['columns']
                        d.order[0]['column'] = arr_list[d.order[0]['column']]['data']
                        return d
                    }
                },
                "columns": arr_list
            });

            // list_data.on( 'select', function ( e, dt, type, indexes ) {
            //     if ( type === 'row' ) {
            //         var data = list_data.rows( indexes ).data().pluck( 'id' );
            //         console.log(e,dt,type,indexes)
            //         // do something with the ID of the selected items
            //     }
            // } );

            $('#tabdata div.dataTables_wrapper').css('max-width','1100px')

            elem = $("#tabdata")[0]; 
  
            let resizeObserver = new ResizeObserver(() => { 
                $('#tabdata div.dataTables_wrapper').css('max-width',(93.3/100*elem.offsetWidth)+'px')
            }); 
    
            resizeObserver.observe(elem);

            $('#list-data tbody').on( 'click', 'td', function () {
                thisele = $(this)
                $(this).addClass('show-editor')
                thiseditor = $(this).find('.datatable-editor')
                thiseditor.focus()

                $(this).find('.datatable-editor').unbind().focusout(function(){
                    index = thiseditor.attr('data_index')
                    column = thiseditor.attr('data_column')
                    value = thiseditor.val()

                    simpanDataTable({
                        'old_data':storage_parameter.get('list_data.'+index),
                        'column':column,
                        'value':value,
                        'table':$( '[name*="table"]' ).val()
                    })

                    thisele.removeClass('show-editor')

                    list_data.ajax.reload( null, false )
                })

            } );
        }
    </script>
    
    <script src="<?php echo URL::to('/vendor/khancode/js/list-index.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/submit.js');?>"></script>

    <script>
        $( document ).ready(function() {
            $(".loading").hide();
        });
    </script>
@endsection