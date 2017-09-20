<?php namespace App\Models\Charge;

/**
 * Class Charge
 *
 * @author Anuj Jaha er.anujjaha@gmail.com
 */

use App\Models\BaseModel;
use App\Models\Charge\Traits\Attribute\Attribute;
use App\Models\Charge\Traits\Relationship\Relationship;

class Charge extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_charge_history";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'user_id',
        'start_battery_status',
        'start_charge_time',
        'end_battery_status',
        'end_charge_time',
        'battery_voltage',
        'total_charge_time',
        'total_battery_charge',
    ];

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}