<?php

use App\Http\Controllers\Pengurusan\Akademik\eLearning\PengurusanKandunganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Akademik\GuruTasmikController;
use App\Http\Controllers\Pengurusan\Akademik\JadualWaktu\JadualKelasController;
use App\Http\Controllers\Pengurusan\Akademik\KalendarAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\KelasController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\KemasukanPelajarIjazahController;
use App\Http\Controllers\Pengurusan\Akademik\KursusController;
use App\Http\Controllers\Pengurusan\Akademik\MainAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\Pendaftaran\KelasPelajarController;
use App\Http\Controllers\Pengurusan\Akademik\Pendaftaran\SyukbahController;
use App\Http\Controllers\Pengurusan\Akademik\Laporan\LaporanMesyuaratController;
use App\Http\Controllers\Pengurusan\Akademik\Laporan\PelajarTangguhController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\AktivitiPdpController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\HebahanAktivitiController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\MpkIsoController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\PenamatanPengajianController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\PenilaianBerterusanSettingController;
use App\Http\Controllers\Pengurusan\Akademik\Pengurusan\PenilaianPensyarahController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodJadualPembelajaranController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodKompilasiSoalanController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodLatihanIndustriController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodMaklumatGraduasiController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodNotaKuliahController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodPenawaranSubjekController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodProfilPensyarahController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah\RekodTesisController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\CloPloController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\DaftarMarkahCloPloController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\PengurusanCloController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\PengurusanPloController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\PenilaianBerterusanController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\RekodHafazanShafawiController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\RekodHafazanTahririController;
use App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan\RekodMurajaahHarianController;
use App\Http\Controllers\Pengurusan\Akademik\Pensyarah\RekodKehadiranController;
use App\Http\Controllers\Pengurusan\Akademik\Pensyarah\SenaraiPensyarahController;
use App\Http\Controllers\Pengurusan\Akademik\Peperiksaan\TetapanPeperiksaanController;
use App\Http\Controllers\Pengurusan\Akademik\PeraturanAkademikController;
use App\Http\Controllers\Pengurusan\Akademik\Permohonan\PelepasanKuliahController;
use App\Http\Controllers\Pengurusan\Akademik\Permohonan\PenangguhanPengajianController;
use App\Http\Controllers\Pengurusan\Akademik\Permohonan\PertukaranSyukbahController;
use App\Http\Controllers\Pengurusan\Akademik\Permohonan\RayuanPengajianController;
use App\Http\Controllers\Pengurusan\Akademik\RekodKehadiran\KehadiranPelajarController;
use App\Http\Controllers\Pengurusan\Akademik\SemesterController;
use App\Http\Controllers\Pengurusan\Akademik\SubjekController;


Route::resource('/', MainAkademikController::class)->only(['index',]);
Route::resource('kursus', KursusController::class);

Route::post('kelas/export/by_class', [KelasController::class, 'exportStudentByClass'])->name('pengurusan_kelas.export_by_class');
Route::post('kelas/edit', [KelasController::class, 'edit'])->name('pengurusan_kelas.store');
Route::post('kelas/store', [KelasController::class, 'store'])->name('pengurusan_kelas.store');
Route::resource('kelas', KelasController::class);

Route::get('subjek/{subjek_id}/daftar_item_penilaian', [SubjekController::class, 'registerMarkItems'])->name('pengurusan_subjek.register_mark_item');
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

    Route::resource('tangguh_pengajian', PelajarTangguhController::class);
});

Route::group(['prefix'=>'permohonan','as'=>'permohonan.'], function(){
    Route::resource('pertukaran_syukbah', PertukaranSyukbahController::class);

    Route::get('pelepasan_kuliah/download/{id}', [PelepasanKuliahController::class, 'suratPelepasan'])->name('pelepasan_kuliah.download_surat_pelepasan');
    Route::get('pelepasan_kuliah/biodata/{id}/{user_id}', [PelepasanKuliahController::class, 'biodata'])->name('pelepasan_kuliah.biodata');
    Route::resource('pelepasan_kuliah', PelepasanKuliahController::class);

    Route::resource('penangguhan_pengajian', PenangguhanPengajianController::class);

    Route::get('rayuan_pengajian/update_status/{id}', [RayuanPengajianController::class, 'updateStatus'])->name('rayuan_pengajian.update_status');
    Route::resource('rayuan_pengajian', RayuanPengajianController::class);
});

