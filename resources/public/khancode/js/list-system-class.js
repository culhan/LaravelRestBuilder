storage_parameter.add('system_class');

eval("code_editor_system_class_class_code= ace.edit('system_class_sementara_class_code', {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
eval("code_editor_system_class_class_code.getSession().setMode({path:\"ace/mode/php\", inline:true})")            
eval("code_editor_system_class_class_code.getSession().on('change', function(e) {val_code_class_code = code_editor_system_class_class_code.getSession().getValue();$( '[name=\"system_class_sementara[class_code]\"]' ).val(val_code_class_code);})")

function build_list_system_class_tabel(data) {

    tableHtml = '<table id="example_listsystem_class" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'
    tableHtml += '<th>Name</th>'
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (system_class_relation, value_relation) {
        system_class_relation = parseInt(system_class_relation)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['name']
        tableHtml += '</td>'
        tableHtml += '<td id="route_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editsystem_classFromTable(\'' + system_class_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removesystem_classFromTable(\'' + system_class_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("listsystem_class_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if (typeof listsystem_class_table != 'undefined') {
        page_now = listsystem_class_table.page.info().page
        page_length = listsystem_class_table.page.info().length
    }

    listsystem_class_table = $("#example_listsystem_class").DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });

    listsystem_class_table.page.len(page_length).page(page_now).draw('page');

    if (page_now > (listsystem_class_table.page.info().pages - 1)) {
        page_now--
        listsystem_class_table.page(page_now).draw('page');
    }
}

function remove_system_class_kolom_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'system_class_sementara.column.' + k)
    build_system_class_kolom(objModul['system_class_sementara']['column'])
}

function tambah_list_system_class_table() {
    storage_parameter.add('system_class', $('#modul').serializeJSON().system_class_sementara)
    build_list_system_class_tabel(storage_parameter.get('system_class'))
    listsystem_class_table.page('last').draw('page');

    clear_system_class_sementara()
}

function clear_system_class_sementara() {
    $('[name="system_class_sementara[name]"]').val('')    
    $('[name="system_class_sementara[class_code]"]').val('')

    eval("code_editor_system_class_class_code.setValue($( '[name=\"system_class_sementara[class_code]\"]' ).val())")
    eval("code_editor_system_class_class_code.clearSelection()")
}

function reset_system_class_sementara() {
    clear_system_class_sementara()

    $("#tambah_system_class").removeClass('d-none')

    $("#edit_system_class").addClass('d-none')
    $("#edit_simpan_system_class").addClass('d-none')
}

function edit_simpan_system_class_table(i) {
    objModul = $('#modul').serializeJSON()
    system_class_sementara = objModul['system_class_sementara']

    storage_parameter.update('system_class.' + i, system_class_sementara)
    build_list_system_class_tabel(storage_parameter.get('system_class'))

    simpanKeApi()
}

function editsystem_classFromTable(i) {
    $("#tambah_system_class").addClass('d-none')
    
    $("#edit_system_class").removeClass('d-none')
    $("#edit_simpan_system_class").removeClass('d-none')

    $("#edit_system_class").attr("onclick", "edit_list_system_class_table(" + i + ")")
    $("#edit_simpan_system_class").attr("onclick", "edit_simpan_system_class_table(" + i + ")")

    fill_system_class_sementara(storage_parameter.get('system_class.' + i))

    $('html, body').animate({
        scrollTop: $("#kolomfungsi-tab").offset().top
    }, 1000, function () {
        $("#listsystem_class-tab").focus();
    });
}

function fill_system_class_sementara(data) {
    $('[name="system_class_sementara[name]"]').val(data.name)
    $('[name="system_class_sementara[class_code]"]').val(data.class_code)

    eval("code_editor_system_class_class_code.setValue($( '[name=\"system_class_sementara[class_code]\"]' ).val())")
    eval("code_editor_system_class_class_code.clearSelection()")
}

function edit_list_system_class_table(i) {
    $("#edit_system_class").addClass('d-none')
    $("#edit_simpan_system_class").addClass('d-none')
    $("#tambah_system_class").removeClass('d-none')

    objModul = $('#modul').serializeJSON()
    system_class_sementara = objModul['system_class_sementara']

    storage_parameter.update('system_class.' + i, system_class_sementara)
    build_list_system_class_tabel(storage_parameter.get('system_class'))

    clear_system_class_sementara()
}

function removesystem_classFromTable(i) {
    storage_parameter.remove('system_class.' + i)
    build_list_system_class_tabel(storage_parameter.get('system_class'))
}