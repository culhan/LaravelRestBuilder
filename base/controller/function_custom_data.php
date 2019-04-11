/**
     * [{{name}} description]
     * @param  [type] $locale [description]
     * @param  [type] $id     [description]
     * @return [type]         [description]
     */
    public function {{name}}($locale{{param}})
    {
        return $this->service->{{name}}(Request::all(){{param}});
    }

    // end list function