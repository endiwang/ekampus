<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Main_Dashboard\UtamaController;
use App\Http\Controllers\DataMigration\MainController as MigrateMainController;
use App\Http\Controllers\Main_Dashboard\AduanSalahlakuPelajarController;
use App\Http\Controllers\Main_Dashboard\AduanPenyelenggaraanController;
use App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran\KehadiranPelajarController;
use App\Http\Controllers\Pengurusan\Kakitangan\Kehadiran\KehadiranPensyarahController;

Route::group(['middleware' => ['guest']], function() {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['guest_pemohon']], function() {
    Route::get('/login_pemohon', [LoginController::class, 'showPemohonLoginForm'])->name('login_pemohon');
    Route::post('/login_pemohon', [LoginController::class, 'loginPemohon'])->name('login_pemohon');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/utama', [UtamaController::class, 'index'])->name('home');
    Route::resource('/utama/aduan_salahlaku_pelajar', AduanSalahlakuPelajarController::class);

    // Penyelenggaraan
    Route::get('/utama/aduan_penyelenggaraan/get_block', [AduanPenyelenggaraanController::class, 'getBlok'])->name('aduan_penyelenggaraan.get_block');
    Route::get('/utama/aduan_penyelenggaraan/get_bilik', [AduanPenyelenggaraanController::class, 'getBilik'])->name('aduan_penyelenggaraan.get_bilik');
    Route::resource('/utama/aduan_penyelenggaraan', AduanPenyelenggaraanController::class);
});


Route::get('/logout_pemohon', [LogoutController::class, 'logoutPemohon'])->name('logout_pemohon');
Route::post('/register_pemohon', [RegisterController::class, 'registerPemohon'])->name('register_pemohon');
Route::get('/verify_email_pemohon/{token}', [RegisterController::class, 'verifyEmailPemohon'])->name('verify_email_pemohon');





Route::get('/testform', [TestController::class, 'testform'])->name('testForm');
Route::get('/testpemohon', [TestController::class, 'testpemohon'])->name('testpemohon');
Route::get('/testformwizard', [TestController::class, 'testformwizard'])->name('testformwizard');
Route::get('/testtable', [TestController::class, 'table'])->name('teble');
Route::get('/data', [TestController::class, 'getBasicData'])->name('tebledata');


Route::prefix('permohonan')->group(function () {
    Route::get('/test', [TestController::class, 'index'])->name('test');
    Route::get('/notest', [TestController::class, 'base2'])->name('base2');
});

Route::get('/test2', [TestController::class, 'index2'])->name('test2');
Route::get('/test_con', [TestController::class, 'testConnection'])->name('test_con');

Route::get('kehadiran/pelajar/berjaya', [KehadiranPelajarController::class, 'successfulSubmission'])->name('kehadiran.pelajar.successful');
Route::post('kehadiran/pelajar/submit', [KehadiranPelajarController::class, 'submitKehadiran'])->name('kehadiran.pelajar.submit');
Route::get('kehadiran/{subjek_id}/{date}', [KehadiranPelajarController::class, 'getkehadiranForm'])->name('kehadiran.submit');

Route::get('pensyarah/pelajar/berjaya', [KehadiranPensyarahController::class, 'successfulSubmission'])->name('pensyarah.kehadiran.successful');
Route::post('pensyarah/kehadiran/submit', [KehadiranPensyarahController::class, 'submitKehadiran'])->name('pensyarah.kehadiran.submit');
Route::get('pensyarah/kehadiran/{staff_id}/{date}', [KehadiranPensyarahController::class, 'getkehadiranForm'])->name('pensyarah.kehadiran');


