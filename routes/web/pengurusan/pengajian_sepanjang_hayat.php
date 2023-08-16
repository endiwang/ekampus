<?php

use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PermohonanController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPenemudugaSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPeperiksaanSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPusatPeperiksaanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'tetapan','as'=>'tetapan.'], function(){
    Route::resource('sesi_peperiksaan_sijil_tahfiz', TetapanPeperiksaanSijilTahfizController::class);

    Route::resource('pusat_peperiksaan_sijil_tahfiz', TetapanPusatPeperiksaanController::class);

    Route::group(['prefix'=>'penemuduga_sijil_tahfiz','as'=>'penemuduga_sijil_tahfiz.'], function(){
        Route::get('fetchPusatPeperiksaan', [TetapanPenemudugaSijilTahfizController::class, 'fetchPusatPeperiksaan'])->name('fetchPusatPeperiksaan');
        Route::get('fetchPusatPeperiksaanNegeri', [TetapanPenemudugaSijilTahfizController::class, 'fetchPusatPeperiksaanNegeri'])->name('fetchPusatPeperiksaan.negeri');
    });
    Route::resource('penemuduga_sijil_tahfiz', TetapanPenemudugaSijilTahfizController::class);
});

Route::group(['prefix'=>'proses_permohonan','as'=>'proses_permohonan.'], function(){

    // Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    //     Route::get('lantikPenemuduga/{id}', [PermohonanController::class,'lantikPenemuduga'])->name('lantik.penemuduga');
    //     Route::patch('lantikPenemuduga/update/{id}', [PermohonanController::class,'lantikPenemuduga'])->name('lantik.penemuduga.update');
    // });
    
    Route::resource('permohonan', PermohonanController::class);
});