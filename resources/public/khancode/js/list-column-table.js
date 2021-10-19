// khusus modul tabel
storage_parameter.add("hidden");

function ubahColumnTableAll(e){
    $("[onchange*='ubahHiddenInTable']").prop('checked', $(e).is(":checked")).change()
}

function build_modul_tabel(data, forbidden_column_name) {
    tableHtml =
        '<table id="example" class="table table-striped table-bordered" style="width:100%">';
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th>#</th>";
    tableHtml += "<th>Name</th>";
    tableHtml += "<th>Hide/Show" +'<div class="float-right with-all"><input class="form-check-input hidden_col" type="checkbox" checked onchange="ubahColumnTableAll(this)"></div>'+"</th>";
    tableHtml += "<th>Action</th>";
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    iDataTable = 0;
    $.each(data, function(index_column_function, value_column_function) {
        index_column_function = parseInt(index_column_function);
        if (!forbidden_column_name[value_column_function["name"]]) {
            tableHtml += "<tr>";
            tableHtml += "<td>";
            tableHtml += iDataTable + 1;
            tableHtml += "</td>";
            tableHtml += "<td>";
            tableHtml += value_column_function["name"];
            tableHtml += "</td>";

            tableHtml += "<td>";
            // if (value_column_function["name"] == "com_id") {
            //     tableHtml += '<div class="form-check form-check-inline">';
            //     tableHtml +=
            //         '<input class="form-check-input hidden_col" type="checkbox" onchange="ubahHiddenInTable(this,' +
            //         index_column_function +
            //         ')" >';
            //     tableHtml += "</div>";
            // } else 
            if (
                storage_parameter.find(
                    "hidden",
                    value_column_function["name"]
                ) == -1
            ) {
                tableHtml += '<div class="form-check form-check-inline">';
                tableHtml +=
                    '<input class="form-check-input hidden_col" type="checkbox" checked onchange="ubahHiddenInTable(this,' +
                    index_column_function +
                    ')" >';
                tableHtml += "</div>";
            } else {
                tableHtml += '<div class="form-check form-check-inline">';
                tableHtml +=
                    '<input class="form-check-input hidden_col" type="checkbox" onchange="ubahHiddenInTable(this,' +
                    index_column_function +
                    ')" >';
                tableHtml += "</div>";
            }
            tableHtml += "</td>";

            tableHtml += '<td id="modul_kolom_' + iDataTable + '">';
            tableHtml +=
                '<button type="button" class="btn btn-primary float-right btn-sm" onclick="ubahColumnModulTable(\'' +
                index_column_function +
                '\')" style="margin-right: 15px;">';
            tableHtml +=
                '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>';
            tableHtml += "</button>";
            tableHtml +=
                '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeColumnModulTable(\'' +
                index_column_function +
                '\')" style="margin-right: 15px;">';
            tableHtml +=
                '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>';
            tableHtml += "</button>";
            tableHtml +=
                '<button type="button" class="btn btn-info float-right btn-sm" onclick="moveColumnModulTable(' +
                (index_column_function + 1) +
                ", " +
                index_column_function +
                ')" style="margin-right: 15px;">';
            tableHtml +=
                '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.5 0l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z" transform="translate(0 1)"></path></svg>';
            tableHtml += "</button>";
            if (iDataTable != 0) {
                tableHtml +=
                    '<button type="button" class="btn btn-success float-right btn-sm" onclick="moveColumnModulTable(' +
                    (index_column_function - 1) +
                    ", " +
                    index_column_function +
                    ')" style="margin-right: 15px;">';
                tableHtml +=
                    '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M4 0l-4 4 1.5 1.5 2.5-2.5 2.5 2.5 1.5-1.5-4-4z" transform="translate(0 1)"></path></svg>';
                tableHtml += "</button>";
            }
            tableHtml += "</td>";
            tableHtml += "</tr>";
            iDataTable++;
        }
    });

    tableHtml += "<tbody>";
    tableHtml += "</table>";

    $("modul_table").html(tableHtml);
    $(".hidden_col").switcher();
    $("#modul_kolom_" + (iDataTable - 1) + " .btn-info").remove();

    page_now = 0;
    page_length = 5;
    if (modul_table != "") {
        page_now = modul_table.page.info().page;
        page_length = modul_table.page.info().length;
    }

    modul_table = $("#example").DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        rowReorder: true,
        columnDefs: [{ width: "1%", targets: 0 }]
    });

    modul_table.on("row-reorder", function(e, diff, edit) {
        position = replaceString(
            "modul_kolom_",
            "",
            $(edit.triggerRow.node())
                .find("[id^=modul_kolom]")
                .attr("id")
        );
        for (var i = 0, ien = diff.length; i < ien; i++) {
            beforeData = parseInt(diff[i].oldPosition);
            afterData = parseInt(diff[i].newPosition);
            editData = parseInt(position);

            if (editData == beforeData) {
                moveColumnModulTable(beforeData, afterData);
            }
        }
    });

    modul_table.page
        .len(page_length)
        .page(page_now)
        .draw("page");

    if (page_now > modul_table.page.info().pages - 1) {
        page_now--;
        modul_table.page(page_now).draw("page");
    }
}

