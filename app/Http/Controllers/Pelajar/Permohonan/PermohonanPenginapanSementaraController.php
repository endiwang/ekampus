<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\PenginapanSementara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\Kursus;
use App\Models\Semester;

class PermohonanPenginapanSementaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pelajar.permohonan.penginapan_sementara.';

    public function index(Builder $builder)
    {

        $title = 'Permohonan Penginapan Sementara';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Penginapan Sementara' => false,
        ];
        $buttons = [
            [
                'title' => 'Permohonan Baru',
                'route' => route('pelajar.permohonan.penginapan_sementara.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = PenginapanSementara::where('pelajar_id', Auth::user()->pelajar->last()->id);

            return DataTables::of($data)
                ->addColumn('bantuan', function ($data) {
                    switch ($data->bantuan_id) {
                        case 1:
                            return '<span class="badge badge-info">Khairat Kematian</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-info">Bencana</span>';
                            break;

                        case 3:
                            return '<span class="badge badge-info">Perubatan</span>';
                            break;
                        case 0:
                            return '<span class="badge badge-info">Lain-lain</span>';
                            break;
                    }
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Permohonan Baru</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Lulus</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-danger">Tidak Lulus</span>';
                            break;
                    }
                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    $tarikh = Utils::formatDate($data->created_at);

                    return $tarikh;
                })
                ->addColumn('action', function ($data) {
                    if($data->status == 1)
                        return '
                            <a href="'.route('pelajar.permohonan.penginapan_sementara.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pelajar.permohonan.penginapan_sementara.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kemas Kini">
                                <i class="fa fa-pencil"></i>
                            </a>';
                        else{
                            return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.penginapan_sementara.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';

                        }
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'tarikh_permohonan'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_rujukan', 'name' => 'no_rujukan', 'title' => 'No Rujukan', 'orderable' => false],
                ['data' => 'nama_institusi', 'name' => 'nama_institusi', 'title' => 'Nama Institusi', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Permohonan', 'orderable' => false],
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
        $title = 'Permohonan Penginapan Sementara';
        $action = route('pelajar.permohonan.penginapan_sementara.store');
        $page_title = 'Permohonan Penginapan Sementara';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bantuan Kebajikan' => false,
            'Permohonan Baru' => false,
        ];


        $semester = Semester::where('deleted_at', null)->pluck('nama', 'id');
        $kursus = Kursus::where('deleted_at', null)->pluck('nama', 'id');
        return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title','semester','kursus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_institusi' => 'required',
            'tujuan' => 'required',
            'nama_pelajar' => 'required',
            'no_tel' => 'required',
            'program_id' => 'required',
            'semester_id' => 'required',
            'nama_ibu_bapa_penjaga' => 'required',
            'no_tel_ibu_bapa_penjaga' => 'required',
        ], [
            'nama_institusi.required' => 'Sila masukkan nama institusi',
            'tujuan.required' => 'Sila masukkan tujuan',
            'nama_pelajar.required' => 'Sila masukkan nama pelajar',
            'no_tel.required' => 'Sila masukkan no telefon',
            'program_id.required' => 'Sila pilih program',
            'semester_id.required' => 'Sila pilih semseter',
            'nama_ibu_bapa_penjaga.required' => 'Sila masukkan nama ibu / bapa / penjaga',
            'no_tel_ibu_bapa_penjaga.required' => 'Sila masukkan no telefon ibu / bapa / penjaga',
        ]);

        $request->request->add([
            'no_rujukan' => 'PPS-'.date('Ymd').'-'.rand(1000, 9999),
            'pelajar_id' => Auth::user()->pelajar->last()->id,
        ]);

        $data = PenginapanSementara::create($request->all());

        Alert::toast('Maklumat permohonan penginapan sementara berjaya dihantar!', 'success');

        return redirect()->route('pelajar.permohonan.penginapan_sementara.index');
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
        $model = PenginapanSementara::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat permohonan berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
