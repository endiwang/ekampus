<?php

use App\Http\Controllers\Pengurusan\Pembangunan\AduanPenyelenggaraanController;
use App\Http\Controllers\Pengurusan\Pembangunan\LaporanAduanPenyelenggaraanController;
use App\Http\Controllers\Pengurusan\Pembangunan\MainPembangunanController;
use App\Http\Controllers\Pengurusan\Pembangunan\VendorController;

Route::group(['middleware' => ['auth', 'auth.unit_pembangunan']], function () {

    Route::resource('/', MainPembangunanController::class)->only(['index']);
    Route::resource('aduan_penyelenggaraan', AduanPenyelenggaraanController::class);

    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function () {
        
        Route::post('export_aduan_penyelenggaraan', [LaporanAduanPenyelenggaraanController::class, 'exportAduanPenyelenggaraan'])->name('export_aduan_penyelenggaraan');
        Route::resource('aduan_penyelenggaraan', LaporanAduanPenyelenggaraanController::class);
    });

    Route::group(['prefix' => 'kemaskini', 'as' => 'kemaskini.'], function () {
        Route::resource('vendor', VendorController::class);
    });

});
