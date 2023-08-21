<?php

use App\Http\Controllers\Pengurusan\HEP\Kaunseling\KaunselingDatatableController;
use Illuminate\Support\Facades\Route;

Route::match(['post', 'get'], 'kaunseling', KaunselingDatatableController::class)->name('kaunseling');
