<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurusan\Pentadbir_Sistem\SesiController;
use App\Http\Controllers\Pengurusan\Pentadbiran\PentadbiranController;

    // Fasiliti
    Route::get('/fasiliti/index', [PentadbiranController::class,'fasilitiIndex'])->name('fasiliti.index');
    Route::get('/fasiliti/tambah', [PentadbiranController::class,'fasilitiCreate'])->name('fasiliti.create');
    Route::post('/fasiliti/store', [PentadbiranController::class, 'fasilitiStore'])->name('fasiliti.store');
    Route::get('/fasiliti/edit/{id}', [PentadbiranController::class,'fasilitiEdit'])->name('fasiliti.show');
    Route::post('/fasiliti/update', [PentadbiranController::class, 'fasilitiUpdate'])->name('fasiliti.update');

    // Permohonan Fasiliti
    Route::get('/fasiliti/permohonan/index', [PentadbiranController::class,'permohonanFasilitiIndex'])->name('fasiliti.permohonan.index');
    Route::get('/fasiliti/permohonan/tambah', [PentadbiranController::class,'permohonanFasilitiTambah'])->name('fasiliti.permohonan.tambah');
    Route::post('/fasiliti/permohonan/store', [PentadbiranController::class, 'permohonanFasilitiStore'])->name('fasiliti.permohonan.store');
    Route::get('/fasiliti/permohonan/action/{id}', [PentadbiranController::class,'permohonanFasilitiShow'])->name('fasiliti.permohonan.show');
    Route::post('/fasiliti/permohonan/update', [PentadbiranController::class, 'permohonanFasilitiUpdate'])->name('fasiliti.permohonan.update');
    Route::get('/fasiliti/permohonan/show/{id}', [PentadbiranController::class,'permohonanFasilitiShowOnly'])->name('fasiliti.permohonan.show');
    // Route::post('/fasiliti/delete', [PentadbiranController::class, 'kursusDestroy'])->name('kursus.destroy');

    // // permohonan Penginapan
    Route::get('/penginapan/permohonan/index', [PentadbiranController::class,'permohonanPenginapanIndex'])->name('penginapan.permohonan.index');
    Route::get('/penginapan/permohonan/tambah', [PentadbiranController::class,'permohonanPenginapanTambah'])->name('penginapan.permohonan.tambah');
    Route::post('/penginapan/permohonan/store', [PentadbiranController::class,'permohonanPenginapanStore'])->name('penginapan.permohonan.store');
    Route::get('/penginapan/permohonan/action/{id}', [PentadbiranController::class,'permohonanPenginapanShow'])->name('penginapan.permohonan.show');
    Route::post('/penginapan/permohonan/update', [PentadbiranController::class,'permohonanPenginapanUpdate'])->name('penginapan.permohonan.update');
    Route::get('/penginapan/permohonan/show/{id}', [PentadbiranController::class,'permohonanPenginapanShowOnly'])->name('penginapan.permohonan.showonly');
    // Route::post('/maklumat/kursus/peserta/delete', [PentadbiranController::class,'MaklumatKursusUpdate'])->name('maklumat.kursus.delete');


    // Permohonan Menggunakan Kenderaan
    Route::get('/kenderaan/permohonan/index', [PentadbiranController::class,'permohonanKenderaanIndex'])->name('kenderaan.permohonan.index');
    Route::get('/kenderaan/permohonan/tambah', [PentadbiranController::class,'permohonanKenderaanTambah'])->name('kenderaan.permohonan.tambah');
    Route::post('/kenderaan/permohonan/store', [PentadbiranController::class,'permohonanKenderaanStore'])->name('kenderaan.permohonan.store');
    Route::get('/kenderaan/permohonan/action/{id}', [PentadbiranController::class,'permohonanKenderaanEdit'])->name('kenderaan.permohonan.show');
    Route::post('/kenderaan/permohonan/update', [PentadbiranController::class,'permohonanKenderaanUpdate'])->name('kenderaan.permohonan.update');
    Route::get('/kenderaan/permohonan/show/{id}',[PentadbiranController::class,'permohonanKenderaanShowonly'])->name('kenderaan.permohonan.showonly');

    // Permohonan Pelekat Kenderaan
    Route::get('/pelekat/permohonan/index', [PentadbiranController::class,'pelekatIndex'])->name('pelekat.permohonan.index');
    Route::get('/pelekat/permohonan/tambah', [PentadbiranController::class,'pelekatTambah'])->name('pelekat.permohonan.tambah');
    Route::post('/pelekat/permohonan/store', [PentadbiranController::class,'pelekatStore'])->name('pelekat.permohonan.store');
    Route::get('/pelekat/permohonan/action/{id}', [PentadbiranController::class,'pelekatEdit'])->name('pelekat.permohonan.show');
    Route::post('/pelekat/permohonan/update', [PentadbiranController::class,'pelekatUpdate'])->name('pelekat.permohonan.update');
    Route::get('/pelekat/permohonan/show/{id}', [PentadbiranController::class,'pelekatShowOnly'])->name('pelekat.permohonan.showonly');

    // // Permohonan Kuarters
    
    Route::get('/kuarters/permohonan/index', [PentadbiranController::class,'kuartersIndex'])->name('kuarters.permohonan.index');
    Route::get('/kuarters/permohonan/tambah', [PentadbiranController::class,'kuartersTambah'])->name('kuarters.permohonan.tambah');
    Route::post('/kuarters/permohonan/store', [PentadbiranController::class,'kuartersStore'])->name('kuarters.permohonan.store');
    Route::get('/kuarters/permohonan/action/{id}', [PentadbiranController::class,'kuartersEdit'])->name('kuarters.permohonan.show');
    Route::post('/kuarters/permohonan/update', [PentadbiranController::class,'kuartersUpdate'])->name('kuarters.permohonan.update');
    Route::get('/kuarters/permohonan/show/{id}', [PentadbiranController::class,'kuartersShowOnly'])->name('kuarters.permohonan.showonly');

   


    



