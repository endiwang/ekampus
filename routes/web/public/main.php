<?php

use App\Http\Controllers\Pelajar\MainPelajarController;
use App\Http\Controllers\Pengurusan\Kewangan\YuranController;
use App\Http\Controllers\Public\FrontPageController;
use App\Http\Controllers\Public\KomunikasiKorporatController;
use App\Http\Controllers\Public\KajianKeberkesananGraduanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', FrontPageController::class)->only(['index']);

Route::get('/kaji_selidik/{id}', [KomunikasiKorporatController::class, 'index'])->name('kaji_selidik.index');
Route::get('/kajian_keberkesanan_graduan/{id}', [KajianKeberkesananGraduanController::class, 'index'])->name('kajian_graduan.index');
Route::post('/kajian_keberkesanan_graduan/{id}/submit', [KajianKeberkesananGraduanController::class, 'fill_store'])->name('kajian_graduan.fill_store');

Route::get('/invois/{id}', [YuranController::class, 'show'])->name('yuran.invois');
Route::get('/resit/{id}', [YuranController::class, 'show'])->name('yuran.resit');
Route::get('/pelajar/find', [MainPelajarController::class, 'find'])->name('pelajar.find');
