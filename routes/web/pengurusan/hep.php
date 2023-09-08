<?php

use App\Http\Controllers\LookupController;
use App\Http\Controllers\Pengurusan\HEP\Alumni\AlumniController;
use App\Http\Controllers\Pengurusan\HEP\Alumni\KajianKeberkesananGraduanController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\BorangKepuasanPelangganController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\KaunselingController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\LaporanKaunselingController;
use App\Http\Controllers\Pengurusan\HEP\Kaunseling\RekodKaunselingController;
use App\Http\Controllers\Pengurusan\HEP\KemahiranInsaniah\PilihanRayaController;
use App\Http\Controllers\Pengurusan\HEP\MainHEPController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\AktivitiController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\JadualTugasanController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\OrangAwamController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\PusatIslamController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\RekodKehadiranController;
use App\Http\Controllers\Pengurusan\HEP\PusatIslam\SuratRasmiController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\BarangRampasanController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\DisiplinPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\KenderaanSitaanController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PengurusanProgramPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PengurusanSalahlakuPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PermohonanBawaBarangController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\PermohonanBawaKenderaanController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\RekodKeluarMasukPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TatatertibRayuanPelajarController;
use App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin\TetapanKeluarMasukController;
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
    Route::get('barang_rampasan/{id}/tuntutan', [BarangRampasanController::class, 'tuntutan_barang'])->name('barang_rampasan.tuntutan');
    Route::put('barang_rampasan/{id}/tuntutan', [BarangRampasanController::class, 'tuntutan_barang_store'])->name('barang_rampasan.tuntutan');
    Route::resource('barang_rampasan', BarangRampasanController::class);
    Route::get('kenderaan_sitaan/{id}/tuntutan', [KenderaanSitaanController::class, 'tuntutan_kenderaan'])->name('kenderaan_sitaan.tuntutan');
    Route::put('kenderaan_sitaan/{id}/tuntutan', [KenderaanSitaanController::class, 'tuntutan_kenderaan_store'])->name('kenderaan_sitaan.tuntutan');
    Route::resource('kenderaan_sitaan', KenderaanSitaanController::class);
    Route::get('program_pelajar/{id}/pilih_pelajar', [PengurusanProgramPelajarController::class, 'pilih_pelajar'])->name('program_pelajar.pilih_pelajar');
    Route::post('program_pelajar/{id}/pilih_pelajar_store', [PengurusanProgramPelajarController::class, 'pilih_pelajar_store'])->name('program_pelajar.pilih_pelajar_store');
    Route::delete('program_pelajar/{id}/pilih_pelajar_destroy/{kehadiran_id}', [PengurusanProgramPelajarController::class, 'pilih_pelajar_destroy'])->name('program_pelajar.pilih_pelajar_destroy');
    Route::get('program_pelajar/{id}/qr_code_kehadiran/', [PengurusanProgramPelajarController::class, 'qr_code_kehadiran'])->name('program_pelajar.qr_code_kehadiran');
    Route::get('program_pelajar/{id}/muat_turun_qr_sesi/{sesi}/', [PengurusanProgramPelajarController::class, 'muat_turun_qr_sesi'])->name('program_pelajar.muat_turun_qr_sesi');
    Route::get('program_pelajar/{id}/submit_kehadiran_program/{sesi}/', [PengurusanProgramPelajarController::class, 'submit_kehadiran_program'])->name('program_pelajar.submit_kehadiran_program');
    Route::resource('program_pelajar',PengurusanProgramPelajarController::class);
});

