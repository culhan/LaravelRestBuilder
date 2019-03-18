/**
     * [{{name}} description]
     * @param  [type] $locale [description]
     * @param  [type] $id     [description]
     * @return [type]         [description]
     */
    public function {{name}}($locale{{param}})
    {
        return (new App\Http\Resources\DeletedResource($this->service->{{name}}($id)));
    }

    // end list function