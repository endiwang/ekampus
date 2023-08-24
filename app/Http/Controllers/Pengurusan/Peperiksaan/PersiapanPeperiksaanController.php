<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Bilik;
use App\Models\PersiapanPeperiksaan;
use App\Models\PersiapanPeperiksaanDetail;
use App\Models\Sesi;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PersiapanPeperiksaanController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.persiapan_peperiksaan.';
    protected $baseRoute = 'pengurusan.peperiksaan.persiapan_peperiksaan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Persiapan Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Persiapan Peperiksaan' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah',
                    'route' => route($this->baseRoute . 'create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = PersiapanPeperiksaan::with('persiapanPeperiksaanDetail', 'lokasi', 'sesi');
                if ($request->has('sesi') && $request->sesi != null) {
                    $data->where('sesi_id', $request->sesi);
                }

                return DataTables::of($data)
                    ->addColumn('sesi_id', function ($data) {
                        return $data->sesi->nama ?? null;
                    })
                    ->addColumn('lokasi_id', function ($data) {
                        return $data->lokasi->nama_bilik ?? null;
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
                        return '<a href="'.route($this->baseRoute . 'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete-'.$data->id.'" action="'.route($this->baseRoute . 'destroy', $data->id).'" method="POST">
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
                    ['data' => 'sesi_id', 'name' => 'sesi_id', 'title' => 'Sesi', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'lokasi_id', 'name' => 'lokasi_id', 'title' => 'Lokasi', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $sessions = Sesi::where('deleted_at', null)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'buttons', 'sessions'));

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

            $title = 'Tambah Persiapan Peperiksaan';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Maklumat Persiapan Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Persiapan Peperiksaan' => route($this->baseRoute . 'index'),
                'Tambah Maklumat' => false,
            ];

            $sessions = Sesi::where('deleted_at', null)->get()->pluck('nama', 'id');
            $locations = Bilik::where('is_deleted', 0)->get()->pluck('nama_bilik', 'id');

            return view($this->baseView.'create', compact('title', 'breadcrumbs', 'page_title', 'action', 'sessions', 'locations'));

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
        try {

            $data = new PersiapanPeperiksaan();
            $data->sesi_id = $request->sesi;
            $data->lokasi_id = $request->lokasi;
            $data->status = $request->status;
            $data->save();

            foreach ($request->data as $value) {
                $detail = new PersiapanPeperiksaanDetail();
                $detail->persiapan_peperiksaan_id = $data->id;
                $detail->item = $value['item'];
                $detail->kuantiti = $value['kuantiti'];
                $detail->catatan = $value['catatan'];
                $detail->save();
            }

            Alert::toast('Maklumat persiapan peperiksaan berjaya ditambah!', 'success');

            return redirect()->route($this->baseRoute.'index');

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
    public function edit($id, Builder $builder)
    {
        try {

            $title = 'Persiapan Peperiksaan';
            $action = route($this->baseRoute . 'update', $id);
            $page_title = 'Kemaskini Maklumat Persiapan Peperiksaan';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Persiapan Peperiksaan' => route($this->baseRoute . 'index'),
                'Kemaskini Maklumat Persiapan Peperiksaan' => false,
            ];

            $model = PersiapanPeperiksaan::find($id);

            $sessions = Sesi::where('deleted_at', null)->get()->pluck('nama', 'id');
            $locations = Bilik::where('is_deleted', 0)->get()->pluck('nama_bilik', 'id');

            if (request()->ajax()) {
                $data = PersiapanPeperiksaanDetail::where('persiapan_peperiksaan_id', $id);

                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route($this->baseRoute . 'delete_item', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="POST">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'item', 'name' => 'item', 'title' => 'Item', 'orderable' => false],
                    ['data' => 'kuantiti', 'name' => 'kuantiti', 'title' => 'Kuantiti', 'orderable' => false],
                    ['data' => 'catatan', 'name' => 'catatan', 'title' => 'Catatan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],
                ])
                ->minifiedAjax();

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'id', 'dataTable', 'sessions', 'locations'));

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
        try {

            $data = PersiapanPeperiksaan::find($id);
            $data->sesi_id = $request->sesi;
            $data->lokasi_id = $request->lokasi;
            $data->status = $request->status;
            $data->save();

            Alert::toast('Maklumat persiapan peperiksaan berjaya dikemaskini!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function addItem($id, Request $request)
    {
        try {

            $detail = new PersiapanPeperiksaanDetail();
            $detail->persiapan_peperiksaan_id = $id;
            $detail->item = $request->item;
            $detail->kuantiti = $request->kuantiti;
            $detail->catatan = $request->catatan;
            $detail->save();

            Alert::toast('Maklumat persiapan peperiksaan berjaya ditambah!', 'success');

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

            PersiapanPeperiksaan::find($id)->delete();
            PersiapanPeperiksaanDetail::where('persiapan_peperiksaan_id', $id)->delete();

            Alert::toast('Maklumat berjaya dihapuskan!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function deleteItem($id)
    {
        try {

            PersiapanPeperiksaanDetail::find($id)->delete();

            Alert::toast('Maklumat berjaya dihapuskan!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
