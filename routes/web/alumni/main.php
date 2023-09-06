<?php

use App\Http\Controllers\Alumni\KajianKeberkesananGraduanController;
use App\Http\Controllers\Alumni\MainAlumniController;
use App\Http\Controllers\Alumni\Permohonan\PermohonanPindahJamKreditController;
use App\Http\Controllers\Alumni\Permohonan\PermohonanSijilGantiController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainAlumniController::class);

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::get('sijil_ganti/downloadFile/{id}/{type}', [PermohonanSijilGantiController::class, 'downloadFile'])->name('sijil_ganti.downloadFile');
    Route::resource('sijil_ganti', PermohonanSijilGantiController::class);

    Route::resource('pindah_jam_kredit', PermohonanPindahJamKreditController::class);
});

Route::resource('kajian_keberkesanan_graduan', KajianKeberkesananGraduanController::class);