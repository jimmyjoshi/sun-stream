<?php

Route::group([
    'namespace'  => 'Charge',
], function () {

    /*
     * Admin Charge Controller
     */
    Route::resource('charge', 'AdminChargeController');

    Route::get('charge/', 'AdminChargeController@index')->name('charge.index');
    Route::get('charge/get', 'AdminChargeController@getTableData')->name('charge.get-list-data');
});
