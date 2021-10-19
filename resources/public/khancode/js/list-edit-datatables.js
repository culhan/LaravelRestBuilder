; (function ($) {
    data_index = '';
    $.fn.switcher = function (filter, e) {

        this.each(function (i, val) {
            var $checkbox = $(val).hide(),
                $switcher = $(document.createElement('div'))
                    .addClass('ui-switcher')
                    .attr('aria-checked', $checkbox.is(':checked'));

            if ('radio' === $checkbox.attr('type')) {
                $switcher.attr('data-name', $checkbox.attr('name'));
            }

            toggleSwitch = function (e) {
                if (e.target.type === undefined) {
                    $checkbox.trigger(e.type);
                }
                $switcher.attr('aria-checked', $checkbox.is(':checked'));
                if ('radio' === $checkbox.attr('type')) {
                    $('.ui-switcher[data-name=' + $checkbox.attr('name') + ']')
                        .not($switcher.get(0))
                        .attr('aria-checked', false);
                }
            };

            $switcher.on('click', toggleSwitch);
            $checkbox.on('change', toggleSwitch);

            $switcher.insertBefore($checkbox);
        });

    };

    $('a[data-toggle="tab"]').on('click', function (e) {
        data_index = $(e.target).attr("index");
    });

})(jQuery);

function build_tabel(index, data) {
    columns = list_table[index];
    tab_columns = [
        { "width" : "1px" },
        null
    ];

    tableHtml = '<table id="table_list_'+index+'" class="table table-striped table-bordered" style="width:100%">'
    tableHtml += '<thead>'
    tableHtml += '<tr>'
    tableHtml += '<th>#</th>'

    $.each(columns, function (key, value) {
        if(value['show'] == 1) {
            tableHtml += '<td>'
            tableHtml += value['name']
            tableHtml += '</td>'

            tab_columns.push(null)
        }
    })
    
    tableHtml += '<th>Action</th>'
    tableHtml += '</tr>'
    tableHtml += '</thead>'
    tableHtml += '<tbody>'

    iDataTable = 0
    $.each(data, function (key, value) {
        key = parseInt(key)

        tableHtml += '<tr>'
        tableHtml += '<td>'
        tableHtml += (iDataTable + 1)
        tableHtml += '</td>'

        $.each(columns, function (key2, value2) {
            if(value2['show'] == 1) {
                tableHtml += '<td>'
                tableHtml += value[value2['attribute']]
                tableHtml += '</td>'
            }
        })
        
        tableHtml += '<td id="modul_'+index+'_' + iDataTable + '">'
        tableHtml += '<button type="button" class="btn btn-primary float-right btn-sm" onclick="changeFromTable(\'' + index + '\', \'' + key + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeFromTable(\'' + index + '\', \'' + key + '\')" style="margin-right: 15px;">'
        tableHtml += '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>'
        tableHtml += '</button>'
        tableHtml += '</td>'
        tableHtml += '</tr>'
        iDataTable++
    })

    tableHtml += '<tbody>'
    tableHtml += '</table>'

    $("modul_"+index).html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })

    if( typeof listTableData == 'undefined' ) {
        listTableData = [];
    }

    page_now = 0;
    page_length = 5;
    if (typeof listTableData[index] != 'undefined') {
        page_now = listTableData[index].page.info().page
        page_length = listTableData[index].page.info().length
    }

    listTableData[index] = $("#table_list_"+index).DataTable({
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        rowReorder: true,
        bAutoWidth: false,
        columns: tab_columns
    });

    listTableData[index].on("row-reorder", function (e, diff, edit) {
        position = replaceString(
            "modul_"+index+"_",
            "",
            $(edit.triggerRow.node())
                .find("[id^=modul_"+index+"_]")
                .attr("id")
        );
        for (var i = 0, ien = diff.length; i < ien; i++) {
            beforeData = parseInt(diff[i].oldPosition);
            afterData = parseInt(diff[i].newPosition);
            editData = parseInt(position);

            if (editData == beforeData) {
                move_cols(index, beforeData, afterData);
            }
        }
    });
    
    listTableData[index].page.len(page_length).page(page_now).draw('page');

    if (page_now > (listTableData[index].page.info().pages - 1)) {
        page_now--
        listTableData[index].page(page_now).draw('page');
    }

    listTableData[index].page('last').draw('page');
    
    // custom function after_build_tabel
    if (typeof window['after_build_table_' + index] === 'function' ) {
        window['after_build_table_' + index](data)
    }
    
}

