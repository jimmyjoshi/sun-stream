<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\User;

/**
 * Class UserActivityRelationship
 */
trait UserActivityRelationship
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }    
}
