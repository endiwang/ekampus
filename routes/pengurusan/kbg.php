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
    Route::get('senarai_permohonan/update/{id}', [SenaraiPermohonanController::class, 'edit'])->name('pengurusan.senarai_permohonan.update');
    Route::resource('/senarai_tapisan_permohonan', SenaraiTapisanPermohonanController::class)->only(['index'])->name('index','pengurusan.senarai_tapisan_permohonan.index');
    Route::resource('/proses_temuduga', ProsesTemudugaController::class)->only(['index'])->name('index','pengurusan.proses_temuduga.index');


    // Route::get('/permohonan', [TestController::class, 'index'])->name('permohonan');
    // Route::get('/notest', [TestController::class, 'base2'])->name('base2');
