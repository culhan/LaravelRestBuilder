// khusus table relasi    

storage_parameter.add('repositories');

$(document).ready(function () {
    eval("code_editor_repository_sementara_code= ace.edit('repository_sementara_code', {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
    eval("code_editor_repository_sementara_code.getSession().setMode({path:\"ace/mode/php\", inline:true})")
    eval("code_editor_repository_sementara_code.getSession().on('change', function(e) {val_code_response_code = code_editor_repository_sementara_code.getSession().getValue();$( '[name=\"repository_sementara[code]\"]' ).val(val_code_response_code);})")
});

function build_list_repository_tabel(data) {

    tableHtml = '<table id="example_listrepository" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'
    tableHtml += '<th>Nama Fungsi</th>'
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (repository_relation, value_relation) {
        repository_relation = parseInt(repository_relation)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['name']
        tableHtml += '</td>'        
        tableHtml += '<td id="route_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editrepositoryFromTable(\'' + repository_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removerepositoryFromTable(\'' + repository_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("listrepository_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if (typeof listrepository_table != 'undefined') {
        page_now = listrepository_table.page.info().page
        page_length = listrepository_table.page.info().length
    }

    listrepository_table = $("#example_listrepository").DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });

    listrepository_table.page.len(page_length).page(page_now).draw('page');

    if (page_now > (listrepository_table.page.info().pages - 1)) {
        page_now--
        listrepository_table.page(page_now).draw('page');
    }
}

function tambah_repository_parameter(k) {

    index_column_html = ''
    index_column_html += '<div class="row mb-3" >'
    index_column_html += '<div class="col-sm-3" style="padding-top:5px;">'
    index_column_html += '<label>' + (k + 1) + '.&nbsp;&nbsp;Nama</label>'
    index_column_html += '</div>'
    index_column_html += '<div class="col-sm">'
    index_column_html += '<input type="" class="form-control" placeholder="nama" name="repository_sementara[param][' + k + ']">'
    index_column_html += '</div>'
    index_column_html += '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_repository_parameter(' + k + ')">x</button>'
    index_column_html += '</div>'

    $(".repository_param_sementara").append(index_column_html)
    $("[onclick^=\"tambah_repository_parameter\"]").attr("onclick", "tambah_repository_parameter(" + (k + 1) + ")")    

}

function remove_repository_parameter(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'repository_sementara.param.' + k)
    build_repository_parameter(objModul['repository_sementara']['param'])
}

function build_repository_parameter(data) {
    $(".repository_param_sementara").html('')
    $("[onclick^=\"tambah_repository_parameter\"]").attr("onclick", "tambah_repository_parameter(0)")
    i_index = 0
    $.each(data, function (index, value) {
        tambah_repository_parameter(i_index)
        $("[name=\"repository_sementara[param][" + i_index + "]\"]").val(value)
        i_index++
    });
}

function remove_repository_kolom_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'repository_sementara.column.' + k)
    build_repository_kolom(objModul['repository_sementara']['column'])
}

function tambah_list_repository_table() {
    storage_parameter.add('repositories', $('#modul').serializeJSON().repository_sementara)
    build_list_repository_tabel(storage_parameter.get('repositories'))
    listrepository_table.page('last').draw('page');

    clear_repository_sementara()
}

function clear_repository_sementara() {
    $(".repository_param_sementara").html('')
    $("[onclick^=\"tambah_repository_parameter\"]").attr("onclick", "tambah_repository_parameter(0)")

    $('[name^="repository_sementara"]').val('')

    eval("code_editor_repository_sementara_code.setValue($( '[name=\"repository_sementara[code]\"]' ).val())")
    eval("code_editor_repository_sementara_code.clearSelection()")
}

function reset_repository_sementara() {
    clear_repository_sementara()

    $("#tambah_repository").removeClass('d-none')

    $("#edit_repository").addClass('d-none')
    $("#edit_simpan_repository").addClass('d-none')
}

function edit_simpan_repository_table(i) {
    objModul = $('#modul').serializeJSON()
    repository_sementara = objModul['repository_sementara']

    storage_parameter.update('repositories.' + i, repository_sementara)
    build_list_repository_tabel(storage_parameter.get('repositories'))

    simpanKeApi()
}

function editrepositoryFromTable(i) {
    $("#tambah_repository").addClass('d-none')
    
    $("#edit_repository").removeClass('d-none')
    $("#edit_simpan_repository").removeClass('d-none')

    $("#edit_repository").attr("onclick", "edit_list_repository_table(" + i + ")")
    $("#edit_simpan_repository").attr("onclick", "edit_simpan_repository_table(" + i + ")")

    fill_repository_sementara(storage_parameter.get('repositories.' + i))

    $('html, body').animate({
        scrollTop: $("#repository-tab").offset().top
    }, 1000, function () {
        $("#repository-tab").focus();
    });
}

function fill_repository_sementara(data) {
    $('[name="repository_sementara[name]"]').val(data.name)
    $('[name="repository_sementara[code]"]').val(data.code)

    eval("code_editor_repository_sementara_code.setValue($( '[name=\"repository_sementara[code]\"]' ).val())")
    eval("code_editor_repository_sementara_code.clearSelection()")

    build_repository_parameter(data.param)
}

function edit_list_repository_table(i) {
    $("#edit_repository").addClass('d-none')
    $("#edit_simpan_repository").addClass('d-none')

    $("#tambah_repository").removeClass('d-none')

    objModul = $('#modul').serializeJSON()
    repository_sementara = objModul['repository_sementara']

    storage_parameter.update('repositories.' + i, repository_sementara)
    build_list_repository_tabel(storage_parameter.get('repositories'))

    clear_repository_sementara()
}

function removerepositoryFromTable(i) {
    storage_parameter.remove('repositories.' + i)
    build_list_repository_tabel(storage_parameter.get('repositories'))
}