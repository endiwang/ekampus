<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\JabatanMurajaahHarian;
use App\Models\Pelajar;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodMurajaahHarianController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Rekod Murajaah Harian';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Rekod Murajaah Harian' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Rekod Murajaah Harian',
                    'route' => route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = JabatanMurajaahHarian::with('pelajar');
                if ($request->has('nama_pelajar') && $request->nama_pelajar != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('nama', 'LIKE', '%'.$request->nama_pelajar.'%');
                    });
                }
                if ($request->has('no_matrik') && $request->no_matrik != null) {
                    $data = $data->whereHas('pelajar', function ($data) use ($request) {
                        $data->where('no_matrik', 'LIKE', '%'.$request->no_matrik.'%');
                    });
                }

                return DataTables::of($data)
                    ->addColumn('nama_pelajar', function ($data) {
                        return $data->pelajar->nama ?? null;
                    })
                    ->addColumn('no_matrik', function ($data) {
                        return $data->pelajar->no_matrik ?? null;
                    })
                    ->addColumn('created_at', function ($data) {
                        return Utils::formatDate($data->created_at) ?? null;
                    })
                    ->addColumn('current_percentage', function ($data) {
                        return number_format($data->current_percentage, 2) ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['document_name', 'sesi', 'action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'nama_pelajar', 'name' => 'nama_pelajar', 'title' => 'Nama Pelajar', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable' => false],
                    ['data' => 'surah', 'name' => 'surah', 'title' => 'surah', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'page_start', 'name' => 'page_start', 'title' => 'Mukasurat Mula', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'page_end', 'name' => 'page_end', 'title' => 'Mukasurat Akhir', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'total_page', 'name' => 'total_page', 'title' => 'Jumlah Mukasurat', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Rekod Dicipta', 'orderable' => false],
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

            $title = 'Tambah Rekod Murajaah Harian';
            $action = route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.store');
            $page_title = 'Maklumat Rekod Murajaah Harian';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Rekod Murajaah Harian' => route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index'),
                'Tambah Rekod Murajaah Harian' => false,
            ];

            $model = new JabatanMurajaahHarian();

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->where('is_tamat', 0)->where('deleted_at', null)->get();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'students'));

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
            'surah' => 'required',
            'juzuk' => 'required',
            'ayat_akhir' => 'required',
            'mukasurat_mula' => 'required',
            'mukasurat_akhir' => 'required',
            'jumlah_mukasurat' => 'required|integer',
        ], [
            'pelajar.required' => 'Sila pilih pelajar',
            'surah.required' => 'Sila masukkan maklumat surah',
            'juzuk.required' => 'Sila masukkan maklumat juzuk',
            'ayat_akhir.required' => 'Sila masukkan maklumat ayat akhir',
            'mukasurat_mula.required' => 'Sila masukkan maklumat mukasurat mula',
            'mukasurat_akhir.required' => 'Sila masukkan maklumat mukasurat akhir',
            'jumlah_mukasurat.required' => 'Sila masukkan maklumat jumla mukasurat',
        ]);

        try {
            $rekod = new JabatanMurajaahHarian();
            $rekod->pelajar_id = $request->pelajar;
            $rekod->surah = $request->surah;
            $rekod->juzuk = $request->juzuk;
            $rekod->ayat_akhir = $request->ayat_akhir;
            $rekod->page_start = $request->mukasurat_mula;
            $rekod->page_end = $request->mukasurat_akhir;
            $rekod->total_page = $request->jumlah_mukasurat;
            $rekod->created_by = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat rekod murajaah harian berjaya ditambah!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index');

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

            $title = 'Pinda Rekod Murajaah Harian';
            $action = route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.update', $id);
            $page_title = 'Maklumat Rekod Murajaah Harian';
            $breadcrumbs = [
                'Akademik' => false,
                'Pengurusan Jabatan' => false,
                'Rekod Rekod Murajaah Harian' => route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index'),
                'Pinda Rekod Murajaah Harian' => false,
            ];

            $model = JabatanMurajaahHarian::find($id);

            $students = Pelajar::where('is_register', 1)->where('is_berhenti', 0)->where('is_gantung', 0)->where('is_tamat', 0)->where('deleted_at', null)->get();

            return view($this->baseView.'add_edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'students'));

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
            'pelajar' => 'required',
            'surah' => 'required',
            'juzuk' => 'required',
            'ayat_akhir' => 'required',
            'mukasurat_mula' => 'required',
            'mukasurat_akhir' => 'required',
            'jumlah_mukasurat' => 'required|integer',
        ], [
            'pelajar.required' => 'Sila pilih pelajar',
            'surah.required' => 'Sila masukkan maklumat surah',
            'juzuk.required' => 'Sila masukkan maklumat juzuk',
            'ayat_akhir.required' => 'Sila masukkan maklumat ayat akhir',
            'mukasurat_mula.required' => 'Sila masukkan maklumat mukasurat mula',
            'mukasurat_akhir.required' => 'Sila masukkan maklumat mukasurat akhir',
            'jumlah_mukasurat.required' => 'Sila masukkan maklumat jumla mukasurat',
        ]);

        try {
            $rekod = JabatanMurajaahHarian::find($id);
            $rekod->pelajar_id = $request->pelajar;
            $rekod->surah = $request->surah;
            $rekod->juzuk = $request->juzuk;
            $rekod->ayat_akhir = $request->ayat_akhir;
            $rekod->page_start = $request->mukasurat_mula;
            $rekod->page_end = $request->mukasurat_akhir;
            $rekod->total_page = $request->jumlah_mukasurat;
            $rekod->created_by = auth()->user()->id;
            $rekod->save();

            Alert::toast('Maklumat rekod murajaah harian berjaya dikemaskini!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index');

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

            JabatanMurajaahHarian::find($id)->delete();

            Alert::toast('Maklumat rekod bertulis (tahriri) berjaya dihapuskan!', 'success');

            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.rekod_murajaah_harian.index');

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
