<?php namespace App\Models\Event\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Event\EventMember;

trait Relationship
{
	/**
	 * Relationship Mapping for Account
	 * @return mixed
	 */
	public function user()
	{
	    return $this->belongsTo(User::class, 'user_id');
	}

	public function members()
	{
		return $this->belongsToMany(User::class, 'event_members', 'event_id', 'user_id');
	}
}