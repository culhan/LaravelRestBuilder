/**
     * [{{has_one_name}} description]
     * @return [type] [description]
     */
    public function {{has_one_name}}(){
        return $this->hasone('\App\Http\Models\{{has_one_name}}','{{column_has_one_foreign_key}}','id');
    }

    // end list relation function