Route::group(['prefix'=>'pensyarah','as'=>'pensyarah.'], function(){
    Route::resource('senarai_pensyarah', SenaraiPensyarahController::class);
});

Route::group(['prefix'=>'rekod_kehadiran','as'=>'rekod_kehadiran.'], function(){
    Route::post('rekod_pelajar/muat_turun', [KehadiranPelajarController::class, 'downloadAttendancePdf'])->name('rekod_pelajar.muat_turun');
    Route::resource('rekod_pelajar', KehadiranPelajarController::class);

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

    Route::resource('penamatan_pengajian', PenamatanPengajianController::class);

    Route::post('tetapan_penilaian_berterusan/store_item', [PenilaianBerterusanSettingController::class, 'storeItem'])->name('tetapan_penilaian_berterusan.store_item');
    Route::resource('tetapan_penilaian_berterusan', PenilaianBerterusanSettingController::class);
});

Route::group(['prefix'=>'jadual','as'=>'jadual.'], function(){
    Route::get('jadual_kelas/download_timetable/{id}', [JadualKelasController::class, 'downloadTimetable'])->name('jadual_kelas.download_timetable');
    Route::post('jadual_kelas/add_subject', [JadualKelasController::class, 'addSubject'])->name('jadual_kelas.add_subject');
    Route::post('jadual_kelas/update/{id}', [JadualKelasController::class, 'update'])->name('jadual_kelas.update_status');
    Route::resource('jadual_kelas', JadualKelasController::class);
});

Route::group(['prefix'=>'jadual','as'=>'jadual.'], function(){
    Route::get('jadual_kelas/download_timetable/{id}', [JadualKelasController::class, 'downloadTimetable'])->name('jadual_kelas.download_timetable');
    Route::post('jadual_kelas/add_subject', [JadualKelasController::class, 'addSubject'])->name('jadual_kelas.add_subject');
    Route::post('jadual_kelas/update/{id}', [JadualKelasController::class, 'update'])->name('jadual_kelas.update_status');
    Route::resource('jadual_kelas', JadualKelasController::class);
});

Route::group(['prefix'=>'pengurusan_ijazah','as'=>'pengurusan_ijazah.'], function(){
    Route::resource('pelajar', KemasukanPelajarIjazahController::class);
    Route::resource('penawaran_subjek', RekodPenawaranSubjekController::class);
    Route::get('penawaran_subjek/download/{id}', [RekodPenawaranSubjekController::class, 'download'])->name('penawaran_subjek.download');
    Route::resource('akademik', RekodAkademikController::class);
    Route::get('akademik/download/{id}', [RekodAkademikController::class, 'download'])->name('akademik.download');
    Route::resource('jadual_pembelajaran', RekodJadualPembelajaranController::class);
    Route::get('jadual_pembelajaran/download/{id}', [RekodJadualPembelajaranController::class, 'download'])->name('jadual_pembelajaran.download');
    Route::resource('nota_kuliah', RekodNotaKuliahController::class);
    Route::get('nota_kuliah/download/{id}', [RekodJadualPembelajaranController::class, 'download'])->name('nota_kuliah.download');
    Route::resource('kompilasi_soalan', RekodKompilasiSoalanController::class);
    Route::get('kompilasi_soalan/download/{id}', [RekodKompilasiSoalanController::class, 'download'])->name('kompilasi_soalan.download');

    Route::resource('latihan_industri', RekodLatihanIndustriController::class);

    Route::get('maklumat_graduasi/download/{id}', [RekodMaklumatGraduasiController::class, 'download'])->name('maklumat_graduasi.download');
    Route::resource('maklumat_graduasi', RekodMaklumatGraduasiController::class);

    Route::get('profil_pensyarah/download/{id}', [RekodProfilPensyarahController::class, 'download'])->name('profil_pensyarah.download');
    Route::post('profil_pensyarah/upload_file/{id}', [RekodProfilPensyarahController::class, 'uploadFile'])->name('profil_pensyarah.upload_file');
    Route::post('profil_pensyarah/delete_file/{id}', [RekodProfilPensyarahController::class, 'deleteFile'])->name('profil_pensyarah.delete_file');
    Route::resource('profil_pensyarah', RekodProfilPensyarahController::class);

    Route::get('rekod_tesis/download/{id}', [RekodTesisController::class, 'download'])->name('rekod_tesis.download');
    Route::resource('rekod_tesis', RekodTesisController::class);
});

