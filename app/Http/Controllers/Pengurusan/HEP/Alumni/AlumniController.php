<?php

namespace App\Http\Controllers\Pengurusan\HEP\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\PengajianSelepasDq;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class AlumniController extends Controller
{
    protected $baseView = 'pages.pengurusan.hep.alumni.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {
            $title = 'Senarai Alumni';
            $breadcrumbs = [
                'Hal Ehwal Pelajar' => false,
                'Alumni' => false,
                'Senarai' => false,
            ];

            $data = Pelajar::where('is_alumni', 1);

            if (request()->ajax()) {
                return DataTables::of($data)
                    ->addColumn('gred_akhir', function ($data) {
                        return empty($data->gred_akhir) ? '-' : $data->gred_akhir;
                    })
                    // ->addColumn('jam_kredit', function ($data) {
                    //     return $data->subjek->kredit ?? null;
                    // })
                    ->addColumn('action', function ($data) {
                        return '
                             <a href="' . route('pengurusan.hep.alumni.edit', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                 <i class="fa fa-eye"></i>
                             </a>
                        ';
                    })
                    ->addIndexColumn()
                    // ->order(function ($data) {
                    //     $data->orderBy('id', 'desc');
                    // })
                    ->rawColumns(['gred_akhir', 'action'])
                    ->toJson();
            }

            // dd($data);
            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan', 'orderable' => false],
                    ['data' => 'gred_akhir', 'name' => 'gred_akhir', 'title' => 'Gred Akhir', 'orderable' => true],
                    ['data' => 'tarikh_berhenti', 'name' => 'tarikh_berhenti', 'title' => 'Tarikh Berhenti', 'orderable' => true],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();


            return view($this->baseView . 'index', compact('title', 'breadcrumbs', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Builder $builder, $id)
    {
        $action = route('pengurusan.hep.alumni.update', $id);
        $page_title = 'Maklumat Alumni';

        $title = 'Maklumat Alumni';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Alumni' => false,
        ];
        $pelajar = Pelajar::find($id);

        $data = PengajianSelepasDq::where('pelajar_id', $pelajar->id);

        if (request()->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('pengurusan.hep.alumni.edit', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove(' . $data->id . ')" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-' . $data->id . '" action="' . route('pengurusan.hep.alumni.pengajian.destroy', $data->id) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_institusi', 'name' => 'nama_institusi', 'title' => 'Nama Institusi', 'orderable' => false],
                ['data' => 'tarikh_mula', 'name' => 'tarikh_mula', 'title' => 'Tarikh Mula', 'orderable' => false],
                ['data' => 'tarikh_tamat', 'name' => 'tarikh_tamat', 'title' => 'Tarikh Tamat', 'orderable' => true],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView . 'add_edit', compact('title', 'breadcrumbs', 'page_title', 'action', 'pelajar', 'dataTable'));
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

    // Managing maklumat pengajian
    public function pengajian_store(Request $request, $id)
    {
        $request->validate(
            [
                'nama_institusi' => 'required|string',
                'tarikh_mula' => 'required',
                'tarikh_tamat' => 'required',
            ],
            [
                'nama_institusi.required' => 'Sila masukkan nama institusi',
                'tarikh_mula.required' => 'Sila masukkan tarikh mula',
                'tarikh_tamat.required' => 'Sila masukkan tarikh tamat',
            ]
        );

        $pelajar = Pelajar::find($id);

        $pengajian = new PengajianSelepasDq();
        $pengajian->pelajar_id = $id;
        $pengajian->user_id = $pelajar->user_id;
        $pengajian->nama_institusi = $request->nama_institusi;
        $pengajian->tarikh_mula = $request->tarikh_mula;
        $pengajian->tarikh_tamat = $request->tarikh_tamat;
        $pengajian->save();

        Alert::toast('Maklumat pengajian disimpan!', 'success');

        return redirect()->route('pengurusan.hep.alumni.edit', $id);

    }

    public function pengajian_edit($pelajarId, $pengajianId)
    {
        dd($pelajarId, $pengajianId);

    }

    public function pengajian_destroy($id)
    {
        PengajianSelepasDq::find($id)->delete();

        return redirect()->back();
    }
}