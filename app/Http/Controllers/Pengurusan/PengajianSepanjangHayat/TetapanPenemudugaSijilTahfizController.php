<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PusatPeperiksaan;
use App\Models\PusatPeperiksaanNegeri;
use App\Models\Staff;
use App\Models\TetapanPenemudugaSijilTahfiz;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TetapanPenemudugaSijilTahfizController extends Controller
{
    public function index(Builder $builder)
    {
        $title = 'Tetapan Sesi Peperiksaan Sijil Tahfiz';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Pengurusan Sijil Tahfiz' => '#',
            'Tetapan Penemuduga Sijil Tahfiz' => '#',
        ];
        $buttons = [
            [
                'title' => 'Tambah',
                'route' => route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = TetapanPenemudugaSijilTahfiz::all();

            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    $staff = Staff::where('id', $data->staff_id)->pluck('nama')->first();

                    return $staff;

                })
                ->addColumn('siri', function ($data) {
                    return $data->tetapanSiriPeperiksaan->siri;

                })
                ->addColumn('status_edit', function ($data) {
                    switch ($data->status) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tutup</span>';
                        default:
                            return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.show', $data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                    $btn .= ' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.edit', $data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                    $btn .= ' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                    <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.destroy', $data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['status_edit', 'action'])
                ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $html = $builder
            ->parameters([
                // 'language' => '{ "lengthMenu": "Show _MENU_", }',
                // 'dom' => $dom_setting,
            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama Penemuduga', 'orderable' => true],
                ['data' => 'siri', 'name' => 'siri', 'title' => 'Siri Peperiksaan', 'orderable' => false],
                ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.main', compact('title', 'breadcrumbs', 'html', 'buttons'));
    }

    public function create()
    {
        $title = 'Tambah Pusat Peperiksaan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Pengurusan Sijil Tahfiz' => '#',
            'Tetapan Penemuduga Sijil Tahfiz' => '#',
            'Tambah Penemudugan' => '#',
        ];

        $staffSelection = Staff::all();
        $tetapanpeperiksaansijiltahfizs = TetapanPeperiksaanSijilTahfiz::where('status', 1)->get();

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'staffSelection' => $staffSelection,
            'tetapanpeperiksaansijiltahfizs' => $tetapanpeperiksaansijiltahfizs,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.add_new', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|array',
            'tetapan_peperiksaan_sijil_tahfiz_id' => 'required',
            'pusat_peperiksaan_id' => 'required',
            'pusat_peperiksaan_negeri_id' => 'required',
        ], [
            'staff_id.required' => 'Sila pilih penemudga.',
            'tetapan_peperiksaan_sijil_tahfiz_id.required' => 'Sila pilih siri peperiksaan.',
            'pusat_peperiksaan_id.required' => 'Sila pilih pusat peperiksaan.',
            'pusat_peperiksaan_negeri_id.required' => 'Sila pilih negeri pusat peperiksaan.',
        ]);

        $request['created_by'] = Auth::id();
        DB::beginTransaction();

        try {
            foreach ($request->staff_id as $staff_id) {
                $request['staff_id'] = $staff_id;
                TetapanPenemudugaSijilTahfiz::create($request->except('_token'));
            }

            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index');
    }

    public function show($id)
    {
        $title = 'Lihat Tetapan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Pengurusan Sijil Tahfiz' => '#',
            'Tetapan Penemuduga Sijil Tahfiz' => '#',
            'Tambah Tetapan' => '#',
        ];

        $penemuduga = TetapanPenemudugaSijilTahfiz::where('id', $id)->first();
        $staffSelection = Staff::all();
        $tetapanpeperiksaansijiltahfizs = TetapanPeperiksaanSijilTahfiz::where('status', 1)->get();

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'penemuduga' => $penemuduga,
            'staffSelection' => $staffSelection,
            'tetapanpeperiksaansijiltahfizs' => $tetapanpeperiksaansijiltahfizs,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.view', $data);
    }

    public function edit($id)
    {
        $title = 'Pinda Penemuduga';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Pengurusan Sijil Tahfiz' => '#',
            'Tetapan Penemuduga Sijil Tahfiz' => '#',
            'Pinda Penemuduga' => '#',
        ];

        $penemuduga = TetapanPenemudugaSijilTahfiz::where('id', $id)->first();
        $staffSelection = Staff::all();
        $tetapanpeperiksaansijiltahfizs = TetapanPeperiksaanSijilTahfiz::where('status', 1)->get();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($penemuduga->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $penemuduga->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'penemuduga' => $penemuduga,
            'staffSelection' => $staffSelection,
            'id' => $id,
            'tetapanpeperiksaansijiltahfizs' => $tetapanpeperiksaansijiltahfizs,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'staff_id' => 'required',
            'tetapan_peperiksaan_sijil_tahfiz_id' => 'required',
            'pusat_peperiksaan_id' => 'required',
            'pusat_peperiksaan_negeri_id' => 'required',
        ], [
            'staff_id.required' => 'Sila pilih penemudga.',
            'tetapan_peperiksaan_sijil_tahfiz_id.required' => 'Sila pilih siri peperiksaan.',
            'pusat_peperiksaan_id.required' => 'Sila pilih pusat peperiksaan.',
            'pusat_peperiksaan_negeri_id.required' => 'Sila pilih negeri pusat peperiksaan.',
        ]);

        $request['created_by'] = Auth::id();
        if (! $request->has('status')) {
            $request['status'] = 0;
        }

        DB::beginTransaction();

        try {
            TetapanPenemudugaSijilTahfiz::where('id', $id)->update($request->except('_token', '_method'));

            Alert::toast('Tetapan Berjaya Dipinda', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            report($e);
            Alert::toast('Tetapan Tidak Berjaya Dipinda', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index');
    }

    public function destroy($id)
    {
        TetapanPenemudugaSijilTahfiz::where('id', $id)->delete();

        Alert::toast('Tetapan telah berjaya dibuang', 'success');

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index');
    }

    public function fetchPusatPeperiksaan(Request $request)
    {
        $tetapan = TetapanPeperiksaanSijilTahfiz::where('id', $request->siri_id)->first();
        $ppeperiksaan = PusatPeperiksaan::whereIn('id', json_decode($tetapan->lokasi_peperiksaan))
            ->get(['id', 'name as text']);

        return $ppeperiksaan;
    }

    public function fetchPusatPeperiksaanNegeri(Request $request)
    {
        $ppnegeri = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $request->pusat_peperiksaan_id)
            ->get(['pusat_peperiksaan_negeris.id', 'negeri.nama as text']);

        return $ppnegeri;
    }
}
