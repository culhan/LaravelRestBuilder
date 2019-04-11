/**
     * [{{name}} description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function {{name}}($id)
    {
        \DB::beginTransaction();

        // start custom code
        // end custom code

        $result = $this->repository->getSingleData($id);

        // start list belongs to many delete
        
        // end list belongs to many delete

        $return = $result->delete();
        
        // start custom code
        // end custom code

        \DB::commit();

        return $return;
    }

    // end list function