<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Relationship\UserLoginTrackRelationship;

/**
 * Class UserMeta
 *
 * @author Anuj Jaha er.anujjaha@gmail.com
 */

use App\Models\BaseModel;

class UserLoginTrack extends BaseModel
{
    use UserLoginTrackRelationship;
    
    /**
     * Database Table
     *
     */
    protected $table = "user_lat_long_track";

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