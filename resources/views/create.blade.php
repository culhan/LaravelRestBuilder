@extends('khancode::base')

@section('title', 'Create Modul')

@section('content')    
    <div class="col-lg-12">        
        <form id="modul">
            <div class="form-group">
                <label>Nama Modul</label>
                <input type="" class="form-control d-none" id="modul_id" name='id' value='{{ Arr::get($data, 'id', 0) }}'>
                <input type="" class="form-control" id="modul_name" placeholder="nama modul" name='name'>
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
                    <a class="nav-link" id="route-tab" data-toggle="tab" href="#route" role="tab" aria-controls="route" aria-selected="false">System Modul</a>
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
                                                    <option value="integer" selected="selected">Integer</option>
                                                    <option value="bigint">Big Integer</option>
                                                    <option value="smallInteger">Small Integer</option>
                                                    <option value="tinyInteger">Tiny Integer</option>
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
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Custom Filter</label>
                            <textarea name="custom_filter" class="d-none"></textarea>
                            <textarea id="tab_custom_filter"></textarea>
                            <pre>*input ".code." akan di baca kode php</pre>
                        </div>
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
                        </div>

                        <relation_table>
                        </relation_table>
                        <!-- <list_relasi class="d-none">
                        </list_relasi> -->

                        <!-- <br> -->
                        <!-- <input class="btn btn-primary" type="button" value="Tambah Relasi" height='10px' id='add_relasi'> -->

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
                            <custom></custom>                            
                            
                            <div class="row mb-3 route_advanced_middleware">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_middleware_route_sementara" aria-expanded="true" aria-controls="route_middleware_route_sementara"><b>Middleware</b></label>
                                </div>
                            </div>
                            <div class="container route_middleware_route_sementara collapse">
                            </div>

                            <div class="row mb-3 route_advanced_param">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_parameter_tambahan" aria-expanded="true" aria-controls="route_parameter_tambahan"><b>Parameter</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_parameter_tambahan collapse">
                                <div class="container route_param_route_sementara">
                                </div>
                                <input class="btn btn-secondary mb-3" type="button" value="Tambah Parameter" height="10px" onclick="tambah_route_parameter('route_sementara',0)">
                            </div>

                            <div class="row mb-3 route_advanced_validation">
                                <div class="col-sm" style="padding-top:5px;">
                                    <label data-toggle="collapse" class="list-collapse collapsed" data-target=".route_validasi" aria-expanded="true" aria-controls="route_validasi"><b>Validasi Data</b></label>
                                </div>
                            </div>
                            <div class="col-sm route_validasi collapse">
                                <div class="container route_route_sementara">
                                </div>
                                <input class="btn btn-secondary mb-3" type="button" value="Tambah Validasi" height="10px" onclick="tambah_validasi('route_sementara',0)">
                            </div>
                            
                        </div>

                        <div class="row container mb-4">
                            <input class="btn btn-primary" type="button" value="Tambah Route" id="tambah_route" height="10px" onclick="tambah_route_table()">
                            <input class="btn btn-primary d-none" type="button" value="Edit Route" id="edit_route" height="10px" onclick="edit_route_table()">
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
    
    <div class="modal"><!-- Place at bottom of page --></div>    
@endsection

