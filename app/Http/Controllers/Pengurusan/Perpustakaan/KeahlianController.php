<?php

namespace App\Http\Controllers\Pengurusan\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\KeahlianPerpustakaan;
use App\Models\PinjamanPerpustakaan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;


class KeahlianController extends Controller
{
    protected $baseView = 'pages.pengurusan.perpustakaan.keahlian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

            $title = "Keahlian Perpustakaan";
            $breadcrumbs = [
                "Perpustakaan" =>  false,
                "Keahlian" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Ahli Baru",
                    'route' => route('pengurusan.perpustakaan.keahlian.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = KeahlianPerpustakaan::query();
                return DataTables::of($data)
                ->addColumn('status', function($data) {
                    switch ($data->status) {
                        case 0:
                            return '<span class="badge badge-success">Aktif</span>';
                          break;
                        case 1:
                            return '<span class="badge badge-danger">Tidak Aktif</span>';
                        default:
                          return '';
                    }
                })
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.perpustakaan.keahlian.show',$data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Cetak Kehadiran">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="'.route('pengurusan.perpustakaan.keahlian.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.perpustakaan.keahlian.destroy', $data->id).'" method="POST">
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
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Kelas', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'ic_no', 'name' => 'ic_no', 'title' => 'No IC', 'orderable'=> false],
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
        $title = 'Keahlian Perpustakaan';
        $action = route('pengurusan.perpustakaan.keahlian.store');
        $page_title = 'Tambah Keahlian Perpustakaan';
        $breadcrumbs = [
            "Perpustakaan" =>  false,
            "Keahlian" =>  false,
            "Tambah Keahlian Perpustakaan" =>  false,
        ];

        $model = new KeahlianPerpustakaan();

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
            'ic_no'  => 'required',
            'no_telefon'   => 'required',
        ],[
            'nama.required'         => 'Sila masukkan nama',
            'ic_no.required'        => 'Sila masukkan no ic',
            'no_telefon.required'   => 'Sila masukkan no telefon',
        ]);

        $ahli = KeahlianPerpustakaan::create($request->all());

        Alert::toast('Ahli berjaya ditambah!', 'success');
        return redirect()->route('pengurusan.perpustakaan.keahlian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Builder $builder, $id)
    {

            $model = KeahlianPerpustakaan::find($id);

            $title = 'Keahlian Perpustakaan';
            $page_title = 'Keahlian Perpustakaan';
            $breadcrumbs = [
                "Perpustakaan" =>  false,
                "Keahlian" =>  false,
            ];


            if (request()->ajax()) {
                $data = PinjamanPerpustakaan::where('keahlian_id',$model->id);
                return DataTables::of($data)
                ->addColumn('nama_bahan', function($data) {
                    if($data->bahan)
                    {
                        return $data->bahan->nama;
                    }else{
                        return 'N/A';
                    }

                })
                ->addColumn('tarikh_pinjam', function($data) {
                    $tarikh = Utils::formatDate($data->tarikh_pinjaman);
                    return $tarikh;
                })
                ->addColumn('tarikh_pulang', function($data) {
                    $tarikh = Utils::formatDate($data->tarikh_pulang);
                    return $tarikh;
                })
                ->addColumn('status_pinjaman', function($data) {
                    switch($data->status)
                {
                    case 0 :
                        return '<span class="badge badge-primary">Dipinjam</span>';
                    break;

                    case 1 :
                        return '<span class="badge badge-info">Dipulang</span>';
                    break;
                }
                })
                ->addColumn('denda', function($data) {
                    return 'ok';
                })
                ->addColumn('status_denda', function($data) {
                    return 'ok';
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.kelas.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
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
                ->rawColumns(['status_pinjaman','action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama_bahan', 'name' => 'nama_bahan', 'title' => 'Nama Buku/Bahan', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'tarikh_pinjam', 'name' => 'tarikh_pinjam', 'title' => 'Tarikh Pinjaman', 'orderable'=> false],
                ['data' => 'tarikh_pulang', 'name' => 'tarikh_pulang', 'title' => 'Tarikh Pulang', 'orderable'=> false],
                ['data' => 'status_pinjaman', 'name' => 'status_pinjaman', 'title' => 'Status Pinjaman', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
            ])
            ->minifiedAjax();

            return view($this->baseView.'show', compact('model', 'title', 'breadcrumbs', 'page_title', 'dataTable'));
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
