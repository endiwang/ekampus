<?php

use App\Http\Controllers\Pengurusan\HEP\MainHEPController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PengurusanSalahlakuPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\RekodKeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TetapanKeluarMasukController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainHEPController::class)->only(['index']);

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::resource('keluar_masuk', KeluarMasukPelajarController::class);
});

Route::group(['prefix' => 'tetapan', 'as' => 'tetapan.'], function () {
    Route::resource('keluar_masuk', TetapanKeluarMasukController::class);
});

Route::group(['prefix' => 'pengurusan', 'as' => 'pengurusan.'], function () {
    Route::get('salahlaku_pelajar/{id}/siasatan', [PengurusanSalahlakuPelajarController::class,'siasatan'])->name('salahlaku_pelajar.siasatan');
    Route::put('salahlaku_pelajar/{id}/siasatan', [PengurusanSalahlakuPelajarController::class,'update_siasatan'])->name('salahlaku_pelajar.update_siasatan');
    Route::resource('salahlaku_pelajar', PengurusanSalahlakuPelajarController::class);
    Route::resource('keluar_masuk', RekodKeluarMasukPelajarController::class);
});
