<?php

use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPeperiksaanSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPusatPeperiksaanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'tetapan','as'=>'tetapan.'], function(){
    Route::group(['prefix'=>'sesi_peperiksaan_sijil_tahfiz'], function(){
        Route::get('negeri_selection', [TetapanPeperiksaanSijilTahfizController::class,'loadNegeriSelection'])->name('tetapan.sesi_peperiksaan_sijil_tahfiz.negeri_selection');
    });
    Route::resource('sesi_peperiksaan_sijil_tahfiz', TetapanPeperiksaanSijilTahfizController::class);

    Route::resource('pusat_peperiksaan_sijil_tahfiz', TetapanPusatPeperiksaanController::class);
});