<?php

use App\Http\Controllers\Pengurusan\HEP\MainHEPController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TetapanKeluarMasukController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainHEPController::class)->only(['index',]);

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::resource('keluar_masuk', KeluarMasukPelajarController::class);
});

Route::group(['prefix'=>'tetapan','as'=>'tetapan.'], function(){
    Route::resource('keluar_masuk', TetapanKeluarMasukController::class);
});
