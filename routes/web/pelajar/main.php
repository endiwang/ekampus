<?php

use App\Http\Controllers\Pelajar\MainPelajarController;
use App\Http\Controllers\Pelajar\PengurusanIjazah\RekodTesisController;
use App\Http\Controllers\Pelajar\PenilaianPensyarahController;
use App\Http\Controllers\Pelajar\Permohonan\KeluarMasukController;
use App\Http\Controllers\Pelajar\Permohonan\PelepasanKuliahController;
use App\Http\Controllers\Pelajar\Permohonan\PenangguhanPengajianController;
use App\Http\Controllers\Pelajar\Permohonan\PermohonanBawaBarangController;
use App\Http\Controllers\Pelajar\Permohonan\PermohonanBawaKenderaanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPelajarController::class)->only(['index']);

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::get('pelepasan_kuliah/muat_turun_surat/{id}', [PelepasanKuliahController::class, 'downloadLetter'])->name('pelepasan_kuliah.download_surat_pelepasan');
    Route::get('pelepasan_kuliah/download/{id}', [PelepasanKuliahController::class, 'downloadFile'])->name('pelepasan_kuliah.download');
    Route::resource('pelepasan_kuliah', PelepasanKuliahController::class);
    Route::resource('bawa_barang', PermohonanBawaBarangController::class);
    Route::resource('bawa_kenderaan', PermohonanBawaKenderaanController::class);

    Route::get('penangguhan_pengajian/download/{id}', [PenangguhanPengajianController::class, 'downloadLetter'])->name('penangguhan_pengajian.download');
    Route::resource('penangguhan_pengajian', PenangguhanPengajianController::class);
    Route::resource('keluar_masuk', KeluarMasukController::class);
});

Route::resource('penilaian_pensyarah', PenilaianPensyarahController::class);

Route::group(['prefix' => 'pengurusan_ijazah', 'as' => 'pengurusan_ijazah.'], function () {
    Route::get('rekod_tesis/download/{id}', [RekodTesisController::class, 'download'])->name('rekod_tesis.download');
    Route::resource('rekod_tesis', RekodTesisController::class);
});