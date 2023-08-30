<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('alumni')
    ->as('alumni.')
    ->group(base_path('routes/web/alumni/main.php'));