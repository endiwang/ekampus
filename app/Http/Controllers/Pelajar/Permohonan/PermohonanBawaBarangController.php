<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\PermohonanBawaBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PermohonanBawaBarangController extends Controller
{
    protected $baseView = 'pages.pelajar.permohonan.bawa_barang.';

    public function index(Builder $builder)
    {

        $title = 'Permohonan Bawa Barang';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bawa Barang' => false,
        ];
        $buttons = [
            [
                'title' => 'Permohonan Baru',
                'route' => route('pelajar.permohonan.bawa_barang.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = PermohonanBawaBarang::query();

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->status_hukuman) {
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
                ->addColumn('jenis', function ($data) {
                    switch ($data->jenis_barang) {
                        case 'E':
                            return '<span class="badge badge-success">Elektrik</span>';
                            break;

                        case 'EN':
                            return '<span class="badge badge-success">Elektronik</span>';
                            break;

                        case 'NE':
                            return '<span class="badge badge-success">Bukan Elektrik/Elektronik</span>';
                            break;
                    }
                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    $tarikh = Utils::formatDate($data->created_at);

                    return $tarikh;
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pelajar.permohonan.bawa_barang.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.bawa_barang.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'jenis', 'tarikh_permohonan'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_rujukan', 'name' => 'no_rujukan', 'title' => 'No Rujukan', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false],
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
        $title = 'Permohonan Bawa Barang';
        $action = route('pelajar.permohonan.bawa_barang.store');
        $page_title = 'Permohonan Bawa Barang';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bawa Barang' => false,
            'Permohonan Baru' => false,
        ];

        return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required',
            'jenama' => 'required',
            'kuasa' => 'required',
            'sebab' => 'required',
            'gambar_barang_upload' => 'required',
        ], [
            'jenis_barang.required' => 'Sila pilih jenis barang',
            'jenama.required' => 'Sila masukkan jenama',
            'kuasa.required' => 'Sila masukkan kuasa',
            'sebab.required' => 'Sila masukkan sebab memohon',
            'gambar_barang_upload.required' => 'Sila muatnaik gambar',
        ]);

        if ($request->has('gambar_barang_upload')) {
            $gambar_barang = uniqid().'.'.$request->gambar_barang_upload->getClientOriginalExtension();
            $gambar_barang_path = 'uploads/pelajar/permohonan/bawa_barang';
            $file_gambar_barang = $request->file('gambar_barang_upload')->storeAs($gambar_barang_path, $gambar_barang, 'public');
            $request->request->add(['gambar_barang' => $file_gambar_barang]);
        }

        $request->request->add([
            'no_rujukan' => 'BB-'.date('Ymd').'-'.rand(1000, 9999),
            'pelajar_id' => Auth::user()->pelajar->last()->id,
        ]);

        $bawa_barang = PermohonanBawaBarang::create($request->all());

        Alert::toast('Maklumat permohonan bawa barang dihantar!', 'success');

        return redirect()->route('pelajar.permohonan.bawa_barang.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Permohonan Bawa Barang';
        $page_title = 'Permohonan Bawa Barang';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bawa Barang' => false,
            'Permohonan Baru' => false,
        ];

        $data = PermohonanBawaBarang::find($id);

        return view($this->baseView.'show', compact('title', 'breadcrumbs', 'data', 'page_title'));

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
        $model = PermohonanBawaBarang::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat permohonan berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
