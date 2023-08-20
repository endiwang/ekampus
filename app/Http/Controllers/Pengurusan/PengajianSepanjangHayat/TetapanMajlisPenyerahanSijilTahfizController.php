<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TetapanMajlisPenyerahanSijilTahfiz;
use App\Models\Staff;
use App\Models\PusatPengajian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TetapanMajlisPenyerahanSijilTahfizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = "Tetapan Majlis Penyerahan Sijil";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Majlis Penyerahan Sijil" =>  '#',
            "Tetapan Majlis Penyerahan Sijil Tahfiz" =>  '#',
        ];
        $buttons = [
            [
                'title' => "Tambah",
                'route' => route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            $data = TetapanMajlisPenyerahanSijilTahfiz::all();
            return DataTables::of($data)
            ->addColumn('tarikh_masa_masjlis', function($data) {
                
                return Carbon::parse($data->tarikh_majlis_mula)->format('d/m/Y'). ' - ' .Carbon::parse($data->tarikh_majlis_akhir)->format('d/m/Y');

            })
            ->addColumn('status_edit', function($data) {
                switch ($data->status) {
                    case 1:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Buka</span>';
                      break;
                    case 0:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tutup</span>';
                    default:
                      return '';
                  }
            })
            ->addColumn('action', function($data){
                $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                $btn .=' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.edit',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                $btn .=' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                    <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.destroy',$data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                 return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['tempoh_permohonan','status_edit','action'])
            ->toJson();
        }

        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'siri', 'name' => 'siri', 'title' => 'Siri', 'orderable'=> true],
            ['data' => 'tahun', 'name' => 'tahun', 'title' => 'Tahun', 'orderable'=> false],
            ['data' => 'tarikh_masa_masjlis', 'name' => 'tarikh_masa_masjlis', 'title' => 'Tarikh & Masa Majlis', 'orderable'=> false],
            ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.main', compact('title','breadcrumbs', 'html', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Tetapan";
        $breadcrumbs = [
            "Jabatan Pengajian Sepanjang Hayat" =>  '#',
            "Majlis Penyerahan Sijil Tahfiz" =>  '#',
            "Tetapan Majlis Penyerahan Sijil Tahfiz" =>  '#',
            "Tambah Tetapan" =>  '#',
        ];

        $lokasi_pusat_pengajian = PusatPengajian::where('status', 1)->get();
        $staffs = Staff::where('status', 1)->get();

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'lokasi_pusat_pengajian' => $lokasi_pusat_pengajian,
            'staffs' => $staffs,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.add_new', $data);
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
