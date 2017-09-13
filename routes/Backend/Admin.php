<?php

Route::group([
    'namespace'  => 'Admin',
], function () {

    /*
     * Admin Event Controller
     */
    Route::resource('admin', 'AdminController');

    Route::get('signup-google-map', 'AdminController@index')->name('map.signup-google-map');
    Route::get('login-google-map', 'AdminController@loginMapHistory')->name('map.login-google-map');
    
});