<?php

use App\Http\Controllers\LookupController;
use Illuminate\Support\Facades\Route;

Route::resource('/lookup', LookupController::class)->middleware(['web', 'auth', 'can:manage lookup']);
