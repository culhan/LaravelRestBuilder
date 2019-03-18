/**
     * [{{name}} description]
     * @return [type] [description]
     */
    public function {{name}}({{param}})
    {
        $data = $this->service->{{name}}(Request::all());
        return new App\Http\Resources\{{Modul_name}}Resource($data);
    }

    // end list function