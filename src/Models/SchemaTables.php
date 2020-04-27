<?php

namespace KhanCode\LaravelRestBuilder\Models;

use KhanCode\LaravelBaseRest\BaseModel;

class SchemaTables extends BaseModel
{
    // public $connection = "laravelrestbuilder_mysql";

    public $table = "INFORMATION_SCHEMA.TABLES";

    protected $soft_delete  =   false;
    
    public $casts = [
		'id'    => 'string'
    ];

    /**
     * [scopeGetAll description]
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeGetAll($query)
    {
        return $query->where('TABLE_SCHEMA',config('database.connections.mysql.database'))
                ->select([
                    \DB::raw('TABLE_NAME AS id'),
                    \DB::raw('TABLE_NAME AS name'),
                ])
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
            
            $model->project_id = config('laravelrestbuilder.project_id');

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