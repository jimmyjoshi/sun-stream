<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Event\Event;
use App\Models\System\Session;
use App\Models\Access\User\SocialLogin;
use App\Models\Access\User\UserMeta;
use App\Models\Access\User\UserLoginTrack;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.role_user_table'), 'user_id', 'role_id');
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialLogin::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * @return mixed
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }    

    /**
     * @return mixed
     */
    public function user_meta()
    {
        return $this->hasOne(UserMeta::class);
    }    


    /**
     * User Login Track
     * 
     * @return HasMany
     */
    public function user_login_track()
    {
        return $this->hasMany(UserLoginTrack::class);
    }
}
