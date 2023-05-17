<?php

use App\Http\Controllers\Pelajar\MainPelajarController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPelajarController::class)->only(['index',]);

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::resource('pelepasan_kuliah', LaporanMesyuaratController::class);
});