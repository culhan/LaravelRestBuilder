/**
     * [{{name}} description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function {{name}}($data)
    {
        $dataRecord = array_only($data,[
            {{column}}
        ]);

        $this->model::validate($dataRecord, [
            {{column_validation}}
        ]);

        // locking function

        \DB::beginTransaction();

        // start custom code
        // end custom code

        // start list belongs to check create
        
        // end list belongs to check create        

        // create
        $result = $this->model->create($dataRecord);
        
        // start list has many create
        
        // end list has many create

        // start list belongs to many create
        
        // end list belongs to many create        
        
        // start custom code
        // end custom code

        \DB::commit();

        // unlocking function

        return $this->getSingleData($result->id);
	}

    // end list function