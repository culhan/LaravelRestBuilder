// khusus table route

storage_parameter.add("route");

$(document).ready(function() {
    fill_default_advanced_validation();
});

function build_route_tabel(data) {
    tableHtml =
        '<table id="example_route" class="table table-striped table-bordered" style="width:100%">';
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th>#</th>";
    tableHtml += "<th>Name</th>";
    tableHtml += "<th>Proses</th>";
    tableHtml += "<th>Action</th>";
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    iDataTable = 0;
    $.each(data, function(index_route, value_route) {
        index_route = parseInt(index_route);
        if (value_route["process"] == "list_data") {
            v_process = "Mengambil Banyak Data";
        }
        if (value_route["process"] == "single_data") {
            v_process = "Mengambil Satu Data";
        }
        if (value_route["process"] == "create_data") {
            v_process = "Menyimpan Data";
        }
        if (value_route["process"] == "update_data") {
            v_process = "Memperbaharui Data";
        }
        if (value_route["process"] == "delete_data") {
            v_process = "Menghapus Data";
        }
        if (value_route["process"] == "custom_data") {
            v_process = "Custom";
        }
        if (value_route["process"] == "system_data") {
            v_process = "Fungsi System";
        }
        if (value_route["process"] == "create_update_data") {
            v_process = "Menyimpan atau memperbaharui data";
        }
        tableHtml += "<tr>";
        tableHtml += "<td>";
        tableHtml += iDataTable + 1;
        tableHtml += "</td>";
        tableHtml += "<td>";
        tableHtml += value_route["name"];
        tableHtml += "</td>";
        tableHtml += "<td>";
        tableHtml += v_process;
        tableHtml += "</td>";
        tableHtml += '<td id="route_' + iDataTable + '">';
        tableHtml +=
            '<button data-placement="top" data-toggle="tooltip" title="Duplicate" type="button" class="btn btn-light float-right btn-sm" onclick="copyRouteFromTable(\'' +
            index_route +
            '\')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg x="0px" y="0px" width="15" height="15" viewBox="0 0 24 24" style=" fill:#000000;"><path d="M 4 2 C 2.895 2 2 2.895 2 4 L 2 18 L 4 18 L 4 4 L 18 4 L 18 2 L 4 2 z M 8 6 C 6.895 6 6 6.895 6 8 L 6 20 C 6 21.105 6.895 22 8 22 L 20 22 C 21.105 22 22 21.105 22 20 L 22 8 C 22 6.895 21.105 6 20 6 L 8 6 z M 8 8 L 20 8 L 20 20 L 8 20 L 8 8 z"></path></svg>';
        tableHtml += "</button>";
        tableHtml +=
            '<button type="button" class="btn btn-primary float-right btn-sm" onclick="editRouteFromTable(\'' +
            index_route +
            '\')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M6 0l-1 1 2 2 1-1-2-2zm-2 2l-4 4v2h2l4-4-2-2z"></path></svg>';
        tableHtml += "</button>";
        tableHtml +=
            '<button type="button" class="btn btn-danger float-right btn-sm" onclick="removeRouteFromTable(\'' +
            index_route +
            '\')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.406 0l-1.406 1.406.688.719 1.781 1.781-1.781 1.781-.688.719 1.406 1.406.719-.688 1.781-1.781 1.781 1.781.719.688 1.406-1.406-.688-.719-1.781-1.781 1.781-1.781.688-.719-1.406-1.406-.719.688-1.781 1.781-1.781-1.781-.719-.688z"></path></svg>';
        tableHtml += "</button>";
        tableHtml +=
            '<button type="button" class="btn btn-info float-right btn-sm route_' +
            iDataTable +
            '" onclick="moveRouteFromTable(' +
            (index_route + 1) +
            ", " +
            index_route +
            ')" style="margin-right: 15px;">';
        tableHtml +=
            '<svg class="icon" viewBox="0 0 8 8" width="100%" height="100%"><path d="M1.5 0l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z" transform="translate(0 1)"></path></svg>';
        tableHtml += "</button>";
        if (iDataTable != 0) {
            tableHtml +=
                '<button type="button" class="btn btn-success float-right btn-sm" onclick="moveRouteFromTable(' +
                (index_route - 1) +
                ", " +
                index_route +
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

    $("route_table").html(tableHtml);
    $(".route_" + (iDataTable - 1)).remove();
    $('[data-toggle="tooltip"]').tooltip({
        container: "body"
    });

    page_now = 0;
    page_length = 5;
    if (route_table != "") {
        page_now = route_table.page.info().page;
        page_length = route_table.page.info().length;
    }

    route_table = $("#example_route").DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });

    route_table.page
        .len(page_length)
        .page(page_now)
        .draw("page");

    if (page_now > route_table.page.info().pages - 1) {
        page_now--;
        route_table.page(page_now).draw("page");
    }
}

function build_fungsi_simpan_relasi_table(data) {
    tableHtml =
        '<table id="fungsi_simpan_relation" class="table table-striped table-bordered" style="width:100%">';
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th>#</th>";
    tableHtml += "<th>Name</th>";
    tableHtml += "<th>Type</th>";
    tableHtml += "<th>Menyimpan / Membuat data</th>";
    tableHtml += "<th>Nama Fungsi</th>";
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    iDataTable = 0;
    $.each(data, function(index_relation, value_relation) {
        if (!value_relation["simpan_data"] && !value_relation["membuat_data"]) {
            return;
        }
        if (value_relation["type"] == "belongs_to_many") {
            return;
        }
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
        tableHtml += v_type;
        tableHtml += "</td>";
        tableHtml += "<td>";
        if (value_relation["simpan_data"]) {
            tableHtml += "Menyimpan Data";
        } else if (value_relation["membuat_data"]) {
            tableHtml += "Membuat Data";
        }
        tableHtml += "</td>";
        tableHtml += "<td>";
        tableHtml +=
            '<input class="form-control" type="" name="route_sementara[fungsi_relasi][' +
            value_relation["name"] +
            ']" placeholder="default fungsi create">';
        tableHtml += "</td>";
        tableHtml += "</tr>";
        iDataTable++;
    });

    tableHtml += "<tbody>";
    tableHtml += "</table>";

    $("fungsi_relation_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: "body"
    });

    page_now = 0;
    page_length = 5;
    if (typeof fungsi_relation_table != "undefined") {
        page_now = fungsi_relation_table.page.info().page;
        page_length = fungsi_relation_table.page.info().length;
    }

    fungsi_relation_table = $("#fungsi_simpan_relation").DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });

    fungsi_relation_table.page
        .len(page_length)
        .page(page_now)
        .draw("page");

    if (page_now > fungsi_relation_table.page.info().pages - 1) {
        page_now--;
        fungsi_relation_table.page(page_now).draw("page");
    }
}

