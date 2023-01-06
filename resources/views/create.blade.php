@extends('khancode::base'.config('laravelrestbuilder.theme'))

@section('title', 'Create Modul')

@section('content')    
    <div class="col-lg-12">        
        <form id="modul">
            <div class="form-group">
                <label>Nama Modul</label>
                <input type="" class="form-control d-none" id="modul_id" name='id' value='{{ Arr::get($data, 'id', 0) }}'>
                <input type="" class="form-control" id="modul_name" placeholder="nama modul" name='name'>
            </div>
            <!-- <div class="form-group">
                <label></label>
                <textarea class="form-control" id="table_name" placeholder="nama tabel" name='table' onkeyup="ambil_data_tabel(this)">
                </textarea>                
            </div> -->
            <div class="form-group">
                <label for="">Nama Table</label>
                <textarea name="table" class="d-none" id="table_name" onchange="ambil_data_tabel(this)"></textarea>
                <textarea id="tab_table"></textarea>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:0px">
                <li class="nav-item">
                    <a class="nav-link active" id="tabel-tab" data-toggle="tab" href="#tabel" role="tab" aria-controls="tabel" aria-selected="true">Tabel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabeloption-tab" data-toggle="tab" href="#tabeloption" role="tab" aria-controls="tabeloption" aria-selected="false">Tabel Option</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="listindex-tab" data-toggle="tab" href="#listindex" role="tab" aria-controls="route" aria-selected="false">Index</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="listcast-tab" data-toggle="tab" href="#listcast" role="tab" aria-controls="route" aria-selected="false">Cast</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="kolomfungsi-tab" data-toggle="tab" href="#kolomfungsi" role="tab" aria-controls="route" aria-selected="false">Kolom Fungsi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="relasi-tab" data-toggle="tab" href="#relasi" role="tab" aria-controls="relasi" aria-selected="false">Relasi Tabel</a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" id="system-class" data-toggle="tab" href="#systemclass" role="tab" aria-controls="systemclass" aria-selected="false">Class System</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="route-tab" data-toggle="tab" href="#route" role="tab" aria-controls="route" aria-selected="false">System Modul</a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" id="repository-class" data-toggle="tab" href="#repositoryclass" role="tab" aria-controls="repositoryclass" aria-selected="false">Class Repository</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="classtab-nav" data-toggle="tab" href="#classtab" role="tab" aria-controls="classtab" aria-selected="false">Class</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="repository-tab" data-toggle="tab" href="#repository" role="tab" aria-controls="repository" aria-selected="false">Repository</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">File</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabel" role="tabpanel" aria-labelledby="tabel-tab">
                    
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
                                                    <option value="json">Json</option>
                                                    <option value="enum">Enum</option>
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
                            <div class="row mb-3">
                                <div class="col-sm-6 form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" checked name="column_sementara[hidden]">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input class="btn btn-primary" type="button" value="Tambah Kolom" height='10px' id='add_kolom' onclick="tambah_kolom_modul_table_click()">                        
                        <input class="d-none btn btn-primary" type="button" value="Ubah Kolom" height='10px' id='ubah_kolom' onclick="ubah_kolom_modul_table_click()">
                        <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_column_sementara_table()">
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
                            <label for="with_timestamp">Key</label>
                            <input type="text" class="form-control" name="key" id="key" placeholder="default: kolom pertama">
                        </div>
                        <div class="form-group">
                            <label for="with_timestamp">Custom Folder</label>
                            <input type="text" class="form-control" name="custom_folder" id="custom_folder" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Increment Key</label>
                            <input class="d-none" name="increment_key" value="0">
                            <div class="form-check form-check-inline with-check col-md">
                                <input checked class="form-check-input" type="checkbox" id="increment_key" name="increment_key" value="1">
                            </div> 
                        </div> 
                        <div class="form-group">
                            <label for="with_timestamp">Time Stamp</label>
                            <select class="form-control" id="with_timestamp" name="with_timestamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="with_timestamp_detail">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".with_timestamp_details" aria-expanded="true" aria-controls="with_timestamp_details"><b>Details</b></label>
                                </div>
                            </div>
                            <div class="col-sm-11 container with_timestamp_details collapse">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_timestamp_details[create]">
                                    <label class="form-check-label" for="with_timestamp_details[create]">create column</label>
                                    <input type="text" class="form-control" name="with_timestamp_details[create_column]" placeholder="default: created_time">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_timestamp_details[update]">
                                    <label class="form-check-label" for="with_timestamp_details[update]">update column</label>
                                    <input type="text" class="form-control" name="with_timestamp_details[update_column]" placeholder="default: updated_time">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_timestamp_details[delete]">
                                    <label class="form-check-label" for="with_timestamp_details[delete]">delete column</label>
                                    <input type="text" class="form-control" name="with_timestamp_details[delete_column]" placeholder="default: deleted_time">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="exampleFormControlSelect1">Auth Stamp</label>
                            <select class="form-control" id="with_authstamp" name="with_authstamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="with_authstamp_detail">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".with_authstamp_details" aria-expanded="true" aria-controls="with_authstamp_details"><b>Details</b></label>
                                </div>
                            </div>
                            <div class="col-sm-11 container with_authstamp_details collapse">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_authstamp_details[create]">
                                    <label class="form-check-label" for="with_authstamp_details[create]">create column</label>
                                    <input type="text" class="form-control" name="with_authstamp_details[create_column]" placeholder="default: created_by">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_authstamp_details[update]">
                                    <label class="form-check-label" for="with_authstamp_details[update]">update column</label>
                                    <input type="text" class="form-control" name="with_authstamp_details[update_column]" placeholder="default: updated_by">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_authstamp_details[delete]">
                                    <label class="form-check-label" for="with_authstamp_details[delete]">delete column</label>
                                    <input type="text" class="form-control" name="with_authstamp_details[delete_column]" placeholder="default: deleted_by">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">IP stamp</label>
                            <select class="form-control" id="with_ipstamp" name="with_ipstamp">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="with_ipstamp_detail">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".with_ipstamp_details" aria-expanded="true" aria-controls="with_ipstamp_details"><b>Details</b></label>
                                </div>
                            </div>
                            <div class="col-sm-11 container with_ipstamp_details collapse">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_ipstamp_details[create]">
                                    <label class="form-check-label" for="with_ipstamp_details[create]">create column</label>
                                    <input type="text" class="form-control" name="with_ipstamp_details[create_column]" placeholder="default: created_from">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_ipstamp_details[update]">
                                    <label class="form-check-label" for="with_ipstamp_details[update]">update column</label>
                                    <input type="text" class="form-control" name="with_ipstamp_details[update_column]" placeholder="default: updated_from">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="with_ipstamp_details[delete]">
                                    <label class="form-check-label" for="with_ipstamp_details[delete]">delete column</label>
                                    <input type="text" class="form-control" name="with_ipstamp_details[delete_column]" placeholder="default: deleted_from">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Company stamp</label>
                            <select class="form-control" id="with_companystamp" name="with_companystamp" onchange="companyStampChange(this)">
                                <option value=0>no</option>                
                                <option value=1>yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Company Restriction</label>
                            <input class="d-none" name="with_company_restriction" value="0">
                            <div class="form-check form-check-inline with-check col-md">
                                <input class="form-check-input" type="checkbox" id="with_company_restriction" name="with_company_restriction" value="1">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label>Delete Restriction</label>
                            <input class="d-none" name="with_delete_restriction" value="1">
                            <div class="form-check form-check-inline with-check col-md">
                                <input class="form-check-input" type="checkbox" id="with_delete_restriction" name="with_delete_restriction" value="0">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Get Company Code</label>
                            <textarea name="get_company_code" class="d-none"></textarea>
                            <textarea id="tab_get_company_code"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Authenticable</label>
                            <input class="d-none" name="with_authenticable" value="0">
                            <div class="form-check form-check-inline with-check col-md">
                                <input class="form-check-input" type="checkbox" id="with_authenticable" name="with_authenticable" value="1">
                            </div> 
                        </div>                       
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Custom Union</label>
                            <textarea name="custom_union" class="d-none"></textarea>
                            <textarea id="tab_custom_union"></textarea>
                            <pre>*input ".code." akan di baca kode php ( tidak di sarankan, karena tidak bisa melakukan pencarian )</pre>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Custom Union Model</label>
                            <div class="">
                                <select class="multi-select2 col-sm-12" name="custom_union_model[]" multiple="">
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Custom Join</label>
                            <textarea name="custom_join" class="d-none"></textarea>
                            <textarea id="tab_custom_join"></textarea>
                            <pre>*input ".code." akan di baca kode php</pre>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Custom Filter</label>
                            <textarea name="custom_filter" class="d-none"></textarea>
                            <textarea id="tab_custom_filter"></textarea>
                            <pre>*input ".code." akan di baca kode php</pre>
                        </div>
                        <div class="form-group">
                            <label for="get_custom_creating">Custom Creating</label>
                            <textarea name="get_custom_creating" class="d-none"></textarea>
                            <textarea id="tab_get_custom_creating"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="get_custom_updating">Custom Updating</label>
                            <textarea name="get_custom_updating" class="d-none"></textarea>
                            <textarea id="tab_get_custom_updating"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="get_custom_deleting">Custom Deleting</label>
                            <textarea name="get_custom_deleting" class="d-none"></textarea>
                            <textarea id="tab_get_custom_deleting"></textarea>
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
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="clear_index_sementara()">
                        </div>

                        <listindex_table>
                        </listindex_table>
                        <!-- <list_relasi class="d-none">
                        </list_relasi> -->

                        <!-- <br> -->
                        <!-- <input class="btn btn-primary" type="button" value="Tambah Relasi" height='10px' id='add_relasi'> -->

                    </figure>
                </div>
                <div class="tab-pane fade" id="listcast" role="tabpanel" aria-labelledby="listcast-tab">
                    <!-- relasi -->
                    <figure class="highlight">

                        <div class="container mb-4">
                            
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Kolom </label>
                                </div>
                                <div class="col-sm">
                                    <input type="" class="form-control autocomplete_column" placeholder="kolom cast" name="cast_sementara[column]">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Tipe Data </label>
                                </div>
                                <div class="col-sm">
                                    <input type="" class="form-control autocomplete_data_cast" placeholder="Tipe Data" name="cast_sementara[data_type]">
                                </div>
                            </div>

                        </div>

                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_cast" type="button" value="Tambah Cast" height="10px" onclick="tambah_list_cast_table()">
                            <input class="btn btn-primary d-none" id="edit_cast" type="button" value="Edit Cast" height="10px" onclick="edit_list_cast_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="clear_cast_sementara()">
                        </div>

                        <listcast_table>
                        </listcast_table>

                    </figure>
                </div>
                <div class="tab-pane fade" id="relasi" role="tabpanel" aria-labelledby="relasi-tab">
                    <!-- relasi -->
                    <figure class="highlight">

                        <div class="container mb-4">
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Type </label>
                                </div>
                                <div class="col-sm">
                                    <select class="form-control relasi_type_relation_sementara" onchange="ubah_type_relasi(this,'relation_sementara')" name="relation[relation_sementara][type]">
                                        <option value="belongs_to">Belongs To</option>
                                        <option value="has_one">Has One</option>
                                        <option value="has_many">Has Many</option>
                                        <option value="belongs_to_many">Many to Many</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_relation" type="button" value="Tambah Relasi" height="10px" onclick="tambah_relation_table()">
                            <input class="btn btn-primary d-none" id="edit_relation" type="button" value="Edit Relasi" height="10px" onclick="edit_relation_table()">
                            <input class="ml-1 btn btn-primary d-none" id="edit_simpan_relation" type="button" value="Ubah Relasi & Simpan" height="10px" onclick="edit_simpan_relation_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_relation_sementara()">
                        </div>

                        <relation_table>
                        </relation_table>
                        <!-- <list_relasi class="d-none">
                        </list_relasi> -->

                        <!-- <br> -->
                        <!-- <input class="btn btn-primary" type="button" value="Tambah Relasi" height='10px' id='add_relasi'> -->

                    </figure>
                </div>
                <div class="tab-pane fade" id="systemclass" role="tabpanel" aria-labelledby="systemclass-tab">
                    <!-- route -->
                    <figure class="highlight">                        

                        <div class="row ">
                            <label for="column1" class="col-sm-12">
                                <b>Class</b>                                
                            </label>
                        </div>
                        <div class="container ">
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Name </label>
                                </div>
                                <div class="col-sm">
                                    <input name="system_class_sementara[name]" type="text" class="form-control" placeholder="nama variable class">
                                </div>
                            </div>                            
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Path Class</label>
                                </div>
                                <div class="col-sm">
                                    <textarea name="system_class_sementara[class_code]" class="d-none"></textarea>
                                    <textarea id="system_class_sementara_class_code"></textarea>
                                    <pre>php code untuk class</pre>
                                </div>
                            </div>                                         
                        </div>
                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_system_class" type="button" value="Tambah column function" height="10px" onclick="tambah_list_system_class_table()">
                            <input class="btn btn-primary d-none" id="edit_system_class" type="button" value="Edit column function" height="10px" onclick="edit_list_system_class_table()">
                            <input class="ml-1 btn btn-primary d-none" id="edit_simpan_system_class" type="button" value="Ubah Kolom Fungsi & Simpan" height="10px" onclick="edit_simpan_system_class_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_system_class_sementara()">
                        </div>

                        <listsystem_class_table>
                        </listsystem_class_table>

                    </figure>
                </div>
                <div class="tab-pane fade" id="route" role="tabpanel" aria-labelledby="route-tab">
                    <!-- route -->
                    <figure class="highlight">
                    
                        <div class="container mb-4">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Nama</label>
                                        </div>
                                        <div class="col-sm">
                                            <input name="route_sementara[name]" type="text" class="form-control" id="inlineFormInputGroup" placeholder="nama">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Prefix</label>
                                        </div>
                                        <div class="col-sm">
                                            <input name="route_sementara[prefix]" type="text" class="form-control" placeholder="prefix route ex:admin/v1/{locale}/" onchange="prefixChange(this)" onkeyup="prefixChange(this)" value="admin/v1/{locale}/">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Proses </label>
                                        </div>
                                        <div class="col-sm">
                                            <select class="form-control" name="route_sementara[process]" onchange="change_route_process(this,'route_sementara')">
                                                <option value="list_data">Mengambil Banyak Data</option>
                                                <option value="single_data">Mengambil Satu Data</option>
                                                <option value="create_data">Menyimpan Data</option>
                                                <option value="update_data">Memperbaharui Data</option>
                                                <option value="delete_data">Menghapus Data</option>
                                                <option value="custom_data">Custom</option>
                                                <option value="system_data">Fungsi System</option>
                                                <option value="create_update_data">Menyimpan atau memperbaharui data</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-top:5px;">
                                            <label>Method</label>
                                        </div>
                                        <div class="col-sm">
                                            <select class="form-control" name="route_sementara[method]">
                                                <option value="get">GET</option>
                                                <option value="post">POST</option>
                                                <option value="put">PUT</option>
                                                <option value="delete">DELETE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 tanpa_route_div">
                                <div class="col-sm-1" style="padding-top:5px;">
                                    <label>Tanpa Route</label>
                                </div>                                
                                <div class="col-sm-1">                                    
                                    <div class="form-check form-check-inline with-check">                                        
                                        <input class="form-check-input tanpa_route" type="checkbox" onchange="show_hide_tanpa_route(this)">
                                    </div>
                                </div>
                                <div>
                                    <input class="form-check-input" type="text" name="route_sementara[tanpa_route]" style="display:none" value=0>
                                </div>
                            </div>

                            <div class="row mb-3 route_advanced_middleware">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_middleware_route_sementara" aria-expanded="true" aria-controls="route_middleware_route_sementara"><b>Middleware</b></label>
                                </div>
                            </div>
                            <div class="container route_middleware_route_sementara collapse">
                            </div>

                            <div class="row mb-3 route_traits_top">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_traits" aria-expanded="true" aria-controls="route_traits"><b>Traits</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_traits collapse">
                                <div class="container route_traits_sementara">
                                </div>
                                <input class="btn btn-secondary mb-3" type="button" value="Tambah Traits" height="10px" onclick="tambah_traits('traits_sementara',0)">
                            </div>

                            <div class="row mb-3 route_advanced_param">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse" data-target=".route_parameter_tambahan" aria-expanded="true" aria-controls="route_parameter_tambahan"><b>Route Parameter</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_parameter_tambahan">
                                <div class="container route_param_route_sementara">                                    
                                </div>
                                <input class="btn btn-secondary mb-3" type="button" value="Tambah Parameter" height="10px" onclick="tambah_route_parameter('route_sementara',1)">
                            </div>
                            
                            <div class="row mb-3 route_custom_check_single_data">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_parameter_custom_check_single_data" aria-expanded="true" aria-controls="route_parameter_custom_check_single_data"><b>Custom check single data</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_parameter_custom_check_single_data collapse">
                                <div class="form-group">
                                    <textarea name="route_sementara[custom_check_single_data]" class="d-none"></textarea>
                                    <textarea id="tab_route_sementara[custom_check_single_data]"></textarea>
                                    <pre>*input ".code." akan di baca kode php</pre>
                                </div>
                            </div>

                            <data-filter style="display:none">
                                <div class="row mb-3">
                                    <div class="col-sm" style="padding-top:5px;">
                                        <label data-toggle="collapse" class="list-collapse collapsed" data-target=".data-filter" aria-expanded="true" aria-controls="data-filter"><b>Pembatasan Parameter</b></label>
                                    </div>
                                </div>
                                <div class="col-sm data-filter collapse" style="">
                                    <div class="container data_filter_sementara"></div>
                                    <input class="btn btn-secondary mb-3" type="button" value="Tambah Parameter" height="10px" onclick="tambah_data_filter_parameter(0)">
                                    <input class="btn btn-secondary mb-3" type="button" value="Import Semua Kolom" height="10px" onclick="tambah_data_import_semua()">
                                </div>
                            </data-filter>                            

                            <div class="row mb-3 route_advanced_validation">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_validasi" aria-expanded="true" aria-controls="route_validasi"><b>Validasi Data</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_validasi collapse">
                                <div class="container form-group">
                                    <label>Advanced Validasi</label>                                    
                                    <div class="form-check form-check-inline with-check col-md">
                                        <input class="form-check-input" type="checkbox" id="with_advanced_validation" name="route_sementara[advanced_validation]" onchange="to_advanced_validation(this)">
                                    </div> 
                                </div>
                                <div class="container route_route_sementara normal_validation">
                                </div>
                                <input class="btn btn-secondary mb-3 normal_validation" type="button" value="Tambah Validasi" height="10px" onclick="tambah_validasi('route_sementara',0)">
                                <div class="container advanced_validation" style="display:none">
                                    <textarea name="route_sementara[advanced_validation_code]" class="d-none" data-editor="php" rows="10"></textarea>
                                    <textarea id="tab_route_sementara[advanced_validation_code]"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3 route_fungsi_check_relasi">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_fungsi_check_relasi_collapse" aria-expanded="true" aria-controls="route_fungsi_check_relasi_collapse"><b>Fungsi Check Data Repository Relasi</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_fungsi_check_relasi_collapse collapse">
                                <fungsi_check_relation_table>
                                </fungsi_check_relation_table>
                            </div>
                            
                            <custom></custom>             
                            
                            <div class="row mb-3 route_fungsi_relasi">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_relasi" aria-expanded="true" aria-controls="route_relasi"><b>Fungsi Create Simpan Data Relasi</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_relasi collapse">
                                <fungsi_relation_table>
                                </fungsi_relation_table>
                            </div>

                        </div>

                        <div class="row container mb-4">
                            <input class="ml-1 btn btn-primary tambah_route" type="button" value="Tambah Route" height="10px" onclick="tambah_route_table()">                            
                            <input class="ml-1 btn btn-primary d-none edit_route" type="button" value="Ubah Route" height="10px" onclick="edit_route_table()">
                            <input class="ml-1 btn btn-primary d-none edit_simpan_route" type="button" value="Ubah Route & Simpan" height="10px" onclick="edit_simpan_route_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_route_sementara()">
                        </div>
                        
                        <!-- table -->
                        <route_table>
                        </route_table>

                        <list_route>
                        </list_route>
                        
                        <br>                    
                        <input class="btn btn-primary d-none" type="button" value="Tambah Route" height='10px' id='add_route'>

                    </figure>
                </div>
                <div class="tab-pane fade" id="kolomfungsi" role="tabpanel" aria-labelledby="kolomfungsi-tab">
                    <!-- route -->
                    <figure class="highlight">                        

                        <!-- <list_function_column>                                                                                        
                        </list_function_column>

                        <br>                    
                        <input class="btn btn-primary" type="button" value="Tambah Kolom Fungsi" height='10px' id='add_function_column'> -->

                        <div class="row ">
                            <label for="column1" class="col-sm-12">
                                <b>Kolom Fungsi</b>
                                <!-- <button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeColumnFunction('+nama_kolom_fungsi+')" style="margin-right: 15px;">Hapus</button> -->
                                <!-- <div class="btn-group btn-group-sm float-right col-sm-2" role="group">
                                    button
                                    <button type="button" class="btn btn-info d-none d-none_kolom_fungsi_'+nama_kolom_fungsi+'" onclick="moveColumnFunction('+jumlah_kolom_fungsi+', '+nama_kolom_fungsi+')">down</button>
                                </div> -->
                            </label>
                        </div>
                        <div class="container ">
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Name </label>
                                </div>
                                <div class="col-sm">
                                    <input name="column_function_sementara[name]" type="text" class="form-control" placeholder="nama kolom">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Sql Query</label>
                                </div>
                                <div class="col-sm">
                                    <textarea name="column_function_sementara[function]" class="d-none"></textarea>
                                    <textarea id="column_function_sementara"></textarea>
                                    <pre>*input ".code." akan di baca kode php</pre>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Response Code</label>
                                </div>
                                <div class="col-sm">
                                    <textarea name="column_function_sementara[response_code]" class="d-none"></textarea>
                                    <textarea id="column_function_sementara_response_code"></textarea>
                                    <pre>php code untuk response</pre>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Json </label>
                                </div>
                                <div class="col-sm">
                                    <div class="form-check form-check-inline with-check">
                                        <input class="form-check-input" type="checkbox" name="column_function_sementara[json]" value="1">
                                    </div>
                                </div>
                            </div>              
                        </div>
                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_column_function" type="button" value="Tambah column function" height="10px" onclick="tambah_list_column_function_table()">
                            <input class="btn btn-primary d-none" id="edit_column_function" type="button" value="Edit column function" height="10px" onclick="edit_list_column_function_table()">
                            <input class="ml-1 btn btn-primary d-none" id="edit_simpan_column_function" type="button" value="Ubah Kolom Fungsi & Simpan" height="10px" onclick="edit_simpan_column_function_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_column_function_sementara()">
                        </div>

                        <listcolumn_function_table>
                        </listcolumn_function_table>

                    </figure>
                </div>
                <div class="tab-pane fade" id="repositoryclass" role="tabpanel" aria-labelledby="repositoryclass-tab">
                    <!-- route -->
                    <figure class="highlight">                        

                        <div class="row ">
                            <label for="column1" class="col-sm-12">
                                <b>Class</b>                                
                            </label>
                        </div>
                        <div class="container ">
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Name </label>
                                </div>
                                <div class="col-sm">
                                    <input name="repository_class_sementara[name]" type="text" class="form-control" placeholder="nama variable class">
                                </div>
                            </div>                            
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Path Class</label>
                                </div>
                                <div class="col-sm">
                                    <textarea name="repository_class_sementara[class_code]" class="d-none"></textarea>
                                    <textarea id="repository_class_sementara_class_code"></textarea>
                                    <pre>php code untuk class</pre>
                                </div>
                            </div>                                         
                        </div>
                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_repository_class" type="button" value="Tambah column function" height="10px" onclick="tambah_list_repository_class_table()">
                            <input class="btn btn-primary d-none" id="edit_repository_class" type="button" value="Edit column function" height="10px" onclick="edit_list_repository_class_table()">
                            <input class="ml-1 btn btn-primary d-none" id="edit_simpan_repository_class" type="button" value="Ubah Kolom Fungsi & Simpan" height="10px" onclick="edit_simpan_repository_class_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_repository_class_sementara()">
                        </div>

                        <listrepository_class_table>
                        </listrepository_class_table>

                    </figure>
                </div>
                <div class="tab-pane fade" id="classtab" role="tabpanel" aria-labelledby="classtab-tab">
                    <!-- route -->
                    <figure class="highlight">                        

                        <div class="row ">
                            <label for="column1" class="col-sm-12">
                                <b>Class</b>                                
                            </label>
                        </div>
                        <div class="container ">
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Modul </label>
                                </div>
                                <div class="col-sm">
                                    <select class="form-control" onchange="ubah_type_kolom_modul_table(this)" name="classtab_sementara[modul]">
                                        <option value="controller">Controller</option>
                                        <option value="model">Model</option>
                                        <option value="service" selected="selected">Service</option>
                                        <option value="repository">Repository</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Path Class</label>
                                </div>
                                <div class="col-sm">
                                    <textarea name="classtab_sementara[class_path]" class="d-none"></textarea>
                                    <textarea id="tab_classtab_sementara[class_path]"></textarea>
                                    <pre>php code untuk class</pre>
                                </div>
                            </div>                                         
                        </div>
                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_classtab" type="button" value="Tambah column function" height="10px" onclick="tambah_list_classtab_table()">
                            <input class="btn btn-primary d-none" id="edit_classtab" type="button" value="Edit column function" height="10px" onclick="edit_list_classtab_table()">
                            <input class="ml-1 btn btn-primary d-none" id="edit_simpan_classtab" type="button" value="Ubah Kolom Fungsi & Simpan" height="10px" onclick="edit_simpan_classtab_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_classtab_sementara()">
                        </div>

                        <listclasstab_table>
                        </listclasstab_table>

                    </figure>
                </div>
                <div class="tab-pane fade" id="repository" role="tabpanel" aria-labelledby="repository-tab">
                    <!-- repository -->
                    <figure class="highlight">
                        <div class="row ">
                            <label for="column1" class="col-sm-12">
                                <b>Repository Function</b>                                
                            </label>
                        </div>
                        <div class="container ">
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Name </label>
                                </div>
                                <div class="col-sm">
                                    <input name="repository_sementara[name]" type="text" class="form-control" placeholder="nama fungsi">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse" data-target=".repository_param" aria-expanded="true" aria-controls="repository_param"><b>Parameter</b></label>
                                </div>
                            </div>
                            <div class="col-sm repository_param collapse show" style="">
                                <div class="container repository_param_sementara"></div>
                                <input class="btn btn-secondary mb-3" type="button" value="Tambah Parameter" height="10px" onclick="tambah_repository_parameter(0)">
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2" style="padding-top:5px;">
                                    <label>Code</label>
                                </div>
                                <div class="col-sm">
                                    <textarea name="repository_sementara[code]" class="d-none"></textarea>
                                    <textarea id="repository_sementara_code"></textarea>
                                    <pre>*input ".code." akan di baca kode php</pre>
                                </div>
                            </div>                                          
                        </div>
                        <div class="row container mb-4">
                            <input class="btn btn-primary" id="tambah_repository" type="button" value="Tambah repository function" height="10px" onclick="tambah_list_repository_table()">
                            <input class="btn btn-primary d-none" id="edit_repository" type="button" value="Edit repository function" height="10px" onclick="edit_list_repository_table()">                            
                            <input class="ml-1 btn btn-primary d-none" id="edit_simpan_repository" type="button" value="Ubah Repository & Simpan" height="10px" onclick="edit_simpan_repository_table()">
                            <input class="ml-1 btn btn-danger" type="button" value="reset" height="10px" onclick="reset_repository_sementara()">
                        </div>

                        <listrepository_table>
                        </listrepository_table>

                    </figure>
                </div>
                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                    <!-- file -->
                    <figure class="highlight">
                        <listfiles_table>
                        </listfiles_table>
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
            </div>
            </div>
        </div>
    </div>
    
    <div class="modal"><!-- Place at bottom of page --></div>
