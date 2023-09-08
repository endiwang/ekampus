<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\PekerjaanAlumni;
use App\Models\Pelajar;
use App\Models\PengajianSelepasDq;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class MainAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.alumni.dashboard.main');
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
        //
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
    public function edit(Builder $builder, $id)
    {
        $action = route('alumni.profile.update', $id);
        $page_title = 'Maklumat Alumni';

        $title = 'Maklumat Alumni';
        $breadcrumbs = [
            'Alumni' => false,
            'Profil Peribadi' => false,
        ];

        $pelajar = Pelajar::find($id);

        $pengajianData = PengajianSelepasDq::where('pelajar_id', $pelajar->id);

        if (request()->ajax()) {
            return DataTables::of($pengajianData)
                ->addColumn('tajaan', function ($data) {
                    return empty($data->tajaan) ? '-' : $data->tajaan;
                })
                ->addColumn('peringkat_pengajian', function ($data) {
                    return ucfirst($data->peringkat_pengajian);
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('alumni.profile.pengajian.edit', [$data->pelajar_id, $data->id]) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove(' . $data->id . ')" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-' . $data->id . '" action="' . route('alumni.profile.pengajian.destroy', $data->id) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['tajaan', 'action', 'peringkat_pengajian'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_institusi', 'name' => 'nama_institusi', 'title' => 'Nama Institusi', 'orderable' => false],
                ['data' => 'tarikh_mula', 'name' => 'tarikh_mula', 'title' => 'Tarikh Mula', 'orderable' => false],
                ['data' => 'tarikh_tamat', 'name' => 'tarikh_tamat', 'title' => 'Tarikh Tamat', 'orderable' => true],
                ['data' => 'peringkat_pengajian', 'name' => 'peringkat_pengajian', 'title' => 'Peringkat Pengajian', 'orderable' => true],
                ['data' => 'tajaan', 'name' => 'tajaan', 'title' => 'Tajaan', 'orderable' => true],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        $pekerjaanData = PekerjaanAlumni::where('pelajar_id', $pelajar->id)->first();
        if ($pekerjaanData == null) {
            $pekerjaanData = new PekerjaanAlumni();
        }


        return view('pages.alumni.profile.add_edit', compact('title', 'breadcrumbs', 'page_title', 'action', 'pelajar', 'dataTable', 'pekerjaanData'));
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
        $request->validate([
            'nama' => 'required|string',
            'no_ic' => 'required|numeric',
            'no_matrik' => 'required',
            'email' => 'nullable|email',
            'no_tel' => 'required',
            'alamat' => 'required',
            'poskod' => 'required',
            'bandar' => 'required',
        ]);

        // Find user ID based on pelajar
        $pelajar = Pelajar::find($id);
        $user = User::find($pelajar->user_id);

        // backtrack all the pelajars that under a user
        $pelajars = Pelajar::where('user_id', $user->id)->get();

        foreach ($pelajars as $student) {
            $student->no_matrik = $request->no_matrik;
            $student->email = $request->email;
            $student->no_tel = $request->no_tel;
            $student->alamat = $request->alamat;
            $student->poskod = $request->poskod;
            $student->bandar = $request->bandar;
            $student->save();
        }

        Alert::toast('Maklumat pelajar dikemaskini!', 'success');

        return redirect()->route('alumni.profile.edit', $id);
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

    // Managing maklumat pengajian
    public function pengajian_create(Builder $builder, $pelajarId)
    {
        $pelajar = Pelajar::find($pelajarId);

        $title = $pelajar->nama;
        $page_title = 'Maklumat Pengajian Selepas Darul Quran';
        $action = route('alumni.profile.pengajian.store', $pelajarId);

        $breadcrumbs = [
            'Alumni' => false,
            'Profil Peribadi' => false,
            'Maklumat Pengajian Selepas Darul Quran' => false,
        ];

        return view('pages.alumni.profile.pengajian_form', compact('title', 'breadcrumbs', 'page_title', 'action'));
    }

    public function pengajian_store(Request $request, $id)
    {
        $request->validate(
            [
                'nama_institusi' => 'required|string',
                'tarikh_mula' => 'required',
                'tarikh_tamat' => 'required',
                'peringkat_pengajian' => 'required',
                'tajaan' => 'nullable',
            ],
            [
                'nama_institusi.required' => 'Sila masukkan nama institusi',
                'tarikh_mula.required' => 'Sila masukkan tarikh mula',
                'tarikh_tamat.required' => 'Sila masukkan tarikh tamat',
                'peringkat_pengajian.required' => 'Sila pilih peringkat pengajian',
            ]
        );

        $pelajar = Pelajar::find($id);

        $pengajian = new PengajianSelepasDq();
        $pengajian->pelajar_id = $id;
        $pengajian->user_id = $pelajar->user_id;
        $pengajian->nama_institusi = $request->nama_institusi;
        $pengajian->tarikh_mula = $request->tarikh_mula;
        $pengajian->tarikh_tamat = $request->tarikh_tamat;
        $pengajian->peringkat_pengajian = $request->peringkat_pengajian;
        $pengajian->tajaan = $request->tajaan;
        $pengajian->save();

        Alert::toast('Maklumat pengajian disimpan!', 'success');

        return redirect()->route('alumni.profile.edit', $id);
    }

    public function pengajian_edit(Builder $builder, $pelajarId, $pengajianId)
    {
        $pelajar = Pelajar::find($pelajarId);

        $title = $pelajar->nama;
        $page_title = 'Maklumat Pengajian Selepas Darul Quran';
        $action = route('alumni.profile.pengajian.update', [$pelajarId, $pengajianId]);

        $breadcrumbs = [
            'Alumni' => false,
            'Profil Peribadi' => false,
            'Maklumat Pengajian Selepas Darul Quran' => false,
        ];

        $data = PengajianSelepasDq::find($pengajianId);

        return view('pages.alumni.profile.pengajian_form', compact('title', 'breadcrumbs', 'page_title', 'action', 'data'));
    }

    public function pengajian_update($pelajarId, $pengajianId, Request $request)
    {
        $request->validate(
            [
                'nama_institusi' => 'required|string',
                'tarikh_mula' => 'required',
                'tarikh_tamat' => 'required',
                'peringkat_pengajian' => 'required',
                'tajaan' => 'nullable',
            ],
            [
                'nama_institusi.required' => 'Sila masukkan nama institusi',
                'tarikh_mula.required' => 'Sila masukkan tarikh mula',
                'tarikh_tamat.required' => 'Sila masukkan tarikh tamat',
                'peringkat_pengajian.required' => 'Sila pilih peringkat pengajian',
            ]
        );

        $pengajian = PengajianSelepasDq::find($pengajianId);
        $pengajian->nama_institusi = $request->nama_institusi;
        $pengajian->tarikh_mula = $request->tarikh_mula;
        $pengajian->tarikh_tamat = $request->tarikh_tamat;
        $pengajian->peringkat_pengajian = $request->peringkat_pengajian;
        $pengajian->tajaan = $request->tajaan;
        $pengajian->save();

        Alert::toast('Maklumat pengajian dikemaskini!', 'success');

        return redirect()->route('alumni.profile.edit', $pelajarId);
    }

    public function pengajian_destroy($id)
    {
        PengajianSelepasDq::find($id)->delete();

        Alert::toast('Maklumat pengajian dipadam!', 'success');

        return redirect()->back();
    }

    public function pekerjaan_store(Request $request, $id)
    {
        $request->validate(
            [
                'nama_syarikat' => 'required',
                'jawatan' => 'required',
                'tarikh_mula' => 'required',
                'bidang_industri' => 'required',
            ],
        );
        $pelajar = Pelajar::find($id);

        $pekerjaan = new PekerjaanAlumni();
        $pekerjaan->pelajar_id = $pelajar->id;
        $pekerjaan->user_id = $pelajar->user_id;
        $pekerjaan->nama_syarikat = $request->nama_syarikat;
        $pekerjaan->jawatan = $request->jawatan;
        $pekerjaan->tarikh_mula = $request->tarikh_mula;
        $pekerjaan->bidang_industri = $request->bidang_industri;

        $pekerjaan->save();

        Alert::toast('Maklumat pekerjaan disimpan!', 'success');

        return redirect()->route('alumni.profile.edit', $pelajar->id);
    }

    public function pekerjaan_update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_syarikat' => 'required',
                'jawatan' => 'required',
                'tarikh_mula' => 'required',
                'bidang_industri' => 'required',
            ],
        );

        $pekerjaan = PekerjaanAlumni::find($request->id);

        $pekerjaan->nama_syarikat = $request->nama_syarikat;
        $pekerjaan->jawatan = $request->jawatan;
        $pekerjaan->tarikh_mula = $request->tarikh_mula;
        $pekerjaan->bidang_industri = $request->bidang_industri;

        $pekerjaan->save();

        Alert::toast('Maklumat pekerjaan dikemaskini!', 'success');

        return redirect()->route('alumni.profile.edit', $id);
    }
}
