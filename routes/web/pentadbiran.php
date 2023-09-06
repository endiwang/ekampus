<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])
    ->prefix('pengurusan/pentadbiran')
    ->as('pengurusan.pentadbiran.')
    ->group(base_path('routes/web/pengurusan/pentadbiran.php'));
