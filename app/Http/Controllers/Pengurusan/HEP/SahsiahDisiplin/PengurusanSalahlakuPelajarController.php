<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\AduanSalahlakuPelajar;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\KesalahanKolejKediaman;
use App\Models\Pelajar;
use RealRashid\SweetAlert\Facades\Alert;

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
                    return '<a href="'.route('pengurusan.hep.pengurusan.salahlaku_pelajar.edit', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat Lanjut">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.kelas.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
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

        Alert::toast('Maklumat Aduan Salahlaku Pelajar Berjaya Dikemaskini', 'success');

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
