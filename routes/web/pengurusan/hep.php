<?php

use App\Http\Controllers\Pengurusan\HEP\MainHEPController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PengurusanSalahlakuPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TetapanKeluarMasukController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\DashboardController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\KaunselingController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainHEPController::class)->only(['index']);

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::resource('keluar_masuk', KeluarMasukPelajarController::class);
});

Route::group(['prefix' => 'tetapan', 'as' => 'tetapan.'], function () {
    Route::resource('keluar_masuk', TetapanKeluarMasukController::class);
});

Route::group(['prefix' => 'pengurusan', 'as' => 'pengurusan.'], function () {
    Route::resource('salahlaku_pelajar', PengurusanSalahlakuPelajarController::class);
});

/** Kaunseling */
Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::get('/kaunseling/dashboard', DashboardController::class)
            ->name('kaunseling.dashboard.index');

        Route::resource('/kaunseling', KaunselingController::class);
    });
