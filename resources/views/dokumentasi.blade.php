@extends('khancode::base')

@section('title', 'Dokumentasi')

@section('content')
<style>
.tree-block {
    background: rgba(86,61,124,.15);
    padding: 10px;
    border-radius: 5px;
    overflow: scroll;
    /* height: 100%; */
}
.tree-detail {
    padding: 0px;
    border-radius: 5px;
    /* height: 100%; */
}
.select-method {
    border-radius: .35rem 0 0 .35rem;
    height: calc(1.5em + .75rem - 2px);
    width: 100%;
    border: 1px solid #d1d3e2;
    color: #6e707e;
    padding: 0.10rem .75rem;
}
.input-group>.prepend-method {
    flex: 0 0 15%;
}
.input-group .input-group-text {
    width: 100%;
}
.dokumentasi button {
    height: calc(1.5em + .75rem - 2px);
}
.input-url {
    border-radius:  0 .35rem .35rem 0 !important;
}
.tab-content {
    padding:10px;
    background: white;
}
.nav-link {
    padding: 0.2rem 0.7rem 0.2rem 0.7rem;
}
.tab-auto .fa-times {    
    margin-right: -5px;    
    cursor:pointer;
}
#tab-top .nav-item .nav-link {
    border-color: #dddfeb #dddfeb #fff;
}
#top-tab-plus {
    cursor:pointer;
    margin-left: 5px;
}
.atas a {
    white-space: nowrap;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}
