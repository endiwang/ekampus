<?php

namespace App\Http\Controllers\Pengurusan\HEP\SahsiahDisiplin;

use App\Http\Controllers\Controller;
use App\Models\TetapanKeluarMasuk;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Helpers\Utils;
use App\Models\Hari;

class TetapanKeluarMasukController extends Controller
{

    protected $baseView = 'pages.pengurusan.hep.tetapan.keluar_masuk.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = "Tetapan Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Tetapan" =>  false,
            "Keluar Masuk" =>  false,
        ];

        $buttons = [
            [
                'title' => "Tambah Tetapan",
                'route' => route('pengurusan.hep.tetapan.keluar_masuk.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = TetapanKeluarMasuk::query();
            return DataTables::of($data)
            ->addColumn('jantina', function($data) {
                switch($data->jantina)
                    {
                        case 'BN':
                            $jantina = 'Lelaki';
                          break;
                        case 'BT':
                            $jantina = 'Perempuan';
                    }

                    return $jantina;

            })
            ->addColumn('hari', function($data) {
                if(!empty($data->hari))
                {
                    return $data->hari->nama ?? 'N/A';
                }
                else {
                    return 'N/A';
                }
            })

            ->addColumn('masa_masuk', function($data) {
                return !empty($data->masa_masuk) ? Utils::formatTime($data->masa_masuk) : null;
            })

            ->addColumn('masa_keluar', function($data) {
                return !empty($data->masa_masuk) ? Utils::formatTime($data->masa_masuk) : null;
            })

            ->addColumn('semasa_syukbah_id', function($data) {
                if(!empty($data->semasa_syukbah_id))
                {
                    return $data->currentSyukbah->nama ?? 'N/A';
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('jumlah_pelajar', function($data) {
                return $data->count_pelajar ?? 0;
            })
            ->addColumn('status_guru_tasmik', function($data) {
                return 'Tiada';
            })
            ->addColumn('status', function($data) {
                switch ($data->status) {
                    case 0:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                      break;
                    case 1:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                    default:
                      return '';
                }
            })
            ->addColumn('action', function($data){
                return '
                        <a href="'.route('pengurusan.hep.tetapan.keluar_masuk.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pengurusan.hep.tetapan.keluar_masuk.destroy', $data->id).'" method="POST">
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
            ['data' => 'nama_tetapan', 'name' => 'nama_tetapan', 'title' => 'Nama Tetapan', 'orderable'=> false, 'class'=>'text-bold'],
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
        $action = route('pengurusan.hep.tetapan.keluar_masuk.store');
        $page_title = 'Tambah Tetapan Keluar Masuk';

        $title = "Tetapan Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Tetapan" =>  false,
            "Keluar Masuk" =>  false,
        ];

        $model = new TetapanKeluarMasuk();

        $genders = [
            'BN' => 'Banin (Lelaki)',
            'BT' => 'Banat (Perempuan)'
        ];

        $hari = Hari::pluck('nama','id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'genders','hari'));
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
            'nama_tetapan'      => 'required',
            'waktu_masuk'       => 'required',
            'waktu_keluar'      => 'required',
            'jantina'           => 'required',
            'hari_id'           => 'required',
        ],[
            'nama_tetapan.required'          => 'Sila masukkan nama tetapan',
            'waktu_masuk.required'         => 'Sila masukkan waktu masuk',
            'waktu_keluar.required'          => 'Sila masukkan waktu keluar',
            'jantina.required'          => 'Sila pilih jantina pelajar',
            'hari_id.required'          => 'Sila pilih hari',
        ]);

            $data = TetapanKeluarMasuk::create($request->all());

            Alert::toast('Maklumat tetapan keluar masuk berjaya disimpan!', 'success');
            return redirect()->route('pengurusan.hep.tetapan.keluar_masuk.index');
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
        $action = route('pengurusan.hep.tetapan.keluar_masuk.update',$id);
        $page_title = 'Pinda Tetapan Keluar Masuk';

        $title = "Tetapan Keluar Masuk";
        $breadcrumbs = [
            "Hal Ehwal Pelajar" =>  false,
            "Tetapan" =>  false,
            "Keluar Masuk" =>  false,
        ];

        $model = TetapanKeluarMasuk::find($id);

        $genders = [
            'BN' => 'Banin (Lelaki)',
            'BT' => 'Banat (Perempuan)'
        ];

        $hari = Hari::pluck('nama','id');

        return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'genders','hari'));
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
        $request->validate([
            'nama_tetapan'      => 'required',
            'waktu_masuk'       => 'required',
            'waktu_keluar'      => 'required',
            'jantina'           => 'required',
            'hari_id'           => 'required',
        ],[
            'nama_tetapan.required'          => 'Sila masukkan nama tetapan',
            'waktu_masuk.required'         => 'Sila masukkan waktu masuk',
            'waktu_keluar.required'          => 'Sila masukkan waktu keluar',
            'jantina.required'          => 'Sila pilih jantina pelajar',
            'hari_id.required'          => 'Sila pilih hari',
        ]);

            $data = TetapanKeluarMasuk::find($id);
            $data->nama_tetapan = $request->nama_tetapan;
            $data->waktu_masuk = $request->waktu_masuk;
            $data->waktu_keluar = $request->waktu_keluar;
            $data->jantina = $request->jantina;
            $data->hari_id = $request->hari_id;
            $data->save();

            Alert::toast('Maklumat tetapan keluar masuk berjaya disimpan!', 'success');
            return redirect()->route('pengurusan.hep.tetapan.keluar_masuk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tetapan = TetapanKeluarMasuk::find($id);

            $tetapan = $tetapan->delete();

            Alert::toast('Maklumat kelas berjaya dihapus!', 'success');
            return redirect()->back();

    }
}