function toArray(obj) {
    if( typeof obj === 'undefined' ) {
        return []
    }

    if( obj instanceof Object ) {                
        data = []
        i = 0
        $.each(obj, function( index_obj, value_obj ) {
            data[i] = value_obj
            i++
        })
        obj = data
    }
    return obj
}

function move(arr, old_index, new_index) {
    arr = toArray(arr)
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);  
    return arr;
}

function move_cols(index, old_index, new_index) {
    storage_parameter.update(index, move(storage_parameter.get(index), old_index, new_index) )
    build_tabel(index, storage_parameter.get(index))
}

function add(index) {
    storage_parameter.add(index, $('#modul').serializeJSON()[index+'_sementara'])
    build_tabel(index, storage_parameter.get(index))

    clear_sementara(index)
}

function clear_sementara(index) {
    columns = list_table[index];
    $.each(columns, function (key2, value2) {
        if(value2['type'] == 'text') {
            $('[name="'+index+'_sementara['+value2['attribute']+']"]').val('')
        }

        if(value2['type'] == 'ace') {
            nama_kolom_fungsi = index+"_sementara["+value2['attribute']+"]"
            nama_kolom_fungsi_var = nama_kolom_fungsi.split('[').join('_')
            nama_kolom_fungsi_var = nama_kolom_fungsi_var.split(']').join('_')
            
            $('[name="'+index+'_sementara['+value2['attribute']+']"]').val('')
            eval("code_editor_"+nama_kolom_fungsi_var+".setValue($( '[name=\""+nama_kolom_fungsi+"\"]' ).val())")
            eval("code_editor_"+nama_kolom_fungsi_var+".clearSelection()")
        }
    })
}

function changeFromTable(index, key) {
    fill(index, storage_parameter.get(index+'.' + key))

    $("[onclick^=\"add(\'"+index+"\')\"]").addClass('d-none')

    $("[onclick^=\"change(\'"+index+"\'\"]").removeClass('d-none')
    $("[onclick^=\"changeAndSave(\'"+index+"\'\"]").removeClass('d-none')

    $("[onclick^=\"change(\'"+index+"\'\"]").attr("onclick", "change(\'"+index+"\',"+key+")")
    $("[onclick^=\"changeAndSave(\'"+index+"\'\"]").attr("onclick", "changeAndSave(\'"+index+"\',"+key+")")

    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 1000, function () {
        $("body").focus();
    });
}

function removeFromTable(index, key) {
    storage_parameter.remove(index+'.' + key)
    build_tabel(index, storage_parameter.get(index))
}

function change(index, key) {
    $("[onclick^=\"add(\'"+index+"\')\"]").removeClass('d-none')

    $("[onclick^=\"change(\'"+index+"\'\"]").addClass('d-none')
    $("[onclick^=\"changeAndSave(\'"+index+"\'\"]").addClass('d-none')

    storage_parameter.update(index+'.' + key, $('#modul').serializeJSON()[index+'_sementara'])
    build_tabel(index, storage_parameter.get(index))

    clear_sementara(index)
}

function changeAndSave(index, key) {
    change(index, key)
    simpanKeApi()
}

function reset_cols(index) {
    clear_sementara(index)

    $("[onclick^=\"add(\'" + index + "\')\"]").removeClass('d-none')

    $("[onclick^=\"change(\'" + index + "\'\"]").addClass('d-none')
    $("[onclick^=\"changeAndSave(\'" + index + "\'\"]").addClass('d-none')
}

function fill( index, data ){

    columns = list_table[index];
    $.each(columns, function (key2, value2) {
        if(value2['type'] == 'text') {
            $('[name="'+index+'_sementara['+value2['attribute']+']"]').val(data[value2['attribute']])
        }

        if(value2['type'] == 'ace') {
            nama_kolom_fungsi = index+"_sementara["+value2['attribute']+"]"
            nama_kolom_fungsi_var = nama_kolom_fungsi.split('[').join('_')
            nama_kolom_fungsi_var = nama_kolom_fungsi_var.split(']').join('_')
            
            $('[name="'+index+'_sementara['+value2['attribute']+']"]').val(data[value2['attribute']])
            eval("code_editor_"+nama_kolom_fungsi_var+".setValue($( '[name=\""+nama_kolom_fungsi+"\"]' ).val())")
            eval("code_editor_"+nama_kolom_fungsi_var+".clearSelection()")
        }
    })

}