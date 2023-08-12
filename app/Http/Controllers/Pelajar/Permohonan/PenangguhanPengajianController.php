<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\PenangguhanPengajian;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenangguhanPengajianController extends Controller
{
    protected $baseView = 'pages.pelajar.permohonan.penangguhan_pengajian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

        $title = 'Penangguhan Pengajian';
        $breadcrumbs = [
            'Pelajar' => false,
            'Permohonan' => false,
            'Penangguhan Pengajian' => false,
        ];

        $modals = [
            [
                'title' => 'Tambah Permohonan Penangguhan',
                'id' => '#addPermohonan',
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        $tempoh = [
            '1 Semester' => '1 Semester',
            '2 Semester' => '2 Semester',
        ];

        if (request()->ajax()) {
            $data = PenangguhanPengajian::with('pelajar')->where('pelajar_id', auth()->user()->id);

            return DataTables::of($data)
                ->addColumn('no_matrik', function ($data) {
                    return $data->pelajar->no_matrik ?? null;
                })
                ->addColumn('tarikh_proses', function ($data) {
                    $tarikh = ! empty($data->tarikh_proses) ? Utils::formatDate($data->tarikh_proses) : 'N/A';

                    return $tarikh;
                })
                ->addColumn('status', function ($data) {
                    switch ($data->status) {
                        case 1:
                            return 'Baru Diterima';
                            break;

                        case 2:
                            return 'Dalam Proses';
                            break;

                        case 3:
                            return 'Lulus';
                            break;

                        case 4:
                            return 'Tolak';
                            break;
                    }
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="'.route('pelajar.permohonan.penangguhan_pengajian.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.penangguhan_pengajian.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['no_ic', 'status', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No. Matrik', 'orderable' => false],
                ['data' => 'tempoh_penangguhan', 'name' => 'nama_permohonan', 'title' => 'Tempoh Penangguhan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'tarikh_proses', 'name' => 'tarikh', 'title' => 'Tarikh Proses', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        return view($this->baseView.'main', compact('title', 'breadcrumbs', 'modals', 'tempoh', 'dataTable'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
        $validation = $request->validate([
            'tempoh' => 'required',
            'sebab' => 'required',
        ], [
            'tempoh.required' => 'Sila pilih tempoh',
            'sebab.required' => 'Sila masukkan sebab penangguhan',
        ]);

        try {

            $pelajar = Pelajar::where('user_id', auth()->user()->id)->first();

            $create = new PenangguhanPengajian();
            $create->pelajar_id = auth()->user()->id;
            $create->semester_now_id = $pelajar->semester;
            $create->is_gantung = 2;
            $create->tempoh_penangguhan = $request->tempoh;
            $create->sebab_penangguhan = $request->sebab;
            $create->status = 1;
            $create->save();

            Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');

            return redirect()->route('pelajar.permohonan.penangguhan_pengajian.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $title = 'Penangguhan Pengajian';
            $page_title = 'Maklumat Permohonan Penangguhan Pengajian';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Penangguhan Pengajian' => route('pelajar.permohonan.penangguhan_pengajian.index'),
                'Maklumat Permohonan Penangguhan Pengajian' => false,
            ];

            $data = PenangguhanPengajian::with('pelajar', 'semester')->find($id);

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'data'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        try {

            $data = PenangguhanPengajian::find($id);

            if ($data->status != 1) {
                Alert::toast('Harap Maaf, Permohonan yang sedang diproses tidak boleh dihapuskan', 'error');

                return redirect()->back();
            }

            $delete = $data->delete();

            Alert::toast('Maklumat permohonan penangguhan pengajian berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function downloadLetter($id)
    {
        try {
            $datas = PenangguhanPengajian::with('pelajar')->find($id);
            $title = 'Surat Kebenaran Penagguhan Pengajian '.$datas->pelajar->nama;

            $view_file = $this->baseView.'letter_pdf';
            $orientation = 'portrait';

            return Utils::pdfGenerate($title, $datas, $view_file, $orientation);

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

            return redirect()->back();
        }
    }
}
