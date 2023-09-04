<?php

namespace App\Http\Controllers\Pengurusan\Kewangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class KelulusanProgramController extends Controller
{
    protected $baseView = 'pages.pengurusan.kewangan.kelulusan_program.';

    protected $baseRoute = 'pengurusan.kewangan.kelulusan_program.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {

            $data = collect(
                [
                    [
                        'id' => 1,
                        'pelajar' => 'ZUNAIDDIN BIN IBRAHIM',
                        'nama_program' => 'Lorem ipsum dolor sit amet.',
                        'bajet_kewangan' => '400',
                        'status_kewangan' => '<span class="badge py-3 px-4 fs-7 badge-warning">Menunggu Kelulusan</span>',
                        'status' => 0,
                        'tarikh_permohonan' => '2023-08-25',
                    ],
                    [
                        'id' => 1,
                        'pelajar' => 'Amirul Aiman',
                        'nama_program' => 'Lorem ipsum dolor sit amet.',
                        'bajet_kewangan' => '500',
                        'status_kewangan' => '<span class="badge py-3 px-4 fs-7 badge-warning">Menunggu Kelulusan</span>',
                        'status' => 0,
                        'tarikh_permohonan' => '2023-08-24',
                    ],
                    [
                        'id' => 1,
                        'pelajar' => 'AFAF BINTI GENARI@AZHARI',
                        'nama_program' => 'Lorem ipsum dolor sit amet.',
                        'bajet_kewangan' => '300',
                        'status_kewangan' => '<span class="badge py-3 px-4 fs-7 badge-danger">Tidak Diluluskan</span>',
                        'status' => 2,
                        'tarikh_permohonan' => '2023-08-24',
                    ],
                    [
                        'id' => 1,
                        'pelajar' => 'ZUNAIDDIN BIN IBRAHIM',
                        'nama_program' => 'Lorem ipsum dolor sit amet.',
                        'bajet_kewangan' => '100',
                        'status_kewangan' => '<span class="badge py-3 px-4 fs-7 badge-success">Lulus</span>',
                        'status' => 1,
                        'tarikh_permohonan' => '2023-08-20',
                    ],
                ]
            );

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $html = '';

                    if (empty($data['status'])) {
                        $html .= '<a href="javascript:void(0)" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1 btn-edit-kelulusan" data-bs-toggle="tooltip" title="Pinda" data-url="'.route($this->baseRoute.'edit', $data['id']).'" data-action="'.route($this->baseRoute.'update', $data['id']).'"><i class="fa fa-pencil-alt"></i></a> ';
                    }

                    return $html;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'status_kewangan'])
                ->toJson();
        }

        $dataTable = $builder
            ->parameters([])
            ->columns([
                ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                ['data' => 'pelajar', 'name' => 'pelajar', 'title' => 'Nama Pelajar', 'orderable' => false],
                ['data' => 'nama_program', 'name' => 'program', 'title' => 'Nama Program', 'orderable' => false],
                ['data' => 'bajet_kewangan', 'name' => 'bajet', 'title' => 'Bajet Diperlukan', 'orderable' => false],
                ['data' => 'status_kewangan', 'name' => 'status', 'title' => 'Status Kelulusan', 'orderable' => false],
                ['data' => 'tarikh_permohonan', 'name' => 'status', 'title' => 'Tarikh Permohonan', 'orderable' => false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],

            ])
            ->minifiedAjax();

        $data['dataTable'] = $dataTable;

        $data['title'] = 'Kelulusan Program';
        $data['breadcrumbs'] = [
            'Kewangan' => false,
            'Kelulusan Program' => false,
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
        $data = [];

        return view($this->baseView.'form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Alert::toast('Maklumat yuran berjaya dikemaskini', 'success');

        return redirect(route($this->baseRoute.'index'));
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
