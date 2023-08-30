<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use App\Models\Pelajar;
use App\Models\PermohonanPertukaranSyukbah;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PertukaranSyukbahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.permohonan.syukbah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Pertukaran Syukbah Pelajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Permohonan' => false,
                'Pertukaran Syukbah Pelajar' => false,
            ];

            $buttons = [];

            if (request()->ajax()) {
                $data = PermohonanPertukaranSyukbah::with('pelajar', 'pelajar.kursus', 'newSyukbah')->where('status', 'NEW');
                if ($request->has('nama') && $request->nama != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                    });
                }
                if ($request->has('no_ic') && $request->no_ic != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('no_ic', 'LIKE', '%'.$request->no_ic.'%');
                    });
                }
                if ($request->has('no_matrik') && $request->no_matrik != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('no_matrik', 'LIKE', '%'.$request->no_matrik.'%');
                    });
                }
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('kursus_id', $request->program_pengajian);
                    });
                }
            
                return DataTables::of($data)
                    ->addColumn('nama', function ($data) {
                        return $data->pelajar->nama;
                    })
                    ->addColumn('no_ic', function ($data) {
                        $data = '<p style="text-align:center">'.$data->pelajar->no_ic.'</p>';

                        return $data;
                    })
                    ->addColumn('no_matrik', function ($data) {
                        return $data->pelajar->no_matrik ?? null;
                    })
                    ->addColumn('kursus_id', function ($data) {
                        return $data->pelajar->kursus->nama ?? null;
                    })
                    ->addColumn('new_syukbah_id', function ($data) {
                        return $data->newSyukbah->nama ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.permohonan.pertukaran_syukbah.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
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
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No. Kad Pengenalan ', 'orderable' => false],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No. Matrik ', 'orderable' => false],
                    ['data' => 'kursus_id', 'name' => 'kursus_id', 'title' => 'Program Pengajian', 'orderable' => false],
                    ['data' => 'new_syukbah_id', 'name' => 'new_syukbah_id', 'title' => 'Syukbah Pilihan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $program_pengajian = Kursus::where('is_deleted', 0)->get()->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable', 'program_pengajian'));

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
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
        try {

            $title = 'Maklumat Pertukaran Syukbah Pelajar';
            $action = route('pengurusan.akademik.permohonan.pertukaran_syukbah.update', $id);
            $page_title = 'Pertukaran Syukbah Pelajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Permohonan' => false,
                'Pertukaran Syukbah Pelajar' => route('pengurusan.akademik.permohonan.pertukaran_syukbah.index'),
                'Maklumat Pertukaran Syukbah Pelajar' => false,
            ];

            $model = PermohonanPertukaranSyukbah::with('pelajar', 'pelajar.kursus', 'semester', 'newSyukbah', 'oldSyukbah')->find($id);

            $results = [
                'NEW' => 'Permohonan Baru',
                'OK' => 'Diterima',
                'KO' => 'Tidak Diterima',
            ];

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'results'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'keputusan' => 'required',
        ], [
            'keputusan.required' => 'Sila pilih syukbah',
        ]);

        try {

            //update status
            PermohonanPertukaranSyukbah::find($id)->update([
                'status' => $request->keputusan,
            ]);

            //update syukbah pelajar, set to status if OK
            $keputusan_permohonan = $request->keputusan;
            if ($keputusan_permohonan == 'OK') {
                Pelajar::find($request->pelajar_id)->update([
                    'syukbah_id' => $request->new_syukbah_id,
                ]);
            }

            Alert::toast('Keputusan pertukaran syukbah pelajar berjaya disimpan!', 'success');

            return redirect()->route('pengurusan.akademik.permohonan.pertukaran_syukbah.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
