<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('pengurusan/pentadbiran')
    ->as('pengurusan.pentadbiran.')
    ->group(base_path('routes/web/pengurusan/pentadbiran.php'));
