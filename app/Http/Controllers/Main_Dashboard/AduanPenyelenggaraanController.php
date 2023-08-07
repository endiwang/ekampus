<?php

namespace App\Http\Controllers\Main_Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AduanPenyelenggaraan;
use App\Models\Bilik;
use App\Models\Blok;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class AduanPenyelenggaraanController extends Controller
{
    protected $baseView = 'pages.main_dashboard.aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $data = AduanPenyelenggaraan::where('user_id', Auth::id());
            return DataTables::of($data)
            ->addColumn('no_siri', function($data) {
                return $data->no_siri;
            })
            ->addColumn('pengadu', function($data) {})
            ->addColumn('lokasi', function($data) {
                $html = '';

                $lokasi = [
                    'A' => 'Asrama', 
                    'K' => 'Kuliah', 
                    'P' => 'Pentadbiran', 
                    'L' => 'Lain-lain',
                ];

                if(!empty($lokasi[$data->type]))
                {
                    $html .= $lokasi[$data->type] . ' / ';
                }

                if(!empty($data->blok))
                {
                    $html .= $data->blok->nama . ' / ';
                }

                if(!empty($data->tingkat))
                {
                    $html .= $data->tingkat->nama . ' / ';
                }

                if(!empty($data->bilik))
                {
                    $html .= $data->bilik->nama_bilik;
                }
                
                return $html;
            })
            ->addColumn('kategori', function($data) {

                $html = '';
                $kategori_aduan = [
                    1 => 'Sivil',
                    2 => 'Mekanikal',
                    3 => 'Elektrikal',
                    4 => 'ICT',
                    5 => 'Landskap',
                    6 => 'Pembersihan',
                    7 => 'Perkara/Alatan',
                ];

                if(!empty($kategori_aduan[$data->kategori]))
                {
                    $html .= $kategori_aduan[$data->kategori];
                }

                return $html;
            })
            ->addColumn('action', function($data){ 
                $html = '<button type="button" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 btn-show-aduan" data-url="' . route('aduan_penyelenggaraan.show', $data->id) . '"><i class="fa fa-eye"></i></button>';
                return $html;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                $data->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
        }
        

        $dataTable = $builder
        ->parameters([])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'width' => '7%'],
            ['data' => 'no_siri', 'name' => 'no_siri', 'title' => 'No Siri Aduan', 'orderable'=> false, 'width' => '10%'],
            ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable'=> false, 'width' => '25%'],
            ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable'=> false],
            ['data' => 'jenis_kerosakan', 'name' => 'jenis_kerosakan', 'title' => 'Jenis Kerosakan', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],

        ])
        ->minifiedAjax();

        $data = [
            // 'title' => 'Aduan Penyelenggaraan',
            'action' => route('aduan_penyelenggaraan.store'),
            'page_title' => 'Aduan Penyelenggaraan',
            'breadcrumbs' => [],
            'model' => new AduanPenyelenggaraan(),
            'dataTable' => $dataTable,
        ];

        return view($this->baseView.'list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            // 'title' => 'Aduan Penyelenggaraan',
            'action' => route('aduan_penyelenggaraan.store'),
            'page_title' => 'Tambah Aduan Penyelenggaraan',
            'breadcrumbs' => [],
            'model' => new AduanPenyelenggaraan(),
            'kategori_aduan' => [
                1 => 'Sivil',
                2 => 'Mekanikal',
                3 => 'Elektrikal',
                4 => 'ICT',
                5 => 'Landskap',
                6 => 'Pembersihan',
                7 => 'Perkara/Alatan',
            ],
            'lokasi' => [
                'A' => 'Asrama', 
                'K' => 'Kuliah', 
                'P' => 'Pentadbiran', 
                'L' => 'Lain-lain',
            ],
            'blok' => Blok::pluck('nama', 'id')->toArray(),
            'tingkat' => Tingkat::pluck('nama', 'id')->toArray(),
            'bilik' => Bilik::pluck('nama_bilik', 'id')->toArray(),
        ];

        return view($this->baseView.'form')->with($data);
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
            'kategori' => 'required',
            'type'  => 'required',
            'blok_id'   => 'required',
            'tingkat_id'   => 'required',
            'bilik_id'   => 'required',
            'jenis_kerosakan'   => 'required',
            'butiran'   => 'required',
        ],[
            'kategori.required'       => 'Sila pilih kategori aduan',
            'type.required'       => 'Sila pilih lokasi',
            'blok_id.required'       => 'Sila pilih bangunan',
            'tingkat_id.required'       => 'Sila pilih tingkat',
            'bilik_id.required'       => 'Sila pilih bilik',
            'jenis_kerosakan.required'  => 'Sila tulis jenis kerosakan',
            'butiran.required'            => 'Sila tulis butiran aduan anda',
        ]);

        try
        { 
            DB::transaction(function () use($request) {

                $count_aduan = AduanPenyelenggaraan::count();
                $request['no_siri'] = sprintf("%04d", $count_aduan + 1);
                $request['user_id'] = Auth::id();

                $aduan = AduanPenyelenggaraan::create($request->all());
            });

        }
        catch (\Exception $e)
        {
            $result = false;                
        }

        Alert::toast('Aduan berjaya dihantar!', 'success');
        return redirect()->route('aduan_penyelenggaraan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
        $data['aduan_penyelenggaraan'] = $aduan_penyelenggaraan;
        return view($this->baseView.'show')->with($data);
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

    public function getBlok(Request $request)
    {
        $blok = [];
        if(!empty($request->type))
        {
            $blok = Blok::where('type', $request->type)->pluck('nama', 'id')->toArray();
        }
        $data['blok'] = $blok;
        return $data;
    }

    public function getBilik(Request $request)
    {
        $bilik = [];
        if(!empty($request->blok_id) && !empty($request->tingkat_id))
        {
            $bilik = Bilik::where('blok_id', $request->blok_id)->where('tingkat_id', $request->tingkat_id)->pluck('nama_bilik', 'id')->toArray();
        }
        $data['bilik'] = $bilik;
        return $data;
    }
}
