<?php

namespace App\Http\Controllers\Pengurusan\HEP\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
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
                'Alumni' => false,
                'Senarai' => false,
            ];

            $data = Pelajar::where('is_alumni', 1);

            if (request()->ajax()) {
                // if (!empty($getJadualId)) {
                //     $data = JadualWaktuDetail::with('subjek')->where('jadual_waktu_id', $getJadualId->id);
                // } else {
                //     $data = [];
                // }


                return DataTables::of($data)
                    ->addColumn('gred_akhir', function ($data) {
                        return empty($data->gred_akhir) ? '-' : $data->gred_akhir;
                    })
                    // ->addColumn('jam_kredit', function ($data) {
                    //     return $data->subjek->kredit ?? null;
                    // })
                    ->addColumn('action', function ($data) {
                        // return '
                        //      <a href="' . route('pelajar.penilaian_pensyarah.show', $data->subjek_id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                        //          <i class="fa fa-eye"></i>
                        //      </a>
                        // ';
                        return '
                             <a class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
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