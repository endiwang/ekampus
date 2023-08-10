<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/utama';
    public const HOME_PEMOHON = '/pemohon/utama';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('pengurusan')
                ->as('pengurusan.')
                ->group(base_path('routes/pengurusan/main.php'));

            Route::middleware('web')
                ->prefix('pengurusan/kbg')
                ->as('pengurusan.kbg.')
                ->group(base_path('routes/pengurusan/kbg.php'));

            Route::middleware('web')
                ->prefix('pengurusan/hep')
                ->as('pengurusan.hep.')
                ->group(base_path('routes/pengurusan/hep.php'));

            Route::middleware('web')
                ->prefix('pengurusan/akademik')
                ->as('pengurusan.akademik.')
                ->group(base_path('routes/pengurusan/akademik.php'));

            Route::middleware('web')
                ->prefix('pengurusan/pentadbir_sistem')
                ->as('pengurusan.pentadbir_sistem.')
                ->group(base_path('routes/pengurusan/pentadbir_sistem.php'));

            Route::middleware('web')
                ->prefix('pemohon')
                ->as('pemohon.')
                ->group(base_path('routes/pemohon/main.php'));

            Route::middleware('web')
                ->prefix('pengurusan/kakitangan')
                ->as('pengurusan.kakitangan.')
                ->group(base_path('routes/pengurusan/kakitangan.php'));

            Route::middleware('web')
                ->prefix('pelajar')
                ->as('pelajar.')
                ->group(base_path('routes/pelajar/main.php'));

            Route::middleware('web')
                ->as('public.')
                ->group(base_path('routes/public/main.php'));

            Route::middleware('web')
                ->prefix('pengurusan/komunikasi_korporat')
                ->as('pengurusan.komunikasi_korporat.')
                ->group(base_path('routes/pengurusan/komunikasi_korporat.php'));

            Route::middleware('web')
                ->prefix('pengurusan/pengajian_sepanjang_hayat/')
                ->as('pengurusan.pengajian_sepanjang_hayat.')
                ->group(base_path('routes/pengurusan/pengajian_sepanjang_hayat.php'));

            Route::middleware('web')
                ->prefix('pengurusan/perpustakaan')
                ->as('pengurusan.perpustakaan.')
                ->group(base_path('routes/pengurusan/perpustakaan.php'));

            Route::middleware('web')
                ->prefix('pengurusan/peperiksaan')
                ->as('pengurusan.peperiksaan.')
                ->group(base_path('routes/pengurusan/peperiksaan.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
