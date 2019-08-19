/**
     * [{{name}} description]
     * @param  [type] $id     [description]
     * @return [type]         [description]
     */
    public function get{{Name}}Data($id)
    {
        // custom code before
        {{custom_code_before}}

        $this->model::validate(Request::all(), [
            {{column_validation}}
        ]);

        $return = $this->repository->getSingleData($id);

        // custom code after
        {{custom_code_after}}

        return $return;
    }

    // end list function