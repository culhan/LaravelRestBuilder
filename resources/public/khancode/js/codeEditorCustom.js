
/**
 * [createCodeEditor description]
 *
 * @param   {[type]}  nama_kolom_editor  [nama_kolom_editor description]
 * @param   {[type]}  nama_kolom         [nama_kolom description]
 * @param   {[type]}  type               [type description]
 *
 * @return  {[type]}                     [return description]
 */
function createCodeEditor(nama_kolom_editor,nama_kolom,type) {
    eval("code_editor_" + nama_kolom_editor + "= ace.edit(nama_kolom_editor, {mode: \"ace/mode/"+ type +"\",maxLines: 30,minLines: 5,wrap: true,autoScrollEditorIntoView: false, enableBasicAutocompletion: true, enableLiveAutocompletion: true, enableSnippets: true})")
    if(type == 'php') {
        eval("code_editor_" + i + ".getSession().setMode({path:\"ace/mode/php\", inline:true})")
    }
    eval("code_editor_" + nama_kolom_editor + ".getSession().on('change', function(e) {val_code = code_editor_" + nama_kolom_editor + ".getSession().getValue();$( '[name=\"" + nama_kolom + "\"]' ).val(val_code);})")
}

/**
 * [fillCodeEditor description]
 *
 * @param   {[type]}  nama_kolom_editor  [nama_kolom_editor description]
 * @param   {[type]}  nama_kolom         [nama_kolom description]
 * @param   {[type]}  value              [value description]
 *
 * @return  {[type]}                     [return description]
 */
function fillCodeEditor(nama_kolom_editor, nama_kolom, value) {
    $('[name="' + nama_kolom + '"]').val(value);    
    eval("code_editor_" + nama_kolom_editor + ".setValue($( '[name=\"" + nama_kolom + "\"]' ).val())")
    eval("code_editor_" + nama_kolom_editor + ".clearSelection()")
}