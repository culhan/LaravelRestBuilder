// khusus storage
var items = {};

var storage_parameter = {
    add(index, value) {
        if (index.indexOf(".") !== -1) {
            index = index.split(".");
            arr1 = "";
            $.each(index, function(index_index, value_index) {
                arr1 += '["' + value_index + '"]';
                if (!eval("window.items" + arr1)) {
                    eval("window.items" + arr1 + "={}");
                }
            });

            if (typeof value != "undefined") {
                lengthObj = eval(
                    "Object.keys(window.items" + arr1 + ").length"
                );
                eval("window.items" + arr1 + "[" + lengthObj + "] = value");
            }
        } else {
            if (!window.items[index]) {
                window.items[index] = {};
            }

            if (typeof value != "undefined") {
                lengthObj = Object.keys(window.items[index]).length;
                window.items[index][lengthObj] = value;
            }
        }

        return true;
    },
    remove(index) {
        index = index.split(".");
        arr1 = "";
        $.each(index, function(index_items, value_items) {
            if (index_items + 1 != index.length) {
                arr1 += '["' + value_items + '"]';
            } else {
                last_item = value_items;
            }
        });

        eval("delete window.items" + arr1 + "[last_item]");

        // re order jika object key berurutan
        new_data = {};
        key_only_number = true;
        start = 0;
        $.each(eval("window.items" + arr1), function(i, v) {
            if (!/^\d+$/.test(i)) {
                key_only_number = false;
            }
            if (typeof v != "undefined") {
                new_data[start] = v;
                start++;
            }
        });

        if (key_only_number) {
            eval("window.items" + arr1 + "=new_data");
        }
    },
    update(index, value) {
        if (index.indexOf(".") !== -1) {
            index = index.split(".");
            arr1 = "";
            $.each(index, function(index_items, value_items) {
                arr1 += '["' + value_items + '"]';
            });
            return eval("window.items" + arr1 + "=value");
        } else {
            return (window.items[index] = value);
        }
    },
    get(index) {
        if (index.indexOf(".") !== -1) {
            index = index.split(".");
            arr1 = "";
            $.each(index, function(index_items, value_items) {
                arr1 += '["' + value_items + '"]';
                if (typeof eval("window.items" + arr1) == "undefined") {
                    return false;
                }
            });
            return eval("window.items" + arr1);
        } else {
            if (typeof window.items[index] == "undefined") {
                return false;
            } else {
                return window.items[index];
            }
        }
    },
    find(index, value) {
        its_obj = storage_parameter.get(index);
        if (typeof its_obj != "object") {
            return -1;
        }

        return_str = -1;
        $.each(its_obj, function(index_its_obj, value_its_obj) {
            if (value_its_obj == value) {
                return_str = index_its_obj;
            }
        });

        return return_str;
    },
    all() {
        return window.items;
    },
    except(keys) {
        its_obj = storage_parameter.all();
        target = {};
        $.each(its_obj, function (its_obj_i, its_obj_v) {
            $.each(keys, function (keys_i, keys_v) {
                if (keys_v.indexOf(its_obj_i) >= 0) return;
                target[its_obj_i] = its_obj[its_obj_i];
            }); 
        });
        return target;
    }
};
