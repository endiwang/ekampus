<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pemohon\MainPemohonController;
use App\Http\Controllers\Pemohon\PermohonanController;

Route::group(['middleware' => ['auth_pemohon']], function() {
    Route::get('/utama', [MainPemohonController::class, 'index'])->name('utama.index');
    Route::post('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');

    Route::post('/permohonan/store_bahagian_a', [PermohonanController::class, 'store_bahagian_a'])->name('permohonan.store_bahagian_a');

});

