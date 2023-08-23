<?php

use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PengesahanMarkahSijilTafiz;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PeperiksaanPemarkahanCalonSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PermohonanController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPenemudugaSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPeperiksaanSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPusatPeperiksaanController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanMajlisPenyerahanSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TemplateJemputanSijilController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\JemputanMajlisPenyerahanSijilController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'tetapan','as'=>'tetapan.'], function(){
    Route::resource('sesi_peperiksaan_sijil_tahfiz', TetapanPeperiksaanSijilTahfizController::class);

    Route::resource('pusat_peperiksaan_sijil_tahfiz', TetapanPusatPeperiksaanController::class);

    Route::group(['prefix'=>'penemuduga_sijil_tahfiz','as'=>'penemuduga_sijil_tahfiz.'], function(){
        Route::get('fetchPusatPeperiksaan', [TetapanPenemudugaSijilTahfizController::class, 'fetchPusatPeperiksaan'])->name('fetchPusatPeperiksaan');
        Route::get('fetchPusatPeperiksaanNegeri', [TetapanPenemudugaSijilTahfizController::class, 'fetchPusatPeperiksaanNegeri'])->name('fetchPusatPeperiksaan.negeri');
    });
    Route::resource('penemuduga_sijil_tahfiz', TetapanPenemudugaSijilTahfizController::class);
    Route::resource('majlis_penyerahan_sijil_tahfiz', TetapanMajlisPenyerahanSijilTahfizController::class);
    Route::resource('template_jemputan_sijil', TemplateJemputanSijilController::class);
});

Route::group(['prefix'=>'proses_permohonan','as'=>'proses_permohonan.'], function(){

    // Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    //     Route::get('lantikPenemuduga/{id}', [PermohonanController::class,'lantikPenemuduga'])->name('lantik.penemuduga');
    //     Route::patch('lantikPenemuduga/update/{id}', [PermohonanController::class,'lantikPenemuduga'])->name('lantik.penemuduga.update');
    // });
    
    Route::resource('permohonan', PermohonanController::class);
});

Route::group(['prefix'=>'pemarkahan','as'=>'pemarkahan.'], function(){
    Route::group(['prefix'=>'calon_peperiksaan_sijil_tahfiz','as'=>'calon_peperiksaan_sijil_tahfiz.'], function(){
        Route::get('temuduga_syafawi/{id}', [PeperiksaanPemarkahanCalonSijilTahfizController::class, 'temuduga_syafawi'])->name('temuduga.syafawi');
        Route::get('tahriri_pengetahuan_islam/{id}', [PeperiksaanPemarkahanCalonSijilTahfizController::class, 'tahriri_pengetahuan_islam'])->name('tahriri.pengetahuan_islam');
    });
    Route::resource('calon_peperiksaan_sijil_tahfiz', PeperiksaanPemarkahanCalonSijilTahfizController::class);

    Route::resource('pengesahan_markah_sijil_tahfiz', PengesahanMarkahSijilTafiz::class);
});

Route::group(['prefix'=>'jemputan','as'=>'jemputan.'], function(){
    Route::resource('jemputan_majlis', JemputanMajlisPenyerahanSijilController::class);
});