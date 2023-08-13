<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Mail\PermohonanBerjayaDihantar;
use App\Models\Keturunan;
use App\Models\Kursus;
use App\Models\Negeri;
use App\Models\Permohonan;
use App\Models\PermohonanKelulusanAkademik;
use App\Models\PermohonanMuatnaikDokumen;
use App\Models\PermohonanPenjaga;
use App\Models\PermohonanSekolah;
use App\Models\PermohonanTanggunganPenjaga;
use App\Models\PermohonanXHantar;
use App\Models\PermohonanXHantarKelulusanAkademik;
use App\Models\PermohonanXHantarMuatNaikDokumen;
// use Illuminate\Support\Carbon;
use App\Models\PermohonanXHantarPenjaga;
use App\Models\PermohonanXHantarSekolah;
use App\Models\PermohonanXHantarTanggunganPenjaga;
use App\Models\SubjekSPM;
use App\Models\TetapanPermohonanPelajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $maklumat_pemohon = PermohonanXHantar::where('pemohon_id', Auth::guard('pemohon')->user()->id)->get()->last();
        if ($maklumat_pemohon != null) {
            $maklumat_penjaga = PermohonanXHantarPenjaga::where('permohonan_x_hantar_id', $maklumat_pemohon->id)->first();
            $maklumat_akademik = PermohonanXHantarKelulusanAkademik::where('permohonan_x_hantar_id', $maklumat_pemohon->id)->first();
        } else {
            $maklumat_penjaga = null;
            $maklumat_akademik = null;
        }

        // dd($maklumat_penjaga);

        $permohonan = TetapanPermohonanPelajar::whereDate('tutup_permohonan', '>=', Carbon::now('Asia/Kuala_Lumpur'))->where('kursus_id', $request->kursus)->get();
        $kursus = Kursus::find($request->kursus);
        $pemohon = Auth::guard('pemohon')->user();
        $subjek_spm = SubjekSPM::all();
        $negeri = Negeri::pluck('nama', 'id');

        return view('pages.pemohon.permohonan.main', compact('subjek_spm', 'pemohon', 'negeri', 'kursus', 'permohonan', 'maklumat_pemohon', 'maklumat_penjaga', 'maklumat_akademik'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $no_rujukan = 'P'.date('Ymd').'_'.uniqid();

        // dump($no_rujukan);
        // dd($request);
        $keturunan = Keturunan::where('kod', $request->keturunan)->first();

        if ($request->file('avatar')) {
            $fileName = $request->file('avatar')->getClientOriginalName();
            $filePath = $request->file('avatar')->storeAs('uploads/permohonan/gambar_pemohon', $fileName, 'public');
            // $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $file_path = '/storage/'.$filePath;
        }

        foreach ($request->pilih_pusat_pengajian as $index => $pilih_pusat_pengajian) {
            $tetapan_permohonan = TetapanPermohonanPelajar::find($request->permohonan_id[$index]);
            $permohonan = Permohonan::create([
                'gambar' => $file_path,
                'no_rujukan' => $no_rujukan,
                'kursus_id' => $tetapan_permohonan->kursus_id,
                'sesi_id' => $tetapan_permohonan->sesi_id,
                'pusat_pengajian_id' => $pilih_pusat_pengajian,
                'nama' => $request->nama_pemohon,
                'nama_jawi' => $request->nama_jawi,
                'email' => Auth::guard('pemohon')->user()->email,
                'no_ic' => Auth::guard('pemohon')->user()->username,
                'tarikh_lahir' => Carbon::createFromFormat('d/m/Y', $request->tarikh_lahir)->format('Y-m-d'),
                'alamat_tetap' => $request->alamat_tetap,
                'poskod' => $request->poskod_tetap,
                'bandar' => $request->bandar_tetap,
                //daerah_id
                'negeri_id' => $request->negeri_tetap,
                // dun_id
                // parlimen_id
                'no_tel' => $request->no_telefon,
                'jantina' => $request->jantina,
                'negeri_kelahiran_id' => $request->negeri_kelahiran_id,
                'alamat_surat' => $request->alamat_surat,
                'bandar_surat' => $request->bandar_surat,
                'poskod_surat' => $request->poskod_surat,
                'negeri_surat' => $request->negeri_surat,
                'keturunan_id' => $keturunan->id,
                'bumiputra' => $request->bumiputra,
                'mualaf' => $request->mualaf,
                'warganegara' => $request->kewarganegaraan,
                'kedaaan_fizikal' => $request->kedaaan_fizikal,
                'penyakit_kronik' => json_encode($request->penyakit_kronik),
                'rekod_kemasukan_wad' => $request->rekod_kemasukan_wad,
                'temuduga' => $request->pusat_temuduga[$index],
                'perakuan' => $request->perakuan_pemohon,
                'is_submitted' => 1,
                'submitted_date' => Carbon::now(),

            ]);

            $permohonan_penjaga = PermohonanPenjaga::create([
                'permohonan_id' => $permohonan->id,
                'status_bapa' => $request->status_bapa == 'masih_hidup' ? 1 : 2,
                'nama_bapa' => $request->nama_bapa,
                'no_ic_bapa' => $request->ic_no_bapa,
                'alamat_surat_bapa' => $request->alamat_bapa,
                'poskod_bapa' => $request->poskod_bapa,
                'no_tel_bapa' => $request->no_telefon_bapa,
                'status_pekerjaan_bapa' => $request->status_pekerjaan_bapa,
                // 'jenis_pekerjaan_bapa'   => $request->jenis_pekerjaan_bapa,
                // 'pekerjaan_bapa'
                'pendapatan_bapa' => $request->pendapatan_bapa,

                'status_ibu' => $request->status_ibu == 'masih_hidup' ? 1 : 2,
                'nama_ibu' => $request->nama_ibu,
                'no_ic_ibu' => $request->ic_no_ibu,
                'alamat_surat_ibu' => $request->alamat_ibu,
                'poskod_ibu' => $request->poskod_ibu,
                'no_tel_ibu' => $request->no_telefon_ibu,
                'status_pekerjaan_ibu' => $request->status_pekerjaan_ibu,
                // 'jenis_pekerjaan_ibu'   => $request->jenis_pekerjaan_ibu,
                // 'pekerjaan_ibu'

                'pendapatan_ibu' => $request->pendapatan_ibu,
                'tingal_bersama' => $request->pemohon_tinggal_bersama == 'ibu_bapa' ? 1 : 2,

                'nama_penjaga' => $request->nama_penjaga,
                'no_ic_penjaga' => $request->ic_no_penjaga,
                'alamat_surat_penjaga' => $request->alamat_penjaga,
                'poskod_penjaga' => $request->poskod_penjaga,
                'no_tel_penjaga' => $request->no_telefon_penjaga,
                'status_pekerjaan_penjaga' => $request->status_pekerjaan_penjaga,
                // 'jenis_pekerjaan_penjaga'   => $request->jenis_pekerjaan_penjaga,
                // 'pekerjaan_penjaga'

                'pendapatan_penjaga' => $request->pendapatan_penjaga,
                'pertalian_penjaga' => $request->pertalian_penjaga,
            ]);

            if ($request->has('tanggungan_nama')) {
                foreach ($request->tanggungan_nama as $index => $nama) {
                    $permohonan_tanggunan_penjaga = PermohonanTanggunganPenjaga::create(
                        [
                            'permohonan_id' => $permohonan->id,
                            'nama' => $nama,
                            'umur' => $request->tanggungan_umur[$index],
                            'institusi' => $request->tanggungan_institusi[$index],
                        ]);
                }
            }

            if ($request->jenis_peperiksaan == 'spm') {
                $subjek_spm = SubjekSPM::where('status', 0)->get();
                foreach ($subjek_spm as $subjek) {
                    $permohonan_kelulusan_akademik = PermohonanKelulusanAkademik::create(
                        [
                            'permohonan_id' => $permohonan->id,
                            'type' => $request->jenis_peperiksaan,
                            'tahun_pepriksaan' => $request->tahun_peperiksaan,
                            'nama_sijil' => 'Sijil Pelajaran Malaysia',
                            'nama_pepriksaan' => 'Sijil Pelajaran Malaysia',
                            'matapelajaran' => $subjek->nama,
                            'gred' => $request->input($subjek->slug),
                        ]);
                }
            } elseif ($request->jenis_peperiksaan == 'setara') {
                foreach ($request->subjek_nama as $index => $subjek_setara) {
                    $permohonan_kelulusan_akademik = PermohonanKelulusanAkademik::create(
                        [
                            'permohonan_id' => $permohonan->id,
                            'type' => $request->jenis_peperiksaan,
                            'tahun_pepriksaan' => $request->tahun_peperiksaan,
                            'nama_sijil' => $request->sijil_lain,
                            'nama_pepriksaan' => $request->nama_peperiksaan_sijil_lain,
                            'matapelajaran' => $subjek_setara,
                            'gred' => $request->subjek_gred[$index],
                        ]);
                }
            }

            if ($request->has('pendidikan_sekolah')) {
                foreach ($request->pendidikan_sekolah as $index => $pendidikan) {
                    $permohonan_sekolah = PermohonanSekolah::create(
                        [
                            'permohonan_id' => $permohonan->id,
                            'sekolah' => $request->pendidikan_sekolah[$index],
                            'tahun' => $request->pendidikan_tahun[$index],
                            'keputusan' => $request->pendidikan_keputusan[$index],
                            'kelulusan' => $request->pendidikan_kelulusan[$index],
                        ]);
                }

            }

            if ($request->file('mykad_passport')) {
                $fileNameMykad = $request->file('mykad_passport')->getClientOriginalName();
                $filePathMykad = $request->file('mykad_passport')->storeAs('uploads/permohonan/dokumen', $fileNameMykad, 'public');
                $file_path_Mykad = '/storage/'.$filePathMykad;

                $Mykad_passport = PermohonanMuatnaikDokumen::updateOrCreate(
                    [
                        'permohonan_id' => $permohonan->id,
                        'jenis_dokumen' => 'mykad_passport',
                    ],
                    [
                        'nama_dokumen' => $fileNameMykad,
                        'path' => $file_path_Mykad,
                    ]);
            }

            if ($request->file('sijil_spm_setara')) {
                $fileNameSPM = $request->file('sijil_spm_setara')->getClientOriginalName();
                $filePathSPM = $request->file('sijil_spm_setara')->storeAs('uploads/permohonan/dokumen', $fileNameSPM, 'public');
                $file_path_SPM = '/storage/'.$filePathSPM;

                $SPM = PermohonanMuatnaikDokumen::updateOrCreate(
                    [
                        'permohonan_id' => $permohonan->id,
                        'jenis_dokumen' => 'sijil_spm_setara',
                    ],
                    [
                        'nama_dokumen' => $fileNameSPM,
                        'path' => $file_path_SPM,
                    ]);
            }

            if ($request->file('kad_oku')) {
                $fileNameOKU = $request->file('kad_oku')->getClientOriginalName();
                $filePathOKU = $request->file('kad_oku')->storeAs('uploads/permohonan/dokumen', $fileNameOKU, 'public');
                $file_path_OKU = '/storage/'.$filePathOKU;

                $Kad_OKU = PermohonanMuatnaikDokumen::updateOrCreate(
                    [
                        'permohonan_id' => $permohonan->id,
                        'jenis_dokumen' => 'kad_oku',
                    ],
                    [
                        'nama_dokumen' => $fileNameOKU,
                        'path' => $file_path_OKU,
                    ]);
            }

            Mail::to($permohonan->email)->send(new PermohonanBerjayaDihantar($permohonan));

        }

        return redirect()->route('pemohon.permohonan.berjaya_dihantar')->with(['data' => $permohonan]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function simpan_dan_seterusnya(Request $request)
    {

        $permohonan_x_hantar_data = PermohonanXHantar::where('pemohon_id', Auth::guard('pemohon')->user()->id)->first();

        if ($request->file('avatar')) {

            if ($permohonan_x_hantar_data == null || $request->file('avatar')->getClientOriginalName() != $permohonan_x_hantar_data->gambar) {
                $fileName = $request->file('avatar')->getClientOriginalName();
                $filePath = $request->file('avatar')->storeAs('uploads/permohonan/gambar_pemohon', $fileName, 'public');
                // $fileModel->name = time().'_'.$req->file->getClientOriginalName();
                $file_path = '/storage/'.$filePath;
            } else {
                $file_path = $permohonan_x_hantar_data->gambar;
            }
        }

        $permohonan_x_hantar = PermohonanXHantar::updateOrCreate(
            [
                'pemohon_id' => Auth::guard('pemohon')->user()->id,
            ],
            [
                // 'gambar'                => '/storage/' . $filePath;
                'gambar' => $file_path,
                'nama_pemohon' => $request->nama_pemohon,
                'nama_jawi' => $request->nama_jawi,
                'no_kp' => Auth::guard('pemohon')->user()->username,
                'tarikh_lahir' => Carbon::createFromFormat('d/m/Y', $request->tarikh_lahir)->format('Y-m-d'),
                'alamat_tetap' => $request->alamat_tetap,
                'bandar_tetap' => $request->bandar_tetap,
                'poskod_tetap' => $request->poskod_tetap,
                'negeri_tetap' => $request->negeri_tetap,
                'alamat_surat' => $request->alamat_surat,
                'bandar_surat' => $request->bandar_surat,
                'poskod_surat' => $request->poskod_surat,
                'negeri_surat' => $request->negeri_surat,
                'no_telefon' => $request->no_telefon,
                'jantina' => $request->jantina,
                'negeri_kelahiran' => $request->negeri_kelahiran,
                'bumiputra' => $request->bumiputra,
                'mualaf' => $request->mualaf,
                'kewarganegaraan' => $request->kewarganegaraan,
                'kedaaan_fizikal' => $request->kedaaan_fizikal,
                'penyakit_kronik' => json_encode($request->penyakit_kronik),
                'rekod_kemasukan_wad' => $request->rekod_kemasukan_wad,
                'keturunan' => $request->keturunan,
            ]);

        $permohonan_x_hantar_penjaga = PermohonanXHantarPenjaga::updateOrCreate(
            [
                'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
            ],
            [
                'status_bapa' => $request->status_bapa,
                'nama_bapa' => $request->nama_bapa,
                'ic_no_bapa' => $request->ic_no_bapa,
                'alamat_bapa' => $request->alamat_bapa,
                'poskod_bapa' => $request->poskod_bapa,
                'no_telefon_bapa' => $request->no_telefon_bapa,
                'status_pekerjaan_bapa' => $request->status_pekerjaan_bapa,
                'jenis_pekerjaan_bapa' => $request->jenis_pekerjaan_bapa,
                'pendapatan_bapa' => $request->pendapatan_bapa,

                'status_ibu' => $request->status_ibu,
                'nama_ibu' => $request->nama_ibu,
                'ic_no_ibu' => $request->ic_no_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'poskod_ibu' => $request->poskod_ibu,
                'no_telefon_ibu' => $request->no_telefon_ibu,
                'status_pekerjaan_ibu' => $request->status_pekerjaan_ibu,
                'jenis_pekerjaan_ibu' => $request->jenis_pekerjaan_ibu,
                'pendapatan_ibu' => $request->pendapatan_ibu,
                'pemohon_tinggal_bersama' => $request->pemohon_tinggal_bersama,

                'nama_penjaga' => $request->nama_penjaga,
                'ic_no_penjaga' => $request->ic_no_penjaga,
                'alamat_penjaga' => $request->alamat_penjaga,
                'poskod_penjaga' => $request->poskod_penjaga,
                'no_telefon_penjaga' => $request->no_telefon_penjaga,
                'status_pekerjaan_penjaga' => $request->status_pekerjaan_penjaga,
                'jenis_pekerjaan_penjaga' => $request->jenis_pekerjaan_penjaga,
                'pendapatan_penjaga' => $request->pendapatan_penjaga,
                'pertalian_penjaga' => $request->pertalian_penjaga,
            ]);

        if ($request->has('tanggungan_nama')) {
            $permohonan_x_hantar_tanggunan_penjaga_lama = PermohonanXHantarTanggunganPenjaga::where('permohonan_x_hantar_id', $permohonan_x_hantar->id)->delete();

            foreach ($request->tanggungan_nama as $index => $nama) {
                $permohonan_x_hantar_tanggunan_penjaga = PermohonanXHantarTanggunganPenjaga::create(
                    [
                        'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                        'nama' => $nama,
                        'umur' => $request->tanggungan_umur[$index],
                        'institusi' => $request->tanggungan_institusi[$index],
                    ]);
            }
        }

        $permohonan_x_hantar_kelulusan_akademik_lama = PermohonanXHantarKelulusanAkademik::where('permohonan_x_hantar_id', $permohonan_x_hantar->id)->delete();

        if ($request->jenis_peperiksaan == 'spm') {
            $subjek_spm = SubjekSPM::where('status', 0)->get();
            foreach ($subjek_spm as $subjek) {
                $permohonan_x_hantar_kelulusan_akademik_lama = PermohonanXHantarKelulusanAkademik::create(
                    [
                        'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                        'type' => $request->jenis_peperiksaan,
                        'tahun_pepriksaan' => $request->tahun_peperiksaan,
                        'nama_sijil' => 'Sijil Pelajaran Malaysia',
                        'nama_pepriksaan' => 'Sijil Pelajaran Malaysia',
                        'matapelajaran' => $subjek->nama,
                        'gred' => $request->input($subjek->slug),
                    ]);
            }
        } elseif ($request->jenis_peperiksaan == 'setara') {
            foreach ($request->subjek_nama as $index => $subjek_setara) {
                $permohonan_x_hantar_kelulusan_akademik_lama = PermohonanXHantarKelulusanAkademik::create(
                    [
                        'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                        'type' => $request->jenis_peperiksaan,
                        'tahun_pepriksaan' => $request->tahun_peperiksaan,
                        'nama_sijil' => $request->sijil_lain,
                        'nama_pepriksaan' => $request->nama_peperiksaan_sijil_lain,
                        'matapelajaran' => $subjek_setara,
                        'gred' => $request->subjek_gred[$index],
                    ]);
            }
        }

        $permohonan_x_hantar_sekolah_lama = PermohonanXHantarSekolah::where('permohonan_x_hantar_id', $permohonan_x_hantar->id)->delete();

        foreach ($request->pendidikan_sekolah as $index => $pendidikan) {
            $permohonan_x_hantar_sekolah_lama = PermohonanXHantarSekolah::create(
                [
                    'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                    'sekolah' => $request->pendidikan_sekolah[$index],
                    'tahun' => $request->pendidikan_tahun[$index],
                    'keputusan' => $request->pendidikan_keputusan[$index],
                    'kelulusan' => $request->pendidikan_kelulusan[$index],
                ]);
        }

        $muat_naik_mykad_lama = PermohonanXHantarMuatNaikDokumen::where('permohonan_x_hantar_id', $permohonan_x_hantar->id)->where('jenis_dokumen', 'mykad_passport')->first();

        if ($muat_naik_mykad_lama == null || $request->file('mykad_passport')->getClientOriginalName() != $muat_naik_mykad_lama->nama_dokumen) {

            if ($request->file('mykad_passport')) {
                $fileNameMykad = $request->file('mykad_passport')->getClientOriginalName();
                $filePathMykad = $request->file('mykad_passport')->storeAs('uploads/permohonan/dokumen', $fileNameMykad, 'public');
                $file_path_Mykad = '/storage/'.$filePathMykad;

                $Mykad_passport = PermohonanXHantarMuatNaikDokumen::updateOrCreate(
                    [
                        'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                        'jenis_dokumen' => 'mykad_passport',
                    ],
                    [
                        'nama_dokumen' => $fileNameMykad,
                        'path' => $file_path_Mykad,
                    ]);
            }
        }

        $muat_naik_sijil_spm_setara_lama = PermohonanXHantarMuatNaikDokumen::where('permohonan_x_hantar_id', $permohonan_x_hantar->id)->where('jenis_dokumen', 'sijil_spm_setara')->first();

        if ($muat_naik_sijil_spm_setara_lama == null || $request->file('sijil_spm_setara')->getClientOriginalName() != $muat_naik_sijil_spm_setara_lama->nama_dokumen) {
            if ($request->file('sijil_spm_setara')) {
                $fileNameSPM = $request->file('sijil_spm_setara')->getClientOriginalName();
                $filePathSPM = $request->file('sijil_spm_setara')->storeAs('uploads/permohonan/dokumen', $fileNameSPM, 'public');
                $file_path_SPM = '/storage/'.$filePathSPM;

                $SPM = PermohonanXHantarMuatNaikDokumen::updateOrCreate(
                    [
                        'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                        'jenis_dokumen' => 'sijil_spm_setara',
                    ],
                    [
                        'nama_dokumen' => $fileNameSPM,
                        'path' => $file_path_SPM,
                    ]);
            }
        }

        $muat_naik_kad_oku_lama = PermohonanXHantarMuatNaikDokumen::where('permohonan_x_hantar_id', $permohonan_x_hantar->id)->where('jenis_dokumen', 'kad_oku')->first();

        if ($muat_naik_sijil_spm_setara_lama == null || $request->file('sijil_spm_setara')->getClientOriginalName() != $muat_naik_sijil_spm_setara_lama->nama_dokumen) {
            if ($request->file('kad_oku')) {
                $fileNameOKU = $request->file('kad_oku')->getClientOriginalName();
                $filePathOKU = $request->file('kad_oku')->storeAs('uploads/permohonan/dokumen', $fileNameOKU, 'public');
                $file_path_OKU = '/storage/'.$filePathOKU;

                $Kad_OKU = PermohonanXHantarMuatNaikDokumen::updateOrCreate(
                    [
                        'permohonan_x_hantar_id' => $permohonan_x_hantar->id,
                        'jenis_dokumen' => 'kad_oku',
                    ],
                    [
                        'nama_dokumen' => $fileNameOKU,
                        'path' => $file_path_OKU,
                    ]);
            }
        }

    }

    public function berjaya_dihantar()
    {

        $data = Session::get('data');

        if ($data != null) {
            $tarikh_hantar = Carbon::parse($data->created_at)->format('d/m/Y g:i A');

            return view('pages.pemohon.permohonan.berjaya_hantar', compact('tarikh_hantar'));
        } else {
            return redirect()->route('pemohon.utama.index');
        }

    }
}
