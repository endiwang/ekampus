<?php

use App\Http\Controllers\Pengurusan\HEP\MainHEPController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KeluarMasukPelajarController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainHEPController::class)->only(['index',]);

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::resource('keluar_masuk', KeluarMasukPelajarController::class);
});
