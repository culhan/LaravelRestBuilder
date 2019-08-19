/**
     * [{{name}} description]
     * @return [type] [description]
     */
    public function {{name}}({{param}})
    {
        $data = $this->service->get{{Name}}Data([
                // start list column
                // end list column
            ],[
                // start list relation column
                // end list relation column
            ]{{param_function}});
        
        return (App\Http\Resources\{{Modul_name}}Resource::collection($data))
                ->additional([
                    'sortableAndSearchableColumn' =>    $data->sortableAndSearchableColumn,
                    'relationColumn'    =>  $data->relationColumn
                ]);
    }

    // end list function