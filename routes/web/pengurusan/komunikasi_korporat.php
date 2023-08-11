<?php

use App\Http\Controllers\Pengurusan\Komunikasi_Korporat\KajiSelidikController;
use App\Http\Controllers\Pengurusan\Komunikasi_Korporat\MainKomunikasiKorporatController;
use Illuminate\Support\Facades\Route;

Route::resource('///', MainKomunikasiKorporatController::class);
Route::resource('/kaji_selidik', KajiSelidikController::class);
Route::get('kaji_selidik/{id}/design_form', [KajiSelidikController::class, 'design_form'])->name('kaji_selidik.design_form');
Route::put('kaji_selidik/{id}/design_update', [KajiSelidikController::class, 'design_update'])->name('kaji_selidik.design_update');
Route::put('kaji_selidik/jawapan/{id}', [KajiSelidikController::class, 'fill_store'])->name('kaji_selidik.fill_store');
Route::get('kaji_selidik/data_chart/{id}', [KajiSelidikController::class, 'data_chart'])->name('kaji_selidik.data_chart');
Route::get('kaji_selidik/analisa/{id}', [KajiSelidikController::class, 'result_survey'])->name('kaji_selidik.analisa');
