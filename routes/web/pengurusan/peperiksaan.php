<?php

use App\Http\Controllers\Pengurusan\Peperiksaan\CajPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\CetakanKeputusanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\CetakTuntutanBayaranController;
use App\Http\Controllers\Pengurusan\Peperiksaan\CetakanTranskripController;
use App\Http\Controllers\Pengurusan\Peperiksaan\JadualPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniKursusController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniMarkahController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniNamaPelajarController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniPaparanKeputusanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniSesiPengajianController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KemaskiniSubjekArabController;
use App\Http\Controllers\Pengurusan\Peperiksaan\KeputusanPeperiksaanStmController;
use App\Http\Controllers\Pengurusan\Peperiksaan\MainPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\MaklumatKehadiranController;
use App\Http\Controllers\Pengurusan\Peperiksaan\PengesahanTamatPengajianController;
use App\Http\Controllers\Pengurusan\Peperiksaan\PenilaianLainController;
use App\Http\Controllers\Pengurusan\Peperiksaan\PersiapanPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\SenaraiCalonPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\SenaraiPelajarTamatController;
use App\Http\Controllers\Pengurusan\Peperiksaan\TetapanSesiPeperiksaanController;
use App\Http\Controllers\Pengurusan\Peperiksaan\TuntutanBayaranPeperiksaanController;
use Illuminate\Support\Facades\Route;

Route::resource('/', MainPeperiksaanController::class)->only(['index']);

Route::group(['prefix' => 'kemaskini', 'as' => 'kemaskini.'], function () {
    Route::resource('senarai_kursus', KemaskiniKursusController::class);

    Route::resource('sesi_pengajian', KemaskiniSesiPengajianController::class);

    Route::resource('nama_pelajar', KemaskiniNamaPelajarController::class);

    Route::resource('subjek_arab', KemaskiniSubjekArabController::class);
});

Route::group(['prefix' => 'tetapan', 'as' => 'tetapan.'], function () {
    Route::resource('sesi_peperiksaan', TetapanSesiPeperiksaanController::class);

    Route::resource('caj_peperiksaan', CajPeperiksaanController::class);
});

Route::get('jadual_peperiksaan/muatturun_jadual/{id}', [JadualPeperiksaanController::class, 'downloadJadualPeperiksaan'])->name('jadual_peperiksaan.muatturun_jadual');
Route::post('jadual_peperiksaan/tambah_subjek/{id}', [JadualPeperiksaanController::class, 'addSubject'])->name('jadual_peperiksaan.add_subjek');
Route::resource('jadual_peperiksaan', JadualPeperiksaanController::class);

Route::resource('pelajar_tamat_berhenti', SenaraiPelajarTamatController::class);

Route::post('persiapan_peperiksaan/add_item/{id}', [PersiapanPeperiksaanController::class, 'addItem'])->name('persiapan_peperiksaan.add_item');
Route::post('persiapan_peperiksaan/delete_item/{id}', [PersiapanPeperiksaanController::class, 'deleteItem'])->name('persiapan_peperiksaan.delete_item');
Route::resource('persiapan_peperiksaan', PersiapanPeperiksaanController::class);

Route::post('cetakan_keputusan_peperiksaan/download_keputusan', [CetakanKeputusanController::class, 'downloadKeputusan'])->name('cetakan_keputusan_peperiksaan.download_keputusan');
Route::post('cetakan_keputusan_peperiksaan/getCourses', [CetakanKeputusanController::class, 'getCourses'])->name('cetakan_keputusan_peperiksaan.getCourses');
Route::resource('cetakan_keputusan_peperiksaan', CetakanKeputusanController::class);

Route::post('cetak_tuntutan_bayaran/muat_turun', [CetakTuntutanBayaranController::class, 'downloadDetail'])->name('cetak_tuntutan_bayaran.download');
Route::resource('cetak_tuntutan_bayaran', CetakTuntutanBayaranController::class);

Route::get('cetakan_transkrip_peperiksaan/muatturun_transkrip/{id}', [CetakanTranskripController::class, 'downloadTranskrip'])->name('cetakan_transkrip_peperiksaan.download_transkrip');
Route::resource('cetakan_transkrip_peperiksaan', CetakanTranskripController::class);

Route::get('calon_peperiksaan/muatturun_slip/{id}', [SenaraiCalonPeperiksaanController::class, 'downloadSlip'])->name('calon_peperiksaan.cetak_slip');
Route::post('calon_peperiksaan/maklumat_subjek_pelajar', [SenaraiCalonPeperiksaanController::class, 'getMaklumatSubjekPelajar'])->name('calon_peperiksaan.getMaklumatSubjekPelajar');
Route::resource('calon_peperiksaan', SenaraiCalonPeperiksaanController::class);

Route::post('maklumat_kehadiran/maklumat_subjek_pelajar', [MaklumatKehadiranController::class, 'getMaklumatSubjekPelajar'])->name('maklumat_kehadiran.getMaklumatSubjekPelajar');
Route::resource('maklumat_kehadiran', MaklumatKehadiranController::class);

Route::post('pengesahan_tamat_pengajian/validate/{id}', [PengesahanTamatPengajianController::class, 'validateStudent'])->name('pengesahan_tamat_pengajian.validate_student');
Route::post('pengesahan_tamat_pengajian/maklumat_subjek_pelajar', [PengesahanTamatPengajianController::class, 'getMaklumatSubjekPelajar'])->name('pengesahan_tamat_pengajian.getMaklumatSubjekPelajar');
Route::resource('pengesahan_tamat_pengajian', PengesahanTamatPengajianController::class);

Route::post('kemaskini_markah/maklumat_pelajar', [KemaskiniMarkahController::class, 'getMaklumatPelajar'])->name('kemaskini_markah.getMaklumatPelajar');
Route::resource('kemaskini_markah', KemaskiniMarkahController::class);

Route::get('penilaian_lain/temudugga_syafawi/{id}', [PenilaianLainController::class, 'temuduga_syafawi'])->name('penilaian_lain.temuduga_syafawi');
Route::get('penilaian_lain/temuduga_tahriri/{id}', [PenilaianLainController::class, 'tahriri_pengetahuan_islam'])->name('penilaian_lain.temuduga_tahriri');
Route::resource('penilaian_lain', PenilaianLainController::class);

Route::resource('tuntutan_bayaran', TuntutanBayaranPeperiksaanController::class);

Route::get('keputusan_peperiksaan_stm/export_senarai/{id}', [KeputusanPeperiksaanStmController::class, 'export_senarai'])->name('keputusan_peperiksaan_stm.export_senarai');
Route::get('keputusan_peperiksaan_stm/temuduga_terdahulu', [KeputusanPeperiksaanStmController::class, 'index2'])->name('keputusan_peperiksaan_stm.temuduga_terdahulu');
Route::resource('keputusan_peperiksaan_stm', KeputusanPeperiksaanStmController::class);

Route::resource('kemaskini_paparan_keputusan', KemaskiniPaparanKeputusanController::class);
