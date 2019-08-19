/**
     * [{{name}} description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function {{name}}($id)
    {
        // locking function
        
        \DB::beginTransaction();

        // custom code before
        {{custom_code_before}}

        $result = $this->repository->getSingleData($id);

        // start list belongs to many delete
        
        // end list belongs to many delete

        $return = $result->delete();
        
        // custom code after
        {{custom_code_after}}        

        \DB::commit();

        // unlocking function

        return $return;
    }

    // end list function