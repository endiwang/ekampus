<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\PermohonanPelajarController;

    Route::get('/sesi', [SesiController::class,'index'])->name('sesi.index');
    Route::get('/sesi/tambah', [SesiController::class,'create'])->name('sesi.create');
    Route::post('/sesi/store', [SesiController::class,'store'])->name('sesi.store');

    Route::get('/permohonan_pelajar', [PermohonanPelajarController::class,'index'])->name('permohonan_pelajar.index');
    Route::get('/permohonan_pelajar/buka_baru', [PermohonanPelajarController::class,'create'])->name('permohonan_pelajar.create');
    Route::post('/permohonan_pelajar/store', [PermohonanPelajarController::class,'store'])->name('permohonan_pelajar.store');
    Route::get('/permohonan_pelajar/pinda/{id}', [PermohonanPelajarController::class,'edit'])->name('permohonan_pelajar.edit');
    Route::patch('/permohonan_pelajar/pinda/{id}', [PermohonanPelajarController::class,'update'])->name('permohonan_pelajar.update');
    Route::post('/permohonan_pelajar/fetchSesi', [PermohonanPelajarController::class,'fetchSesi'])->name('permohonan_pelajar.fetchSesi');


