/**
     * [{{name}} description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function {{name}}($data{{param_function}})
    {
        $this->model::validate($data, [
            {{column_validation}}
        ]);

        // start code
        // end code
	}

    // end list function