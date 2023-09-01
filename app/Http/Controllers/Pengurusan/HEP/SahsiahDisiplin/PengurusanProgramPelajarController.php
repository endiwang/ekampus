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
use App\Models\Pelajar;
use App\Models\ProgramPelajarKehadiran;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;



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
                    if($data->jenis_kehadiran == 1)
                    {
                    return '
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.qr_code_kehadiran', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-qrcode"></i>
                        </a>
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar', $data->id).'" class="edit btn btn-icon btn-dark btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip">
                        <i class="fa fa-user-plus"></i></a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.program_pelajar.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">';
                    }else{
                        return '
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="'.route('pengurusan.hep.pengurusan.program_pelajar.qr_code_kehadiran', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-qrcode"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.program_pelajar.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">';
                    }
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
    public function show(Builder $builder, $id)
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

        if (request()->ajax()) {
            $data = ProgramPelajarKehadiran::where('program_id', $id)->with('pelajar')->get();

            return DataTables::of($data)
                ->addColumn('nama', function ($data) {
                    if (! empty($data->pelajar)) {
                        return $data->pelajar->nama ?? 'N/A';
                    } else {
                        return 'N/A';
                    }
                    return $data->pelajar ?? null;
                })
                ->addColumn('no_matrik', function ($data) {
                    if (! empty($data->pelajar)) {
                        return $data->pelajar->no_matrik ?? 'N/A';
                    } else {
                        return 'N/A';
                    }
                    return $data->pelajar ?? null;
                })
                ->addColumn('action', function ($data) use($id) {
                    return '
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar_destroy', [$id,$data->id]).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        ';
                })
                ->addIndexColumn()
                ->rawColumns(['nama', 'kursus','sesi', 'action'])
                ->toJson();
        }


        for ($i=1; $i <= $model->jumlah_sesi; $i++) {

            $column_sesi[] = ['data' => 'sesi_'.$i,'name' => 'sesi_'.$i,'title' => 'Sesi '.$i, 'orderable' => false];
        }
        $other_column =
        [
            ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
            ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'min-w-200px'],
            ['data' => 'no_matrik',      'name' => 'no_matrik',         'title' => 'No Matrik', 'orderable' => false],
        ];
        $action_column =
        [
            ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'min-w-100px']
        ];
        $all_column = array_merge($other_column, $column_sesi,$action_column);
        $dataTable = $builder
        ->columns($all_column)
        ->minifiedAjax();


        return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'page_title','dataTable'));
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
        ProgramPelajar::find($id)->delete();

        Alert::toast('Rekod program pelajar berjaya dihapuskan!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.program_pelajar.index');
    }


    public function pilih_pelajar(Builder $builder, Request $request, $id)
    {
        $action = route('pengurusan.hep.pengurusan.program_pelajar.pilih_pelajar_store',$id);
        $page_title = 'Pilih Pelajar';

        $title = 'Pilih Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Program Pelajar' => false,
            'Pilih Pelajar' => false,
        ];

        $sesi_id = $request->sesi;
        $kursus_id = $request->kursus;

        $selected_pelajar = ProgramPelajarKehadiran::where('program_id',$id)->pluck('pelajar_id');

        $pelajar = Pelajar::where('is_berhenti', 0)->whereNotIn('id', $selected_pelajar)->with('kursus')->with('sesi');
        if($request->has('kursus'))
        {
            $pelajar->where('kursus_id', $kursus_id);
        }
        if($request->has('sesi'))
        {
            $pelajar->where('sesi_id', $sesi_id);
        }

        $pelajar->get();

        $model = ProgramPelajar::find($id);

        $kursus = Kursus::where('is_deleted', 0)->pluck('nama', 'id');

        if (request()->ajax() && $pelajar) {
            $data = $pelajar;

            return DataTables::of($data)
                ->addColumn('nama', function ($data) {
                    return $data->nama ?? null;
                })
                ->addColumn('kursus', function ($data) {
                    if (! empty($data->kursus_id)) {
                        return $data->kursus->nama ?? 'N/A';
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('sesi', function ($data) {
                    if (! empty($data->sesi_id)) {
                        return $data->sesi->nama ?? 'N/A';
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" name="users_checkbox[]" class="users_checkbox pemohon_checkbox" value='.$data->id.' />';
                })
                ->addIndexColumn()
                ->rawColumns(['nama', 'kursus','sesi', 'checkbox'])
                ->toJson();
        }

        $dataTable = $builder
        ->columns([
            ['data' => 'checkbox',    'name' => 'checkbox',         'title' => '', 'orderable' => false, 'searchable' => false, 'class' => 'max-w-10px'],
            ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
            ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
            ['data' => 'no_ic',     'name' => 'no_ic',          'title' => 'No. Kad Pengenalan', 'orderable' => false],
            ['data' => 'kursus',      'name' => 'kursus',         'title' => 'Program', 'orderable' => false],
            ['data' => 'sesi',      'name' => 'sesi',         'title' => 'Sesi', 'orderable' => false],

            // ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'searchable' => false, 'class'=>'min-w-100px'],

        ])
        ->minifiedAjax();


        return view($this->baseView.'pilih_pelajar', compact('model', 'title', 'breadcrumbs', 'page_title', 'action','kursus','dataTable'));
    }

    public function pilih_pelajar_store(Request $request,$id)
    {

        $model = ProgramPelajar::find($id);


        $sesi[] =  NULL;
        for ($i=1; $i <= $model->jumlah_sesi; $i++) {

            if($i == 1)
            {
                $sesi = ['sesi_'.$i => 0];
            }else{
                $sesi = array_merge($sesi,['sesi_'.$i => 0]);
            }
        }

        foreach ($request->ids as $pelajar_id) {
            ProgramPelajarKehadiran::updateOrCreate([
                'program_id' => $id,
                'pelajar_id' => $pelajar_id,
            ],$sesi
        );
        }
        Alert::success('Pelajar berjaya dipilih');

        return ['success' => true];
    }

    public function pilih_pelajar_destroy($id, $kehadiran_id)
    {
        ProgramPelajarKehadiran::find($kehadiran_id)->delete();

        Alert::toast('Pelajar berjaya dihapuskan!', 'success');

        return redirect()->back();
    }

    public function qr_code_kehadiran($id)
    {
        $page_title = 'QR Code Program Pelajar';

        $title = 'QR Code Program Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Program Pelajar' => false,
            'QR Code Program' => false,
        ];

        $model = ProgramPelajar::find($id);
        return view($this->baseView.'qr_code_kehadiran', compact('model', 'title', 'breadcrumbs', 'page_title'));

    }

    public function muat_turun_qr_sesi($id,$sesi)
    {
        $hashids = new Hashids('', 20);

        $route = route('pengurusan.hep.pengurusan.program_pelajar.submit_kehadiran_program',[$hashids->encodeHex($id),$hashids->encodeHex($sesi)]);
        $program = ProgramPelajar::find($id);
        $generated_at = Utils::formatDateTime(now());

        //generate PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView($this->baseView.'.generated_qr_pdf', compact('route', 'program', 'generated_at','sesi'));

        return $pdf->stream();
    }

    public function submit_kehadiran_program($id, $sesi)
    {

        $hashids = new Hashids('', 20);
        $id_decode = $hashids->decodeHex($id);
        $sesi_decode = $hashids->decodeHex($sesi);

        $user = Auth::user();
        if($user->is_student == 1)
        {
            ProgramPelajarKehadiran::updateOrCreate([
                'program_id' => $id_decode,
                'pelajar_id' => $user->pelajar->last()->id,
            ],[
                'sesi_'.$sesi_decode => 1,
            ]);

            Alert::success('Berjaya', 'Kehadiran program berjaya diambil');
            return redirect()->route('home');

        }else{
            Alert::error('Maaf', 'Kehadiran program hanya untuk pelajar');
            return redirect()->route('home');
        }


    }
}
