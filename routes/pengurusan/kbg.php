<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\Pengurusan\KBG\MainKBGController;
use App\Http\Controllers\Pengurusan\KBG\PelajarController;
use App\Http\Controllers\Pengurusan\KBG\ProsesTemudugaController;
use App\Http\Controllers\Pengurusan\KBG\SenaraiPermohonanController;
use App\Http\Controllers\Pengurusan\KBG\SenaraiTapisanPermohonanController;
use Illuminate\Support\Facades\Route;




    Route::get('/', [MainKBGController::class, 'index'])->name('index');
    Route::resource('/pelajar', PelajarController::class)->only(['index',])->name('index','pengurusan.pelajar.index');
    Route::resource('/senarai_permohonan', SenaraiPermohonanController::class)->only(['index'])->name('index','pengurusan.senarai_permohonan.index');
    Route::get('senarai_permohonan/pemohon/{id}', [SenaraiPermohonanController::class, 'edit'])->name('pengurusan.senarai_permohonan.pemohon');
    Route::post('senarai_permohonan/pilih', [SenaraiPermohonanController::class, 'pilih'])->name('pengurusan.senarai_permohonan.pilih');
    Route::resource('/senarai_tapisan_permohonan', SenaraiTapisanPermohonanController::class)->only(['index'])->name('index','pengurusan.senarai_tapisan_permohonan.index');
    Route::resource('/proses_temuduga', ProsesTemudugaController::class)->only(['index','create','store'])->name('index','pengurusan.proses_temuduga.index','create','pengurusan.proses_temuduga.create','store','pengurusan.proses_temuduga.store');


    // Route::get('/permohonan', [TestController::class, 'index'])->name('permohonan');
    // Route::get('/notest', [TestController::class, 'base2'])->name('base2');
