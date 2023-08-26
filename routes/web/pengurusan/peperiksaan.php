<?php

use App\Http\Controllers\Pengurusan\Peperiksaan\CetakanKeputusanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\CetakTuntutanBayaranController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniKursusController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniNamaPelajarController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniSesiPengajianController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniSubjekArabController;
use App\Http\Controllers\Pengurusan\Peperiksaan\MainPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\PersiapanPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\SenaraiPelajarTamatController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPeperiksaanController::class)->only(['index']);

Route::group(['prefix' => 'kemaskini', 'as' => 'kemaskini.'], function () {
    Route::resource('senarai_kursus', KemaskiniKursusController::class);

    Route::resource('sesi_pengajian', KemaskiniSesiPengajianController::class);

    Route::resource('nama_pelajar', KemaskiniNamaPelajarController::class);

    Route::resource('subjek_arab', KemaskiniSubjekArabController::class);
});

Route::resource('pelajar_tamat_berhenti', SenaraiPelajarTamatController::class);

Route::post('persiapan_peperiksaan/add_item/{id}', [PersiapanPeperiksaanController::class, 'addItem'])->name('persiapan_peperiksaan.add_item');
Route::post('persiapan_peperiksaan/delete_item/{id}', [PersiapanPeperiksaanController::class, 'deleteItem'])->name('persiapan_peperiksaan.delete_item');
Route::resource('persiapan_peperiksaan', PersiapanPeperiksaanController::class);

Route::post('cetakan_keputusan_peperiksaan/download_keputusan', [CetakanKeputusanController::class, 'downloadKeputusan'])->name('cetakan_keputusan_peperiksaan.download_keputusan');
Route::post('cetakan_keputusan_peperiksaan/getCourses', [CetakanKeputusanController::class, 'getCourses'])->name('cetakan_keputusan_peperiksaan.getCourses');
Route::resource('cetakan_keputusan_peperiksaan', CetakanKeputusanController::class);

Route::post('cetak_tuntutan_bayaran/muat_turun', [CetakTuntutanBayaranController::class, 'downloadDetail'])->name('cetak_tuntutan_bayaran.download');
Route::resource('cetak_tuntutan_bayaran', CetakTuntutanBayaranController::class);