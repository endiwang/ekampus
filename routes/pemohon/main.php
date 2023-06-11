<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pemohon\MainPemohonController;
use App\Http\Controllers\Pemohon\PermohonanController;
use App\Http\Controllers\Pemohon\RayuanController;
use App\Http\Controllers\Pemohon\SemakanController;
use App\Http\Controllers\Pemohon\TawaranController;

Route::group(['middleware' => ['auth_pemohon']], function() {
    Route::get('/utama', [MainPemohonController::class, 'index'])->name('utama.index');
    Route::post('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');

    Route::post('/permohonan/simpan_dan_seterusnya', [PermohonanController::class, 'simpan_dan_seterusnya'])->name('permohonan.simpan_dan_seterusnya');
    Route::get('/permohonan/berjaya_dihantar', [PermohonanController::class, 'berjaya_dihantar'])->name('permohonan.berjaya_dihantar');

    Route::get('/semakan', [SemakanController::class, 'index'])->name('semakan.index');
    Route::get('/tawaran/{id}', [TawaranController::class, 'index'])->name('tawaran.index');
    Route::post('/tawaran/keputusan', [TawaranController::class, 'store'])->name('tawaran.keputusan.store');


    Route::get('/rayuan/{id}', [RayuanController::class, 'index'])->name('rayuan.index');
    Route::post('/rayuan/store', [RayuanController::class, 'store'])->name('rayuan.store');


});

