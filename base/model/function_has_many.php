/**
     * [{{has_many_name}} description]
     * @return [type] [description]
     */
    public function {{has_many_name}}(){
        return $this->hasmany('\App\Http\Models\{{has_many_name_model}}','{{column_has_many_foreign_key}}','id');
    }

    // end list relation function