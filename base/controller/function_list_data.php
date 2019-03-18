/**
     * [{{name}} description]
     * @return [type] [description]
     */
    public function {{name}}()
    {
        $data = $this->service->get{{Name}}Data([
                // start list column
                // end list column
            ]);
        
        return (App\Http\Resources\{{Modul_name}}Resource::collection($data))
                ->additional([
                    'sortableAndSearchableColumn' =>    $data->sortableAndSearchableColumn
                ]);
    }

    // end list function