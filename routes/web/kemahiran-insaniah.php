<?php

use App\Http\Controllers\KemahiranInsaniah\PilihanRayaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->group(function() {
        Route::get('/kemahiran-insaniah.pilihan-raya', PilihanRayaController::class)
            ->name('kemahiran-insaniah.pilihan-raya.index');
    });
