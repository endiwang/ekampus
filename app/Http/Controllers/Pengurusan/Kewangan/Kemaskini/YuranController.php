<?php

namespace App\Http\Controllers\Pengurusan\Kewangan\Kemaskini;

use App\Http\Controllers\Controller;
use App\Models\Yuran;
use App\Models\YuranDetail;
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
                    $html .= '<a href="' . route($this->baseRoute.'edit', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil-alt"></i></a> ';

                    if(!empty($data->is_fixed))
                    {
                        //
                    }
                    else {
                        $html .= '<a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hapus" onclick="remove('.$data->id.')"><i class="fa fa-trash"></i></a>'.
                        '<form id="delete-'.$data->id.'" action="'.route($this->baseRoute.'destroy', $data->id).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                        </form>';
                    }

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
                'route' => route($this->baseRoute . 'create'),
                'button_class' => 'btn btn-sm btn-primary fw-bold',
                'icon_class' => 'fa fa-plus-circle',
            ],
        ];

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
            'model' => new Yuran,
            'action' => route($this->baseRoute . 'store'),
            'yuran_detail' => collect([]),
        ];

        $data['title'] = 'Tambah Yuran';
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            'Kemaskini' => false,
            'Tambah Yuran' => false,
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
            'nama_yuran' => 'required',
            'amaun' => 'required',
        ], [
            'nama.required' => 'Sila tulis nama yuran',
            'nama_yuran.required' => 'Sila tulis nama yuran',
            'amaun.required' => 'Sila tulis amaun yuran',
        ]);

        $result = true;
        try {
            DB::transaction(function () use ($request) {

                $yuran = new Yuran;
                $yuran->nama = $request->nama;
                // $yuran->amaun = $request->amaun;
                $yuran->status = $request->status;
                $yuran->invoice_remarks = @$request->invoice_remarks;
                if($yuran->save())
                {                
                    if(!empty($request->nama_yuran))
                    {
                        foreach($request->nama_yuran as $key => $nama_yuran)
                        {
                            $yuran_detail = new YuranDetail;
                            $yuran_detail->yuran_id = $yuran->id;
                            $yuran_detail->nama = $nama_yuran;
                            $yuran_detail->amaun = $request->amaun[$key];
                            $yuran_detail->save();
                        }

                    }
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
            'model' => Yuran::findOrFail($id),
            'action' => route($this->baseRoute.'update', $id),
            'yuran_detail' => YuranDetail::where('yuran_id', $id)->get(),
        ];

        $data['title'] = 'Pinda Yuran';
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            'Kemaskini' => false,
            'Pinda Yuran' => false,
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
            'nama_yuran' => 'required',
            'amaun' => 'required',
        ], [
            'nama.required' => 'Sila tulis nama yuran',
            'nama_yuran.required' => 'Sila tulis nama yuran',
            'amaun.required' => 'Sila tulis amaun yuran',
        ]);

        $result = true;
        try {
            DB::transaction(function () use ($request, $id) {

                $yuran = Yuran::find($id);
                $yuran->nama = $request->nama;
                // $yuran->amaun = $request->amaun;
                $yuran->status = $request->status;
                $yuran->invoice_remarks = @$request->invoice_remarks;
                if($yuran->save())
                {              
                    YuranDetail::where('yuran_id', $yuran->id)->delete();
                                    
                    if(!empty($request->nama_yuran))
                    {
                        foreach($request->nama_yuran as $key => $nama_yuran)
                        {
                            $yuran_detail = new YuranDetail;
                            $yuran_detail->yuran_id = $yuran->id;
                            $yuran_detail->nama = $nama_yuran;
                            $yuran_detail->amaun = $request->amaun[$key];
                            $yuran_detail->save();
                        }

                    }

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
