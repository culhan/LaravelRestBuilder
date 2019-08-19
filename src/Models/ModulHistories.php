<?php

namespace KhanCode\LaravelRestBuilder\Models;

use KhanCode\LaravelBaseRest\BaseModel;

class ModulHistories extends BaseModel
{
    public $connection = "laravelrestbuilder_mysql";

    public $table = "modul_histories";

    public $timestamps = true;
            
    protected $soft_delete  =   true;
    
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    const DELETED_AT = 'deleted_at';
    
    public $fillable = [
		
    ];

    /**
     * [scopeGetAll description]
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeGetAll($query)
    {
        return $query->select([
                    "modul_histories.*",					
                ])
                // start list query option
                ->whereNull("modul_histories.deleted_at")
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

            if(auth()->guard('laravelrestbuilder_auth')->check()) $model->created_by = auth()->guard('laravelrestbuilder_auth')->id();

            $model->created_from = $_SERVER['REMOTE_ADDR'];

            // end list creating option  

        });

        self::updating(function($model){
            
            // start list updating option
            
            if(auth()->guard('laravelrestbuilder_auth')->check()) $model->modified_by = auth()->guard('laravelrestbuilder_auth')->id();

            $model->modified_from = $_SERVER['REMOTE_ADDR'];

            // end list updating option

        });

    }
}