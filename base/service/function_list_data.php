/**
     * [{{name}} description]
     * @return [type] [description]
     */
    public function get{{Name}}Data($data,$relation{{param_function}})
    {
        // custom code before
        {{custom_code_before}}

        $this->model::validate(Request::all(), [
            {{column_validation}}
        ]);

        $return = $this->repository->getIndexData($data,$relation);

        // custom code after
        {{custom_code_after}}

        return $return;
    }

    // end list function