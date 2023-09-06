<?php

namespace App\Http\Controllers\Alumni\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Alumni\PermohonanSijilGanti;
use App\Models\Pelajar;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PermohonanSijilGantiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Permohonan Sjil Ganti';
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Sijil ganti (hilang/rosak)' => false,
            ];

            $buttons = [
                [
                    'title' => 'Permohonan Baru',
                    'route' => route('alumni.permohonan.sijil_ganti.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = PermohonanSijilGanti::where('user_id', auth()->user()->id);
                return DataTables::of($data)
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 0:
                                return '<span class="badge badge-primary">Dihantar untuk diproses</span>';

                            case 1:
                                return '<span class="badge badge-success">Selesai</span>';

                            case 2:
                                return '<span class="badge badge-danger">Ditolak</span>';
                        }
                    })
                    ->addColumn('created_at', function ($data) {
                        return date('d/m/Y', strtotime($data->created_at));
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="' . route('alumni.permohonan.sijil_ganti.show', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove(' . $data->id . ')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-' . $data->id . '" action="' . route('alumni.permohonan.sijil_ganti.destroy', $data->id) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['created_at', 'status', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view('pages.alumni.permohonan.sijil_ganti.main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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
            $title = 'Sijil Ganti';
            $action = route('alumni.permohonan.sijil_ganti.store');
            $page_title = 'Permohonan Sijil Ganti';
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Sijil Ganti' => route('alumni.permohonan.sijil_ganti.index'),
                'Mohon Sijil Ganti' => false,
            ];

            $pelajar = Pelajar::where('user_id', auth()->user()->id)->first();

            return view('pages.alumni.permohonan.sijil_ganti.create', compact('title', 'breadcrumbs', 'action', 'page_title', 'pelajar'));

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
        $request->validate([
            'nama' => 'required',
            'no_ic' => 'required',
            'no_matrik' => 'required',
            'laporan_polis' => 'required',
            'salinan_sijil' => 'nullable',
        ], [
            'nama.required' => 'Sila masukkan maklumat nama pemohon',
            'no_ic.required' => 'Sila masukkan nombor kad pengenalan / passport',
            'no_matrik.required' => 'Sila masukkan nombor matrik',
            'laporan_polis.required' => 'Sila sertakan laporan polis',
        ]);

        // get pelajar data
        $pelajar = Pelajar::where('user_id', auth()->user()->id)->first();


        $polisFile = $this->uploadFile($request->file('laporan_polis'));
        $qrFile = $this->uploadFile($request->file('kod_qr'));

        if (request()->has('salinan_sijil')) {
            $sijilFile = $this->uploadFile($request->file('salinan_sijil'));
        } else {
            $sijilFile = null;
        }

        // save data
        $data = new PermohonanSijilGanti();
        $data->user_id = auth()->user()->id;
        $data->pelajar_id = $pelajar->id;
        $data->no_ic = $request->no_ic;
        $data->no_matrik = $request->no_matrik;
        $data->nama = $request->nama;
        $data->status = 0; // defaulted to baru diterima
        $data->laporan_polis = $polisFile;
        $data->salinan_sijil = $sijilFile;
        $data->kod_qr = $qrFile;

        $data->save();

        Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');

        return redirect()->route('alumni.permohonan.sijil_ganti.index');
    }

    function uploadFile($file, $file_path = 'uploads/permohonan/sijil_ganti')
    {
        $file_extension = $file->getClientOriginalExtension();
        $file_name = uniqid() . '.' . $file_extension;
        $file->move($file_path, $file_name);
        $uploadedFilePath = $file_path . '/' . $file_name;
        return $uploadedFilePath;
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
            $title = 'Sijil Ganti';
            $page_title = 'Maklumat Permohonan Sijil Ganti';
            $breadcrumbs = [
                'Alumni' => false,
                'Permohonan' => false,
                'Sijil Ganti' => route('alumni.permohonan.sijil_ganti.index'),
                'Maklumat Permohonan Sijil Ganti' => false,
            ];

            $data = PermohonanSijilGanti::find($id);

            return view('pages.alumni.permohonan.sijil_ganti.show', compact('title', 'breadcrumbs', 'page_title', 'data'));

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
     * @param  \Illuminate\Http\Request  $request
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
        //
    }

    public function downloadFile($id, $type)
    {
        $download = PermohonanSijilGanti::find($id);

        if ($type === 'laporan_polis') {
            $filePath = $download->laporan_polis;
        } elseif ($type === 'salinan_sijil') {
            $filePath = $download->salinan_sijil;
        } elseif ($type === 'kod_qr') {
            $filePath = $download->kod_qr;
        } else {
            // Handle invalid type (e.g., return a 404 response)
            return response()->json(['error' => 'Invalid file type'], 404);
        }

        return response()->file(public_path($filePath));
    }

}