<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\ProgramPelajar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use Illuminate\Support\Carbon;
use App\Models\Kursus;

class PengurusanProgramPelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseView = 'pages.pengurusan.hep.pengurusan.program_pelajar.';

    public function index(Builder $builder)
    {
        $title = 'Pengurusan Program Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Program Pelajar' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Program Pelajar',
                'route' => route('pengurusan.hep.pengurusan.program_pelajar.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = ProgramPelajar::query();

            return DataTables::of($data)
                ->addColumn('tarikh_mula', function ($data) {
                    $tarikh = Utils::formatDate($data->tarikh_mula);

                    return $tarikh;
                })
                ->addColumn('tarikh_tamat', function ($data) {
                    $tarikh = Utils::formatDate($data->tarikh_tamat);

                    return $tarikh;
                })
                ->addColumn('kehadiran', function ($data) {
                    switch ($data->jenis_kehadiran) {
                        case 0:
                            return '<span class="badge badge-info">Tidak Wajib</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Wajib</span>';
                            break;
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar', $data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                        <i class="fa fa-user-plus"></i></a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.program_pelajar.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['tarikh_mula', 'tarikh_tamat', 'kehadiran','action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_program', 'name' => 'nama_program', 'title' => 'Nama Program', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_mula', 'name' => 'tarikh_mula', 'title' => 'Tarikh Mula', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_tamat', 'name' => 'tarikh_tamat', 'title' => 'Tarikh Tamat', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'kehadiran', 'name' => 'kehadiran', 'title' => 'Kehadiran', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('pengurusan.hep.pengurusan.program_pelajar.store');
        $page_title = 'Tambah Program Pelajar';

        $title = 'Tambah Program Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Program Pelajar' => false,
            'Tambah Program' => false,
        ];

        $model = new ProgramPelajar();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required',
            'maklumat_program' => 'required',
            'lokasi_program' => 'required',
            'tarikh_mula_program' => 'required',
            'masa_mula' => 'required',
            'tarikh_tamat_program' => 'required',
            'masa_tamat' => 'required',
            'jumlah_sesi' => 'required',
            'jenis_kehadiran' => 'required',
        ], [
            'nama_program.required' => 'Sila masukkan nama program',
            'maklumat_program.required' => 'Sila masukkan keterangan program',
            'lokasi_program.required' => 'Sila masukkan lokasi program',
            'tarikh_mula_program.required' => 'Sila masukkan tarikh mula program',
            'masa_mula.required' => 'Sila masukkan masa mula program',
            'tarikh_tamat_program.required' => 'Sila masukkan tarikh tamat program',
            'masa_tamat.required' => 'Sila masukkan masa tamat program',
            'jumlah_sesi.required' => 'Sila masukkan jumalah sesi',
            'jenis_kehadiran.required' => 'Sila pilih jenis kehadiran',
        ]);

        $request->request->add([
            'tarikh_mula' => Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_program)->format('Y-m-d'),
            'tarikh_tamat' => Carbon::createFromFormat('d/m/Y', $request->tarikh_tamat_program)->format('Y-m-d'),
        ]);

        $data = ProgramPelajar::create($request->all());

        Alert::toast('Maklumat program perlajar berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.program_pelajar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $action = route('pengurusan.hep.pengurusan.program_pelajar.store');
        $page_title = 'Maklumat Program Pelajar';

        $title = 'Maklumat Program Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Program Pelajar' => false,
            'Maklumat Program' => false,
        ];

        $model = ProgramPelajar::find($id);

        return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'page_title'));
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

    public function pilih_pelajar($id)
    {
        $action = route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar_store',$id);
        $page_title = 'Tambah Program Pelajar';

        $title = 'Tambah Program Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Program Pelajar' => false,
            'Tambah Program' => false,
        ];

        $model = ProgramPelajar::find($id);
        $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');


        return view($this->baseView.'pilih_pelajar', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','kursus'));
    }

    public function pilih_pelajar_store($id)
    {
        dd($id);
    }
}
