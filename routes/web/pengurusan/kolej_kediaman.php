<?php

use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\MainKolejKediamanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PengurusanBlokController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PengurusanBilikController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanBantuanKebajikanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanMendapatkanRawatanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanPenggunaanKemudahanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PermohonanPenginapanSementaraController;
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

});

