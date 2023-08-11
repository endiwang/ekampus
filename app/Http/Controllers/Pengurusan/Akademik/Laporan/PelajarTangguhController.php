<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\Semester;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PelajarTangguhController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.laporan.tangguh_pengajian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {

        $title = 'Senarai Maklumat Pelajar ( GANTUNG @ TANGGUH PENGAJIAN )';
        $breadcrumbs = [
            'Akademik' => false,
            'Laporan' => false,
            'Pelajar Gantung/Tangguh Pengajian' => false,
        ];

        $programmes = Kursus::where('deleted_at', null)->get()->pluck('nama', 'id');
        $sessions = Sesi::where('deleted_at', null)->get()->pluck('nama', 'id');
        $semesters = Semester::where('deleted_at', null)->get()->pluck('nama', 'id');

        if (request()->ajax()) {
            $data = Pelajar::with('kursus', 'sesi')->where('is_deleted', 0)->where('is_register', 1)->where('is_gantung', 1);
            if ($request->has('kursus') && $request->kursus != null) {
                $data = $data->where('kursus_id', $request->kursus);
            }
            if ($request->has('sesi') && $request->sesi != null) {
                $data = $data->where('sesi_id', $request->sesi);
            }
            if ($request->has('semester') && $request->semester != null) {
                $data = $data->where('semester', $request->semester);
            }

            return DataTables::of($data)
                ->addColumn('no_ic', function ($data) {
                    if (! empty($data->no_matrik)) {
                        $data = '<p style="text-align:center">'.$data->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik.'] </span></p>';
                    } else {
                        $data = $data->no_ic;
                    }

                    return $data;
                })
                ->addColumn('sesi_id', function ($data) {
                    return $data->sesi->nama ?? null;
                })
                ->addColumn('kursus_id', function ($data) {
                    return $data->kursus->nama ?? null;
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="'.route('pengurusan.akademik.laporan.tangguh_pengajian.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['action', 'no_ic'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable' => false],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport [No Matrik]', 'orderable' => false],
                ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi Kemasukan', 'orderable' => false],
                ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'programmes', 'sessions', 'semesters'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
        try {

            $title = 'Rekod Pelajar';
            $action = route('pengurusan.akademik.laporan.tangguh_pengajian.update', $id);
            $page_title = 'Pinda Rekod Aktiviti PDP';
            $breadcrumbs = [
                'Akademik' => false,
                'Laporan' => false,
                'Pelajar Gantung/Tangguh Pengajian' => route('pengurusan.akademik.laporan.tangguh_pengajian.index'),
                'Rekod Pelajar' => false,
            ];

            $model = Pelajar::with('kursus', 'sesi', 'syukbah', 'negeri')->find($id);

            $statuses = [
                1 => 'Gantung Pengajian',
                0 => 'Terus Pengajian',
            ];

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'statuses'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
            $laporan = Pelajar::find($id);
            $laporan->is_gantung = $request->status;
            $laporan->save();

            Alert::toast('Maklumat status pelajar berjaya dipinda!', 'success');

            return redirect()->route('pengurusan.akademik.laporan.tangguh_pengajian.index');

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
