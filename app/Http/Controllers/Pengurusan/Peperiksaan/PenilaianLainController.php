<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSijilTahfiz;
use App\Models\PusatPeperiksaan;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianLainController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.penilaian_lain.';
    protected $baseRoute = 'pengurusan.peperiksaan.penilaian_lain.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Peperiksaan/Penilaian Lain';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Peperiksaan/Penilaian Lain' => false,
            ];

            if (request()->ajax()) {
                $data = PermohonanSijilTahfiz::with('pemohon', 'markahPermohonan', 'pusatPeperiksaan')->where('status', 1);
                if ($request->has('nama') && $request->nama != null) {
                    $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                }
                if ($request->has('no_ic') && $request->no_ic != null) {
                    $data->where('ic_no', 'LIKE', '%'.$request->no_ic.'%');
                }
                if ($request->has('pusat_peperiksaan') && $request->pusat_peperiksaan != null) {
                    $data->where('pusat_peperiksaan_id', $request->pusat_peperiksaan);
                }

                return DataTables::of($data)
                    ->addColumn('pusat_peperiksaan_id', function ($data) {
                        return $data->pusatPeperiksaan->name ?? null;
                    })
                    ->addColumn('total_mark', function ($data) {
                        return !empty($data->markahPemohon->total_mark) ? number_format($data->markahPemohon->total_mark, 2) : '0.00';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('name', 'asc');
                    })
                    ->rawColumns(['no_ic', 'total_mark', 'action', 'pusat_peperiksaan_id'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'name', 'name' => 'name', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'ic_no', 'name' => 'ic_no', 'title' => 'No. K/P', 'orderable' => false],
                    ['data' => 'pusat_peperiksaan_id', 'name' => 'pusat_peperiksaan_id', 'title' => 'Pusat Peperiksaan', 'orderable' => false],
                    ['data' => 'total_mark', 'name' => 'total_mark', 'title' => 'Markah Akhir', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $pusat_peperiksaan = PusatPeperiksaan::pluck('name', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'pusat_peperiksaan'));

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
        try {
            $title = 'Maklumat Kehadiran dan Markah Awal Peperiksaan';
            $page_title = 'Maklumat Kehadiran dan Markah Awal Peperiksaan Pelajar';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Maklumat Kehadiran dan Markah Awal Peperiksaan' => route($this->baseRoute.'index'),
                'Maklumat Kehadiran dan Markah Awal Peperiksaan Pelajar' => false,
            ];

            $model = PermohonanSijilTahfiz::with('pemohon', 'markahPermohonan', 'pusatPeperiksaan')->where('status', 1)->find($id);

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'pageTitle', 'model', 'id'));
        
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
}
