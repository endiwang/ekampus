<?php

use App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran\KehadiranPelajarController;
use App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran\KehadiranPensyarahController;
use App\Http\Controllers\Pengurusan\Kakitangan\MainKakitanganController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainKakitanganController::class)->only(['index']);

Route::group(['prefix' => 'kehadiran', 'as' => 'kehadiran.'], function () {
    Route::get('pelajar/print/qr/{id}', [KehadiranPelajarController::class, 'downloadQr'])->name('kehadiran_pelajar.download_qr');
    Route::resource('pelajar', KehadiranPelajarController::class);

    Route::resource('pensyarah', KehadiranPensyarahController::class);
});
