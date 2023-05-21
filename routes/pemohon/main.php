<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pemohon\MainPemohonController;
use App\Http\Controllers\Pemohon\PermohonanController;
use App\Http\Controllers\Pemohon\SemakanController;

Route::group(['middleware' => ['auth_pemohon']], function() {
    Route::get('/utama', [MainPemohonController::class, 'index'])->name('utama.index');
    Route::post('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');

    Route::post('/permohonan/simpan_dan_seterusnya', [PermohonanController::class, 'simpan_dan_seterusnya'])->name('permohonan.simpan_dan_seterusnya');
    Route::get('/permohonan/berjaya_dihantar', [PermohonanController::class, 'berjaya_dihantar'])->name('permohonan.berjaya_dihantar');

    Route::get('/semakan', [SemakanController::class, 'index'])->name('semakan.index');

});

