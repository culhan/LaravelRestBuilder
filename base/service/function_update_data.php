/**
     * [{{name}} description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function {{name}}($data{{param_function}})
    {
        $dataRecord = array_only($data,[
            {{column}}
        ]);

        $this->model::validate($dataRecord, [
            {{column_validation}}
        ]);

        // locking function

        \DB::beginTransaction();

        // custom code before
        {{custom_code_before}}

        // start list belongs to check create
        
        // end list belongs to check create        

        // update
        $single_data = $this->getSingleData($id);
        $result = $single_data->update($dataRecord);
        if(!$result) {
            throw new DataEmptyException('no data updated');
        }else {
            $result = $single_data;
        }

        // start list has many create
        
        // end list has many create

        // start list belongs to many create
        
        // end list belongs to many create
        
        // custom code after
        {{custom_code_after}}

        \DB::commit();

        // unlocking function

        return $this->getSingleData($id);
	}

    // end list function