Route::group(['prefix'=>'peperiksaan','as'=>'peperiksaan.'], function(){
    Route::resource('tetapan_peperiksaan', TetapanPeperiksaanController::class);
    Route::get('tetapan_peperiksaan/{id}/pilih_subjek', [TetapanPeperiksaanController::class, 'pilih_subjek'])->name('tetapan_peperiksaan.pilih_subjek');
    Route::post('tetapan_peperiksaan/{id}/store_pilihan_subjek', [TetapanPeperiksaanController::class, 'store_pilihan_subjek'])->name('tetapan_peperiksaan.store_pilihan_subjek');

});

Route::group(['prefix'=>'pengurusan_jabatan','as'=>'pengurusan_jabatan.'], function(){
    Route::resource('rekod_hafazan_shafawi', RekodHafazanShafawiController::class);

    Route::resource('rekod_tahriri', RekodHafazanTahririController::class);

    Route::resource('rekod_murajaah_harian', RekodMurajaahHarianController::class);

    Route::resource('pengurusan_clo', PengurusanCloController::class);

    Route::resource('pengurusan_plo', PengurusanPloController::class);

    Route::resource('pemetaan_clo_plo', CloPloController::class);

    Route::post('daftar_markah_clo_plo/store_marks', [DaftarMarkahCloPloController::class, 'storeMark'])->name('daftar_markah_clo_plo.store_marks');
    Route::get('daftar_markah_clo_plo/update_marks/{clo_plo_id}/{class_id}/{student_id}', [DaftarMarkahCloPloController::class, 'updateMark'])->name('daftar_markah_clo_plo.update_marks');
    Route::get('daftar_markah_clo_plo/clo_plo/{student_id}/{class_id}', [DaftarMarkahCloPloController::class, 'show'])->name('daftar_markah_clo_plo.clo_plo_list');
    Route::get('daftar_markah_clo_plo/student_list/{class_id}', [DaftarMarkahCloPloController::class, 'studentList'])->name('daftar_markah_clo_plo.student_list');
    Route::resource('daftar_markah_clo_plo', DaftarMarkahCloPloController::class);

    Route::get('penilaian_berterusan/kemaskini_markah/{id}/{student_id}/{class_id}', [PenilaianBerterusanController::class, 'edit'])->name('penilaian_berterusan.markah');
    Route::resource('penilaian_berterusan', PenilaianBerterusanController::class);
});

Route::group(['prefix'=>'e_learning','as'=>'e_learning.'], function(){
    Route::post('pengurusan_kandungan/upload_file/{id}', [PengurusanKandunganController::class, 'uploadFile'])->name('pengurusan_kandungan.upload_file');
    Route::get('pengurusan_kandungan/download/{id}', [PengurusanKandunganController::class, 'download'])->name('pengurusan_kandungan.download');
    Route::post('pengurusan_kandungan/delete_file/{id}', [PengurusanKandunganController::class, 'deleteFile'])->name('pengurusan_kandungan.delete_file');
    Route::post('pengurusan_kandungan/update/{id}', [PengurusanKandunganController::class, 'update'])->name('pengurusan_kandungan.update_kandungan_pemebelajaran');
    Route::resource('pengurusan_kandungan', PengurusanKandunganController::class);
});
