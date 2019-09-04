<?php

Route::group(['prefix' => 'health-check'], function () {
    Route::get('/readiness', 'Ambientia\HealthCheck\Http\Controllers\HealthCheckController@readiness')->name('readiness');
    Route::get('/liveness/backend', 'Ambientia\HealthCheck\Http\Controllers\HealthCheckController@livenessBackend')->name('livenessBackend');
    Route::get('/liveness/database', 'Ambientia\HealthCheck\Http\Controllers\HealthCheckController@livenessDatabase')->name('livenessDatabase');
    Route::get('/liveness/schedule', 'Ambientia\HealthCheck\Http\Controllers\HealthCheckController@livenessSchedule')->name('livenessSchedule');
    Route::get('/liveness/queue', 'Ambientia\HealthCheck\Http\Controllers\HealthCheckController@livenessQueue')->name('livenessQueue');
});
