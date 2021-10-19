storage_parameter.add('classtab');

aceGenerate({ name_cols: "classtab_sementara[class_path]" });
// eval("code_editor_classtab_sementara_class_path_= ace.edit('classtab_sementara_class_path', {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
// eval("code_editor_classtab_sementara_class_path_.getSession().setMode({path:\"ace/mode/php\", inline:true})")
// eval("code_editor_classtab_sementara_class_path_.getSession().on('change', function(e) {val_code_class_path = code_editor_classtab_sementara_class_path_.getSession().getValue();$( '[name=\"classtab_sementara[class_path]\"]' ).val(val_code_class_path);})")

function build_list_classtab_tabel(data) {

    tableHtml = '<table id="example_listclasstab" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'
    tableHtml += '<th>Modul</th>'
    tableHtml += '<th>Path</th>'
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (classtab_relation, value_relation) {
        classtab_relation = parseInt(classtab_relation)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['modul']
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['class_path']
        tableHtml += '</td>'
        tableHtml += '<td id="route_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editclasstabFromTable(\'' + classtab_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeclasstabFromTable(\'' + classtab_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("listclasstab_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if (typeof listclasstab_table != 'undefined') {
        page_now = listclasstab_table.page.info().page
        page_length = listclasstab_table.page.info().length
    }

    listclasstab_table = $("#example_listclasstab").DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });

    listclasstab_table.page.len(page_length).page(page_now).draw('page');

    if (page_now > (listclasstab_table.page.info().pages - 1)) {
        page_now--
        listclasstab_table.page(page_now).draw('page');
    }
}

function remove_classtab_kolom_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'classtab_sementara.column.' + k)
    build_classtab_kolom(objModul['classtab_sementara']['column'])
}

function tambah_list_classtab_table() {
    storage_parameter.add('classtab', $('#modul').serializeJSON().classtab_sementara)
    build_list_classtab_tabel(storage_parameter.get('classtab'))
    listclasstab_table.page('last').draw('page');

    clear_classtab_sementara()
}

function clear_classtab_sementara() {
    $('[name="classtab_sementara[name]"]').val('')
    $('[name="classtab_sementara[class_path]"]').val('')

    eval("code_editor_classtab_sementara_class_path_.setValue($( '[name=\"classtab_sementara[class_path]\"]' ).val())")
    eval("code_editor_classtab_sementara_class_path_.clearSelection()")
}

function reset_classtab_sementara() {
    clear_classtab_sementara()

    $("#tambah_classtab").removeClass('d-none')

    $("#edit_classtab").addClass('d-none')
    $("#edit_simpan_classtab").addClass('d-none')
}

function edit_simpan_classtab_table(i) {
    objModul = $('#modul').serializeJSON()
    classtab_sementara = objModul['classtab_sementara']

    storage_parameter.update('classtab.' + i, classtab_sementara)
    build_list_classtab_tabel(storage_parameter.get('classtab'))

    simpanKeApi()
}

function editclasstabFromTable(i) {
    $("#tambah_classtab").addClass('d-none')

    $("#edit_classtab").removeClass('d-none')
    $("#edit_simpan_classtab").removeClass('d-none')

    $("#edit_classtab").attr("onclick", "edit_list_classtab_table(" + i + ")")
    $("#edit_simpan_classtab").attr("onclick", "edit_simpan_classtab_table(" + i + ")")

    fill_classtab_sementara(storage_parameter.get('classtab.' + i))

    $('html, body').animate({
        scrollTop: $("#kolomfungsi-tab").offset().top
    }, 1000, function () {
        $("#listclasstab-tab").focus();
    });
}

function fill_classtab_sementara(data) {
    $('[name="classtab_sementara[modul]"]').val(data.modul)
    $('[name="classtab_sementara[class_path]"]').val(data.class_path)

    eval("code_editor_classtab_sementara_class_path_.setValue($( '[name=\"classtab_sementara[class_path]\"]' ).val())")
    eval("code_editor_classtab_sementara_class_path_.clearSelection()")
}

function edit_list_classtab_table(i) {
    $("#edit_classtab").addClass('d-none')
    $("#edit_simpan_classtab").addClass('d-none')
    $("#tambah_classtab").removeClass('d-none')

    objModul = $('#modul').serializeJSON()
    classtab_sementara = objModul['classtab_sementara']

    storage_parameter.update('classtab.' + i, classtab_sementara)
    build_list_classtab_tabel(storage_parameter.get('classtab'))

    clear_classtab_sementara()
}

function removeclasstabFromTable(i) {
    storage_parameter.remove('classtab.' + i)
    build_list_classtab_tabel(storage_parameter.get('classtab'))
}