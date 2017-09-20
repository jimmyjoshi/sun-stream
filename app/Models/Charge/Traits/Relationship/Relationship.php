<?php namespace App\Models\Charge\Traits\Relationship;

use App\Models\Access\User\User;

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
}