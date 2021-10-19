function saveApi(e,tab) {
    if ($('#top-tab-content-' + tab).find("[name='id']").val() > 0) {
        saveApiServer(tab)
        return
    }
    $("#simpanEndpointModal").find("[data-save='modal']").attr('onclick',"saveApiServer("+tab+")")

    data_modal_body = '<p>Pilih Folder: </p>'
    data_modal_body += '<div class="col-md-12 tree-block">'
        data_modal_body += '<div id="jstree-modal"></div>'
    data_modal_body += '</div>'

    $("#simpanEndpointModal").find("[class='modal-body']").html(data_modal_body)

    $('#jstree-modal').jstree({
        'core': {
            "data": {
                'url': function (node) {
                    return node.id === '#' ?
                        "/listEndpoint" :
                        "/listEndpointChildren/" + node.id;
                },
            },
            "check_callback": true
        },
        "plugins": ["dnd", "wholerow", "types", "search", "json_data", "conditionalselect"],
        'types': {
            "root": { // the root node can have only "branch" children
                "valid_children": [
                    "folder",
                    "file-get",
                    "file-post",
                    "file-put",
                    "file-delete"
                ],
                'icon': "fa fa-folder"
            },
            "folder": { // any "branch" can only have "leaf" children
                "valid_children": [
                    "folder",
                    "file-get",
                    "file-post",
                    "file-put",
                    "file-delete"
                ],
                'icon': "fa fa-folder"
            },
            "file-get": { // "leaf" typed nodes can not have any children
                "valid_children": [],
                'icon': "icon-get"
            },
            "file-post": { // "leaf" typed nodes can not have any children
                "valid_children": [],
                'icon': "icon-post"
            },
            "file-put": { // "leaf" typed nodes can not have any children
                "valid_children": [],
                'icon': "icon-put"
            },
            "file-delete": { // "leaf" typed nodes can not have any children
                "valid_children": [],
                'icon': "icon-delete"
            }

        },
        'conditionalselect':function(node) {
            if (node.type == 'folder') {                
                $('#top-tab-content-' + tab).find("[name='parent']").val(node.id)
                return true
            }
            return false
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
        console.log(newPostionIndex, parent, id, data)
    }).bind("select_node.jstree", function (e, data) {        
        
    });

    $('#jstree-modal').on("changed.jstree", function (e, data) {        
    });
    $("#simpanEndpointModal").modal('show');
}

function saveApiServer(tab) {
    closestForm = $('#top-tab-content-' + tab).find('form').serializeArray()
    formData = new FormData();

    $.each(closestForm, function (i, k) {
        if ((k.name).indexOf("bodies_raw") !== -1 ){
            formData.append("bodies_raw", k.value)    
        }else {
            formData.append(k.name, k.value)
        }
    })


    $.ajax({
        url: baseUrl + '/saveApi',
        type: 'POST',
        crossDomain: true,
        data: formData,
        processData: false,
        contentType: false,
        complete: function (data) {
            $("#jstree").jstree("refresh")
            
            $("#simpanEndpointModal").modal('hide');
            $("[idTab='" + tab + "']").find('.chrome-tab-close').removeClass('changed')
            $("[idTab='" + tab + "']").find('.chrome-tab-close').removeAttr('onclick')
            $("[idTab='" + tab + "']").find('.chrome-tab-close').attr('onclick','closeTabChromeAfter('+tab+')')
            $("[idTab='" + tab + "']").find('.chrome-tab-title').html(data.responseJSON.name)
            $("#top-tab-content-" + tab).find('[name="id"]').val(data.responseJSON.id)
            $("#top-tab-content-" + tab).find('form').attr('id','form-'+data.responseJSON.id)
            storage_parameter.update('list_tab.' + data.responseJSON.id, data.responseJSON)
        }
    });
}

function submitForm(e, idTab) {
    closestForm = $(e).closest('form').serializeArray()

    // Find and replace `content` if there
    for (index = 0; index < closestForm.length; ++index) {
        oldData = closestForm[index]
        $.each(window.env, function (i, k) {
            regex = new RegExp('{{' + k.key + '}}', "igm");
            closestForm[index]['name'] = oldData['name'].replace(regex, k.value);
            closestForm[index]['value'] = oldData['value'].replace(regex, k.value);
        })
    }

    formData = new FormData();

    for (index = 0; index < closestForm.length; ++index) {
        if ((closestForm[index]['name']).indexOf("bodies_raw") !== -1) {
            closestForm[index]['name'] = "bodies_raw"
        }
        formData.append(closestForm[index]['name'], closestForm[index]['value'])
    }
    
    $.ajax({
        url: baseUrl + '/callApi',
        type: 'POST',
        // headers: closestForm.find('.header-params').serializeJSON(),
        crossDomain: true,
        data: formData,
        processData: false,
        contentType: false,
        complete: function (data) {
            storage_parameter.update("code_editor_response_editor" + idTab, this.url)
            htmlTabContent = ''
            htmlTabContent += '<div class="row">'
                htmlTabContent += '<div class="col-md-12 mb-3">'
                    htmlTabContent += '<div class="pull-right">'
                        htmlTabContent += '<button type="button" class="btn btn-primary" style="margin-left: 10px;float: right;padding: 8px 20px 8px 20px;padding-left: 20px;">Save</button>'
            htmlTabContent += '<button type="button" class="btn btn-primary" style="margin-left: 10px;float: right;padding: 8px 20px 8px 20px;padding-left: 20px;" onclick="openNewTab(' + idTab+')">Open in new tab</button>'
                    htmlTabContent += '</div>'
                htmlTabContent += '</div>'
            htmlTabContent += '</div>'
            htmlTabContent += '<div class="form-group bodies_raw">'
            htmlTabContent += '<textarea disabled name="response_editor_' + idTab + '" class="d-none"></textarea>'
            htmlTabContent += '<textarea id="tab_response_editor_' + idTab + '"></textarea>'
            htmlTabContent += '</div>'

            $("#response_" + idTab).html(htmlTabContent)
            
            if (isJson(data.responseJSON.data) ) {
                aceGenerate({ name_cols: 'response_editor_' + idTab, mode: 'json', default_code: data.responseJSON.data, maxLines: 30 });
            }else {
                aceGenerate({ name_cols: 'response_editor_' + idTab, mode: 'html', default_code: data.responseJSON.data, maxLines: 30 });
            }
        }
    });
}

function simpanApiEnv() {
    formData = new FormData();

    $("#form-env").find(':input').each(function () {
        if ($(this).val() != "") {
            formData.append($(this).attr('name'), $(this).val())
        }
    })

    $.ajax({
        url: baseUrl +'/saveEnv',
        type: 'POST',
        crossDomain: true,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            window.env = data
            $("#env_modal").modal('hide')
        }
    });
}

