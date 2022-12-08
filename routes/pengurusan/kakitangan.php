<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Kakitangan\MainKakitanganController;


Route::resource('/', MainKakitanganController::class)->only(['index',]);

