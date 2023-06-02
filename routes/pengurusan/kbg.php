<?php

use App\Http\Controllers\Pengurusan\KBG\CetakSijilController;
use App\Http\Controllers\Pengurusan\KBG\KeputusanTemudugaController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Pengurusan\KBG\MainKBGController;
use App\Http\Controllers\Pengurusan\KBG\PelajarController;
use App\Http\Controllers\Pengurusan\KBG\PelajarTamatController;
use App\Http\Controllers\Pengurusan\KBG\PendaftaranNoMatrikController;
use App\Http\Controllers\Pengurusan\KBG\TawaranController;
use App\Http\Controllers\Pengurusan\KBG\ProsesTemudugaController;
use App\Http\Controllers\Pengurusan\KBG\SenaraiPermohonanController;
use App\Http\Controllers\Pengurusan\KBG\SenaraiTapisanPermohonanController;
use App\Http\Controllers\Pengurusan\KBG\PendaftaranPelajarController;
use App\Http\Controllers\Pengurusan\KBG\ProsesBerhentiController;
use App\Http\Controllers\Pengurusan\KBG\SenaraiKonvokesyenController;
use Illuminate\Support\Facades\Route;




    Route::get('/', [MainKBGController::class, 'index'])->name('index');
    Route::resource('/pelajar', PelajarController::class)->only(['index',])->name('index','pengurusan.pelajar.index');
    Route::resource('/senarai_permohonan', SenaraiPermohonanController::class)->only(['index'])->name('index','pengurusan.senarai_permohonan.index');
    Route::get('senarai_permohonan/pemohon/{id}', [SenaraiPermohonanController::class, 'edit'])->name('pengurusan.senarai_permohonan.pemohon');
    Route::post('senarai_permohonan/pilih', [SenaraiPermohonanController::class, 'pilih'])->name('pengurusan.senarai_permohonan.pilih');

    Route::resource('/senarai_tapisan_permohonan', SenaraiTapisanPermohonanController::class)->only(['index'])->name('index','pengurusan.senarai_tapisan_permohonan.index');
    Route::get('/senarai_tapisan_permohonan/proses_pemilihan', [SenaraiTapisanPermohonanController::class,'proses_pemilihan'])->name('pengurusan.senarai_tapisan_permohonan.proses_pemilihan');

    Route::resource('/proses_temuduga', ProsesTemudugaController::class)->only(['index','create','store','show','update'])->name('index','pengurusan.proses_temuduga.index','create','pengurusan.proses_temuduga.create','store','pengurusan.proses_temuduga.store','show','pengurusan.proses_temuduga.show','update','pengurusan.proses_temuduga.update');
    Route::get('/proses_temuduga/{id}/pilih_pemohon', [ProsesTemudugaController::class, 'pilih_pemohon'])->name('pengurusan.proses_temuduga.pilih_pemohon');
    Route::get('/proses_temuduga_api/{id}', [ProsesTemudugaController::class, 'pilih_pemohon_api'])->name('pengurusan.proses_temuduga.pilih_pemohon_api');
    Route::post('/proses_temuduga_store_pemohon', [ProsesTemudugaController::class, 'store_pemohon'])->name('pengurusan.proses_temuduga.store_pemohon');
    Route::get('proses_temuduga/export_senarai/{id}', [ProsesTemudugaController::class, 'export_senarai'])->name('pengurusan.proses_temuduga.export_senarai');


    Route::resource('/keputusan_temuduga', KeputusanTemudugaController::class)->only(['index','store'])->name('index','pengurusan.keputusan_temuduga.index','store','pengurusan.keputusan_temuduga.store');
    Route::get('keputusan_temuduga/export_senarai/{id}', [KeputusanTemudugaController::class, 'export_senarai'])->name('pengurusan.keputusan_temuduga.export_senarai');


    Route::get('/keputusan_temuduga/{id}/kemas_kini_markah', [KeputusanTemudugaController::class,'kemas_kini_markah'])->name('pengurusan.keputusan_temuduga.kemas_kini_markah');

    Route::resource('/tawaran', TawaranController::class)->only(['index','create','store','show','update'])->name('index','pengurusan.tawaran.index','create','pengurusan.tawaran.create','store','pengurusan.tawaran.store','show','pengurusan.tawaran.show','update','pengurusan.tawaran.update');
    Route::get('tawaran/{id}/pilih_pelajar', [TawaranController::class, 'pilih_pelajar'])->name('pengurusan.tawaran.pilih_pelajar');
    Route::get('tawaran/pilih_pelajar/{id}', [TawaranController::class, 'pilih_pelajar_api'])->name('pengurusan.tawaran.pilih_pelajar_api');
    Route::post('tawaran/store_pelajar', [TawaranController::class, 'store_pelajar'])->name('pengurusan.tawaran.store_pelajar');
    Route::get('tawaran/export_senarai/{id}', [TawaranController::class, 'export_senarai'])->name('pengurusan.tawaran.export_senarai');




    Route::resource('/pendaftaran_pelajar', PendaftaranPelajarController::class)->only(['index','store'])->name('index','pengurusan.pendaftaran_pelajar.index','store','pengurusan.pendaftaran_pelajar.store');
    Route::post('/pendaftaran_pelajar/maklumat_pelajar', [PendaftaranPelajarController::class, 'getMaklumatPelajar'])->name('pengurusan.pendaftaran_pelajar.getMaklumatPelajar');

    Route::resource('/pendaftaran_no_matrik', PendaftaranNoMatrikController::class)->only(['index','store'])->name('index','pengurusan.pendaftaran_no_matrik.index','store','pengurusan.pendaftaran_no_matrik.store');
    Route::post('/pendaftaran_no_matrik/maklumat_pelajar', [PendaftaranNoMatrikController::class, 'getMaklumatPelajar'])->name('pengurusan.pendaftaran_no_matrik.getMaklumatPelajar');

    Route::resource('/proses_berhenti', ProsesBerhentiController::class)->only(['index','store'])->name('index','pengurusan.proses_berhenti.index','store','pengurusan.proses_berhenti.store');
    Route::post('/proses_berhenti/maklumat_pelajar', [ProsesBerhentiController::class, 'getMaklumatPelajar'])->name('pengurusan.proses_berhenti.getMaklumatPelajar');

    Route::resource('/pelajar_tamat', PelajarTamatController::class)->only(['index'])->name('index','pengurusan.pelajar_tamat.index');

    Route::resource('/cetak_sijil', CetakSijilController::class)->only(['index'])->name('index','pengurusan.cetak_sijil.index');
    Route::resource('/konvokesyen', SenaraiKonvokesyenController::class)->only(['index','create','store','show','update'])->name('index','pengurusan.konvokesyen.index','create','pengurusan.konvokesyen.create','store','pengurusan.konvokesyen.store','show','pengurusan.konvokesyen.show','update','pengurusan.konvokesyen.update');
    Route::get('konvokesyen/{id}/pilih_pelajar', [SenaraiKonvokesyenController::class, 'pilih_pelajar'])->name('pengurusan.konvokesyen.pilih_pelajar');
    Route::get('konvokesyen/pilih_pelajar/{id}', [SenaraiKonvokesyenController::class, 'pilih_pelajar_api'])->name('pengurusan.konvokesyen.pilih_pelajar_api');
    Route::post('konvokesyen/store_pelajar', [SenaraiKonvokesyenController::class, 'store_pelajar'])->name('pengurusan.konvokesyen.store_pelajar');
    Route::get('konvokesyen/export_senarai/{id}', [SenaraiKonvokesyenController::class, 'export_senarai'])->name('pengurusan.konvokesyen.export_senarai');









    // Route::get('/permohonan', [TestController::class, 'index'])->name('permohonan');
    // Route::get('/notest', [TestController::class, 'base2'])->name('base2');
