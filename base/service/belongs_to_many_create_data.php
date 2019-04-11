// create data {{name_belongs_to_many}}
        if(!empty($data['{{name_belongs_to_many}}']))
        {
            $result->{{name_belongs_to_many}}()->detach();
            // ex(many data) : {{name_belongs_to_many}}[0][98][additional_column] = 207
            // ex(single data) : {{name_belongs_to_many}}[0] = 98
            foreach ($data['{{name_belongs_to_many}}'] as $key_belongs_to_many => $value_relation_belongs_to_many) {
                if(is_array($value_relation_belongs_to_many)) {
                    foreach ($value_relation_belongs_to_many as $key_belongs_to_many_2 => $value_relation_belongs_to_many_2) {
                        {{service_name}}Service::getSingleData($key_belongs_to_many_2);
                        $result->{{name_belongs_to_many}}()->attach($key_belongs_to_many_2,$value_relation_belongs_to_many_2);
                    }
                }else {
                    {{service_name}}Service::getSingleData($value_relation_belongs_to_many);
                    $result->{{name_belongs_to_many}}()->attach($value_relation_belongs_to_many);
                }
            }
        }
