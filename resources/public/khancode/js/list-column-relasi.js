// khusus table relasi

storage_parameter.add("relation");

storage_parameter.add("hidden_relation");

function build_relation_tabel(data) {
    tableHtml =
        '<table id="example_relation" class="table table-striped table-bordered" style="width:100%">';
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th>#</th>";
    tableHtml += "<th>Name</th>";
    tableHtml += "<th>Show/Hide</th>";
    tableHtml += "<th>Type</th>";
    tableHtml += "<th>Action</th>";
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    iDataTable = 0;
    $.each(data, function(index_relation, value_relation) {
        index_relation = parseInt(index_relation);
        if (value_relation["type"] == "belongs_to") {
            v_type = "Belongs To";
        }
        if (value_relation["type"] == "has_one") {
            v_type = "Has One";
        }
        if (value_relation["type"] == "has_many") {
            v_type = "Has Many";
        }
        if (value_relation["type"] == "belongs_to_many") {
            v_type = "Belongs To Many";
        }

        tableHtml += "<tr>";
        tableHtml += "<td>";
        tableHtml += iDataTable + 1;
        tableHtml += "</td>";
        tableHtml += "<td>";
        tableHtml += value_relation["name"];
        tableHtml += "</td>";

        tableHtml += "<td>";
        if (
            storage_parameter.find("hidden_relation", value_relation["name"]) ==
            -1
        ) {
            tableHtml += '<div class="form-check form-check-inline">';
            tableHtml +=
                '<input class="form-check-input hidden_col_relasi" type="checkbox" checked onchange="ubahHiddenRelationInTable(this,' +
                iDataTable +
                ')" >';
            tableHtml += "</div>";
        } else {
            tableHtml += '<div class="form-check form-check-inline">';
            tableHtml +=
                '<input class="form-check-input hidden_col_relasi" type="checkbox" onchange="ubahHiddenRelationInTable(this,' +
                iDataTable +
                ')" >';
            tableHtml += "</div>";
        }
        tableHtml += "</td>";

        tableHtml += "<td>";
        tableHtml += v_type;
        tableHtml += "</td>";
        tableHtml += '<td id="route_' + iDataTable + '">';
        tableHtml +=
            '<button data-placement="top" data-toggle="tooltip" title="Duplicate" type="button" class="btn btn-light float-right btn-sm" onclick="copyRelationFromTable(\'' +
            index_relation +
            '\')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg x="0px" y="0px" width="15" height="15" viewBox="0 0 24 24" style=" fill:#000000;"><path d="M 4 2 C 2.895 2 2 2.895 2 4 L 2 18 L 4 18 L 4 4 L 18 4 L 18 2 L 4 2 z M 8 6 C 6.895 6 6 6.895 6 8 L 6 20 C 6 21.105 6.895 22 8 22 L 20 22 C 21.105 22 22 21.105 22 20 L 22 8 C 22 6.895 21.105 6 20 6 L 8 6 z M 8 8 L 20 8 L 20 20 L 8 20 L 8 8 z"></path></svg>';
        tableHtml += "</button>";
        tableHtml +=
            '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editRelationFromTable(\'' +
            index_relation +
            '\')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>';
        tableHtml += "</button>";
        tableHtml +=
            '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeRelationFromTable(\'' +
            index_relation +
            '\')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>';
        tableHtml += "</button>";
        tableHtml +=
            '<button type="button" class="btn btn-info float-right btn-sm" onclick="moveRelationFromTable(' +
            (index_relation + 1) +
            ", " +
            index_relation +
            ')" style="margin-right: 15px;" id="relation_' +
            iDataTable +
            '" >';
        tableHtml +=
            '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.5 0l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z" transform="translate(0 1)"></path></svg>';
        tableHtml += "</button>";
        if (iDataTable != 0) {
            tableHtml +=
                '<button type="button" class="btn btn-success float-right btn-sm" onclick="moveRelationFromTable(' +
                (index_relation - 1) +
                ", " +
                index_relation +
                ')" style="margin-right: 15px;">';
            tableHtml +=
                '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M4 0l-4 4 1.5 1.5 2.5-2.5 2.5 2.5 1.5-1.5-4-4z" transform="translate(0 1)"></path></svg>';
            tableHtml += "</button>";
        }
        tableHtml += "</td>";
        tableHtml += "</tr>";
        iDataTable++;
    });

    tableHtml += "<tbody>";
    tableHtml += "</table>";

    $("relation_table").html(tableHtml);
    $(".hidden_col_relasi").switcher();
    $("#relation_" + (iDataTable - 1) + ".btn-info").remove();
    $('[data-toggle="tooltip"]').tooltip({
        container: "body"
    });

    page_now = 0;
    page_length = 5;
    if (typeof relation_table != "undefined") {
        page_now = relation_table.page.info().page;
        page_length = relation_table.page.info().length;
    }

    relation_table = $("#example_relation").DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });

    relation_table.page
        .len(page_length)
        .page(page_now)
        .draw("page");

    if (page_now > relation_table.page.info().pages - 1) {
        page_now--;
        relation_table.page(page_now).draw("page");
    }
    console.log(data)
    build_fungsi_simpan_relasi_table(data);
    build_fungsi_check_relasi_table(data);
}

