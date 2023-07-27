<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use App\Http\Controllers\Pengurusan\Kualiti\KualitiController;

    Route::get('/index', [KualitiController::class,'index'])->name('kualiti.index');
    



