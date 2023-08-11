<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\PenangguhanPengajian;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenangguhanPengajianController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.permohonan.penangguhan_pengajian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Penangguhan Pengajian';
            $breadcrumbs = [
                'Akademik' => false,
                'Permohonan' => false,
                'Penangguhan Pengajian' => false,
            ];

            // $modals = [
            //     [
            //         'title'         => "Tambah Permohonan Penangguhan",
            //         'id'            => "#addPermohonan",
            //         'button_class'  => "btn btn-sm btn-primary fw-bold",
            //         'icon_class'    => "fa fa-plus-circle"
            //     ],
            // ];

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->get();

            if (request()->ajax()) {
                $data = PenangguhanPengajian::with('pelajar', 'semester');

                return DataTables::of($data)
                    ->addColumn('nama_pelajar', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('no_kp', function ($data) {
                        $student = nl2br($data->pelajar->no_ic."\n".' ['.$data->pelajar->no_matrik.']');

                        return $student;
                    })
                    ->addColumn('semester_now', function ($data) {
                        return $data->semester->nama;
                    })
                    ->addColumn('is_gantung', function ($data) {
                        switch ($data->is_gantung) {
                            case 1:
                                return 'Digantung Semester';
                                break;

                            case 2:
                                return 'Tangguh Semester';
                                break;
                        }
                    })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return 'Permohonan Baru';
                                break;

                            case 1:
                                return 'Dalam Proses';
                                break;

                            case 2:
                                return 'Telah Diproses';
                                break;

                            case 3:
                                return 'Lulus';
                                break;

                            case 4:
                                return 'Ditolak';
                                break;
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.permohonan.penangguhan_pengajian.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['no_kp', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pemohon', 'orderable' => false],
                    ['data' => 'no_kp', 'name' => 'no_kp', 'title' => 'No. K/P [No.Matrik]', 'orderable' => false],
                    ['data' => 'semester_now', 'name' => 'semester_now', 'title' => 'Semester Terkini', 'orderable' => false],
                    ['data' => 'is_gantung', 'name' => 'is_gantung', 'title' => 'Status Penangguhan', 'orderable' => false],
                    ['data' => 'tempoh_penangguhan', 'name' => 'tempoh_penangguhan', 'title' => 'Tempoh Penangguhan', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'students'));

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
        try {

            $title = 'Penangguhan Pengajian';
            $page_title = 'Maklumat Permohonan Penangguhan Pengajian';
            $breadcrumbs = [
                'Akademik' => false,
                'Permohonan' => false,
                'Penangguhan Pengajian' => route('pengurusan.akademik.permohonan.penangguhan_pengajian.index'),
                'Maklumat Permohonan Penangguhan Pengajian' => false,
            ];
            $action = route('pengurusan.akademik.permohonan.penangguhan_pengajian.update', $id);

            $data = PenangguhanPengajian::with('pelajar', 'semester', 'pelajar.kursus')->find($id);

            $statuses = [
                1 => 'Baru Diterima',
                2 => 'Proses',
                3 => 'Lulus',
                4 => 'Tolak',
            ];

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'data', 'action', 'statuses'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        try {

            //update status
            PenangguhanPengajian::find($id)->update([
                'status' => $request->status,
                'tarikh_proses' => now(),
            ]);

            //to do to update status pengajian in table pelajar
            //to recconfirm which column to update

            Alert::toast('Keputusan penangguhan pengajian berjaya disimpan!', 'success');

            return redirect()->route('pengurusan.akademik.permohonan.penangguhan_pengajian.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
