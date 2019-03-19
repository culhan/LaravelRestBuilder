/**
     * [{{belongs_to_many_name}} description]
     * @return [type] [description]
     */
    public function {{belongs_to_many_name}}(){
        return $this->belongsToMany('\App\Http\Models\{{belongs_to_many_model_name}}','{{belongs_to_many_table}}','{{column_belongs_to_many_foreign_key_model}}','{{column_belongs_to_many_foreign_key_joining_model}}');
    }

    // end list relation function