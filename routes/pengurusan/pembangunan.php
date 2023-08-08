<?php

use App\Http\Controllers\Pengurusan\Pembangunan\AduanPenyelenggaraanController;
use App\Http\Controllers\Pengurusan\Pembangunan\MainPembangunanController;

Route::group(['middleware' => ['auth']], function() {

    Route::resource('/', MainPembangunanController::class)->only(['index',]);
    Route::resource('aduan_penyelenggaraan', AduanPenyelenggaraanController::class);

});





