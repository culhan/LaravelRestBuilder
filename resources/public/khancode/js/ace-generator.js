/**
 * 
 */
function aceGenerate({ name_cols = '', maxLines = 30, minLines = 5, default_code = '', mode = project_lang } = {}) {
    mode = ((mode == 'php') ? 'phpinline' : mode)
    mode = ((mode == 'go') ? 'golang' : mode)
    nama_kolom_fungsi = name_cols
    nama_kolom_fungsi_var = nama_kolom_fungsi.split('[').join('_')
    nama_kolom_fungsi_var = nama_kolom_fungsi_var.split(']').join('_')
    
    // eval("code_editor_process_" + i + "= ace.edit('route_text_'+i, {mode: \"ace/mode/php\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
    // eval("code_editor_process_" + i + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
    // eval("code_editor_process_" + i + ".getSession().on('change', function(e) {val_code = code_editor_process_" + i + ".getSession().getValue();$( '[name=\"" + name_route + "[custom_function]\"]' ).val(val_code);})")
    
    eval("code_editor_" + nama_kolom_fungsi_var + "= ace.edit('tab_" + nama_kolom_fungsi + "', {mode: \"ace/mode/" + mode + "\", maxLines: " + maxLines + ",minLines: " + minLines + ",wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true })")
    if (mode == 'phpinline') {
        eval("code_editor_" + nama_kolom_fungsi_var + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
    }
    eval("code_editor_" + nama_kolom_fungsi_var + ".getSession().on('change', function(e) {val_code = code_editor_" + nama_kolom_fungsi_var + ".getSession().getValue();$( '[name=\"" + nama_kolom_fungsi + "\"]' ).val(val_code);})")

    if (default_code != '' && default_code) {
        console.log(default_code)
        if (IsJsonString(default_code) ) {
            $('[name="' + nama_kolom_fungsi + '"]').val(JSON.stringify(JSON.parse(default_code), null, 4));
        } else {
            $('[name="' + nama_kolom_fungsi + '"]').val(default_code);
        }
        
        eval(
            "code_editor_" + nama_kolom_fungsi_var + ".setValue($( '[name=\"" + nama_kolom_fungsi + "\"]' ).val())"
        );
        eval(
            "code_editor_" + nama_kolom_fungsi_var + ".clearSelection()"
        );
    }
}

/**
 * 
 * @param {*} param0 
 */
function fillAceGenerate({ name_cols = '', code = '' } = {}) {
    nama_kolom_fungsi = name_cols
    nama_kolom_fungsi_var = nama_kolom_fungsi.split('[').join('_')
    nama_kolom_fungsi_var = nama_kolom_fungsi_var.split(']').join('_')

    mode = eval(
        "code_editor_" +
        nama_kolom_fungsi_var +
        ".getSession().getMode().$id"
    );

    if (IsJsonString(code) && mode != 'ace/mode/json' ) {
        $('[name="' + nama_kolom_fungsi + '"]').val(JSON.stringify(JSON.parse(code), null, 4));
    }else{
        $('[name="' + nama_kolom_fungsi + '"]').val(code);
    }

    eval(
        "code_editor_" +
        nama_kolom_fungsi_var +
        ".setValue($( '[name=\"" +
        nama_kolom_fungsi +
        "\"]' ).val())"
    );
    eval(
        "code_editor_" +
        nama_kolom_fungsi_var +
        ".clearSelection()"
    );
    
}

/**
 * 
 * @param {*} url 
 */
function getParamsFromUrl(url) {
    url = decodeURI(url);
    if (typeof url === 'string') {
        let params = url.split('?');
        if (params[1] ){
            let eachParamsArr = params[1].split('&');
            let obj = {};
            if (eachParamsArr && eachParamsArr.length) {
                ik = 0;
                eachParamsArr.map(param => {
                    let keyValuePair = param.split('=')
                    let key = ik;
                    let value = {
                        "key":keyValuePair[0],
                        "value":keyValuePair[1],
                    }
                    obj[key] = value;
                    ik++
                })
            }
            return obj;
        }
    }
}

/**
 * 
 * @param {*} url 
 */
function getUrlPathFromUrl(url) {
    url = decodeURI(url);
    if (typeof url === 'string') {
        let params = url.split('?');
        if (params[0] ){
            return params[0]
        }
        return ''
    }
}