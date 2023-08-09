<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use App\Http\Controllers\Pengurusan\Kualiti\KualitiController;

    Route::get('/index', [KualitiController::class,'index'])->name('kualiti.index');
    Route::get('/tambah', [KualitiController::class,'create'])->name('kualiti.create');
    Route::post('/store', [KualitiController::class, 'store'])->name('kualiti.store');
    Route::get('/edit/{id}', [KualitiController::class,'edit'])->name('kualiti.show');
    Route::post('/update', [KualitiController::class, 'update'])->name('kualiti.update');

    Route::get('/kursus/index', [KualitiController::class,'kursusIndex'])->name('kursus.index');
    Route::get('/kursus/tambah', [KualitiController::class,'kursusTambah'])->name('kursus.tambah');
    Route::post('/kursus/store', [KualitiController::class, 'kursusStore'])->name('kursus.store');
    Route::get('/kursus/edit/{id}', [KualitiController::class,'kursusEdit'])->name('kursus.show');
    Route::post('/kursus/update', [KualitiController::class, 'kursusUpdate'])->name('kursus.update');
    Route::get('/kursus/download/{id}', [KualitiController::class, 'download'])->name('kursus.download');
    Route::post('/kursus/delete', [KualitiController::class, 'kursusDestroy'])->name('kursus.destroy');


    



