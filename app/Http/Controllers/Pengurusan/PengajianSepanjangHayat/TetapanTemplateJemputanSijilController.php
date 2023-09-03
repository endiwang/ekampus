<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\TemplateJemputanMajlisPensijilan;
use App\Models\TetapanMajlisPenyerahanSijilTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TetapanTemplateJemputanSijilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $title = 'Tetapan Template Jemputan Majlis Pensijilan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => '#',
            'Majlis Pensijilan' => '#',
            'Tetapan Template Jemputan Majlis Pensijilan ' => '#',
        ];
        $buttons = [
            [
                'title' => 'Tambah',
                'route' => route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = TemplateJemputanMajlisPensijilan::all();

            return DataTables::of($data)
                ->addColumn('status_edit', function ($data) {
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
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.edit', $data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                    $btn .= ' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                    <i class="fa fa-trash"></i>
                    </a>
                    <form id="delete-'.$data->id.'" action="'.route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.destroy', $data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';

                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['status_edit', 'action'])
                ->toJson();
        }

        $html = $builder
            ->parameters([

            ])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'orderable' => false],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama Template', 'orderable' => true],
                ['data' => 'status_edit', 'name' => 'status_edit', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.main', compact('title', 'breadcrumbs', 'html', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Template Jemputan Majlis Pensijilan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => false,
            'Majlis Pensijilan' => false,
            'Tetapan Template Jemputan Majlis Pensijilan' => false,
            'Tambah Template Jemputan Majlis Pensijilan' => false,
        ];

        $majlis = TetapanMajlisPenyerahanSijilTahfiz::where('status', 1)->whereNull('deleted_at')->get()->pluck('nama', 'id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'majlis_selection' => $majlis,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.add_new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'majlis_id' => 'required',
            'template' => 'required',
        ], [
            'name.required' => 'Sila masukkan nama sijil.',
            'majlis_id.required' => 'Sila pilih Majlis',
            'template.required' => 'Ruangan ini perlu diisi.',
        ]);

        $request['created_by'] = Auth::id();
        DB::beginTransaction();
        try {
            TemplateJemputanMajlisPensijilan::create($request->except('_token'));

            Alert::toast('Tetapan Baru Berjaya Ditambah', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            dd($e);
            Alert::toast('Tetapan Baru Tidak Berjaya Ditambah', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.index');
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
        $title = 'Kemaskini Template Jemputan Majlis Pensijilan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => false,
            'Majlis Pensijilan' => false,
            'Tetapan Template Jemputan Majlis Pensijilan' => false,
            'Kemaskini Template Jemputan Majlis Pensijilan' => false,
        ];

        $template = TemplateJemputanMajlisPensijilan::find($id);
        $majlis = TetapanMajlisPenyerahanSijilTahfiz::where('status', 1)->whereNull('deleted_at')->get()->pluck('nama', 'id');
        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'template' => $template,
            'majlis_selection' => $majlis,
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'majlis_id' => 'required',
            'template' => 'required',
        ], [
            'name.required' => 'Sila masukkan nama sijil.',
            'majlis_id.required' => 'Sila pilih Majlis',
            'template.required' => 'Ruangan ini perlu diisi.',
        ]);

        DB::beginTransaction();
        try {
            TemplateJemputanMajlisPensijilan::where('id', $id)->update($request->except('_token', '_method'));

            Alert::toast('Tetapan Berjaya Dikemaskini', 'success');
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            dd($e);
            Alert::toast('Tetapan Tidak Berjaya Dikemaskini', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TemplateJemputanMajlisPensijilan::where('id', $id)->delete();
        Alert::toast('Tetapan Dibuang', 'success');

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.tetapan.template_jemputan_sijil.index');
    }
}
