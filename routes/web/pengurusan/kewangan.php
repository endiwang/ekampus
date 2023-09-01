<?php

use App\Http\Controllers\Pengurusan\Kewangan\KelulusanProgramController;
use App\Http\Controllers\Pengurusan\Kewangan\Kemaskini\YuranController as KemaskiniYuranController;
use App\Http\Controllers\Pengurusan\Kewangan\MainKewanganController;
use App\Http\Controllers\Pengurusan\Kewangan\YuranController;

Route::group(['middleware' => ['auth', 'auth.unit_kewangan']], function () {

    Route::resource('/', MainKewanganController::class)->only(['index']);


    Route::group(['prefix' => 'kemaskini', 'as' => 'kemaskini.'], function () {
        Route::resource('yuran', KemaskiniYuranController::class);
    });

    Route::resource('{id}/yuran', YuranController::class);
    Route::resource('kelulusan_program', KelulusanProgramController::class);

});