function show_hide_check_function_route(ele, i) {
    attribute_name_check = $(ele).attr("attr_check");
    if (!$(ele).is(":checked")) {
        $(
            "[name='route_sementara[fungsi_check_relasi]" +
                attribute_name_check +
                "']"
        ).prop("disabled", true);
        $(
            "[name='route_sementara[fungsi_check_relasi_disabled]" +
                attribute_name_check +
                "']"
        ).val(1);
    } else {
        $(
            "[name='route_sementara[fungsi_check_relasi]" +
                attribute_name_check +
                "']"
        ).prop("disabled", false);
        $(
            "[name='route_sementara[fungsi_check_relasi_disabled]" +
                attribute_name_check +
                "']"
        ).val(0);
    }
}

function show_check_function_route(attribute_name_check){
    attribute_name_check = '[' + attribute_name_check + ']'
    $(
        "[attr_check='" + attribute_name_check + "']"
    ).prop("checked", true);
    $(
        "[name='route_sementara[fungsi_check_relasi]" +
        attribute_name_check +
        "']"
    ).prop("disabled", false);
    $(
        "[name='route_sementara[fungsi_check_relasi_disabled]" +
        attribute_name_check +
        "']"
    ).val(0);
    $(
        "[attr_check='" + attribute_name_check + "']"
    ).prev().attr("aria-checked", true)
}

