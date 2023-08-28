<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\KenderaanSitaan;
use App\Helpers\Utils;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;


class KenderaanSitaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $baseView = 'pages.pengurusan.hep.pengurusan.kenderaan_sitaan.';

    public function index(Builder $builder)
    {

        $title = 'Rekod Kenderaan Sitaan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Kenderaan Sitaan' => false,
        ];
        $buttons = [
            [
                'title' => 'Tambah Rekod Kenderaan Sitaan',
                'route' => route('pengurusan.hep.pengurusan.kenderaan_sitaan.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = KenderaanSitaan::query();

            return DataTables::of($data)
                ->addColumn('no_ic', function ($data) {
                    $data = '<p style="text-align:center">'.$data->no_ic_pemilik.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik_pemilik.'] </span></p>';
                    return $data;
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Tidak Dituntut</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-success">Dituntut</span>';
                            break;
                    }
                })
                ->addColumn('jenis', function ($data) {
                    switch ($data->jenis_kenderaan) {
                        case 'K':
                            return '<span class="badge badge-success">Kereta</span>';
                            break;

                        case 'M':
                            return '<span class="badge badge-success">Motorsikal</span>';
                            break;
                    }
                })
                ->addColumn('tarikh_sitaan', function ($data) {
                    $tarikh = Utils::formatDate($data->tarik_sitaan);

                    return $tarikh;
                })
                ->addColumn('action', function ($data) {
                    return '
                         <a href="'.route('pengurusan.hep.pengurusan.kenderaan_sitaan.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                             <i class="fa fa-pencil"></i>
                         </a>
                         <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                         <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.pengurusan.kenderaan_sitaan.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'jenis', 'tarikh_permohonan', 'nama_pelajar', 'no_ic'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pemilik', 'name' => 'nama_pemilik', 'title' => 'Nama Pemilik', 'orderable' => false],
                ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No MyKad/Passport<br>[No Matrik]', 'orderable' => false],
                ['data' => 'no_pelekat', 'name' => 'no_pelekat', 'title' => 'No Pelekat', 'orderable' => false],
                ['data' => 'tarikh_sitaan', 'name' => 'tarikh_sitaan', 'title' => 'Tarikh Sitaan', 'orderable' => false],
                ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
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
        $action = route('pengurusan.hep.pengurusan.kenderaan_sitaan.store');
        $page_title = 'Tambah Rekod Kenderaan Sitaan';

        $title = 'Tambah Rekod Kenderaan Sitaan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Kenderaan Sitaan' => false,
            'Tambah Rekod' => false,
        ];

        $model = new KenderaanSitaan();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kenderaan' => 'required',
            'jenama' => 'required',
            'warna' => 'required',
            'no_pendaftaran' => 'required',
            'tarikh_sita_kenderaan' => 'required',
            'masa_sita' => 'required',
            'tempat_sita' => 'required',
            'sebab_sita' => 'required',
        ], [
            'jenis_kenderaan.required' => 'Sila pilih jenis barang',
            'jenama.required' => 'Sila masukkan jenama',
            'warna.required' => 'Sila masukkan warna',
            'no_pendaftaran.required' => 'Sila masukkan no pedaftaran kenderaan',
            'tarikh_sita_kenderaan.required' => 'Sila pilih tarikh sitaan',
            'masa_sita.required' => 'Sila masakkan masa sitaan',
            'tempat_sita.required' => 'Sila masukkan tempat sitaan',
            'sebab_sita.required' => 'Sila masukkan sebab sitaan',
        ]);

        if ($request->has('lampiran_sita_upload')) {
            $lampiran_sita = uniqid().'.'.$request->lampiran_sita_upload->getClientOriginalExtension();
            $lampiran_sita_path = 'uploads/hal_ehwal_pelajar/lampiran_sita';
            $file_lampiran_sita = $request->file('lampiran_sita_upload')->storeAs($lampiran_sita_path, $lampiran_sita, 'public');
            $request->request->add(['lampiran_sita' => $file_lampiran_sita]);
        }

        $request->request->add([
            'tarikh_sita' => Carbon::createFromFormat('d/m/Y', $request->tarikh_sita_kenderaan)->format('Y-m-d'),
            'create_by' => Auth::user()->id,
            'update_by' => Auth::user()->id,
        ]);

        $data = KenderaanSitaan::create($request->all());

        Alert::toast('Maklumat kenderaan sitaan berjaya disimpan!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.kenderaan_sitaan.index');
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
        $action = route('pengurusan.hep.pengurusan.kenderaan_sitaan.update', $id);
        $page_title = 'Pinda Rekod Kenderaan Sitaan';

        $title = 'Pinda Rekod Kenderaan Sitaan';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Kenderaan Sitaan' => false,
            'Pinda Rekod' => false,
        ];

        $model = KenderaanSitaan::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));
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
            'jenis_kenderaan' => 'required',
            'jenama' => 'required',
            'warna' => 'required',
            'no_pendaftaran' => 'required',
            'tarikh_sita_kenderaan' => 'required',
            'masa_sita' => 'required',
            'tempat_sita' => 'required',
            'sebab_sita' => 'required',
        ], [
            'jenis_kenderaan.required' => 'Sila pilih jenis barang',
            'jenama.required' => 'Sila masukkan jenama',
            'warna.required' => 'Sila masukkan warna',
            'no_pendaftaran.required' => 'Sila masukkan no pedaftaran kenderaan',
            'tarikh_sita_kenderaan.required' => 'Sila pilih tarikh sitaan',
            'masa_sita.required' => 'Sila masakkan masa sitaan',
            'tempat_sita.required' => 'Sila masukkan tempat sitaan',
            'sebab_sita.required' => 'Sila masukkan sebab sitaan',
        ]);

        $data = KenderaanSitaan::find($id);
        $data->nama_pemilik = $request->nama_pemilik;
        $data->no_ic_pemilik = $request->no_ic_pemilik;
        $data->no_matrik_pemilik = $request->no_matrik_pemilik;
        $data->no_pelekat = $request->no_pelekat;
        $data->jenis_kenderaan = $request->jenis_kenderaan;
        $data->jenama = $request->model;
        $data->model = $request->model;
        $data->warna = $request->warna;
        $data->no_pendaftaran = $request->no_pendaftaran;
        $data->tarikh_sita = Carbon::createFromFormat('d/m/Y', $request->tarikh_sita_kenderaan)->format('Y-m-d');
        $data->masa_sita = $request->masa_sita;
        $data->tempat_sita = $request->tempat_sita;
        $data->sebab_sita = $request->sebab_sita;
        $data->status = $request->status;
        $data->update_by = Auth::user()->id;

        if ($request->has('lampiran_sita_upload')) {
            $lampiran_sita = uniqid().'.'.$request->lampiran_sita_upload->getClientOriginalExtension();
            $lampiran_sita_path = 'uploads/hal_ehwal_pelajar/lampiran_sita';
            $file_lampiran_sita = $request->file('lampiran_sita_upload')->storeAs($lampiran_sita_path, $lampiran_sita, 'public');
            $data->lampiran_sita = $file_lampiran_sita;
        }

        $data->save();

        Alert::toast('Maklumat kenderaan sitaan berjaya dipinda!', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.kenderaan_sitaan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tetapan = KenderaanSitaan::find($id);

        $tetapan = $tetapan->delete();

        Alert::toast('Maklumat kenderaan sitaan berjaya dihapus!', 'success');

        return redirect()->back();
    }
}
