<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Akademik\KursusController;
use App\Http\Controllers\Pengurusan\Akademik\MainAkademikController;


Route::resource('/', MainAkademikController::class)->only(['index',]);
Route::resource('kursus', KursusController::class);

