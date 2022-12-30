<?php

use App\Http\Controllers\Pengurusan\Akademik\GuruTasmikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Akademik\KelasController;
use App\Http\Controllers\Pengurusan\Akademik\KursusController;
use App\Http\Controllers\Pengurusan\Akademik\MainAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\SubjekController;

Route::resource('/', MainAkademikController::class)->only(['index',]);
Route::resource('kursus', KursusController::class);

Route::post('kelas/export/by_class', [KelasController::class, 'exportStudentByClass'])->name('pengurusan_kelas.export_by_class');
Route::post('kelas/edit', [KelasController::class, 'edit'])->name('pengurusan_kelas.store');
Route::post('kelas/store', [KelasController::class, 'store'])->name('pengurusan_kelas.store');
Route::resource('kelas', KelasController::class);

Route::post('subjek/store', [SubjekController::class, 'store'])->name('pengurusan_subjek.store');
Route::get('subjek/edit/{id}/{course_id}', [SubjekController::class, 'edit'])->name('pengurusan_subjek.edit');
Route::get('subjek/create/{id}', [SubjekController::class, 'create'])->name('pengurusan_subjek.create');
Route::resource('subjek', SubjekController::class);


Route::resource('guru_tasmik', GuruTasmikController::class);

