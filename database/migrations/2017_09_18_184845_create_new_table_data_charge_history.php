<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewTableDataChargeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_charge_history', function(Blueprint $table)
        {
            $table->bigInteger('id', true);
            $table->integer('user_id');
            $table->string('start_battery_status')->nullable();
            $table->datetime('start_charge_time')->nullable();
            $table->string('end_battery_status')->nullable();
            $table->datetime('end_charge_time')->nullable();
            $table->string('battery_voltage')->nullable();
            $table->string('total_charge_time')->nullable();
            $table->string('total_battery_charge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
