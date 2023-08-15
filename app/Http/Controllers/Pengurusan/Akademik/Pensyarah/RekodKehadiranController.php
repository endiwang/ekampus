<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pensyarah;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPensyarah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Carbon;

class RekodKehadiranController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pensyarah.rekod_kehadiran.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Rekod Kehadiran Pensyarah';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Pensyarah' => false,
                'Rekod Kehadiran' => false,
            ];

            $modals = [
                [
                    'title'         => "Muat Turun Kehadiran Pensyarah",
                    'id'            => "#exportPensyarah",
                    'button_class'  => "btn btn-sm btn-primary fw-bold",
                    'icon_class'    => "fa-solid fa-circle-down"
                ],
            ];

            if (request()->ajax()) {
                $data = KehadiranPensyarah::with('staff')->orderBy('created_at', 'DESC');
                if ($request->has('nama_pensyarah') && $request->nama_pensyarah != null) {
                    $data = $data->whereHas('staff', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama_pensyarah.'%');
                    });
                }
                if ($request->has('no_kakitangan') && $request->no_kakitangan != null) {
                    $data = $data->whereHas('staff', function ($data) use ($request) {
                        $data->where('staff_id', 'LIKE', '%'.$request->no_kakitangan.'%');
                    });
                }
                if ($request->has('tarikh') && $request->tarikh != null) {
                    $data->whereDate('tarikh_masuk', Carbon::createFromFormat('d/m/Y', $request->tarikh)->format('Y-m-d'));
                }

                return DataTables::of($data)
                    ->addColumn('nama', function ($data) {
                        return $data->staff->nama ?? null;
                    })
                    ->addColumn('no_kakitangan', function ($data) {
                        return $data->staff->staff_id ?? null;
                    })
                    ->addColumn('tarikh_masuk', function ($data) {
                        return ! empty($data->tarikh_masuk) ? Utils::formatDate($data->tarikh_masuk) : null;
                    })
                    ->addColumn('masa_masuk', function ($data) {
                        return ! empty($data->masa_masuk) ? Utils::formatTime($data->masa_masuk) : null;
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_kakitangan', 'name' => 'no_kakitangan', 'title' => 'No. Kakitangan', 'orderable' => false],
                    ['data' => 'tarikh_masuk', 'name' => 'tarikh_masuk', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'masa_masuk', 'name' => 'masa_masuk', 'title' => 'Masa', 'orderable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'modals'));

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

    public function exportLecturerAttendancePdf(Request $request)
    {
        try {

            $datas = KehadiranPensyarah::with('staff')
                    ->whereBetween('tarikh_masuk', [Carbon::createFromFormat('d/m/Y', $request->tarikh_mula)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir)->format('Y-m-d')])
                    ->get();

            $tarikh_mula = $request->tarikh_mula;
            $tarikh_akhir = $request->tarikh_akhir;
            $generated_date = Utils::formatDateTime(now());

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.attendance_pdf', compact('datas', 'tarikh_mula', 'tarikh_akhir', 'generated_date'));

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
