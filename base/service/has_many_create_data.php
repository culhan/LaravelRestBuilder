// create data {{name_has_many}}
        if(!empty($data['{{name_has_many}}']))
        {
            if( empty($data['{{name_has_many}}'][0]) ) {
                if( count($result->{{name_has_many}}) > 0 ) {
                    foreach ($result->{{name_has_many}} as $key_{{name_has_many}} => $value_{{name_has_many}}) {                        
                        $value_{{name_has_many}}->delete();
                    }
                }
            }else {
                $this->{{service_name}}Service = New {{service_name}}Service;
                foreach ($data['{{name_has_many}}'] as $key_{{name_has_many}} => $value_{{name_has_many}}) {
                    $this->{{service_name}}Service->create($value_{{name_has_many}}+[
                        "{{foregin_key}}"   =>  $result->id,
                    ]);
                }
            }
        }
