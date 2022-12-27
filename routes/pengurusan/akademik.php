<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Akademik\KelasController;
use App\Http\Controllers\Pengurusan\Akademik\KursusController;
use App\Http\Controllers\Pengurusan\Akademik\MainAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\SubjekController;

Route::resource('/', MainAkademikController::class)->only(['index',]);
Route::resource('kursus', KursusController::class);

Route::post('kelas/edit', [KelasController::class, 'edit'])->name('pengurusan_kelas.store');
Route::post('kelas/store', [KelasController::class, 'store'])->name('pengurusan_kelas.store');
Route::resource('kelas', KelasController::class);


Route::resource('subjek', SubjekController::class);

