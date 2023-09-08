<?php

use App\Http\Controllers\Vendor\AduanPenyelenggaraanController;
use App\Http\Controllers\Vendor\PenyelenggaraanAsramaController;
use App\Http\Controllers\Vendor\UtamaController;

Route::group(['middleware' => ['auth', 'auth.vendor'], 'prefix' => 'vendor', 'as' => 'vendor.'], function () {

    Route::resource('utama', UtamaController::class);
    Route::resource('aduan_penyelenggaraan', AduanPenyelenggaraanController::class);
    Route::resource('penyelenggaraan_asrama', PenyelenggaraanAsramaController::class);

});
