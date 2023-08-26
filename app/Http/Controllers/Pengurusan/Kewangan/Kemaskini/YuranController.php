<?php

namespace App\Http\Controllers\Pengurusan\Kewangan\Kemaskini;

use App\Http\Controllers\Controller;
use App\Models\Yuran;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use DB;
use Illuminate\Support\Facades\Cache;

class YuranController extends Controller
{
    protected $baseView = 'pages.pengurusan.kewangan.kemaskini.yuran.';
    protected $baseRoute = 'pengurusan.kewangan.kemaskini.yuran.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {

            $data = Yuran::query();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .= '<a href="javascript:void(0)" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1 btn-edit-yuran" data-bs-toggle="tooltip" title="Pinda" data-url="' . route($this->baseRoute.'edit', $data->id) . '" data-action="' . route($this->baseRoute.'update', $data->id) . '"><i class="fa fa-pencil-alt"></i></a> ';
                    $html .= '<a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hapus" onclick="remove('.$data->id.')"><i class="fa fa-trash"></i></a>'.
                    '<form id="delete-'.$data->id.'" action="'.route($this->baseRoute.'destroy', $data->id).'" method="POST">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="_method" value="DELETE">
                </form>';

                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        $dataTable = $builder
            ->parameters([])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Yuran', 'orderable' => false],
                ['data' => 'amaun', 'name' => 'amaun', 'title' => 'Amaun Yuran', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],

            ])
            ->minifiedAjax();

        $data['dataTable'] = $dataTable;

        $data['title'] = 'Senarai Yuran';
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            'Kemaskini' => false,
            'Senarai Yuran' => false,
        ];
        $data['buttons'] = [
            [
                'title' => 'Tambah Yuran',
                'route' => 'javascript:void(0)',
                'button_class' => 'btn btn-sm btn-primary fw-bold btn-add-yuran',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];
        $data['btn_create_url'] = route($this->baseRoute . 'create');
        $data['btn_create_action'] = route($this->baseRoute . 'store');

        return view($this->baseView.'list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new Yuran
        ];
        return view($this->baseView.'form')->with($data);
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
            'nama' => 'required',
            'amaun' => 'required',
        ], [
            'nama.required' => 'Sila tulis nama yuran',
            'amaun.required' => 'Sila tulis amaun yuran',
        ]);

        $result = true;
        try {
            DB::transaction(function () use ($request) {

                $yuran = new Yuran;
                $yuran->nama = $request->nama;
                $yuran->amaun = $request->amaun;
                $yuran->status = $request->status;
                if($yuran->save())
                {                                        
                    Cache::forget('yuran_cached');
                    Cache::rememberForever('yuran_cached', function () {
                        return Yuran::get();
                    });
                }
            });

        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            Alert::toast('Maklumat yuran berjaya ditambah', 'success');

            return redirect(route($this->baseRoute.'index'));
        } else {
            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

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
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => Yuran::find($id)
        ];
        return view($this->baseView.'form')->with($data);
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
            'nama' => 'required',
            'amaun' => 'required',
        ], [
            'nama.required' => 'Sila tulis nama yuran',
            'amaun.required' => 'Sila tulis amaun yuran',
        ]);

        $result = true;
        try {
            DB::transaction(function () use ($request, $id) {

                $yuran = Yuran::find($id);
                $yuran->nama = $request->nama;
                $yuran->amaun = $request->amaun;
                $yuran->status = $request->status;
                if($yuran->save())
                {                    
                    Cache::forget('yuran_cached');
                    Cache::rememberForever('yuran_cached', function () {
                        return Yuran::get();
                    });
                }
            });

        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            Alert::toast('Maklumat yuran berjaya dikemaskini', 'success');

            return redirect(route($this->baseRoute.'index'));
        } else {
            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

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
        $yuran = Yuran::find($id);

        if (! empty($yuran)) {
            $yuran->delete();
                                
            Cache::forget('yuran_cached');
            Cache::rememberForever('yuran_cached', function () {
                return Yuran::get();
            });
        }

        Alert::toast('Maklumat yuran berjaya dihapus!', 'success');

        return redirect()->back();
    }
}
