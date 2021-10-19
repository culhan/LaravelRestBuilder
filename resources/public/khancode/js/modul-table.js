function ubah_type_kolom(data,i) {
    $( "[name='column["+i+"][precision]']" ).remove()
    $( "[name='column["+i+"][scale]']" ).remove()
    $( "[name='column["+i+"][length]']" ).remove()
    if(data.value == 'decimal') {
        html_decimal_detail = 
            '<input type="" class="form-control" placeholder="precision (default = 8)" name="column['+i+'][precision]">'+
            '<input type="" class="form-control" placeholder="scale (default = 2)" name="column['+i+'][scale]">';
        $(data).parent().append(html_decimal_detail);
    }else if(data.value == 'string') {
        html_decimal_detail = '<input type="" class="form-control" placeholder="length (default = 191)" name="column['+i+'][length]">'
        $(data).parent().append(html_decimal_detail);
    }
}

function ubah_type_kolom_modul_table(data) {
    $( "[name='column_sementara[precision]']" ).remove()
    $( "[name='column_sementara[scale]']" ).remove()
    $( "[name='column_sementara[length]']" ).remove()
    if(data.value == 'decimal') {
        html_decimal_detail = 
            '<input type="" class="form-control" placeholder="precision (default = 8)" name="column_sementara[precision]">'+
            '<input type="" class="form-control" placeholder="scale (default = 2)" name="column_sementara[scale]">';
        $(data).parent().append(html_decimal_detail);
    }else if(data.value == 'string') {
        html_decimal_detail = '<input type="" class="form-control" placeholder="length (default = 191)" name="column_sementara[length]">'
        $(data).parent().append(html_decimal_detail);
    }
}

function tambah_kolom(jumlah_kolom,type) {
    nama_kolom = jumlah_kolom
    window.jumlah_kolom = jumlah_kolom
    window.jumlah_kolom++
    jumlah_kolom = window.jumlah_kolom

    if(typeof type === 'undefined') {
        type = ''
        window.index_kolom_terakhir_dibuat = jumlah_kolom
        if(nama_kolom!=0) {
            $( ".d-none_"+(nama_kolom-1) ).removeClass( "d-none" );
        }
    }

    button = ''
    if(jumlah_kolom != 1) {
        button = '<button type="button" class="btn btn-success" onclick="moveColumn('+nama_kolom+', '+(nama_kolom-1)+')">up</button>'
    }            

    html_new_kolom = 
        '<div class="row_modul_table_'+nama_kolom+' d-none">'+
            '<div class="row '+type+'">'+
                '<label for="column1" class="col-sm-12">'+
                    '<b>Kolom '+jumlah_kolom+'</b>'+
                    '<button type="button" class="btn btn-danger float-right col-sm-1 btn-sm" onclick="removeColumn(\''+nama_kolom+'\')" style="margin-right: 15px;">Hapus</button>'+
                    '<div class="btn-group btn-group-sm float-right col-sm-2" role="group">'+
                        button+
                        '<button type="button" class="btn btn-info d-none d-none_'+nama_kolom+'" onclick="moveColumn('+(nama_kolom+1)+', '+nama_kolom+')">down</button>'+
                    '</div>'+
                '</label>'+
            '</div>'+
            '<div class="container '+type+'">'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-2" style="padding-top:5px;">'+
                        '<label>Name </label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<input name="column['+nama_kolom+'][name]" type="text" class="form-control" placeholder="nama kolom">'+
                    '</div>'+
                '</div>'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-2" style="padding-top:5px;">'+
                        '<label>Type </label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<div class="input-group">'+
                            '<select class="form-control" onchange="ubah_type_kolom(this,'+nama_kolom+')" name="column['+nama_kolom+'][type]">'+
                                '<option value="increment">Increment</option>'+
                                '<option value="bigIncrement">Big Increment</option>'+ 
                                '<option value="integer" selected="selected">Integer</option>'+
                                '<option value="bigint">Big Integer</option>'+
                                '<option value="smallInteger">Small Integer</option>'+
                                '<option value="tinyInteger">Tiny Integer</option>'+
                                '<option value="boolean">Boolean</option>'+
                                '<option value="decimal">Decimal</option>'+
                                '<option value="datetime">Datetime</option>'+
                                '<option value="date">Date</option>'+
                                '<option value="timestamp">Timestamp</option>'+
                                '<option value="string">String</option>'+
                                '<option value="char">Char</option>'+
                                '<option value="text">Text</option>'+
                                '<option value="time">Time</option>'+                                        
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-2" style="padding-top:5px;">'+
                        '<label>Default </label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<textarea class="form-control" name="column['+nama_kolom+'][default]" rows="2"></textarea>'+                                
                    '</div>'+
                '</div>'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-2" style="padding-top:5px;">'+
                        '<label>Comment </label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<textarea class="form-control" name="column['+nama_kolom+'][comment]" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="row mb-3">'+
                    '<div class="col-sm-2" style="padding-top:5px;">'+
                        '<label>Nullable </label>'+
                    '</div>'+
                    '<div class="col-sm">'+
                        '<select class="form-control" name="column['+nama_kolom+'][nullable]">'+
                            '<option value="1">Yes</option>'+
                            '<option value="0">No</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>'+
    '';            
    $( "list_kolom" ).append(html_new_kolom);
}

function set_value_kolom(i,data) {
    $( '[name="column['+i+'][name]"]' ).val(data['name']);
    if(data['type']) {
        $( '[name="column['+i+'][type]"]' ).val(data['type']).change();
    }
    if(data['length']) {
        $( '[name="column['+i+'][length]"]' ).val(data['length']);
    }
    if(data['precision']) {
        $( '[name="column['+i+'][precision]"]' ).val(data['precision']);
    }
    if(data['scale']) {
        $( '[name="column['+i+'][scale]"]' ).val(data['scale']);
    }
    if(data['default']) {
        $( '[name="column['+i+'][default]"]' ).val(data['default']);
    }
    if(data['comment']) {
        $( '[name="column['+i+'][comment]"]' ).val(data['comment']);
    }
    if(data['nullable']) {
        $( '[name="column['+i+'][nullable]"]' ).val(data['nullable']).change();
    }else {
        $( '[name="column['+i+'][nullable]"]' ).val('0').change();
    }
}