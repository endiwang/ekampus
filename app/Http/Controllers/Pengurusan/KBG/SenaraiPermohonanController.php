<?php

namespace App\Http\Controllers\Pengurusan\KBG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Models\Permohonan;



class SenaraiPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = "Senarai Permohonan";
            $breadcrumbs = [
                "Kemasukan Biasiswa Graduasi" =>  false,
                "Senarai Permohonan" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Maklumat Guru Tasmik",
                    'route' => route('pengurusan.akademik.guru_tasmik.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = Permohonan::all();
                return DataTables::of($data)
                ->addColumn('nama', function($data) {
                    return $data->nama ?? null;
                })
                ->addColumn('jabatan', function($data) {
                    if(!empty($data->jabatan_id))
                    {
                        return $data->jabatan->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('pusat_pengajian', function($data) {
                    if(!empty($data->pusat_pengajian_id))
                    {
                        return $data->pusatPengajian->nama ?? 'N/A';
                    }
                    else {
                        return 'N/A';
                    }
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.guru_tasmik.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.guru_tasmik.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['kursus','status', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'nama',      'name' => 'nama',           'title' => 'Nama Pemohon', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'no_ic',     'name' => 'no_ic',          'title' => 'No. Kad Pengenalan', 'orderable'=> false],
                ['data' => 'gred',      'name' => 'kursus',         'title' => 'Jenis Permohonan', 'orderable'=> false],
                ['data' => 'jabatan',   'name' => 'tarik_daftar',   'title' => 'Tarikh Daftar', 'orderable'=> false],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan','orderable' => false, 'class'=>'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

            return view('pages.pengurusan.kbg.senarai_permohonan.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

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
