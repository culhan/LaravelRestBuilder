var jumlah_data_filter = 0

function tambah_data_filter_parameter(k) {

    jumlah_data_filter++

    data_filter_html = ''
    data_filter_html += '<div class="row mb-3" >'
        data_filter_html += '<div class="col-sm-3" style="padding-top:5px;">'
            data_filter_html += '<label>' + (k + 1) + '.&nbsp;&nbsp;Nama Kolom</label>'
        data_filter_html += '</div>'
        data_filter_html += '<div class="col-sm">'
            data_filter_html += '<input type="" class="form-control autocomplete_column" placeholder="nama kolom" name="route_sementara[dataFilter][' + k + '][name]">'
        data_filter_html += '</div>'
        data_filter_html += '<div class="col-sm-1" style="padding-top:5px;">'
            data_filter_html += '<label>&nbsp;&nbsp;Default</label>'
        data_filter_html += '</div>'
        data_filter_html += '<div class="col-sm">'
            data_filter_html += '<input type="" class="form-control" placeholder="default" name="route_sementara[dataFilter][' + k + '][default]">'
        data_filter_html += '</div>'
        data_filter_html += '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_data_filter_parameter_route(' + k + ')">x</button>'
    data_filter_html += '</div>'
   
    $(".data_filter_sementara").append(data_filter_html)
    $("[onclick^=\"tambah_data_filter_parameter\"]").attr("onclick", "tambah_data_filter_parameter(" + (k + 1) + ")")

    $(".autocomplete_column").focus(function () {

        var listColumn = []
        objModul = $('#modul').serializeJSON()
        $.each(objModul['column'], function (data_filter, value_column) {
            listColumn.push(value_column['name'])
        })

        $(".autocomplete_column").autocomplete({
            source: listColumn,
            selectFirst: true,
            minLength: 0
        });

    });
}

function remove_data_filter_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'route_sementara.dataFilter.' + k)
    build_data_filter(objModul['route_sementara']['dataFilter'])
}

function build_data_filter(data) {
    $(".data_filter_sementara").html('')
    $("[onclick^=\"tambah_data_filter_parameter\"]").attr("onclick", "tambah_data_filter_parameter(0)")
    i_index = 0
    jumlah_data_filter = 0
    $.each(data, function (index, value) {
        tambah_data_filter_parameter(i_index)        
        $("[name=\"route_sementara[dataFilter][" + i_index + "][name]\"]").val(value['name'])
        $("[name=\"route_sementara[dataFilter][" + i_index + "][default]\"]").val(value['default'])
        i_index++
    });
}

function tambah_data_import_semua() {  
    i_index = jumlah_data_filter
    data_filter_sudah_ada = []
    data_hidden = array_flip(storage_parameter.get('hidden'))
    for (let index = 0; index < i_index; index++) {
        val_data = $("[name=\"route_sementara[dataFilter][" + index + "][name]\"]").val()
        data_filter_sudah_ada[val_data] = val_data
    }    
    $.each(objColumn, function (index, value) {
        if (!objForbiddenCOlumn[value['name']] && !data_filter_sudah_ada[value['name']] && !data_hidden[value['name']] && value['name']!='id') {
            tambah_data_filter_parameter(i_index)
            $("[name=\"route_sementara[dataFilter][" + i_index + "][name]\"]").val(value['name'])        
            i_index++
        }
    });
}