<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR'+nama_relasi+'iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        figure.highlight {
            background-color: #f8f9fa;
            padding: 20px 40px;
        }
        .form-control::-webkit-input-placeholder { color: #a0a3a77a; }  /* WebKit, Blink, Edge */
        .form-control:-moz-placeholder { color: #a0a3a77a; }  /* Mozilla Firefox 4 to 18 */
        .form-control::-moz-placeholder { color: #a0a3a77a; }  /* Mozilla Firefox 19+ */
        .form-control:-ms-input-placeholder { color: #a0a3a77a; }  /* Internet Explorer 10-11 */
        .form-control::-ms-input-placeholder { color: #a0a3a77a; }  /* Microsoft Edge */
        .btn-delete {
            width: calc(1.5em + .75rem - 2px);
            padding: 0px;
            margin: 0;
            height: calc(1.5em + .75rem - 2px);
        }
        .form-control {
            height: calc(1.5em + .75rem - 2px);
            padding: 0.10rem .75rem;
        }
    </style>
    <title>Create Modul</title>
  </head>
  <body>
    <br>
    <div class="container">
        <h4 class="row">
            <span class="col-sm">Detail Modul </span>
            <button type="button" class="btn btn-success float-right col-sm-2 btn-sm" onclick="simpanKeApi()" style="margin-right: 15px;">Simpan</button>
        </h4>
        <form id="modul">
            <div class="form-group">
                <label>Nama Modul</label>
                <input type="" class="form-control" id="modul_name" placeholder="nama modul" name='name' onkeyup="ambil_data_modul(this)">
            </div>
            <div class="form-group">
                <label>Nama Table</label>
                <input type="" class="form-control" id="table_name" placeholder="nama tabel" name='table' onkeyup="ambil_data_tabel(this)">
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tabel-tab" data-toggle="tab" href="#tabel" role="tab" aria-controls="tabel" aria-selected="true">Tabel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabeloption-tab" data-toggle="tab" href="#tabeloption" role="tab" aria-controls="tabeloption" aria-selected="false">Tabel Option</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="kolomfungsi-tab" data-toggle="tab" href="#kolomfungsi" role="tab" aria-controls="route" aria-selected="false">Kolom Fungsi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="relasi-tab" data-toggle="tab" href="#relasi" role="tab" aria-controls="relasi" aria-selected="false">Relasi Tabel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="route-tab" data-toggle="tab" href="#route" role="tab" aria-controls="route" aria-selected="false">Route Modul</a>
                </li>                
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">
                    <!-- kolom -->
                    <figure class="highlight">                                        

                        <list_kolom>
                        </list_kolom>

                        <br>
                        <input class="btn btn-primary" type="button" value="Tambah Kolom" height='10px' id='add_kolom' onclick="tambah_kolom_click()">
                        
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
                            <select class="form-control" id="with_companystamp" name="with_companystamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                    </figure>
                </div>
                <div class="tab-pane fade" id="relasi" role="tabpanel" aria-labelledby="relasi-tab">
                    <!-- relasi -->
                    <figure class="highlight">                    

                        <list_relasi>
                        </list_relasi>

                        <br>                    
                        <input class="btn btn-primary" type="button" value="Tambah Relasi" height='10px' id='add_relasi'>

                    </figure>
                </div>
                <div class="tab-pane fade" id="route" role="tabpanel" aria-labelledby="route-tab">
                    <!-- route -->
                    <figure class="highlight">                        

                        <list_route>
                        </list_route>

                        <br>                    
                        <input class="btn btn-primary" type="button" value="Tambah Route" height='10px' id='add_route'>

                    </figure>
                </div>
                <div class="tab-pane fade" id="kolomfungsi" role="tabpanel" aria-labelledby="route-tab">
                    <!-- route -->
                    <figure class="highlight">                        

                        <list_function_column>                                                                                        
                        </list_function_column>

                        <br>                    
                        <input class="btn btn-primary" type="button" value="Tambah Kolom Fungsi" height='10px' id='add_function_column'>

                    </figure>
                </div>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/2.9.0/jquery.serializejson.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>    
    <script src="<?php echo URL::to('/js/ace.js');?>"></script>

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

        function change_route_process(ele,i) {
            if(ele.value == 'custom_data') {                
                html_code_php = 
                    '<div class="mt-3 custom_data_'+i+' ">'+
                        '<textarea name="route['+i+'][custom_function]" class="d-none">'+
                            '\\DB::beginTransaction();'+"\n"+
                            '$single_data = $this->getSingleData(1);'+"\n"+
                            '\\DB::commit();'+"\n"+
                            'return new \\App\\Http\\Resources\\YourResource($data);'+"\n"+
                        '</textarea>'+
                        '<textarea id="route_text_'+i+'">'+
                            '\\DB::beginTransaction();'+"\n"+
                            '$single_data = $this->getSingleData(1);'+"\n"+
                            '\\DB::commit();'+"\n"+
                            'return new \\App\\Http\\Resources\\YourResource($data);'+"\n"+                            
                        '</textarea>'+
                    '</div>'

                $(ele).parent().parent().parent().append(html_code_php)
                
                eval("code_editor_process_" + i + "= ace.edit('route_text_'+i, {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false})")
                eval("code_editor_process_" + i + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
                eval("code_editor_process_" + i + ".getSession().on('change', function(e) {val_code = code_editor_process_"+i+".getSession().getValue();$( '[name=\"route["+i+"][custom_function]\"]' ).val(val_code);})")
            }else {
                $( '.custom_data_'+i ).remove()
            }
        }

        function ubah_type_kolom(data,i) {
            if(data.value == 'decimal') {
                html_decimal_detail = 
                    '<input type="" class="form-control" placeholder="precision (default = 8)" name="column['+i+'][precision]">'+
                    '<input type="" class="form-control" placeholder="scale (default = 2)" name="column['+i+'][scale]">';
                $(data).parent().append(html_decimal_detail);
            }else {
                $( "[name='column["+i+"][precision]']" ).remove()
                $( "[name='column["+i+"][scale]']" ).remove()
            }
        }

        function ubah_type_relasi(data,i) {
            data_sebelum = get_data_array(objModul,'relation.'+i+'.type','')
            data_sesudah = data.value
                    
            objModul = $('#modul').serializeJSON()
            if( data_sebelum == '' || data_sebelum == 'belongs_to_many' || data_sesudah == 'belongs_to_many') {
                $( "[class*='has_many_"+i+"']" ).remove()
                $( "[class*='has_one_"+i+"']" ).remove()
                $( "[class*='belongs_to_many_"+i+"']" ).remove()
                $( "[class*='belongs_to_"+i+"']" ).remove()

                if( data.value == "has_many" || data.value == "has_one" || data.value == "belongs_to" ) {
                    html_relasi_detail = ''

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Name </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama tabel relasi" name="relation['+i+'][name]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Tabel </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama tabel relasi" name="relation['+i+'][table]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Foreign Key </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="ferign key relasi" name="relation['+i+'][foreign_key]">'+
                            '</div>'+
                        '</div>'+
                        '';                
                }
                
                if( data.value == "belongs_to_many" ) {
                    html_relasi_detail = ''

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Name </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama relasi" name="relation['+i+'][name]">'+
                            '</div>'+
                        '</div>'+
                        '';
                    
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Nama Model Relasi</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama model relasi, default nama relasi" name="relation['+i+'][model_name]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Tabel </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama tabel relasi" name="relation['+i+'][table]">'+
                            '</div>'+
                        '</div>'+
                        '';
                    
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Foreign Key Model </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="foregin key tabel relasi" name="relation['+i+'][foreign_key_model]">'+
                            '</div>'+
                        '</div>'+
                        '';
                    
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Foreign Key Joining Model </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="foregin key joining tabel relasi" name="relation['+i+'][foreign_key_joining_model]">'+
                            '</div>'+
                        '</div>'+
                        '';
                    
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Intermediate Tabel </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="intermediate table" name="relation['+i+'][intermediate_table]">'+
                            '</div>'+
                        '</div>'+
                        '';                
                }

                html_relasi_detail += 
                    '<div class="row mb-3 '+data.value+'_'+i+'">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Custom Join </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input type="" class="form-control" placeholder="custom join relasi (ex:left join zw_com_products on (zw_com_products.id=zw_com_order_products.product_id))" name="relation['+i+'][custom_join]">'+
                        '</div>'+
                    '</div>'+
                    '';

                html_relasi_detail += 
                    '<div class="row mb-3 '+data.value+'_'+i+'">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Custom option </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input type="" class="form-control" placeholder="custom option relasi (ex:and zw_com_products.deleted_by is null and zw_com_products.com_id = \'.user()->com_id.\')" name="relation['+i+'][custom_option]">'+
                        '</div>'+
                    '</div>'+
                    '';

                html_relasi_detail += 
                    '<div class="row mb-3 '+data.value+'_'+i+'">'+
                        '<div class="col-sm-8" style="padding-top:5px;">'+
                            '<label><b>Kolom Relasi</b></label>'+
                        '</div>'+                        
                    '</div>'+
                    '';

                html_relasi_detail +=
                    '<div class="container '+data.value+'_'+i+' kolom_relasi_'+data.value+'_'+i+'">'+                    
                    '</div>'+
                    '';
                
                html_relasi_detail += "<input class='btn btn-secondary mb-3 "+data.value+'_'+i+"' type='button' value='Tambah Kolom Relasi' height='10px' onclick=\"tambah_kolom_relasi('"+data.value+"',"+i+",0)\">";

                if( data.value == "belongs_to_many" ) {
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-8" style="padding-top:5px;">'+
                                '<label><b>Kolom Tambahan di Intermediate Tabel</b></label>'+
                            '</div>'+                        
                        '</div>'+
                        '';

                    html_relasi_detail +=
                        '<div class="container '+data.value+'_'+i+' kolom_tambahan_relasi_'+data.value+'_'+i+'">'+                        
                        '</div>'+
                        '';
                    
                    html_relasi_detail += "<input class='btn btn-secondary "+data.value+'_'+i+"' type='button' value='Tambah Kolom tambahan di Intermediate Tabel' height='10px' onclick=\"tambah_kolom_tambahan_relasi('"+data.value+"',"+i+",0)\">";
                }            
                
                $(data).parent().parent().parent().append(html_relasi_detail);
            }else {
                if(data_sebelum!=data_sesudah) {               
                    $( '.'+data_sebelum+'_'+i ).addClass( data_sesudah+'_'+i ).removeClass( data_sebelum+'_'+i )
                }
            }
        }

        function tambah_kolom_tambahan_relasi(data,irelasi,ikolom) {
            html_kolom_tambahan_relasi_detail =
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>'+(ikolom+1)+'.&nbsp&nbspNama</label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input type="" class="form-control" placeholder="nama" name="relation['+irelasi+'][column_add_on]['+ikolom+'][name]">'+
                        '</div>'+
                        '<div class="col-sm-1" style="padding-top:5px;">'+
                            '<label>Tipe</label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<select class="form-control" name="relation['+irelasi+'][column_add_on]['+ikolom+'][type]">'+
                                '<option value="integer">Integer</option>'+
                                '<option value="string">String</option>'+
                            '</select>'+
                        '</div>'+
                        '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_tambahan_relasi(\''+data+'\','+irelasi+','+ikolom+')">x</button>'+
                    '</div>'+
                '';

            $( '.kolom_tambahan_relasi_'+data+'_'+irelasi+'' ).append(html_kolom_tambahan_relasi_detail);
            $( "[onclick=\"tambah_kolom_tambahan_relasi('"+data+"',"+irelasi+","+(ikolom)+")\"]" ).attr('onclick',"tambah_kolom_tambahan_relasi('"+data+"',"+irelasi+","+(ikolom+1)+")");
        }

        function tambah_kolom_relasi(data,irelasi,ikolom) {
            html_kolom_relasi_detail =
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>'+(ikolom+1)+'.&nbsp&nbspNama</label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input type="" class="form-control" placeholder="nama" name="relation['+irelasi+'][select_column]['+ikolom+'][name]">'+
                        '</div>'+
                        '<div class="col-sm-1" style="padding-top:5px;">'+
                            '<label>Kolom</label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input type="" class="form-control" placeholder="nama kolom" name="relation['+irelasi+'][select_column]['+ikolom+'][column]">'+
                        '</div>'+
                        '<div class="col-sm-1" style="padding-top:5px;">'+
                            '<label>Tipe</label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<select class="form-control" name="relation['+irelasi+'][select_column]['+ikolom+'][type]">'+
                                '<option value="integer">Integer</option>'+
                                '<option value="string">String</option>'+
                            '</select>'+
                        '</div>'+
                        '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_relasi(\''+data+'\','+irelasi+','+(ikolom)+')">x</button>'+
                    '</div>'+
                '';

            $( '.kolom_relasi_'+data+'_'+irelasi+'' ).append(html_kolom_relasi_detail);
            $( "[onclick=\"tambah_kolom_relasi('"+data+"',"+irelasi+","+(ikolom)+")\"]" ).attr('onclick',"tambah_kolom_relasi('"+data+"',"+irelasi+","+(ikolom+1)+")");
        }

        function tambah_relasi(jumlah_relasi) {
            objModul = $('#modul').serializeJSON()
            nama_relasi = jumlah_relasi
            window.jumlah_relasi = jumlah_relasi
            window.jumlah_relasi++
            jumlah_relasi = window.jumlah_relasi
            html_new_relasi = 
                '<label for="relasi'+jumlah_relasi+'" class="col-sm-12"><b>Relasi '+jumlah_relasi+'</b> <button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeRelasi(\'relation.'+nama_relasi+'\')">Hapus</button></label>'+
                '<div class="container mb-4">'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Type </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<select class="form-control relasi_type_'+nama_relasi+'" onchange="ubah_type_relasi(this,'+nama_relasi+')" name="relation['+nama_relasi+'][type]">'+
                                '<option value="belongs_to">Belongs To</option>'+
                                '<option value="has_one">Has One</option>'+
                                '<option value="has_many">Has Many</option>'+
                                '<option value="belongs_to_many">Many to Many</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '';
            $( "list_relasi" ).append(html_new_relasi);
            $( '.relasi_type_'+nama_relasi ).val('belongs_to').change();
        }

        function tambah_kolom(jumlah_kolom,type) {
            nama_kolom = jumlah_kolom
            window.jumlah_kolom = jumlah_kolom
            window.jumlah_kolom++
            jumlah_kolom = window.jumlah_kolom

            if(typeof type === 'undefined') {
                type = ''
                window.index_kolom_terakhir_dibuat = jumlah_kolom
                if(nama_kolom!=0) {
                    $( ".d-none_"+(nama_kolom-1) ).removeClass( "d-none" );
                }
            }

            button = ''
            if(jumlah_kolom != 1) {
                button = '<button type="button" class="btn btn-success" onclick="moveColumn('+nama_kolom+', '+(nama_kolom-1)+')">up</button>'
            }            

            html_new_kolom = 
                '<div class="row '+type+'">'+
                    '<label for="column1" class="col-sm-12">'+
                        '<b>Kolom '+jumlah_kolom+'</b>'+
                        '<button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeColumn(\''+nama_kolom+'\')" style="margin-right: 15px;">Hapus</button>'+
                        '<div class="btn-group btn-group-sm float-right col-sm-2" role="group">'+
                            button+
                            '<button type="button" class="btn btn-info d-none d-none_'+nama_kolom+'" onclick="moveColumn('+(nama_kolom+1)+', '+nama_kolom+')">down</button>'+
                        '</div>'+
                    '</label>'+
                '</div>'+
                '<div class="container '+type+'">'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Name </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input name="column['+nama_kolom+'][name]" type="text" class="form-control" placeholder="nama kolom">'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Type </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<div class="input-group">'+
                                '<select class="form-control" onchange="ubah_type_kolom(this,'+nama_kolom+')" name="column['+nama_kolom+'][type]">'+
                                    '<option value="increment">Increment</option>'+
                                    '<option value="integer" selected="selected">Integer</option>'+
                                    '<option value="smallInteger">Small Integer</option>'+
                                    '<option value="decimal">Decimal</option>'+
                                    '<option value="datetime">Datetime</option>'+
                                    '<option value="timestamp">Timestamp</option>'+
                                    '<option value="string">String</option>'+
                                    '<option value="text">Text</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Default </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input name="column['+nama_kolom+'][default]" type="text" class="form-control" placeholder="default value kolom">'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Comment </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input name="column['+nama_kolom+'][comment]" type="text" class="form-control" placeholder="komentar kolom">'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Nullable </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<select class="form-control" name="column['+nama_kolom+'][nullable]">'+
                                '<option value="1">Yes</option>'+
                                '<option value="0">No</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '';            
            $( "list_kolom" ).append(html_new_kolom);
        }

        function tambah_validasi(i_route,i_ele) {
            html_validasi = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Validasi Parameter</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="nama parameter" name="route['+i_route+'][validation]['+i_ele+'][name]">'+
                    '</div>'+
                    '<div class="col-sm-1" style="padding-top:5px;">'+
                        '<label>Validasi</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="(ex:required|numeric)" name="route['+i_route+'][validation]['+i_ele+'][statement]" att="validation_'+i_route+'_'+i_ele+'">'+
                    '</div>'+
                    '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_validasi('+i_route+','+i_ele+')" att="remove_validation_'+i_route+'_'+i_ele+'">x</button>'+
                '</div>'+
                '';

            $( ".route_"+i_route ).append(html_validasi)

            $( '[onclick="tambah_validasi('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_validasi('+i_route+','+(i_ele+1)+')')
        }

        function tambah_route_parameter(i_route,i_ele) {
            html_parameter = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Nama</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="nama parameter" name="route['+i_route+'][param]['+i_ele+']">'+
                    '</div>'+
                    '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_parameter_route('+i_route+','+i_ele+')">x</button>'+
                '</div>'+
                '';

            $( ".route_param_"+i_route ).append(html_parameter)

            $( '[onclick="tambah_route_parameter('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_route_parameter('+i_route+','+(i_ele+1)+')')
        }

        function tambah_route(jumlah_route) {
            objModul = $('#modul').serializeJSON()
            nama_route = jumlah_route
            window.jumlah_route = jumlah_route
            window.jumlah_route++
            jumlah_route = window.jumlah_route
            html_new_route = 
                '<label class="col-sm-12"><b>Route '+jumlah_route+'</b> <button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeRoute(\'route.'+nama_route+'\')">Hapus</button></label>'+
                '<div class="container mb-4">'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Nama </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input name="route['+nama_route+'][name]" type="text" class="form-control" placeholder="nama route">'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Proses </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<select class="form-control" name="route['+nama_route+'][process]" onchange="change_route_process(this,'+nama_route+')">'+
                                '<option value="list_data">Mengambil Banyak Data</option>'+
                                '<option value="single_data">Mengambil Satu Data</option>'+
                                '<option value="create_data">Menyimpan Data</option>'+
                                '<option value="update_data">Memperbaharui Data</option>'+
                                '<option value="delete_data">Menghapus Data</option>'+
                                '<option value="custom_data">Custom</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Route Method</label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<select class="form-control" name="route['+nama_route+'][method]">'+
                                '<option value="get">GET</option>'+
                                '<option value="post">POST</option>'+
                                '<option value="put">PUT</option>'+
                                '<option value="delete">DELETE</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label><b>Parameter Route</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="container route_param_'+nama_route+'">'+                        
                    '</div>'+
                    '<input class="btn btn-secondary mb-3" type="button" value="Tambah Parameter" height="10px" onclick="tambah_route_parameter('+nama_route+',0)">'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label><b>Validasi Data</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="container route_'+nama_route+'">'+                        
                    '</div>'+
                    '<input class="btn btn-secondary" type="button" value="Tambah Validasi" height="10px" onclick="tambah_validasi('+nama_route+',0)">'+
                '</div>'+
                '';

            $( "list_route" ).append(html_new_route);
        }

        function tambah_kolom_click() {
            objModul = $('#modul').serializeJSON()
            objColumn = toArray(objModul.column)
            objColumn.splice(index_kolom_terakhir_dibuat, 0, {});
            objModul["column"] = objColumn
            build_kolom_tabel(objColumn,objForbiddenCOlumn);
        }

        function tambah_kolom_fungsi(i_kolom_fungsi) {
            objModul = $('#modul').serializeJSON()
            nama_kolom_fungsi = jumlah_kolom_fungsi
            window.jumlah_kolom_fungsi = jumlah_kolom_fungsi
            window.jumlah_kolom_fungsi++
            jumlah_kolom_fungsi = window.jumlah_kolom_fungsi

            button = ''
            if(nama_kolom_fungsi!=0) {
                $( ".d-none_kolom_fungsi_"+(nama_kolom_fungsi-1) ).removeClass( "d-none" );
            }

            if(nama_kolom_fungsi > 0) {
                button = '<button type="button" class="btn btn-success" onclick="moveColumnFunction('+nama_kolom_fungsi+', '+(nama_kolom_fungsi-1)+')">up</button>'
            }

            html_new_kolom_fungsi = 
                '<div class="row ">'+
                    '<label for="column1" class="col-sm-12">'+
                        '<b>Kolom Fungsi '+jumlah_kolom_fungsi+'</b>'+
                        '<button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeColumnFunction('+nama_kolom_fungsi+')" style="margin-right: 15px;">Hapus</button>'+
                        '<div class="btn-group btn-group-sm float-right col-sm-2" role="group">'+
                            button+
                            '<button type="button" class="btn btn-info d-none d-none_kolom_fungsi_'+nama_kolom_fungsi+'" onclick="moveColumnFunction('+jumlah_kolom_fungsi+', '+nama_kolom_fungsi+')">down</button>'+
                        '</div>'+
                    '</label>'+
                '</div>'+
                '<div class="container ">'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Name </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input name="column_function['+nama_kolom_fungsi+'][name]" type="text" class="form-control" placeholder="nama kolom">'+
                        '</div>'+
                    '</div>'+
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Fungsi </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<textarea name="column_function['+nama_kolom_fungsi+'][function]" class="d-none"></textarea>'+
                            '<textarea id="column_function_'+nama_kolom_fungsi+'"></textarea>'+
                            '<pre>*input ".code." akan di baca kode php</pre>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '';

            $( "list_function_column" ).append(html_new_kolom_fungsi);

            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('column_function_'+nama_kolom_fungsi, {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\"column_function["+nama_kolom_fungsi+"][function]\"]' ).val(val_code);})")

            // code_editor[nama_kolom_fungsi] = ace.edit('column_function_'+nama_kolom_fungsi, {
            //     mode: "ace/mode/sql",
            //     maxLines: 30,
            //     minLines: 5,
            //     wrap: true,
            // })

            // code_editor[nama_kolom_fungsi].getSession().on('change', function(e) {
            //     val_code = code_editor[nama_kolom_fungsi].getSession().getValue()            
            //     $( '[name="column_function['+nama_kolom_fungsi+'][function]"]' ).val(val_code)
            // });
        }

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout(timer);
                timer = setTimeout(callback,ms);
            };
        })();

        $( document ).ready(function() {

            $( "#add_relasi" ).click(function( event ) {
                tambah_relasi(jumlah_relasi)
                window.objModul = $('#modul').serializeJSON()
            });

            $( "#add_route" ).click(function( event ) {
                tambah_route(jumlah_route)
                window.objModul = $('#modul').serializeJSON()                
            })
            
            $( "#add_function_column" ).click(function( event ) {
                tambah_kolom_fungsi(jumlah_kolom_fungsi)
                window.objModul = $('#modul').serializeJSON()                
            })

        });
    </script>

    <script>

        var objModul;
        
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

        function remove_validasi(iroute, iparameter) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,'route.'+iroute+'.validation.'+iparameter)
            build_validasi(iroute)
        }

        function build_validasi(iroute,validation_data) {
            $( ".route_"+iroute ).html('')
            if(typeof validation_data === 'undefined') {
                validation_data = get_data_array(objModul,'route.'+iroute+'.validation',[])
            }
            $( "[onclick=\"tambah_validasi("+iroute+","+(Object.keys(validation_data).length+1)+")\"]" ).attr('onclick',"tambah_validasi("+iroute+",0)");
            i = 0            
            $.each(validation_data, function( index, value ) {
                tambah_validasi(iroute,i)
                $( '[name="route['+iroute+'][validation]['+i+'][name]"]' ).val(value['name'])
                $( '[name="route['+iroute+'][validation]['+i+'][statement]"]' ).val(value['statement'])
                i++
            });
        }

        function remove_kolom_parameter_route(iroute, iparameter) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,'route.'+iroute+'.param.'+iparameter)
            build_kolom_parameter_route(iroute)
        }

        function build_kolom_parameter_route(iroute,parameter_route_data) {
            $( ".route_param_"+iroute ).html('')
            if(typeof parameter_route_data === 'undefined') {
                parameter_route_data = toArray(get_data_array(objModul,'route.'+iroute+'.param',[]))
            }
            $( "[onclick=\"tambah_route_parameter("+iroute+","+(parameter_route_data.length+1)+")\"]" ).attr('onclick',"tambah_route_parameter("+iroute+",0)");
            i = 0            
            $.each(parameter_route_data, function( index, value ) {
                tambah_route_parameter(iroute,i)
                $( '[name="route['+iroute+'][param]['+i+']"]' ).val(value)
                i++
            });
        }

        function removeColumnFunction(i_kolom_fungsi) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,'column_function.'+i_kolom_fungsi)
            build_kolom_fungsi(objModul)
        }

        function remove_kolom_tambahan_relasi(data, irelasi, ikolom) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,'relation.'+irelasi+'.column_add_on.'+ikolom)
            build_kolom_tambahan_relasi_modul(data,irelasi,ikolom)
        }

        function build_kolom_tambahan_relasi_modul(data,irelasi,ikolom) {
            $( ".kolom_tambahan_relasi_"+data+"_"+irelasi ).html('')
            add_on_column_data = toArray(get_data_array(objModul,'relation.'+irelasi+'.column_add_on',[]))
            $( "[onclick=\"tambah_kolom_tambahan_relasi('"+data+"',"+irelasi+","+(add_on_column_data.length+1)+")\"]" ).attr('onclick',"tambah_kolom_tambahan_relasi('"+data+"',"+irelasi+",0)");
            i = 0
            $.each(add_on_column_data, function( index, value ) {
                tambah_kolom_tambahan_relasi(data,irelasi,i)
                $( '[name="relation['+irelasi+'][column_add_on]['+i+'][name]"]' ).val(value['name'])
                $( '[name="relation['+irelasi+'][column_add_on]['+i+'][type]"]' ).val(value['type'])
                i++
            });
        }

        function remove_kolom_relasi(data, irelasi, ikolom) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,'relation.'+irelasi+'.select_column.'+ikolom)
            build_kolom_relasi_select_column_modul(data,irelasi,ikolom)
        }        

        function build_kolom_relasi_select_column_modul(data,irelasi,ikolom) {
            $( ".kolom_relasi_"+data+"_"+irelasi ).html('')
            select_column_data = toArray(get_data_array(objModul,'relation.'+irelasi+'.select_column',[]))
            $( "[onclick=\"tambah_kolom_relasi('"+data+"',"+irelasi+","+(select_column_data.length+1)+")\"]" ).attr('onclick',"tambah_kolom_relasi('"+data+"',"+irelasi+",0)");
            i = 0
            $.each(select_column_data, function( index, value ) {
                tambah_kolom_relasi(data,irelasi,i)
                $( '[name="relation['+irelasi+'][select_column]['+i+'][name]"]' ).val(value['name'])
                $( '[name="relation['+irelasi+'][select_column]['+i+'][column]"]' ).val(value['column'])
                $( '[name="relation['+irelasi+'][select_column]['+i+'][type]"]' ).val(value['type'])
                i++
            });
            // $( "[onclick=\"tambah_kolom_relasi('"+data+"',"+irelasi+","+(i+1)+")\"]" ).attr('onclick',"tambah_kolom_relasi('"+data+"',"+irelasi+","+(i)+")");
        }

        function moveColumnFunction(old_index, new_index) {
            objModul = $('#modul').serializeJSON()
            objModul.column_function = toArray(objModul.column_function)
            objModul.column_function = move(objModul.column_function, old_index, new_index)
            build_kolom_fungsi(objModul);
        }

        function moveColumn(old_index, new_index) {
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

        function removeRoute(data) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,data)
            build_kolom_route_modul(objModul)
        }

        function removeRelasi(data) {
            objModul = $('#modul').serializeJSON()
            data = data.split('.')
            type_relasi_remove = $( ".relasi_type_"+data[1] ).val() 
            splice_multilevel_array(objModul,data[0]+'.'+data[1])
            build_kolom_relasi_modul(objModul)
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
                    url: '{{url('/')}}/table?table='+ele.value,
                    jsonpCallback: 'testing',
                    dataType: 'json',
                    success: function(json) {
                        if(json[ele.value]) {
                            objColumn = json[ele.value]
                            objModul['column'] = json[ele.value]
                            objForbiddenCOlumn = json['forbidden_column_name']
                            build_kolom_tabel(objModul['column'],objForbiddenCOlumn);
                            build_tabel_option_by_column(objModul['column'])
                        }else {
                            objColumn = []
                            objModul['column'] = []
                            objForbiddenCOlumn = []
                            build_kolom_tabel([]);
                            build_tabel_option_by_column([])
                        }
                    },
                    error: function(e) {
                        objColumn = []
                        objModul['column'] = []
                        objForbiddenCOlumn = []
                        build_kolom_tabel([]);
                        build_tabel_option_by_column([])
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

        function set_value_kolom(i,data) {
            $( '[name="column['+i+'][name]"]' ).val(data['name']);
            if(data['type']) {
                $( '[name="column['+i+'][type]"]' ).val(data['type']).change();
            }
            if(data['precision']) {
                $( '[name="column['+i+'][precision]"]' ).val(data['precision']);
            }
            if(data['scale']) {
                $( '[name="column['+i+'][scale]"]' ).val(data['scale']);
            }
            if(data['default']) {
                $( '[name="column['+i+'][default]"]' ).val(data['default']);
            }
            if(data['comment']) {
                $( '[name="column['+i+'][comment]"]' ).val(data['comment']);
            }
            if(data['nullable']) {
                $( '[name="column['+i+'][nullable]"]' ).val(data['nullable']).change();
            }else {
                $( '[name="column['+i+'][nullable]"]' ).val('0').change();
            }
        }

        function ambil_data_modul(ele) {
            delay(function(){
                $.ajax({
                    type: 'GET',
                    url: '{{url('/')}}/modul',
                    jsonpCallback: 'testing',
                    dataType: 'json',
                    success: function(json) {
                        if(json[ele.value])
                        {
                            objModul = json[ele.value]
                            build_semua_kolom(objModul)
                        }else {
                            objModul = []
                            build_semua_kolom([],'')
                        }
                    },
                    error: function(e) {
                        objModul = []
                        build_semua_kolom([],'')
                    }
                });
            }, 500);
        }

        function build_semua_kolom(json) {
            build_tabel_option(json);
            build_kolom_tabel_modul(json);
            build_kolom_relasi_modul(json);
            build_kolom_route_modul(json);
            build_kolom_fungsi(json);
        }
        
        function build_tabel_option_by_column(data) {
            $( '[name="with_timestamp"]' ).val(0).change();
            $( '[name="with_authstamp"]' ).val(0).change();
            $( '[name="with_ipstamp"]' ).val(0).change();
            $( '[name="with_companystamp"]' ).val(0).change();

            $.each(data, function( index, value ) {
                if(value['name'] == 'created_time') $( '[name="with_timestamp"]' ).val(1).change();                
                if(value['name'] == 'created_by') $( '[name="with_authstamp"]' ).val(1).change();                
                if(value['name'] == 'created_from') $( '[name="with_ipstamp"]' ).val(1).change();                
                if(value['name'] == 'com_id') $( '[name="with_companystamp"]' ).val(1).change();                
            });
        }

        function build_tabel_option(data) {
            $( '[name="with_timestamp"]' ).val(0).change();
            $( '[name="with_authstamp"]' ).val(0).change();
            $( '[name="with_ipstamp"]' ).val(0).change();
            $( '[name="with_companystamp"]' ).val(0).change();

            if(data.with_timestamp) $( '[name="with_timestamp"]' ).val(data.with_timestamp).change();
            if(data.with_authstamp) $( '[name="with_authstamp"]' ).val(data.with_authstamp).change();
            if(data.with_ipstamp) $( '[name="with_ipstamp"]' ).val(data.with_ipstamp).change();
            if(data.with_companystamp) $( '[name="with_companystamp"]' ).val(data.with_companystamp).change();
        }

        function build_kolom_tabel_modul(data) {
            if(get_data_array(data,'table')) {
                $( '[name*="table"]' ).val(data['table']).keyup();
            }else {
                $( '[name*="table"]' ).val('').keyup();
            }
        }

        function build_kolom_relasi_modul(data) {
            $( "list_relasi" ).html('');
            jumlah_relasi_builded = 0
            window.jumlah_relasi = 0
            if(get_data_array(data,'relation')) {
                $.each(data['relation'], function( index_relasi, value_relasi ) {
                    tambah_relasi(jumlah_relasi_builded)
                    $( '.relasi_type_'+jumlah_relasi_builded ).val(value_relasi['type']).change();
                    if( value_relasi['name'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][name]"]' ).val(value_relasi['name']);
                    }
                    if( value_relasi['table'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][table]"]' ).val(value_relasi['table']);
                    }
                    if( value_relasi['model_name'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][model_name]"]' ).val(value_relasi['model_name']);
                    }
                    if( value_relasi['foreign_key'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][foreign_key]"]' ).val(value_relasi['foreign_key']);
                    }
                    if( value_relasi['custom_join'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][custom_join]"]' ).val(value_relasi['custom_join']);
                    }
                    if( value_relasi['custom_option'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][custom_option]"]' ).val(value_relasi['custom_option']);
                    }

                    // khusus many to many
                    if( value_relasi['foreign_key_model'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_model]"]' ).val(value_relasi['foreign_key_model']);
                    }
                    if( value_relasi['foreign_key_joining_model'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_joining_model]"]' ).val(value_relasi['foreign_key_joining_model']);
                    }
                    if( value_relasi['intermediate_table'] )
                    {
                        $( '[name="relation['+jumlah_relasi_builded+'][intermediate_table]"]' ).val(value_relasi['intermediate_table']);
                    }

                    select_column_relasi = 0
                    $( '.kolom_relasi_'+value_relasi['type']+'_'+jumlah_relasi_builded ).html('')                    
                    $.each(value_relasi['select_column'], function( index_relasi_detail, value_relasi_detail ) {
                        tambah_kolom_relasi(value_relasi['type'],jumlah_relasi_builded,select_column_relasi)
                        $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][name]"]' ).val(value_relasi_detail['name']);
                        $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][column]"]' ).val(value_relasi_detail['column']);
                        $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][type]"]' ).val(value_relasi_detail['type']);
                        select_column_relasi++
                    });

                    select_column_tambahan_relasi = 0
                    $( '.kolom_tambahan_relasi_'+value_relasi['type']+'_'+jumlah_relasi_builded ).html('')
                    $.each(value_relasi['column_add_on'], function( index_relasi_detail, value_relasi_detail ) {
                        tambah_kolom_tambahan_relasi(value_relasi['type'],jumlah_relasi_builded,select_column_tambahan_relasi)
                        $( '[name="relation['+jumlah_relasi_builded+'][column_add_on]['+select_column_tambahan_relasi+'][name]"]' ).val(value_relasi_detail['name']);                    
                        $( '[name="relation['+jumlah_relasi_builded+'][column_add_on]['+select_column_tambahan_relasi+'][type]"]' ).val(value_relasi_detail['type']);
                        select_column_tambahan_relasi++
                    });

                    jumlah_relasi_builded++

                    // $.each(value_relasi, function( index_relasi_detail, value_relasi_detail ) {
                    //     tambah_relasi(jumlah_relasi_builded)
                    //     $( '.relasi_type_'+jumlah_relasi_builded ).val(index_relasi).change();
                    //     if( value_relasi_detail['name'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][name]"]' ).val(value_relasi_detail['name']);
                    //     }
                    //     if( value_relasi_detail['table'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][table]"]' ).val(value_relasi_detail['table']);
                    //     }
                    //     if( value_relasi_detail['foreign_key'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][foreign_key]"]' ).val(value_relasi_detail['foreign_key']);
                    //     }
                    //     if( value_relasi_detail['custom_join'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][custom_join]"]' ).val(value_relasi_detail['custom_join']);
                    //     }
                    //     if( value_relasi_detail['custom_option'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][custom_option]"]' ).val(value_relasi_detail['custom_option']);
                    //     }

                    //     // khusus many to many
                    //     if( value_relasi_detail['foreign_key_model'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_model]"]' ).val(value_relasi_detail['foreign_key_model']);
                    //     }
                    //     if( value_relasi_detail['foreign_key_joining_model'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_joining_model]"]' ).val(value_relasi_detail['foreign_key_joining_model']);
                    //     }
                    //     if( value_relasi_detail['intermediate_table'] )
                    //     {
                    //         $( '[name="relation['+jumlah_relasi_builded+'][intermediate_table]"]' ).val(value_relasi_detail['intermediate_table']);
                    //     }

                    //     select_column_relasi = 0
                    //     $( '.kolom_relasi_'+index_relasi+'_'+jumlah_relasi_builded ).html('')
                    //     $.each(value_relasi_detail['select_column'], function( index_relasi_detail, value_relasi_detail ) {
                    //         tambah_kolom_relasi(index_relasi,jumlah_relasi_builded,select_column_relasi)
                    //         $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][name]"]' ).val(value_relasi_detail['name']);
                    //         $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][column]"]' ).val(value_relasi_detail['column']);
                    //         $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][type]"]' ).val(value_relasi_detail['type']);
                    //         select_column_relasi++
                    //     });

                    //     select_column_tambahan_relasi = 0
                    //     $( '.kolom_tambahan_relasi_'+index_relasi+'_'+jumlah_relasi_builded ).html('')
                    //     $.each(value_relasi_detail['column_add_on'], function( index_relasi_detail, value_relasi_detail ) {
                    //         tambah_kolom_tambahan_relasi(index_relasi,jumlah_relasi_builded,select_column_tambahan_relasi)
                    //         $( '[name="relation['+jumlah_relasi_builded+'][column_add_on]['+select_column_tambahan_relasi+'][name]"]' ).val(value_relasi_detail['name']);                    
                    //         $( '[name="relation['+jumlah_relasi_builded+'][column_add_on]['+select_column_tambahan_relasi+'][type]"]' ).val(value_relasi_detail['type']);
                    //         select_column_tambahan_relasi++
                    //     });

                    //     jumlah_relasi_builded++
                    // })
                })
            }
        }

        function build_kolom_route_modul(data) {
            $( "list_route" ).html('')
            jumlah_route_builded = 0
            window.jumlah_route = 0
            if(get_data_array(data,'route')) {
                $.each(data['route'], function( index_route, value_route ) {   
                    tambah_route(jumlah_route_builded)
                    $( '[name="route['+jumlah_route_builded+'][name]"]' ).val(value_route['name']);
                    $( '[name="route['+jumlah_route_builded+'][process]"]' ).val(value_route['process']).change();
                    $( '[name="route['+jumlah_route_builded+'][method]"]' ).val(value_route['method']);
                    
                    build_kolom_parameter_route(jumlah_route_builded,value_route['param'])
                    build_validasi(jumlah_route_builded,value_route['validation'])                    
                    
                    if( value_route['process'] == 'custom_data' )
                    {
                        $( '[name="route['+jumlah_route_builded+'][custom_function]"]' ).val(value_route['custom_function'])
                        eval("code_editor_process_" + jumlah_route_builded + ".setValue($( '[name=\"route["+jumlah_route_builded+"][custom_function]\"]' ).val())")
                    }
                    
                    jumlah_route_builded++
                })
            }
        }

        function build_kolom_fungsi(data) {
            $( "list_function_column" ).html('')
            jumlah_kolom_fungsi_builded = 0
            window.jumlah_kolom_fungsi = 0
            if(get_data_array(data,'column_function')) {
                $.each(data['column_function'], function( index_column_function, value_column_function ) {   
                    tambah_kolom_fungsi(jumlah_kolom_fungsi_builded)
                    $( '[name="column_function['+jumlah_kolom_fungsi_builded+'][name]"]' ).val(value_column_function['name']);                    
                    $( '[name="column_function['+jumlah_kolom_fungsi_builded+'][function]"]' ).val(value_column_function['function']);
                    eval("code_editor_" + nama_kolom_fungsi + ".setValue($( '[name=\"column_function["+jumlah_kolom_fungsi_builded+"][function]\"]' ).val())")

                    jumlah_kolom_fungsi_builded++
                })
            }
        }
    </script>

    <script>
        function simpanKeApi() {
            objModul = $('#modul').serializeJSON()
            $.ajax({
                url: '{{url('/')}}/build',
                type: "POST",
                data: $('#modul').serialize(),                
                success: function (data) {
                    htmlcreated = ''
                    htmlupdated = ''
                    $.each(data,function(index,value) {
                        $.each(value,function(index_2,value_2) {
                            if(index == 'created') {
                                htmlcreated += value_2+"<br>"
                            }else {
                                htmlupdated += value_2+"<br>"
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
                    
                    $( "#modal_1 .modal-body" ).html(html)
                    $( "#launch_modal_1" ).click()
                }
            });
        }
    </script>
  </body>
</html>