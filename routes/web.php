<?php

require_all_in(base_path('routes/web/*.php'));

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'ajax'])
    ->prefix('datatable')
    ->as('dt.')
    ->group(function () {
        require_all_in(base_path('routes/datatable/*.php'));
    });
