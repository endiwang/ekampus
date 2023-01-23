<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\FrontPageController;
use App\Http\Controllers\Public\PermohonanController;


Route::resource('/', FrontPageController::class)->only(['index',]);
// Route::resource('/permohonan', PermohonanController::class);

