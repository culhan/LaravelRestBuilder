// create data {{name_belongs_to_many}}
        if(!empty($data['{{name_belongs_to_many}}']))
        {
            $result->{{name_belongs_to_many}}()->sync($data['{{name_belongs_to_many}}']);            
        }