function tambah_relation_table() {
    storage_parameter.add(
        "relation",
        $("#modul").serializeJSON().relation.relation_sementara
    );
    build_relation_tabel(storage_parameter.get("relation"));
    relation_table.page("last").draw("page");

    clear_relation_sementara();
}

function moveRelationFromTable(old_index, new_index) {
    old_data = storage_parameter.get("relation." + old_index);
    new_data = storage_parameter.get("relation." + new_index);

    storage_parameter.update("relation." + old_index, new_data);
    storage_parameter.update("relation." + new_index, old_data);

    build_relation_tabel(storage_parameter.get("relation"));
}

function copyRelationFromTable(index) {
    $(".tooltip").tooltip("hide");
    clone = JSON.parse(
        JSON.stringify(storage_parameter.get("relation." + index))
    );
    storage_parameter.add("relation", clone);
    length_relation = Object.keys(storage_parameter.get("relation")).length;
    new_name = clone.name + " (copy of " + clone.name + ")";
    storage_parameter.update(
        "relation." + (length_relation - 1) + ".name",
        new_name
    );

    build_relation_tabel(storage_parameter.get("relation"));
    relation_table.page("last").draw("page");
}

function removeRelationFromTable(i) {
    storage_parameter.remove("relation." + i);
    build_relation_tabel(storage_parameter.get("relation"));
}

function fill_relation_sementara(data) {
    $(".relasi_type_relation_sementara").val(data.type);
    ubah_type_relasi(
        $(".relasi_type_relation_sementara").get(0),
        "relation_sementara",
        0
    );
    fill_kolom_relasi("relation_sementara", data, 0);
}

function edit_simpan_relation_table(i) {
    objModul = $("#modul").serializeJSON();
    relation_sementara = objModul["relation"]["relation_sementara"];

    storage_parameter.update("relation." + i, relation_sementara);
    build_relation_tabel(storage_parameter.get("relation"));

    simpanKeApi();
}

function editRelationFromTable(i) {
    $("#tambah_relation").addClass("d-none");

    $("#edit_relation").removeClass("d-none");
    $("#edit_simpan_relation").removeClass("d-none");

    $("#edit_relation").attr("onclick", "edit_relation_table(" + i + ")");
    $("#edit_simpan_relation").attr(
        "onclick",
        "edit_simpan_relation_table(" + i + ")"
    );

    fill_relation_sementara(storage_parameter.get("relation." + i));

    $("html, body").animate(
        {
            scrollTop: $("#relasi-tab").offset().top
        },
        1000,
        function() {
            $("#relasi-tab").focus();
        }
    );
}

function clear_relation_sementara() {
    $(".relasi_type_relation_sementara").val("belongs_to");
    ubah_type_relasi(
        $(".relasi_type_relation_sementara").get(0),
        "relation_sementara",
        0
    );
}

function reset_relation_sementara() {
    clear_relation_sementara();

    $("#tambah_relation").removeClass("d-none");

    $("#edit_relation").addClass("d-none");
    $("#edit_simpan_relation").addClass("d-none");
}

function edit_relation_table(i) {
    $("#edit_relation").addClass("d-none");
    $("#edit_simpan_relation").addClass("d-none");
    $("#tambah_relation").removeClass("d-none");

    objModul = $("#modul").serializeJSON();
    relation_sementara = objModul["relation"]["relation_sementara"];

    storage_parameter.update("relation." + i, relation_sementara);
    build_relation_tabel(storage_parameter.get("relation"));

    clear_relation_sementara();
}

function to_advanced_validation(e) {
    if ($(e).is(":checked")) {
        $(" .normal_validation ").hide();
        $(" .advanced_validation ").show();
    } else {
        $(" .normal_validation ").show();
        $(" .advanced_validation ").hide();
    }
}
