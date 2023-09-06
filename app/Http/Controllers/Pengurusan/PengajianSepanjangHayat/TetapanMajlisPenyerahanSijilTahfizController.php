<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PusatPengajian;
use App\Models\Staff;
use App\Models\TetapanMajlisPenyerahanSijilTahfiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $title = 'Tetapan Majlis Penyerahan Sijil';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Majlis Penyerahan Sijil' => '#',
            'Tetapan Majlis Penyerahan Sijil Tahfiz' => '#',
        ];
        $buttons = [
            [
                'title' => 'Tambah',
                'route' => route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = TetapanMajlisPenyerahanSijilTahfiz::all();

            return DataTables::of($data)
                ->addColumn('tarikh_masa_masjlis', function ($data) {

                    return Carbon::parse($data->tarikh_majlis_mula)->format('d/m/Y').' - '.Carbon::parse($data->tarikh_majlis_akhir)->format('d/m/Y').'<br> ('.Carbon::parse($data->masa_majlis)->format('g:i A').')';

                })
                ->addColumn('status_edit', function ($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {

                    $btn = ' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.edit', $data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                    $btn .= ' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                    <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.destroy', $data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['tarikh_masa_masjlis', 'status_edit', 'action'])
                ->toJson();
        }

        $html = $builder
            ->parameters([
                // 'language' => '{ "lengthMenu": "Show _MENU_", }',
                // 'dom' => $dom_setting,
            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => true],
                ['data' => 'siri', 'name' => 'siri', 'title' => 'Siri', 'orderable' => true],
                ['data' => 'tahun', 'name' => 'tahun', 'title' => 'Tahun', 'orderable' => false],
                ['data' => 'tarikh_masa_masjlis', 'name' => 'tarikh_masa_masjlis', 'title' => 'Tarikh & Masa Majlis', 'orderable' => false],
                ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.main', compact('title', 'breadcrumbs', 'html', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Tetapan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Majlis Penyerahan Sijil Tahfiz' => '#',
            'Tetapan Majlis Penyerahan Sijil Tahfiz' => '#',
            'Tambah Tetapan' => '#',
        ];

        $lokasi_pusat_pengajian = PusatPengajian::where('status', 1)->get();
        $staffs = Staff::where('is_deleted', 0)->where('jabatan_id', 32)->get()->pluck('nama', 'id');

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (! $request->has('staff_id')) {
            $request['staff_id'] = null;
        }

        $validated = $request->validate([
            'nama' => 'required',
            'siri' => 'required',
            'tahun' => 'required',
            'no_fail_surat' => 'required',
            'lokasi_majlis' => 'required',
            'tarikh_surat_mula' => 'required',
            'tarikh_surat_akhir' => 'required',
            'tarikh_majlis_mula' => 'required',
            'tarikh_majlis_akhir' => 'required',
            'masa_majlis' => 'required',
            'staff_id' => 'required',
            'tarikh_cetakan' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama majlis.',
            'siri.required' => 'Sila masukkan siri majlis.',
            'tahun.required' => 'Sila masukkan tahun majlis.',
            'no_fail_surat.required' => 'Sila masukkan no fail surat.',
            'lokasi_majlis.required' => 'Sila masukkan lokasi majlis.',
            'tarikh_surat_mula.required' => 'Sila pilih tarikh mula surat.',
            'tarikh_surat_akhir.required' => 'Sila pilih tarikh tutup surat.',
            'tarikh_majlis_mula.required' => 'Sila pilih tarikh mula majlis.',
            'tarikh_majlis_akhir.required' => 'Sila pilih tarikh tutup majlis.',
            'masa_majlis.required' => 'Sila pilih masa majlis.',
            'staff_id.required' => 'Sila pilih pegawai untuk dihubungi.',
            'tarikh_cetakan' => 'Sila pilih tarikh cetakan.',
        ]);

        if ($request->has('status')) {
            $status = $request->status;
        } else {
            $status = 0;
        }

        DB::beginTransaction();

        try {
            TetapanMajlisPenyerahanSijilTahfiz::create([
                'nama' => $request->nama,
                'siri' => $request->siri,
                'tahun' => $request->tahun,
                'no_fail_surat' => $request->no_fail_surat,
                'status' => $status,
                'lokasi_majlis' => $request->lokasi_majlis,
                'tarikh_surat_mula' => Carbon::createFromFormat('d/m/Y', $request->tarikh_surat_mula)->format('Y-m-d'),
                'tarikh_surat_akhir' => Carbon::createFromFormat('d/m/Y', $request->tarikh_surat_akhir)->format('Y-m-d'),
                'tarikh_majlis_mula' => Carbon::createFromFormat('d/m/Y', $request->tarikh_majlis_mula)->format('Y-m-d'),
                'tarikh_majlis_akhir' => Carbon::createFromFormat('d/m/Y', $request->tarikh_majlis_akhir)->format('Y-m-d'),
                'tarikh_cetakan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_cetakan)->format('Y-m-d'),
                'masa_majlis' => $request->masa_majlis,
                'staff_id' => $request->staff_id,
                'created_by' => Auth::id(),
            ]);

            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.index');
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
        $title = 'Pinda Tetapan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Majlis Penyerahan Sijil Tahfiz' => '#',
            'Tetapan Majlis Penyerahan Sijil Tahfiz' => '#',
            'Pinda Tetapan' => '#',
        ];

        $tetapan_majlis = TetapanMajlisPenyerahanSijilTahfiz::find($id);
        $lokasi_pusat_pengajian = PusatPengajian::where('status', 1)->get();
        $staffs = Staff::where('is_deleted', 0)->where('jabatan_id', 32)->get()->pluck('nama', 'id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'tetapan_majlis' => $tetapan_majlis,
            'lokasi_pusat_pengajian' => $lokasi_pusat_pengajian,
            'staffs' => $staffs,
            'id' => $id,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! $request->has('pusat_pengajian_id')) {
            $request['pusat_pengajian_id'] = null;
        }
        if (! $request->has('staff_id')) {
            $request['staff_id'] = null;
        }

        $validated = $request->validate([
            'nama' => 'required',
            'siri' => 'required',
            'tahun' => 'required',
            'no_fail_surat' => 'required',
            'lokasi_majlis' => 'required',
            'tarikh_surat_mula' => 'required',
            'tarikh_surat_akhir' => 'required',
            'tarikh_majlis_mula' => 'required',
            'tarikh_majlis_akhir' => 'required',
            'masa_majlis' => 'required',
            'staff_id' => 'required',
            'tarikh_cetakan' => 'required',
        ], [
            'nama.required' => 'Sila masukkan nama majlis.',
            'siri.required' => 'Sila masukkan siri majlis.',
            'tahun.required' => 'Sila masukkan tahun majlis.',
            'no_fail_surat.required' => 'Sila masukkan no fail surat.',
            'lokasi_majlis.required' => 'Sila masukkan lokasi majlis.',
            'tarikh_surat_mula.required' => 'Sila pilih tarikh mula surat.',
            'tarikh_surat_akhir.required' => 'Sila pilih tarikh tutup surat.',
            'tarikh_majlis_mula.required' => 'Sila pilih tarikh mula majlis.',
            'tarikh_majlis_akhir.required' => 'Sila pilih tarikh tutup majlis.',
            'masa_majlis.required' => 'Sila pilih masa majlis.',
            'staff_id.required' => 'Sila pilih pegawai untuk dihubungi.',
            'tarikh_cetakan.required' => 'Sila pilih tarikh cetakan.',
        ]);

        if ($request->has('status')) {
            $status = $request->status;
        } else {
            $status = 0;
        }

        DB::beginTransaction();

        try {
            TetapanMajlisPenyerahanSijilTahfiz::where('id', $id)->update([
                'nama' => $request->nama,
                'siri' => $request->siri,
                'tahun' => $request->tahun,
                'no_fail_surat' => $request->no_fail_surat,
                'status' => $status,
                'lokasi_majlis' => $request->lokasi_majlis,
                'tarikh_surat_mula' => Carbon::createFromFormat('d/m/Y', $request->tarikh_surat_mula)->format('Y-m-d'),
                'tarikh_surat_akhir' => Carbon::createFromFormat('d/m/Y', $request->tarikh_surat_akhir)->format('Y-m-d'),
                'tarikh_majlis_mula' => Carbon::createFromFormat('d/m/Y', $request->tarikh_majlis_mula)->format('Y-m-d'),
                'tarikh_majlis_akhir' => Carbon::createFromFormat('d/m/Y', $request->tarikh_majlis_akhir)->format('Y-m-d'),
                'tarikh_cetakan' => Carbon::createFromFormat('d/m/Y', $request->tarikh_cetakan)->format('Y-m-d'),
                'masa_majlis' => $request->masa_majlis,
                'staff_id' => $request->staff_id,
                'created_by' => Auth::id(),
            ]);

            Alert::toast('Tetapan Baru Berjaya Dipinda', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Dipinda', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TetapanMajlisPenyerahanSijilTahfiz::where('id', $id)->delete();

        Alert::toast('Tetapan telah berjaya dibuang', 'success');

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.majlis_penyerahan_sijil_tahfiz.index');
    }
}
