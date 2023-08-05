<?php

use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniKursusController;
use App\Http\Controllers\Pengurusan\Peperiksaan\MainPeperiksaanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPeperiksaanController::class)->only(['index',]);

Route::group(['prefix'=>'kemaskini','as'=>'kemaskini.'], function(){
    Route::resource('senarai_kursus', KemaskiniKursusController::class);
});