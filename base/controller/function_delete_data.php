/**
     * [{{name}} description]
     * @return [type]         [description]
     */
    public function {{name}}({{param}})
    {
        return (new App\Http\Resources\DeletedResource($this->service->{{name}}($id)));
    }

    // end list function