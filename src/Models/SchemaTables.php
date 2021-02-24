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
                    \DB::raw('TABLE_NAME as id'),
                    \DB::raw('TABLE_NAME as name'),
                ])
                ;
    }

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return void
     */
    public function getModifiedTimeAttribute($value)
    {
        return $value;
    }

    // start list relation function
    
    // end list relation function
}