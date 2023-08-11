<?php

namespace App\Http\Controllers\Pengurusan\Pentadbir_Sistem;

use App\Http\Controllers\Controller;
use App\Models\PusatTemuduga;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PusatTemudugaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // try {

        $title = 'Pusat Temuduga';
        $breadcrumbs = [
            'Pentadbir Sistem' => false,
            'Pusat Temuduga' => false,
        ];

        $buttons = [
            [
                'title' => 'Tambah Pusat Temuduga',
                'route' => route('pengurusan.pentadbir_sistem.pusat_temuduga.create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

        if (request()->ajax()) {
            $data = PusatTemuduga::get();

            return DataTables::of($data)
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
                    return '
                            <a href="'.route('pengurusan.pentadbir_sistem.pusat_temuduga.edit', $data->id).'" class="edit btn btn-icon btn-success btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.pentadbir_sistem.pusat_temuduga.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';

                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status'])
                ->toJson();
        }

        $dataTable = $builder
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false, 'class' => 'max-w-5px'],
                ['data' => 'nama',      'name' => 'nama',           'title' => 'Pusat Temuduga', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'status',      'name' => 'status',           'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                ['data' => 'action',    'name' => 'action',         'title' => 'Tindakan', 'orderable' => false, 'searchable' => false, 'class' => 'max-w-10px'],

            ])
            ->minifiedAjax();

        return view('pages.pengurusan.pentadbir_sistem.pusat_temuduga.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
        $title = 'Pusat Temuduga';
        $breadcrumbs = [
            'Pentadbir Sistem' => false,
            'Pusat Temuduga' => false,
            'Tambah Pusat Temuduga' => false,
        ];

        return view('pages.pengurusan.pentadbir_sistem.pusat_temuduga.add_new', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        PusatTemuduga::create([
            'nama' => $request->nama_pusat_temuduga,
            'status' => $request->status,
        ]);

        Alert::toast('Pusat Temuduga Berjaya Ditambah', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.pusat_temuduga.index');
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
        $title = 'Pusat Temuduga';
        $breadcrumbs = [
            'Pentadbir Sistem' => false,
            'Pusat Temuduga' => false,
            'Pinda Pusat Temuduga' => false,
        ];

        $pusat_temuduga = PusatTemuduga::find($id);

        return view('pages.pengurusan.pentadbir_sistem.pusat_temuduga.edit', compact('title', 'breadcrumbs', 'pusat_temuduga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pusat_temuduga = PusatTemuduga::find($id);
        $pusat_temuduga->nama = $request->nama_pusat_temuduga;
        $pusat_temuduga->status = $request->status;
        $pusat_temuduga->save();

        Alert::toast('Pusat Temuduga Berjaya Dipinda', 'success');

        return redirect()->route('pengurusan.pentadbir_sistem.pusat_temuduga.index');

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

            $pusat_temuduga = PusatTemuduga::find($id);

            $pusat_temuduga = $pusat_temuduga->delete();

            Alert::toast('Maklumat guru tasmik berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
