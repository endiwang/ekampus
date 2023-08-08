<?php

namespace App\Http\Controllers\Pengurusan\Pembangunan;

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
    protected $baseView = 'pages.pengurusan.pembangunan.aduan_penyelenggaraan.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $data = AduanPenyelenggaraan::query();
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
                $html = '<button type="button" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 btn-show-aduan" data-url="' . route('pengurusan.pembangunan.aduan_penyelenggaraan.show', $data->id) . '"><i class="fa fa-eye"></i></button>' . ' ';
                $html .= '<a href="' . route('pengurusan.pembangunan.aduan_penyelenggaraan.edit', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Proses"><i class="fa fa-pencil-alt"></i></a>';
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

        $data['dataTable'] = $dataTable;

        return view($this->baseView.'list')->with($data);        
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
        $data = [
            // 'title' => 'Aduan Penyelenggaraan',
            'action' => route('aduan_penyelenggaraan.store'),
            'page_title' => 'Proses Aduan Penyelenggaraan',
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

                
        $data['status'] = [
            1 => 'Baru diterima', 
            2 => 'Dalam Proses Vendor', 
            3 => 'Dalam Proses Unit Penyelenggaraan', 
            4 => 'Selesai',
        ];

        $aduan_penyelenggaraan = AduanPenyelenggaraan::find($id);
        $data['aduan_penyelenggaraan'] = $aduan_penyelenggaraan;

        return view($this->baseView.'form')->with($data);
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
