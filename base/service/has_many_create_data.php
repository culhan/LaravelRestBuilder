// create data {{name_has_many}}
        if(!empty($data['{{name_has_many}}']))
        {
            $this->{{service_name}}Service = New {{service_name}}Service;
            $this->{{service_name}}Service->create($data['{{name_has_many}}']+[
                "{{foregin_key}}"   =>  $result->id,
            ]);
        }
