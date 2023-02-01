<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\Pengurusan\KBG\MainKBGController;
use App\Http\Controllers\Pengurusan\KBG\PelajarController;
use App\Http\Controllers\Pengurusan\KBG\SenaraiPermohonanController;
use Illuminate\Support\Facades\Route;




    Route::get('/', [MainKBGController::class, 'index'])->name('index');
    Route::resource('/pelajar', PelajarController::class)->only(['index',])->name('index','pengurusan.pelajar.index');
    Route::resource('/senarai_permohonan', SenaraiPermohonanController::class)->only(['index',])->name('index','pengurusan.senarai_permohonan.index');
    // Route::get('/permohonan', [TestController::class, 'index'])->name('permohonan');
    // Route::get('/notest', [TestController::class, 'base2'])->name('base2');
