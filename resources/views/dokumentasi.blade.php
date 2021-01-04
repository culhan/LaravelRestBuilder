@extends('khancode::base'.config('laravelrestbuilder.theme'))

@section('title', 'Dokumentasi')

@section('content')
<style>
.jstree-contextmenu{
    z-index:10
}
.tree-block {
    background: rgba(86,61,124,.15);
    padding: 10px;
    border-radius: 5px;
    /* overflow: scroll; */
    /* height: 100%; */
}
.tree-detail {
    padding: 0px;
    border-radius: 5px;
    /* height: 100%; */
}
.jstree-anchor {
    /* width:100%; */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.select-method {
    border-radius: .35rem 0 0 .35rem;
    /* height: calc(1.5em + .75rem - 2px); */
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
    padding: 8px;
    /* height: calc(1.5em + .75rem - 2px); */
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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<link href="{{url('/')}}/vendor/khancode/css/chrome-tabs.css" rel="stylesheet">

<div class="row">
    <div class="tree-block resizeableDiv1" style="width:25%">
        <li class="jstree-node  jstree-leaf jstree-last">            
            <div class="row">
                <div class="col-md-6">
                    <span style="font-size:medium">{{ session('project')['name'] }}</span><br>
                    <span style="font-size:small" id="jumlah_endpoint">{{$data['jumlah_endpoint']}} endpoint</span>
                </div>
                <div class="btn-group col-md-6" style="right:20px;position:absolute;padding-top:5px;width:15px;height:30px;">
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="fa fa-ellipsis-h" style="color: rgb(128, 128, 128); height: 25px; cursor: pointer;"></span>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="tambahFolder(0)">Tambah Folder</a>
                        <a class="dropdown-item" href="#" onclick="importPostman(0)">Import Postaman</a>
                    </div>
                </div>
            </div>
            <hr>
        </li>
        <div id="jstree"></div>
    </div>

    <div class="tree-detail d-inline-block dokumentasi resizeableDiv2" style="width:75%">

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
                <div class="d-flex justify-content-center" style="padding-top: 100px;padding-bottom: 100px;">
                    <i class="fas fa-laugh-wink fa-10x" style="color:#c2c0c0a8"></i>
                </div>
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
@endsection

@section('script_add_on')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>    

    <script>
        // jstree conditional select node
        (function ($, undefined) {
        "use strict";
        $.jstree.defaults.conditionalselect = function () { return true; };

        $.jstree.plugins.conditionalselect = function (options, parent) {
            // own function
            this.select_node = function (obj, supress_event, prevent_open) {
            if(this.settings.conditionalselect.call(this, this.get_node(obj))) {
                parent.select_node.call(this, obj, supress_event, prevent_open);
            }
            };
        };
        })(jQuery);

        $( document ).ready(function() {            

            $(".resizeableDiv1").resizable({
                minWidth: 250,
                maxWidth: 600,
            });
            $('.resizeableDiv1').resize(function(){
                $('.resizeableDiv2').width($('.resizeableDiv2').parent().width()-$(".resizeableDiv1").width()-30); 
                $('.jstree-anchor').each(function(i,k){
                    // $(this).width( $(".resizeableDiv1").width()-(($(this).parents('[role="group"]').length)*24)-20 )
                    $(this).width( $(this).parent().width()*75/100 )
                })
            });
            $(window).resize(function(){
                $('#resizeableDiv2').width($('.resizeableDiv2').parent().width()-$("#resizeableDiv1").width()-30); 
                $('#resizeableDiv1').height($('.resizeableDiv2').parent().height()); 
            });

            storage_parameter.add('list_tab')
            // set variable
            getEnv()
            // untuk refresh
            // $("#jstree").jstree(true).refresh_node(1);

            $( ".chrome-tabs-content" ).append(htmlAddButton)
            chromeTabs.addTab({title: 'New Tab',favicon: 'icon-get'})

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            $('#jstree').on("select_node.jstree", function (e, data) {                

                if(data.node) {
                    if(data.node.type == "folder") {
                        return
                    }                

                    dataOld = storage_parameter.get('list_tab.'+data.node.id)                
                    if( typeof(dataOld) != 'undefined' ) {                        
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
                                    storage_parameter.update('list_tab.'+data.id,data)
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
                newPostionIndex = data.position
                parent = data.parent
                id = data.node.id                
                formData = new FormData();
                formData.append('child', data.instance.get_node(data.node.parent).children)
                formData.append('parent', parent)
                
                $.ajax({
                    url: baseUrl + '/updatePositionApi',
                    type: 'POST',
                    crossDomain: true,
                    data: formData,
                    processData: false,
                    contentType: false,
                    complete: function (data) {
                        addLinkRight()
                    }
                });
            }).bind("ready.jstree",function(e,data){
                addLinkRight()
            }).bind("open_node.jstree",function(e,data){
                addLinkRight()
            }).bind("refresh.jstree",function(e,data){
                addLinkRight()
                $.ajax({
                    url: baseUrl + '/getJumlahEndpoint',
                    type: 'GET',
                    crossDomain: true,
                    processData: false,
                    contentType: false,
                    complete: function (data) {
                        $("#jumlah_endpoint").html(data.responseText+' endpoint')
                    }
                });
            }).bind("hover_node.jstree",function(e,data) {                
                $("#jstree").find('[aria-labelledby="'+data.node.id+'_anchor"]').find('[class="fa fa-ellipsis-h"]:first').show()
            }).bind("dehover_node.jstree",function(e,data) {
                $("#jstree").find('[aria-labelledby="'+data.node.id+'_anchor"]').find('[class="fa fa-ellipsis-h"]:first').hide()
            });
            
        });

        function addLinkRight() {
            $(".jstree-anchor").each(function(i,k){
                $(k).before(linkRigth( $(k).parent().attr('id') ))                
            })

            $('.jstree-anchor').each(function(i,k){
                $(this).width( $(".resizeableDiv1").width()-(($(this).parents('[role="group"]').length)*24)-30 )
            })
        }

        function linkRigth(id) {            
            jsonNodes = $('#jstree').jstree(true).get_json('#', { flat: true });            
            $.each(jsonNodes, function (i, val) {
                if( val.id == id ){
                    current_node = val
                }
            })            

            html_dropdown = ''

            html_dropdown += '<div class="btn-group" style="right:10px;position:absolute;padding-top:5px;width:15px;height:30px" onmouseover="$(this).find(\'span\').show();$(this).next().mouseover();" onmouseout="$(this).find(\'span\').hide();$(this).next().mouseout();">'
                html_dropdown += '<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="fa fa-ellipsis-h" style="display:none;color:#808080;height:25px;cursor:pointer"></span>'
                html_dropdown += '<div class="dropdown-menu">'                   
                    if( current_node.type == 'folder') {
                        html_dropdown += '<a class="dropdown-item" href="#" onclick="tambahFolder('+id+')">Tambah Folder</a>'
                    }
                    html_dropdown += '<a class="dropdown-item" href="#" onclick="ubahNamaEndpoint('+id+')">Ubah Nama</a>'
                    html_dropdown += '<a class="dropdown-item" href="#" onclick="hapusNode('+id+')">Hapus</a>'
                html_dropdown += '</div>'
            html_dropdown += '</div>'

            return html_dropdown
        }

        function importPostman() {
            $("#editNodeModal").find("[data-save='modal']").attr('onclick', "importPostmanServer()")

            data_modal_body = ''
            data_modal_body +='<div class="form-group">'
                data_modal_body +='<label for="json_postman">Json Postman</label>'
                data_modal_body +='<textarea class="form-control" id="json_postman" rows="12"></textarea>'
            data_modal_body +='</div>'

            $("#editNodeModal").find("[class='modal-body']").html(data_modal_body)
            $("#editNodeModal").modal('show');
        }

        function importPostmanServer(id) {
            formData = new FormData();
            formData.append('json',$("#editNodeModal").find("#json_postman").val())

            $.ajax({
                url: '/importPostman',
                type: 'POST',
                crossDomain: true,
                data: formData,
                processData: false,
                contentType: false,
                complete: function (data) {
                    $("#jstree").jstree("refresh");
                    $("#editNodeModal").modal('hide');
                }
            });
        }

        function tambahFolder(id) {
            $("#editNodeModal").find("[data-save='modal']").attr('onclick', "tambahFolderServer(" + id + ")")

            data_modal_body = ''
            data_modal_body += '<input type="text" class="input-name form-control d-none" aria-label="" value="'+id+'" name="parent">'
            data_modal_body += '<input type="text" class="input-name form-control d-none" aria-label="" value="folder" name="type">'
            data_modal_body += '<input type="text" class="input-name form-control" aria-label="" value="" placeholder="Nama Folder" name="name">'

            $("#editNodeModal").find("[class='modal-body']").html(data_modal_body)
            $("#editNodeModal").modal('show');
        }

        function tambahFolderServer(id) {
            formData = new FormData();
            formData.append('parent',$("#editNodeModal").find("[name='parent']").val())
            formData.append('name',$("#editNodeModal").find("[name='name']").val())

            $.ajax({
                url: '/tambahFolder',
                type: 'POST',
                crossDomain: true,
                data: formData,
                processData: false,
                contentType: false,
                complete: function (data) {
                    $("#jstree").jstree("refresh");
                    $("#editNodeModal").modal('hide');
                }
            });
        }

        function ubahNamaEndpoint(id) {
            $("#simpanEndpointModal").find("[data-save='modal']").attr('onclick', "saveEditNode(" + id + ")")

            jsonNodes = $('#jstree').jstree(true).get_json('#', { flat: true });
            $.each(jsonNodes, function (i, val) {
                if( val.id == id ){
                    current_node = val
                }
            })

            data_modal_body = ''
            data_modal_body = '<input type="text" class="d-none" value="'+current_node.id+'" name="id">'
            data_modal_body = '<input type="text" class="input-name form-control" aria-label="" value="'+current_node.text+'" placeholder="Nama" name="name">'

            $("#editNodeModal").find("[class='modal-body']").html(data_modal_body)
            $("[data-save*='modal']").attr('onclick','ubahNamaEndpointServer('+id+')');
            $("#editNodeModal").modal('show');
        }

        function ubahNamaEndpointServer(id) {
            data_put = {"name":$("#editNodeModal").find("[name='name']").val()}

            $.ajax({
                url: '/renameEndpoint/'+id,
                type: 'PUT',
                crossDomain: true,
                data: JSON.stringify(data_put),
                processData: false,
                contentType: 'application/json',
                complete: function (data) {
                    $("#jstree").jstree("refresh");
                    $("#editNodeModal").modal('hide');
                    storage_parameter.update('list_tab.' + data.responseJSON.id, data.responseJSON)
                    
                    idTabHapus = $( "#form-"+id ).parent().attr('data-tab')
                    if(idTabHapus) {
                        chromeTabs.removeTab( $( "[idTab='"+idTabHapus+"']" ).get(0), true )
                        chromeTabs.addTab({
                            title: data.responseJSON.text,
                            favicon: data.responseJSON.icon_tab,
                            dataAjax: data.responseJSON
                        },tab)
                    }                    
                }
            });
        }

        function hapusNode(id) {
            $("[data-save*='modal']").attr('onclick','hapusNodeServer('+id+')');
            $("#deleteNodeModal").modal('show');
        }

        function hapusNodeServer(id) {
            $.ajax({
                url: baseUrl + '/deleteEndpoint/'+id,
                type: 'delete',
                crossDomain: true,
                processData: false,
                contentType: false,
                complete: function (data) {                    
                    $("#jstree").jstree("refresh")
                    idTabHapus = $( "#form-"+id ).parent().attr('data-tab')
                    if(idTabHapus) {
                        chromeTabs.removeTab( $( "[idTab='"+idTabHapus+"']" ).get(0), true )
                    }
                    $("#deleteNodeModal").modal('hide');
                }
            });
            
        }
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

        function closeTabChromeAfter(tab) {
            chromeTabs.removeTab( $( "[idTab='"+tab+"']" ).get(0), true )
        }

        function addListQueryParams(e, idFTab, data) { 

            if(typeof data == 'undefined') data = {};

            if(!data['key']) data['key'] = ''
            if(!data['value']) data['value'] = ''
            if(!data['desc']) data['desc'] = ''
            
            idFTab++
            htmlTr = ''
            htmlTr +=   "<tr>"
                htmlTr +=   "<th scope='row'></th>"
                htmlTr +=   '<td><input type="text" name="query_params['+idFTab+'][key]" placeholder="key" class="input form-control" onkeyup="addListQueryParams(this,'+idFTab+');changeQueryParams(this);" value="'+data['key']+'"></td>'
                htmlTr +=   '<td><input type="text" name="query_params['+idFTab+'][value]" placeholder="value" class="input form-control" value="'+data['value']+'" onkeyup="changeQueryParams(this);"></td>'
                htmlTr +=   '<td><input type="text" name="query_params['+idFTab+'][desc]" placeholder="description" class="input form-control" value="'+data['desc']+'" onkeyup="changeQueryParams(this);"></td>'
            htmlTr +=   "</tr>"

            if( typeof e == 'object' ){           
                if( $(e).parent().parent().next().length == 0) {  
                    $(e).parent().parent().find('th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')
                    $(e).parent().parent().parent().append( htmlTr )
                }
            }else {
                $("#query_params_"+e).find('tbody th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')
                $("#query_params_"+e).find('tbody').append( htmlTr )
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

        function addListEnvParams(e, idFTab, data) {

            if(typeof data == 'undefined') data = {};

            if(!data['key']) data['key'] = ''
            if(!data['value']) data['value'] = ''
            if(!data['desc']) data['desc'] = ''

            idFTab++
            htmlTr = ''
            htmlTr += '<tr>'
                htmlTr += '<th scope="row"></th>'
                htmlTr += '<td><input type="text" name="env_params['+idFTab+'][key]" placeholder="key" class="input form-control" onkeyup="addListEnvParams(this,'+idFTab+');" value="'+data['key']+'"></td>'
                htmlTr += '<td><textarea type="text" name="env_params['+idFTab+'][value]" placeholder="value" class="input form-control" rows="1">'+data['value']+'</textarea></td>'
                htmlTr += '<td><input type="text" name="env_params['+idFTab+'][desc]" placeholder="description" class="input form-control" value="'+data['desc']+'"></td>'
            htmlTr += '</tr>'

            if( typeof e == 'object' ){           
                if( $(e).parent().parent().next().length == 0) {  
                    $(e).parent().parent().find('th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')                
                    $(e).parent().parent().parent().append( htmlTr )
                }
            }else {
                $("#form-env").find('tbody th').html('<i class="fa fa-close" onclick="closeCols(this)"></i>')
                $("#form-env").find('tbody').append( htmlTr )
            }
            
        }

        function resetListEnvParams(data) {
            $("#form-env").find('tbody').html("")
            $.each(data, function (i,k) {
                addListEnvParams(i, i-1, {
                    "key":k.key,
                    "value":k.value,
                    "desc":k.desc
                })
            })

            addListEnvParams(i, i-1, {
                "key":'',
                "value":'',
                "desc":''
            })
        }

        function addTabChrome({ 
                name = 'Untitled Request', 
                id = 0, 
                url = '', 
                method = 'get', 
                description = '', 
                parent = '', 
                position = '',
                query_params = {},
                headers = {},
                bodies = {},
                bodies_raw = {}
            } = {},idTab) {

            tab++
            
            htmlTabContent = ''
            htmlTabContent += '<div class="atas tab-pane fade col-md" id="top-tab-content-'+tab+'" data-tab="'+(idTab+1)+'" role="tabpanel" aria-labelledby="top-tab">'
                htmlTabContent += '<form id="form-'+id+'" enctype="multipart/form-data">'
                htmlTabContent += '<div class="row">'
                    htmlTabContent += '<div class="col-md-10">'
                        htmlTabContent += '<input type="text" class="input-name form-control" aria-label="" value="'+name+'" name="name">'
                    htmlTabContent += '</div>'
                    htmlTabContent += '<div class="col-md-2 d-flex">'
                        htmlTabContent += '<p class="ml-auto"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#env_modal">Environment</button></p>'
                    htmlTabContent += '</div>'
                    htmlTabContent += '<div class="col-md-12">'
                        htmlTabContent += '<textarea name="description" class="form-control mb-3 desc-textarea" rows="1" placeholder="deskripsi">'+description+'</textarea>'
                    htmlTabContent += '</div>'
                htmlTabContent += '</div>'
                htmlTabContent += '<div class="row">'
                    htmlTabContent += '<div class="col-md-12 mb-3">'
                        
                        htmlTabContent += '<div class="col-md-10" style="padding: 0;margin-right: 0;float: left;">'
                            htmlTabContent += '<div class="input-group">'
                                htmlTabContent += '<div class="input-group-prepend prepend-method">'
                                    htmlTabContent += '<select class="select-method" name="method">'
                                        htmlTabContent += '<option value="get" selected>GET</option>'
                                        htmlTabContent += '<option value="post">POST</option>'
                                        htmlTabContent += '<option value="put">PUT</option>'
                                        htmlTabContent += '<option value="delete">DELETE</option>'
                                    htmlTabContent += '</select>'
                                htmlTabContent += '</div>'
                                htmlTabContent += '<input type="hidden" name="id" value="'+id+'">'
                                htmlTabContent += '<input type="hidden" name="position" value="'+position+'">'
                                htmlTabContent += '<input type="hidden" name="parent" value="'+parent+'">'
                                htmlTabContent += '<input type="text" class="input-url form-control" aria-label="Text input with dropdown button" value="'+url+'" name="url" onkeyup="changeUrl(this)">'
                            htmlTabContent += '</div>'
                        htmlTabContent += '</div>'

                        htmlTabContent += '<div class="col-md-2" style="padding: 0;float: right;">'
                            
                                
                                htmlTabContent += '<div class="btn-group" style="float:right">'
                                    htmlTabContent += '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left:10px;">'
                                        htmlTabContent += 'Save'
                                    htmlTabContent += '</button>'
                                    htmlTabContent += '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
                                        htmlTabContent += '<a class="dropdown-item" href="#" onclick="saveApi(this,'+tab+')">Save</a>'
                                        htmlTabContent += '<a class="dropdown-item" href="#">Save As</a>'
                                    htmlTabContent += '</div>'
                                htmlTabContent += '</div>'

                                htmlTabContent += '<button type="button" class="btn btn-primary" style="margin-left: 10px;float: right;" onclick="submitForm(this,'+tab+')">Send</button>'
                            
                        htmlTabContent += '</div>'
                    htmlTabContent += '</div>'

                    htmlTabContent += '<div class="col-md-12">'
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

                                        iqp = 0
                                        $.each(query_params,function(i,k){
                                            if(k.key) {
                                                if(!k.value) k.value = ''
                                                if(!k.desc) k.desc = ''
                                                htmlTabContent += '<tr>'
                                                    htmlTabContent += '<th scope="row"></th>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.key+'" name="query_params['+iqp+'][key]" placeholder="key" class="input form-control" onkeyup="addListQueryParams(this,'+idTab+');changeQueryParams(this);"></td>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.value+'" name="query_params['+iqp+'][value]" placeholder="value" class="input form-control" onkeyup="changeQueryParams(this);"></td>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.desc+'" name="query_params['+iqp+'][desc]" placeholder="description" class="input form-control" onkeyup="changeQueryParams(this);"></td>'
                                                htmlTabContent += '</tr>'
                                                iqp++
                                            }
                                        })

                                        htmlTabContent += '<tr>'
                                            htmlTabContent += '<th scope="row"></th>'
                                            htmlTabContent += '<td><input type="text" name="query_params['+iqp+'][key]" placeholder="key" class="input form-control" onkeyup="addListQueryParams(this,'+idTab+');changeQueryParams(this);"></td>'
                                            htmlTabContent += '<td><input type="text" name="query_params['+iqp+'][value]" placeholder="value" class="input form-control" onkeyup="changeQueryParams(this);"></td>'
                                            htmlTabContent += '<td><input type="text" name="query_params['+iqp+'][desc]" placeholder="description" class="input form-control" onkeyup="changeQueryParams(this);"></td>'
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

                                        ih = 0
                                        $.each(headers,function(i,k){
                                            if(k.key) {
                                                if(!k.value) k.value = ''
                                                if(!k.desc) k.desc = ''
                                                htmlTabContent += '<tr>'
                                                    htmlTabContent += '<th scope="row"></th>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.key+'" name="headers['+ih+'][key]" placeholder="key" class="input form-control" onkeyup="addListHeader(this,'+idTab+');"></td>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.value+'" name="headers['+ih+'][value]" placeholder="value" class="input form-control"></td>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.desc+'" name="headers['+ih+'][desc]" placeholder="description" class="input form-control"></td>'
                                                htmlTabContent += '</tr>'
                                                ih++
                                            }
                                        })

                                        htmlTabContent += '<tr>'
                                            htmlTabContent += '<th scope="row"></th>'
                                            htmlTabContent += '<td><input type="text" name="headers['+ih+'][key]" placeholder="key" class="input form-control" onkeyup="addListHeader(this,'+idTab+');"></td>'
                                            htmlTabContent += '<td><input type="text" name="headers['+ih+'][value]" placeholder="value" class="input form-control"></td>'
                                            htmlTabContent += '<td><input type="text" name="headers['+ih+'][desc]" placeholder="description" class="input form-control"></td>'
                                        htmlTabContent += '</tr>'
                                        
                                        htmlTabContent += '</tbody>'
                                    htmlTabContent += '</table>'
                                htmlTabContent += '</div>'
                            htmlTabContent += '</div>'
                            htmlTabContent += '<div class="tab-pane fade" id="body_'+tab+'" role="tabpanel" aria-labelledby="body_'+tab+'-tab">'
                                htmlTabContent += '<div class="col-md">'
                                    htmlTabContent += '<h6>'
                                    htmlTabContent += '<select class="form-control" name="body-mode" id="body-mode" onchange="bodyModeChanged(this)">'
                                        htmlTabContent += '<option value="form-data">Form Data</option>'
                                        htmlTabContent += '<option value="raw">raw</option>'
                                    htmlTabContent += '</select>'
                                    htmlTabContent += '</h6>'
                                htmlTabContent += '</div>'
                                htmlTabContent += '<div class="col-md">'
                                    
                                    htmlTabContent += '<div class="form-group bodies_raw">'
                                        htmlTabContent += '<textarea name="bodies_raw_'+tab+'" class="d-none"></textarea>'
                                        htmlTabContent += '<textarea id="tab_bodies_raw_'+tab+'"></textarea>'
                                    htmlTabContent += '</div>'

                                    htmlTabContent += '<table class="table bodies">'
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

                                        ib = 0
                                        $.each(bodies,function(i,k){
                                            if(k.key) {
                                                if(!k.value) k.value = ''
                                                if(!k.desc) k.desc = ''
                                                htmlTabContent += '<tr>'
                                                    htmlTabContent += '<th scope="row"></th>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.key+'" name="bodies['+ib+'][key]" placeholder="key" class="input form-control" onkeyup="addListBody(this,'+idTab+');"></td>'
                                                    htmlTabContent += '<td>'
                                                        htmlTabContent += '<select class="form-control" name="bodies['+ib+'][type]" onchange="selectTypeBody(this,'+idTab+');">'
                                                            htmlTabContent += '<option value="text" '+((k.type == 'text')?'selected':'')+'>Text</option>'
                                                            htmlTabContent += '<option value="file" '+((k.type == 'file')?'selected':'')+'>File</option>'
                                                        htmlTabContent += '</select>'
                                                    htmlTabContent += '</td>'
                                                    htmlTabContent += '<td><input type="text" value="'+k.value+'" name="bodies['+ib+'][value]" placeholder="value" class="input form-control"></td>'                                                
                                                    htmlTabContent += '<td><input type="text" value="'+k.desc+'" name="bodies['+ib+'][desc]" placeholder="description" class="input form-control"></td>'
                                                htmlTabContent += '</tr>'
                                                ib++
                                            }
                                        })

                                        htmlTabContent += '<tr>'
                                            htmlTabContent += '<th scope="row"></th>'
                                            htmlTabContent += '<td><input type="text" name="bodies['+ib+'][key]" placeholder="key" class="input form-control" onkeyup="addListBody(this,'+idTab+');"></td>'
                                            htmlTabContent += '<td>'
                                                htmlTabContent += '<select class="form-control" name="bodies['+ib+'][type]" onchange="selectTypeBody(this,'+idTab+');">'
                                                    htmlTabContent += '<option value="text" selected="">Text</option>'
                                                    htmlTabContent += '<option value="file">File</option>'
                                                htmlTabContent += '</select>'
                                            htmlTabContent += '</td>'
                                            htmlTabContent += '<td><input type="text" name="bodies['+ib+'][value]" placeholder="value" class="input form-control"></td>'                                                
                                            htmlTabContent += '<td><input type="text" name="bodies['+ib+'][desc]" placeholder="description" class="input form-control"></td>'
                                        htmlTabContent += '</tr>'

                                        htmlTabContent += '</tbody>'
                                    htmlTabContent += '</table>'
                                        
                                htmlTabContent += '</div>'
                            htmlTabContent += '</div>'
                        htmlTabContent += '</div>'
                    htmlTabContent += '</div>'

                htmlTabContent += '</div>'
                htmlTabContent += '<ul class="nav nav-tabs" id="tabResponse'+tab+'" role="tablist">'
                    htmlTabContent += '<li class="nav-item">'
                        htmlTabContent += '<a class="nav-link active" data-toggle="tab" href="#response_'+tab+'" role="tab" aria-controls="response_'+tab+'" aria-selected="true">Response</a>'
                    htmlTabContent += '</li>'
                htmlTabContent += '</ul>'
                htmlTabContent += '<div class="tab-content">'                    
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

            if( !jQuery.isEmptyObject(bodies_raw) ){
                aceGenerate({ name_cols : 'bodies_raw_'+tab, mode : 'json', default_code : bodies_raw, maxLines : 5, beautify: true});
                $( '#form-'+id ).find('#body-mode').val('raw').change()
            }else {
                aceGenerate({ name_cols : 'bodies_raw_'+tab, mode : 'json', default_code : '', maxLines : 5, beautify: true});
                $( '#form-'+id ).find('#body-mode').val('form-data').change()
            }

            // update method            
            $( '#form-'+id ).find('[name*=method]').val(method).change()

        }

        function changeUrl(e) {
            idTabFormChanged = $(e).closest('form').parent().data('tab');
            listDesc = {}
            $("#query_params_"+idTabFormChanged+" tbody").find("[name^='query_params[']").each(function(i,k){
                if($(k).attr('placeholder') == 'key'){
                    listDesc[$(k).val()] = $("#query_params_"+idTabFormChanged+" tbody").find("[name='"+($(k).attr('name')).replace("key","desc")+"']").val()
                }
            })
            
            $("#query_params_"+idTabFormChanged+" tbody").html("")
            
            ik = 0
            $.each( getParamsFromUrl(URI($(e).val())), function(i,k){
                addListQueryParams(idTabFormChanged,ik-1,{
                    "key":k.key,
                    "value":k.value,
                    "desc":listDesc[k.key]
                })
                ik++
            })

            addListQueryParams(idTabFormChanged,ik-1,{
                "key":"",
                "value":"",
                "desc":""
            })
        }

        function changeQueryParams(e) {
            idTabFormChanged = $(e).closest('form').parent().data('tab');
            urlFullPath = URI(getUrlPathFromUrl( $(e).closest('form').find('[name="url"]').val() ))
            $("#query_params_"+idTabFormChanged+" tbody").find("[name^='query_params[']").each(function(i,k){
                if($(k).attr('placeholder') == 'key'){
                    if( $(k).val() ){
                        urlFullPath.addSearch( $(k).val(), $("#query_params_"+idTabFormChanged+" tbody").find("[name='"+($(k).attr('name')).replace("key","value")+"']").val() )
                    }
                }
            })
            $(e).closest('form').find('[name="url"]').val(urlFullPath.readable())
        }

        function bodyModeChanged(e) {
            e_parent = $(e).parent().parent().parent()
            $(e_parent).find('.bodies').hide()
            $(e_parent).find('.bodies_raw').hide()
            if($(e_parent).find('#body-mode').val() == 'form-data'){
                $(e_parent).find('.bodies').show()
            }
            if($(e_parent).find('#body-mode').val() == 'raw'){
                $(e_parent).find('.bodies_raw').show()
            }
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

    <script src="<?php echo URL::to('/vendor/khancode/js/storage.js');?>"></script>
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
            idTab = $(detail.tabEl).attr('idTab')
            openTab( idTab )
            
            $('#jstree').jstree("deselect_all");
            selected_id = $("#top-tab-content-"+idTab).find("[name='id']").val()
            if(selected_id) {
                $('#jstree').jstree('select_node', selected_id);
            }
        })        
        el.addEventListener('tabAdd', ({ detail }) => {
            dataAjax = {}
            if( detail.tabProperties.dataAjax ) {                
                dataAjax = {
                    'name' : detail.tabProperties.dataAjax.name, 
                    'id' : detail.tabProperties.dataAjax.id, 
                    'url' : detail.tabProperties.dataAjax.url, 
                    'method' : detail.tabProperties.dataAjax.method, 
                    'description' : detail.tabProperties.dataAjax.data.description, 
                    'parent' : detail.tabProperties.dataAjax.parent, 
                    'position' : detail.tabProperties.dataAjax.position,
                    'query_params' : detail.tabProperties.dataAjax.data.query_params,
                    'headers' : detail.tabProperties.dataAjax.data.headers,
                    'bodies' : detail.tabProperties.dataAjax.data.bodies,
                    'bodies_raw' : detail.tabProperties.dataAjax.data.bodies_raw
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
    <script src="{{url('/')}}/vendor/khancode/js/ace-generator.js"></script>

    <script>
        function openNewTab(tab) {
            window.open(storage_parameter.get("code_editor_response_editor" + tab)+'&show_html=1', '__new')
        }
    </script>
@endsection

@section('modal')
<div class="modal fade" id="deleteNodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Yakin Hapus ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" data-save="modal">Ya</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Endpoint</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" data-save="modal">Simpan</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="simpanEndpointModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" data-save="modal">Simpan</button>
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