function hide_check_function_route(attribute_name_check) {
    attribute_name_check = '[' + attribute_name_check + ']'
    $(
        "[attr_check='" + attribute_name_check + "']"
    ).prop("checked", false);
    $(
        "[name='route_sementara[fungsi_check_relasi]" +
        attribute_name_check +
        "']"
    ).prop("disabled", true);
    $(
        "[name='route_sementara[fungsi_check_relasi_disabled]" +
        attribute_name_check +
        "']"
    ).val(1);
    $(
        "[attr_check='" + attribute_name_check +"']"
    ).prev().attr("aria-checked", false)
}

function build_fungsi_check_relasi_table(data) {
    tableHtml =
        '<table id="fungsi_check_relation" class="table table-striped table-bordered" style="width:100%">';
    tableHtml += "<thead>";
    tableHtml += "<tr>";
    tableHtml += "<th>#</th>";
    tableHtml += "<th>Name</th>";
    tableHtml += "<th>Type</th>";
    tableHtml += "<th>Nama Fungsi check</th>";
    tableHtml += "</tr>";
    tableHtml += "</thead>";
    tableHtml += "<tbody>";

    iDataTable = 0;
    $.each(data, function(index_relation, value_relation) {
        if (
            value_relation["type"] == "belongs_to" ||
            value_relation["type"] == "belongs_to_many"
        ) {
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

            if (value_relation["check_data_function"]) {
                defaultCheckFunction = value_relation["check_data_function"];
            } else {
                defaultCheckFunction = "getSingleData";
            }

            switch_check_data = "";
            switch_check_data +=
                '<div class="with-check"><input class="form-check-input check_function_route" attr_check="[' +
                value_relation["name"] +
                ']" type="checkbox" onchange="show_hide_check_function_route(this,' +
                iDataTable +
                ')"></div>';
            switch_check_data +=
                '<input type="text" name="route_sementara[fungsi_check_relasi_disabled][' +
                value_relation["name"] +
                ']" style="display:none" value=0>';

            tableHtml += "<tr>";
            tableHtml += "<td>";
            tableHtml += switch_check_data;
            tableHtml += "</td>";
            tableHtml += "<td>";
            tableHtml += value_relation["name"];
            tableHtml += "</td>";
            tableHtml += "<td>";
            tableHtml += v_type;
            tableHtml += "</td>";
            tableHtml += "<td>";
            tableHtml +=
                '<input class="form-control" type="" name="route_sementara[fungsi_check_relasi][' +
                value_relation["name"] +
                ']" placeholder="default fungsi ' +
                defaultCheckFunction +
                '">';
            tableHtml += "</td>";
            tableHtml += "</tr>";
            iDataTable++;
        }
    });

    tableHtml += "<tbody>";
    tableHtml += "</table>";

    $("fungsi_check_relation_table").html(tableHtml);
    $('[data-toggle="tooltip"]').tooltip({
        container: "body"
    });
    $(".check_function_route").switcher();

    page_now = 0;
    page_length = 5;
    if (typeof fungsi_check_relation_table != "undefined") {
        page_now = fungsi_check_relation_table.page.info().page;
        page_length = fungsi_check_relation_table.page.info().length;
    }

    fungsi_check_relation_table = $("#fungsi_check_relation").DataTable({
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });

    fungsi_check_relation_table.page
        .len(page_length)
        .page(page_now)
        .draw("page");

    if (page_now > fungsi_check_relation_table.page.info().pages - 1) {
        page_now--;
        fungsi_check_relation_table.page(page_now).draw("page");
    }
}

function tambah_route_table() {
    storage_parameter.add("route", $("#modul").serializeJSON().route_sementara);
    build_route_tabel(storage_parameter.get("route"));
    route_table.page("last").draw("page");

    clear_route_sementara();
}

function edit_simpan_route_table(i) {
    objModul = $("#modul").serializeJSON();
    route_sementara = objModul["route_sementara"];

    storage_parameter.update("route." + i, route_sementara);
    build_route_tabel(storage_parameter.get("route"));

    simpanKeApi();
}

