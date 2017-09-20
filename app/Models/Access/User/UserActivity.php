<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Relationship\UserActivityRelationship;

/**
 * Class UserMeta
 *
 * @author Anuj Jaha er.anujjaha@gmail.com
 */

use App\Models\BaseModel;

class UserActivity extends BaseModel
{
    use UserActivityRelationship;
    
    /**
     * Database Table
     *
     */
    protected $table = "data_activity";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'user_id',
        'lat',
        'long'
    ];

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}