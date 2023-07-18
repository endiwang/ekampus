<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\FrontPageController;
use App\Http\Controllers\Public\KomunikasiKorporatController;
use App\Http\Controllers\Public\PermohonanController;


Route::resource('/', FrontPageController::class)->only(['index',]);

Route::get('/kaji_selidik/{id}', [KomunikasiKorporatController::class, 'index'])->name('kaji_selidik.index');


