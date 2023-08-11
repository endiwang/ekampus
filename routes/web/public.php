<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->as('public.')
    ->group(base_path('routes/web/public/main.php'));
