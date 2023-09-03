<?php

use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PenerimaSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PengesahanMarkahSijilTafiz;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PeperiksaanPemarkahanCalonSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\PermohonanController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPenemudugaSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPeperiksaanSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanPusatPeperiksaanController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanTemplateSijilTahfiz;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanMajlisPenyerahanSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\TetapanTemplateJemputanSijilController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\JemputanMajlisPenyerahanSijilController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\MainPengajianSepanjangHayatController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\RekodAnalisaSijilTahfizController;
use App\Http\Controllers\Pengurusan\PengajianSepanjangHayat\VenuePeperiksaanSijilTahfizController;
use Illuminate\Support\Facades\Route;


Route::resource('/', MainPengajianSepanjangHayatController::class)->only(['index']);
Route::group(['prefix'=>'tetapan','as'=>'tetapan.'], function(){
    Route::resource('sesi_peperiksaan_sijil_tahfiz', TetapanPeperiksaanSijilTahfizController::class);

    Route::resource('pusat_peperiksaan_sijil_tahfiz', TetapanPusatPeperiksaanController::class);

    Route::group(['prefix'=>'penemuduga_sijil_tahfiz','as'=>'penemuduga_sijil_tahfiz.'], function(){
        Route::get('fetchPusatPeperiksaan', [TetapanPenemudugaSijilTahfizController::class, 'fetchPusatPeperiksaan'])->name('fetchPusatPeperiksaan');
        Route::get('fetchPusatPeperiksaanNegeri', [TetapanPenemudugaSijilTahfizController::class, 'fetchPusatPeperiksaanNegeri'])->name('fetchPusatPeperiksaan.negeri');
    });
    Route::resource('penemuduga_sijil_tahfiz', TetapanPenemudugaSijilTahfizController::class);
    Route::resource('majlis_penyerahan_sijil_tahfiz', TetapanMajlisPenyerahanSijilTahfizController::class);
    Route::resource('template_jemputan_sijil', TetapanTemplateJemputanSijilController::class);

    Route::resource('template_sijil_tahfiz', TetapanTemplateSijilTahfiz::class);

    Route::resource('venue_peperiksaan_sijil_tahfiz', VenuePeperiksaanSijilTahfizController::class);
});

Route::group(['prefix'=>'proses_permohonan','as'=>'proses_permohonan.'], function(){
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

Route::group(['prefix'=>'pengurusan_sijil_tahfiz','as'=>'pengurusan_sijil_tahfiz.'], function(){
    Route::group(['prefix'=>'penerima_sijil_tahfiz','as'=>'penerima_sijil_tahfiz.'], function(){
        Route::get('jana_sijil/{id}', [PenerimaSijilTahfizController::class, 'jana_sijil'])->name('jana_sijil');
        Route::get('download_sijil/{id}', [PenerimaSijilTahfizController::class, 'download_sijil'])->name('download_sijil');
        Route::get('pengambilan_sijil/{id}', [PenerimaSijilTahfizController::class, 'pengambilan_sijil'])->name('pengambilan_sijil');
        Route::post('pengambilan_sijil/{id}/store', [PenerimaSijilTahfizController::class, 'pengambilan_sijil_store'])->name('pengambilan_sijil.store');
    });
    Route::resource('penerima_sijil_tahfiz', PenerimaSijilTahfizController::class);

});

Route::group(['prefix'=>'jemputan','as'=>'jemputan.'], function(){
    Route::resource('jemputan_majlis', JemputanMajlisPenyerahanSijilController::class);
});

Route::group(['prefix'=>'laporan','as'=>'laporan.'], function(){
    Route::group(['prefix'=>'rekod_analisa','as'=>'rekod_analisa.'], function(){
        Route::post('analisa_negeri', [RekodAnalisaSijilTahfizController::class, 'analisa_negeri'])->name('analisa_negeri');
        Route::post('analisa_siri_peperiksaan', [RekodAnalisaSijilTahfizController::class, 'analisa_siri_peperiksaan'])->name('analisa_siri_peperiksaan');
        Route::get('analisa_peringkat_kelulusan', [RekodAnalisaSijilTahfizController::class, 'analisa_peringkat_kelulusan'])->name('analisa_peringkat_kelulusan');
    });
    Route::resource('rekod_analisa', RekodAnalisaSijilTahfizController::class);
});

