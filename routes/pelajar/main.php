<?php

use App\Http\Controllers\Pelajar\MainPelajarController;
use App\Http\Controllers\Pelajar\PenilaianPensyarahController;
use App\Http\Controllers\Pelajar\Permohonan\PelepasanKuliahController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPelajarController::class)->only(['index',]);

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::get('pelepasan_kuliah/download/{id}', [PelepasanKuliahController::class, 'downloadFile'])->name('pelepasan_kuliah.download');
    Route::resource('pelepasan_kuliah', PelepasanKuliahController::class);
});

Route::resource('penilaian_pensyarah', PenilaianPensyarahController::class);