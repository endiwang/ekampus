<?php

use App\Http\Controllers\Kaunseling\DashboardController;
use App\Http\Controllers\Kaunseling\KaunselingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->prefix('kaunseling')
    ->as('kaunseling.')
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)
            ->name('dashboard.index');

        Route::resource('/', KaunselingController::class);
    });
