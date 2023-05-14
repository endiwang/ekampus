<?php

use App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran\KehadiranPelajarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Kakitangan\MainKakitanganController;


Route::resource('/', MainKakitanganController::class)->only(['index',]);

Route::group(['prefix'=>'kehadiran','as'=>'kehadiran.'], function(){
    Route::get('pelajar/print/qr/{id}', [KehadiranPelajarController::class, 'downloadQr'])->name('kehadiran_pelajar.download_qr');
    Route::resource('pelajar', KehadiranPelajarController::class);
});