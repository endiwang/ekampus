<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\PelepasanKuliah;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PelepasanKuliahController extends Controller
{
    protected $baseView = 'pages.pelajar.permohonan.pelepasan_kuliah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Pelepasan Kuliah';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Pelepasan Kuliah' => false,
            ];

            $buttons = [
                [
                    'title' => 'Permohonan Baru',
                    'route' => route('pelajar.permohonan.pelepasan_kuliah.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = PelepasanKuliah::where('user_id', auth()->user()->id);

                return DataTables::of($data)
                    ->addColumn('tarikh', function ($data) {
                        $tarikh = Utils::formatDate($data->tarikh_mula).' - '.Utils::formatDate($data->tarikh_akhir);

                        return $tarikh;
                    })
                    ->addColumn('status', function ($data) {
                        switch ($data->status) {
                            case 1:
                                return 'Baru Diterima';
                                break;

                            case 2:
                                return 'Dalam Proses';
                                break;

                            case 3:
                                return 'Lulus';
                                break;

                            case 4:
                                return 'Tolak';
                                break;
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pelajar.permohonan.pelepasan_kuliah.show', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.pelepasan_kuliah.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
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
                    ['data' => 'nama_permohonan', 'name' => 'nama_permohonan', 'title' => 'Nama Permohonan', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Pelepasan', 'orderable' => false],
                    ['data' => 'jumlah_hari', 'name' => 'jumlah_hari', 'title' => 'Jumlah Hari', 'orderable' => false],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'buttons', 'dataTable'));

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

            $title = 'Pelepasan Kuliah';
            $action = route('pelajar.permohonan.pelepasan_kuliah.store');
            $page_title = 'Permohonan Pelepasan Kuliah';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Pelepasan Kuliah' => route('pelajar.permohonan.pelepasan_kuliah.index'),
                'Mohon Pelepasan Kuliah' => false,
            ];

            return view($this->baseView.'create', compact('title', 'breadcrumbs', 'action', 'page_title'));

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
        $request->validate([
            'nama_permohonan' => 'required',
            'tarikh_mula' => 'required',
            'tarikh_akhir' => 'required',
            'jumlah_hari' => 'required',
            'sebab_mohon' => 'required',
            'file' => 'required',
        ], [
            'nama_permohonan.required' => 'Sila masukkan maklumat nama permohonan',
            'tarikh_mula.required' => 'Sila pilih tarikh mula',
            'tarikh_akhir.required' => 'Sila pilih tarikh akhir',
            'jumlah_hari.required' => 'Sila masukkan jumlah hari',
            'sebab_mohon.required' => 'Sila masukkan sebab memohon',
            'file.required' => 'Sila masukkan deskripsi rekod aktiviti',
        ]);

        try {

            $student = Pelajar::where('user_id', auth()->user()->id)->first();

            $file_name = uniqid().'.'.$request->file->getClientOriginalExtension();
            $file_extension = $request->file->getClientOriginalExtension();
            $file_path = 'uploads/permohonan/pelepasan_kuliah';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path.'/'.$file_name;

            $data = new PelepasanKuliah();
            $data->nama_permohonan = $request->nama_permohonan;
            $data->student_id = $student->id ?? null;
            $data->user_id = auth()->user()->id;
            $data->jumlah_hari = $request->jumlah_hari;
            $data->tarikh_mula = Carbon::createFromFormat('d/m/Y', $request->tarikh_mula)->format('Y-m-d');
            $data->tarikh_akhir = Carbon::createFromFormat('d/m/Y', $request->tarikh_akhir)->format('Y-m-d');
            $data->sebab_permohonan = $request->sebab_mohon;
            $data->dokumen_sokongan = $file;
            $data->status = 1;
            $data->save();

            Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');

            return redirect()->route('pelajar.permohonan.pelepasan_kuliah.index');

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
        try {

            $title = 'Pelepasan Kuliah';
            $page_title = 'Maklumat Permohonan Pelepasan Kuliah';
            $breadcrumbs = [
                'Pelajar' => false,
                'Permohonan' => false,
                'Pelepasan Kuliah' => route('pelajar.permohonan.pelepasan_kuliah.index'),
                'Maklumat Permohonan Pelepasan Kuliah' => false,
            ];

            $data = PelepasanKuliah::find($id);

            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'page_title', 'data'));

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

            $data = PelepasanKuliah::find($id);

            if ($data->status != 1) {
                Alert::toast('Harap Maaf, Permohonan yang sedang diproses tidak boleh dihapuskan', 'error');

                return redirect()->back();
            }

            $delete = $data->delete();

            Alert::toast('Maklumat permohonan pelepasan kuliah berjaya dihapus!', 'success');

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function downloadFile($id)
    {
        $download = PelepasanKuliah::find($id);

        return response()->file(public_path($download->dokumen_sokongan));
    }

    public function downloadLetter($id)
    {
        try {
            $data = PelepasanKuliah::with('pelajar', 'pelajar.kursus', 'pelajar.semester')->find($id);
            $export_data = [
                'data' => $data,
                'date' => Utils::formatDate($data->tarikh_sokongan),
            ];
            $title = 'Surat Kebenaran Pelepasan Kuliah '.$data->pelajar->nama;

            $view_file = 'pages.pengurusan.akademik.permohonan.pelepasan_kuliah.export_pdf';
            $orientation = 'portrait';

            return Utils::pdfGenerate($title, $export_data, $view_file, $orientation);

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Sesuatu yang tidak diingini berlaku', 'error');

            return redirect()->back();
        }
    }
}
