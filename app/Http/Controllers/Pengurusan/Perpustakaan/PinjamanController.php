<?php

namespace App\Http\Controllers\Pengurusan\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\PinjamanPerpustakaan;
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
            $title = "Rekod Pinjaman";
            $breadcrumbs = [
                "Perpustakaan" =>  false,
                "Rekod Pinjaman" =>  false,
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
                $data = PinjamanPerpustakaan::where('status',0)->with('bahan','ahli');
                return DataTables::of($data)
                ->addColumn('status', function($data) {
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
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.perpustakaan.pinjaman.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Maklumat lanjut">
                                <i class="fa fa-gear"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'ahli.nama', 'name' => 'ahli.nama', 'title' => 'Nama', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'ahli.ic_no', 'name' => 'ahli.ic_no', 'title' => 'Ic No', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'ahli.no_telefon', 'name' => 'ahli.no_telefon', 'title' => 'No Telefon', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'bahan.nama', 'name' => 'nama', 'title' => 'Nama Bahan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'bahan.isbn', 'name' => 'isbn', 'title' => 'ISBN', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

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
     * @param  \Illuminate\Http\Request  $request
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
            "Perpustakaan" =>  false,
            "Rekod Pinjaman" =>  false,
            "Maklumat Pinjaman" =>  false,
        ];

        $pinjaman = PinjamanPerpustakaan::find($id);

        return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title','pinjaman'));
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
        //
    }
}
