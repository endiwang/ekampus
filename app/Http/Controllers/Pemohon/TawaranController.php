<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\TawaranPermohonan;
use Illuminate\Http\Request;
use App\Models\Pelajar;
use App\Models\User;
use Illuminate\Support\Carbon;

class TawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $permohonan = Permohonan::find($id);

        return view('pages.pemohon.tawaran.main', compact('permohonan'));
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
        // dd($request);
        $tawaran_pemohon = TawaranPermohonan::where('permohonan_id', $request->id)->first();
        $tawaran_pemohon->is_terima = $request->is_terima;
        $tawaran_pemohon->save();

        $permohonan = Permohonan::find($tawaran_pemohon->permohonan_id);

        //password = 123

        $user = User::where('username', $permohonan->no_ic)->first();

        // dd($permohonan);


        $password_hash = '$2y$10$DYl/XAwUYLdFk4BDUD0lkO12yxz0ZO.YpwySx0ZV9.OBVF2o/vi2y';



        if (! $user) {
            $user = User::create([
                'username' => $permohonan->no_ic,
                'password' => $password_hash,
                'is_student' => 1,
            ]);
        }

        $user->assignRole('pelajar');

        $pelajar = Pelajar::create([
            'user_id' => $user->id,
            'kursus_id' => $permohonan->kursus_id,
            'img_pelajar' => $permohonan->gambar,
            'no_ic' => $permohonan->no_ic,
            'email' => $permohonan->email,
            'nama' => $permohonan->nama,
            'tarikh_lahir' => $permohonan->tarikh_lahir,
            'alamat' => $permohonan->alamat_tetap,
            'bandar' => $permohonan->bandar,
            'poskod' => $permohonan->poskod,
            'negeri_id' => $permohonan->negeri_id,
            'alamat_surat' => $permohonan->alamat_surat,
            'bandar_surat' => $permohonan->bandar_surat,
            'poskod_surat' => $permohonan->poskod_surat,
            'negeri_id_surat' => $request->negeri_surat,
            'no_tel' => $permohonan->no_tel,
            'jantina' => $permohonan->jantina,
            'negeri_kelahiran_id' => $permohonan->negeri_kelahiran_id,
            'keturunan_id' => $permohonan->keturunan_id,
            'bumiputra' => $permohonan->bumiputra,
            'mualaf' => $permohonan->mualaf,
            'warganegara' => $permohonan->kewarganegaraan,
            'syukbah_id' => 1,
            'sesi_id' => $permohonan->sesi_id,
        ]);


        return redirect()->route('pemohon.utama.index');
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
}
