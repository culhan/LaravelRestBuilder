// create data {{name_has_one}}
        if(!empty($data['{{name_has_one}}']))
        {
            $this->{{service_name}}Service = New {{service_name}}Service;
            $this->{{service_name}}Service->create($data['{{name_has_one}}']+[
                "{{foregin_key}}"   =>  $result->id,
            ]);
        }