/* .atas i {
    display: block;
    margin-top: 100px;
    margin-left: 56px;
} */
#addTabChrome {
    font-weight: bold;
    font-size: large;
    margin-top: -6px;
    cursor:pointer
}
</style>
<style>
.icon-get {
    margin-left:20px !important;
}
.icon-get:before {
    content:'GET';
    color: #3ac23a;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.icon-post {
    margin-left:20px !important;
}
.icon-post:before {
    content:'POST';
    color: orange;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.icon-put {
    margin-left:20px !important;
}
.icon-put:before {
    content:'PUT';
    color: purple;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.icon-delete {
    margin-left:20px !important;
}
.icon-delete:before {
    content:'DEL';
    color: red;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.changed {
    flex-grow: 0;
    flex-shrink: 0;
    position: relative;    
    border-radius: 50%;
    background-image: none !important;
    background: #d94f4f;
    width: 12px !important;
    height: 12px !important;
}
.desc-textarea {
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
    border-radius: 0px;
}
.addtab {
    width: 50px !important;
}
table .fa-close {
    margin-top: 8px;
    cursor: pointer;
}
.ace_editor {
    min-height:120px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<link href="{{url('/')}}/vendor/khancode/css/chrome-tabs.css" rel="stylesheet">

<div class="col-md-2 tree-block">
    <div id="jstree"></div>
</div>

<div class="col-md-10 tree-detail d-inline-block dokumentasi">

    <div class="chrome-tabs col-md-12" style="--tab-content-margin: 9px">
        <div class="chrome-tabs-content">                        
        </div>
        <div class="chrome-tabs-bottom-bar"></div>
        <!-- Styles to prevent flash after JS initialization -->
        <style>
        .chrome-tabs .chrome-tab {
            width: 258px
        }

        .chrome-tabs .chrome-tab:nth-child(1) {
            transform: translate3d(0px, 0, 0)
        }

        .chrome-tabs .chrome-tab:nth-child(2) {
            transform: translate3d(239px, 0, 0)
        }
        </style>
    </div>

    <div class="tab-content" id="myTabTopContent">
        <div class="atas tab-pane fade active show" id="top-tab-content-default" role="tabpanel" aria-labelledby="top-tab">
            <div class="d-flex justify-content-center rotate-n-15" style="padding-top: 100px;padding-bottom: 100px;">
                <i class="fas fa-laugh-wink fa-10x" style="color:#c2c0c0a8"></i>
            </div>
        </div>
    </div>    
</div>   




<div class="mock-browser-content d-none">
    <div class="buttons">
        <button data-theme-toggle>Toggle dark theme</button>
        <button data-add-tab>Add new tab</button>
        <button data-add-background-tab>Add tab in the background</button>
        <button data-remove-tab>Remove active tab</button>
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
            Terdapat perubahan data, 
            Yakin Akan Keluar ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" onclick="closeTabChrome()">Ya</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="env_modal" tabindex="-1" role="dialog" aria-labelledby="env_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="env_modal">ENVIRONMENTS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-env">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Key</th>
                        <th scope="col">Value</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"></th>
                        <td><input type="text" name="env_params[0][key]" placeholder="key" class="input form-control" onkeyup="addListEnvParams(this,0)"></td>
                        <td><textarea type="text" name="env_params[0][value]" placeholder="value" class="input form-control" rows="1"></textarea></td>
                        <td><input type="text" name="env_params[0][desc]" placeholder="description" class="input form-control"></td>
                    </tr>
                </tbody>
            </table>
            <form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            <button type="button" class="btn btn-primary" onclick="simpanApiEnv()">Simpan</button>
        </div>
        </div>
    </div>
</div>


@endsection

@section('script_add_on')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>    

    <script>
        $( document ).ready(function() {

            // set variable
            getEnv()
            // untuk refresh
            // $("#jstree").jstree(true).refresh_node(1);

            $( ".chrome-tabs-content" ).append(htmlAddButton)

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            $('#jstree').on("changed.jstree", function (e, data) {
                // console.log(data.selected,data);
                if(data.node.type == "folder") {
                    return
                }

                dataOld = storage_parameter.get('list_tab.'+data.node.id)                
                if( typeof(dataOld) != 'undefined' ) {
                    dataOld=dataOld[0]
                    if( $( "#form-"+dataOld.id ).length == 0 ) {
                        chromeTabs.addTab({
                            title: dataOld.text,
                            favicon: dataOld.icon_tab,
                            dataAjax: dataOld
                        },tab)                        
                    }else {
                        datatab = $( "#form-"+dataOld.id ).parent().attr('data-tab')
                        chromeTabs.setCurrentTab( $( "[idTab='"+datatab+"']" ).get(0) )
                    }
                }else {                
                    $.ajax({
                        url: '{{url('/')}}/endpoint/'+data.node.id,
                        type: "GET",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (data) {                        
                            if( $( "#form-"+data.id ).length == 0 ) {
                                chromeTabs.addTab({
                                    title: data.text,
                                    favicon: data.icon_tab,
                                    dataAjax: data
                                },tab)
                                storage_parameter.add('list_tab.'+data.id,data)
                            }else {
                                datatab = $( "#form-"+data.id ).parent().attr('data-tab')
                                chromeTabs.setCurrentTab( $( "[idTab='"+datatab+"']" ).get(0) )
                            }
                        },
                        error: function (data) {
                            alert(' data tidak ada ')
                        }
                    });
                }

            });

            $('#jstree').jstree({ 
                'core' : {
                    "data" : {
                        'url' : function (node) {
                            return node.id === '#' ?
                                "{{url('/').'/listEndpoint'}}" :
                                "{{url('/').'/listEndpointChildren/'}}"+node.id;
                        },
                    },
                    "check_callback" : true
                },
                "plugins" : [ "dnd", "wholerow", "types", "search", "json_data" ],                
                'types': {
                    "root" : { // the root node can have only "branch" children
                        "valid_children" : [
                                "folder",
                                "file-get",
                                "file-post",
                                "file-put",
                                "file-delete"
                            ],
                        'icon': "fa fa-folder"
                    },
                    "folder" : { // any "branch" can only have "leaf" children
                        "valid_children" :  [
                                "folder",
                                "file-get",
                                "file-post",
                                "file-put",
                                "file-delete"
                            ],
                        'icon': "fa fa-folder"
                    },
                    "file-get" : { // "leaf" typed nodes can not have any children
                        "valid_children" : [],
                        'icon': "icon-get"
                    },
                    "file-post" : { // "leaf" typed nodes can not have any children
                        "valid_children" : [],
                        'icon': "icon-post"
                    },
                    "file-put" : { // "leaf" typed nodes can not have any children
                        "valid_children" : [],
                        'icon': "icon-put"
                    },
                    "file-delete" : { // "leaf" typed nodes can not have any children
                        "valid_children" : [],
                        'icon': "icon-delete"
                    }

                }
            }).bind("move_node.jstree", function (e, data) {
                // data.rslt.o is a list of objects that were moved
                // Inspect data using your fav dev tools to see what the properties are
                // ref = $('#jstree').jstree(true)
                // v = $('#jstree').jstree(true).get_json('#', {flat:true})
                // mytext = JSON.stringify(v);

                // rename
                // $("#demo1").jstree('rename_node', node , text );

                //position index point in group                
                newPostionIndex = data.position
                parent = data.parent
                id = data.node.id
                console.log(newPostionIndex,parent,id,data)
            });
            
        });
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
        tab = 0
        var idTabChanged

        function deleteModal(idTabToChanged){            
            $( "#deleteModal" ).modal('show')
            window.idTabChanged = idTabToChanged
        }

        function closeTabChrome() {
            $( "#deleteModal" ).modal('hide')
            chromeTabs.removeTab( $( "[idTab='"+window.idTabChanged+"']" ).get(0), true )
        }

        function addListQueryParams(e,idFTab) {            
            if( $(e).parent().parent().next().length == 0) {  
                idFTab++
                htmlTr = ''
                htmlTr +=   "<tr>"
                    htmlTr +=   "<th scope='row'></th>"
                    htmlTr +=   '<td><input type="text" name="query_params['+idFTab+'][key]" placeholder="key" class="input form-control" onkeyup="addListQueryParams(this,'+idFTab+')"></td>'
                    htmlTr +=   '<td><input type="text" name="query_params['+idFTab+'][value]" placeholder="value" class="input form-control"</td>'
                    htmlTr +=   '<td><input type="text" name="query_params['+idFTab+'][desc]" placeholder="description" class="input form-control"></td>'
                htmlTr +=   "</tr>"

                $(e).parent().parent().find('th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')
                $(e).parent().parent().parent().append( htmlTr )
            }
        }

        function addListHeader(e,idFTab) {
            if( $(e).parent().parent().next().length == 0) {  
                idFTab++
                htmlTr = ''
                htmlTr +=   "<tr>"
                    htmlTr +=   "<th scope='row'></th>"
                    htmlTr +=   '<td><input type="text" name="headers['+idFTab+'][key]" placeholder="key" class="input form-control" onkeyup="addListHeader(this,'+idFTab+')"></td>'
                    htmlTr +=   '<td><input type="text" name="headers['+idFTab+'][value]" placeholder="value" class="input form-control"></td>'
                    htmlTr +=   '<td><input type="text" name="headers['+idFTab+'][desc]" placeholder="description" class="input form-control"></td>'
                htmlTr +=   "</tr>"

                $(e).parent().parent().find('th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')

                $(e).parent().parent().parent().append( htmlTr )
            }
        }

        function addListBody(e,idFTab) {
            if( $(e).parent().parent().next().length == 0) {  
                idFTab++
                htmlTr = ''
                htmlTr += '<tr>'
                    htmlTr += '<th scope="row"></th>'
                    htmlTr += '<td><input type="text" name="bodies['+idFTab+'][key]" placeholder="key" class="input form-control" onkeyup="addListBody(this,'+idFTab+');"></td>'
                    htmlTr += '<td>'
                        htmlTr += '<select class="form-control" name="bodies['+idFTab+'][type]" onchange="selectTypeBody(this,'+idFTab+');">'
                            htmlTr += '<option value="text" selected="">Text</option>'
                            htmlTr += '<option value="file">File</option>'
                        htmlTr += '</select>'
                    htmlTr += '</td>'
                    htmlTr += '<td><input type="text" name="bodies['+idFTab+'][value]" placeholder="value" class="input form-control"></td>'                                                
                    htmlTr += '<td><input type="text" name="bodies['+idFTab+'][desc]" placeholder="description" class="input form-control"></td>'
                htmlTr += '</tr>'

                $(e).parent().parent().find('th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')
                $(e).parent().parent().parent().append( htmlTr )
            }
        }

        function selectTypeBody(e,idFTab) {
            if( $(e).val() == 'text' ) {
                htmlInput = '<input type="text" name="bodies['+idFTab+'][value]" class="input form-control">';

                $(e).parent().next().html( htmlInput )
            }else {
                htmlInput = '<input type="file" name="bodies['+idFTab+'][value]" class="form-control-file">';

                $(e).parent().next().html( htmlInput )
            }
        }

        function closeCols(e) {
            $(e).parent().parent().remove()
        }

        function addListEnvParams(e,idFTab) {
            if( $(e).parent().parent().next().length == 0) {  
                idFTab++
                htmlTr = ''
                htmlTr += '<tr>'
                    htmlTr += '<th scope="row"></th>'
                    htmlTr += '<td><input type="text" name="env_params['+idFTab+'][key]" placeholder="key" class="input form-control" onkeyup="addListEnvParams(this,'+idFTab+');"></td>'
                    htmlTr += '<td><texarea type="text" name="env_params['+idFTab+'][value]" placeholder="value" class="input form-control" rows="1"></textarea></td>'
                    htmlTr += '<td><input type="text" name="env_params['+idFTab+'][desc]" placeholder="description" class="input form-control"></td>'
                htmlTr += '</tr>'

                $(e).parent().parent().find('th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')
                $(e).parent().parent().parent().append( htmlTr )
            }
        }

        function addTabChrome({ name = 'Untitled Request', id = 0, url = '', method = 'get', deskripsi = '' } = {},idTab) {            
            tab++

            htmlTabContent = ''
            htmlTabContent += '<div class="atas tab-pane fade col-md" id="top-tab-content-'+tab+'" data-tab="'+(idTab+1)+'" role="tabpanel" aria-labelledby="top-tab">'
                htmlTabContent += '<form id="form-'+id+'" enctype="multipart/form-data">'
                htmlTabContent += '<div class="row">'
                    htmlTabContent += '<div class="col-md-10">'
                        htmlTabContent += '<h5>'+name+'</h5>'
                    htmlTabContent += '</div>'
                    htmlTabContent += '<div class="col-md-2 d-flex">'
                        htmlTabContent += '<p class="ml-auto"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#env_modal">Environment</button></p>'
                    htmlTabContent += '</div>'
                    htmlTabContent += '<div class="col-md-12">'
                        htmlTabContent += '<textarea name="data[description]" class="form-control mb-3 desc-textarea" rows="1" placeholder="deskripsi">'+deskripsi+'</textarea>'
                    htmlTabContent += '</div>'
                htmlTabContent += '</div>'
                htmlTabContent += '<div class="row">'
                    htmlTabContent += '<div class="col-md-12">'
                        htmlTabContent += '<div class="input-group mb-3">'
                            htmlTabContent += '<div class="input-group-prepend prepend-method">'
                                htmlTabContent += '<select class="select-method" name="method">'
                                    htmlTabContent += '<option value="get" selected>GET</option>'
                                    htmlTabContent += '<option value="post">POST</option>'
                                    htmlTabContent += '<option value="put">PUT</option>'
                                    htmlTabContent += '<option value="delete">DELETE</option>'
                                htmlTabContent += '</select>'
                            htmlTabContent += '</div>'
                            htmlTabContent += '<input type="hidden" name="id" value="'+id+'">'
                            htmlTabContent += '<input type="text" class="input-url form-control" aria-label="Text input with dropdown button" value="'+url+'" name="url">'
                            htmlTabContent += '<button type="button" class="btn btn-primary" style="margin-left:10px;" onclick="submitForm(this,'+tab+')">Send</button>                '
                            htmlTabContent += '<div class="dropdown">'
                                htmlTabContent += '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left:10px;">'
                                    htmlTabContent += 'Save'
                                htmlTabContent += '</button>'
                                htmlTabContent += '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
                                    htmlTabContent += '<a class="dropdown-item" href="#">Save As</a>                        '
                                htmlTabContent += '</div>'
                            htmlTabContent += '</div>                '
                        htmlTabContent += '</div>'
                        htmlTabContent += '<ul class="nav nav-tabs" id="myTab" role="tablist">'
                            htmlTabContent += '<li class="nav-item">'
                                htmlTabContent += '<a class="nav-link active" data-toggle="tab" href="#query_params_'+tab+'" role="tab" aria-controls="query_params_'+tab+'" aria-selected="true">Params</a>'
                            htmlTabContent += '</li>'
                            htmlTabContent += '<li class="nav-item">'
                                htmlTabContent += '<a class="nav-link" data-toggle="tab" href="#header_'+tab+'" role="tab" aria-controls="header_'+tab+'" aria-selected="false">Headers</a>'
                            htmlTabContent += '</li>'
                            htmlTabContent += '<li class="nav-item">'
                                htmlTabContent += '<a class="nav-link" data-toggle="tab" href="#body_'+tab+'" role="tab" aria-controls="body_'+tab+'" aria-selected="false">Body</a>'
                            htmlTabContent += '</li>'
                        htmlTabContent += '</ul>'
                        htmlTabContent += '<div class="tab-content">                  '
                            htmlTabContent += '<div class="tab-pane fade show active" id="query_params_'+tab+'" role="tabpanel" aria-labelledby="query_params_'+tab+'-tab">'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<h6>Query Params</h6>'
                                htmlTabContent += '</div>'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<table class="table">'
                                        htmlTabContent += '<thead>'
                                            htmlTabContent += '<tr>'
                                                htmlTabContent += '<th scope="col">#</th>'
                                                htmlTabContent += '<th scope="col">Key</th>'
                                                htmlTabContent += '<th scope="col">Value</th>'
                                                htmlTabContent += '<th scope="col">Description</th>'
                                            htmlTabContent += '</tr>'
                                        htmlTabContent += '</thead>'
                                        htmlTabContent += '<tbody>'
                                            htmlTabContent += '<tr>'
                                                htmlTabContent += '<th scope="row"></th>'
                                                htmlTabContent += '<td><input type="text" name="query_params[0][key]" placeholder="key" class="input form-control" onkeyup="addListQueryParams(this,'+idTab+')"></td>'
                                                htmlTabContent += '<td><input type="text" name="query_params[0][value]" placeholder="value" class="input form-control"></td>'
                                                htmlTabContent += '<td><input type="text" name="query_params[0][desc]" placeholder="description" class="input form-control"></td>'
                                            htmlTabContent += '</tr>'                                            
                                        htmlTabContent += '</tbody>'
                                    htmlTabContent += '</table>'
                                htmlTabContent += '</div>'
                            htmlTabContent += '</div>'
                            htmlTabContent += '<div class="tab-pane fade" id="header_'+tab+'" role="tabpanel" aria-labelledby="header_'+tab+'-tab">'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<h6>Headers</h6>'
                                htmlTabContent += '</div>'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<table class="table">'
                                        htmlTabContent += '<thead>'
                                            htmlTabContent += '<tr>'
                                                htmlTabContent += '<th scope="col">#</th>'
                                                htmlTabContent += '<th scope="col">Key</th>'
                                                htmlTabContent += '<th scope="col">Value</th>'
                                                htmlTabContent += '<th scope="col">Description</th>'
                                            htmlTabContent += '</tr>'
                                        htmlTabContent += '</thead>'
                                        htmlTabContent += '<tbody>'
                                            htmlTabContent += '<tr>'
                                                htmlTabContent += '<th scope="row"></th>'
                                                htmlTabContent += '<td><input type="text" name="headers[0][key]" placeholder="key" class="input form-control" onkeyup="addListHeader(this,'+idTab+');"></td>'
                                                htmlTabContent += '<td><input type="text" name="headers[0][value]" placeholder="value" class="input form-control"></td>'
                                                htmlTabContent += '<td><input type="text" name="headers[0][desc]" placeholder="description" class="input form-control"></td>'
                                            htmlTabContent += '</tr>'                                            
                                        htmlTabContent += '</tbody>'
                                    htmlTabContent += '</table>'
                                htmlTabContent += '</div>'
                            htmlTabContent += '</div>'
                            htmlTabContent += '<div class="tab-pane fade" id="body_'+tab+'" role="tabpanel" aria-labelledby="body_'+tab+'-tab">'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<h6>Body Params</h6>'
                                htmlTabContent += '</div>'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<table class="table">'
                                        htmlTabContent += '<thead>'
                                            htmlTabContent += '<tr>'
                                                htmlTabContent += '<th scope="col">#</th>'
                                                htmlTabContent += '<th scope="col">Key</th>'
                                                htmlTabContent += '<th scope="col">Type</th>'
                                                htmlTabContent += '<th scope="col" width="30%">Value</th>'
                                                htmlTabContent += '<th scope="col">Description</th>'
                                            htmlTabContent += '</tr>'
                                        htmlTabContent += '</thead>'
                                        htmlTabContent += '<tbody>'
                                            htmlTabContent += '<tr>'
                                                htmlTabContent += '<th scope="row"></th>'
                                                htmlTabContent += '<td><input type="text" name="bodies[0][key]" placeholder="key" class="input form-control" onkeyup="addListBody(this,'+idTab+');"></td>'
                                                htmlTabContent += '<td>'
                                                    htmlTabContent += '<select class="form-control" name="bodies[0][type]" onchange="selectTypeBody(this,'+idTab+');">'
                                                        htmlTabContent += '<option value="text" selected="">Text</option>'
                                                        htmlTabContent += '<option value="file">File</option>'
                                                    htmlTabContent += '</select>'
                                                htmlTabContent += '</td>'
                                                htmlTabContent += '<td><input type="text" name="bodies[0][value]" placeholder="value" class="input form-control"></td>'                                                
                                                htmlTabContent += '<td><input type="text" name="bodies[0][desc]" placeholder="description" class="input form-control"></td>'
                                            htmlTabContent += '</tr>'
                                        htmlTabContent += '</tbody>'
                                    htmlTabContent += '</table>'
                                htmlTabContent += '</div>'
                            htmlTabContent += '</div>'
                        htmlTabContent += '</div>            '
                    htmlTabContent += '</div>'
                htmlTabContent += '</div>'
                htmlTabContent += '<ul class="nav nav-tabs" id="tabResponse'+tab+'" role="tablist">'
                    htmlTabContent += '<li class="nav-item">'
                        htmlTabContent += '<a class="nav-link active" data-toggle="tab" href="#response_'+tab+'" role="tab" aria-controls="response_'+tab+'" aria-selected="true">Response</a>'
                    htmlTabContent += '</li>'
                htmlTabContent += '</ul>'
                htmlTabContent += '<div class="tab-content">                  '
                    htmlTabContent += '<div class="tab-pane fade show active" id="response_'+tab+'" role="tabpanel" aria-labelledby="response_'+tab+'-tab">'
                        htmlTabContent += '<div class="col-md text-justify">'
                        htmlTabContent += '<p>Belum ada response</p>'                        
                        htmlTabContent += '</div>'
                    htmlTabContent += '</div>'
                htmlTabContent += '</div>'
                htmlTabContent += '</form>'
            htmlTabContent += '</div>'
            
            $( "#myTabTopContent" ).append(htmlTabContent)
            openTab(tab)
            storage_parameter.add('tab',tab)
            $('[data-toggle="tooltip"]').tooltip()
            $("form :input").change(function() {
                $(this).closest('form').data('changed', true);
                idTabFormChanged = $(this).closest('form').parent().data('tab');
                element = $( "[idTab='"+idTabFormChanged+"']" ).find('.chrome-tab-close')
                // element.removeClass('chrome-tab-close')
                element.addClass( "changed" )
                element.attr("onclick","deleteModal("+idTabFormChanged+")")
                $( "[idTab='"+idTabFormChanged+"']" ).data('changed',true)
                if( $(this).hasClass('select-method') ) {
                    changeIcon(this,idTabFormChanged)
                }
            });

            // update method            
            $( '#form-'+id ).find('[name*=method]').val(method).change()

        }

        function changeIcon(e,tab) {            
            element = $( "[idTab='"+tab+"']" ).find('.chrome-tab-favicon')
            element.removeClass()
            element.addClass('chrome-tab-favicon').addClass('icon-'+$(e).val())
        }

        function openTab(id) {
            $( '.tab-content .atas' ).each(function(e){                
                $(this).removeClass('show')
                $(this).hide()
                $(this).removeClass('active')
            })                        
            $( '#top-tab-content-'+id ).fadeIn(0.1)
            $( '#top-tab-content-'+id ).addClass('show')
            $( '#top-tab-content-'+id ).addClass('active')

            return true
        }

        function closeTopTab(id) {            
            dataTab = storage_parameter.get('tab')            
            if(ObjectLength(dataTab)==1) {
                $( '#top-tab-content-default' ).fadeIn(0.1)
                $( '#top-tab-content-default' ).addClass('show')
                $( '#top-tab-content-default' ).addClass('active')                                
            }
            $.each(dataTab, function(index, value) {
                if(value == id) {                    
                    storage_parameter.remove('tab.'+index)              
                    $( "#top-tab-content-"+id ).remove()                  
                }
            });            
        }

        function ObjectLength( object ) {
            var length = 0;
            for( var key in object ) {
                if( object.hasOwnProperty(key) ) {
                    ++length;
                }
            }
            return length;
        };
    </script>   

    <script src="https://unpkg.com/draggabilly@2.2.0/dist/draggabilly.pkgd.min.js"></script>
    <script src="{{url('/')}}/vendor/khancode/js/chrome-tabs.js"></script>    

    <script>
        htmlAddButton = ''
        htmlAddButton += '<div class="chrome-tab addtab" onclick="chromeTabs.addTab({title: \'New Tab\',favicon: \'icon-get\'})">'
            htmlAddButton += '<div class="chrome-tab-dividers"></div>'
            htmlAddButton += '<div class="chrome-tab-background">'
            htmlAddButton += '</div>'
            htmlAddButton += '<div class="chrome-tab-content">'
                htmlAddButton += '<span id="addTabChrome">+</span>'
            htmlAddButton += '</div>'
        htmlAddButton += '</div>'        
        
        var el = document.querySelector('.chrome-tabs')
        var chromeTabs = new ChromeTabs()

        chromeTabs.init(el)

        el.addEventListener('activeTabChange', ({ detail }) => {            
            openTab( $(detail.tabEl).attr('idTab') )
        })        
        el.addEventListener('tabAdd', ({ detail }) => {
            dataAjax = {}
            if( detail.tabProperties.dataAjax ) {
                dataAjax = {
                    'id':detail.tabProperties.dataAjax.id,
                    'name':detail.tabProperties.dataAjax.text,
                    'url':detail.tabProperties.dataAjax.url,
                    'method':detail.tabProperties.dataAjax.method
                }
            }
            addTabChrome(dataAjax,tab),
            $( ".addtab" ).last().remove(),            
            $( ".chrome-tab" ).last().attr('idTab',tab),
            $( ".chrome-tab" ).last().after(htmlAddButton),
            $( ".chrome-tab" ).last().css("cursor: pointer")            
        })      
        el.addEventListener('tabRemove', ({ detail }) => {
            closeTopTab( $(detail.tabEl).attr('idTab') )
        })

        document.querySelector('button[data-add-tab]').addEventListener('click', _ => {
            chromeTabs.addTab({
                title: 'New Tab',
                favicon: 'icon-get'
            })
        })

        document.querySelector('button[data-add-background-tab]').addEventListener('click', _ => {
            chromeTabs.addTab({
            title: 'New Tab',
            favicon: false
            }, {
            background: true
            })
        })

        document.querySelector('button[data-remove-tab]').addEventListener('click', _ => {
            chromeTabs.removeTab(chromeTabs.activeTabEl)
        })

        document.querySelector('button[data-theme-toggle]').addEventListener('click', _ => {
            if (el.classList.contains('chrome-tabs-dark-theme')) {
            document.documentElement.classList.remove('dark-theme')
            el.classList.remove('chrome-tabs-dark-theme')
            } else {
            document.documentElement.classList.add('dark-theme')
            el.classList.add('chrome-tabs-dark-theme')
            }
        })

        window.addEventListener('keydown', (event) => {
            if (event.ctrlKey && event.key === 't') {
            chromeTabs.addTab({
                title: 'New Tab',
                favicon: false
            })
            }
        })
    </script>

    <script>
        baseUrl = "{{url('/')}}"
    </script>
    <script src="<?php echo URL::to('/vendor/khancode/js/src/ace.js');?>"></script>
    <script src="{{url('/')}}/vendor/khancode/js/submit.js"></script>
@endsection

    