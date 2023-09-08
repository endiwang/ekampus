<?php

use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\JadualWardenController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\KeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\MainKolejKediamanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PengurusanBlokController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PengurusanBilikController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanBantuanKebajikanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanMendapatkanRawatanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanPenggunaanKemudahanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanPenginapanSementaraController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\TakwimTahunanAsramaController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PenyelengaraanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanKemasukanAsramaController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainKolejKediamanController::class)->only(['index']);

Route::group(['prefix' => 'pengurusan_aset', 'as' => 'pengurusan_aset.'], function () {
    Route::resource('/pengurusan_blok', PengurusanBlokController::class);
    Route::resource('/pengurusan_bilik', PengurusanBilikController::class);
});

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {

    Route::resource('/mendapatkan_rawatan', PermohonanMendapatkanRawatanController::class);
    Route::resource('/bantuan_kebajikan', PermohonanBantuanKebajikanController::class);
    Route::resource('/penggunaan_kemudahan', PermohonanPenggunaanKemudahanController::class);
    Route::resource('/penginapan_sementara', PermohonanPenginapanSementaraController::class);
    Route::resource('/kemasukan_asrama', PermohonanKemasukanAsramaController::class);

});

Route::resource('/takwim_tahunan', TakwimTahunanAsramaController::class);
Route::get('jadual_warden/{id}/pilih_warden', [JadualWardenController::class, 'pilih_warden'])->name('jadual_warden.pilih_warden');
Route::post('jadual_warden/{id}/store_warden', [JadualWardenController::class, 'store_warden'])->name('jadual_warden.store_warden');
Route::delete('jadual_warden/{id}/destroy_warden/{warden}', [JadualWardenController::class, 'destroy_warden'])->name('jadual_warden.destroy_warden');
Route::resource('/jadual_warden', JadualWardenController::class);
Route::resource('/keluar_masuk', KeluarMasukPelajarController::class);
Route::resource('/penyelenggaraan', PenyelengaraanController::class);


