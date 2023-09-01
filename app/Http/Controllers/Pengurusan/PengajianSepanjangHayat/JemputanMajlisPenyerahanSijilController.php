<?php

namespace App\Http\Controllers\Pengurusan\PengajianSepanjangHayat;

use App\Http\Controllers\Controller;
use App\Models\PemarkahanCalonSijilTahfiz;
use App\Models\PermohonanSijilTahfiz;
use App\Models\Staff;
use App\Models\TemplateJemputanMajlisPensijilan;
use App\Models\TetapanMajlisPenyerahanSijilTahfiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class JemputanMajlisPenyerahanSijilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        $title = 'Senarai Jemputan';
        $breadcrumbs = [
            'Jabatan Pengajian Sepanjang Hayat' => false,
            'Majlis Pensijilan' => false,
            'Jemputan Majlis Pensijilan' => false,
        ];

        if (request()->ajax()) {
            $query = PemarkahanCalonSijilTahfiz::query();

            $query->join('permohonan_sijil_tahfizs as p', 'p.id', '=', 'pemarkahan_calon_sijil_tahfizs.permohonan_id');
            if ($request->has('carian')) {
                $query->where(function ($q) use ($request) {
                    $q->where('p.name', 'LIKE', '%'.$request->carian.'%');
                    $q->orWhere('p.ic_no', 'LIKE', '%'.$request->carian.'%');
                });
            }
            if (! is_null($request->status_kehadiran)) {
                $query->where('p.status_kehadiran', $request->status_kehadiran);
            }
            if (! is_null($request->status_janaan)) {
                $query->where('p.status_janaan_jemputan', $request->status_janaan);
            }
            $data = $query->where('pemarkahan_calon_sijil_tahfizs.approval', 1)
                ->where('pemarkahan_calon_sijil_tahfizs.status_kelulusan', 1);

            return DataTables::of($data)
                ->addColumn('nama', function ($data) {
                    return $data->permohonanSijilTahfiz->name ?? null;
                })
                ->addColumn('status_kehadiran', function ($data) {
                    switch ($data->permohonanSijilTahfiz->status_kehadiran) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Hadir</span>';
                            break;
                        case 2:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Hadir</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum disahkan kehadiran</span>';
                            break;

                        default:
                            return '';
                    }
                })
                ->addColumn('status', function ($data) {
                    switch ($data->permohonanSijilTahfiz->status_janaan_jemputan) {
                        case 1:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Dijana</span>';
                            break;
                        case 0:
                            return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Belum Dijana</span>';
                            break;

                        default:
                            return '';
                    }
                })
                ->addColumn('select', function ($data) {
                    $btn = '<input type="hidden" name="pemohon_id[]" value="'.$data->permohonan_id.'">';

                    return $btn;
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('pemarkahan_calon_sijil_tahfizs.id', 'asc');
                })
                ->rawColumns(['status', 'select', 'nama', 'status_kehadiran'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Jemputan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status_kehadiran', 'name' => 'status_kehadiran', 'title' => 'Status Kehadiran', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Janaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'select', 'name' => 'select', 'title' => 'Pilih', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
            ])
            ->columnDefs([
                [
                    'orderable' => 'false',
                    'className' => 'select-checkbox',
                    'targets' => -1,
                ],
            ])
            ->select(
                ['style' => 'multi']
            )
            ->parameters(
                [
                    'info' => false,
                    'paging' => false,
                ]
            )
            ->minifiedAjax();

        $majlis = TetapanMajlisPenyerahanSijilTahfiz::where('status', 1)->whereNull('deleted_at')->get()->pluck('nama', 'id');
        $template = TemplateJemputanMajlisPensijilan::where('status', 1)->whereNull('deleted_at')->get()->pluck('name', 'id');
        $status_kehadiran = [
            0 => 'Belum Disahkan Kehadiran',
            1 => 'Hadir',
            2 => 'Tidak Hadir',
        ];
        $status_janaan = [
            0 => 'Belum Dijana',
            1 => 'Sudah Dijana',
        ];

        return view('pages.pengurusan.pengajian_sepanjang_hayat.majlis_pensijilan.jemputan_majlis_pensijilan.main', compact('title', 'breadcrumbs', 'dataTable', 'majlis', 'template', 'status_kehadiran', 'status_janaan'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required',
        ], [
            'template_id.required' => 'Sila pilih template jemputan.',
        ]);

        DB::beginTransaction();
        try {
            $template_id = $request->get('template_id');
            $jemputan = $request->get('pemohon_id');

            if (! empty($jemputan)) {
                foreach ($jemputan as $permohonan_id) {
                    PermohonanSijilTahfiz::where('id', $permohonan_id)->update(['template_jemputan_id' => $template_id, 'status_janaan_jemputan' => 1]);
                }
            }

            Alert::toast('Sijil Tahfiz Telah Berjaya Dijana', 'success');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            Alert::toast('Jemputan Tidah Berjaya Dijana', 'error');
        }

        return redirect()->route('pengurusan.pengajian_sepanjang_hayat.jemputan.jemputan_majlis.index');

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

    public function generateTemplate($template_id)
    {
        $template_jemputan = TemplateJemputanMajlisPensijilan::find($template_id);
        $tetapan_majlis = TetapanMajlisPenyerahanSijilTahfiz::find($template_jemputan->majlis_id);
        $pegawai = Staff::find($tetapan_majlis->staff_id);
        preg_match_all('/{([^}]*)}/', $template_jemputan->template, $matches);

        $message_body = '';
        $message_body .= $tetapan_majlis->template;
        foreach ($matches[0] as $pholder) {
            if ($pholder == '{NamaMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->nama, $message_body);
            }

            if ($pholder == '{LokasiMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->lokasi_majlis, $message_body);
            }

            if ($pholder == '{TarikhMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->tarikh_majlis_mula, $message_body);
            }

            if ($pholder == '{MasaMajlis}') {
                $message_body = str_replace($pholder, $tetapan_majlis->masa_majlis, $message_body);
            }

            if ($pholder == '{PegawaiMajlis}') {
                $message_body = str_replace($pholder, $pegawai->nama.'('.$pegawai->no_tel.')', $message_body);
            }
        }

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pages.pengurusan.pengajian_sepanjang_hayat.majlis_pensijilan.jemputan_majlis_pensijilan.export_pdf', compact('message_body'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream();
    }
}