@endsection

@section('script_add_on')    

    <?php
        // $models = array();
        // $select2_data = array();
        
        // if( session('project')['lang'] == 'php' ) {
            // $dir = app_path().'/../../'.session('project')['folder'].'/app/';

            // \KhanCode\LaravelRestBuilder\FileCreator::createPath($dir.'Http/Controllers/');
            // \KhanCode\LaravelRestBuilder\FileCreator::createPath($dir.'Http/Models/');
            // \KhanCode\LaravelRestBuilder\FileCreator::createPath($dir.'Http/Services/');
            // \KhanCode\LaravelRestBuilder\FileCreator::createPath($dir.'Http/Repositories/');
            // \KhanCode\LaravelRestBuilder\FileCreator::createPath($dir.'Http/Resources/');
            // \KhanCode\LaravelRestBuilder\FileCreator::createPath($dir.'Exceptions/');
            
            // $files = scandir($dir.'Http/Controllers/');
            // $namespace = '\App\Http\Controllers\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
            // }

            // $files = scandir($dir.'Http/Models/');
            // $namespace = '\App\Http\Models\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
                    
            //         $select2_data[] = [
            //             'id'    => preg_replace('/.php$/', '', $file),
            //             'text'  => preg_replace('/.php$/', '', $file)
            //         ];
            // }

            // $files = scandir($dir.'Http/Model/');
            // $namespace = '\App\Http\Model\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
                    
            //         $select2_data[] = [
            //             'id'    => preg_replace('/.php$/', '', $file),
            //             'text'  => preg_replace('/.php$/', '', $file)
            //         ];
            // }

            // $files = scandir($dir.'Http/Services/');
            // $namespace = '\App\Http\Services\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
            // }

            // $files = scandir($dir.'Http/Repositories/');
            // $namespace = '\App\Http\Repositories\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
            // }

            // $files = scandir($dir.'Http/Resources/');
            // $namespace = '\App\Http\Resources\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
            // }

            // $files = scandir($dir.'Exceptions/');
            // $namespace = '\App\Exceptions\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
            // }

            // $files = scandir($dir.'Http/');
            // $namespace = '\App\Http\\';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.php$/', '', $file);
            // }
            
        // }else if( session('project')['lang'] == 'go' ) {
            // $models[] = "strconv";
            // $models[] = "olsera.com/kikota/exceptions";

            // $dir = app_path().'/../../'.session('project')['folder'].'/app/';

            // $files = scandir($dir.'models/');
            // $namespace = '';
            // foreach($files as $file) {
            //     //skip current and parent folder entries and non-php files
            //     if ($file == '.' || $file == '..' || !preg_match('/.go/', $file)) continue;
            //         $models[] = $namespace . preg_replace('/.go$/', '', $file);
                    
            //         $select2_data[] = [
            //             'id'    => preg_replace('/.go$/', '', $file),
            //             'text'  => preg_replace('/.go$/', '', $file)
            //         ];
            // }
        // }
    ?>
    <script>   
        var dataModels = <?php echo json_encode($models)?>;
        var select2_data = <?=json_encode($select2_data)?>;
        
        var langTools = ace.require("ace/ext/language_tools");
        var staticWordCompleter = {
            getCompletions: function(editor, session, pos, prefix, callback) {
                var wordList = dataModels
                callback(null, wordList.map(function(word) {
                    return {
                        caption: word,
                        value: word,
                        meta: "static"
                    };
                }));

            }
        }

        langTools.addCompleter(staticWordCompleter)
        
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
        dataOld = {}

        function change_route_process(ele,i) {

            $("#modul_name").val()
            
            $( '.custom_data_'+i ).find('textarea').each(function(e,k){
                if(typeof( $(k).attr('name') ) != 'undefined' && $(k).val() != ""){
                    dataOld[$(k).attr('name')] = $(k).val()
                }
            })

            if(i == 'route_sementara') {
                toAppend = $('custom')
                name_route = 'route_sementara'
            }else   {
                toAppend = $(ele).parent().parent().parent()
                name_route = 'route['+i+']'
            }

            $( "[name^='route_sementara[prefix]']" ).prop('disabled',false)
            $( "[name^='route_sementara[middleware_parameter]']" ).prop('disabled',false)
            $( "[name^='route_sementara[middleware]']" ).prop('disabled',false).change()
            $( "[name^='route_sementara[validation]']" ).prop('disabled',false)
            $( "[name^='route_sementara[method]']" ).prop('disabled',false)
            $( ".route_advanced_middleware" ).removeClass('d-none')            
            $( ".route_advanced_validation" ).removeClass('d-none')
            $( ".route_advanced_middleware + div" ).removeClass('d-none')
            $( ".route_advanced_validation + div" ).removeClass('d-none')
            $( ".tanpa_route_div" ).removeClass('d-none')

            if( ele.value == 'create_data' || ele.value == 'update_data' || ele.value == 'create_update_data') {                
                $( ".route_fungsi_check_relasi" ).removeClass('d-none')
                $( ".route_fungsi_check_relasi + div" ).removeClass('d-none')

                $( ".route_fungsi_relasi" ).removeClass('d-none')
                $( ".route_fungsi_relasi + div" ).removeClass('d-none')
            }else {
                $( ".route_fungsi_check_relasi" ).addClass('d-none')
                $( ".route_fungsi_check_relasi + div" ).addClass('d-none')

                $( ".route_fungsi_relasi" ).addClass('d-none')
                $( ".route_fungsi_relasi + div" ).addClass('d-none')
            }

            if( ele.value == 'update_data' || ele.value == 'delete_data' || ele.value == 'single_data' || ele.value == 'delete_data' ) {
                $('.route_custom_check_single_data').removeClass('d-none')
                $('.route_parameter_custom_check_single_data').removeClass('d-none')
            }else{
                $('.route_custom_check_single_data').addClass('d-none')
                $('.route_parameter_custom_check_single_data').addClass('d-none')
            }

            single_data_code = ''
            if( project_lang == 'php' ){
                if( ele.value == 'single_data' ){
                    single_data_code = '$single_data = $this->getSingleData(1);\n' 
                }
            }else if ( project_lang == 'golang' ){

                if (storage_parameter.get("column_to_save.0.type") == 'bigint'){
                    if( ele.value == 'single_data' ){
                        single_data_code = ''
                        single_data_code += 'idt, err_int := strconv.ParseInt(id, 10, 64)\n'
                        single_data_code += 'if( err_int != nil ){\n'
                            single_data_code += '\texceptions.ValidateException(7, `url param id must be a number`)\n'
                            single_data_code += '\treturn nil, err_int\n'
                        single_data_code += '}\n'
                        single_data_code += 'singleData := tx.Where("id = ?", idt)\n'

                        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
                    }else if( ele.value == 'delete_data' ){
                        single_data_code = ''
                        single_data_code += 'idt, err_int := strconv.ParseInt(id, 10, 64)\n'
                        single_data_code += 'if( err_int != nil ){\n'
                            single_data_code += '\texceptions.ValidateException(7, `url param id must be a number`)\n'
                            single_data_code += '\treturn nil, err_int\n'
                        single_data_code += '}\n'
                        single_data_code += 'keyForDelete["id"] = idt\n'

                        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
                    }else if( ele.value == 'update_data' ){
                        single_data_code = ''
                        single_data_code += 'idt, err_int := strconv.ParseInt(id, 10, 64)\n'
                        single_data_code += 'if( err_int != nil ){\n'
                            single_data_code += '\texceptions.ValidateException(7, `url param id must be a number`)\n'
                            single_data_code += '\treturn nil, err_int\n'
                        single_data_code += '}\n'
                        single_data_code += 'singleData:= tx.Model(&this_model).Where("id = ?", idt)'

                        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
                    }
                }else{
                    if( ele.value == 'single_data' ){
                        single_data_code = ''
                        single_data_code += 'idt, err_int := strconv.Atoi(id)\n'
                        single_data_code += 'if( err_int != nil ){\n'
                            single_data_code += '\texceptions.ValidateException(7, `url param id must be a number`)\n'
                            single_data_code += '\treturn nil, err_int\n'
                        single_data_code += '}\n'
                        single_data_code += 'singleData := tx.Where("id = ?", idt)\n'

                        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
                    }else if( ele.value == 'delete_data' ){
                        single_data_code = ''
                        single_data_code += 'idt, err_int := strconv.Atoi(id)\n'
                        single_data_code += 'if( err_int != nil ){\n'
                            single_data_code += '\texceptions.ValidateException(7, `url param id must be a number`)\n'
                            single_data_code += '\treturn nil, err_int\n'
                        single_data_code += '}\n'
                        single_data_code += 'keyForDelete["id"] = idt\n'

                        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
                    }else if( ele.value == 'update_data' ){
                        single_data_code = ''
                        single_data_code += 'idt, err_int := strconv.Atoi(id)\n'
                        single_data_code += 'if( err_int != nil ){\n'
                            single_data_code += '\texceptions.ValidateException(7, `url param id must be a number`)\n'
                            single_data_code += '\treturn nil, err_int\n'
                        single_data_code += '}\n'
                        single_data_code += 'singleData:= tx.Model(&this_model).Where("id = ?", idt)'

                        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
                    }
                }
                
            }

            if(ele.value == 'custom_data') {

                html_code_php = 
                    '<div class="mt-3 custom_data_'+i+' ">'+                        
                        '<textarea name="'+name_route+'[custom_function]" class="d-none" rows="10">'+isi_after+
                        '</textarea>'+
                        '<textarea id="tab_'+name_route+'[custom_function]">'+isi_after+
                        '</textarea>'+
                    '</div>';

                // html_code_php = 
                //     '<div class="mt-3 custom_data_'+i+' ">'+
                //         '<textarea name="'+name_route+'[custom_function]" class="d-none">'+
                //             '\\DB::beginTransaction();'+"\n"+
                //             single_data_code+
                //             '\\DB::commit();'+"\n"+
                //             'return new \\App\\Http\\Resources\\YourResource($data);'+"\n"+
                //         '</textarea>'+
                //         '<textarea id="route_text_'+i+'">'+
                //             '\\DB::beginTransaction();'+"\n"+
                //             single_data_code+
                //             '\\DB::commit();'+"\n"+
                //             'return new \\App\\Http\\Resources\\YourResource($data);'+"\n"+                            
                //         '</textarea>'+
                //     '</div>'
                                
                $( '.custom_data_'+i ).remove()
                toAppend.append(html_code_php)
                
                if(i == 'route_sementara') {
                    aceGenerate({ name_cols : name_route + "[custom_function]" });
                    // eval("code_editor_process_" + i + "= ace.edit('route_text_'+i, {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
                    // eval("code_editor_process_" + i + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
                    // eval("code_editor_process_" + i + ".getSession().on('change', function(e) {val_code = code_editor_process_"+i+".getSession().getValue();$( '[name=\""+name_route+"[custom_function]\"]' ).val(val_code);})")
                    // eval("")
                }            
            }else if(ele.value == 'system_data') {
                html_code_php = 
                    '<div class="mt-3 custom_data_'+i+' ">'+
                        '<textarea name="'+name_route+'[system_function]" class="d-none">'+
                            '// locking function'+"\n"+
                            '\\DB::beginTransaction();'+"\n"+
                            single_data_code+
                            '\\DB::commit();'+"\n"+
                            '// unlocking function'+"\n"+
                            'return true;'+"\n"+
                        '</textarea>'+
                        '<textarea id="route_text_'+i+'">'+
                            '// locking function'+"\n"+
                            '\\DB::beginTransaction();'+"\n"+
                            single_data_code+
                            '\\DB::commit();'+"\n"+
                            '// unlocking function'+"\n"+
                            'return true;'+"\n"+                            
                        '</textarea>'+
                    '* untuk menggunakan lock, jangan hilangkan "// locking function" dan "// unlocking function"'+
                    '</div>'
                
                $( "[name^='route_sementara[prefix]']" ).prop('disabled',true)
                $( "[name^='route_sementara[middleware]']" ).prop('disabled',true)
                $( "[name^='route_sementara[middleware_parameter]']" ).prop('disabled',true)                
                $( "[name^='route_sementara[validation]']" ).prop('disabled',true)
                $( "[name^='route_sementara[method]']" ).prop('disabled',true)
                $( ".route_advanced_middleware" ).addClass('d-none')
                $( ".route_advanced_validation" ).addClass('d-none')
                $( ".route_advanced_middleware + div" ).addClass('d-none')
                $( ".route_advanced_validation + div" ).addClass('d-none')

                $( '.custom_data_'+i ).remove()
                toAppend.append(html_code_php)
                
                if(i == 'route_sementara') {
                    eval("code_editor_process_" + i + "= ace.edit('route_text_'+i, {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
                    eval("code_editor_process_" + i + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
                    eval("code_editor_process_" + i + ".getSession().on('change', function(e) {val_code = code_editor_process_"+i+".getSession().getValue();$( '[name=\""+name_route+"[system_function]\"]' ).val(val_code);})")
                    eval("")
                }            
            }else {

                if( ele.value == 'delete_data' ) {
                    $( "[name^='route_sementara[validation]']" ).prop('disabled',true)                
                    $( ".route_advanced_validation" ).addClass('d-none')
                    $( ".route_validasi" ).hide()
                    $( "data-filter" ).hide()
                }else {
                    $( "[name^='route_sementara[validation]']" ).prop('disabled',false)                
                    $( ".route_advanced_validation" ).removeClass('d-none')
                    $( ".route_validasi" ).collapse('hide')
                    $( "data-filter" ).collapse('hide')
                    // $( ".route_validasi" ).show()
                    $( 'data-filter' ).show()
                }
                
                isi_before = ''
                if( dataOld[name_route+'[custom_code_before]'] ){ 
                    isi_before = dataOld[name_route+'[custom_code_before]']
                }

                isi_after = ''
                if( dataOld[name_route+'[custom_code_after]'] ){ 
                    isi_after = dataOld[name_route+'[custom_code_after]']
                }
                
                if( project_lang == 'php' ){
                    if(ele.value == 'create_update_data' && !isi_before.includes("$keyFirstOrCreate")) {
                        isi_before = '$keyFirstOrCreate = [\'key\' => \'value\'];'+"\n"+isi_before
                    }
                }else if( project_lang == 'golang' ){
                    if(ele.value == 'create_update_data' && !isi_before.includes("keyFirstOrCreate")) {
                        isi_before = 'keyFirstOrCreate.Key = data["value"].(string)'+"\n"+isi_before
                    }
                }

                html_code_php = 
                    '<div class="row mb-3 custom_data_'+i+'">'+
                        '<div class="col-sm-3" style="padding-top:5px;">'+
                            '<label><b>Custom Code Before</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="mt-3 custom_data_'+i+' custom_code_before_'+i+' ">'+                        
                        '<textarea name="'+name_route+'[custom_code_before]" class="d-none" rows="10">'+isi_before+
                        '</textarea>'+
                        '<textarea id="tab_'+name_route+'[custom_code_before]">'+isi_before+
                        '</textarea>'+
                    '</div>';

                html_code_php += 
                    '<div class="row mb-3 custom_data_'+i+'">'+
                        '<div class="col-sm-3" style="padding-top:5px;">'+
                            '<label><b>Custom Code After</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="mt-3 custom_data_'+i+' custom_code_after_'+i+' ">'+                        
                        '<textarea name="'+name_route+'[custom_code_after]" class="d-none" rows="10">'+isi_after+
                        '</textarea>'+
                        '<textarea id="tab_'+name_route+'[custom_code_after]">'+isi_after+
                        '</textarea>'+
                    '</div>';

                html_code_php += 
                    '<div class="row mb-3 custom_data_'+i+'">'+
                        '<div class="col-sm-3" style="padding-top:5px;">'+
                            '<label><b>Custom Code After Commit</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="mt-3 custom_data_'+i+' custom_code_after_commit_'+i+' ">'+                        
                        '<textarea name="'+name_route+'[custom_code_after_commit]" class="d-none" rows="10">'+isi_after+
                        '</textarea>'+
                        '<textarea id="tab_'+name_route+'[custom_code_after_commit]">'+isi_after+
                        '</textarea>'+
                    '</div>';
                
                $( '.custom_data_'+i ).remove()
                toAppend.append(html_code_php)
                                
                if(i == 'route_sementara') {
                    aceGenerate({ name_cols : name_route + "[custom_code_before]" });
                    aceGenerate({ name_cols : name_route + "[custom_code_after]" });
                    aceGenerate({ name_cols : name_route + "[custom_code_after_commit]" });
                    
                    // eval("code_editor_custom_code_before_= ace.edit('tab_' + name_route + '[custom_code_before]')")
                    // eval("code_editor_custom_code_before_.setOptions({mode: \"ace/mode/phpinline\", maxLines: 30, minLines: 5, wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
                    // eval("code_editor_custom_code_before_.getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
                    // eval("code_editor_custom_code_before_.getSession().on('change', function(e) {val_code = code_editor_custom_code_before_.getSession().getValue();$( '[name=\""+name_route+"[custom_code_before]\"]' ).val(val_code);})")
                                        
                    // eval("code_editor_custom_code_after_= ace.edit('tab_' + name_route + '[custom_code_after]', {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
                    // eval("code_editor_custom_code_after_.getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
                    // eval("code_editor_custom_code_after_.getSession().on('change', function(e) {val_code = code_editor_custom_code_after_.getSession().getValue();$( '[name=\""+name_route+"[custom_code_after]\"]' ).val(val_code);})")
                }                
            }

            if( ele.value != 'list_data' && ele.value != 'single_data') {
                html_lock = 
                    '<div class="row mb-3 lock_input_'+i+'">'+
                        '<div class="col-sm-1" style="padding-top:5px;">'+
                            '<label>Use Lock </label>'+
                        '</div>'+
                        '<div class="col-sm-1">'+
                            '<div class="form-check form-check-inline with-check">'+
                                '<input class="form-check-input lock_'+i+'" type="checkbox" onchange="show_hide_key(\''+i+'\')" dataId='+i+'>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm lock_key_'+i+'" style="display:none">'+                            
                            '<input name="'+name_route+'[lock]" type="text" class="form-control" placeholder="key" disabled=disabled>'+
                        '</div>'+
                    '</div>'+                    
                    '';
                
                $( '.lock_input_'+i ).remove()
                toAppend.prepend(html_lock);

                $( ".lock_"+i ).switcher();
            }

            if(ele.value == 'system_data') {
                $( ".tanpa_route_div" ).addClass('d-none')
            }                        
        }

        function show_hide_tanpa_route(ele) {            
            if( $(ele).is(':checked') ) {
                $( "[name='route_sementara[prefix]']" ).prop('disabled',true)
                $( "[name='route_sementara[method]']" ).prop('disabled',true)
                $( "[name='route_sementara[tanpa_route]']" ).val(1)         
            }else {
                $( "[name='route_sementara[prefix]']" ).prop('disabled',false)
                $( "[name='route_sementara[method]']" ).prop('disabled',false)
                $( "[name='route_sementara[tanpa_route]']" ).val(0)
            }
        }

        function show_hide_key(i) {
            $('.lock_key_'+i).hide();
            $('[name="route_sementara[lock]"]').prop('disabled',true);
            if ($('.lock_'+i).is(':checked')) {
                $('.lock_key_'+i).show();
                $('[name="route_sementara[lock]"]').prop('disabled',false);                
            }
        }        

        function ubahTableRelasi(i) {
            $( ".foreign_key_"+i ).html( $( '[name="relation['+i+'][table]"]' ).val() )
        }

        function ubah_type_relasi(data,i, refill) {

            refill = typeof refill !== 'undefined' ? refill : 1
            // data_sebelum = get_data_array(objModul,'relation.'+i+'.type','')
            data_sebelum = storage_parameter.get('relation.'+i+'.type','[]')
            data_sesudah = data.value
                    
            objModul = $('#modul').serializeJSON()
            // if( data_sebelum == '' || data_sebelum == 'belongs_to_many' || data_sesudah == 'belongs_to_many' || data_sebelum == 'has_many' || data_sesudah == 'has_many') {
                $( "[class*='has_many_"+i+"']" ).remove()
                $( "[class*='has_one_"+i+"']" ).remove()
                $( "[class*='belongs_to_many_"+i+"']" ).remove()
                $( "[class*='belongs_to_"+i+"']" ).remove()                

                if( data.value == "has_many" || data.value == "has_one" || data.value == "belongs_to") {
                    html_relasi_detail = ''

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Nama </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama tabel relasi" name="relation['+i+'][name]">'+
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
                                '<input type="" class="form-control" placeholder="nama tabel relasi" name="relation['+i+'][table]" onchange=ubahTableRelasi(\''+i+'\') onkeyup=ubahTableRelasi(\''+i+'\')>'+
                            '</div>'+
                        '</div>'+
                        '';                                    
                }

                if( data.value == "belongs_to" ) {

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Primary/Relation Key <span class="foreign_key_'+i+'"></span></label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="default id" name="relation['+i+'][relation_key]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Foreign Key <span class="foreign_key_'+i+'"></span></label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="foreign key relasi" name="relation['+i+'][foreign_key]">'+
                            '</div>'+
                        '</div>'+
                        '';
                }

                if( data.value != "belongs_to" ) {
                                        
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Primary/Relation Key <span class="foreign_key_table">'+get_data_array(objModul,'table')+'</span></label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="default id" name="relation['+i+'][relation_key]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Foreign Key <span class="foreign_key_table">'+get_data_array(objModul,'table')+'</span></label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="foreign key relasi" name="relation['+i+'][foreign_key]">'+
                            '</div>'+
                        '</div>'+
                        '';
                }
                
                if( data.value == "belongs_to_many" ) {
                    html_relasi_detail = ''

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Nama </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama relasi" name="relation['+i+'][name]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Nama Parameter</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama parameter relasi (default Nama)" name="relation['+i+'][name_param]">'+
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
                            '<div class="col-sm">'+
                                '<select class="form-control" name="relation['+i+'][foreign_key_model_type]"><option value="integer">Integer</option><option value="string">String</option></select>'+
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
                            '<div class="col-sm">'+
                                '<select class="form-control" name="relation['+i+'][foreign_key_joining_model_type]"><option value="integer">Integer</option><option value="string">String</option></select>'+
                            '</div>'+
                        '</div>'+
                        '';
                    
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Intermediate Tabel </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<textarea name="relation['+i+'][intermediate_table]" class="d-none">'+
                                    '-- intermediate_table'+
                                '</textarea>'+
                                '<textarea id="relation_intermediate_table_'+i+'">'+
                                    '-- intermediate_table'+
                                '</textarea>'+    
                                // '<input type="" class="form-control" placeholder="intermediate table" name="relation['+i+'][intermediate_table]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Modul Intermediate Tabel *go</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<select class="multi-select2-relasi col-sm-12" name="relation['+i+'][modul_intermediate_table]" multiple="">'+
                                '</select>'+
                                // '<input type="" class="form-control" placeholder="model intermediate table" name="relation['+i+'][modul_intermediate_table]">'+
                            '</div>'+
                        '</div>'+
                        '';                
                }

                if( data.value == "belongs_to" ) {
                    
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Check Data Repository Function</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="default getSingleData" name="relation['+i+'][check_data_function]">'+
                            '</div>'+
                        '</div>'+
                        '';

                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Membuat Data </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<div class="form-check form-check-inline with-check">'+
                                    '<input class="form-check-input" type="checkbox" name="relation['+i+'][membuat_data]">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '';
                }else {
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Menyimpan Data </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<div class="form-check form-check-inline with-check">'+
                                    '<input class="form-check-input" type="checkbox" name="relation['+i+'][simpan_data]">'+
                                '</div>'+
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
                            '<textarea name="relation['+i+'][custom_join]" class="d-none">'+
                                '-- left join zw_com_products on (zw_com_products.id=zw_com_order_products.product_id)'+"\n"+
                            '</textarea>'+
                            '<textarea id="relation_custom_join_'+i+'">'+
                                '-- left join zw_com_products on (zw_com_products.id=zw_com_order_products.product_id)'+"\n"+
                            '</textarea>'+                            
                        '</div>'+
                    '</div>'+
                    '';

                html_relasi_detail += 
                    '<div class="row mb-3 '+data.value+'_'+i+'">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Custom option </label>'+
                        '</div>'+
                        '<div class="col-sm">'+                            
                            '<textarea name="relation['+i+'][custom_option]" class="d-none">'+
                                '-- custom option relasi (ex:and zw_com_products.deleted_by is null and zw_com_products.com_id = \'.user()->com_id.\')'+"\n"+
                            '</textarea>'+
                            '<textarea id="relation_custom_option_'+i+'">'+
                                '-- custom option relasi (ex:and zw_com_products.deleted_by is null and zw_com_products.com_id = \'.user()->com_id.\')'+"\n"+
                            '</textarea>'+
                        '</div>'+
                    '</div>'+
                    '';

                html_relasi_detail += 
                    '<div class="row mb-3 '+data.value+'_'+i+'">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Custom order </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<textarea name="relation['+i+'][custom_order]" class="d-none">'+
                                '-- order by name asc'+"\n"+
                            '</textarea>'+
                            '<textarea id="relation_custom_order_'+i+'">'+
                                '-- order by name asc'+"\n"+
                            '</textarea>'+                            
                        '</div>'+
                    '</div>'+
                    '';

                html_relasi_detail += 
                    '<div class="row mb-3 '+data.value+'_'+i+'">'+
                        '<div class="col-sm-8" style="padding-top:5px;">'+
                            '<label data-toggle="collapse" class="list-collapse collapsed" data-target=".collapse_'+data.value+'_'+i+'" aria-expanded="true" aria-controls="collapse_'+data.value+'_'+i+'"><b>Kolom Relasi</b></label>'+
                        '</div>'+                        
                    '</div>'+
                    '';

                html_relasi_detail +=
                    '<div class="collapse collapse_'+data.value+'_'+i+' ">'+
                        '<div class="container '+data.value+'_'+i+' kolom_relasi_'+data.value+'_'+i+'">'+                    
                        '</div>'+                
                        '<input class="btn btn-secondary mb-3 '+data.value+'_'+i+'" type="button" value="Tambah Kolom Relasi" height="10px" onclick="tambah_kolom_relasi(\''+data.value+'\',\''+i+'\',0)">'+
                    '</div>'+
                    '';                                

                if( data.value == "belongs_to_many" ) {
                    html_relasi_detail += 
                        '<div class="row mb-3 '+data.value+'_'+i+'">'+
                            '<div class="col-sm-8" style="padding-top:5px;">'+                                
                                '<label data-toggle="collapse" class="list-collapse collapsed" data-target=".collapse_tambahan_'+data.value+'_'+i+'" aria-expanded="true" aria-controls="collapse_tambahan_'+data.value+'_'+i+'"><b>Kolom Tambahan di Intermediate Tabel</b></label>'+
                            '</div>'+                        
                        '</div>'+
                        '';

                    html_relasi_detail +=
                        '<div class="collapse collapse_tambahan_'+data.value+'_'+i+' ">'+
                            '<div class="container '+data.value+'_'+i+' kolom_tambahan_relasi_'+data.value+'_'+i+'">'+
                            '</div>'+
                            "<input class='btn btn-secondary "+data.value+'_'+i+"' type='button' value='Tambah Kolom tambahan di Intermediate Tabel' height='10px' onclick=\"tambah_kolom_tambahan_relasi('"+data.value+"','"+i+"',0)\">"
                        '</div>'+
                        '';
                                        
                }            
                
                $(data).parent().parent().parent().append(html_relasi_detail);
                
                $( "[name='relation["+i+"][membuat_data]']" ).switcher();
                $( "[name='relation["+i+"][simpan_data]']" ).switcher();
                                               
                createCodeEditor( 'relation_intermediate_table_'+i, "relation["+i+"][intermediate_table]", 'sql' );
                createCodeEditor( 'relation_custom_join_'+i, "relation["+i+"][custom_join]", 'sql' );
                createCodeEditor( 'relation_custom_option_'+i, "relation["+i+"][custom_option]", 'sql' );
                createCodeEditor( 'relation_custom_order_'+i, "relation["+i+"][custom_order]", 'sql' );

                $('.multi-select2-relasi').select2({
                    placeholder: 'Models',
                    allowClear: true,
                    width: '100%',
                    data:select2_data,
                });

                if( refill == 1) {
                    fill_kolom_relasi(i,get_data_array(objModul,'relation.'+i,''),0)
                }
            // }else {
                // if(data_sebelum!=data_sesudah) {
                //     $( '.'+data_sebelum+'_'+i ).addClass( data_sesudah+'_'+i ).removeClass( data_sebelum+'_'+i )
                //     $( '[class*="'+data_sebelum+'"]' ).each(function(){
                //         class_str = $(this).attr('class')
                //         class_str = class_str.replace(data_sebelum, data_sesudah, "g")
                //         $(this).attr('class',class_str)
                //     })
                //     $( '[onclick*="'+data_sebelum+'"]' ).each(function(){
                //         onclick_str = $(this).attr('onclick')
                //         onclick_str = onclick_str.replace(data_sebelum, data_sesudah, "g")
                //         $(this).attr('onclick',onclick_str)
                //     })
                // }
            // }
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
                        '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_tambahan_relasi(\''+data+'\',\''+irelasi+'\','+ikolom+')">x</button>'+
                    '</div>'+
                '';

            $( '.kolom_tambahan_relasi_'+data+'_'+irelasi+'' ).append(html_kolom_tambahan_relasi_detail);
            $( "[onclick=\"tambah_kolom_tambahan_relasi('"+data+"','"+irelasi+"',"+(ikolom)+")\"]" ).attr('onclick',"tambah_kolom_tambahan_relasi('"+data+"','"+irelasi+"',"+(ikolom+1)+")");
        }

        function tambah_kolom_relasi(data,irelasi,ikolom) {
            html_kolom_relasi_detail =                    
                    '<div class="kolom_relasi_'+irelasi+ikolom+'">'+
                        '<div class="row col-sm-12">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Nama</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input type="" class="form-control" placeholder="nama" name="relation['+irelasi+'][select_column]['+ikolom+'][name]">'+
                            '</div>'+
                        '</div>'+
                        '<div class="row col-sm-12">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Query Kolom</label>'+
                            '</div>'+
                            '<div class="col-sm">'+                                
                                '<textarea name="relation['+irelasi+'][select_column]['+ikolom+'][column]" class="d-none"></textarea>'+
                                '<textarea id="relation'+irelasi+ikolom+'"></textarea>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row col-sm-12">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Tipe</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<select class="form-control" name="relation['+irelasi+'][select_column]['+ikolom+'][type]">'+
                                    '<option value="integer">Integer</option>'+
                                    '<option value="string">String</option>'+
                                '</select>'+
                            '</div>'+                            
                        '</div>'+                        
                    '</div>'+
                    '<div class="row mb-3 col-sm-12">'+
                        // '<div class="col-sm" style="padding-top:5px;">'+
                        //     '<label data-toggle="collapse" class="list-collapse collapsed" data-target=".kolom_relasi_'+irelasi+ikolom+'" aria-expanded="true" aria-controls="kolom_relasi_'+irelasi+ikolom+'"><b>Kolom '+(ikolom+1)+'</b></label>'+
                        // '</div>'+
                        '<div class="col-sm" style="padding-top:5px;">'+
                            '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_relasi(\''+data+'\',\''+irelasi+'\','+(ikolom)+')">x</button>'+
                            '<br>'+
                            '<hr>'+
                        '</div>'+                        
                    '</div>'+
                '';

            $( '.kolom_relasi_'+data+'_'+irelasi+'' ).append(html_kolom_relasi_detail);

            eval("code_editor_" + irelasi + ikolom + "= ace.edit('relation'+irelasi+ikolom, {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + irelasi + ikolom + ".getSession().on('change', function(e) {val_code = code_editor_"+irelasi+ikolom+".getSession().getValue();$( '[name=\"relation["+irelasi+"][select_column]["+ikolom+"][column]\"]' ).val(val_code);})")

            $( "[onclick=\"tambah_kolom_relasi('"+data+"','"+irelasi+"',"+(ikolom)+")\"]" ).attr('onclick',"tambah_kolom_relasi('"+data+"','"+irelasi+"',"+(ikolom+1)+")");
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

        function tambah_validasi(i_route,i_ele) {
            if( typeof i_route == "string") {
                i_route = "'"+i_route+"'"

                html_validasi = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Validasi Parameter</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="nama parameter" name="route_sementara[validation]['+i_ele+'][name]">'+
                    '</div>'+
                    '<div class="col-sm-1" style="padding-top:5px;">'+
                        '<label>Validasi</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="(ex:required|numeric)" name="route_sementara[validation]['+i_ele+'][statement]" att="validation_'+i_route+'_'+i_ele+'">'+
                    '</div>'+
                    '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_validasi('+i_route+','+i_ele+')" att="remove_validation_'+i_route+'_'+i_ele+'">x</button>'+
                '</div>'+
                '';

                $( ".route_"+i_route.replace(/\'/g,'') ).append(html_validasi)
            }else {
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
            }

            $( '[onclick="tambah_validasi('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_validasi('+i_route+','+(i_ele+1)+')')
        }

        function tambah_traits(i_route,i_ele) {            
            i_route = "'"+i_route+"'"

            html_traits = 
            '<div class="row mb-3">'+
                '<div class="col-sm-3" style="padding-top:5px;">'+
                    '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Traits</label>'+
                '</div>'+
                '<div class="col-sm">'+
                    '<input type="" class="form-control" placeholder="path traits" name="route_sementara[traits]['+i_ele+'][path]">'+
                '</div>'+                
                '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_traits('+i_route+','+i_ele+')" att="remove_traits_'+i_route+'_'+i_ele+'">x</button>'+
            '</div>'+
            '';

            $( ".route_"+i_route.replace(/\'/g,'') ).append(html_traits)            

            $( '[onclick="tambah_traits('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_traits('+i_route+','+(i_ele+1)+')')
        }

        function tambah_route_parameter(i_route,i_ele) {
            if( typeof i_route == "string") {
                i_route = "'"+i_route+"'"

                html_parameter = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Nama</label>'+
                    '</div>'+
                    '<div class="col-sm-9">'+
                        '<input type="" class="form-control route_sementara[param][name]" placeholder="nama parameter" name="route_sementara[param]['+i_ele+'][name]">'+
                    '</div>'+
                '</div>'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Class</label>'+
                    '</div>'+
                    '<div class="col-sm-9">'+                        
                        '<input class="form-control class_param_'+i_ele+'" type="" name="route_sementara[param]['+i_ele+'][class]">'+
                    '</div>'+
                '</div>'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-12">'+
                        '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_parameter_route('+i_route+','+i_ele+')">x</button>'+
                    '</div>'+
                '</div>'+
                '';

                $( ".route_param_"+i_route.replace(/\'/g,'') ).append(html_parameter)
            }else {
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
            }           

            $( '[onclick="tambah_route_parameter('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_route_parameter('+i_route+','+(i_ele+1)+')')
        }

        function tambah_route_middleware(i_route,i_ele) {
            if( typeof i_route == "string") {
                i_route = "'"+i_route+"'"

                html_middleware = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Middleware</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="nama middleware" name="route_sementara[middleware]['+i_ele+']">'+
                    '</div>'+
                    '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_middleware_route('+i_route+','+i_ele+')">x</button>'+
                '</div>'+
                '';

                $( ".route_middleware_"+i_route.replace(/\'/g,'') ).append(html_middleware)        

                $( '[onclick="tambah_route_middleware('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_route_middleware('+i_route+','+(i_ele+1)+')')

                $( '[name="route_sementara[middleware]['+i_ele+']"]' ).autocomplete({
                    source: '{{url('/')}}/middleware',
                    minLength: 0,
                } ); 
            }else {
                html_middleware = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Middleware</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="nama middleware" name="route['+i_route+'][middleware]['+i_ele+']">'+
                    '</div>'+
                    '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_middleware_route('+i_route+','+i_ele+')">x</button>'+
                '</div>'+
                '';

                $( ".route_middleware_"+i_route ).append(html_middleware)        

                $( '[onclick="tambah_route_middleware('+i_route+','+i_ele+')"]' ).attr("onclick",'tambah_route_middleware('+i_route+','+(i_ele+1)+')')

                $( '[name="route['+i_route+'][middleware]['+i_ele+']"]' ).autocomplete({
                    source: '{{url('/')}}/middleware',
                    minLength: 0,
                } ); 
            }                       
        }

        function tambah_route(jumlah_route) {
            objModul = $('#modul').serializeJSON()
            nama_route = jumlah_route
            window.jumlah_route = jumlah_route
            window.jumlah_route++
            jumlah_route = window.jumlah_route
            html_new_route = 
                '<div class="d-none">'+
                    '<div class="row mb-3">'+
                        '<label class="col-sm-11"><b>Route '+jumlah_route+'</b> </label>'+
                        '<button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeRoute(\'route.'+nama_route+'\')">Hapus</button>'+            
                    '</div>'+
                    '<div class="container mb-4">'+
                        '<div class="row mb-3">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Route Prefix</label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<input name="route['+nama_route+'][prefix]" type="text" class="form-control" placeholder="prefix route ex:admin/v1/{locale}/" onchange="prefixChange(this)" onkeyup="prefixChange(this)" value="admin/v1/{locale}/">'+
                            '</div>'+
                        '</div>'+
                        '<div class="row mb-3">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Route </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<div class="input-group mb-2">'+
                                    '<div class="input-group-prepend">'+
                                    '<div class="input-group-text route'+nama_route+'prefix">api/admin/v1/{locale}/'+objModul['name']+'/</div>'+
                                    '</div>'+
                                    '<input name="route['+nama_route+'][name]" type="text" class="form-control" id="inlineFormInputGroup" placeholder="route">'+
                                '</div>'+
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
                        '<input class="btn btn-secondary mb-3" type="button" value="Tambah Validasi" height="10px" onclick="tambah_validasi('+nama_route+',0)">'+
                        '<div class="row mb-3">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label><b>Middleware</b></label>'+
                            '</div>'+
                        '</div>'+
                        '<div class="container route_middleware_'+nama_route+'">'+                        
                        '</div>'+
                        '<input class="btn btn-secondary mb-3" type="button" value="Tambah Middleware" height="10px" onclick="tambah_route_middleware('+nama_route+',0)">'+            
                    '</div>'+
                '</div>'+ 
                '';
                
            $( "list_route" ).append(html_new_route);

            $( "[name=\"route["+nama_route+"][process]\"]" ).change()                        
        }

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

            $.ajax({
                type: 'GET',
                url: '{{url('/')}}/middleware',
                dataType: 'json',
                success: function(json) {
                    build_tabel_middleware(json)
                },
                error: function(e) {
                    alert('route middleware error')
                }
            });

            $( "[name=\"column_sementara[hidden]\"]" ).switcher();

            $( "#with_company_restriction" ).switcher();

            $( "#with_delete_restriction" ).switcher();

            $( "#with_authenticable" ).switcher()

            $( "#increment_key" ).switcher();

            $( "#with_advanced_validation" ).switcher();

            $( "[name=\"route_sementara[process]\"]" ).change()

            $( "[name=\"route_sementara[prefix]\"]" ).change()
            
            $( "[name=\"relation[relation_sementara][type]\"]" ).change();

            $( ".tanpa_route" ).switcher();
            
            $( ".set_switcher" ).switcher();
            
            // $( "#add_relasi" ).click(function( event ) {
            //     tambah_relasi(jumlah_relasi)
            //     window.objModul = $('#modul').serializeJSON()
            // });

            // $( "#add_route" ).click(function( event ) {
            //     tambah_route(jumlah_route)
            //     window.objModul = $('#modul').serializeJSON()                
            // })
            
            // $( "#add_function_column" ).click(function( event ) {
            //     tambah_kolom_fungsi(jumlah_kolom_fungsi)
            //     window.objModul = $('#modul').serializeJSON()                
            // })
            
            nama_kolom_fungsi = 'table'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_table', {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code).change();})")
            
            nama_kolom_fungsi = 'get_company_code'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_get_company_code', {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")

            nama_kolom_fungsi = 'get_custom_updating'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_get_custom_updating', {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")

            nama_kolom_fungsi = 'get_custom_deleting'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_get_custom_deleting', {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")

            nama_kolom_fungsi = 'get_custom_creating'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_get_custom_creating', {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")

            nama_kolom_fungsi = 'custom_filter'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_custom_filter', {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")
            
            nama_kolom_fungsi = 'custom_union'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_custom_union', {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")

            nama_kolom_fungsi = 'custom_join'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_custom_join', {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")            
            
            // nama_kolom_fungsi = 'route_sementara_advanced_validation_code'
            // eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('route_sementara_advanced_validation_code', {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
            // eval("code_editor_" + nama_kolom_fungsi + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
            // eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\"route_sementara[advanced_validation_code]\"]' ).val(val_code);})")
            
            aceGenerate({ name_cols : 'route_sementara[advanced_validation_code]'});
            aceGenerate({ name_cols : 'route_sementara[custom_check_single_data]', default_code : single_data_code});

            @if (!empty($data['id']) )
                ambil_data_modul({{$data['id']}})
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

        function remove_validasi(iroute, iparameter) {
            objModul = $('#modul').serializeJSON()

            if( typeof iroute == "string") {
                splice_multilevel_array(objModul,'route_sementara.validation.'+iparameter)
            }else {
                splice_multilevel_array(objModul,'route.'+iroute+'.validation.'+iparameter)
            }
            build_validasi(iroute)
        }

        function remove_traits(iroute, iparameter) {
            objModul = $('#modul').serializeJSON()

            splice_multilevel_array(objModul,'route_sementara.traits.'+iparameter)
            build_traits(iroute)
        }

        function remove_kolom_parameter_route(iroute, iparameter) {
            objModul = $('#modul').serializeJSON()
            
            if( typeof iroute == "string") {
                splice_multilevel_array(objModul,'route_sementara.param.'+iparameter)
            }else {
                splice_multilevel_array(objModul,'route.'+iroute+'.param.'+iparameter)
            }
            build_kolom_parameter_route(iroute)
        }

        function remove_kolom_middleware_route(iroute, imiddleware) {
            objModul = $('#modul').serializeJSON()

            if( typeof iroute == "string") {
                splice_multilevel_array(objModul,'route_sementara.middleware.'+imiddleware)
            }else {
                splice_multilevel_array(objModul,'route.'+iroute+'.middleware.'+imiddleware)
            }

            build_kolom_middleware_route(iroute)
        }

        function build_validasi(iroute,validation_data) {
            if( typeof iroute == "string") {
                $( ".route_"+iroute.replace(/\'/g,'') ).html('')
                if(typeof validation_data === 'undefined') {
                    validation_data = get_data_array(objModul,'route_sementara.validation',[])
                }
                $( "[onclick=\"tambah_validasi('"+iroute+"',"+(Object.keys(validation_data).length+1)+")\"]" ).attr('onclick',"tambah_validasi('"+iroute+"',0)");
                i = 0            
                $.each(validation_data, function( index, value ) {
                    tambah_validasi(iroute,i)
                    $( '[name="route_sementara[validation]['+i+'][name]"]' ).val(value['name'])
                    $( '[name="route_sementara[validation]['+i+'][statement]"]' ).val(value['statement'])
                    i++
                });
            }else {
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
        }

        function build_traits(iroute,traits_data) {            
            $( ".route_"+iroute.replace(/\'/g,'') ).html('')
            if(typeof traits_data === 'undefined') {
                traits_data = get_data_array(objModul,'route_sementara.traits',[])
            }
            $( "[onclick=\"tambah_traits('"+iroute+"',"+(Object.keys(traits_data).length+1)+")\"]" ).attr('onclick',"tambah_traits('"+iroute+"',0)");
            i = 0            
            $.each(traits_data, function( index, value ) {
                tambah_traits(iroute,i)
                $( '[name="route_sementara[traits]['+i+'][path]"]' ).val(value['path'])                
                i++
            });           
        }
        
        function build_kolom_parameter_route(iroute,parameter_route_data) {
            if( typeof iroute == "string") {                
                $( ".route_param_"+iroute.replace(/\'/g,'') ).html('')
                if(typeof parameter_route_data === 'undefined') {
                    parameter_route_data = toArray(get_data_array(objModul,'route_sementara.param',[]))
                }
                $( "[onclick=\"tambah_route_parameter('"+iroute+"',"+(parameter_route_data.length+1)+")\"]" ).attr('onclick',"tambah_route_parameter('"+iroute+"',0)");
                i = 0            
                $.each(parameter_route_data, function( index, value ) {
                    tambah_route_parameter(iroute,i)
                    
                    if( value.name ) {
                        $( '[name="route_sementara[param]['+i+'][name]"]' ).val(value.name)
                    }else {
                        $( '[name="route_sementara[param]['+i+'][name]"]' ).val(value)
                    }

                    if( value['class'] )
                        $( '[name="route_sementara[param]['+i+'][class]"]' ).val(value.class)                    
                    
                    i++                    
                });

            }else{
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
        }

        function build_kolom_middleware_route(iroute,middleware_route_data) {
            if( typeof iroute == "string") {
                $( ".route_middleware_"+iroute.replace(/\'/g,'') ).html('')
                if(typeof middleware_route_data === 'undefined') {
                    middleware_route_data = toArray(get_data_array(objModul,'route_sementara.middleware',[]))
                }
                $( "[onclick=\"tambah_route_middleware('"+iroute+"',"+(middleware_route_data.length+1)+")\"]" ).attr('onclick',"tambah_route_middleware('"+iroute+"',0)");
                i = 0            
                $.each(middleware_route_data, function( index, value ) {
                    tambah_route_middleware(iroute,i)
                    $( '[name="route_sementara[middleware]['+i+']"]' ).val(value)
                    i++                
                });
            }else {
                $( ".route_middleware_"+iroute ).html('')
                if(typeof middleware_route_data === 'undefined') {
                    middleware_route_data = toArray(get_data_array(objModul,'route.'+iroute+'.middleware',[]))
                }
                $( "[onclick=\"tambah_route_middleware("+iroute+","+(middleware_route_data.length+1)+")\"]" ).attr('onclick',"tambah_route_middleware("+iroute+",0)");
                i = 0            
                $.each(middleware_route_data, function( index, value ) {
                    tambah_route_middleware(iroute,i)
                    $( '[name="route['+iroute+'][middleware]['+i+']"]' ).val(value)
                    i++                
                });
            }
        }

        function remove_kolom_tambahan_relasi(data, irelasi, ikolom) {
            objModul = $('#modul').serializeJSON()
            splice_multilevel_array(objModul,'relation.'+irelasi+'.column_add_on.'+ikolom)
            build_kolom_tambahan_relasi_modul(data,irelasi,ikolom)
        }

        function build_kolom_tambahan_relasi_modul(data,irelasi,ikolom) {
            $( ".kolom_tambahan_relasi_"+data+"_"+irelasi ).html('')
            add_on_column_data = toArray(get_data_array(objModul,'relation.'+irelasi+'.column_add_on',[]))
            $( "[onclick=\"tambah_kolom_tambahan_relasi('"+data+"','"+irelasi+"',"+(add_on_column_data.length+1)+")\"]" ).attr('onclick',"tambah_kolom_tambahan_relasi('"+data+"','"+irelasi+"',0)");
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
            $( "[onclick=\"tambah_kolom_relasi('"+data+"','"+irelasi+"',"+(select_column_data.length+1)+")\"]" ).attr('onclick',"tambah_kolom_relasi('"+data+"','"+irelasi+"',0)");
            i = 0
            $.each(select_column_data, function( index, value ) {
                tambah_kolom_relasi(data,irelasi,i)
                $( '[name="relation['+irelasi+'][select_column]['+i+'][name]"]' ).val(value['name'])
                $( '[name="relation['+irelasi+'][select_column]['+i+'][column]"]' ).val(value['column'])

                eval("code_editor_" + irelasi + i + ".setValue($( '[name=\"relation["+irelasi+"][select_column]["+i+"][column]\"]' ).val())")
                eval("code_editor_" + irelasi + i + ".clearSelection()")

                $( '[name="relation['+irelasi+'][select_column]['+i+'][type]"]' ).val(value['type'])
                i++
            });
            // $( "[onclick=\"tambah_kolom_relasi('"+data+"',"+irelasi+","+(i+1)+")\"]" ).attr('onclick',"tambah_kolom_relasi('"+data+"',"+irelasi+","+(i)+")");
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
                        storage_parameter.update('column_to_save',[])
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

        function ambil_data_modul(id) {
            // delay(function(){
                $.ajax({
                    type: 'GET',
                    url: '{{url('/')}}/modul/'+id,
                    jsonpCallback: 'testing',
                    dataType: 'json',
                    success: function(json) {
                        $( '[name="name"]' ).val(json.name)
                        objModul = JSON.parse(json.detail)                        
                        build_semua_kolom(json)                
                    },
                    error: function(e) {
                        alert('data modul tidak ada')
                        window.location = "/list"
                        objModul = []
                        build_semua_kolom([],'')
                    }
                });
            // }, 500);
        }

        function build_semua_kolom(data) {
            dataDetail = JSON.parse(data.detail)
            
            build_tabel_option(dataDetail);
            build_kolom_tabel_modul(dataDetail);           
            // build_kolom_fungsi(dataDetail);
                        
            storage_parameter.update('hidden',dataDetail['hidden'])
            storage_parameter.update('hidden_relation',dataDetail['hidden_relation'])
            storage_parameter.update('route',dataDetail['route'])            
            storage_parameter.update('relation',dataDetail['relation'])
            
            objColumn = data['table']['column']
            objModul['column'] = data['table']['column']
            objForbiddenCOlumn = data['table']['forbidden_column_name']
            storage_parameter.update('list_index',data['table']['list_index'])
            storage_parameter.update('column_function',objModul['column_function'])
            storage_parameter.update('casts',objModul['casts'])
            storage_parameter.update('repositories',objModul['repositories'])
            storage_parameter.update('files',data['files'])
            storage_parameter.update('classtab',objModul['classtab'])
            storage_parameter.update('column_to_save', objColumn)

            build_route_tabel(dataDetail['route'])
            build_relation_tabel(dataDetail['relation'])
            build_kolom_tabel(objModul['column'],objForbiddenCOlumn)
            build_tabel_option_by_column(objModul['column'])
            build_tabel_option_details(objModul, 'time')
            build_tabel_option_details(objModul, 'auth')
            build_tabel_option_details(objModul, 'ip')
            build_modul_tabel(objModul['column'],objForbiddenCOlumn)
            build_list_index_tabel(data['table']['list_index'])
            build_list_column_function_tabel(objModul['column_function'])
            build_list_cast_tabel(objModul['casts'])
            build_list_repository_tabel(objModul['repositories'])            
            build_list_files_tabel(data['files'])
            build_list_classtab_tabel(objModul['classtab'])
        }
        
        function build_tabel_option_details(data, type) {
            if( data['with_'+type+'stamp_details'] ){
                if( data['with_'+type+'stamp_details'].create ){
                    $( '[name="with_'+type+'stamp_details[create]"]' ).prop('checked', true)
                }else{
                    $( '[name="with_'+type+'stamp_details[create]"]' ).prop('checked', false)
                }

                if( data['with_'+type+'stamp_details'].update ){
                    $( '[name="with_'+type+'stamp_details[update]"]' ).prop('checked', true)
                }else {
                    $( '[name="with_'+type+'stamp_details[update]"]' ).prop('checked', false)
                }

                if( data['with_'+type+'stamp_details'].delete ){
                    $( '[name="with_'+type+'stamp_details[delete]"]' ).prop('checked', true)
                }else {
                    $( '[name="with_'+type+'stamp_details[delete]"]' ).prop('checked', false)
                }

                if( data['with_'+type+'stamp_details'].create_column ){
                    $( '[name="with_'+type+'stamp_details[create_column]"]' ).val(data['with_'+type+'stamp_details'].create_column)
                }
                if( data['with_'+type+'stamp_details'].update_column ){
                    $( '[name="with_'+type+'stamp_details[update_column]"]' ).val(data['with_'+type+'stamp_details'].update_column)
                }
                if( data['with_'+type+'stamp_details'].delete_column ){
                    $( '[name="with_'+type+'stamp_details[delete_column]"]' ).val(data['with_'+type+'stamp_details'].delete_column)
                }
            }else {
                $( '[name="with_'+type+'stamp_details[create]"]' ).prop('checked', false)
                $( '[name="with_'+type+'stamp_details[update]"]' ).prop('checked', false)
                $( '[name="with_'+type+'stamp_details[delete]"]' ).prop('checked', false)
            }
        }

        function build_tabel_option_by_column(data) {
            // $( '[name="with_timestamp"]' ).val(0)
            // $( '[name="with_authstamp"]' ).val(0)
            // $( '[name="with_ipstamp"]' ).val(0)
            // $( '[name="with_companystamp"]' ).val(0)

            $.each(data, function( index, value ) {
                // if(value['name'] == 'created_time') $( '[name="with_timestamp"]' ).val(1)
                // if(value['name'] == 'created_by') $( '[name="with_authstamp"]' ).val(1)
                // if(value['name'] == 'created_from') $( '[name="with_ipstamp"]' ).val(1)
                if(value['name'] == 'com_id') {
                    $( '[name="with_companystamp"]' ).val(1)
                    // storage_parameter.add('hidden','com_id')
                }
            });
        }

        function build_tabel_option(data) {
            $( '[name="key"]' ).val('').change();
            $( '[name="custom_folder"]' ).val('').change();
            $( '[name="with_timestamp"]' ).val(0).change();
            $( '[name="with_authstamp"]' ).val(0).change();
            $( '[name="with_ipstamp"]' ).val(0).change();
            $( '[name="with_companystamp"]' ).val(0)            
            $( '[name="with_company_restriction"]' ).prop('checked',false).change();
            $( '[name="with_delete_restriction"]' ).prop('checked',false).change();
            $( '[name="with_authenticable"]' ).prop('checked',false).change();
            $( '[name="custom_filter"]' ).val('');
            eval("code_editor_custom_filter.setValue('')")
            eval("code_editor_custom_filter.clearSelection()")

            if(data.key) $( '[name="key"]' ).val(data.key).change();
            if(data.custom_folder) $( '[name="custom_folder"]' ).val(data.custom_folder).change();
            if(data.increment_key) {
                if( data.increment_key == 1 ) {
                    $( '[name="increment_key"]' ).prop('checked',true).change();
                }else {
                    $( '[name="increment_key"]' ).prop('checked',false).change();
                }
            }
            if(data.with_timestamp) $( '[name="with_timestamp"]' ).val(data.with_timestamp).change();
            if(data.with_authstamp) $( '[name="with_authstamp"]' ).val(data.with_authstamp).change();
            if(data.with_ipstamp) $( '[name="with_ipstamp"]' ).val(data.with_ipstamp).change();
            if(data.with_companystamp) $( '[name="with_companystamp"]' ).val(data.with_companystamp)                       
            
            if(!data.with_company_restriction) data.with_company_restriction = 0;
            if(data.with_company_restriction == 1) $( '[name="with_company_restriction"]' ).prop('checked',true).change();

            if(!data.with_delete_restriction) data.with_delete_restriction = 1;
            if(data.with_delete_restriction == 0) $( '[name="with_delete_restriction"]' ).prop('checked',true).change();

            if(!data.with_authenticable) data.with_authenticable = 0;
            if(data.with_authenticable == 1) $( '[name="with_authenticable"]' ).prop('checked',true).change();

            if(data.custom_filter) {
                $( '[name="custom_filter"]' ).val(data.custom_filter);
                eval("code_editor_custom_filter.setValue($( '[name=\"custom_filter\"]' ).val())")
                eval("code_editor_custom_filter.clearSelection()")
            }

            if(data.custom_union) {
                $( '[name="custom_union"]' ).val(data.custom_union);
                eval("code_editor_custom_union.setValue($( '[name=\"custom_union\"]' ).val())")
                eval("code_editor_custom_union.clearSelection()")
            }

            if(data.custom_union_model) {
                $('[name="custom_union_model[]"]').val(data.custom_union_model).change();
            }

            if(data.custom_join) {
                $( '[name="custom_join"]' ).val(data.custom_join);
                eval("code_editor_custom_join.setValue($( '[name=\"custom_join\"]' ).val())")
                eval("code_editor_custom_join.clearSelection()")
            }

            if(data.get_company_code) {
                $( '[name="get_company_code"]' ).val(data.get_company_code);
                eval("code_editor_get_company_code.setValue($( '[name=\"get_company_code\"]' ).val())")
                eval("code_editor_get_company_code.clearSelection()")
            }

            if(data.get_custom_creating) {
                $( '[name="get_custom_creating"]' ).val(data.get_custom_creating);
                eval("code_editor_get_custom_creating.setValue($( '[name=\"get_custom_creating\"]' ).val())")
                eval("code_editor_get_custom_creating.clearSelection()")
            }

            if(data.get_custom_updating) {
                $( '[name="get_custom_updating"]' ).val(data.get_custom_updating);
                eval("code_editor_get_custom_updating.setValue($( '[name=\"get_custom_updating\"]' ).val())")
                eval("code_editor_get_custom_updating.clearSelection()")
            }

            if(data.get_custom_deleting) {
                $( '[name="get_custom_deleting"]' ).val(data.get_custom_deleting);
                eval("code_editor_get_custom_deleting.setValue($( '[name=\"get_custom_deleting\"]' ).val())")
                eval("code_editor_get_custom_deleting.clearSelection()")
            }
                        
        }

        function build_kolom_tabel_modul(data) {
            if(get_data_array(data,'table')) {
                $( '[name="table"]' ).val(data['table']);
                eval("code_editor_table.setValue($( '[name=\"table\"]' ).val())")
                eval("code_editor_table.clearSelection()")
            }else {
                $( '[name="table"]' ).val('');
            }
        }

        function build_kolom_relasi_modul(data) {
            // $( "list_relasi" ).html('');
            // jumlah_relasi_builded = 0
            // window.jumlah_relasi = 0
            // if(get_data_array(data,'relation')) {
            //     $.each(data['relation'], function( index_relasi, value_relasi ) {
            //         tambah_relasi(jumlah_relasi_builded)

            //         fill_kolom_relasi(jumlah_relasi_builded,value_relasi)                    

            //         jumlah_relasi_builded++                    
            //     })
            // }
        }

        function fill_kolom_relasi(jumlah_relasi_builded,value_relasi,change_relasi) {
            change_relasi = typeof change_relasi !== 'undefined' ? change_relasi : 1
            if( change_relasi == 1) {
                $( '.relasi_type_'+jumlah_relasi_builded ).val(value_relasi['type']).change();
            }else{
                $( '.relasi_type_'+jumlah_relasi_builded ).val(value_relasi['type']);
            }
            if( value_relasi['name'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][name]"]' ).val(value_relasi['name']);
            }
            if( value_relasi['table'] ) {                
                $( '[name="relation['+jumlah_relasi_builded+'][table]"]' ).val(value_relasi['table']).change();                
            }
            if( value_relasi['model_name'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][model_name]"]' ).val(value_relasi['model_name']);
            }
            if( value_relasi['foreign_key'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key]"]' ).val(value_relasi['foreign_key']);
            }
            if( value_relasi['relation_key'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][relation_key]"]' ).val(value_relasi['relation_key']);
            }

            if( value_relasi['foreign_key_type'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_type]"]' ).val(value_relasi['foreign_key_type']);
            }
            if( value_relasi['relation_key_type'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][relation_key_type]"]' ).val(value_relasi['relation_key_type']);
            }

            if( value_relasi['check_data_function'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][check_data_function]"]' ).val(value_relasi['check_data_function']);
            }
            if( value_relasi['custom_union'] ) {
                fillCodeEditor( 'relation_custom_union'+jumlah_relasi_builded, "relation["+jumlah_relasi_builded+"][custom_union]", value_relasi['custom_union'] );                
            }
            if( value_relasi['custom_join'] ) {
                fillCodeEditor( 'relation_custom_join_'+jumlah_relasi_builded, "relation["+jumlah_relasi_builded+"][custom_join]", value_relasi['custom_join'] );
            }
            if( value_relasi['custom_option'] ) {
                fillCodeEditor( 'relation_custom_option_'+jumlah_relasi_builded, "relation["+jumlah_relasi_builded+"][custom_option]", value_relasi['custom_option'] );
            }
            if( value_relasi['custom_order'] ) {
                fillCodeEditor( 'relation_custom_order_'+jumlah_relasi_builded, "relation["+jumlah_relasi_builded+"][custom_order]", value_relasi['custom_order'] );                
            }            
            if( value_relasi['intermediate_table'] ) {                
                fillCodeEditor( 'relation_intermediate_table_'+jumlah_relasi_builded, "relation["+jumlah_relasi_builded+"][intermediate_table]", value_relasi['intermediate_table'] );
            }
            if( value_relasi['simpan_data'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][simpan_data]"]' ).prop('checked',true).change()
            }

            // khusus many to many
            if( value_relasi['foreign_key_model'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_model]"]' ).val(value_relasi['foreign_key_model']);
            }
            if( value_relasi['foreign_key_joining_model'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_joining_model]"]' ).val(value_relasi['foreign_key_joining_model']);
            }

            if( value_relasi['foreign_key_model_type'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_model_type]"]' ).val(value_relasi['foreign_key_model_type']);
            }else{
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_model_type]"]' ).val("integer");
            }
            if( value_relasi['foreign_key_joining_model_type'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_joining_model_type]"]' ).val(value_relasi['foreign_key_joining_model_type']);
            }else{
                $( '[name="relation['+jumlah_relasi_builded+'][foreign_key_joining_model_type]"]' ).val("integer");
            }

            if( value_relasi['intermediate_table'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][intermediate_table]"]' ).val(value_relasi['intermediate_table']);
            }
            if( value_relasi['modul_intermediate_table'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][modul_intermediate_table]"]' ).val(value_relasi['modul_intermediate_table']).change();
            }

            select_column_relasi = 0
            $( '.kolom_relasi_'+value_relasi['type']+'_'+jumlah_relasi_builded ).html('')
            $.each(value_relasi['select_column'], function( index_relasi_detail, value_relasi_detail ) {
                tambah_kolom_relasi(value_relasi['type'],jumlah_relasi_builded,select_column_relasi)
                $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][name]"]' ).val(value_relasi_detail['name']);
                $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][column]"]' ).val(value_relasi_detail['column']);
                
                eval("code_editor_" + jumlah_relasi_builded + select_column_relasi + ".setValue($( '[name=\"relation["+jumlah_relasi_builded+"][select_column]["+select_column_relasi+"][column]\"]' ).val())")
                eval("code_editor_" + jumlah_relasi_builded + select_column_relasi + ".clearSelection()")

                $( '[name="relation['+jumlah_relasi_builded+'][select_column]['+select_column_relasi+'][type]"]' ).val(value_relasi_detail['type']);
                select_column_relasi++
            });
            
            if( select_column_relasi > 0) {
                $( ".collapse_"+value_relasi['type']+"_"+jumlah_relasi_builded ).collapse('show')
            }else {
                $( ".collapse_"+value_relasi['type']+"_"+jumlah_relasi_builded ).collapse('hide')
            }

            select_column_tambahan_relasi = 0
            $( '.kolom_tambahan_relasi_'+value_relasi['type']+'_'+jumlah_relasi_builded ).html('')
            $.each(value_relasi['column_add_on'], function( index_relasi_detail, value_relasi_detail ) {
                tambah_kolom_tambahan_relasi(value_relasi['type'],jumlah_relasi_builded,select_column_tambahan_relasi)
                $( '[name="relation['+jumlah_relasi_builded+'][column_add_on]['+select_column_tambahan_relasi+'][name]"]' ).val(value_relasi_detail['name']);                    
                $( '[name="relation['+jumlah_relasi_builded+'][column_add_on]['+select_column_tambahan_relasi+'][type]"]' ).val(value_relasi_detail['type']);
                select_column_tambahan_relasi++
            });
        }

        function build_kolom_route_modul(data) {
            $( "list_route" ).html('')
            jumlah_route_builded = 0
            window.jumlah_route = 0
            if(get_data_array(data,'route')) {                
                $.each(data['route'], function( index_route, value_route ) {   
                    tambah_route(jumlah_route_builded)
                    $( '[name="route['+jumlah_route_builded+'][prefix]"]' ).val(value_route['prefix']).change();
                    $( '[name="route['+jumlah_route_builded+'][name]"]' ).val(value_route['name']);
                    $( '[name="route['+jumlah_route_builded+'][process]"]' ).val(value_route['process']).change();
                    $( '[name="route['+jumlah_route_builded+'][method]"]' ).val(value_route['method']);
                    
                    build_kolom_parameter_route(jumlah_route_builded,value_route['param'])
                    build_validasi(jumlah_route_builded,value_route['validation'])
                    build_kolom_middleware_route(jumlah_route_builded,value_route['middleware'])
                    
                    if( value_route['process'] == 'custom_data' )
                    {
                        $( '[name="route['+jumlah_route_builded+'][custom_function]"]' ).val(value_route['custom_function'])
                        // eval("code_editor_process_" + jumlah_route_builded + ".setValue($( '[name=\"route["+jumlah_route_builded+"][custom_function]\"]' ).val())")
                        // eval("code_editor_process_" + jumlah_route_builded + ".clearSelection()")
                    }

                    if( value_route['process'] != 'custom_data' )
                    {
                        $( '[name="route['+jumlah_route_builded+'][custom_code_before]"]' ).val(value_route['custom_code_before'])
                        // eval("code_editor_custom_code_before_" + jumlah_route_builded + ".setValue($( '[name=\"route["+jumlah_route_builded+"][custom_code_before]\"]' ).val())")
                        // eval("code_editor_custom_code_before_" + jumlah_route_builded + ".clearSelection()")

                        $( '[name="route['+jumlah_route_builded+'][custom_code_after]"]' ).val(value_route['custom_code_after'])
                        // eval("code_editor_custom_code_after_" + jumlah_route_builded + ".setValue($( '[name=\"route["+jumlah_route_builded+"][custom_code_after]\"]' ).val())")
                        // eval("code_editor_custom_code_after_" + jumlah_route_builded + ".clearSelection()")
                    }
                    
                    jumlah_route_builded++
                })
            }
        }
    </script>

    <script>
        $( "#key" ).focus(function() {
            
            var listColumn = []
            objModul = $('#modul').serializeJSON()            
            $.each(objModul['column'], function( index_column, value_column ) {
                listColumn.push(value_column['name'])
            })

            $( "#key" ).autocomplete({
                source: listColumn
            });

        });
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
        $('.multi-select2').select2({
            placeholder: 'Models',
            allowClear: true,
            width: '100%',
            data:select2_data,
        });
    </script>

    <script src="<?php echo URL::to('/vendor/khancode/js/storage.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/submit.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-column-table.js');?>"></script> 
    <script src="<?php echo URL::to('/vendor/khancode/js/list-index.js');?>"></script>   
    <script src="<?php echo URL::to('/vendor/khancode/js/list-cast.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-column-function.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-column-relasi.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-column-route.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-system-class.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-system-modul.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-repository-class.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-repositories.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-files.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/list-classtab.js');?>"></script>
@endsection