function tambahApiEnv(key, value) {
    formData = new FormData();

    formData.append('key', key)
    formData.append('value', value)

    $.ajax({
        url: baseUrl + '/addEnv',
        type: 'POST',
        crossDomain: true,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            window.env = data
            resetListEnvParams(data)
        }
    });
}

function getEnv() {
    tbody = $("#form-env").find('tbody')

    $.ajax({
        url: baseUrl +'/getEnv',
        type: 'GET',
        success: function (data) {
            window.env = data
            htmlTr = ''
            if(data.length){
                $.each(data, function (i, k) {
                    if (!k.key) {
                        k.key = ''
                    }
                    if (!k.value) {
                        k.value = ''
                    }
                    if (!k.desc) {
                        k.desc = ''
                    }

                    htmlTr += '<tr>'                
                    htmlTr += '<th scope="row"><i class="fa fa-close" onclick="closeCols(this)"></i></th>'
                    htmlTr += '<td><input type="text" name="env_params[' + i + '][key]" placeholder="key" class="input form-control" onkeyup="addListEnvParams(this,' + i + ');" value="' + k.key + '"></td>'
                    htmlTr += '<td><textarea name="env_params[' + i + '][value]" placeholder="value" class="input form-control" rows="1">' + k.value + '</textarea></td>'
                    htmlTr += '<td><input type="text" name="env_params[' + i + '][desc]" placeholder="description" class="input form-control" value="' + k.desc + '"></td>'
                    htmlTr += '</tr>'
                })
                i = data.length                        

                tbody.html(htmlTr)
                $("[name='env_params[" + (i - 1) + "][key]']").keyup()
            }
        }
    });
}

