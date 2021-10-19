// khusus table files    

storage_parameter.add('files');

function build_list_files_tabel(data) {

    tableHtml = '<table id="example_listfiles" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'
    tableHtml += '<th>Name</th>'
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (files_relation, value_relation) {
        files_relation = parseInt(files_relation)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['name']
        tableHtml += '</td>'        
        tableHtml += '<td id="route_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-info float-right btn-sm" onclick="showfilesFromTable(\'' + value_relation['id'] + '\')" style="margin-right: 15px;">'
        tableHtml += '<i class="fas fa-file fa-sm text-white-50"></i>'
        tableHtml += '</button>'        
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("listfiles_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if (typeof listfiles_table != 'undefined') {
        page_now = listfiles_table.page.info().page
        page_length = listfiles_table.page.info().length
    }

    listfiles_table = $("#example_listfiles").DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });

    listfiles_table.page.len(page_length).page(page_now).draw('page');

    if (page_now > (listfiles_table.page.info().pages - 1)) {
        page_now--
        listfiles_table.page(page_now).draw('page');
    }
}

function showfilesFromTable(i) {
    $("#tambah_files").addClass('d-none')
    $("#edit_files").removeClass('d-none')
    $("#edit_files").attr("onclick", "edit_list_files_table(" + i + ")")
    
    $.ajax({
        url: '/modulFile/' + i,
        type: 'GET',
        crossDomain: true,
        data: '',
        processData: false,
        contentType: false,
        success: function (data) {            
            file = data

            html_code_php =
                '<textarea name="file_code" class="d-none" data-editor="' + project_lang + '" rows="10">' + file.code +
                '</textarea>' +
                '<textarea id="file_code">' + file.code +
                '</textarea>';

            $("#modal_1 .modal-body").html(html_code_php);

            eval("code_editor_file_code= ace.edit('file_code')")
            eval("code_editor_file_code.setOptions({mode: \"ace/mode/" + project_lang +"\", maxLines: 30, minLines: 5, wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true, readOnly: true })")
            eval("code_editor_file_code.getSession().on('change', function(e) {val_code = code_editor_file_code.getSession().getValue();$( '[name=\"file_code\"]' ).val(val_code);})")

            $("#modal_1").modal('show')
        }
    });    
}