<?php

use App\Http\Controllers\LookupController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\BorangKepuasanPelangganController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\KaunselingController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\LaporanKaunselingController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\RekodKaunselingController;
use App\Http\Controllers\Pengurusan\HEP\MainHEPController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\AktivitiController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\DashboardController as PusatIslamDashboardController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\JadualTugasanController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\OrangAwamController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\RekodKehadiranController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\SuratRasmiController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\DisiplinPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PengurusanSalahlakuPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PermohonanBawaBarangController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PermohonanBawaKenderaanController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\RekodKeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TatatertibRayuanPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TetapanKeluarMasukController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\BarangRampasanController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KenderaanSitaanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainHEPController::class)->only(['index']);

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::resource('keluar_masuk', KeluarMasukPelajarController::class);
    Route::resource('bawa_barang', PermohonanBawaBarangController::class);
    Route::resource('bawa_kenderaan', PermohonanBawaKenderaanController::class);
});

Route::group(['prefix' => 'tetapan', 'as' => 'tetapan.'], function () {
    Route::resource('keluar_masuk', TetapanKeluarMasukController::class);
    Route::resource('lookup', LookupController::class)->middleware(['web', 'auth']);
});

Route::group(['prefix' => 'pengurusan', 'as' => 'pengurusan.'], function () {
    Route::get('salahlaku_pelajar/{id}/siasatan', [PengurusanSalahlakuPelajarController::class, 'siasatan'])->name('salahlaku_pelajar.siasatan');
    Route::put('salahlaku_pelajar/{id}/siasatan', [PengurusanSalahlakuPelajarController::class, 'update_siasatan'])->name('salahlaku_pelajar.update_siasatan');
    Route::resource('salahlaku_pelajar', PengurusanSalahlakuPelajarController::class);
    Route::resource('keluar_masuk', RekodKeluarMasukPelajarController::class);
    Route::resource('disiplin_pelajar', DisiplinPelajarController::class);
    Route::get('tatatertib_pelajar/{id}/rayuan', [TatatertibRayuanPelajarController::class, 'rayuan'])->name('tatatertib_pelajar.rayuan');
    Route::post('tatatertib_pelajar/{id}/rayuan_store', [TatatertibRayuanPelajarController::class, 'rayuan_store'])->name('tatatertib_pelajar.rayuan_store');
    Route::resource('tatatertib_pelajar', TatatertibRayuanPelajarController::class);
    Route::resource('barang_rampasan', BarangRampasanController::class);
    Route::resource('kenderaan_sitaan',KenderaanSitaanController::class);
});

/** Kaunseling */
Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::resource('/kaunseling', KaunselingController::class);

        Route::resource('/rekod-kaunseling', RekodKaunselingController::class)->only('index', 'edit', 'update', 'show');
        Route::resource('/laporan-kaunseling', LaporanKaunselingController::class)->only('index', 'edit', 'update', 'show');
        Route::resource('/brg-kpsn-plngn-knslng', BorangKepuasanPelangganController::class)->only('edit', 'show');
    });

/** Pusat Islam */
Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::get('pusat-islam/dashboard', PusatIslamDashboardController::class)
            ->name('pusat-islam.dashboard.index');

        Route::get('pusat-islam/aktiviti', AktivitiController::class)
            ->name('pusat-islam.aktiviti.index');

        Route::get('pusat-islam/jadual-tugasan', JadualTugasanController::class)
            ->name('pusat-islam.jadual-tugasan.index');

        Route::get('pusat-islam/orang-awam', OrangAwamController::class)
            ->name('pusat-islam.orang-awam.index');

        Route::get('pusat-islam/rekod-kehadiran', RekodKehadiranController::class)
            ->name('pusat-islam.rekod-kehadiran.index');

        Route::get('pusat-islam/surat-rasmi', SuratRasmiController::class)
            ->name('pusat-islam.surat-rasmi.index');
    });
