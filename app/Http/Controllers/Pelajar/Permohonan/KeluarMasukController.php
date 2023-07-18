<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\PelepasanKuliah;
use App\Models\PermohonanKeluarMasuk;
use Carbon\Carbon;

class KeluarMasukController extends Controller
{
    protected $baseView = 'pages.pelajar.permohonan.keluar_masuk.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = "Permohonan Keluar Masuk";
        $breadcrumbs = [
            "Pelajar" =>  false,
            "Permohonan" =>  false,
            "Keluar Masuk" =>  false,
        ];

        $buttons = [
            [
                'title' => "Permohonan Baru",
                'route' => route('pelajar.permohonan.keluar_masuk.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = PermohonanKeluarMasuk::where('pemohon_user_id', auth()->user()->id);
            return DataTables::of($data)
            ->addColumn('tarikh_keluar', function($data) {
                $tarikh = Utils::formatDate($data->tarikh_keluar);

                return $tarikh;
            })
            ->addColumn('tarikh_masuk', function($data) {
                $tarikh = Utils::formatDate($data->tarikh_masuk);

                return $tarikh;
            })
            ->addColumn('status', function($data) {
                switch($data->status)
                {
                    case 1 :
                        return '<span class="badge badge-primary">Baru Diterima</span>';
                    break;

                    case 2 :
                        return '<span class="badge badge-info">Dalam Proses</span>';
                    break;

                    case 3 :
                        return  '<span class="badge badge-success">Lulus</span>';
                    break;

                    case 4 :
                        return  '<span class="badge badge-danger">Ditolak</span>';
                    break;
                }
            })
            ->addColumn('action', function($data){
                return '
                        <a href="'.route('pelajar.permohonan.keluar_masuk.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-eye"></i>
                        </a>

                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>

                        <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.keluar_masuk.destroy', $data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        ';
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('id', 'desc');
            })
            ->rawColumns(['no_ic','status', 'action'])
            ->toJson();
        }

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'tarikh_keluar', 'name' => 'tarikh_keluar', 'title' => 'Tarikh Keluar', 'orderable'=> false],
            ['data' => 'tarikh_masuk', 'name' => 'tarikh_masuk', 'title' => 'Tarikh Masuk', 'orderable'=> false],
            ['data' => 'jumlah_hari', 'name' => 'jumlah_hari', 'title' => 'Jumlah Hari', 'orderable'=> false],
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
        $title = "Permohonan Keluar Masuk";
        $action = route('pelajar.permohonan.keluar_masuk.store');
        $page_title = 'Permohonan Keluar Masuk';
        $breadcrumbs = [
            "Pelajar" =>  false,
            "Permohonan" =>  false,
            "Pelepasan Kuliah" =>  route('pelajar.permohonan.pelepasan_kuliah.index'),
            "Mohon Pelepasan Kuliah" =>  false,
        ];

        return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title' ));
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
            'tarikh_keluar'           => 'required',
            'tarikh_masuk'          => 'required',
            'jumlah_hari'           => 'required',
            'sebab_mohon'           => 'required',
        ],[
            'tarikh_keluar.required'          => 'Sila pilih tarikh keluar',
            'tarikh_masuk.required'         => 'Sila pilih tarikh masuk',
            'jumlah_hari.required'          => 'Sila masukkan jumlah hari',
            'sebab_mohon.required'          => 'Sila masukkan sebab memohon',
        ]);

            $student = Pelajar::where('user_id', auth()->user()->id)->first();

            $file = '';
            if($request->file)
            {
                $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
                $file_extension = $request->file->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/pelepasan_kuliah';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path . '/' .$file_name;
            }


            $data = new PermohonanKeluarMasuk();
            $data->pemohon_pelajar_id       = $student->id ?? null;
            $data->pemohon_user_id       = auth()->user()->id;
            $data->jumlah_hari      = $request->jumlah_hari;
            $data->tarikh_keluar      = Carbon::createFromFormat('d/m/Y',$request->tarikh_keluar)->format('Y-m-d');
            $data->tarikh_masuk     = Carbon::createFromFormat('d/m/Y',$request->tarikh_masuk)->format('Y-m-d');
            $data->sebab_permohonan = $request->sebab_mohon;
            $data->dokumen_sokongan = $file;
            $data->status           = 1;
            $data->save();

            Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');
            return redirect()->route('pelajar.permohonan.keluar_masuk.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Permohonan Keluar Masuk";
        $page_title = 'Permohonan Keluar Masuk';
        $breadcrumbs = [
            "Pelajar" =>  false,
            "Permohonan" =>  false,
            "Keluar Masuk" =>  route('pelajar.permohonan.keluar_masuk.index'),
            "Maklumat Permohonan Keluar Masuk" =>  false,
        ];

        $data = PermohonanKeluarMasuk::find($id);

        return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'data'));
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
