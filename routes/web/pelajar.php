<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('pelajar')
    ->as('pelajar.')
    ->group(base_path('routes/web/pelajar/main.php'));
