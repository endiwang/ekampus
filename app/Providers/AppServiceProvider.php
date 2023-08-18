<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $loader = AliasLoader::getInstance();
        // $loader->alias('vendor\realrashid\sweet-alert\src\Toaster', 'App\Helpers\CompiledRouteCollection');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(app()->environment('production')) {
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
        }
    }
}
