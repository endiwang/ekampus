<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\CajPeperiksaan;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class CajPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.tetapan.caj_peperiksaan.';
    protected $baseRoute = 'pengurusan.peperiksaan.tetapan.caj_peperiksaan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Caj Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Caj Peperiksaan' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah',
                    'route' => route($this->baseRoute.'create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = CajPeperiksaan::with('subjek');
                if ($request->has('jenis') && $request->jenis != null) {
                    $data->where('jenis', $request->jenis);
                }
                if ($request->has('subjek') && $request->subjek != null) {
                    $data->where('subjek_id', $request->subjek);
                }

                return DataTables::of($data)
                    ->addColumn('jenis', function ($data) {
                        return Utils::getJenisCaj($data->jenis);
                    })
                    ->addColumn('description', function ($data) {
                        if($data->description == 'subjek')
                        {
                            return 'Subjek';
                        }
                        else {
                            return 'Subjek Ulangan';
                        }
                    })
                    ->addColumn('subjek_id', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('jumlah', function ($data) {
                        return number_format($data->jumlah,2) ?? null;
                    })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-success">Aktif</span>';
                                break;
                            case 1:
                                return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Aktif</span>';
                            default:
                                return '';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route($this->baseRoute.'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
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
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'subjek_id', 'name' => 'subjek_id', 'title' => 'Subjek', 'orderable' => false],
                    ['data' => 'description', 'name' => 'description', 'title' => 'Deskripsi', 'orderable' => false],
                    ['data' => 'jumlah', 'name' => 'jumlah', 'title' => 'Amaun', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

                $types  = [
                    'peperiksaan'       => 'Peperiksaan',
                    'hilang_transkrip'  => 'Hilang Transkrip/Slip Keputusan Periksa',
                    'semak_keputusan'   => 'Semak Semula Keputusan Peperiksaan',
                ];

                $subjects = Subjek::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'buttons', 'types', 'subjects'));

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

            $title = 'Caj Peperiksaan';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Tambah Sesi Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Tetapan' => false,
                'Caj Peperiksaan' => route($this->baseRoute . 'index'),
                'Tambah Caj Peperiksaan' => false,
            ];

            $model = new CajPeperiksaan();

            $types  = [
                'peperiksaan'       => 'Peperiksaan',
                'hilang_transkrip'  => 'Hilang Transkrip/Slip Keputusan Periksa',
                'semak_keputusan'   => 'Semak Semula Keputusan Peperiksaan'
            ];

            $descriptions = [
                'subjek' => 'Subjek',
                'subjek_ulangan' => 'Subjek Ulangan',
                'pengurusan_peperiksaan' => 'Pengurusan Peperiksaan'
            ];

            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'types', 'descriptions', 'subjects'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'jenis' => 'required',
            'description' => 'required_if:jenis,peperiksaan',
            'subjek' => 'required_if:description,subjek',
            'amaun' => 'required',
        ], [
            'jenis.required' => 'Sila masukkan maklumat nama',
            'description.required' => 'Sila pilih deskripsi',
            'subjek.required' => 'Sila pilih subjek',
            'amaun.required' => 'Sila pilih program pengajian',
        ]);

        try {

            CajPeperiksaan::create([
                'jenis' => $request->jenis,
                'description' => $request->description,
                'subjek_id' => $request->subjek ?? null,
                'jumlah' => $request->amaun,
                'status' => $request->status,
            ]);

            Alert::toast('Maklumat caj peperiksaan berjaya ditambah!', 'success');

            return redirect()->route($this->baseRoute . 'index');

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

            $title = 'Caj Peperiksaan';
            $action = route($this->baseRoute . 'update', $id);
            $page_title = 'Kemaskini Sesi Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Tetapan' => false,
                'Caj Peperiksaan' => route($this->baseRoute . 'index'),
                'Kemaskini Caj Peperiksaan' => false,
            ];

            $model = CajPeperiksaan::find($id);

            $types  = [
                'peperiksaan'       => 'Peperiksaan',
                'hilang_transkrip'  => 'Hilang Transkrip/Slip Keputusan Periksa',
                'semak_keputusan'   => 'Semak Semula Keputusan Peperiksaan'
            ];

            $descriptions = [
                'subjek' => 'Subjek',
                'subjek_ulangan' => 'Subjek Ulangan',
                'pengurusan_peperiksaan' => 'Pengurusan Peperiksaan'
            ];

            $subjects = Subjek::where('deleted_at', null)->get()->pluck('nama', 'id');

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'types', 'descriptions', 'subjects'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        $validation = $request->validate([
            'jenis' => 'required',
            'description' => 'required_if:jenis,peperiksaan',
            'subjek' => 'required_if:description,subjek',
            'amaun' => 'required',
        ], [
            'jenis.required' => 'Sila masukkan maklumat nama',
            'description.required' => 'Sila pilih deskripsi',
            'subjek.required' => 'Sila pilih subjek',
            'amaun.required' => 'Sila pilih program pengajian',
        ]);

        try {

            $data = CajPeperiksaan::find($id);
            $data->jenis = $request->jenis;
            $data->description = $request->description;
            $data->subjek_id = $request->subjek;
            $data->jumlah = $request->amaun;
            $data->status = $request->status;
            $data->save();

            Alert::toast('Maklumat caj peperiksaan berjaya dikemaskini!', 'success');

            return redirect()->route($this->baseRoute . 'index');

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

            CajPeperiksaan::find($id)->delete();

            Alert::toast('Maklumat caj peperiksaan berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