function fill_default_advanced_validation() {

    defaultCode = "";
    if (project_lang == "php" ){
        defaultCode += "//$this->model::validate($dataRecord, [\n";
        defaultCode += '\t//"nama_param"	=>	"validasi"\n';
        defaultCode += "//]);\n";
        defaultCode += "//\\KhanCode\\LaravelBaseRest\\Helpers::set_error($validator->errors()->toArray());";
    } else if (project_lang == "golang") {
        defaultCode += "// start validation \n"
        defaultCode += "data_json, _ := json.Marshal(data)\n"
        defaultCode += "data_byte:= []byte(string(data_json))\n"
        defaultCode += "type BusinessTypeCreateValidation struct {\n"
            defaultCode += "\tName string` json:\"name\" validate:\"required\"`\n"
            defaultCode += "\tJumlah int` json:\"jumlah\" validate:\"required\"`\n"
        defaultCode += "}\n\n"
        defaultCode += "errorState:= models.IsValid(data_byte, new (BusinessTypeCreateValidation))\n"
        defaultCode += "if (errorState != nil) {\n"
            defaultCode += "\treturn nil, errorState\n"
        defaultCode += "}\n"
	    defaultCode += "// finish validation\n"
    }

    fillAceGenerate({ name_cols: 'route_sementara[advanced_validation_code]', code: defaultCode })
    // $('[name="route_sementara[advanced_validation_code]"]').val(defaultCode);
    // eval(
    //     "code_editor_route_sementara_advanced_validation_code.setValue($( '[name=\"route_sementara[advanced_validation_code]\"]' ).val())"
    // );
    // eval(
    //     "code_editor_route_sementara_advanced_validation_code.clearSelection()"
    // );
}

