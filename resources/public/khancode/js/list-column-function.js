// khusus table relasi    

storage_parameter.add('column_function');

$("[name='column_function_sementara[json]']").switcher();

eval("code_editor_column_function= ace.edit('column_function_sementara', {mode: \"ace/mode/sql\",maxLines: 30,minLines: 5,wrap: true, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
eval("code_editor_column_function.getSession().on('change', function(e) {val_code = code_editor_column_function.getSession().getValue();$( '[name=\"column_function_sementara[function]\"]' ).val(val_code);})")

eval("code_editor_column_function_response_code= ace.edit('column_function_sementara_response_code', {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
eval("code_editor_column_function_response_code.getSession().setMode({path:\"ace/mode/php\", inline:true})")            
eval("code_editor_column_function_response_code.getSession().on('change', function(e) {val_code_response_code = code_editor_column_function_response_code.getSession().getValue();$( '[name=\"column_function_sementara[response_code]\"]' ).val(val_code_response_code);})")

function build_list_column_function_tabel(data) {

    tableHtml = '<table id="example_listcolumn_function" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'
    tableHtml += '<th>Name</th>'
    tableHtml += '<th>Json</th>'    
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (column_function_relation, value_relation) {
        column_function_relation = parseInt(column_function_relation)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['name']
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += (value_relation['json']) ? 'yes' : 'no'
        tableHtml += '</td>'
        tableHtml += '<td id="modul_column_function_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editcolumn_functionFromTable(\'' + column_function_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removecolumn_functionFromTable(\'' + column_function_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("listcolumn_function_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if (typeof listcolumn_function_table != 'undefined') {
        page_now = listcolumn_function_table.page.info().page
        page_length = listcolumn_function_table.page.info().length
    }

    listcolumn_function_table = $("#example_listcolumn_function").DataTable({
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        rowReorder: true,
        bAutoWidth: false,
        columns: [
            { "width": "1px" },
            null,
            null,
            null,
        ]
    });

    listcolumn_function_table.on("row-reorder", function (e, diff, edit) {
        position = replaceString(
            "modul_column_function_",
            "",
            $(edit.triggerRow.node())
                .find("[id^=modul_column_function_]")
                .attr("id")
        );

        beforeData = parseInt(diff[0].oldData);
        afterData = parseInt(diff[0].newData);
        editData = parseInt(position);

        moveColumnFunction(beforeData-1, afterData-1);

    });
    
    listcolumn_function_table.page.len(page_length).page(page_now).draw('page');

    if (page_now > (listcolumn_function_table.page.info().pages - 1)) {
        page_now--
        listcolumn_function_table.page(page_now).draw('page');
    }
}

function moveColumnFunction(old_index, new_index) {
    storage_parameter.update('column_function', move(storage_parameter.get('column_function'), old_index, new_index) )
    build_list_column_function_tabel(storage_parameter.get('column_function'))
}

function remove_column_function_kolom_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'column_function_sementara.column.' + k)
    build_column_function_kolom(objModul['column_function_sementara']['column'])
}

function tambah_list_column_function_table() {
    storage_parameter.add('column_function', $('#modul').serializeJSON().column_function_sementara)
    build_list_column_function_tabel(storage_parameter.get('column_function'))
    listcolumn_function_table.page('last').draw('page');

    clear_column_function_sementara()
}

function clear_column_function_sementara() {
    $('[name="column_function_sementara[name]"]').val('')
    $('[name="column_function_sementara[function]"]').val('')
    $('[name="column_function_sementara[response_code]"]').val('')

    eval("code_editor_column_function.setValue($( '[name=\"column_function_sementara[function]\"]' ).val())")
    eval("code_editor_column_function.clearSelection()")

    eval("code_editor_column_function_response_code.setValue($( '[name=\"column_function_sementara[response_code]\"]' ).val())")
    eval("code_editor_column_function_response_code.clearSelection()")

    $('[name="column_function_sementara[json]"]').prop('checked', false).change()    
}

function reset_column_function_sementara() {
    clear_column_function_sementara()

    $("#tambah_column_function").removeClass('d-none')

    $("#edit_column_function").addClass('d-none')
    $("#edit_simpan_column_function").addClass('d-none')
}

function edit_simpan_column_function_table(i) {
    objModul = $('#modul').serializeJSON()
    column_function_sementara = objModul['column_function_sementara']

    storage_parameter.update('column_function.' + i, column_function_sementara)
    build_list_column_function_tabel(storage_parameter.get('column_function'))

    simpanKeApi()
}

function editcolumn_functionFromTable(i) {
    $("#tambah_column_function").addClass('d-none')
    
    $("#edit_column_function").removeClass('d-none')
    $("#edit_simpan_column_function").removeClass('d-none')

    $("#edit_column_function").attr("onclick", "edit_list_column_function_table(" + i + ")")
    $("#edit_simpan_column_function").attr("onclick", "edit_simpan_column_function_table(" + i + ")")

    fill_column_function_sementara(storage_parameter.get('column_function.' + i))

    $('html, body').animate({
        scrollTop: $("#kolomfungsi-tab").offset().top
    }, 1000, function () {
        $("#listcolumn_function-tab").focus();
    });
}

function fill_column_function_sementara(data) {

    $('[name="column_function_sementara[name]"]').val(data.name)
    $('[name="column_function_sementara[function]"]').val(data.function)
    $('[name="column_function_sementara[response_code]"]').val(data.response_code)

    eval("code_editor_column_function.setValue($( '[name=\"column_function_sementara[function]\"]' ).val())")
    eval("code_editor_column_function.clearSelection()")

    eval("code_editor_column_function_response_code.setValue($( '[name=\"column_function_sementara[response_code]\"]' ).val())")
    eval("code_editor_column_function_response_code.clearSelection()")
    
    if( data['json'] ) {
        $( '[name="column_function_sementara[json]"]' ).prop('checked',true).change()
    }else {
        $('[name="column_function_sementara[json]"]').prop('checked', false).change()
    }
}

function edit_list_column_function_table(i) {
    $("#edit_column_function").addClass('d-none')
    $("#edit_simpan_column_function").addClass('d-none')
    $("#tambah_column_function").removeClass('d-none')

    objModul = $('#modul').serializeJSON()
    column_function_sementara = objModul['column_function_sementara']

    storage_parameter.update('column_function.' + i, column_function_sementara)
    build_list_column_function_tabel(storage_parameter.get('column_function'))

    clear_column_function_sementara()
}

function removecolumn_functionFromTable(i) {
    storage_parameter.remove('column_function.' + i)
    build_list_column_function_tabel(storage_parameter.get('column_function'))
}