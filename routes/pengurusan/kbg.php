<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;




    Route::get('/permohonan', [TestController::class, 'index'])->name('permohonan');
    // Route::get('/notest', [TestController::class, 'base2'])->name('base2');