function fill_route_sementara(data) {
    param_fill = 0;
    validasi_fill = 0;
    dataFilter_fill = 0;
    middleware_fill = 0;

    $(".route_param_route_sementara").html("");
    $(".route_route_sementara").html("");
    $(".data_filter_sementara").html("");

    $("[onclick^=\"tambah_route_parameter('route_sementara'\"]").attr(
        "onclick",
        "tambah_route_parameter('route_sementara',0)"
    );
    $("[onclick^=\"tambah_validasi('route_sementara'\"]").attr(
        "onclick",
        "tambah_validasi('route_sementara',0)"
    );
    $('[onclick^="tambah_data_filter_parameter"]').attr(
        "onclick",
        "tambah_data_filter_parameter(0)"
    );

    if (data.advanced_validation) {
        $('[name="route_sementara[advanced_validation]"]')
            .prop("checked", true)
            .change();
    } else {
        $('[name="route_sementara[advanced_validation]"]')
            .prop("checked", false)
            .change();
    }

    if( data.traits ) {
        build_traits('traits_sementara', data.traits);
        $(".route_traits").collapse("show");
    }else {
        $(".route_traits").collapse("hide");
    }

    if (data.advanced_validation_code) {
        fillAceGenerate({ name_cols: 'route_sementara[advanced_validation_code]', code: data.advanced_validation_code })
        // $('[name="route_sementara[advanced_validation_code]"]').val(
        //     data.advanced_validation_code
        // );
        // eval(
        //     "code_editor_route_sementara_advanced_validation_code.setValue($( '[name=\"route_sementara[advanced_validation_code]\"]' ).val())"
        // );
        // eval(
        //     "code_editor_route_sementara_advanced_validation_code.clearSelection()"
        // );
        if (data.advanced_validation) {
            validasi_fill++;
        }
    } else {
        fill_default_advanced_validation();
    }

    if (!data["middleware"]) {
        $("[name^='route_sementara[middleware_parameter]'][type='text']").val(
            ""
        );
        $("[name^='route_sementara[middleware]'][type='checkbox']")
            .prop("checked", false)
            .change();
    } else {
        $("[name^='route_sementara[middleware_parameter]'][type='text']").val(
            ""
        );
        $("[name^='route_sementara[middleware]'][type='checkbox']")
            .prop("checked", false)
            .change();
        $.each(data["middleware"], function(
            index_middleware,
            value_middleware
        ) {
            // tambah_route_middleware('route_sementara',(index_middleware*1))
            // $( "[name='route_sementara[middleware]["+index_middleware+"]']" ).val(value_middleware).change()

            if (value_middleware.indexOf(":") > -1) {
                v_mid = value_middleware.split(":");
                value_middleware = v_mid[0];
                if (!data["middleware_parameter"]) {
                    data["middleware_parameter"] = {};
                }
                data["middleware_parameter"][value_middleware] = v_mid[1];
            }

            $(
                "[name^='route_sementara[middleware]'][value='" +
                    value_middleware +
                    "']"
            )
                .prop("checked", true)
                .change();
            if (data["middleware_parameter"]) {
                if (data["middleware_parameter"][value_middleware]) {
                    $(
                        "[name^='route_sementara[middleware_parameter][" +
                            value_middleware +
                            "]']"
                    ).val(data["middleware_parameter"][value_middleware]);
                }
            }
            middleware_fill++;
        });
    }

    data_fungsi_relasi_exist = 0;
    if (data["fungsi_relasi"]) {
        $.each(data["fungsi_relasi"], function(i_frelasi, v_frelasi) {
            if (v_frelasi != "") {
                data_fungsi_relasi_exist++;
                $(
                    "[name='route_sementara[fungsi_relasi][" + i_frelasi + "]']"
                ).val(v_frelasi);
            }
        });
    }

    data_fungsi_check_relasi_exist = 0;
    if (data["fungsi_check_relasi"]) {
        $.each(data["fungsi_check_relasi"], function(i_frelasi, v_frelasi) {
            if (v_frelasi != "") {
                data_fungsi_check_relasi_exist++;
                $(
                    "[name='route_sementara[fungsi_check_relasi][" +
                        i_frelasi +
                        "]']"
                ).val(v_frelasi);
            }
        });
    }

    if (data["fungsi_check_relasi_disabled"]) {
        $.each(data["fungsi_check_relasi_disabled"], function (i_frelasi, v_frelasi) {
            if( v_frelasi == 0) {
                show_check_function_route(i_frelasi)
            }else {
                hide_check_function_route(i_frelasi)
            }
            
        });
    }

    if (!data['custom_check_single_data']) {
        fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })
    }else {
        $(".route_parameter_custom_check_single_data").collapse("show");
    }

    $.each(data, function(index_route_sementara, value_route_sementara) {
        if (
            index_route_sementara != "param" ||
            index_route_sementara != "validation" ||
            index_route_sementara != "middleware" ||
            index_route_sementara != "middleware_parameter" ||
            index_route_sementara != "lock" ||
            index_route_sementara != "dataFilter" ||
            index_route_sementara != "tanpa_route"
        ) {
            $("[name='route_sementara[" + index_route_sementara + "]']")
                .val(value_route_sementara)
                .change();
        }
        if (index_route_sementara == "lock") {
            $(".lock_route_sementara")
                .prop("checked", true)
                .change();
            $("[name='route_sementara[lock]']").val(value_route_sementara);
        }
        if (index_route_sementara == "param") {
            $.each(value_route_sementara, function(index_param, value_param) {
                tambah_route_parameter("route_sementara", index_param * 1);

                if (value_param.name) {
                    $(
                        "[name='route_sementara[param][" +
                            index_param +
                            "][name]']"
                    )
                        .val(value_param.name)
                        .change();
                } else {
                    $(
                        "[name='route_sementara[param][" +
                            index_param +
                            "][name]']"
                    )
                        .val(value_param)
                        .change();
                }

                if (value_param.class) {
                    $(
                        "[name='route_sementara[param][" +
                            index_param +
                            "][class]']"
                    ).val(value_param.class);
                }

                param_fill++;
            });
        }
        if (index_route_sementara == "validation") {
            $.each(value_route_sementara, function(
                index_validation,
                value_validation
            ) {
                tambah_validasi("route_sementara", index_validation * 1);
                $(
                    "[name='route_sementara[validation][" +
                        index_validation +
                        "][name]']"
                )
                    .val(value_validation["name"])
                    .change();
                $(
                    "[name='route_sementara[validation][" +
                        index_validation +
                        "][statement]']"
                )
                    .val(value_validation["statement"])
                    .change();
                validasi_fill++;
            });
        }
        if (index_route_sementara == "dataFilter") {
            $.each(value_route_sementara, function(
                index_dataFilter,
                value_dataFilter
            ) {
                tambah_data_filter_parameter(index_dataFilter * 1);
                $(
                    "[name='route_sementara[dataFilter][" +
                        index_dataFilter +
                        "][name]']"
                )
                    .val(value_dataFilter["name"])
                    .change();
                $(
                    "[name='route_sementara[dataFilter][" +
                        index_dataFilter +
                        "][default]']"
                )
                    .val(value_dataFilter["default"])
                    .change();
                dataFilter_fill++;
            });
        }

        if (
            index_route_sementara == "custom_code_before" ||
            index_route_sementara == "custom_code_after" 
        ) {
            name_sementara_code = index_route_sementara;
            eval(
                "code_editor_route_sementara_" + name_sementara_code + "_.setValue($( '[name=\"route_sementara[" + name_sementara_code + "]\"]' ).val())"
            );
            eval("code_editor_route_sementara_" + name_sementara_code + "_.clearSelection()");
            
            // eval(
            //     "code_editor_" +
            //         name_sementara_code +
            //         "_route_sementara.setValue($( '[name=\"route_sementara[" +
            //         name_sementara_code +
            //         "]\"]' ).val())"
            // );
            // eval(
            //     "code_editor_" +
            //         name_sementara_code +
            //         "_route_sementara.clearSelection()"
            // );
        }

        if ( index_route_sementara == "custom_check_single_data" ) {
            fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: value_route_sementara })
        }

        if (index_route_sementara == "custom_function") {
            fillAceGenerate({ name_cols: 'route_sementara[custom_function]', code: value_route_sementara })
            // eval(
            //     "code_editor_process_route_sementara.setValue($( '[name=\"route_sementara[custom_function]\"]' ).val())"
            // );
            // eval("code_editor_process_route_sementara.clearSelection()");
        }

        if (index_route_sementara == "system_function") {
            eval(
                "code_editor_process_route_sementara.setValue($( '[name=\"route_sementara[system_function]\"]' ).val())"
            );
            eval("code_editor_process_route_sementara.clearSelection()");
        }
    });

    $(".route_fungsi_check_relasi_collapse").collapse("hide");
    if (data_fungsi_check_relasi_exist > 0) {
        $(".route_fungsi_check_relasi_collapse ").collapse("show");
    }

    $(".route_relasi").collapse("hide");
    if (data_fungsi_relasi_exist > 0) {
        $(".route_relasi ").collapse("show");
    }

    $(".route_middleware_route_sementara ").collapse("hide");
    if (middleware_fill > 0) {
        $(".route_middleware_route_sementara ").collapse("show");
    }

    $(".route_validasi ").collapse("hide");
    if (validasi_fill > 0) {
        $(".route_validasi ").collapse("show");
    }    

    $(".route_parameter_tambahan ").collapse("hide");
    if (param_fill > 0) {
        $(".route_parameter_tambahan ").collapse("show");
    }

    $(".data-filter").collapse("hide");
    if (dataFilter_fill > 0) {
        $(".data-filter").collapse("show");
    }

    if (data.tanpa_route == 1 || data.process == "system_data") {
        $(".tanpa_route")
            .prop("checked", true)
            .change();
    } else {
        $(".tanpa_route")
            .prop("checked", false)
            .change();
    }

    if (data.fungsi_check_relasi_disabled) {
        $.each(data.fungsi_check_relasi_disabled, function(i, v) {
            if (v == "1") {
                $(".check_function_route_[" + i + "]")
                    .prop("checked", false)
                    .change();
            }
        });
    }

    dataOld = {};
}

