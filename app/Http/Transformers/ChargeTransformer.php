<?php

namespace App\Http\Transformers;

use App\Http\Transformers;

class ChargeTransformer extends Transformer 
{
    /**
     * Transform
     * 
     * @param array $data
     * @return array
     */
    public function transform($data) 
    {
        if(is_array($data))
        {
            $data = (object)$data;
        }
        
        return [
            'chargeId'                  => (int) $data->id,
            'start_battery_status'      => $data->start_battery_status,
            'start_charge_time'         => $data->start_charge_time,
            'end_battery_status'        => $data->end_battery_status,
            'end_charge_time'           => $data->end_charge_time,
            'battery_voltage'           => $data->battery_voltage,
            'total_charge_time'         => $data->total_charge_time,
            'total_battery_charge'      => $data->total_battery_charge
        ];
    }

    public function createCharge($model = null)
    {
        return [
            'chargeId'                  => (int) $model->id,
            'start_battery_status'      => $model->start_battery_status,
            'start_charge_time'         => $model->start_charge_time,
            'end_battery_status'        => $model->end_battery_status,
            'end_charge_time'           => $model->end_charge_time,
            'battery_voltage'           => $model->battery_voltage,
            'total_charge_time'         => $model->total_charge_time,
            'total_battery_charge'      => $model->total_battery_charge
        ];
    }
}
