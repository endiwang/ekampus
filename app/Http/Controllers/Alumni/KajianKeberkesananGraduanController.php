<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\JawapanKajianKeberkesananGraduan;
use App\Models\KajianKeberkesananGraduan;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class KajianKeberkesananGraduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = 'Kajian Keberkesanan Graduan';
        $breadcrumbs = [
            'Alumni' => false,
            'Kajian Keberkesanan Graduan' => false,
        ];

        $buttons = [];

        if (request()->ajax()) {
            $data = KajianKeberkesananGraduan::query();

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    // check dijawab or not
                    $dataJawapan = JawapanKajianKeberkesananGraduan::where('user_id', auth()->user()->id)->where('borang_kaji_selidik_id', $data->id)->first();
                    if ($dataJawapan) {
                        return '<span class="badge badge-success">Sudah dijawab</span>';
                    }
                    // otherwise it will show the form status
                    switch ($data->is_active) {
                        case 0:
                            return '<span class="badge badge-danger">Tidak Aktif</span>';

                        case 1:
                            return '<span class="badge badge-warning">Belum dijawab</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    // check dijawab or not
                    $dataJawapan = JawapanKajianKeberkesananGraduan::where('user_id', auth()->user()->id)->where('borang_kaji_selidik_id', $data->id)->first();
                    if ($dataJawapan) {
                        return '
                        <a class="edit btn btn-icon btn-secondary disabled btn-sm hover-elevate-up mb-1n" target="_blank" data-bs-toggle="tooltip" title="Jawab Borang">
                            <i class="fa fa-eye"></i>
                        </a>
                        ';
                    }


                    $hashids = new Hashids('', 20);

                    return '
                            <a href="' . route('public.kajian_graduan.index', $hashids->encodeHex($data->id)) . '" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1n" target="_blank" data-bs-toggle="tooltip" title="Lihat Borang">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'title', 'name' => 'title', 'title' => 'Tajuk Kaji Selidik', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.alumni.kajian_keberkesanan_graduan.main', compact('title', 'breadcrumbs', 'dataTable', 'buttons'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
