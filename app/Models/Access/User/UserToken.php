<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Relationship\UserTokenRelationship;

/**
 * Class UserToken
 *
 * @author Anuj Jaha er.anujjaha@gmail.com
 */

use App\Models\BaseModel;

class UserToken extends BaseModel
{
    use UserTokenRelationship;
    
    /**
     * Database Table
     *
     */
    protected $table = "user_tokens";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'user_id',
        'token'
    ];

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}