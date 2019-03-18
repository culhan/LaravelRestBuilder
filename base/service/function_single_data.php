/**
     * [{{name}} description]
     * @param  [type] $id     [description]
     * @return [type]         [description]
     */
    public function get{{Name}}Data($id)
    {
        return $this->repository->getSingleData($id);
    }

    // end list function