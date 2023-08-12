<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('pemohon')
    ->as('pemohon.')
    ->group(base_path('routes/web/pemohon/main.php'));
