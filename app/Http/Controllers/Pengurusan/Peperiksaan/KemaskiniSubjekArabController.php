<?php

namespace App\Http\Controllers\Pengurusan\Peperiksaan;

use App\Http\Controllers\Controller;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KemaskiniSubjekArabController extends Controller
{
    protected $baseView = 'pages.pengurusan.peperiksaan.subjek_arab.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {
            $title = 'Senarai Maklumat Subjek';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Subjek' => false,
            ];

            if (request()->ajax()) {
                $data = Subjek::query();
                if ($request->has('program_pengajian') && $request->program_pengajian != null) {
                    $data->where('nama', 'LIKE', '%'.$request->program_pengajian.'%');
                }

                return DataTables::of($data)
                    ->addColumn('nama_arab', function ($data) {
                        return $data->nama_arab ?? null;
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
                        return '<a href="'.route('pengurusan.peperiksaan.kemaskini.subjek_arab.edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('nama', 'asc');
                    })
                    ->rawColumns(['status', 'action', 'nama_arab'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek', 'orderable' => false],
                    ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'nama_arab', 'name' => 'nama_arab', 'title' => 'Subjek Arab', 'orderable' => false],
                    ['data' => 'maklumat_tambahan', 'name' => 'maklumat_tambahan', 'title' => 'Maklumat', 'orderable' => false],
                    ['data' => 'kredit', 'name' => 'kredit', 'title' => 'Kredit', 'orderable' => false],
                    ['data' => 'status', 'name' => 'kelas', 'title' => 'Status', 'orderable' => false, 'class' => 'text-bold'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable'));

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

            $title = 'Kemaskini Subjek Arab';
            $action = route('pengurusan.peperiksaan.kemaskini.subjek_arab.update', $id);
            $page_title = 'Kemaskini Maklumat Subjek';
            $breadcrumbs = [
                'Peperiksaan' => false,
                'Kemaskini' => false,
                'Senarai Maklumat Subjek' => route('pengurusan.peperiksaan.kemaskini.subjek_arab.index'),
                'Kemaskini Maklumat Subjek' => false,
            ];

            $model = Subjek::find($id);

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title', 'action'));

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
        // try {

        $update = Subjek::find($id);
        $update->nama = $request->nama_subjek;
        $update->kod_subjek = $request->kod_subjek;
        $update->nama_arab = $request->description;
        $update->maklumat_tambahan = $request->kenyataan;
        $update->save();

        Alert::toast('Maklumat subjek berjaya dikemaskini!', 'success');

        return redirect()->route('pengurusan.peperiksaan.kemaskini.subjek_arab.index');

        // }catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
