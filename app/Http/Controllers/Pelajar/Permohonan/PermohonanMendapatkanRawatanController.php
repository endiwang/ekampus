<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\PermohonanMendapatkanRawatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\Penyakit;

class PermohonanMendapatkanRawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseView = 'pages.pelajar.permohonan.mendapatkan_rawatan.';

    public function index(Builder $builder)
    {

        $title = 'Permohonan Mendapatkan Rawatan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Mendapatkan Rawatan' => false,
        ];
        $buttons = [
            [
                'title' => 'Permohonan Baru',
                'route' => route('pelajar.permohonan.mendapatkan_rawatan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = PermohonanMendapatkanRawatan::where('pelajar_id', Auth::user()->pelajar->last()->id);

            return DataTables::of($data)
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
                            <a href="'.route('pelajar.permohonan.mendapatkan_rawatan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="'.route('pelajar.permohonan.mendapatkan_rawatan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Kemas Kini">
                                <i class="fa fa-pencil"></i>
                            </a>';
                        else{
                            return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.mendapatkan_rawatan.destroy', $data->id).'" method="POST">
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
                ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Permohonan', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $title = 'Permohonan Mendapatkan Rawatan';
        $action = route('pelajar.permohonan.mendapatkan_rawatan.store');
        $page_title = 'Permohonan Mendapatkan Rawatan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Mendapatkan Rawatan' => false,
            'Permohonan Baru' => false,
        ];

        $lain_lain = collect([ 0 => 'Lain-lain']);
        $penyakit_db = Penyakit::pluck('nama','id');
        $penyakit = $lain_lain->merge($penyakit_db)->reverse();

        return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title','penyakit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required',
            'dokument_sokongan_upload' => 'required',
        ], [
            'penyakit_id.required' => 'Sila pilih jenis penyakit',
            'dokument_sokongan_upload.required' => 'Sila muat naik dokument sokongan',
        ]);

        if ($request->has('dokument_sokongan_upload')) {
            $dokument_sokongan = uniqid().'.'.$request->dokument_sokongan_upload->getClientOriginalExtension();
            $dokument_sokongan_path = 'uploads/pelajar/permohonan/mendapatkan_rawatan';
            $file_dokument_sokongan = $request->file('dokument_sokongan_upload')->storeAs($dokument_sokongan_path, $dokument_sokongan, 'public');
            $request->request->add(['dokument_sokongan' => $file_dokument_sokongan]);
        }

        $request->request->add([
            'no_rujukan' => 'PMR-'.date('Ymd').'-'.rand(1000, 9999),
            'pelajar_id' => Auth::user()->pelajar->last()->id,
        ]);

        $data = PermohonanMendapatkanRawatan::create($request->all());

        Alert::toast('Maklumat permohonan mendapatkan rawatan berjaya dihantar!', 'success');

        return redirect()->route('pelajar.permohonan.mendapatkan_rawatan.index');
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
        $title = 'Kemas Kini Bukti Hadir';
        $action = route('pelajar.permohonan.mendapatkan_rawatan.update',$id);
        $page_title = 'Kemas Kini Bukti Hadir';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Mendapatkan Rawatan' => false,
            'Bukti Hadir' => false,
        ];

        $data = PermohonanMendapatkanRawatan::find($id);

        return view($this->baseView.'edit', compact('title', 'breadcrumbs', 'data', 'page_title', 'action'));
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
        $request->validate([
            'bukti_hadir_upload' => 'required',
        ], [
            'bukti_hadir_upload.required' => 'Sila muat naik bukti hadir',
        ]);

        $data = PermohonanMendapatkanRawatan::find($id);


        if ($request->has('bukti_hadir_upload')) {
            $bukti_hadir = uniqid().'.'.$request->bukti_hadir_upload->getClientOriginalExtension();
            $bukti_hadir_path = 'uploads/pelajar/permohonan/mendapatkan_rawatan';
            $file_bukti_hadir = $request->file('bukti_hadir_upload')->storeAs($bukti_hadir_path, $bukti_hadir, 'public');
            $data->bukti_hadir = $file_bukti_hadir;
        }

        $data->status_rawatan = 1;
        $data->save();

        Alert::toast('Maklumat bukti kehadiran berjaya dikemas kini!', 'success');

        return redirect()->route('pelajar.permohonan.mendapatkan_rawatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = PermohonanMendapatkanRawatan::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat permohonan berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
