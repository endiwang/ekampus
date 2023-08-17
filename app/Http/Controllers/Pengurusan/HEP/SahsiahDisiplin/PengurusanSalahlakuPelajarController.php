<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\AduanSalahlakuPelajar;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\KesalahanKolejKediaman;
use App\Models\Pelajar;
use App\Models\SiasatanAduanSalahlakuPelajar;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PengurusanSalahlakuPelajarController extends Controller
{
    protected $baseView = 'pages.pengurusan.hep.pengurusan.salahlaku_pelajar.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = 'Salahlaku Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Salahlaku Pelajar' => false,
        ];

        $buttons = [

        ];

        if (request()->ajax()) {
            $data = AduanSalahlakuPelajar::query();

            return DataTables::of($data)
                ->addColumn('nama_pengadu', function ($data) {
                    if (! empty($data->pengadu)) {
                        if ($data->pengadu->is_staff = 1) {
                            return $data->pengadu->staff->nama;
                        } else {
                            return $data->pengadu->pelajar->nama;
                        }

                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('nama_pelaku', function ($data) {
                    if (! empty($data->pelaku_pelajar_id)) {
                        return $data->pelaku->nama;
                    } else {
                        return $data->nama_pelaku;
                    }
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Aduan Baru</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-danger">Dalam Siasatan</span>';
                            break;

                        case 2:
                            return '<span class="badge badge-success">Selesai</span>';
                            break;
                    }
                })
                ->addColumn('action', function ($data) {
                    $button_siasatan = ' <a href="'.route('pengurusan.hep.pengurusan.salahlaku_pelajar.siasatan', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat Siastan">
                    <i class="fa fa-file"></i></a>';
                    $button_maklumat = '<a href="'.route('pengurusan.hep.pengurusan.salahlaku_pelajar.edit', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat Aduan">
                    <i class="fa fa-eye"></i></a>';
                    $button_delete = '
                    <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kelas.destroy', $data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                    if($data->status != 0)
                    {
                        $button = $button_maklumat.$button_siasatan.$button_delete;
                    }else{
                        $button= $button_maklumat.$button_delete;
                    }

                    return $button;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['nama_pengadu', 'action','status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_pengadu', 'name' => 'nama_pengadu', 'title' => 'Nama Pengadu', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'nama_pelaku', 'name' => 'nama_pelaku', 'title' => 'Nama Pelaku', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action = route('pengurusan.hep.pengurusan.salahlaku_pelajar.update', $id);
        $page_title = 'Maklumat Aduan Salahlaku Pelajar';

        $title = 'Maklumat Aduan Salahlaku Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Salahlaku Pelajar' => false,
        ];

        $model = AduanSalahlakuPelajar::find($id);

        $jenis_kesalahan = [
            'U' => 'Kesalahan Umum',
            'KK' => 'Kesalahan Hal-ehwal Kolej Kediaman',
        ];

        $kesalahan_kolej_kediaman = KesalahanKolejKediaman::pluck('nama_kesalahan', 'id');

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic_no_matrik', 'id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'kesalahan_kolej_kediaman', 'jenis_kesalahan', 'pelajar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aduan = AduanSalahlakuPelajar::find($id);
        $aduan->pelaku_pelajar_id = $request->pelaku_pelajar_id;
        $aduan->status = $request->status;
        $aduan->save();

        $siasatan = SiasatanAduanSalahlakuPelajar::where('aduan_salahlaku_pelajar_id', $id)->first();
        if(empty($siasatan) && $request->status == 1)
        {
            SiasatanAduanSalahlakuPelajar::create([
                'aduan_salahlaku_pelajar_id' => $id,
            ]);
        }

        //Email pelaku utk notifikasi

        Alert::toast('Maklumat Aduan Salahlaku Pelajar Berjaya Dikemaskini', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.salahlaku_pelajar.index');

    }


    public function siasatan($id)
    {
        $action = route('pengurusan.hep.pengurusan.salahlaku_pelajar.update_siasatan', $id);
        $page_title = 'Siasatan Aduan Salahlaku Pelajar';

        $title = 'Siasatan Aduan Salahlaku Pelajar';
        $breadcrumbs = [
            'Hal Ehwal Pelajar' => false,
            'Pengurusan' => false,
            'Salahlaku Pelajar' => false,
        ];

        $model = SiasatanAduanSalahlakuPelajar::where('aduan_salahlaku_pelajar_id', $id)->first();

        $jenis_kesalahan = [
            'U' => 'Kesalahan Umum',
            'KK' => 'Kesalahan Hal-ehwal Kolej Kediaman',
        ];

        if($model->keputusan_siasatan == 'S')
        {
            $keputusan_siasatan = $model->kategori_kesalahan;
        }else
        {
            $keputusan_siasatan = $model->keputusan_siasatan;
        }

        // $kesalahan_kolej_kediaman = KesalahanKolejKediaman::pluck('nama_kesalahan', 'id');

        // $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic_no_matrik', 'id');

        return view($this->baseView.'siasatan', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'jenis_kesalahan','keputusan_siasatan'));

    }

    public function update_siasatan(Request $request, $id)
    {
        $aduan = AduanSalahlakuPelajar::find($id);

        $siasatan = SiasatanAduanSalahlakuPelajar::where('aduan_salahlaku_pelajar_id', $id)->first();

        if($request->has('dokumen_siasatan_1'))
        {
            $dokumen_siasatan_1 = uniqid().'.'.$request->dokumen_siasatan_1->getClientOriginalExtension();
            $dokumen_siasatan_1_path = 'uploads/aduan_salahlaku/dokumen_siasatan';
            $file_dokumen_siasatan_1 = $request->file('dokumen_siasatan_1')->storeAs($dokumen_siasatan_1_path, $dokumen_siasatan_1, 'public');
            $siasatan->dokument_siasatan = $file_dokumen_siasatan_1;
        }

        if($request->has('dokumen_siasatan_2'))
        {
            $dokumen_siasatan_2 = uniqid().'.'.$request->dokumen_siasatan_2->getClientOriginalExtension();
            $dokumen_siasatan_2_path = 'uploads/aduan_salahlaku/dokumen_siasatan';
            $file_dokumen_siasatan_2 = $request->file('dokumen_siasatan_2')->storeAs($dokumen_siasatan_2_path, $dokumen_siasatan_2, 'public');
            $siasatan->dokument_siasatan_2 = $file_dokumen_siasatan_2;
        }

        if($request->has('dokumen_siasatan_3'))
        {
            $dokumen_siasatan_3 = uniqid().'.'.$request->dokumen_siasatan_3->getClientOriginalExtension();
            $dokumen_siasatan_3_path = 'uploads/aduan_salahlaku/dokumen_siasatan';
            $file_dokumen_siasatan_3 = $request->file('dokumen_siasatan_3')->storeAs($dokumen_siasatan_3_path, $dokumen_siasatan_3, 'public');
            $siasatan->dokument_siasatan_3 = $file_dokumen_siasatan_3;
        }

        $siasatan->tarikh_mula_siasatan = Carbon::createFromFormat('d/m/Y', $request->tarikh_mula_siasatan)->format('Y-m-d');
        $siasatan->tarikh_akhir_siasatan = Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir_siasatan)->format('Y-m-d');
        $siasatan->masa_akhir_siasatan = $request->masa_akhir_siasatan;
        $siasatan->masa_mula_siasatan = $request->masa_mula_siasatan;
        $siasatan->tempat_siasatan = $request->tempat_siasatan;
        $siasatan->jenis_kesalahan = $request->jenis_kesalahan;
        $siasatan->keterangan_tertuduh = $request->keterangan_tertuduh;
        if($request->keputusan_siasatan != 'TS')
        {
            $siasatan->keputusan_siasatan = 'S';
            $siasatan->kategori_kesalahan = $request->keputusan_siasatan;
        }else{
            $siasatan->keputusan_siasatan = $request->keputusan_siasatan;
            $siasatan->kategori_kesalahan = NULL;


        }
        $aduan->update_by = Auth::user()->id;
        $siasatan->save();

        if($aduan->status != $request->status_aduan)
        {
            $aduan->status = $request->status_aduan;
            $aduan->update_by = Auth::user()->id;
            $aduan->save();
        }


        Alert::toast('Maklumat Siasatan Aduan Salahlaku Pelajar Berjaya Dikemaskini', 'success');

        return redirect()->route('pengurusan.hep.pengurusan.salahlaku_pelajar.index');

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
