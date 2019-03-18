/**
     * [{{name}} description]
     * @param  [type] $locale [description]
     * @param  [type] $id     [description]
     * @return [type]         [description]
     */
    public function {{name}}($locale{{param}})
    {
        $data = $this->service->get{{Name}}Data($id);
        return new App\Http\Resources\{{Modul_name}}Resource($data);
    }

    // end list function