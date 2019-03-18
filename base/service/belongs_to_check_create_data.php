// check data {{name_belongs_to}}
        if(!empty($data['{{foregin_key}}']))
        {
            {{service_name}}Service::getSingleData($data['{{foregin_key}}']);
        }

        // create data {{name_belongs_to}}
        if(array_has($data,'{{name_belongs_to}}'))
        {
            $this->{{service_name}}Service = New {{service_name}}Service;
            $this->{{service_name}}Service->create($data['{{name_belongs_to}}']);
            $dataRecord["{{foregin_key}}"]   =    $result->id;
        }
        