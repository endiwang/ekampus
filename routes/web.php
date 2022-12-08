<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Main_Dashboard\UtamaController;
use App\Http\Controllers\DataMigration\MainController as MigrateMainController;



Route::group(['middleware' => ['guest']], function() {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/utama', [UtamaController::class, 'index'])->name('home');

});


Route::get('/testform', [TestController::class, 'testform'])->name('testForm');
Route::get('/testformwizard', [TestController::class, 'testformwizard'])->name('testformwizard');
Route::get('/testtable', [TestController::class, 'table'])->name('teble');
Route::get('/data', [TestController::class, 'getBasicData'])->name('tebledata');


Route::prefix('permohonan')->group(function () {
    Route::get('/test', [TestController::class, 'index'])->name('test');
    Route::get('/notest', [TestController::class, 'base2'])->name('base2');
});

Route::get('/test2', [TestController::class, 'index2'])->name('test2');
Route::get('/test_con', [TestController::class, 'testConnection'])->name('test_con');



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
});

Route::get('/duplicate_data', [MigrateMainController::class,'find_duplicate']);



// Auth::routes();

