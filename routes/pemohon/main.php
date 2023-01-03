<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pemohon\MainPemohonController;
use App\Http\Controllers\Pemohon\PermohonanController;

Route::group(['middleware' => ['auth_pemohon']], function() {
    Route::get('/utama', [MainPemohonController::class, 'index'])->name('utama.index');
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('pemohonan.index');

});

