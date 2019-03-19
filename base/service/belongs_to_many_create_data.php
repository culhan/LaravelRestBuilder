// create data {{name_belongs_to_many}}
        if(!empty($data['{{name_belongs_to_many}}']))
        {
            $result->{{name_belongs_to_many}}()->detach();
            // ex : [1 => [["class_session" => 1],["class_session" => 1]] ]
            foreach ($data['{{name_belongs_to_many}}'] as $key_belongs_to_many => $value_relation_belongs_to_many) {
                foreach ($value_relation_belongs_to_many as $key_belongs_to_many_2 => $value_relation_belongs_to_many_2) {
                    if(is_array($value_relation_belongs_to_many_2)) {
                        $result->{{name_belongs_to_many}}()->attach($key_belongs_to_many,$value_relation_belongs_to_many_2);
                    }else {
                        $result->{{name_belongs_to_many}}()->attach($key_belongs_to_many,$value_relation_belongs_to_many);
                    }
                }
            }
        }
