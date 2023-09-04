<?php

namespace App\Http\Controllers\Pengurusan\Akademik\RekodKehadiran;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KehadiranPelajar;
use App\Models\Subjek;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KehadiranPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.rekod_kehadiran.pelajar.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Rekod Kehadiran Pelajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Rekod Kehadiran Pelajar' => false,
            ];

            if (request()->ajax()) {
                $data = Subjek::where('deleted_at', null);
                if ($request->has('nama_subjek') && $request->nama_subjek != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama_subjek.'%');
                }
                if ($request->has('kod_subjek') && $request->kod_subjek != null) {
                    $data->where('kod_subjek', 'LIKE', '%'.$request->kod_subjek.'%');
                }

                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['kursus', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kod_subjek', 'name' => 'nama', 'title' => 'Kod Subjek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'nama', 'name' => 'semasa_semester_id', 'title' => 'Nama Subjek', 'orderable' => false],
                    ['data' => 'kredit', 'name' => 'gred', 'title' => 'Jam Kredit', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

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
    public function show(Builder $builder, $id)
    {
        try {

            $subjek = Subjek::find($id);

            $title = 'Kehadiran Pelajar [Subjek: '.$subjek->nama.']';
            $breadcrumbs = [
                'Akademik' => false,
                'Rekod Kehadiran Pelajar' => route('pengurusan.akademik.rekod_kehadiran.rekod_pelajar.index'),
                $title => false,
            ];

            if (request()->ajax()) {
                $data = KehadiranPelajar::with('pelajar')->where('subjek_id', $id);

                return DataTables::of($data)
                    ->addColumn('pelajar_id', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('no_matrik', function ($data) {
                        return $data->pelajar->no_matrik ?? null;
                    })
                    ->addColumn('tarikh', function ($data) {
                        return Utils::formatDate($data->tarikh) ?? null;
                    })
                    ->addColumn('masa', function ($data) {
                        return Utils::formatTime($data->waktu) ?? null;
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('tarikh', 'desc');
                    })
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'pelajar_id', 'name' => 'pelajar_id', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false],
                    ['data' => 'tarikh', 'name' => 'traikh', 'title' => 'Tarikh', 'orderable' => false],
                    ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'subjek'));

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

    public function downloadAttendancePdf(Request $request)
    {
        try {

            $datas = KehadiranPelajar::with('pelajar')->where('tarikh', Carbon::createFromFormat('d/m/Y', $request->tarikh_kehadiran)->format('Y-m-d'))->get();

            $subjek = $request->nama_subjek;
            $tarikh = Utils::formatDate($request->tarikh);
            $generated_date = Utils::formatDateTime(now());

            //generate PDF
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView($this->baseView.'.attendance_pdf', compact('datas', 'subjek', 'tarikh', 'generated_date'));

            return $pdf->stream();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