function removeColumnModulTable(i) {
    objModul = $("#modul").serializeJSON();
    column_sementara = objModul["column"][i];
    key_hidden = storage_parameter.find("hidden", column_sementara["name"]);
    storage_parameter.remove("hidden." + key_hidden);

    removeColumn(i);
    build_modul_tabel(objColumn, objForbiddenCOlumn);

    if (column_sementara["name"] == "com_id") {
        $("#with_companystamp").val(0);
    }
}

function moveColumnModulTable(i, y) {
    moveColumn(i, y);
    build_modul_tabel(objColumn, objForbiddenCOlumn);
}

function tambah_kolom_modul_table_click() {
    tambah_kolom_click();
    objModul = $("#modul").serializeJSON();
    column_sementara = objModul["column_sementara"];

    update_data_storage_hidden_column(column_sementara["name"]);

    $.each(column_sementara, function(
        index_column_sementara,
        value_column_sementara
    ) {
        $(
            "[name='column[" +
                (index_kolom_terakhir_dibuat - 1) +
                "][" +
                index_column_sementara +
                "]']"
        )
            .val(value_column_sementara)
            .change();
    });

    objModul = $("#modul").serializeJSON();
    objColumn = objModul["column"];
    build_modul_tabel(objColumn, objForbiddenCOlumn);

    $("[name='column_sementara[name]']").val("");
    $("[name='column_sementara[default]']").val("");
    $("[name='column_sementara[comment]']").val("");
    $("[name='column_sementara[hidden]']")
        .prop("checked", true)
        .change();
    $("[name='column_sementara[type]']")
        .val("integer")
        .change();
    $("[name='column_sementara[nullable]']")
        .val(1)
        .change();

    modul_table.page("last").draw("page");
    // $( ".row_modul_table_"+(index_kolom_terakhir_dibuat-1) ).removeClass( "d-none" );
}

function ubahColumnModulTable(i) {
    $("#add_kolom").addClass("d-none");
    $("#ubah_kolom").removeClass("d-none");
    $("#ubah_kolom").attr("onclick", "ubah_kolom_modul_table_click(" + i + ")");

    $.each(objColumn[i], function(
        index_column_sementara,
        value_column_sementara
    ) {
        $("[name='column_sementara[" + index_column_sementara + "]']")
            .val(value_column_sementara)
            .change();
    });

    $("[name='column_sementara[hidden]']")
        .prop("checked", false)
        .change();
    if (storage_parameter.find("hidden", objColumn[i]["name"]) == -1) {
        $("[name='column_sementara[hidden]']")
            .prop("checked", true)
            .change();
    }

    $("html, body").animate(
        {
            scrollTop: $("[name='column_sementara[name]']").offset().top
        },
        1000,
        function() {
            $("[name='column_sementara[name]']").focus();
        }
    );
}

function ubah_kolom_modul_table_click(i) {
    objModul = $("#modul").serializeJSON();
    column_sementara = objModul["column_sementara"];

    update_data_storage_hidden_column(column_sementara["name"]);

    $.each(objModul["column_sementara"], function(
        index_column_sementara,
        value_column_sementara
    ) {
        $("[name='column[" + i + "][" + index_column_sementara + "]']")
            .val(value_column_sementara)
            .change();
    });
    objModul = $("#modul").serializeJSON();
    objColumn = objModul["column"];
    build_modul_tabel(objColumn, objForbiddenCOlumn);

    reset_column_sementara_table()
}

function reset_column_sementara_table(){
    $("[name='column_sementara[name]']").val("");
    $("[name='column_sementara[default]']").val("");
    $("[name='column_sementara[comment]']").val("");
    $("[name='column_sementara[hidden]']")
        .prop("checked", true)
        .change();
    $("[name='column_sementara[type]']")
        .val("integer")
        .change();
    $("[name='column_sementara[nullable]']")
        .val(1)
        .change();

    $("#add_kolom").removeClass("d-none");
    $("#ubah_kolom").addClass("d-none");
}

function update_data_storage_hidden_column(column_sementara_name) {
    key_hidden = storage_parameter.find("hidden", column_sementara_name);
    if (column_sementara["hidden"]) {
        // jika di check, hapus data jika ada
        if (key_hidden != -1) {
            storage_parameter.remove("hidden." + key_hidden);
        }
    } else {
        // jika tidak di check, tambah data jika belum ada
        if (key_hidden == -1) {
            storage_parameter.add("hidden", column_sementara_name);
        }
    }
}

function ubahHiddenInTable(ele, i) {
    if ($(ele).is(":checked")) {
        key_hidden = storage_parameter.find("hidden", objModul.column[i].name);
        storage_parameter.remove("hidden." + key_hidden);
    } else {
        storage_parameter.add("hidden", objModul.column[i].name);
    }
}

function ubahHiddenRelationInTable(ele, i) {
    if ($(ele).is(":checked")) {
        key_hidden = storage_parameter.find(
            "hidden_relation",
            storage_parameter.get("relation." + i + ".name")
        );
        storage_parameter.remove("hidden_relation." + key_hidden);
    } else {
        storage_parameter.add(
            "hidden_relation",
            storage_parameter.get("relation." + i + ".name")
        );
    }
}
