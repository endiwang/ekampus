<?php

use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\MainKolejKediamanController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PengurusanBlokController;
use App\Http\Controllers\Pengurusan\HEP\KolejKediaman\PengurusanBilikController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainKolejKediamanController::class)->only(['index']);
Route::resource('/pengurusan_blok', PengurusanBlokController::class);
Route::resource('/pengurusan_bilik', PengurusanBilikController::class);
