<?php

namespace App\Http\Controllers\Pengurusan\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\PinjamanPerpustakaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PinjamanController extends Controller
{
    protected $baseView = 'pages.pengurusan.perpustakaan.pinjaman.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = 'Rekod Pinjaman';
        $breadcrumbs = [
            'Perpustakaan' => false,
            'Rekod Pinjaman' => false,
        ];

        $buttons = [
            // [
            //     'title' => "Tambah Buku/Bahan",
            //     'route' => route('pengurusan.perpustakaan.bahan.create'),
            //     'button_class' => "btn btn-sm btn-primary fw-bold",
            //     'icon_class' => "fa fa-plus-circle"
            // ],
        ];

        if (request()->ajax()) {
            $data = PinjamanPerpustakaan::with('bahan', 'ahli');

            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-info">Dipinjam</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-success">Dipulangkan</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<a href="'.route('pengurusan.perpustakaan.pinjaman.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat lanjut">
                                <i class="fa fa-gear"></i>
                            </a>';
                })
                ->addColumn('denda', function ($data) {
                    switch ($data->status_denda) {
                        case 0:
                            return '<span class="badge badge-success">Tiada</span>';
                            break;
                        case 1:
                            return '<span class="badge badge-danger">Didenda</span>';
                            break;
                        case 2:
                            return '<span class="badge badge-primary">Selesai</span>';
                            break;

                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<a href="'.route('pengurusan.perpustakaan.pinjaman.show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat lanjut">
                                <i class="fa fa-gear"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action', 'denda'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'ahli.nama', 'name' => 'ahli.nama', 'title' => 'Nama', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'ahli.ic_no', 'name' => 'ahli.ic_no', 'title' => 'Ic No', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'ahli.no_telefon', 'name' => 'ahli.no_telefon', 'title' => 'No Telefon', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'bahan.nama', 'name' => 'nama', 'title' => 'Nama Bahan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'bahan.isbn', 'name' => 'isbn', 'title' => 'ISBN', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Pinjaman', 'orderable' => false],
                ['data' => 'denda', 'name' => 'denda', 'title' => 'Status Denda', 'orderable' => false],
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
        $title = 'Maklumat Pinjaman';
        // $action = route('pengurusan.perpustakaan.bahan.store');
        $page_title = 'Maklumat Pinjaman';
        $breadcrumbs = [
            'Perpustakaan' => false,
            'Rekod Pinjaman' => false,
            'Maklumat Pinjaman' => false,
        ];

        $pinjaman = PinjamanPerpustakaan::find($id);

        return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'pinjaman'));
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

    public function pulang(Request $request)
    {
        $pulang = PinjamanPerpustakaan::find($request->id);

        $today = Carbon::now('Asia/Kuala_Lumpur');

        $tarikh_pulang = Carbon::parse($pulang->tarikh_pulang);

        if ($tarikh_pulang->isPast()) {
            $pulang->status = 1;
            $pulang->status_denda = 1;
            $pulang->tarikh_pemulangan = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d');

            $diff_day = $today->diffInDays($tarikh_pulang);
            $pulang->denda = 0.10 * $diff_day;
            Alert::warning('Bahan Dipulangkan Lewat');

        } else {
            $pulang->status = 1;
            $pulang->status_denda = 0;
            $pulang->tarikh_pemulangan = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d');
            Alert::success('Bahan Telah Dipulangkan');
        }

        $pulang->save();

        return ['success' => true];
    }

    public function bayar_denda(Request $request)
    {
        $pulang = PinjamanPerpustakaan::find($request->id);

        $pulang->status_denda = 2;
        $pulang->save();

        return ['success' => true];
    }
}