function clear_route_sementara() {
    $("[name='route_sementara[name]']").val("");
    $("[name='route_sementara[prefix]']")
        .val("admin/v1/{locale}/")
        .change();
    $("[name='route_sementara[method]']")
        .val("get")
        .change();
    $("[name='route_sementara[process]']")
        .val("list_data")
        .change();
    $(".lock_route_sementara")
        .prop("checked", false)
        .change();
    $(".check_function_route")
        .prop("checked", true)
        .change();
    $(".tanpa_route")
        .prop("checked", false)
        .change();
    $("[name='route_sementara[lock]']").val("");

    $(".route_param_route_sementara").html("");
    $(".route_route_sementara").html("");
    $(".data_filter_sementara").html("");
    $(".route_traits_sementara").html("");    

    $("[onclick^=\"tambah_route_parameter('route_sementara'\"]").attr(
        "onclick",
        "tambah_route_parameter('route_sementara',0)"
    );
    $("[onclick^=\"tambah_validasi('route_sementara'\"]").attr(
        "onclick",
        "tambah_validasi('route_sementara',0)"
    );
    $('[onclick^="tambah_data_filter_parameter"]').attr(
        "onclick",
        "tambah_data_filter_parameter(0)"
    );
    $('[onclick^="tambah_traits"]').attr(
        "onclick",
        "tambah_traits('traits_sementara',0)"
    );

    $("[onclick^=\"tambah_route_middleware('route_sementara'\"]").attr(
        "onclick",
        "tambah_route_middleware('route_sementara',0)"
    );
    $("[name^='route_sementara[middleware]']")
        .prop("checked", false)
        .change();
    $("[name^='route_sementara[middleware_parameter]']").val("");

    $(".route_middleware_route_sementara ").collapse("hide");
    $(".route_parameter_tambahan").collapse("hide");
    $(".route_validasi").collapse("hide");
    $(".data-filter").collapse("hide");
    $(".route_relasi").collapse("hide");
    $(".route_traits").collapse("hide");
    $(".route_fungsi_check_relasi_collapse").collapse("hide");
    jumlah_data_filter = 0;

    $('[name="route_sementara[custom_code_before]"]').val("");
    eval(
        "code_editor_route_sementara_custom_code_before_.setValue($( '[name=\"route_sementara[custom_code_before]\"]' ).val())"
    );
    eval("code_editor_route_sementara_custom_code_before_.clearSelection()");

    $('[name="route_sementara[custom_code_after]"]').val("");
    eval(
        "code_editor_route_sementara_custom_code_after_.setValue($( '[name=\"route_sementara[custom_code_after]\"]' ).val())"
    );
    eval("code_editor_route_sementara_custom_code_after_.clearSelection()");

    $('[name="route_sementara[advanced_validation]"]')
        .prop("checked", false)
        .change();

    $("[name^='route_sementara[fungsi_relasi]']").val("");
    $("[name^='route_sementara[fungsi_check_relasi]']").val("");

    fill_default_advanced_validation();

    $(".route_parameter_custom_check_single_data").collapse("hide");

    fillAceGenerate({ name_cols: 'route_sementara[custom_check_single_data]', code: single_data_code })

    dataOld = {};
}

