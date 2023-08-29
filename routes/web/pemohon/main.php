<?php

use App\Http\Controllers\Pemohon\MainPemohonController;
use App\Http\Controllers\Pemohon\PermohonanController;
use App\Http\Controllers\Pemohon\RayuanController;
use App\Http\Controllers\Pemohon\SemakanController;
use App\Http\Controllers\Pemohon\Sijil_Tahfiz\PermohonanSijilTahfizController;
use App\Http\Controllers\Pemohon\Sijil_Tahfiz\SemakanKelayakanSijilTahfizController;
use App\Http\Controllers\Pemohon\Sijil_Tahfiz\SemakanKeputusanPeperiksaanSijilTahfizController;
use App\Http\Controllers\Pemohon\TawaranController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth_pemohon']], function () {
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

    Route::group(['prefix'=>'permohonan_sijil_tahfiz','as'=>'permohonan_sijil_tahfiz.'], function(){
        Route::get('fetchPusatPeperiksaan', [PermohonanSijilTahfizController::class, 'fetchPusatPeperiksaan'])->name('fetchPusatPeperiksaan');
        Route::get('fetchPusatPeperiksaanNegeri', [PermohonanSijilTahfizController::class, 'fetchPusatPeperiksaanNegeri'])->name('fetchPusatPeperiksaan.negeri');
        Route::get('setujuTerimaTawaran/{id}', [PermohonanSijilTahfizController::class, 'setujuTerimaTawaran'])->name('setujuTerima.tawaran');
        Route::patch('setujuTerimaTawaran/update/{id}', [PermohonanSijilTahfizController::class, 'setujuTerimaTawaranJawapan'])->name('setujuTerima.tawaran.jawapan');
        Route::get('setujuTerimaTawaran/export_pdf/{id}', [PermohonanSijilTahfizController::class, 'exportPdf'])->name('setujuTerima.tawaran.download.slip');
        
        Route::resource('semakan_permohonan_sijil_tahfiz', SemakanKelayakanSijilTahfizController::class);
        Route::group(['prefix'=>'semakan_keputusan_sijil_tahfiz','as'=>'semakan_keputusan_sijil_tahfiz.'], function(){
            Route::get('/download/keputusan_sementara/{id}', [SemakanKeputusanPeperiksaanSijilTahfizController::class, 'downloadPdf'])->name('keputusan_sementara.downloadPdf');
        });
        Route::resource('semakan_keputusan_sijil_tahfiz', SemakanKeputusanPeperiksaanSijilTahfizController::class);
    });

    Route::resource('/permohonan_sijil_tahfiz',PermohonanSijilTahfizController::class);
    // Route::get('/permohonan_sijil_tahfiz', [PermohonanSijilTahfizController::class, 'index'])->name('permohonan_sijil_tahfiz.index');
    // Route::get('/permohonan_sijil_tahfiz/create', [PermohonanSijilTahfizController::class, 'create'])->name('permohonan_sijil_tahfiz.create');
    // Route::post('/permohonan_sijil_tahfiz/store', [PermohonanSijilTahfizController::class, 'store'])->name('permohonan_sijil_tahfiz.store');
    // Route::get('/permohonan_sijil_tahfiz/edit/{id}', [PermohonanSijilTahfizController::class, 'edit'])->name('permohonan_sijil_tahfiz.edit');
    // Route::patch('/permohonan_sijil_tahfiz/update/{id}', [PermohonanSijilTahfizController::class, 'update'])->name('permohonan_sijil_tahfiz.update');
    // Route::delete('/permohonan_sijil_tahfiz/destroy/{id}', [PermohonanSijilTahfizController::class, 'destroy'])->name('permohonan_sijil_tahfiz.destroy');
});

