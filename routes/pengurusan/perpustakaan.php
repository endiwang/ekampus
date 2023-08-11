<?php

use App\Http\Controllers\Pengurusan\Perpustakaan\BahanController;
use App\Http\Controllers\Pengurusan\Perpustakaan\DeklarasiController;
use App\Http\Controllers\Pengurusan\Perpustakaan\KeahlianController;
use App\Http\Controllers\Pengurusan\Perpustakaan\MainPerpustakaanController;
use App\Http\Controllers\Pengurusan\Perpustakaan\PinjamanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPerpustakaanController::class)->only(['index']);
Route::resource('keahlian', KeahlianController::class);
Route::resource('bahan', BahanController::class);
Route::post('bahan/pinjam', [BahanController::class, 'pinjam'])->name('bahan.pinjam');
Route::resource('pinjaman', PinjamanController::class);
Route::post('pinjaman/pulang', [PinjamanController::class, 'pulang'])->name('pinjaman.pulang');
Route::post('pinjaman/bayar_denda', [PinjamanController::class, 'bayar_denda'])->name('pinjaman.bayar_denda');
Route::get('deklarasi/semakan', [DeklarasiController::class, 'semakan'])->name('deklarasi.semakan');
Route::post('deklarasi/sahkan_pelajar', [DeklarasiController::class, 'sahkan_pelajar'])->name('deklarasi.sahkan_pelajar');
Route::resource('deklarasi', DeklarasiController::class);
