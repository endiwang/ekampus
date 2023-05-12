<?php

use App\Http\Controllers\Pengurusan\Akademik\GuruTasmikController;
use App\Http\Controllers\Pengurusan\Akademik\KalendarAkademikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Akademik\KelasController;
use App\Http\Controllers\Pengurusan\Akademik\KursusController;
use App\Http\Controllers\Pengurusan\Akademik\MainAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\Pendaftaran\KelasPelajarController;
use App\Http\Controllers\Pengurusan\Akademik\Pendaftaran\SyukbahController;
use App\Http\Controllers\Pengurusan\Akademik\Laporan\LaporanMesyuaratController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\AktivitiPdpController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\HebahanAktivitiController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\MpkIsoController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\PenilaianPensyarahController;
use App\Http\Controllers\Pengurusan\Akademik\Pensyarah\RekodKehadiranController;
use App\Http\Controllers\Pengurusan\Akademik\Pensyarah\SenaraiPensyarahController;
use App\Http\Controllers\Pengurusan\Akademik\PeraturanAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\Permohonan\PertukaranSyukbahController;
use App\Http\Controllers\Pengurusan\Akademik\SemesterController;
use App\Http\Controllers\Pengurusan\Akademik\SubjekController;

Route::resource('/', MainAkademikController::class)->only(['index',]);
Route::resource('kursus', KursusController::class);

Route::post('kelas/export/by_class', [KelasController::class, 'exportStudentByClass'])->name('pengurusan_kelas.export_by_class');
Route::post('kelas/edit', [KelasController::class, 'edit'])->name('pengurusan_kelas.store');
Route::post('kelas/store', [KelasController::class, 'store'])->name('pengurusan_kelas.store');
Route::resource('kelas', KelasController::class);

Route::post('subjek/store', [SubjekController::class, 'store'])->name('pengurusan_subjek.store');
Route::get('subjek/edit/{id}/{course_id}', [SubjekController::class, 'edit'])->name('pengurusan_subjek.edit');
Route::get('subjek/create/{id}', [SubjekController::class, 'create'])->name('pengurusan_subjek.create');
Route::resource('subjek', SubjekController::class);

Route::get('guru_tasmik/update/{id}', [GuruTasmikController::class, 'edit'])->name('guru_tasmik.update');
Route::resource('guru_tasmik', GuruTasmikController::class);

Route::get('/download/{id}', [PeraturanAkademikController::class, 'download'])->name('peraturan_akademik.download');
Route::resource('peraturan_akademik', PeraturanAkademikController::class);

Route::delete('kalendar_akademik/aktiviti/delete/{id}', [KalendarAkademikController::class, 'deleteActivity'])->name('kalendar_akademik.delete_activity');
Route::put('kalendar_akademik/aktiviti/update/{id}', [KalendarAkademikController::class, 'updateActivity'])->name('kalendar_akademik.update_activity');
Route::get('kalendar_akademik/aktiviti/edit/{id}', [KalendarAkademikController::class, 'editActivity'])->name('kalendar_akademik.edit_activity');
Route::post('kalendar_akademik/aktiviti/store/{id}', [KalendarAkademikController::class, 'storeActivity'])->name('kalendar_akademik.store_activity');
Route::get('kalendar_akademik/aktiviti/create/{id}', [KalendarAkademikController::class, 'createActivity'])->name('kalendar_akademik.create_activity');
Route::resource('kalendar_akademik', KalendarAkademikController::class);

Route::resource('semester', SemesterController::class);

Route::post('pendaftaran/kelas_pelajar/update/{id}', [KelasPelajarController::class, 'updateClass'])->name('kelas_pelajar.update');
Route::resource('pendaftaran/kelas_pelajar', KelasPelajarController::class);

Route::resource('pendaftaran/syukbah_pelajar', SyukbahController::class);

Route::group(['prefix'=>'laporan','as'=>'laporan.'], function(){
    Route::get('laporan_mesyuarat/download/{id}', [LaporanMesyuaratController::class, 'download'])->name('laporan_mesyuarat.download');
    Route::post('laporan_mesyuarat/delete_file/{id}', [LaporanMesyuaratController::class, 'deleteFile'])->name('laporan_mesyuarat.delete_file');
    Route::post('laporan_mesyuarat/update/{id}', [LaporanMesyuaratController::class, 'update'])->name('laporan_mesyuarat.update_laporan');
    Route::post('laporan_mesyuarat/upload_file/{id}', [LaporanMesyuaratController::class, 'uploadFile'])->name('laporan_mesyuarat.upload_file');
    Route::resource('laporan_mesyuarat', LaporanMesyuaratController::class);
});

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::resource('pertukaran_syukbah', PertukaranSyukbahController::class);
});

Route::group(['prefix'=>'pensyarah','as'=>'pensyarah.'], function(){
    Route::resource('senarai_pensyarah', SenaraiPensyarahController::class);

    Route::resource('rekod_kehadiran', RekodKehadiranController::class);
});

Route::group(['prefix'=>'pengurusan','as'=>'pengurusan.'], function(){
    Route::get('mpk_iso/download/{id}', [MpkIsoController::class, 'download'])->name('mpk_iso.download');
    Route::resource('mpk_iso', MpkIsoController::class);

    Route::get('hebahan_aktiviti/download/{id}', [HebahanAktivitiController::class, 'download'])->name('hebahan_aktiviti.download');
    Route::post('hebahan_aktiviti/delete_file/{id}', [HebahanAktivitiController::class, 'deleteFile'])->name('hebahan_aktiviti.delete_file');
    Route::post('hebahan_aktiviti/update/{id}', [HebahanAktivitiController::class, 'update'])->name('hebahan_aktiviti.update_aktiviti');
    Route::post('hebahan_aktiviti/upload_file/{id}', [HebahanAktivitiController::class, 'uploadFile'])->name('hebahan_aktiviti.upload_file');
    Route::resource('hebahan_aktiviti', HebahanAktivitiController::class);

    Route::resource('aktiviti_pdp', AktivitiPdpController::class);

    Route::post('penilaian_pensyarah/skala_penilaian/delete/{id}', [PenilaianPensyarahController::class, 'deleteRating'])->name('penilaian_pensyarah.rating.delete');
    Route::post('penilaian_pensyarah/skala_penilaian/store', [PenilaianPensyarahController::class, 'storeRating'])->name('penilaian_pensyarah.rating.store');
    Route::get('penilaian_pensyarah/skala_penilaian', [PenilaianPensyarahController::class, 'createRating'])->name('penilaian_pensyarah.rating');
    Route::resource('penilaian_pensyarah', PenilaianPensyarahController::class);
});

