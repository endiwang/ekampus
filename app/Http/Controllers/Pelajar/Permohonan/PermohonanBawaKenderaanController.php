<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\PermohonanBawaKenderaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PermohonanBawaKenderaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $baseView = 'pages.pelajar.permohonan.bawa_kenderaan.';


    public function index(Builder $builder)
    {


        $title = 'Permohonan Bawa Kenderaan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bawa Kenderaan' => false,
        ];
        $buttons = [
            [
                'title' => "Permohonan Baru",
                'route' => route('pelajar.permohonan.bawa_kenderaan.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = PermohonanBawaKenderaan::query();

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
                    switch ($data->jenis_kenderaan) {
                        case 'K':
                            return '<span class="badge badge-success">Kereta</span>';
                            break;

                        case 'M':
                            return '<span class="badge badge-success">Motorsikal</span>';
                            break;
                    }
                })
                ->addColumn('tarikh_permohonan', function ($data) {
                    $tarikh = Utils::formatDate($data->created_at);

                    return $tarikh;
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="'.route('pelajar.permohonan.bawa_kenderaan.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.bawa_kenderaan.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action','jenis','tarikh_permohonan'])
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
        {
            $title = 'Permohonan Bawa Kenderaan';
            $action = route('pelajar.permohonan.bawa_kenderaan.store');
            $page_title = 'Permohonan Bawa Kenderaan';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Bawa Barang' => false,
                'Permohonan Kenderaan' => false,
            ];

            return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title'));
        }
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
            'model' => 'required',
            'warna' => 'required',
            'no_pendaftaran' => 'required',
            'tarikh_tamat_cukai_kenderaan' => 'required',
            'tarikh_tamat_lesen_memandu' => 'required',
            'sebab' => 'required',
            'gambar_depan_upload' => 'required',
            'gambar_belakang_upload' => 'required',
            'salinan_kad_matrik_upload' => 'required',
            'salinan_lesen_upload' => 'required',
            'salinan_geran_upload' => 'required',
        ], [
            'jenis_kenderaan.required' => 'Sila pilih jenis kenderaan',
            'jenama.required' => 'Sila masukkan jenama kenderaan',
            'model.required' => 'Sila masukkan model kenderaan',
            'warna.required' => 'Sila masukkan warna kenderaan',
            'no_pendaftaran.required' => 'Sila masukkan no pendaftaran kenderaan',
            'tarikh_tamat_cukai_kenderaan.required' => 'Sila masukkan tarikh tamat cukai jalan',
            'tarikh_tamat_lesen_memandu.required' => 'Sila masukkan tarikh tamat lesen memandu',
            'sebab.required' => 'Sila masukkan sebab memohon',
            'gambar_depan_upload.required' => 'Sila muatnaik gambar depan kenderaan',
            'gambar_belakang_upload.required' => 'Sila muatnaik gambar belakang kenderaan',
            'salinan_kad_matrik_upload.required' => 'Sila muatnaik salinan kad matrik',
            'salinan_lesen_upload.required' => 'Sila muatnaik lesen memandu',
            'salinan_geran_upload.required' => 'Sila muatnaik geran kenderaan',
        ]);

        if($request->has('gambar_depan_upload'))
        {
            $gambar_depan = uniqid().'.'.$request->gambar_depan_upload->getClientOriginalExtension();
            $gambar_depan_path = 'uploads/pelajar/permohonan/bawa_kenderaan';
            $file_gambar_depan = $request->file('gambar_depan_upload')->storeAs($gambar_depan_path, $gambar_depan, 'public');
            $request->request->add(['gambar_hadapan' => $file_gambar_depan]);
        }

        if($request->has('gambar_belakang_upload'))
        {
            $gambar_belakang = uniqid().'.'.$request->gambar_belakang_upload->getClientOriginalExtension();
            $gambar_belakang_path = 'uploads/pelajar/permohonan/bawa_kenderaan';
            $file_gambar_belakang= $request->file('gambar_belakang_upload')->storeAs($gambar_belakang_path, $gambar_belakang, 'public');
            $request->request->add(['gambar_belakang' => $file_gambar_belakang]);
        }

        if($request->has('salinan_kad_matrik_upload'))
        {
            $salinan_kad_matrik = uniqid().'.'.$request->salinan_kad_matrik_upload->getClientOriginalExtension();
            $salinan_kad_matrik_path = 'uploads/pelajar/permohonan/bawa_kenderaan';
            $file_salinan_kad_matrik= $request->file('salinan_kad_matrik_upload')->storeAs($salinan_kad_matrik_path, $salinan_kad_matrik, 'public');
            $request->request->add(['salinan_kad_matrik' => $file_salinan_kad_matrik]);
        }

        if($request->has('salinan_lesen_upload'))
        {
            $salinan_lesen = uniqid().'.'.$request->salinan_lesen_upload->getClientOriginalExtension();
            $salinan_lesen_path = 'uploads/pelajar/permohonan/bawa_kenderaan';
            $file_salinan_lesen = $request->file('salinan_lesen_upload')->storeAs($salinan_lesen_path, $salinan_lesen, 'public');
            $request->request->add(['salinan_lesen' => $file_salinan_lesen]);
        }

        if($request->has('salinan_geran_upload'))
        {
            $salinan_geran = uniqid().'.'.$request->salinan_geran_upload->getClientOriginalExtension();
            $salinan_geran_path = 'uploads/pelajar/permohonan/bawa_kenderaan';
            $file_salinan_geran = $request->file('salinan_lesen_upload')->storeAs($salinan_geran_path, $salinan_geran, 'public');
            $request->request->add(['salinan_geran' => $file_salinan_geran]);
        }

        if($request->has('salinan_surat_kebenaran_pemilik_upload'))
        {
            $salinan_surat_kebenaran_pemilik = uniqid().'.'.$request->salinan_surat_kebenaran_pemilik_upload->getClientOriginalExtension();
            $salinan_surat_kebenaran_pemilik_path = 'uploads/pelajar/permohonan/bawa_kenderaan';
            $file_salinan_surat_kebenaran_pemilik = $request->file('salinan_surat_kebenaran_pemilik_upload')->storeAs($salinan_surat_kebenaran_pemilik_path, $salinan_surat_kebenaran_pemilik, 'public');
            $request->request->add(['salinan_surat_kebenaran_pemilik' => $file_salinan_surat_kebenaran_pemilik]);
        }


        $request->request->add([
            'no_rujukan' => 'BK-'.date('Ymd').'-'.rand(1000, 9999),
            'tarikh_tamat_lesen' => Carbon::createFromFormat('d/m/Y', $request->tarikh_tamat_lesen_memandu)->format('Y-m-d'),
            'tarikh_tamat_cukai' => Carbon::createFromFormat('d/m/Y', $request->tarikh_tamat_cukai_kenderaan)->format('Y-m-d'),
            'pelajar_id' => Auth::user()->pelajar->last()->id,
        ]);

        $bawa_kenderaan = PermohonanBawaKenderaan::create($request->all());

        Alert::toast('Maklumat permohonan bawa kenderaan dihantar!', 'success');

        return redirect()->route('pelajar.permohonan.bawa_kenderaan.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Permohonan Bawa Kenderaan';
        $page_title = 'Permohonan Bawa Kenderaan';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Bawa Kenderaan' => false,
            'Maklumat Permohonan' => false,
        ];

        $data = PermohonanBawaKenderaan::find($id);
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
        $model = PermohonanBawaKenderaan::find($id);

        $model = $model->delete();

        Alert::toast('Maklumat permohonan berjaya dihapuskan!', 'success');

        return redirect()->back();
    }
}
