<?php

use App\Http\Controllers\Alumni\KajianKeberkesananGraduanController;
use App\Http\Controllers\Alumni\MainAlumniController;
use App\Http\Controllers\Alumni\Permohonan\PermohonanPindahJamKreditController;
use App\Http\Controllers\Alumni\Permohonan\PermohonanSijilGantiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainAlumniController::class, 'index'])->name('index');

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    // Pengajian Selepas DQ
    Route::get('/{id}/pengajian/create', [MainAlumniController::class, 'pengajian_create'])
        ->name('pengajian.create');
    Route::post('/{id}/pengajian', [MainAlumniController::class, 'pengajian_store'])
        ->name('pengajian.store');
    Route::get('/{id}/pengajian/{pengajian_id}/edit', [MainAlumniController::class, 'pengajian_edit'])
        ->name('pengajian.edit');
    Route::put('/{id}/pengajian/{pengajian_id}', [MainAlumniController::class, 'pengajian_update'])
        ->name('pengajian.update');
    Route::delete('/{id}/pengajian', [MainAlumniController::class, 'pengajian_destroy'])
        ->name('pengajian.destroy');

    // Pekerjaan terkini
    Route::post('/{id}/pekerjaan/create_edit', [MainAlumniController::class, 'pekerjaan_store'])
        ->name('pekerjaan.store');
    Route::put('/{id}/pekerjaan/create_edit', [MainAlumniController::class, 'pekerjaan_update'])
        ->name('pekerjaan.update');

    Route::get('{id}/edit', [MainAlumniController::class, 'edit'])->name('edit');
    Route::put('{id}', [MainAlumniController::class, 'update'])->name('update');
});

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::get('sijil_ganti/downloadFile/{id}/{type}', [PermohonanSijilGantiController::class, 'downloadFile'])->name('sijil_ganti.downloadFile');
    Route::resource('sijil_ganti', PermohonanSijilGantiController::class);

    Route::resource('pindah_jam_kredit', PermohonanPindahJamKreditController::class);
});

Route::resource('kajian_keberkesanan_graduan', KajianKeberkesananGraduanController::class);
