<?php

namespace App\Http\Controllers\Pengurusan\Akademik\JadualWaktu;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\JadualPensyarah;
use App\Models\PusatPengajian;
use App\Models\Semester;
use App\Models\Sesi;
use App\Models\Staff;
use App\Services\CalendarService;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class JadualPensyarahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.jadual.jadual_pensyarah.';

    protected $baseRoute = 'pengurusan.akademik.jadual.jadual_pensyarah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Jadual Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Jadual' => false,
                'Jadual Pensyarah' => false,
            ];

            if (request()->ajax()) {
                $data = Staff::with('pusatPengajian', 'jabatan')->where('deleted_at', null);
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                }
                if ($request->has('staff_id') && $request->staff_id != null) {
                    $data->where('staff_id', 'LIKE', '%'.$request->staff_id.'%');
                }
                if ($request->has('pusat_pengajian') && $request->pusat_pengajian != null) {
                    $data->where('pusat_pengajian_id', $request->pusat_pengajian);
                }
                if ($request->has('jabatan') && $request->jabatan != null) {
                    $data->where('jabatan_id', $request->jabatan);
                }

                return DataTables::of($data)
                    ->addColumn('pusat_pengajian_id', function ($data) {
                        return $data->pusatPengajian->nama ?? null;
                    })
                    ->addColumn('jabatan', function ($data) {
                        return $data->jabatan->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute.'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat">
                                <i class="fa fa-eye"></i>
                            </a>
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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pensyarah', 'orderable' => false],
                    ['data' => 'staff_id', 'name' => 'staff_id', 'title' => 'No. Staff', 'orderable' => false],
                    ['data' => 'pusat_pengajian_id', 'name' => 'pusat_pengajian_id', 'title' => 'Pusat Pengajian', 'orderable' => false],
                    ['data' => 'jabatan', 'name' => 'jabatan', 'title' => 'Jabatan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $pusat_pengajian = PusatPengajian::where('deleted_at', null)->pluck('nama', 'id');
            $jabatan = Jabatan::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'pusat_pengajian', 'jabatan'));

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
    public function show($id, Builder $builder, Request $request)
    {
        try {

            $title = 'Maklumat Jadual Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Jadual' => false,
                'Jadual Pensyarah' => route($this->baseRoute.'index'),
                'Maklumat Jadual Pensyarah' => false,
            ];

            if (request()->ajax()) {
                $data = JadualPensyarah::with('sesi', 'semester')->where('staff_id', $id);
                if ($request->has('sesi') && $request->sesi != null) {
                    $data->where('sesi_id', $request->sesi);
                }
                if ($request->has('semester') && $request->semester != null) {
                    $data->where('semester_id', $request->semester);
                }

                return DataTables::of($data)
                    ->addColumn('semester_id', function ($data) {
                        return $data->semester->nama ?? null;
                    })
                    ->addColumn('action', function ($data) use ($id) {
                        return '
                            <a href="'.route('pengurusan.akademik.jadual.jadual_pensyarah.lecturer_timetable', [$data->id, $id]).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Muat Turun Jadual">
                                <i class="fa-solid fa-circle-down"></i>
                            </a>
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
                    ['data' => 'semester_id', 'name' => 'semester_id', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $sesi = Sesi::where('deleted_at', null)->pluck('nama', 'id');
            $semester = Semester::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'sesi', 'semester', 'id'));

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

    public function downloadTimetable(CalendarService $calendarService, $id, $staff_id)
    {
        try {
            $detail = JadualPensyarah::with('semester', 'sesi')->find($id);
            $nama = Staff::select('nama')->find($staff_id);

            $days = Utils::days();
            $calendarData = $calendarService->generateLecturerCalendarData($days, $id);

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.timetable_pdf', compact('detail', 'days', 'calendarData', 'nama'))->setPaper('a4', 'landscape');

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
