<?php

use App\Http\Controllers\Pelajar\MainPelajarController;
use App\Http\Controllers\Pelajar\PenilaianPensyarahController;
use App\Http\Controllers\Pelajar\Permohonan\PelepasanKuliahController;
use App\Http\Controllers\Pelajar\Permohonan\PenangguhanPengajianController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPelajarController::class)->only(['index',]);

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::get('pelepasan_kuliah/download/{id}', [PelepasanKuliahController::class, 'downloadFile'])->name('pelepasan_kuliah.download');
    Route::resource('pelepasan_kuliah', PelepasanKuliahController::class);

    Route::get('penangguhan_pengajian/download/{id}', [PenangguhanPengajianController::class, 'downloadLetter'])->name('penangguhan_pengajian.download');
    Route::resource('penangguhan_pengajian', PenangguhanPengajianController::class);
});

Route::resource('penilaian_pensyarah', PenilaianPensyarahController::class);