@section('script_add_on')
    <script src="<?php echo URL::to('/vendor/khancode/js/src/ace.js');?>"></script>
    <script src="<?php echo URL::to('/vendor/khancode/js/src/ext-language_tools.js');?>"></script>    
    
    <?php
        
        $dir = app_path().'/Http/Models/';
        $files = scandir($dir);

        $models = array();
        $namespace = '\App\Http\Models\\';
        foreach($files as $file) {
            //skip current and parent folder entries and non-php files
            if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
                $models[] = $namespace . preg_replace('/.php$/', '', $file);
        }
        $dir = app_path().'/Http/Services/';
        $files = scandir($dir);

        // $models = array();
        $namespace = '\App\Http\Services\\';
        foreach($files as $file) {
            //skip current and parent folder entries and non-php files
            if ($file == '.' || $file == '..' || !preg_match('/.php/', $file)) continue;
                $models[] = $namespace . preg_replace('/.php$/', '', $file);
        }
        
    ?>
    <script>   
        var dataModels = <?php echo json_encode($models)?>;
        
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

            if(ele.value == 'custom_data') {                
                html_code_php = 
                    '<div class="mt-3 custom_data_'+i+' ">'+
                        '<textarea name="'+name_route+'[custom_function]" class="d-none">'+
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
                                
                $( '.custom_data_'+i ).remove()
                toAppend.append(html_code_php)
                
                if(i == 'route_sementara') {
                    eval("code_editor_process_" + i + "= ace.edit('route_text_'+i, {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
                    eval("code_editor_process_" + i + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
                    eval("code_editor_process_" + i + ".getSession().on('change', function(e) {val_code = code_editor_process_"+i+".getSession().getValue();$( '[name=\""+name_route+"[custom_function]\"]' ).val(val_code);})")
                    eval("")
                }            
            }else if(ele.value == 'system_data') {                
                html_code_php = 
                    '<div class="mt-3 custom_data_'+i+' ">'+
                        '<textarea name="'+name_route+'[system_function]" class="d-none">'+
                            '// locking function'+"\n"+
                            '\\DB::beginTransaction();'+"\n"+
                            '$single_data = $this->getSingleData(1);'+"\n"+
                            '\\DB::commit();'+"\n"+
                            '// unlocking function'+"\n"+
                            'return true;'+"\n"+
                        '</textarea>'+
                        '<textarea id="route_text_'+i+'">'+
                            '// locking function'+"\n"+
                            '\\DB::beginTransaction();'+"\n"+
                            '$single_data = $this->getSingleData(1);'+"\n"+
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
                
                // if( eval( $('.custom_code_before_'+i)[0] )) {
                //     return
                // }
                
                isi_before = ''
                if( dataOld[name_route+'[custom_code_before]'] ){ 
                    isi_before = dataOld[name_route+'[custom_code_before]']
                }

                isi_after = ''
                if( dataOld[name_route+'[custom_code_after]'] ){ 
                    isi_after = dataOld[name_route+'[custom_code_after]']
                }
                
                if(ele.value == 'create_update_data' && !isi_before.includes("$keyFirstOrCreate")) {
                    isi_before = '$keyFirstOrCreate = [\'key\' => \'value\'];'+"\n"+isi_before                    
                }  


                html_code_php = 
                    '<div class="row mb-3 custom_data_'+i+'">'+
                        '<div class="col-sm-3" style="padding-top:5px;">'+
                            '<label><b>Custom Code Before</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="mt-3 custom_data_'+i+' custom_code_before_'+i+' ">'+                        
                        '<textarea name="'+name_route+'[custom_code_before]" class="d-none" data-editor="php" rows="10">'+isi_before+
                        '</textarea>'+
                        '<textarea id="route_custom_code_before_'+i+'">'+isi_before+
                        '</textarea>'+
                    '</div>';

                html_code_php += 
                    '<div class="row mb-3 custom_data_'+i+'">'+
                        '<div class="col-sm-3" style="padding-top:5px;">'+
                            '<label><b>Custom Code After</b></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="mt-3 custom_data_'+i+' custom_code_after_'+i+' ">'+                        
                        '<textarea name="'+name_route+'[custom_code_after]" class="d-none" data-editor="php" rows="10">'+isi_after+
                        '</textarea>'+
                        '<textarea id="route_custom_code_after_'+i+'">'+isi_after+
                        '</textarea>'+
                    '</div>';
                
                $( '.custom_data_'+i ).remove()
                toAppend.append(html_code_php)
                                
                if(i == 'route_sementara') {                    
                    eval("code_editor_custom_code_before_" + i + "= ace.edit('route_custom_code_before_'+i)")
                    eval("code_editor_custom_code_before_" + i + ".setOptions({mode: \"ace/mode/phpinline\", maxLines: 30, minLines: 5, wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
                    eval("code_editor_custom_code_before_" + i + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
                    eval("code_editor_custom_code_before_" + i + ".getSession().on('change', function(e) {val_code = code_editor_custom_code_before_"+i+".getSession().getValue();$( '[name=\""+name_route+"[custom_code_before]\"]' ).val(val_code);})")
                    
                    eval("code_editor_custom_code_after_" + i + "= ace.edit('route_custom_code_after_'+i, {mode: \"ace/mode/php\", maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
                    eval("code_editor_custom_code_after_" + i + ".getSession().setMode({path:\"ace/mode/phpinline\", inline:true})")
                    eval("code_editor_custom_code_after_" + i + ".getSession().on('change', function(e) {val_code = code_editor_custom_code_after_"+i+".getSession().getValue();$( '[name=\""+name_route+"[custom_code_after]\"]' ).val(val_code);})")                
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
        }

        function show_hide_key(i) {
            $('.lock_key_'+i).hide();
            $('[name="route_sementara[lock]"]').prop('disabled',true);
            if ($('.lock_'+i).is(':checked')) {
                $('.lock_key_'+i).show();
                $('[name="route_sementara[lock]"]').prop('disabled',false);                
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

        function ubah_type_kolom_modul_table(data) {
            if(data.value == 'decimal') {
                html_decimal_detail = 
                    '<input type="" class="form-control" placeholder="precision (default = 8)" name="column_sementara[precision]">'+
                    '<input type="" class="form-control" placeholder="scale (default = 2)" name="column_sementara[scale]">';
                $(data).parent().append(html_decimal_detail);
            }else {
                $( "[name='column_sementara[precision]']" ).remove()
                $( "[name='column_sementara[scale]']" ).remove()
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
                            '<label>Menyimpan Data </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<div class="form-check form-check-inline with-check">'+
                                '<input class="form-check-input" type="checkbox" name="relation['+i+'][simpan_data]">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '';

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
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Custom order </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<input type="" class="form-control" placeholder="custom order relasi (ex:order by name asce)" name="relation['+i+'][custom_order]">'+
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
                
                $( "[name='relation["+i+"][simpan_data]']" ).switcher();
                
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
                '<div class="row_modul_table_'+nama_kolom+' d-none">'+
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
                                        '<option value="bigint">Big Integer</option>'+
                                        '<option value="smallInteger">Small Integer</option>'+
                                        '<option value="tinyInteger">Tiny Integer</option>'+
                                        '<option value="decimal">Decimal</option>'+
                                        '<option value="datetime">Datetime</option>'+
                                        '<option value="date">Date</option>'+
                                        '<option value="timestamp">Timestamp</option>'+
                                        '<option value="string">String</option>'+
                                        '<option value="char">Char</option>'+
                                        '<option value="text">Text</option>'+
                                        '<option value="time">Time</option>'+                                        
                                    '</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row mb-3">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Default </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<textarea class="form-control" name="column['+nama_kolom+'][default]" rows="2"></textarea>'+                                
                            '</div>'+
                        '</div>'+
                        '<div class="row mb-3">'+
                            '<div class="col-sm-2" style="padding-top:5px;">'+
                                '<label>Comment </label>'+
                            '</div>'+
                            '<div class="col-sm">'+
                                '<textarea class="form-control" name="column['+nama_kolom+'][comment]" rows="2"></textarea>'+
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
                '</div>'+
            '';            
            $( "list_kolom" ).append(html_new_kolom);
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

        function tambah_route_parameter(i_route,i_ele) {
            if( typeof i_route == "string") {
                i_route = "'"+i_route+"'"

                html_parameter = 
                '<div class="row mb-3">'+
                    '<div class="col-sm-3" style="padding-top:5px;">'+
                        '<label>'+(i_ele+1)+'.&nbsp;&nbsp;Nama</label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input type="" class="form-control" placeholder="nama parameter" name="route_sementara[param]['+i_ele+']">'+
                    '</div>'+
                    '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_kolom_parameter_route('+i_route+','+i_ele+')">x</button>'+
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
                    '<div class="row mb-3">'+
                        '<div class="col-sm-2" style="padding-top:5px;">'+
                            '<label>Json </label>'+
                        '</div>'+
                        '<div class="col-sm">'+
                            '<div class="form-check form-check-inline with-check">'+
                                '<input class="form-check-input" type="checkbox" name="column_function['+nama_kolom_fungsi+'][json]">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '';

            $( "list_function_column" ).append(html_new_kolom_fungsi);

            $( "[name='column_function["+nama_kolom_fungsi+"][json]']" ).switcher();

            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('column_function_'+nama_kolom_fungsi, {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\"column_function["+nama_kolom_fungsi+"][function]\"]' ).val(val_code);})")            
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

            $( "[name=\"route_sementara[process]\"]" ).change()            
            
            $( "[name=\"relation[relation_sementara][type]\"]" ).change();

            // $( "#add_relasi" ).click(function( event ) {
            //     tambah_relasi(jumlah_relasi)
            //     window.objModul = $('#modul').serializeJSON()
            // });

            // $( "#add_route" ).click(function( event ) {
            //     tambah_route(jumlah_route)
            //     window.objModul = $('#modul').serializeJSON()                
            // })
            
            $( "#add_function_column" ).click(function( event ) {
                tambah_kolom_fungsi(jumlah_kolom_fungsi)
                window.objModul = $('#modul').serializeJSON()                
            })

            nama_kolom_fungsi = 'custom_filter'
            eval("code_editor_" + nama_kolom_fungsi + "= ace.edit('tab_custom_filter', {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
            eval("code_editor_" + nama_kolom_fungsi + ".getSession().on('change', function(e) {val_code = code_editor_"+nama_kolom_fungsi+".getSession().getValue();$( '[name=\""+nama_kolom_fungsi+"\"]' ).val(val_code);})")
            
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
                    $( '[name="route_sementara[param]['+i+']"]' ).val(value)
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

        function moveColumnFunction(old_index, new_index) {
            objModul = $('#modul').serializeJSON()
            objModul.column_function = toArray(objModul.column_function)
            objModul.column_function = move(objModul.column_function, old_index, new_index)
            build_kolom_fungsi(objModul);
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
                            build_modul_tabel(objModul['column'],objForbiddenCOlumn);
                        }else {
                            objColumn = []
                            objModul['column'] = []
                            objForbiddenCOlumn = []
                            build_kolom_tabel([]);
                            build_tabel_option_by_column([])
                            build_modul_tabel([]);
                        }
                    },
                    error: function(e) {
                        objColumn = []
                        objModul['column'] = []
                        objForbiddenCOlumn = []
                        build_kolom_tabel([]);
                        build_tabel_option_by_column([])
                        build_modul_tabel([]);
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
                        build_semua_kolom(objModul)                        
                    },
                    error: function(e) {
                        alert('data modul tidak ada')
                        objModul = []
                        build_semua_kolom([],'')
                    }
                });
            // }, 500);
        }

        function build_semua_kolom(json) {
            build_tabel_option(json);
            build_kolom_tabel_modul(json);
            // build_kolom_relasi_modul(json);
            // build_kolom_route_modul(json);
            build_kolom_fungsi(json);
            build_route_tabel(json['route'])
            // if(get_data_array(json,'route')) {
            // }else {
            //     build_route_tabel([])
            // }
            build_relation_tabel(json['relation'])
            storage_parameter.update('hidden',json['hidden'])
            storage_parameter.update('route',json['route'])            
            storage_parameter.update('relation',json['relation'])
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
            $( '[name="key"]' ).val('').change();
            $( '[name="with_timestamp"]' ).val(0).change();
            $( '[name="with_authstamp"]' ).val(0).change();
            $( '[name="with_ipstamp"]' ).val(0).change();
            $( '[name="with_companystamp"]' ).val(0).change();
            $( '[name="custom_filter"]' ).val('');
            eval("code_editor_custom_filter.setValue('')")
            eval("code_editor_custom_filter.clearSelection()")

            if(data.key) $( '[name="key"]' ).val(data.key).change();
            if(data.with_timestamp) $( '[name="with_timestamp"]' ).val(data.with_timestamp).change();
            if(data.with_authstamp) $( '[name="with_authstamp"]' ).val(data.with_authstamp).change();
            if(data.with_ipstamp) $( '[name="with_ipstamp"]' ).val(data.with_ipstamp).change();
            if(data.with_companystamp) $( '[name="with_companystamp"]' ).val(data.with_companystamp).change();

            if(data.custom_filter) {
                $( '[name="custom_filter"]' ).val(data.custom_filter);
                eval("code_editor_custom_filter.setValue($( '[name=\"custom_filter\"]' ).val())")
                eval("code_editor_custom_filter.clearSelection()")
            }            
        }

        function build_kolom_tabel_modul(data) {
            if(get_data_array(data,'table')) {
                $( '[name="table"]' ).val(data['table']).keyup();
            }else {
                $( '[name="table"]' ).val('').keyup();
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
            if( value_relasi['custom_join'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][custom_join]"]' ).val(value_relasi['custom_join']);
            }
            if( value_relasi['custom_option'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][custom_option]"]' ).val(value_relasi['custom_option']);
            }
            if( value_relasi['custom_order'] ) {
                $( '[name="relation['+jumlah_relasi_builded+'][custom_order]"]' ).val(value_relasi['custom_order']);
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
            if( value_relasi['intermediate_table'] ){
                $( '[name="relation['+jumlah_relasi_builded+'][intermediate_table]"]' ).val(value_relasi['intermediate_table']);
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
                    eval("code_editor_" + nama_kolom_fungsi + ".clearSelection()")

                    if( value_column_function['json'] ) {
                        $( '[name="column_function['+jumlah_kolom_fungsi_builded+'][json]"]' ).prop('checked',true).change()
                    }
                    jumlah_kolom_fungsi_builded++
                })
            }
        }
    </script>

    <script>
        // khusus storage
        var items = {};

        var storage_parameter = {
            add(index,value) {

                if(index.indexOf('.') !== -1) {
                    index = index.split(".");
                    arr1 = ''
                    $.each(index, function( index_index, value_index ) {
                        arr1 += '["'+value_index+'"]'
                        if( !eval('window.items'+arr1) ) {
                            eval('window.items'+arr1+'={}')
                        }
                    })

                    if(typeof value != 'undefined') {
                        lengthObj = eval('Object.keys(window.items'+arr1+').length')
                        eval('window.items'+arr1+'['+lengthObj+'] = value')
                    }
                }else {                    
                    if( !window.items[index] ) {
                        window.items[index] = {}
                    }

                    if(typeof value != 'undefined') {
                        lengthObj = Object.keys(window.items[index]).length
                        window.items[index][lengthObj] = value
                    }
                }
                
                return true
            },
            remove(index) {
                
                index = index.split(".");
                arr1 = ''
                $.each(index, function( index_items, value_items ) {
                    if( (index_items+1)!=index.length ) {
                        arr1 += '["'+value_items+'"]'
                    }else {
                        last_item = value_items
                    }
                })
                
                eval('delete window.items'+arr1+'[last_item]')

                // re order jika object key berurutan
                new_data = {}
                key_only_number = true
                start = 0                    
                $.each( eval('window.items'+arr1), function(i,v){
                    if( !(/^\d+$/.test(i)) ){
                        key_only_number = false
                    }
                    if(typeof v != 'undefined') {
                        new_data[ start ] = v
                        start++
                    }                        
                });
                
                if( key_only_number ) {
                    eval('window.items'+arr1+'=new_data')
                }
                
            },
            update(index,value) {
                if(index.indexOf('.') !== -1) {
                    index = index.split(".");
                    arr1 = ''
                    $.each(index, function( index_items, value_items ) {
                        arr1 += '["'+value_items+'"]'
                    })
                    return eval('window.items'+arr1+'=value')
                }else {
                    return window.items[index] = value
                }
            },
            get(index) {
                if(index.indexOf('.') !== -1) {
                    index = index.split(".");
                    arr1 = ''
                    $.each(index, function( index_items, value_items ) {
                        arr1 += '["'+value_items+'"]'
                        if( typeof eval('window.items'+arr1) == 'undefined' ) {
                            return false
                        }
                    })
                    return eval('window.items'+arr1)
                }else {
                    if( typeof window.items[index] == 'undefined' ) {
                        return false
                    }else {
                        return window.items[index]
                    }
                }
            },
            find(index,value) {
                its_obj = storage_parameter.get(index)
                if( typeof its_obj != 'object') {
                    return -1
                }

                return_str = -1
                $.each(its_obj, function( index_its_obj, value_its_obj ) {
                    if( value_its_obj == value ) {
                        return_str = index_its_obj
                    }
                });

                return return_str
            },
            all() {
                return window.items;
            }
        };
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
                        tableHtml += '<th>Hide/Show</th>'
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
                            tableHtml += '</td>'
                            tableHtml += '<td>'
                                tableHtml += value_column_function['name']
                            tableHtml += '</td>'

                            tableHtml += '<td>'
                            if( storage_parameter.find('hidden',value_column_function['name']) == -1 ) {                                
                                tableHtml += '<div class="form-check form-check-inline">'
                                    tableHtml += '<input class="form-check-input hidden_col" type="checkbox" checked onchange="ubahHiddenInTable(this,'+index_column_function+')" >'
                                tableHtml += '</div>'
                            }else {                                
                                tableHtml += '<div class="form-check form-check-inline">'
                                    tableHtml += '<input class="form-check-input hidden_col" type="checkbox" onchange="ubahHiddenInTable(this,'+index_column_function+')" >'
                                tableHtml += '</div>'
                            }
                            tableHtml += '</td>'

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
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
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
        }

        function moveColumnModulTable(i,y) {
            moveColumn(i,y)
            build_modul_tabel(objColumn,objForbiddenCOlumn)
        }

        function tambah_kolom_modul_table_click() {
            tambah_kolom_click();
            objModul = $('#modul').serializeJSON()
            column_sementara = objModul['column_sementara']
            
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
                scrollTop: $( "[name='column_sementara[name]']" ).offset().top
            }, 1000, function() {
                $( "[name='column_sementara[name]']" ).focus();
            });
        }

        function ubah_kolom_modul_table_click(i) {
            objModul = $('#modul').serializeJSON()
            column_sementara = objModul['column_sementara']

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
        function simpanKeApi() {
            
            objModul = $('#modul').serializeJSON()
            delete objModul['route']
            delete objModul['relation']
            delete objModul['route_sementara']
            delete objModul['column_sementara']            

            $.ajax({
                url: '{{url('/')}}/build',
                type: "POST",
                data: JSON.stringify(Object.assign({}, objModul, storage_parameter.all() )),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    htmlcreated = ''
                    htmlupdated = ''
                    $.each(data,function(index,value) {
                        $.each(value,function(index_2,value_2) {
                            if(index == 'created') {
                                htmlcreated += value_2+"<br>"
                            }else if(index == 'updated') {
                                htmlupdated += value_2+"<br>"
                            }
                            
                        })
                    })

                    
                    $( "[name='id']" ).val(data.data.id).change()

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

    <script>
        $( "#key" ).focus(function() {
            
            listColumn = []
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
        function prefixChange(ele){
            $( '.'+($(ele).attr('name')).replace(/[\[\]']+/g,'') ).html('api/'+ele.value+objModul['name']+'/')
        }        
    </script>

    <script>
        // khusus table route    
        
        storage_parameter.add('route');

        function build_route_tabel(data) {

            tableHtml = '<table id="example_route" class="table table-striped table-bordered" style="width:100%">'
                tableHtml += '<thead>'
                    tableHtml += '<tr>'
                        tableHtml += '<th>#</th>'
                        tableHtml += '<th>Name</th>'
                        tableHtml += '<th>Proses</th>'
                        tableHtml += '<th>Action</th>'
                    tableHtml += '</tr>'
                tableHtml += '</thead>'
                tableHtml += '<tbody>'                

                iDataTable=0                
                $.each(data, function( index_route, value_route ) {
                    index_route = parseInt(index_route)
                    if(value_route['process']=="list_data") {
                        v_process = "Mengambil Banyak Data"
                    }
                    if(value_route['process']=="single_data") {
                        v_process = "Mengambil Satu Data"
                    }
                    if(value_route['process']=="create_data") {
                        v_process = "Menyimpan Data"
                    }
                    if(value_route['process']=="update_data") {
                        v_process = "Memperbaharui Data"
                    }
                    if(value_route['process']=="delete_data") {
                        v_process = "Menghapus Data"
                    }
                    if(value_route['process']=="custom_data") {
                        v_process = "Custom"
                    }
                    if(value_route['process']=="system_data") {
                        v_process = "Fungsi System"
                    }
                    if(value_route['process']=="create_update_data") {
                        v_process = "Menyimpan atau memperbaharui data"
                    }
                    tableHtml += '<tr>'
                        tableHtml += '<td>'
                            tableHtml += (iDataTable+1)
                        tableHtml += '</td>'
                        tableHtml += '<td>'
                            tableHtml += value_route['name']
                        tableHtml += '</td>'
                        tableHtml += '<td>'
                            tableHtml += v_process
                        tableHtml += '</td>'
                        tableHtml += '<td id="route_'+iDataTable+'">'                        
                            tableHtml += '<button data-placement="top" data-toggle="tooltip" title="Duplicate" type="button" class="btn btn-light float-right btn-sm" onclick="copyRouteFromTable(\''+index_route+'\')" style="margin-right: 15px;">'
                            tableHtml += '<svg x="0px" y="0px" width="15" height="15" viewBox="0 0 24 24" style=" fill:#000000;"><path d="M 4 2 C 2.895 2 2 2.895 2 4 L 2 18 L 4 18 L 4 4 L 18 4 L 18 2 L 4 2 z M 8 6 C 6.895 6 6 6.895 6 8 L 6 20 C 6 21.105 6.895 22 8 22 L 20 22 C 21.105 22 22 21.105 22 20 L 22 8 C 22 6.895 21.105 6 20 6 L 8 6 z M 8 8 L 20 8 L 20 20 L 8 20 L 8 8 z"></path></svg>'
                            tableHtml += '</button>'
                            tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editRouteFromTable(\''+index_route+'\')" style="margin-right: 15px;">'
                            tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
                            tableHtml += '</button>'
                            tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeRouteFromTable(\''+index_route+'\')" style="margin-right: 15px;">'
                            tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
                            tableHtml += '</button>'
                            tableHtml += '<button type="button" class="btn btn-info float-right btn-sm" onclick="moveRouteFromTable('+(index_route+1)+', '+index_route+')" style="margin-right: 15px;">'
                            tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.5 0l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z" transform="translate(0 1)"></path></svg>'
                            tableHtml += '</button>'
                            if(iDataTable!=0){
                                tableHtml += '<button type="button" class="btn btn-success float-right btn-sm" onclick="moveRouteFromTable('+(index_route-1)+', '+index_route+')" style="margin-right: 15px;">'
                                tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M4 0l-4 4 1.5 1.5 2.5-2.5 2.5 2.5 1.5-1.5-4-4z" transform="translate(0 1)"></path></svg>'
                                tableHtml += '</button>'
                            }
                        tableHtml += '</td>'
                    tableHtml += '</tr>'
                    iDataTable++
                })

                tableHtml += '<tbody>'
            tableHtml += '</table>'

            $( "route_table" ).html(tableHtml);
            $( "#route_"+(iDataTable-1)+" .btn-info" ).remove()
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            })

            page_now = 0;
            page_length = 5;
            if(route_table != '') {
                page_now = route_table.page.info().page
                page_length = route_table.page.info().length
            }

            route_table = $( "#example_route" ).DataTable({
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
            });
            
            route_table.page.len( page_length ).page( page_now ).draw( 'page' );

            if(page_now > (route_table.page.info().pages-1)) {                
                page_now--
                route_table.page( page_now ).draw( 'page' );
            }            
        }

        function tambah_route_table() {
            storage_parameter.add('route',$('#modul').serializeJSON().route_sementara)
            build_route_tabel(storage_parameter.get('route'))
            route_table.page( 'last' ).draw( 'page' );

            clear_route_sementara()
        }                

        function fill_route_sementara(data) {
            param_fill = 0
            validasi_fill = 0
            middleware_fill = 0

            $( ".route_param_route_sementara" ).html('')
            $( ".route_route_sementara" ).html('')            
            
            $( "[onclick^=\"tambah_route_parameter('route_sementara'\"]" ).attr('onclick',"tambah_route_parameter('route_sementara',0)");
            $( "[onclick^=\"tambah_validasi('route_sementara'\"]" ).attr('onclick',"tambah_validasi('route_sementara',0)");

            $.each(data, function( index_route_sementara, value_route_sementara ) {
                if( index_route_sementara != 'param' 
                    || index_route_sementara != 'validation' 
                    || index_route_sementara != 'middleware' 
                    || index_route_sementara != 'middleware_parameter'
                    || index_route_sementara != 'lock'
                ) {
                    $( "[name='route_sementara["+index_route_sementara+"]']" ).val(value_route_sementara).change()
                }                
                if(index_route_sementara == 'lock') {
                    $( '.lock_route_sementara' ).prop('checked',true).change()
                    $( "[name='route_sementara[lock]']" ).val(value_route_sementara)
                }
                if(index_route_sementara == 'param'){
                    $.each(value_route_sementara, function( index_param, value_param ) {
                        tambah_route_parameter('route_sementara',(index_param*1))
                        $( "[name='route_sementara[param]["+index_param+"]']" ).val(value_param).change()                        
                        param_fill++
                    })
                }
                if(index_route_sementara == 'validation'){
                    $.each(value_route_sementara, function( index_validation, value_validation ) {
                        tambah_validasi('route_sementara',(index_validation*1))
                        $( "[name='route_sementara[validation]["+index_validation+"][name]']" ).val(value_validation['name']).change()
                        $( "[name='route_sementara[validation]["+index_validation+"][statement]']" ).val(value_validation['statement']).change()
                        validasi_fill++
                    })
                }
                if(index_route_sementara == 'middleware'){
                    $.each(value_route_sementara, function( index_middleware, value_middleware ) {
                        // tambah_route_middleware('route_sementara',(index_middleware*1))
                        // $( "[name='route_sementara[middleware]["+index_middleware+"]']" ).val(value_middleware).change()

                        if(value_middleware.indexOf(':') > -1) {
                            v_mid = value_middleware.split(":");
                            value_middleware = v_mid[0]
                            if(!data['middleware_parameter']) {
                                data['middleware_parameter'] = {}
                            }
                            data['middleware_parameter'][value_middleware] = v_mid[1]
                        }

                        $( "[name^='route_sementara[middleware]'][value='"+value_middleware+"']" ).prop('checked',true).change()
                        if(data['middleware_parameter']) {
                            if(data['middleware_parameter'][value_middleware]) {
                                $( "[name^='route_sementara[middleware_parameter]["+value_middleware+"]']" ).val(data['middleware_parameter'][value_middleware])
                            }
                        }
                        middleware_fill++
                    })
                }

                if(index_route_sementara == 'custom_code_before' || index_route_sementara == 'custom_code_after'){
                    name_sementara_code = index_route_sementara
                    eval("code_editor_"+name_sementara_code+"_route_sementara.setValue($( '[name=\"route_sementara["+name_sementara_code+"]\"]' ).val())")
                    eval("code_editor_"+name_sementara_code+"_route_sementara.clearSelection()")                    
                }

                if(index_route_sementara == 'custom_function'){                    
                    eval("code_editor_process_route_sementara.setValue($( '[name=\"route_sementara[custom_function]\"]' ).val())")
                    eval("code_editor_process_route_sementara.clearSelection()")                    
                }

                if(index_route_sementara == 'system_function'){                    
                    eval("code_editor_process_route_sementara.setValue($( '[name=\"route_sementara[system_function]\"]' ).val())")
                    eval("code_editor_process_route_sementara.clearSelection()")                    
                }
                                
            })

        
            // if( middleware_fill > 0 ) {
                $( ".route_middleware_route_sementara " ).collapse('show')
            // }

            // if( validasi_fill > 0 ) {
                $( ".route_validasi " ).collapse('show')
            // }

            // if( param_fill > 0 ) {
                $( ".route_parameter_tambahan " ).collapse('show')
            // }

            dataOld = {}
        }

        function clear_route_sementara() {
            $( "[name='route_sementara[name]']" ).val('')
            $( "[name='route_sementara[prefix]']" ).val('admin/v1/{locale}/')
            $( "[name='route_sementara[method]']" ).val('get').change()
            $( "[name='route_sementara[process]']" ).val('list_data').change()
            $( '.lock_route_sementara' ).prop('checked',false).change()
            $( "[name='route_sementara[lock]']" ).val('')            
            
            $( ".route_param_route_sementara" ).html('')
            $( ".route_route_sementara" ).html('')            
            
            $( "[onclick^=\"tambah_route_parameter('route_sementara'\"]" ).attr('onclick',"tambah_route_parameter('route_sementara',0)");
            $( "[onclick^=\"tambah_validasi('route_sementara'\"]" ).attr('onclick',"tambah_validasi('route_sementara',0)");

            $( "[onclick^=\"tambah_route_middleware('route_sementara'\"]" ).attr('onclick',"tambah_route_middleware('route_sementara',0)");
            $( "[name^='route_sementara[middleware]']" ).prop('checked',false).change()
            $( "[name^='route_sementara[middleware_parameter]']" ).val('')

            $( ".route_middleware_route_sementara " ).collapse('hide')
            $( ".route_parameter_tambahan" ).collapse('hide')
            $( ".route_validasi" ).collapse('hide')

            $( '[name=\"route_sementara[custom_code_before]\"]' ).val('')
            eval("code_editor_custom_code_before_route_sementara.setValue($( '[name=\"route_sementara[custom_code_before]\"]' ).val())")
            eval("code_editor_custom_code_before_route_sementara.clearSelection()") 

            $( '[name=\"route_sementara[custom_code_after]\"]' ).val('')
            eval("code_editor_custom_code_after_route_sementara.setValue($( '[name=\"route_sementara[custom_code_after]\"]' ).val())")
            eval("code_editor_custom_code_after_route_sementara.clearSelection()") 
            dataOld = {}
        }

        function removeRouteFromTable(i) {
            storage_parameter.remove('route.'+i)
            build_route_tabel(storage_parameter.get('route'))
        }

        function editRouteFromTable(i) {
            
            $( "#tambah_route" ).addClass('d-none')
            $( "#edit_route" ).removeClass('d-none')
            $( "#edit_route" ).attr("onclick","edit_route_table("+i+")")
                        
            fill_route_sementara(storage_parameter.get('route.'+i))            
            
            $('html, body').animate({
                scrollTop: $( "[name='route_sementara[prefix]']" ).offset().top
            }, 1000, function() {
                $( "[name='route_sementara[prefix]']" ).focus();
            });
        }

        function edit_route_table(i) {
            $( "#edit_route" ).addClass('d-none')
            $( "#tambah_route" ).removeClass('d-none')

            objModul = $('#modul').serializeJSON()
            route_sementara = objModul['route_sementara']

            storage_parameter.update('route.'+i,route_sementara)
            build_route_tabel(storage_parameter.get('route'))

            clear_route_sementara()
        }

        function moveRouteFromTable(old_index, new_index) {
            old_data = storage_parameter.get('route.'+old_index)
            new_data = storage_parameter.get('route.'+new_index)
            
            storage_parameter.update('route.'+old_index,new_data)
            storage_parameter.update('route.'+new_index,old_data)

            build_route_tabel(storage_parameter.get('route'));
        }

        function copyRouteFromTable(index) {
            clone = JSON.parse(JSON.stringify( storage_parameter.get('route.'+index) ))
            storage_parameter.add('route',clone)
            length_route = Object.keys(storage_parameter.get('route')).length
            new_name = clone.name +' (copy of ' + clone.name + ')'
            storage_parameter.update('route.'+(length_route-1)+'.name',new_name)
            
            build_route_tabel(storage_parameter.get('route'))
            route_table.page( 'last' ).draw( 'page' );
        }
        // khusus table route
    </script>    

    <script>
        // khusus tabel middleware        
        function build_tabel_middleware(json) {
            
            tabel_middleware = ''

            tabel_middleware    +=   '<table id="table_middleware" class="table table-striped table-bordered" style="width:100%">'
            tabel_middleware    +=   '<thead>'
                tabel_middleware    +=   '<tr>'
                tabel_middleware    +=   '<th scope="col">#</th>'
                tabel_middleware    +=   '<th scope="col"></th>'
                tabel_middleware    +=   '<th scope="col">Nama</th>'
                tabel_middleware    +=   '<th scope="col">Param</th>'
                tabel_middleware    +=   '</tr>'
            tabel_middleware    +=   '</thead>'
            tabel_middleware    +=   '<tbody>'

            $.each(json,function(k,v) {
                
                tabel_middleware    +=  '<tr>'
                    tabel_middleware    +=  '<th scope="row">'+(k+1)+'</th>'
                    tabel_middleware    +=  '<td>'
                        tabel_middleware    +=  '<div class="form-check form-check-inline with-check">'
                            tabel_middleware    +=  '<input class="form-check-input" type="checkbox" name="route_sementara[middleware][]" value="'+v+'">'
                        tabel_middleware    +=  '</div>'
                    tabel_middleware    +=  '</td>'
                    tabel_middleware    +=  '<td>'+v+'</td>'
                    tabel_middleware    +=  '<td>'                        
                        tabel_middleware    +=  '<input name="route_sementara[middleware_parameter]['+v+']" type="text" class="form-control" disabled>'
                    tabel_middleware    +=  '</td>'
                tabel_middleware    +=  '</tr>'
    
            })

                tabel_middleware    +=  '</tbody>'
            tabel_middleware    +=  '</table>'

            $( '.route_middleware_route_sementara' ).html(tabel_middleware)

            $( "[name^=\"route_sementara[middleware]\"]" ).switcher();

            $( "[name^=\"route_sementara[middleware]\"]" ).change(function(){                
                name = "route_sementara[middleware_parameter]["+$(this).val()+"]"
                if( $(this).is(':checked') ) {
                    $( "[name='"+name+"']" ).prop('disabled',false)
                }else {
                    $( "[name='"+name+"']" ).prop('disabled',true)
                }
            })
        }
    </script>

    <script>        

        // $( document ).ready(function() {
                        
        //     $.ajax({
        //         type: 'GET',
        //         url: '{{url('/')}}/vendor/khancode/ace_autocomplete.json',
        //         dataType: 'json',
        //         success: function(json) {
        //             console.log(json)
        //             var myList = json
        //             var myCompleter = {
        //                 identifierRegexps: [/[^\s]+/],
        //                 getCompletions: function(editor, session, pos, prefix, callback) {
        //                     console.info("myCompleter prefix:", prefix);
        //                     callback(
        //                         null,
        //                         myList.filter(entry=>{
        //                             return entry.includes(prefix);
        //                         }).map(entry=>{
        //                             return {
        //                                 value: entry
        //                             };
        //                         })
        //                     );
        //                 }
        //             }
        //             langTools.addCompleter(myCompleter);
        //         },
        //         error: function(e) {
        //             alert('autocomplete error')
        //         }
        //     });

        // });
        
    </script>

    <script>
        // khusus table relasi    
        
        storage_parameter.add('relation');

        function build_relation_tabel(data) {

            tableHtml = '<table id="example_relation" class="table table-striped table-bordered" style="width:100%">'
                tableHtml += '<thead>'
                    tableHtml += '<tr>'
                        tableHtml += '<th>#</th>'
                        tableHtml += '<th>Name</th>'
                        tableHtml += '<th>Type</th>'
                        tableHtml += '<th>Action</th>'
                    tableHtml += '</tr>'
                tableHtml += '</thead>'
                tableHtml += '<tbody>'                

                iDataTable=0                
                $.each(data, function( index_relation, value_relation ) {
                    index_relation = parseInt(index_relation)
                    
                    tableHtml += '<tr>'
                        tableHtml += '<td>'
                            tableHtml += (iDataTable+1)
                        tableHtml += '</td>'
                        tableHtml += '<td>'
                            tableHtml += value_relation['name']
                        tableHtml += '</td>'
                        tableHtml += '<td>'
                            tableHtml += v_process
                        tableHtml += '</td>'
                        tableHtml += '<td id="route_'+iDataTable+'">'                        
                            tableHtml += '<button data-placement="top" data-toggle="tooltip" title="Duplicate" type="button" class="btn btn-light float-right btn-sm" onclick="copyRelationFromTable(\''+index_relation+'\')" style="margin-right: 15px;">'
                            tableHtml += '<svg x="0px" y="0px" width="15" height="15" viewBox="0 0 24 24" style=" fill:#000000;"><path d="M 4 2 C 2.895 2 2 2.895 2 4 L 2 18 L 4 18 L 4 4 L 18 4 L 18 2 L 4 2 z M 8 6 C 6.895 6 6 6.895 6 8 L 6 20 C 6 21.105 6.895 22 8 22 L 20 22 C 21.105 22 22 21.105 22 20 L 22 8 C 22 6.895 21.105 6 20 6 L 8 6 z M 8 8 L 20 8 L 20 20 L 8 20 L 8 8 z"></path></svg>'
                            tableHtml += '</button>'
                            tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editRelationFromTable(\''+index_relation+'\')" style="margin-right: 15px;">'
                            tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
                            tableHtml += '</button>'
                            tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeRelationFromTable(\''+index_relation+'\')" style="margin-right: 15px;">'
                            tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
                            tableHtml += '</button>'
                            tableHtml += '<button type="button" class="btn btn-info float-right btn-sm" onclick="moveRelationFromTable('+(index_relation+1)+', '+index_relation+')" style="margin-right: 15px;">'
                            tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.5 0l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z" transform="translate(0 1)"></path></svg>'
                            tableHtml += '</button>'
                            if(iDataTable!=0){
                                tableHtml += '<button type="button" class="btn btn-success float-right btn-sm" onclick="moveRelationFromTable('+(index_relation-1)+', '+index_relation+')" style="margin-right: 15px;">'
                                tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M4 0l-4 4 1.5 1.5 2.5-2.5 2.5 2.5 1.5-1.5-4-4z" transform="translate(0 1)"></path></svg>'
                                tableHtml += '</button>'
                            }
                        tableHtml += '</td>'
                    tableHtml += '</tr>'
                    iDataTable++
                })

                tableHtml += '<tbody>'
            tableHtml += '</table>'

            $( "relation_table" ).html(tableHtml);
            $( "#relation_"+(iDataTable-1)+" .btn-info" ).remove()
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            })

            page_now = 0;
            page_length = 5;
            if(typeof relation_table != 'undefined') {
                page_now = relation_table.page.info().page
                page_length = relation_table.page.info().length
            }

            relation_table = $( "#example_relation" ).DataTable({
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
            });
            
            relation_table.page.len( page_length ).page( page_now ).draw( 'page' );

            if(page_now > (relation_table.page.info().pages-1)) {                
                page_now--
                relation_table.page( page_now ).draw( 'page' );
            }            
        }

        function tambah_relation_table() {
            storage_parameter.add('relation',$('#modul').serializeJSON().relation.relation_sementara)
            build_relation_tabel(storage_parameter.get('relation'))
            relation_table.page( 'last' ).draw( 'page' );

            clear_relation_sementara()
        } 

        function moveRelationFromTable(old_index, new_index) {
            old_data = storage_parameter.get('relation.'+old_index)
            new_data = storage_parameter.get('relation.'+new_index)
            
            storage_parameter.update('relation.'+old_index,new_data)
            storage_parameter.update('relation.'+new_index,old_data)

            build_relation_tabel(storage_parameter.get('relation'));
        }

        function copyRelationFromTable(index) {
            clone = JSON.parse(JSON.stringify( storage_parameter.get('relation.'+index) ))
            storage_parameter.add('relation',clone)
            length_relation = Object.keys(storage_parameter.get('relation')).length
            new_name = clone.name +' (copy of ' + clone.name + ')'
            storage_parameter.update('relation.'+(length_relation-1)+'.name',new_name)
            
            build_relation_tabel(storage_parameter.get('relation'))
            relation_table.page( 'last' ).draw( 'page' );
        }

        function removeRelationFromTable(i) {
            storage_parameter.remove('relation.'+i)
            build_relation_tabel(storage_parameter.get('relation'))
        }

        function fill_relation_sementara(data) {
            $( '.relasi_type_relation_sementara' ).val(data.type)
            ubah_type_relasi($( '.relasi_type_relation_sementara' ).get(0),'relation_sementara', 0)
            fill_kolom_relasi('relation_sementara',data,0)
        }

        function editRelationFromTable(i) {
            
            $( "#tambah_relation" ).addClass('d-none')
            $( "#edit_relation" ).removeClass('d-none')
            $( "#edit_relation" ).attr("onclick","edit_relation_table("+i+")")
                        
            fill_relation_sementara(storage_parameter.get('relation.'+i))            
            
            $('html, body').animate({
                scrollTop: $( "#relasi-tab" ).offset().top
            }, 1000, function() {
                $( "#relasi-tab" ).focus();
            });
        }

        function clear_relation_sementara() {
            $( '.relasi_type_relation_sementara' ).val('belongs_to')
            ubah_type_relasi($( '.relasi_type_relation_sementara' ).get(0),'relation_sementara', 0)            
        }

        function edit_relation_table(i) {
            $( "#edit_relation" ).addClass('d-none')
            $( "#tambah_relation" ).removeClass('d-none')

            objModul = $('#modul').serializeJSON()
            relation_sementara = objModul['relation']['relation_sementara']

            storage_parameter.update('relation.'+i,relation_sementara)
            build_relation_tabel(storage_parameter.get('relation'))

            clear_relation_sementara()
        }
    </script>
@endsection