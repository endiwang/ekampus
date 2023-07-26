<?php

namespace App\Http\Controllers\Pengurusan\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\BahanPerpustakaan;
use App\Models\KeahlianPerpustakaan;
use App\Models\PinjamanPerpustakaan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class BahanController extends Controller
{    protected $baseView = 'pages.pengurusan.perpustakaan.bahan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
            $title = "Buku & Bahan Lain";
            $breadcrumbs = [
                "Perpustakaan" =>  false,
                "Buku dan Bahan Lain" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Buku/Bahan",
                    'route' => route('pengurusan.perpustakaan.bahan.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = BahanPerpustakaan::query();
                return DataTables::of($data)
                ->addColumn('status', function($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-success">Ada</span>';
                          break;
                        case 1:
                            return '<span class="badge badge-danger">Dipinjam</span>';
                        default:
                          return '';
                    }
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.perpustakaan.bahan.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinjam Buku">
                                <i class="fa fa-book"></i>
                            </a>
                            <a href="'.route('pengurusan.perpustakaan.bahan.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.perpustakaan.bahan.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
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
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Bahan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'isbn', 'name' => 'isbn', 'title' => 'ISBN', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable'=> false, 'class'=>'text-bold'],
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
        $title = 'Tambah Buku / Bahan Perpustakaan';
        $action = route('pengurusan.perpustakaan.bahan.store');
        $page_title = 'Tambah Buku / Bahan Perpustakaan';
        $breadcrumbs = [
            "Perpustakaan" =>  false,
            "Buku dan Bahan" =>  false,
            "Tambah Buku / Bahan Baru" =>  false,
        ];

        $model = new BahanPerpustakaan();

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama'        => 'required',
            'isbn'  => 'required',
            'lokasi'   => 'required',
        ],[
            'nama.required'         => 'Sila masukkan nama',
            'ic_no.required'        => 'Sila masukkan ISBN',
            'no_telefon.required'   => 'Sila masukkan lokasi',
        ]);

        $bahan = BahanPerpustakaan::create($request->all());

        Alert::toast('Buku / Bahan berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.perpustakaan.bahan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Pinjam Buku / Bahan Perpustakaan';
        $action = route('pengurusan.perpustakaan.bahan.store');
        $page_title = 'Tambah Buku / Bahan Perpustakaan';
        $breadcrumbs = [
            "Perpustakaan" =>  false,
            "Buku dan Bahan" =>  false,
            "Tambah Buku / Bahan Baru" =>  false,
        ];

        $peminjam = KeahlianPerpustakaan::pluck('ic_no','id');

        $model = BahanPerpustakaan::find($id);

        return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'page_title',  'action','peminjam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Pinda Buku / Bahan Perpustakaan';
        $action = route('pengurusan.perpustakaan.bahan.update',$id);
        $page_title = 'Pinda Buku / Bahan Perpustakaan';
        $breadcrumbs = [
            "Perpustakaan" =>  false,
            "Buku dan Bahan" =>  false,
            "Pinda Buku / Bahan Baru" =>  false,
        ];

        $model = BahanPerpustakaan::find($id);

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action'));
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
        $validation = $request->validate([
            'nama'        => 'required',
            'isbn'  => 'required',
            'lokasi'   => 'required',
        ],[
            'nama.required'         => 'Sila masukkan nama',
            'ic_no.required'        => 'Sila masukkan ISBN',
            'no_telefon.required'   => 'Sila masukkan lokasi',
        ]);

        $bahan = BahanPerpustakaan::find($id);
        $bahan->nama = $request->nama;
        $bahan->isbn = $request->isbn;
        $bahan->lokasi = $request->lokasi;
        $bahan->save();

        Alert::toast('Buku / Bahan berjaya dipinda!', 'success');
        return redirect()->route('pengurusan.perpustakaan.bahan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pinjam = PinjamanPerpustakaan::where('bahan_id',$id)->where('status',0)->first();
        if($pinjam)
        {
            Alert::toast('Buku / bahan sedang dipinjam', 'error');
            return redirect()->back();
        }else{

            $bahan = BahanPerpustakaan::find($id);
            $bahan = $bahan->delete();

            Alert::toast('Buku / bahan berjaya dihapus!', 'success');
            return redirect()->back();
        }

    }

    public function pinjam(Request $request)
    {
        dd($request);
    }
}