function simpanKeApi() {
    unsetErrorColumn()

    objModul = $("#modul").serializeJSON();
    delete objModul["route"];
    delete objModul["relation"];
    delete objModul["route_sementara"];
    delete objModul["column_sementara"];
    delete objModul["column_function_sementara"];
    delete objModul["index_sementara"];
    delete objModul["repository_sementara"];
    
    if (typeof submit_url == 'undefined' ) {
        submit_url = "/build"
    }

    storage_parameter.update('select_project', $('[name="select_project"]').val());

    $.ajax({
        url: submit_url,
        type: "POST",
        data: JSON.stringify(
            Object.assign({}, objModul, storage_parameter.except(["files"]))
        ),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            htmlcreated = "";
            htmlupdated = "";
            htmlmigration = "";
            htmldeleted = "";
            $.each(data, function(index, value) {
                $.each(value, function(index_2, value_2) {
                    if (index == "created") {
                        htmlcreated += value_2 + "<br>";
                    } else if (index == "updated") {
                        htmlupdated += value_2 + "<br>";
                    } else if (index == "migration") {
                        htmlmigration += value_2 + "<br>";
                    } else if (index == "deleted") {
                        htmldeleted += value_2 + "<br>";
                    }
                    
                });
            });

            if (data.data) {
                $("[name='id']")
                    .val(data.data.id)
                    .change();
            }

            html = "";
            if (htmlcreated != "") {
                html += "created <br>" + htmlcreated + "<br>";
            }
            if (htmlupdated != "") {
                html += "updated <br>" + htmlupdated + "<br>";
            }
            if (htmlmigration != "") {
                html += "migrated <br>" + htmlmigration + "<br>";
            }
            if (htmldeleted != "") {
                html += "deleted <br>" + htmldeleted + "<br>";
            }

            if (html != "") {
                $("#modal_1 .modal-body").html(html);
            } else {
                $("#modal_1 .modal-body").html("Tidak ada perubahan");
            }

            $("#launch_modal_1").click();
            if ($('#table_name').length) {
                ambil_data_tabel($('#table_name').get(0))
                build_list_files_tabel(data.files)
            }
        },
        error: function(data) {
            if (data.responseJSON) {
                if (jsonObj = IsJsonString(data.responseJSON.message)){
                    setErrorColumn(jsonObj)
                } else if (jsonObj = data.responseJSON.error.error) {
                    setErrorColumn(jsonObj)
                }else {
                    str_error = data.responseJSON.message;
                    str_error = str_error.replace(/(?:\r\n|\r|\n)/g, '<br>');
                    $("#modal_1 .modal-body").html(str_error);
                    $("#launch_modal_1").click();
                }                
            } else {
                $("#modal_1 .modal-body").html("Tidak ada perubahan");
                $("#launch_modal_1").click();
            }            
        }
    });
}

function setErrorColumn(errorData) {
    $("errorMsg").remove();
    $.each(errorData, function (key, value) {
        errorMsg = '<errorMsg>';
        $.each(value, function (vkey, vvalue) {
            if (errorMsg != '<errorMsg>' ) {
                errorMsg += '<br>';    
            }
            errorMsg += "<span style='color:red;font-size:small;'>"+vvalue+"</span>";
        });
        errorMsg += '</errorMsg>';
        $('[name="' + key + '"]').after(errorMsg)
    });
}

function unsetErrorColumn() {
    $("errorMsg").remove();
}

function simpanDataTable(data) {
    $.ajax({
        url: '/saveData',
        type: 'POST',
        crossDomain: true,
        data: JSON.stringify(data),
        processData: false,
        contentType: 'application/json',
        complete: function (data) {
            console.log('sent')
        }
    })
}

function addDataTable(data) {
    $.ajax({
        url: '/addData',
        type: 'POST',
        crossDomain: true,
        data: JSON.stringify(data),
        processData: false,
        contentType: 'application/json',
        complete: function (data) {
            $('#modalData').modal('toggle')
            list_data.ajax.reload(null, false)
        }
    })
}