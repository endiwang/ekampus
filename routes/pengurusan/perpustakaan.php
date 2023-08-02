<?php

use App\Http\Controllers\Pengurusan\Perpustakaan\BahanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Perpustakaan\KeahlianController;
use App\Http\Controllers\Pengurusan\Perpustakaan\MainPerpustakaanController;
use App\Http\Controllers\Pengurusan\Perpustakaan\PinjamanController;

Route::resource('/', MainPerpustakaanController::class)->only(['index',]);
Route::resource('keahlian', KeahlianController::class);
Route::resource('bahan', BahanController::class);
Route::post('bahan/pinjam', [BahanController::class, 'pinjam'])->name('bahan.pinjam');
Route::resource('pinjaman', PinjamanController::class);
Route::post('pinjaman/pulang', [PinjamanController::class, 'pulang'])->name('pinjaman.pulang');
Route::post('pinjaman/bayar_denda', [PinjamanController::class, 'bayar_denda'])->name('pinjaman.bayar_denda');



