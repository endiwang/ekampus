<?php

use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniKursusController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniNamaPelajarController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniSesiPengajianController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniSubjekArabController;
use App\Http\Controllers\Pengurusan\Peperiksaan\MainPeperiksaanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPeperiksaanController::class)->only(['index',]);

Route::group(['prefix'=>'kemaskini','as'=>'kemaskini.'], function(){
    Route::resource('senarai_kursus', KemaskiniKursusController::class);

    Route::resource('sesi_pengajian', KemaskiniSesiPengajianController::class);

    Route::resource('nama_pelajar', KemaskiniNamaPelajarController::class);
    
    Route::resource('subjek_arab', KemaskiniSubjekArabController::class);
});