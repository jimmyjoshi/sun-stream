<?php

Route::group([
    'namespace'  => 'Admin',
], function () {

    /*
     * Admin Event Controller
     */
    Route::resource('admin', 'AdminController');

    Route::get('signup-google-map', 'AdminController@index')->name('map.index');
});