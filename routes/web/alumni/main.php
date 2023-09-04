<?php

use App\Http\Controllers\Alumni\MainAlumniController;
use App\Http\Controllers\Pelajar\PengurusanIjazah\RekodTesisController;
use App\Http\Controllers\Pelajar\PenilaianPensyarahController;
use App\Http\Controllers\Pelajar\Permohonan\KeluarMasukController;
use App\Http\Controllers\Alumni\Permohonan\PermohonanSijilGantiController;
use App\Http\Controllers\Pelajar\Permohonan\PenangguhanPengajianController;
use App\Http\Controllers\Pelajar\Permohonan\PermohonanBawaBarangController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainAlumniController::class);

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    // Route::get('pelepasan_kuliah/muat_turun_surat/{id}', [PelepasanKuliahController::class, 'downloadLetter'])->name('pelepasan_kuliah.download_surat_pelepasan');
    Route::get('sijil_ganti/downloadFile/{id}/{type}', [PermohonanSijilGantiController::class, 'downloadFile'])->name('sijil_ganti.downloadFile');
    Route::resource('sijil_ganti', PermohonanSijilGantiController::class);
    // Route::resource('bawa_barang', PermohonanBawaBarangController::class);

    // Route::get('penangguhan_pengajian/download/{id}', [PenangguhanPengajianController::class, 'downloadLetter'])->name('penangguhan_pengajian.download');
    // Route::resource('penangguhan_pengajian', PenangguhanPengajianController::class);
    // Route::resource('keluar_masuk', KeluarMasukController::class);
});

Route::resource('penilaian_pensyarah', PenilaianPensyarahController::class);

Route::group(['prefix' => 'pengurusan_ijazah', 'as' => 'pengurusan_ijazah.'], function () {
    Route::get('rekod_tesis/download/{id}', [RekodTesisController::class, 'download'])->name('rekod_tesis.download');
    Route::resource('rekod_tesis', RekodTesisController::class);
});