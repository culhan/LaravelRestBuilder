// khusus table relasi    

storage_parameter.add('list_index');

function build_list_index_tabel(data) {

    tableHtml = '<table id="example_listindex" class="table table-striped table-bordered" style="width:100%">'
        tableHtml += '<thead>'
            tableHtml += '<tr>'
                tableHtml += '<th>#</th>'
                tableHtml += '<th>Name</th>'
                tableHtml += '<th>Action</th>'
            tableHtml += '</tr>'
        tableHtml += '</thead>'
        tableHtml += '<tbody>'                

        iDataTable=0                
        $.each(data, function( index_relation, value_relation ) {
            index_relation = parseInt(index_relation)                   

            tableHtml += '<tr>'
                tableHtml += '<td>'
                    tableHtml += (iDataTable+1)
                tableHtml += '</td>'
                tableHtml += '<td>'
                    tableHtml += value_relation['name']
                tableHtml += '</td>'
                tableHtml += '<td id="route_'+iDataTable+'">'                    
                    tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editIndexFromTable(\''+index_relation+'\')" style="margin-right: 15px;">'
                    tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
                    tableHtml += '</button>'
                    tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeIndexFromTable(\''+index_relation+'\')" style="margin-right: 15px;">'
                    tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
                    tableHtml += '</button>'                    
                tableHtml += '</td>'
            tableHtml += '</tr>'
            iDataTable++
        })

        tableHtml += '<tbody>'
    tableHtml += '</table>'

    $( "listindex_table" ).html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    page_now = 0;
    page_length = 5;
    if(typeof listindex_table != 'undefined') {
        page_now = listindex_table.page.info().page
        page_length = listindex_table.page.info().length
    }

    listindex_table = $( "#example_listindex" ).DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });
    
    listindex_table.page.len( page_length ).page( page_now ).draw( 'page' );

    if(page_now > (listindex_table.page.info().pages-1)) {                
        page_now--
        listindex_table.page( page_now ).draw( 'page' );
    }            
}

function tambah_index_column_parameter(k) {
    
    index_column_html = ''
    index_column_html += '<div class="row mb-3" >'
        index_column_html += '<div class="col-sm-3" style="padding-top:5px;">'
            index_column_html += '<label>'+ (k+1) +'.&nbsp;&nbsp;Nama Kolom</label>'
        index_column_html += '</div>'
        index_column_html += '<div class="col-sm">'
            index_column_html += '<input type="" class="form-control autocomplete_column" placeholder="nama kolom" name="index_sementara[column]['+ k +']">'
        index_column_html += '</div>'
    index_column_html += '<button type="button" class="btn btn-danger float-right btn-sm btn-delete" onclick="remove_index_kolom_parameter_route('+ k +')">x</button>'
    index_column_html += '</div>'
    
    $(".index_column_sementara").append(index_column_html)
    $("[onclick^=\"tambah_index_column_parameter\"]").attr("onclick","tambah_index_column_parameter("+ (k+1) +")")

    $(".autocomplete_column").focus(function () {

        var listColumn = []
        objModul = $('#modul').serializeJSON()
        $.each(objModul['column'], function (index_column, value_column) {
            listColumn.push(value_column['name'])
        })

        $(".autocomplete_column").autocomplete({
            source: listColumn,
            selectFirst: true,
            minLength: 0
        });

    });

}

function remove_index_kolom_parameter_route(k) {
    objModul = $('#modul').serializeJSON()
    splice_multilevel_array(objModul, 'index_sementara.column.' + k)
    build_index_kolom(objModul['index_sementara']['column'])
}

function build_index_kolom(data) {
    $(".index_column_sementara").html('')    
    $("[onclick^=\"tambah_index_column_parameter\"]").attr("onclick", "tambah_index_column_parameter(0)")
    i_index=0
    $.each(data, function (index, value) {        
        tambah_index_column_parameter(i_index)
        $("[name=\"index_sementara[column][" + i_index +"]\"]").val(value)
        i_index++
    });
}

function tambah_list_index_table() {
    storage_parameter.add('list_index', $('#modul').serializeJSON().index_sementara)
    build_list_index_tabel(storage_parameter.get('list_index'))
    listindex_table.page( 'last' ).draw( 'page' );

    clear_index_sementara()
} 

function clear_index_sementara() {
    $('[name="index_sementara[name]"]').val('')
    $(".index_column").collapse('hide')
    build_index_kolom([])
}

function editIndexFromTable(i) {
    $("#tambah_index").addClass('d-none')
    $("#edit_index").removeClass('d-none')
    $("#edit_index").attr("onclick","edit_list_index_table("+i+")")

    fill_index_sementara(storage_parameter.get('list_index.'+i))

    $('html, body').animate({
        scrollTop: $( "#listindex-tab" ).offset().top
    }, 1000, function() {
        $( "#listindex-tab" ).focus();
    });
}

function fill_index_sementara(data) {
    $('[name="index_sementara[name]"]').val(data.name)
    $(".index_column").collapse('show')
    build_index_kolom(data.column)
}

function edit_list_index_table(i) {
    $("#edit_index").addClass('d-none')
    $( "#tambah_index" ).removeClass('d-none')

    objModul = $('#modul').serializeJSON()
    index_sementara = objModul['index_sementara']

    storage_parameter.update('list_index.' + i, index_sementara)
    build_list_index_tabel(storage_parameter.get('list_index'))

    clear_index_sementara()
}

function removeIndexFromTable(i) {
    storage_parameter.remove('list_index.' + i)
    build_list_index_tabel(storage_parameter.get('list_index'))
}