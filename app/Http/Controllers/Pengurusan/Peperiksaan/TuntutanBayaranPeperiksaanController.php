<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Bil;
use App\Models\PusatPengajian;
use App\Models\SesiPeperiksaan;
use App\Models\TuntutanBayaran;
use App\Models\Yuran;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TuntutanBayaranPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.tuntutan_bayaran.';

    protected $baseRoute = 'pengurusan.peperiksaan.tuntutan_bayaran.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Tuntutan Bayaran Peperiksaan (LTDQ/IPT Lain)';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Tuntutan Bayaran Peperiksaan (LTDQ/IPT Lain)' => false,
            ];

            if (request()->ajax()) {
                $data = PusatPengajian::query();
                if ($request->has('pusat_pengajian') && $request->pusat_pengajian != null) {
                    $data->where('id', $request->pusat_pengajian);
                }

                return DataTables::of($data)
                    ->addColumn('no_ic', function ($data) {
                        if (! empty($data->no_matrik)) {
                            $data = '<p style="text-align:center">'.$data->no_ic.'<br/> <span style="font-weight:bold"> ['.$data->no_matrik.'] </span></p>';
                        } else {
                            $data = $data->no_ic;
                        }

                        return $data;
                    })
                    ->addColumn('sesi_id', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('syukbah_id', function ($data) {
                        return $data->syukbah->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['nama', 'no_ic', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Pusat Pengajian', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $campuses = PusatPengajian::where('deleted_at', null)->where('kod', '!=', 'DQ')->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'campuses'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $yuran = Yuran::select('id')->where('nama', 'Yuran Peperiksaan')->first();
            $bil = new Bil();
            $bil->yuran_id = $yuran->id;
            $bil->description = $request->description;
            $bil->amaun = $request->jumlah;
            $bil->status = 1;
            $bil->save();

            TuntutanBayaran::create([
                'pusat_pengajian_id' => $request->pusat_pengajian_id,
                'bil_id' => $bil->id,
                'sesi_id' => $request->sesi,
                'description' => $request->description,
                'jumlah_pelajar' => $request->jumlah_pelajar,
                'jumlah' => $request->jumlah,
            ]);

            Alert::toast('Maklumat tuntutan bayaran berjaya ditambah!', 'success');

            return redirect()->back();

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
    public function show($id, Builder $builder)
    {
        // try {
        $title = 'Tuntutan Bayaran Peperiksaan (LTDQ/IPT Lain)';
        $page_title = 'Senarai Tuntutan Bayaran';
        $breadcrumbs = [
            'Peperiksaan' => false,
            'Tuntutan Bayaran Peperiksaan (LTDQ/IPT Lain)' => route($this->baseRoute.'index'),
            'Senarai Tuntutan Bayaran' => false,
        ];

        $modals = [
            [
                'title' => 'Tambah',
                'id' => '#addTuntutanBayaran',
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = TuntutanBayaran::with('sesi')->where('pusat_pengajian_id', $id);

            return DataTables::of($data)
                ->addColumn('sesi', function ($data) {
                    return $data->sesi->nama ?? null;
                })
                ->addColumn('jumlah', function ($data) {
                    return ! empty($data->jumlah) ? number_format($data->jumlah, 2) : '0.00';
                })
                ->addColumn('action', function ($data) {
                    return '
                                <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete-'.$data->id.'" action="'.route($this->baseRoute.'destroy', $data->id).'" method="POST">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                ';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'asc');
                })
                ->rawColumns(['no_ic', 'penilaian', 'action'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'sesi', 'name' => 'sesi', 'title' => 'Sesi Peperiksaan', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'description', 'name' => 'description', 'title' => 'Keterangan', 'orderable' => false],
                ['data' => 'jumlah_pelajar', 'name' => 'jumlah_pelajar', 'title' => 'Jumlah Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'jumlah', 'name' => 'jumlah', 'title' => 'Jumlah', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

            ])
            ->minifiedAjax();

        $exam_sessions = SesiPeperiksaan::pluck('nama', 'id');

        return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'page_title', 'modals', 'exam_sessions', 'id'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
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

            $data = TuntutanBayaran::find($id);

            Bil::find($data->bil_id)->delete();

            $delete = $data->delete();

            Alert::toast('Maklumat tuntutan bayaran berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
