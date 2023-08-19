<?php

use App\Http\Controllers\PusatIslam\AktivitiController;
use App\Http\Controllers\PusatIslam\DashboardController;
use App\Http\Controllers\PusatIslam\JadualTugasanController;
use App\Http\Controllers\PusatIslam\SuratRasmiController;
use App\Http\Controllers\PusatIslam\OrangAwamController;
use App\Http\Controllers\PusatIslam\RekodKehadiranController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::get('pusat-islam/dashboard', DashboardController::class)
            ->name('pusat-islam.dashboard.index');

        Route::get('pusat-islam/aktiviti', AktivitiController::class)
            ->name('pusat-islam.aktiviti.index');

        Route::get('pusat-islam/jadual-tugasan', JadualTugasanController::class)
            ->name('pusat-islam.jadual-tugasan.index');

        Route::get('pusat-islam/orang-awam', OrangAwamController::class)
            ->name('pusat-islam.orang-awam.index');

        Route::get('pusat-islam/rekod-kehadiran', RekodKehadiranController::class)
            ->name('pusat-islam.rekod-kehadiran.index');

        Route::get('pusat-islam/surat-rasmi', SuratRasmiController::class)
            ->name('pusat-islam.surat-rasmi.index');
    });
