<?php

use App\Http\Controllers\Pengurusan\Kewangan\Kemaskini\YuranController as KemaskiniYuranController;
use App\Http\Controllers\Pengurusan\Kewangan\MainKewanganController;
use App\Http\Controllers\Pengurusan\Kewangan\YuranController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/', MainKewanganController::class)->only(['index']);


    Route::group(['prefix' => 'kemaskini', 'as' => 'kemaskini.'], function () {
        Route::resource('yuran', KemaskiniYuranController::class);
    });

    Route::resource('{id}/yuran', YuranController::class);

});
