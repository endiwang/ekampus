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

    // // Kursus
    // Route::get('/kursus/index', [KualitiController::class,'kursusIndex'])->name('kursus.index');
    // Route::get('/kursus/tambah', [KualitiController::class,'kursusTambah'])->name('kursus.tambah');
    // Route::post('/kursus/store', [KualitiController::class, 'kursusStore'])->name('kursus.store');
    // Route::get('/kursus/edit/{id}', [KualitiController::class,'kursusEdit'])->name('kursus.show');
    // Route::post('/kursus/update', [KualitiController::class, 'kursusUpdate'])->name('kursus.update');
    // Route::get('/kursus/download/{id}', [KualitiController::class, 'download'])->name('kursus.download');
    // Route::post('/kursus/delete', [KualitiController::class, 'kursusDestroy'])->name('kursus.destroy');

    // // maklumat kursus dan latihan
    // Route::get('/maklumat/kursus/index', [KualitiController::class,'MaklumatKursusIndex'])->name('maklumat.kursus.index');
    // Route::get('/maklumat/kursus/{id}/list', [KualitiController::class,'MaklumatKursusList'])->name('maklumat.kursus.list');
    // Route::get('/maklumat/kursus/{id}/tambah', [KualitiController::class,'MaklumatKursusTambah'])->name('maklumat.kursus.tambah');
    // Route::post('/maklumat/kursus/store', [KualitiController::class,'MaklumatKursusStore'])->name('maklumat.kursus.store');
    // Route::get('/maklumat/kursus/peserta/{id}', [KualitiController::class,'MaklumatKursusEdit'])->name('maklumat.kursus.show');
    // Route::post('/maklumat/kursus/peserta/update', [KualitiController::class,'MaklumatKursusUpdate'])->name('maklumat.kursus.update');
    // Route::post('/maklumat/kursus/peserta/delete', [KualitiController::class,'MaklumatKursusUpdate'])->name('maklumat.kursus.delete');


    // // akreditasi
    // Route::get('/akreditasi/index', [KualitiController::class,'akreditasIndex'])->name('akreditasi.index');
    // Route::get('/akreditasi/tambah', [KualitiController::class,'akreditasiTambah'])->name('akreditasi.tambah');
    // Route::post('/akreditasi/store', [KualitiController::class,'akreditasiStore'])->name('akreditasi.store');
    // Route::get('/akreditasi/edit/{id}', [KualitiController::class,'akreditasiEdit'])->name('akreditasi.show');
    // Route::post('/akreditasi/update', [KualitiController::class,'akreditasiUpdate'])->name('akreditasi.update');

    // // muadalah
    // Route::get('/muadalah/index', [KualitiController::class,'muadalahIndex'])->name('muadalah.index');
    // Route::get('/muadalah/tambah', [KualitiController::class,'muadalahTambah'])->name('muadalah.tambah');
    // Route::post('/muadalah/store', [KualitiController::class,'muadalahStore'])->name('muadalah.store');
    // Route::get('/muadalah/edit/{id}', [KualitiController::class,'muadalahEdit'])->name('muadalah.show');
    // Route::post('/muadalah/update', [KualitiController::class,'muadalahUpdate'])->name('muadalah.update');

    // // Rekod kompetensi Pensyarah
    
    // Route::get('/rekodkompetensi/index', [KualitiController::class,'RekodKompetensiIndex'])->name('rekodkompetensi.index');
    // Route::get('/rekodkompetensi/tambah', [KualitiController::class,'RekodKompetensiTambah'])->name('rekodkompetensi.tambah');
    // Route::post('/rekodkompetensi/store', [KualitiController::class,'RekodKompetensiStore'])->name('rekodkompetensi.store');
    // Route::get('/rekodkompetensi/edit/{id}', [KualitiController::class,'RekodKompetensiEdit'])->name('rekodkompetensi.show');
    // Route::post('/rekodkompetensi/update', [KualitiController::class,'RekodKompetensiUpdate'])->name('rekodkompetensi.update');

    // // penyelidikan
    // Route::get('/penyelidikan/index', [KualitiController::class,'penyelidikanIndex'])->name('penyelidikan.index');
    // Route::get('/penyelidikan/tambah', [KualitiController::class,'penyelidikanTambah'])->name('penyelidikan.tambah');
    // Route::post('/penyelidikan/store', [KualitiController::class,'penyelidikanStore'])->name('penyelidikan.store');
    // Route::get('/penyelidikan/edit/{id}', [KualitiController::class,'penyelidikanEdit'])->name('penyelidikan.show');
    // Route::post('/penyelidikan/update', [KualitiController::class,'penyelidikanUpdate'])->name('penyelidikan.update');

    // // Penerbitan 
    // // permohonan dan penyediaan akses penyumbang artikel
    // Route::get('/penyumbang/artikel/daftar', [KualitiController::class,'penyumbangDaftar'])->name('penyumbang.artikel.daftar');
    // Route::post('/penyumbang/artikel/store', [KualitiController::class,'penyumbangStore'])->name('penyumbang.artikel.store');
    // // kelulusan permohonan penyumbang artikel
    // Route::get('/penyumbang/artikel/list', [KualitiController::class,'penyumbangList'])->name('penyumbang.artikel.list');
    // Route::get('/penyumbang/artikel/show/{id}', [KualitiController::class,'penyumbangShow'])->name('penyumbang.artikel.show');
    // Route::post('/penyumbang/artikel/update', [KualitiController::class,'penyumbangUpdate'])->name('penyumbang.artikel.update');

    // // penerbitan editor artikel
    // Route::get('/editor/artikel/daftar', [KualitiController::class,'editorDaftar'])->name('editor.artikel.daftar');
    // Route::post('/editor/artikel/store', [KualitiController::class,'editorStore'])->name('editor.artikel.store');
    // // kelulusan permohonan editor artikel
    // Route::get('/editor/artikel/list', [KualitiController::class,'editorList'])->name('editor.artikel.list');
    // Route::get('/editor/artikel/show/{id}', [KualitiController::class,'editorShow'])->name('editor.artikel.show');
    // Route::post('/editor/artikel/update', [KualitiController::class,'editorUpdate'])->name('editor.artikel.update');

    // // hantar dan semak artikel
    // Route::get('/artikel/hantar', [KualitiController::class,'artikelHantar'])->name('artikel.hantar');
    // Route::post('/artikel/store', [KualitiController::class,'artikelStore'])->name('artikel.store');
    // // semak artikel
    // Route::get('/artikel/penyumbang/list', [KualitiController::class,'artikelPenyumbangList'])->name('artikel.penyumbang.list');
    // Route::get('/artikel/editor/list', [KualitiController::class,'artikelEditorList'])->name('artikel.editor.list');
    // Route::get('/artikel/editor/show/{id}', [KualitiController::class,'artikelEditorShow'])->name('artikel.editor.show');
    // Route::post('/artikel/editor/update', [KualitiController::class,'artikelEditorUpdate'])->name('artikel.editor.update');

    // // penerbitan artikel utk dipublish
    // Route::get('/artikel/penerbitan/list', [KualitiController::class,'artikelPenerbitanList'])->name('artikel.penerbitan.list');
    // Route::get('/artikel/penerbitan/show/{id}', [KualitiController::class,'artikelPenerbitanShow'])->name('artikel.penerbitan.show');
    // Route::post('/artikel/penerbitan/update', [KualitiController::class,'artikelPenerbitanUpdate'])->name('artikel.penerbitan.update');




    



