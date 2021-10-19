// khusus table relasi    

storage_parameter.add('casts');

$(document).ready(function () {
    $(".autocomplete_column").focus(function () {

        var listColumn = []
        objModul = $('#modul').serializeJSON()
        $.each(objModul['column'], function (cast_column, value_column) {
            listColumn.push(value_column['name'])
        })

        $(".autocomplete_column").autocomplete({
            source: listColumn,
            selectFirst: true,
            minLength: 0
        });

    });

    $(".autocomplete_data_cast").focus(function () {

        $(".autocomplete_data_cast").autocomplete({
            source: [
                'integer',
                'real',
                'float',
                'double',
                'decimal: <digits>',
                'string',
                'boolean',
                'object',
                'array',
                'collection',
                'date',
                'datetime',
                'timestamp',
            ],
            selectFirst: true,
            minLength: 0
        });

    });
});

function build_list_cast_tabel(data) {

    tableHtml = '<table id="example_listcast" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'
    tableHtml += '<th>Kolom</th>'
    tableHtml += '<th>Tipe Data</th>'
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (cast_relation, value_relation) {
        cast_relation = parseInt(cast_relation)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['column']
        tableHtml += '</td>'
        tableHtml += '<td>'
        tableHtml += value_relation['data_type']
        tableHtml += '</td>'
        tableHtml += '<td id="route_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editcastFromTable(\'' + cast_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removecastFromTable(\'' + cast_relation + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("listcast_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if (typeof listcast_table != 'undefined') {
        page_now = listcast_table.page.info().page
        page_length = listcast_table.page.info().length
    }

    listcast_table = $("#example_listcast").DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });

    listcast_table.page.len(page_length).page(page_now).draw('page');

    if (page_now > (listcast_table.page.info().pages - 1)) {
        page_now--
        listcast_table.page(page_now).draw('page');
    }
}

function remove_cast_kolom_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'cast_sementara.column.' + k)
    build_cast_kolom(objModul['cast_sementara']['column'])
}

function tambah_list_cast_table() {
    storage_parameter.add(
        "casts",
        $("#modul").serializeJSON().cast_sementara
    );
    build_list_cast_tabel(storage_parameter.get('casts'))
    listcast_table.page('last').draw('page');

    clear_cast_sementara()
}

function clear_cast_sementara() {
    $('[name^="cast_sementara"]').val('')
}

function editcastFromTable(i) {
    $("#tambah_cast").addClass('d-none')
    $("#edit_cast").removeClass('d-none')
    $("#edit_cast").attr("onclick", "edit_list_cast_table(" + i + ")")

    fill_cast_sementara(storage_parameter.get('casts.' + i))

    $('html, body').animate({
        scrollTop: $("#listcast-tab").offset().top
    }, 1000, function () {
        $("#listcast-tab").focus();
    });
}

function fill_cast_sementara(data) {
    $('[name="cast_sementara[column]"]').val(data.column)
    $('[name="cast_sementara[data_type]"]').val(data.data_type)    
}

function edit_list_cast_table(i) {
    $("#edit_cast").addClass('d-none')
    $("#tambah_cast").removeClass('d-none')

    objModul = $('#modul').serializeJSON()
    cast_sementara = objModul['cast_sementara']

    storage_parameter.update('casts.' + i, cast_sementara)
    build_list_cast_tabel(storage_parameter.get('casts'))

    clear_cast_sementara()
}

function removecastFromTable(i) {
    storage_parameter.remove('casts.' + i)
    build_list_cast_tabel(storage_parameter.get('casts'))
}