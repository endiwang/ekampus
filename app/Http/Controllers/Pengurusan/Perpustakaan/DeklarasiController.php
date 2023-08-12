<?php

namespace App\Http\Controllers\Pengurusan\Perpustakaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\KeahlianPerpustakaan;
use App\Models\KonvoPelajar;
use App\Models\Pelajar;
use App\Models\PinjamanPerpustakaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class DeklarasiController extends Controller
{
    protected $baseView = 'pages.pengurusan.perpustakaan.deklarasi.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Deklarasi Pelajar';
        $breadcrumbs = [
            'Perpustakaan' => false,
            'Deklarasi Pelajar' => false,
        ];

        $action = route('pengurusan.perpustakaan.deklarasi.semakan');

        $buttons = [
        ];

        $pelajar = Pelajar::where('is_berhenti', 0)->get()->pluck('name_ic', 'id');

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'pelajar', 'action'));
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

    public function semakan(Builder $builder, Request $request)
    {
        $pelajar = Pelajar::find($request->pelajar_id);
        $model = KeahlianPerpustakaan::where('user_id', $pelajar->user_id)->first();
        $title = 'Deklarasi Pelajar';
        $page_title = 'Keahlian Perpustakaan';
        $breadcrumbs = [
            'Perpustakaan' => false,
            'Deklarasi Pelajar' => false,
        ];

        $pinjaman_denda = PinjamanPerpustakaan::where('keahlian_id', $model->id)
            ->where(function ($query) {
                $query->where('status_denda', 1)
                    ->orWhere('status', 0);
            })
            ->first();

        if (request()->ajax()) {
            $data = PinjamanPerpustakaan::where('keahlian_id', $model->id)->where(function ($query) {
                $query->where('status_denda', 1)
                    ->orWhere('status', 0);
            });

            return DataTables::of($data)
                ->addColumn('nama_bahan', function ($data) {
                    if ($data->bahan) {
                        return $data->bahan->nama;
                    } else {
                        return 'N/A';
                    }

                })
                ->addColumn('tarikh_pinjam', function ($data) {
                    $tarikh = Utils::formatDate($data->tarikh_pinjaman);

                    return $tarikh;
                })
                ->addColumn('tarikh_pulang', function ($data) {
                    $tarikh = Utils::formatDate($data->tarikh_pulang);

                    return $tarikh;
                })
                ->addColumn('status_pinjaman', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Belum Pulang</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-info">Dipulang</span>';
                            break;
                    }
                })
                ->addColumn('status_denda', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-primary">Tiada</span>';
                            break;

                        case 1:
                            return '<span class="badge badge-danger">Didenda</span>';
                            break;
                        case 2:
                            return '<span class="badge badge-info">Selesai</span>';
                            break;
                    }
                })
                ->addColumn('denda', function ($data) {

                    if ($data->denda != null) {
                        return 'RM '.number_format((float) $data->denda, 2, '.', '');

                    } else {
                        return 'N\A';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="'.route('pengurusan.perpustakaan.pinjaman.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tindakan">
                                <i class="fa fa-gear"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status_pinjaman', 'action', 'status_denda'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama_bahan', 'name' => 'nama_bahan', 'title' => 'Nama Buku/Bahan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_pinjam', 'name' => 'tarikh_pinjam', 'title' => 'Tarikh Pinjaman', 'orderable' => false],
                ['data' => 'tarikh_pulang', 'name' => 'tarikh_pulang', 'title' => 'Tarikh Pulang', 'orderable' => false],
                ['data' => 'status_pinjaman', 'name' => 'status_pinjaman', 'title' => 'Status Pinjaman', 'orderable' => false],
                ['data' => 'status_denda', 'name' => 'status_denda', 'title' => 'Status Denda', 'orderable' => false],
                ['data' => 'denda', 'name' => 'denda', 'title' => 'Denda', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
            ])
            ->minifiedAjax();

        return view($this->baseView.'semak', compact('model', 'title', 'breadcrumbs', 'page_title', 'dataTable', 'pelajar', 'pinjaman_denda'));
    }

    public function sahkan_pelajar(Request $request)
    {

        $pelajar = KonvoPelajar::where('pelajar_id', $request->pelajar_id)->first();
        if ($pelajar != null) {
            $pelajar->deklarasi_perpustakaan = 1;
            $pelajar->save();

            return ['success' => true];
        } else {
            return ['error' => true];

        }

    }
}