/** Kemahiran Insaniah */
Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::get('kemahiran-insaniah/pilihan-raya', [PilihanRayaController::class, 'index'])
            ->name('kemahiran-insaniah.pilihan-raya.index');
        Route::get('kemahiran-insaniah/pilihan-raya/create', [PilihanRayaController::class, 'create'])
            ->name('kemahiran-insaniah.pilihan-raya.create');
        Route::get('kemahiran-insaniah/pilihan-raya/{id}/edit', [PilihanRayaController::class, 'edit'])
            ->name('kemahiran-insaniah.pilihan-raya.edit');
        Route::get('kemahiran-insaniah/pilihan-raya/{id}/show', [PilihanRayaController::class, 'show'])
            ->name('kemahiran-insaniah.pilihan-raya.show');
        Route::delete('kemahiran-insaniah/pilihan-raya/{id}', [PilihanRayaController::class, 'destroy'])
            ->name('kemahiran-insaniah.pilihan-raya.destroy');
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
        Route::get('pusat-islam/', PusatIslamController::class)
            ->name('pusat-islam.index');

        Route::get('pusat-islam/aktiviti', [AktivitiController::class, 'index'])
            ->name('pusat-islam.aktiviti.index');
        Route::get('pusat-islam/aktiviti/create', [AktivitiController::class, 'create'])
            ->name('pusat-islam.aktiviti.create');
        Route::get('pusat-islam/aktiviti/{id}/edit', [AktivitiController::class, 'edit'])
            ->name('pusat-islam.aktiviti.edit');
        Route::get('pusat-islam/aktiviti/{id}/show', [AktivitiController::class, 'show'])
            ->name('pusat-islam.aktiviti.show');
        Route::delete('pusat-islam/aktiviti/{id}', [AktivitiController::class, 'destroy'])
            ->name('pusat-islam.aktiviti.destroy');

        Route::get('pusat-islam/jadual-tugasans', [JadualTugasanController::class, 'index'])
            ->name('pusat-islam.jadual-tugasans.index');
        Route::get('pusat-islam/jadual-tugasans/create', [JadualTugasanController::class, 'create'])
            ->name('pusat-islam.jadual-tugasans.create');
        Route::get('pusat-islam/jadual-tugasans/{id}/edit', [JadualTugasanController::class, 'edit'])
            ->name('pusat-islam.jadual-tugasans.edit');
        Route::get('pusat-islam/jadual-tugasans/{id}/show', [JadualTugasanController::class, 'show'])
            ->name('pusat-islam.jadual-tugasans.show');
        Route::delete('pusat-islam/jadual-tugasans/{id}', [JadualTugasanController::class, 'destroy'])
            ->name('pusat-islam.jadual-tugasans.destroy');

        Route::get('pusat-islam/orang-awam', [OrangAwamController::class, 'index'])
            ->name('pusat-islam.orang-awam.index');
        Route::get('pusat-islam/orang-awam/create', [OrangAwamController::class, 'create'])
            ->name('pusat-islam.orang-awam.create');
        Route::get('pusat-islam/orang-awam/{id}/edit', [OrangAwamController::class, 'edit'])
            ->name('pusat-islam.orang-awam.edit');
        Route::get('pusat-islam/orang-awam/{id}/show', [OrangAwamController::class, 'show'])
            ->name('pusat-islam.orang-awam.show');
        Route::delete('pusat-islam/orang-awam/{id}', [OrangAwamController::class, 'destroy'])
            ->name('pusat-islam.orang-awam.destroy');

        Route::get('pusat-islam/rekod-kehadiran', [RekodKehadiranController::class, 'index'])
            ->name('pusat-islam.rekod-kehadiran.index');
        Route::get('pusat-islam/rekod-kehadiran/create', [RekodKehadiranController::class, 'create'])
            ->name('pusat-islam.rekod-kehadiran.create');
        Route::get('pusat-islam/rekod-kehadiran/{id}/edit', [RekodKehadiranController::class, 'edit'])
            ->name('pusat-islam.rekod-kehadiran.edit');
        Route::get('pusat-islam/rekod-kehadiran/{id}/show', [RekodKehadiranController::class, 'show'])
            ->name('pusat-islam.rekod-kehadiran.show');
        Route::delete('pusat-islam/rekod-kehadiran/{id}', [RekodKehadiranController::class, 'destroy'])
            ->name('pusat-islam.rekod-kehadiran.destroy');

        Route::get('pusat-islam/surat-rasmi', [SuratRasmiController::class, 'index'])
            ->name('pusat-islam.surat-rasmi.index');
        Route::get('pusat-islam/surat-rasmi/create', [SuratRasmiController::class, 'create'])
            ->name('pusat-islam.surat-rasmi.create');
        Route::get('pusat-islam/surat-rasmi/{id}/edit', [SuratRasmiController::class, 'edit'])
            ->name('pusat-islam.surat-rasmi.edit');
        Route::get('pusat-islam/surat-rasmi/{id}/show', [SuratRasmiController::class, 'show'])
            ->name('pusat-islam.surat-rasmi.show');
        Route::delete('pusat-islam/surat-rasmi/{id}', [SuratRasmiController::class, 'destroy'])
            ->name('pusat-islam.surat-rasmi.destroy');
    });

/** Alumni */
Route::middleware(['web', 'auth'])
    ->as('alumni.')
    ->prefix('alumni')
    ->group(function () {
        // Route::get('/dashboard', DashboardController::class)
        //     ->name('dashboard.index');

        // Pengajian Selepas DQ
        Route::post('/{id}/pengajian/create', [AlumniController::class, 'pengajian_store'])
            ->name('pengajian.store');
        Route::get('/{id}/pengajian/{pengajian_id}/edit', [AlumniController::class, 'pengajian_edit'])
            ->name('pengajian.edit');
        Route::put('/{id}/pengajian/{pengajian_id}', [AlumniController::class, 'pengajian_update'])
            ->name('pengajian.update');
        Route::delete('/{id}/pengajian', [AlumniController::class, 'pengajian_destroy'])
            ->name('pengajian.destroy');

        // Pekerjaan terkini
        Route::post('/{id}/pekerjaan/create_edit', [AlumniController::class, 'pekerjaan_store'])
            ->name('pekerjaan.store');
        Route::put('/{id}/pekerjaan/create_edit', [AlumniController::class, 'pekerjaan_update'])
            ->name('pekerjaan.update');

        // Alumni personal data
        // Route::resource('/', AlumniController::class);
        Route::get('/', [AlumniController::class, 'index'])
            ->name('index');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}/update', [AlumniController::class, 'update'])
            ->name('update');

        Route::get('kajian_keberkesanan/{id}/design_form', [KajianKeberkesananGraduanController::class, 'design_form'])->name('kajian_keberkesanan.design_form');
        Route::put('kajian_keberkesanan/{id}/design_update', [KajianKeberkesananGraduanController::class, 'design_update'])->name('kajian_keberkesanan.design_update');
        Route::put('kajian_keberkesanan/jawapan/{id}', [KajianKeberkesananGraduanController::class, 'fill_store'])->name('kajian_keberkesanan.fill_store');
        Route::get('kajian_keberkesanan/data_chart/{id}', [KajianKeberkesananGraduanController::class, 'data_chart'])->name('kajian_keberkesanan.data_chart');
        Route::get('kajian_keberkesanan/analisa/{id}', [KajianKeberkesananGraduanController::class, 'result_survey'])->name('kajian_keberkesanan.analisa');
        Route::resource('kajian_keberkesanan', KajianKeberkesananGraduanController::class);

        // Route::resource('/rekod-kaunseling', RekodKaunselingController::class)->only('index', 'edit', 'update', 'show');
        // Route::resource('/laporan-kaunseling', LaporanKaunselingController::class)->only('index', 'edit', 'update', 'show');
    });
