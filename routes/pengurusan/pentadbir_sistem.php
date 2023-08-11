<?php

use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\KakitanganController;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\PermohonanPelajarController;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\PusatTemudugaController;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use Illuminate\Support\Facades\Route;

Route::get('/sesi', [SesiController::class, 'index'])->name('sesi.index');
Route::get('/sesi/tambah', [SesiController::class, 'create'])->name('sesi.create');
Route::post('/sesi/store', [SesiController::class, 'store'])->name('sesi.store');
Route::get('/sesi/pinda/{id}', [SesiController::class, 'edit'])->name('sesi.edit');
Route::patch('/sesi/pinda/{id}', [SesiController::class, 'update'])->name('sesi.update');

Route::get('/permohonan_pelajar', [PermohonanPelajarController::class, 'index'])->name('permohonan_pelajar.index');
Route::get('/permohonan_pelajar/buka_baru', [PermohonanPelajarController::class, 'create'])->name('permohonan_pelajar.create');
Route::post('/permohonan_pelajar/store', [PermohonanPelajarController::class, 'store'])->name('permohonan_pelajar.store');
Route::get('/permohonan_pelajar/pinda/{id}', [PermohonanPelajarController::class, 'edit'])->name('permohonan_pelajar.edit');
Route::patch('/permohonan_pelajar/pinda/{id}', [PermohonanPelajarController::class, 'update'])->name('permohonan_pelajar.update');
Route::post('/permohonan_pelajar/fetchSesi', [PermohonanPelajarController::class, 'fetchSesi'])->name('permohonan_pelajar.fetchSesi');

Route::get('/kakitangan', [KakitanganController::class, 'index'])->name('kakitangan.index');
Route::get('/kakitangan/{id}/profil', [KakitanganController::class, 'show'])->name('kakitangan.show');
Route::get('/kakitangan/{id}/pinda', [KakitanganController::class, 'edit'])->name('kakitangan.edit');

Route::resource('/pusat_temuduga', PusatTemudugaController::class)->only(['index', 'create', 'store', 'edit', 'destroy', 'update'])
    ->name(
        'index', 'pusat_temuduga.index',
        'create', 'pusat_temuduga.create',
        'store', 'pengurusan.pentadbir_sistem.pusat_temuduga.store',
        'edit', 'pengurusan.pentadbir_sistem.pusat_temuduga.edit',
        'edit', 'pengurusan.pentadbir_sistem.pusat_temuduga.update',
        'destroy', 'pengurusan.pentadbir_sistem.pusat_temuduga.destroy',
    );