function reset_route_sementara() {
    $(".edit_route").addClass("d-none");
    $(".edit_simpan_route").addClass("d-none");

    $(".tambah_route").removeClass("d-none");

    clear_route_sementara();
}

function removeRouteFromTable(i) {
    storage_parameter.remove("route." + i);
    build_route_tabel(storage_parameter.get("route"));
}

function editRouteFromTable(i) {
    $(".tambah_route").addClass("d-none");

    $(".edit_route").removeClass("d-none");
    $(".edit_simpan_route").removeClass("d-none");

    $(".edit_route").attr("onclick", "edit_route_table(" + i + ")");
    $(".edit_simpan_route").attr(
        "onclick",
        "edit_simpan_route_table(" + i + ")"
    );

    fill_route_sementara(storage_parameter.get("route." + i));

    $("html, body").animate(
        {
            scrollTop: $("#table_name").offset().top
        },
        1000,
        function() {
            $("#table_name").focus();
        }
    );
}

function edit_route_table(i) {
    $(".edit_route").addClass("d-none");
    $(".edit_simpan_route").addClass("d-none");

    $(".tambah_route").removeClass("d-none");

    objModul = $("#modul").serializeJSON();
    route_sementara = objModul["route_sementara"];

    storage_parameter.update("route." + i, route_sementara);
    build_route_tabel(storage_parameter.get("route"));

    clear_route_sementara();
}

function moveRouteFromTable(old_index, new_index) {
    old_data = storage_parameter.get("route." + old_index);
    new_data = storage_parameter.get("route." + new_index);

    storage_parameter.update("route." + old_index, new_data);
    storage_parameter.update("route." + new_index, old_data);

    build_route_tabel(storage_parameter.get("route"));
}

function copyRouteFromTable(index) {
    $(".tooltip").tooltip("hide");
    clone = JSON.parse(JSON.stringify(storage_parameter.get("route." + index)));
    storage_parameter.add("route", clone);
    length_route = Object.keys(storage_parameter.get("route")).length;
    new_name = clone.name + " (copy of " + clone.name + ")";
    storage_parameter.update("route." + (length_route - 1) + ".name", new_name);

    build_route_tabel(storage_parameter.get("route"));
    route_table.page("last").draw("page");
}

