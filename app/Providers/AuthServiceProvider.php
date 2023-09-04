<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Kaunseling;
use App\Models\KemahiranInsaniah\PilihanRaya\Calon;
use App\Models\KemahiranInsaniah\PilihanRaya\Sesi;
use App\Models\PusatIslam\Aktiviti;
use App\Models\PusatIslam\JadualTugasan;
use App\Models\PusatIslam\KelasOrangAwam;
use App\Models\PusatIslam\PesertaKelasOrangAwam;
use App\Models\PusatIslam\RekodKehadiran;
use App\Models\PusatIslam\SuratRasmi;
use App\Policies\KaunselingPolicy;
use App\Policies\KemahiranInsaniah\CalonPilihanRayaPolicy;
use App\Policies\KemahiranInsaniah\SesiPilihanRayaPolicy;
use App\Policies\PusatIslam\AktivitiPolicy;
use App\Policies\PusatIslam\JadualTugasanPolicy;
use App\Policies\PusatIslam\KelasOrangAwamPolicy;
use App\Policies\PusatIslam\PesertaKelasOrangAwamPolicy;
use App\Policies\PusatIslam\RekodKehadiranPolicy;
use App\Policies\PusatIslam\SuratRasmiPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Kaunseling::class => KaunselingPolicy::class,
        Aktiviti::class => AktivitiPolicy::class,
        JadualTugasan::class => JadualTugasanPolicy::class,
        KelasOrangAwam::class => KelasOrangAwamPolicy::class,
        PesertaKelasOrangAwam::class => PesertaKelasOrangAwamPolicy::class,
        RekodKehadiran::class => RekodKehadiranPolicy::class,
        SuratRasmi::class => SuratRasmiPolicy::class,

        Calon::class => CalonPilihanRayaPolicy::class,
        Sesi::class => SesiPilihanRayaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
