<?php namespace App\Models\Event;


use App\Models\BaseModel;
use App\Models\Event\Traits\Relationship\EventMemberRelationship;

class EventMember extends BaseModel
{
    use EventMemberRelationship;
    /**
     * Database Table
     *
     */
    protected $table = "event_members";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'name',
        'user_id',
        'title',
        'creator_id',
        'start_date',
        'end_date'
    ];

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}