<?php

namespace App\Http\Controllers\Pengurusan\Kewangan;

use App\Constants\Generic;
use App\Events\BayaranYuranEvent;
use App\Http\Controllers\Controller;
use App\Libraries\BilLibrary;
use App\Models\Bayaran;
use App\Models\Bil;
use App\Models\Pelajar;
use App\Models\Yuran;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Dompdf\Dompdf;
use Pdf;

class YuranController extends Controller
{
    protected $baseView = 'pages.pengurusan.kewangan.yuran.';

    protected $baseRoute = 'pengurusan.kewangan.yuran.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder, $id)
    {
        $yuran = Yuran::find($id);

        if (request()->ajax()) {

            $data = Bil::where('yuran_id', $id);

            if(!empty($request->carian))
            {
                if($id == Generic::YURAN_SIJIL_TAHFIZ)
                {
                    $data->join('pemohon', 'pemohon.id', 'bil.pemohon_id')
                    ->join('permohonan_sijil_tahfizs', 'permohonan_sijil_tahfizs.id', 'bil.permohonan_sijil_tahfiz_id')
                    ->where(function($where) use($request) {
                        $where->where('bil.doc_no', 'LIKE', '%' . $request->carian . '%');
                        $where->orWhere('permohonan_sijil_tahfizs.name', 'LIKE', '%' . $request->carian . '%');
                        $where->orWhere('pemohon.username', 'LIKE', '%' . $request->carian . '%');
                    });

                }
                else {
                    $data->join('pelajar', 'pelajar.id', 'bil.pelajar_id')
                    ->where(function($where) use($request) {
                        $where->where('bil.doc_no', 'LIKE', '%' . $request->carian . '%');
                        $where->orWhere('pelajar.nama', 'LIKE', '%' . $request->carian . '%');
                        $where->orWhere('pelajar.no_ic', 'LIKE', '%' . $request->carian . '%');
                    });
                }
            }

            if (! empty($request->status)) {
                $data->where('bil.status', $request->status);
            }

            $data = $data->select(['bil.*']);

            return DataTables::of($data)
                ->addColumn('pelajar', function ($data) use($id){
                    return @$data->pelajar_nama . '<br>' . @$data->pelajar_ic;
                })
                ->addColumn('action', function ($data) use ($id) {
                    $html = '';
                    $html .= '<a href="'.route($this->baseRoute.'edit', ['id' => $id, 'yuran' => $data->id]).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil-alt"></i></a> ';

                    return $html;
                })
                ->addColumn('bil', function ($data) use($id){
                    return '<a href="' . route('public.yuran.invois', Crypt::encryptString($data->id)) . '" target="_blank">' . $data->doc_no . '</a>';
                })
                ->addColumn('bayaran', function ($data) use($id){
                    $bayaran = Bayaran::where('bil_id', $data->id)->first();
                    if (! empty($bayaran)) {
                        return '<a href="'.route('public.yuran.resit', Crypt::encryptString($bayaran->id)).'" target="_blank">'.$bayaran->doc_no.'</a>';
                    }
                })
                ->addColumn('status', function ($data) {
                    return $data->status_name;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'bayaran', 'bil', 'pelajar'])
                ->toJson();
        }

        $dataTable = $builder
            ->parameters([])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'bil', 'name' => 'bil', 'title' => 'No Bil', 'orderable' => false],
                ['data' => 'bayaran', 'name' => 'bayaran', 'title' => 'Bayaran', 'orderable' => false],
                ['data' => 'pelajar', 'name' => 'pelajar', 'title' => 'Nama Pelajar', 'orderable' => false],
                ['data' => 'amaun', 'name' => 'amaun', 'title' => 'Amaun Yuran', 'orderable' => false],
                ['data' => 'status', 'name' => 'status', 'title' => 'Status Bil', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],

            ])
            ->minifiedAjax('', null, [
                'carian' => '$("#maklumat_carian").val()',
                'status' => '$("#status").val()',
            ]);

        $data['dataTable'] = $dataTable;

        $data['title'] = $yuran->nama;
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            $yuran->nama => false,
        ];
        $data['buttons'] = [
            [
                'title' => 'Bil Baru',
                'route' => route($this->baseRoute.'create', $id),
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
    public function create($id)
    {
        $yuran = Yuran::find($id);
        $data['title'] = $yuran->nama;
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            $yuran->nama => false,
        ];
        $data['page_title'] = 'Bil Baru';
        $data['action'] = route($this->baseRoute.'store', $id);
        $data['yuran'] = $yuran;
        $data['model'] = new Bil;
        $data['pelajar'] = Pelajar::limit(10)->pluck('nama', 'id')->toArray();

        return view($this->baseView.'form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validation = $request->validate([
            'pelajar_id' => 'required',
            'amaun' => 'required',
        ], [
            'pelajar_id.required' => 'Sila pilih pelajar',
            'amaun.required' => 'Sila tulis amaun yuran',
        ]);

        $result = true;
        try {
            DB::transaction(function () use ($request, $id) {

                $request['yuran'] = Yuran::find($id);
                BilLibrary::createBil($request->all());
            });

        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {
            Alert::toast('Maklumat bil berjaya ditambah', 'success');

            return redirect(route($this->baseRoute.'index', $id));
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
    public function show(Request $request, $data_id)
    {
        if ($request->segment(1) == 'resit') {
            $id = Crypt::decryptString($data_id);
            $bayaran = Bayaran::where('id', $id)->first();

            if (empty($bayaran)) {
                abort(404);
            }

            $data['bayaran'] = $bayaran;
          
            return view($this->baseView . 'resit')->with($data);
        }    

        if($request->segment(1) == 'invois')
        {
            $id = Crypt::decryptString($data_id);
            $bil = Bil::where('id', $id)->first();

            if(empty($bil))
            {
                abort(404);
            }
            
            $data['bil'] = $bil;
            return view($this->baseView . 'invois')->with($data);
        } 

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $bil_id)
    {
        $yuran = Yuran::find($id);
        $data['title'] = $yuran->nama;
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            $yuran->nama => false,
        ];
        $data['page_title'] = 'Kemaskini Bil & Bayaran';
        $data['action'] = route($this->baseRoute.'update', [$id, $bil_id]);
        $data['yuran'] = $yuran;
        $data['model'] = Bil::find($bil_id);
        $data['pelajar'] = Pelajar::limit(10)->pluck('nama', 'id')->toArray();
        $data['status'] = Bil::getStatusSelection();
        $data['bayaran'] = Bayaran::where('bil_id', $bil_id)->first();

        return view($this->baseView.'form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $bil_id)
    {
        $validation = $request->validate([
            'status' => 'required',
            'bayaran_date' => ($request->status == 2) ? 'required' : '',
            'bayaran_description' => ($request->status == 2) ? 'required' : '',
        ], [
            'status.required' => 'Sila pilih status bayaran',
            'bayaran_date.required' => 'Sila pilih tarikh bayaran',
            'bayaran_description.required' => 'Sila tulis keterangan bayaran',
        ]);

        $result = true;
        try {
            DB::transaction(function () use ($request, $id, $bil_id) {

                $yuran = Yuran::find($id);
                $bil = Bil::find($bil_id);
                if (! empty($bil)) {
                    $bil->status = $request->status;
                    if ($bil->status == 3) {
                        $bil->remarks = $request->reject_reason;
                    }
                    $bil->save();
                }

                if ($request->status == 2 && ! empty($request->bayaran_date) && ! empty($request->bayaran_description)) {
                    $count_bayaran = Bayaran::count();
                    $no_bayaran = sprintf('%04d', $count_bayaran + 1);

                    $bayaran = Bayaran::where('bil_id', $bil->id)->first();
                    if (empty($bayaran)) {
                        $bayaran = new Bayaran;
                    }
                    $bayaran->doc_no = 'RCPT'.$no_bayaran;
                    $bayaran->bil_id = $bil->id;
                    $bayaran->pelajar_id = $bil->pelajar_id;
                    $bayaran->pemohon_id = $bil->pemohon_id;
                    $bayaran->permohonan_sijil_tahfiz_id = $bil->permohonan_sijil_tahfiz_id;
                    $bayaran->yuran_id = $bil->yuran_id;
                    $bayaran->date = $request->bayaran_date;
                    $bayaran->description = $request->bayaran_description;
                    $bayaran->save();

                    $datetime_now = strtotime(now());

                    if (! empty($request->bayaran_gambar)) {
                        $image = [];

                        $file = $request->bayaran_gambar;
                        $original_name = $file->getClientOriginalName();
                        $file_name = pathinfo($original_name, PATHINFO_FILENAME);
                        $extension = pathinfo($original_name, PATHINFO_EXTENSION);
                        $file_name = $aduan->id.'_'.$file_name.'_'.$datetime_now.'.'.$extension;
                        $file_path = 'bayaran/'.$file_name;
                        Storage::disk('local')->put('public/'.$file_path, fopen($file, 'r+'), 'public');

                        $image['image_name'] = $file_name;
                        $image['image_path'] = $file_path;

                        $bayaran->gambar = json_encode($image);
                        $bayaran->save();
                    }
                }
            });

        } catch (\Exception $e) {
            $result = false;
        }

        if ($result) {

            $bil = Bil::find($bil_id);
            $bayaran = Bayaran::where('bil_id', $bil_id)->first();
            if ($bil->status == 2 && ! empty($bayaran)) {
                event(new BayaranYuranEvent($bil, $bayaran));
            }

            Alert::toast('Maklumat bil & bayaran berjaya dikemaskini', 'success');

            return redirect(route($this->baseRoute.'edit', [$id, $bil_id]));
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
        //
    }
}
