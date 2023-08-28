<?php

namespace App\Http\Controllers\Pengurusan\Akademik\Pengurusan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\PelajarBerhenti;
use App\Models\SebabBerhenti;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenamatanPengajianController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan.penamatan_pengajian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Arahan Berhenti Belajar';
            $breadcrumbs = [
                'Akademik' => false,
                'Arahan Berhenti Belajar' => false,
            ];

            $buttons = [
                [
                    'title' => 'Cipta Rekod Pelajar Diberhentikan',
                    'route' => route('pengurusan.akademik.pengurusan.penamatan_pengajian.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = PelajarBerhenti::with('pelajar', 'pelajarOld');
                if ($request->has('nama') && $request->nama != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama.'%');
                    });
                }
                if ($request->has('no_kp') && $request->no_kp != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('no_ic', 'LIKE', '%'.$request->no_kp.'%');
                    });
                }
                if ($request->has('no_matrik') && $request->no_matrik != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('no_matrik', 'LIKE', '%'.$request->no_matrik.'%');
                    });
                }
                if ($request->has('sebab_berhenti') && $request->sebab_berhenti != null) {
                    $data->where('kod_berhenti', $request->sebab_berhenti);
                }

                return DataTables::of($data)
                    ->addColumn('nama_pelajar', function ($data) {
                        if (! empty($data->pelajar->nama)) {
                            return $data->pelajar->nama;
                        } else {
                            return $data->pelajarOld->nama ?? null;
                        }
                    })
                    ->addColumn('tarikh_berhenti', function ($data) {
                        return ! empty($data->tarikh_berhenti) ? Utils::formatDate($data->tarikh_berhenti) : null;
                    })
                    ->addColumn('no_ic', function ($data) {
                        $student = '';
                        if (! empty($data->pelajar->no_ic)) {
                            $no_ic = ! empty($data->pelajar->no_ic) ? $data->pelajar->no_ic : null;
                            $no_matrik = ! empty($data->pelajar->no_matrik) ? $data->pelajar->no_matrik : null;
                            $student = nl2br($no_ic."\n".' ['.$no_matrik.']');
                        } else {
                            $no_ic = ! empty($data->pelajarOld->no_ic) ? $data->pelajarOld->no_ic : null;
                            $no_matrik = ! empty($data->pelajarOld->no_matrik) ? $data->pelajarOld->no_matrik : null;
                            $student = nl2br($no_ic."\n".' ['.$no_matrik.']');
                        }

                        return $student;
                    })
                    ->addColumn('kod_berhenti', function ($data) {
                        $deskripsi_kod = SebabBerhenti::find($data->kod_berhenti);

                        return $deskripsi_kod->berhenti ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pengurusan.akademik.pengurusan.penamatan_pengajian.edit', $data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Maklumat">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan.penamatan_pengajian.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action', 'no_ic'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable' => false],
                    ['data' => 'no_ic', 'name' => 'no_ic', 'title' => 'No Kp / [No Matrik]', 'orderable' => false],
                    ['data' => 'tarikh_berhenti', 'name' => 'tarikh_berhenti', 'title' => 'Tarikh Berhenti', 'orderable' => false],
                    ['data' => 'kod_berhenti', 'name' => 'kod_berhenti', 'title' => 'Kod Berhenti', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();
            
            $sebab_berhenti = SebabBerhenti::pluck('berhenti', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'buttons', 'sebab_berhenti'));

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
        try {

            $title = 'Arahan Berhenti Belajar';
            $action = route('pengurusan.akademik.pengurusan.penamatan_pengajian.store');
            $page_title = 'Cipta Rekod Pelajar Diberhentikan';
            $breadcrumbs = [
                'Akademik' => false,
                'Arahan Berhenti Belajar' => route('pengurusan.akademik.pengurusan.penamatan_pengajian.index'),
                'Cipta Rekod Pelajar Diberhentikan' => false,
            ];

            $model = new PelajarBerhenti();

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->get();

            $sebab_berhenti = SebabBerhenti::get()->pluck('berhenti', 'id');

            return view($this->baseView.'create', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'students', 'sebab_berhenti'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'pelajar' => 'required',
            'kod_berhenti' => 'required',
            'sebab_berhenti' => 'required',
            'tarikh_berhenti' => 'required',
        ], [
            'pelajar.required' => 'Sila pilih pelajar',
            'kod_berhenti.required' => 'Sila pilih kod berhenti',
            'sebab_berhenti.required' => 'Sila masukkan sebab berhenti',
            'tarikh_berhenti.required' => 'Sila pilih tarikh rekod',
        ]);

        try {

            $aktiviti = new PelajarBerhenti();
            $aktiviti->pelajar_id = $request->pelajar;
            $aktiviti->tarikh_berhenti = Carbon::createFromFormat('d/m/Y', $request->tarikh_berhenti)->format('Y-m-d');
            $aktiviti->sebab_berhenti = $request->sebab_berhenti;
            $aktiviti->kod_berhenti = $request->kod_berhenti;
            $aktiviti->created_by = auth()->user()->id;
            $aktiviti->save();

            Alert::toast('Maklumat pelajar diberhentikan berjaya disimpan!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan.penamatan_pengajian.index');

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

            $title = 'Arahan Berhenti Belajar';
            $action = route('pengurusan.akademik.pengurusan.penamatan_pengajian.update', $id);
            $page_title = 'Pinda Rekod Pelajar Diberhentikan';
            $breadcrumbs = [
                'Akademik' => false,
                'Arahan Berhenti Belajar' => route('pengurusan.akademik.pengurusan.penamatan_pengajian.index'),
                'Pinda Rekod Pelajar Diberhentikan' => false,
            ];

            $model = PelajarBerhenti::find($id);

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->get();

            $sebab_berhenti = SebabBerhenti::get()->pluck('berhenti', 'id');

            return view($this->baseView.'create', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'students', 'sebab_berhenti'));

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
        try {
            $aktiviti = PelajarBerhenti::find($id);
            $aktiviti->pelajar_id = $request->pelajar;
            $aktiviti->tarikh_berhenti = Carbon::createFromFormat('d/m/Y', $request->tarikh_berhenti)->format('Y-m-d');
            $aktiviti->sebab_berhenti = $request->sebab_berhenti;
            $aktiviti->kod_berhenti = $request->kod_berhenti;
            $aktiviti->created_by = auth()->user()->id;
            $aktiviti->save();

            Alert::toast('Maklumat pelajar diberhentikan berjaya dipinda!', 'success');

            return redirect()->back();

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
        try {
            PelajarBerhenti::find($id)->delete();

            Alert::toast('Maklumat pelajar berhenti berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
