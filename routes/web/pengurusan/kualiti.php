<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use App\Http\Controllers\Pengurusan\Kualiti\KualitiController;

    // Kualiti
    Route::get('/index', [KualitiController::class,'index'])->name('kualiti.index');
    Route::get('/tambah', [KualitiController::class,'create'])->name('kualiti.create');
    Route::post('/store', [KualitiController::class, 'store'])->name('kualiti.store');
    Route::get('/edit/{id}', [KualitiController::class,'edit'])->name('kualiti.show');
    Route::post('/update', [KualitiController::class, 'update'])->name('kualiti.update');

    // Kursus
    Route::get('/kursus/index', [KualitiController::class,'kursusIndex'])->name('kursus.index');
    Route::get('/kursus/tambah', [KualitiController::class,'kursusTambah'])->name('kursus.tambah');
    Route::post('/kursus/store', [KualitiController::class, 'kursusStore'])->name('kursus.store');
    Route::get('/kursus/edit/{id}', [KualitiController::class,'kursusEdit'])->name('kursus.show');
    Route::post('/kursus/update', [KualitiController::class, 'kursusUpdate'])->name('kursus.update');
    Route::get('/kursus/download/{id}', [KualitiController::class, 'download'])->name('kursus.download');
    Route::post('/kursus/delete', [KualitiController::class, 'kursusDestroy'])->name('kursus.destroy');

    // maklumat kursus dan latihan
    Route::get('/maklumat/kursus/index', [KualitiController::class,'MaklumatKursusIndex'])->name('maklumat.kursus.index');
    Route::get('/maklumat/kursus/{id}/list', [KualitiController::class,'MaklumatKursusList'])->name('maklumat.kursus.list');
    Route::get('/maklumat/kursus/{id}/tambah', [KualitiController::class,'MaklumatKursusTambah'])->name('maklumat.kursus.tambah');
    Route::post('/maklumat/kursus/store', [KualitiController::class,'MaklumatKursusStore'])->name('maklumat.kursus.store');
    Route::get('/maklumat/kursus/peserta/{id}', [KualitiController::class,'MaklumatKursusEdit'])->name('maklumat.kursus.show');
    Route::post('/maklumat/kursus/peserta/update', [KualitiController::class,'MaklumatKursusUpdate'])->name('maklumat.kursus.update');
    Route::post('/maklumat/kursus/peserta/delete', [KualitiController::class,'MaklumatKursusUpdate'])->name('maklumat.kursus.delete');


    // akreditasi
    Route::get('/akreditasi/index', [KualitiController::class,'akreditasIndex'])->name('akreditasi.index');
    Route::get('/akreditasi/tambah', [KualitiController::class,'akreditasiTambah'])->name('akreditasi.tambah');
    Route::post('/akreditasi/store', [KualitiController::class,'akreditasiStore'])->name('akreditasi.store');
    Route::get('/akreditasi/edit/{id}', [KualitiController::class,'akreditasiEdit'])->name('akreditasi.show');
    Route::post('/akreditasi/update', [KualitiController::class,'akreditasiUpdate'])->name('akreditasi.update');

    // muadalah
    Route::get('/muadalah/index', [KualitiController::class,'muadalahIndex'])->name('muadalah.index');
    Route::get('/muadalah/tambah', [KualitiController::class,'muadalahTambah'])->name('muadalah.tambah');
    Route::post('/muadalah/store', [KualitiController::class,'muadalahStore'])->name('muadalah.store');
    Route::get('/muadalah/edit/{id}', [KualitiController::class,'muadalahEdit'])->name('muadalah.show');
    Route::post('/muadalah/update', [KualitiController::class,'muadalahUpdate'])->name('muadalah.update');

    // Rekod kompetensi Pensyarah
    
    Route::get('/rekodkompetensi/index', [KualitiController::class,'RekodKompetensiIndex'])->name('rekodkompetensi.index');
    Route::get('/rekodkompetensi/tambah', [KualitiController::class,'RekodKompetensiTambah'])->name('rekodkompetensi.tambah');
    Route::post('/rekodkompetensi/store', [KualitiController::class,'RekodKompetensiStore'])->name('rekodkompetensi.store');
    Route::get('/rekodkompetensi/edit/{id}', [KualitiController::class,'RekodKompetensiEdit'])->name('rekodkompetensi.show');
    Route::post('/rekodkompetensi/update', [KualitiController::class,'RekodKompetensiUpdate'])->name('rekodkompetensi.update');




    