//Migrate Data
Route::prefix('migrate')->group(function () {
    Route::get('/student_as_user', [MigrateMainController::class,'sis_tblpelajar_to_user_table']);
    Route::get('/staff_as_user', [MigrateMainController::class,'sis_tblstaff_to_user_table']);
    Route::get('/ref_kursus_to_kursus_table', [MigrateMainController::class,'ref_kursus_to_kursus_table']);
    Route::get('/ref_syukbah_to_syukbah_table', [MigrateMainController::class,'ref_syukbah_to_syukbah_table']);
    Route::get('/ref_kelas_to_kelas_table', [MigrateMainController::class,'ref_kelas_to_kelas_table']);
    Route::get('/sis_tblpelajar_to_pelajar_table', [MigrateMainController::class,'sis_tblpelajar_to_pelajar_table']);
    Route::get('/sis_tblstaff_to_staff_table', [MigrateMainController::class,'sis_tblstaff_to_staff_table']);
    Route::get('/ref_sesi_to_sesi_table', [MigrateMainController::class,'ref_sesi_to_sesi_table']);
    Route::get('/ref_semester_to_semester_table', [MigrateMainController::class,'ref_semester_to_semester_table']);
    Route::get('/ref_subjek_to_subjek_table', [MigrateMainController::class,'ref_subjek_to_subjek_table']);
    Route::get('/ref_pusat_pengajian_to_pusat_pengajian_table', [MigrateMainController::class,'ref_pusat_pengajian_to_pusat_pengajian_table']);
    Route::get('/ref_jabatan_to_jabatan_table', [MigrateMainController::class,'ref_jabatan_to_jabatan_table']);
    Route::get('/ref_warganegara_to_warganegara_table', [MigrateMainController::class,'ref_warganegara_to_warganegara_table']);
    Route::get('/tbl_masuk_permohonan_to_tetapan_permohonan_pelajar', [MigrateMainController::class,'tbl_masuk_permohonan_to_tetapan_permohonan_pelajar']);
    Route::get('/refstate_to_negeri', [MigrateMainController::class,'refstate_to_negeri']);
    Route::get('/sis_tblpermohonan_to_permohonan', [MigrateMainController::class,'sis_tblpermohonan_to_permohonan']);
    Route::get('/sis_tblpermohonan_pelajaran_to_permohonan_kelulusan_akademik', [MigrateMainController::class,'sis_tblpermohonan_pelajaran_to_permohonan_kelulusan_akademik']);
    Route::get('/sis_tblpermohonan_penjaga_to_permohonan_penjaga', [MigrateMainController::class,'sis_tblpermohonan_penjaga_to_permohonan_penjaga']);
    Route::get('/sis_tblpermohonan_tanggung_to_permohonan_tanggungan_penjaga', [MigrateMainController::class,'sis_tblpermohonan_tanggung_to_permohonan_tanggungan_penjaga']);
    Route::get('/sis_tbltemuduga_to_temuduga', [MigrateMainController::class,'sis_tbltemuduga_to_temuduga']);
    Route::get('/ref_keturunan_to_keturunan', [MigrateMainController::class,'ref_keturunan_to_keturunan']);
    Route::get('/sis_tbltawaran_to_tawaran', [MigrateMainController::class,'sis_tbltawaran_to_tawaran']);
    Route::get('/sis_tbltawaran_mohon_to_tawaran_permohonan', [MigrateMainController::class,'sis_tbltawaran_mohon_to_tawaran_permohonan']);
    Route::get('/sis_tblkonvo_to_konvo', [MigrateMainController::class,'sis_tblkonvo_to_konvo']);
    Route::get('/sis_tblkonvo_mohon_to_konvo_pelajar', [MigrateMainController::class,'sis_tblkonvo_mohon_to_konvo_pelajar']);
    Route::get('/ref_sebab_berhenti_to_sebab_berhenti', [MigrateMainController::class,'ref_sebab_berhenti_to_sebab_berhenti']);
    Route::get('/ref_asrama_blok_to_blok', [MigrateMainController::class,'ref_asrama_blok_to_blok']);
    Route::get('/ref_asrama_tingkat_to_tingkat', [MigrateMainController::class,'ref_asrama_tingkat_to_tingkat']);
});

Route::get('/duplicate_data', [MigrateMainController::class,'find_duplicate']);



// Auth::routes();

