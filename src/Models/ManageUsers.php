<?php

namespace KhanCode\LaravelRestBuilder\Models;

use KhanCode\LaravelBaseRest\BaseModel;

class ManageUsers extends BaseModel
{
    // public $connection = "laravelrestbuilder_mysql";

    public $table = "users";

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
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * [scopeGetAll description]
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeGetAll($query)
    {
        return $query->select([
                    "id",
                    "name",
                    "email",
                    "role_id",
                    \DB::raw("(
                            select concat('[',IFNULL(group_concat(distinct concat(
                                    project_id
                                ) -- order by name asc 
                            ),''), ']')
                            from users_projects
                            where users_projects.user_id = users.id
                        )
                    as 'projects' "),			
                ])
                // start list query option
                ->whereNull("deleted_at")
                // end list query option
                ;
    }

    /**
     * [Redeemable_location description]
     * @return [type] [description]
     */
    public function Projects(){
        return $this->belongsToMany('\KhanCode\LaravelRestBuilder\Models\Projects','users_projects','user_id','project_id');
    }

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return void
     */
    public function getProjectsAttribute($value)
    {
        return json_decode($value);
    }

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