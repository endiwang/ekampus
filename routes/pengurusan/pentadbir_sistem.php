<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;

    Route::resource('/sesi', SesiController::class)->only(['index',])->name('index','sesi.index');
