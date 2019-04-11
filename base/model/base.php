<?php

namespace App\Http\Models;
// use KhanCode\LaravelBaseRest\BaseModel;

class {{Name}} extends BaseModel
{
    public $table = "{{table}}";

    // start list option

    // end list option    

    /**
     * [scopeGetAll description]
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeGetAll($query)
    {
        return $query->select([
                    {{column}}
                ])
                // start list query option
                // end list query option
                ;
    }

    // start list relation function
    
    // end list relation function

    /**
     * [boot description]
     * @return [type] [description]
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){

            // start list creating option

            // end list creating option  

        });

        self::updating(function($model){
            
            // start list updating option

            // end list updating option

        });

    }
}