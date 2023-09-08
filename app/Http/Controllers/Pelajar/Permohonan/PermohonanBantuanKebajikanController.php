<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\BantuanKebajikan;
use App\Models\Penyakit;

class PermohonanBantuanKebajikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pelajar.permohonan.bantuan_kebajikan.';

    public function index(Builder $builder)
    {

        $title = 'Permohonan Bantuan Kebajikan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bantuan Kebajikan' => false,
        ];
        $buttons = [
            [
                'title' => 'Permohonan Baru',
                'route' => route('pelajar.permohonan.bantuan_kebajikan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = BantuanKebajikan::where('pelajar_id', Auth::user()->pelajar->last()->id);

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
                            <a href="'.route('pelajar.permohonan.bantuan_kebajikan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pelajar.permohonan.bantuan_kebajikan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kemas Kini">
                                <i class="fa fa-pencil"></i>
                            </a>';
                        else{
                            return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.bantuan_kebajikan.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';

                        }
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'tarikh_permohonan','bantuan'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_rujukan', 'name' => 'no_rujukan', 'title' => 'No Rujukan', 'orderable' => false],
                ['data' => 'bantuan', 'name' => 'bantuan', 'title' => 'Bantuan', 'orderable' => false],
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
        $title = 'Permohonan Bantuan Kebajikan';
        $action = route('pelajar.permohonan.bantuan_kebajikan.store');
        $page_title = 'Permohonan Bantuan Kebajikan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bantuan Kebajikan' => false,
            'Permohonan Baru' => false,
        ];


        $bantuan = [1=>'Khairat Kematian',2=>'Bencana',3=>'Perubatan',0=>'Lain-lain'];
        return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title','bantuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bantuan_id' => 'required',
            'kad_pengenalan_upload' => 'required',
            'akuan_bank_upload' => 'required',
        ], [
            'bantuan_id.required' => 'Sila pilih jenis penyakit',
            'kad_pengenalan_upload.required' => 'Sila muat naik salinan kad pengenalan yang disahkan',
            'akuan_bank_upload.required' => 'Sila muat naik salinan bank akuan yang disahkan',
        ]);

        if ($request->has('kad_pengenalan_upload')) {
            $kad_pengenalan = uniqid().'.'.$request->kad_pengenalan_upload->getClientOriginalExtension();
            $kad_pengenalan_path = 'uploads/pelajar/permohonan/bantuan_kebajikan';
            $file_kad_pengenalan = $request->file('kad_pengenalan_upload')->storeAs($kad_pengenalan_path, $kad_pengenalan, 'public');
            $request->request->add(['kad_pengenalan' => $file_kad_pengenalan]);
        }

        if ($request->has('sijil_kematian_upload')) {
            $sijil_kematian = uniqid().'.'.$request->sijil_kematian_upload->getClientOriginalExtension();
            $sijil_kematian_path = 'uploads/pelajar/permohonan/bantuan_kebajikan';
            $file_sijil_kematian = $request->file('sijil_kematian_upload')->storeAs($sijil_kematian_path, $sijil_kematian, 'public');
            $request->request->add(['sijil_kematian' => $file_sijil_kematian]);
        }

        if ($request->has('akuan_bank_upload')) {
            $akuan_bank = uniqid().'.'.$request->akuan_bank_upload->getClientOriginalExtension();
            $akuan_bank_path = 'uploads/pelajar/permohonan/bantuan_kebajikan';
            $file_akuan_bank = $request->file('akuan_bank_upload')->storeAs($akuan_bank_path, $akuan_bank, 'public');
            $request->request->add(['akaun_bank' => $file_akuan_bank]);
        }

        if ($request->has('bukti_bayaran_upload')) {
            $bukti_bayaran = uniqid().'.'.$request->bukti_bayaran_upload->getClientOriginalExtension();
            $bukti_bayaran_path = 'uploads/pelajar/permohonan/bantuan_kebajikan';
            $file_bukti_bayaran = $request->file('bukti_bayaran_upload')->storeAs($bukti_bayaran_path, $bukti_bayaran, 'public');
            $request->request->add(['bukti_bayaran' => $file_bukti_bayaran]);
        }

        $request->request->add([
            'no_rujukan' => 'PBK-'.date('Ymd').'-'.rand(1000, 9999),
            'pelajar_id' => Auth::user()->pelajar->last()->id,
        ]);

        $data = BantuanKebajikan::create($request->all());

        Alert::toast('Maklumat permohonan bantuan kebajikan berjaya dihantar!', 'success');

        return redirect()->route('pelajar.permohonan.bantuan_kebajikan.index');
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
        $model = BantuanKebajikan::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat permohonan berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
