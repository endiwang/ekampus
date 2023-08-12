<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('pengurusan/kualiti')
    ->as('pengurusan.kualiti.')
    ->group(base_path('routes/web/pengurusan/kualiti.php'));
