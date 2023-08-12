<?php

use App\Http\Controllers\Pengurusan\Pembangunan\AduanPenyelenggaraanController;
use App\Http\Controllers\Pengurusan\Pembangunan\MainPembangunanController;
use App\Http\Controllers\Pengurusan\Pembangunan\VendorController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/', MainPembangunanController::class)->only(['index']);
    Route::resource('aduan_penyelenggaraan', AduanPenyelenggaraanController::class);

    Route::group(['prefix' => 'kemaskini', 'as' => 'kemaskini.'], function () {
        Route::resource('vendor', VendorController::class);
    });

});
