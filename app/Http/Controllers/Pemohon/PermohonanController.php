<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Negeri;
use App\Models\SubjekSPM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TetapanPermohonanPelajar;
// use Illuminate\Support\Carbon;
use App\Models\PermohonanXHantar;
use App\Models\PermohonanXHantarPenjaga;
use App\Models\PermohonanXHantarTanggunganPenjaga;
use App\Models\PermohonanXHantarKelulusanAkademik;
use App\Models\PermohonanXHantarMuatNaikDokumen;
use Carbon\Carbon;
use Svg\Tag\Rect;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permohonan = TetapanPermohonanPelajar::whereDate('tutup_permohonan', '>=', Carbon::now('Asia/Kuala_Lumpur'))->where('kursus_id',$request->kursus)->get();
        $kursus = Kursus::find($request->kursus);
        $pemohon = Auth::guard('pemohon')->user();
        $subjek_spm = SubjekSPM::all();
        $negeri =  Negeri::pluck('nama','id');
        return view('pages.pemohon.permohonan.main', compact('subjek_spm','pemohon','negeri','kursus','permohonan'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
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
     * @param  \Illuminate\Http\Request  $request
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


    public function store_bahagian_a(Request $request)
    {

        // dump($request->has('tanggungan_nama'));
        // dd($request);

        if($request->file('avatar')) {
            $fileName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $filePath = $request->file('avatar')->storeAs('uploads/gambar_pelajar', $fileName, 'public');
            // $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $file_path = '/storage/' . $filePath;
        }

        $permohonan_x_hantar = PermohonanXHantar::updateOrCreate(
            [
                'pemohon_id' => Auth::guard('pemohon')->user()->id
            ],
            [
                // 'gambar'                => '/storage/' . $filePath;
                'nama_pemohon'          => $file_path,
                'nama_jawi'             => $request->nama_jawi,
                'no_kp'                 => $request->no_kp,
                'tarikh_lahir'          => Carbon::createFromFormat('d/m/Y', $request->tarikh_lahir)->format('Y-m-d'),
                'alamat_tetap'          => $request->alamat_emel,
                'bandar_tetap'          => $request->alamat_tetap,
                'poskod_tetap'          => $request->bandar_tetap,
                'negeri_tetap'          => $request->poskod_tetap,
                'alamat_surat'          => $request->alamat_surat,
                'bandar_surat'          => $request->bandar_surat,
                'poskod_surat'          => $request->poskod_surat,
                'negeri_surat'          => $request->negeri_surat,
                'no_telefon'            => $request->no_telefon,
                'jantina'               => $request->jantina,
                'nageri_kelahiran'      => $request->nageri_kelahiran,
                'bumiputra'             => $request->bumiputra,
                'mualaf'                => $request->mualaf,
                'kewarganegaraan'       => $request->kewarganegaraan,
                'kedaaan_fizikal'       => $request->kedaaan_fizikal,
                'penyakit_kronik'       => json_encode($request->penyakit_kronik),
                'rekod_kemasukan_wad'   => $request->rekod_kemasukan_wad,
                'keturunan'             => $request->keturunan,
            ]);

        $permohonan_x_hantar_penjaga = PermohonanXHantarPenjaga::updateOrCreate(
            [
                'permohoan_x_hantar_id' => $permohonan_x_hantar->id
            ],
            [
                'status_bapa'   => $request->status_bapa,
                'nama_bapa'   => $request->nama_bapa,
                'ic_no_bapa'   => $request->ic_no_bapa,
                'alamat_bapa'   => $request->alamat_bapa,
                'poskod_bapa'   => $request->poskod_bapa,
                'no_telefon_bapa'   => $request->no_telefon_bapa,
                'status_pekerjaan_bapa'   => $request->status_pekerjaan_bapa,
                'jenis_pekerjaan_bapa'   => $request->jenis_pekerjaan_bapa,
                'pendapatan_bapa'   => $request->pendapatan_bapa,

                'status_ibu'   => $request->status_ibu,
                'nama_ibu'   => $request->nama_ibu,
                'ic_no_ibu'   => $request->ic_no_ibu,
                'alamat_ibu'   => $request->alamat_ibu,
                'poskod_ibu'   => $request->poskod_ibu,
                'no_telefon_ibu'   => $request->no_telefon_ibu,
                'status_pekerjaan_ibu'   => $request->status_pekerjaan_ibu,
                'jenis_pekerjaan_ibu'   => $request->jenis_pekerjaan_ibu,
                'pendapatan_ibu'   => $request->pendapatan_ibu,
                'pemohon_tinggal_bersama'   => $request->pemohon_tinggal_bersama,

                'nama_penjaga'   => $request->nama_penjaga,
                'ic_no_penjaga'   => $request->ic_no_penjaga,
                'alamat_penjaga'   => $request->alamat_penjaga,
                'poskod_penjaga'   => $request->poskod_penjaga,
                'no_telefon_penjaga'   => $request->no_telefon_penjaga,
                'status_pekerjaan_penjaga'   => $request->status_pekerjaan_penjaga,
                'jenis_pekerjaan_penjaga'   => $request->jenis_pekerjaan_penjaga,
                'pendapatan_penjaga'   => $request->pendapatan_penjaga,
                'pertalian_penjaga'   => $request->pertalian_penjaga,
            ]);




            if($request->has('tanggungan_nama'))
            {
                $permohonan_x_hantar_tanggunan_penjaga_lama = PermohonanXHantarTanggunganPenjaga::where('permohoan_x_hantar_id',$permohonan_x_hantar->id)->delete();

                foreach ($request->tanggungan_nama as $index => $nama)
                {
                    $permohonan_x_hantar_tanggunan_penjaga = PermohonanXHantarTanggunganPenjaga::create(
                        [
                            'permohoan_x_hantar_id' => $permohonan_x_hantar->id,
                            'nama'      => $nama,
                            'umur'      => $request->tanggungan_umur[$index],
                            'institusi' => $request->tanggungan_institusi[$index],
                        ]);
                }
            }


            $permohonan_x_hantar_kelulusan_akademik_lama = PermohonanXHantarKelulusanAkademik::where('permohoan_x_hantar_id',$permohonan_x_hantar->id)->delete();

            if($request->jenis_peperiksaan == 'spm')
            {
                $subjek_spm = SubjekSPM::where('status',0)->get();
                foreach ($subjek_spm as $subjek)
                {
                    $permohonan_x_hantar_kelulusan_akademik_lama = PermohonanXHantarKelulusanAkademik::create(
                        [
                            'permohoan_x_hantar_id' => $permohonan_x_hantar->id,
                            'type' => $request->jenis_peperiksaan,
                            'tahun_pepriksaan' => $request->tahun_peperiksaan,
                            'nama_sijil' => 'Sijil Pelajaran Malaysia',
                            'nama_pepriksaan' => 'Sijil Pelajaran Malaysia',
                            'matapelajaran' => $subjek->nama,
                            'gred'          => $request->input($subjek->slug),
                        ]);
                }
            }

            if($request->file('mykad_passport')) {
                $fileNameMykad = $request->file('mykad_passport')->getClientOriginalName();
                $filePathMykad = $request->file('mykad_passport')->storeAs('uploads/permohonan/dokumen', $fileNameMykad, 'public');
                $file_path_Mykad = '/storage/' . $filePathMykad;

                $Mykad_passport = PermohonanXHantarMuatNaikDokumen::create(
                    [
                        'permohoan_x_hantar_id' => $permohonan_x_hantar->id,
                        'jenis_dokumen' => 'mykad_passport',
                        'nama_dokumen' => $fileNameMykad,
                        'path' => $file_path_Mykad,
                    ]);
            }

            if($request->file('sijil_spm_setara')) {
                $fileNameSPM = $request->file('sijil_spm_setara')->getClientOriginalName();
                $filePathSPM = $request->file('sijil_spm_setara')->storeAs('uploads/permohonan/dokumen', $fileNameSPM, 'public');
                $file_path_SPM= '/storage/' . $filePathSPM;

                $SPM = PermohonanXHantarMuatNaikDokumen::create(
                    [
                        'permohoan_x_hantar_id' => $permohonan_x_hantar->id,
                        'jenis_dokumen' => 'sijil_spm_setara',
                        'nama_dokumen' => $fileNameSPM,
                        'path' => $file_path_SPM,
                    ]);
            }

            if($request->file('kad_oku')) {
                $fileNameOKU = $request->file('kad_oku')->getClientOriginalName();
                $filePathOKU = $request->file('kad_oku')->storeAs('uploads/permohonan/dokumen', $fileNameOKU, 'public');
                $file_path_OKU = '/storage/' . $filePathOKU;

                $Kad_OKU= PermohonanXHantarMuatNaikDokumen::create(
                    [
                        'permohoan_x_hantar_id' => $permohonan_x_hantar->id,
                        'jenis_dokumen' => 'kad_oku',
                        'nama_dokumen' => $fileNameOKU,
                        'path' => $file_path_OKU,
                    ]);
            }



    }

    public function store_bahagian_b(Request $request)
    {

    }

    public function store_bahagian_c(Request $request)
    {

    }

    public function store_bahagian_d(Request $request)
    {

    }

    public function store_bahagian_e(Request $request)
    {

    }

}