var prefix_param = [];

function prefixChange(ele) {
    $(
        "." +
            $(ele)
                .attr("name")
                .replace(/[\[\]']+/g, "")
    ).html("api/" + ele.value + objModul["name"] + "/");

    delay(function() {
        txt = ele.value;
        regExp = /\{([^}]+)\}/g;
        matches = txt.match(regExp);

        param_current_data = $("#modul").serializeJSON().route_sementara.param;

        param_current = [];
        param_current_class = [];
        $.each(param_current_data, function(
            index_param_current,
            value_param_current
        ) {
            param_current.push(value_param_current.name);
            param_current_class.push(value_param_current.class);
        });

        $(".route_param_route_sementara").html("");
        $("[onclick^=\"tambah_route_parameter('route_sementara'\"]").attr(
            "onclick",
            "tambah_route_parameter('route_sementara',0)"
        );
        $(".route_parameter_tambahan ").collapse("show");

        prefix_param = [];
        if (matches) {
            for (i = 0; i < matches.length; i++) {
                str = matches[i];
                prefix_param.push(str.substring(1, str.length - 1));
            }
        }

        $.each(prefix_param, function(index_param, value_param) {
            index_current = param_current.indexOf(value_param);
            if (index_current > -1) {
                param_current.splice(index_current, 1);
            }
        });

        param_route_list = arrayUnique(prefix_param.concat(param_current));

        $.each(param_route_list, function(index_param, value_param) {
            tambah_route_parameter("route_sementara", index_param * 1);
            $("[name='route_sementara[param][" + index_param + "][name]']")
                .val(value_param)
                .change();

            if (param_current_class[index_param]) {
                $(
                    "[name='route_sementara[param][" +
                        index_param +
                        "][class]']"
                ).val(param_current_class[index_param]);
            }
        });
    }, 500);
}
// khusus table route

// khusus tabel middleware        
function build_tabel_middleware(json) {
    
    tabel_middleware = ''

    tabel_middleware    +=   '<table id="table_middleware" class="table table-striped table-bordered" style="width:100%">'
    tabel_middleware    +=   '<thead>'
        tabel_middleware    +=   '<tr>'
        tabel_middleware    +=   '<th scope="col">#</th>'
        tabel_middleware    +=   '<th scope="col"></th>'
        tabel_middleware    +=   '<th scope="col">Nama</th>'
        tabel_middleware    +=   '<th scope="col">Param</th>'
        tabel_middleware    +=   '</tr>'
    tabel_middleware    +=   '</thead>'
    tabel_middleware    +=   '<tbody>'

    $.each(json,function(k,v) {
        
        tabel_middleware    +=  '<tr>'
            tabel_middleware    +=  '<th scope="row">'+(k+1)+'</th>'
            tabel_middleware    +=  '<td>'
                tabel_middleware    +=  '<div class="form-check form-check-inline with-check">'
                    tabel_middleware    +=  '<input class="form-check-input" type="checkbox" name="route_sementara[middleware][]" value="'+v+'">'
                tabel_middleware    +=  '</div>'
            tabel_middleware    +=  '</td>'
            tabel_middleware    +=  '<td>'+v+'</td>'
            tabel_middleware    +=  '<td>'                        
                tabel_middleware    +=  '<input name="route_sementara[middleware_parameter]['+v+']" type="text" class="form-control" disabled>'
            tabel_middleware    +=  '</td>'
        tabel_middleware    +=  '</tr>'

    })

        tabel_middleware    +=  '</tbody>'
    tabel_middleware    +=  '</table>'

    $( '.route_middleware_route_sementara' ).html(tabel_middleware)

    $( "[name^=\"route_sementara[middleware]\"]" ).switcher();

    $( "[name^=\"route_sementara[middleware]\"]" ).change(function(){                
        name = "route_sementara[middleware_parameter]["+$(this).val()+"]"
        if( $(this).is(':checked') ) {
            $( "[name='"+name+"']" ).prop('disabled',false)
        }else {
            $( "[name='"+name+"']" ).prop('disabled',true)
        }
    })
}