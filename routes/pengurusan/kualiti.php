<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use App\Http\Controllers\Pengurusan\Kualiti\KualitiController;

    Route::get('/index', [KualitiController::class,'index'])->name('kualiti.index');
    Route::get('/tambah', [KualitiController::class,'create'])->name('kualiti.create');
    Route::post('/store', [KualitiController::class, 'store'])->name('kualiti.store');
    Route::get('/edit/{id}', [KualitiController::class,'edit'])->name('kualiti.show');
    Route::post('/update', [KualitiController::class, 'update'])->name('kualiti.update');

    



