<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanJabatan;

use App\Http\Controllers\Controller;
use App\Models\JadualWaktu;
use App\Models\Pelajar;
use App\Models\PenilaianBerterusanItem;
use App\Models\PenilaianBerterusanMark;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianBerterusanController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = "Penilaian Berterusan";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan" =>  false,
                "Penilaian Berterusan" =>  false,
            ];

            if (request()->ajax()) {
                $data = Subjek::where('deleted_at', NULL);
                if($request->has('nama_subjek') && $request->nama_subjek != NULL)
                {
                    $data->where('nama', 'LIKE', '%'. $request->nama_subjek . '%');
                }
                if($request->has('kod_subjek') && $request->kod_subjek != NULL)
                {
                    $data->where('kod_subjek', 'LIKE', '%'. $request->kod_subjek . '%');
                }

                return DataTables::of($data)
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.show',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Lihat Pelajar">
                                <i class="fa fa-eye"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('nama', 'asc');
                })
                ->rawColumns(['action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek', 'orderable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Subjek', 'orderable'=> false ],
                ['data' => 'kredit', 'name' => 'kredit', 'title' => 'Kredit', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // try {

            foreach($request->marks as $key => $value)
            {
                PenilaianBerterusanMark::updateOrCreate([
                    'student_id' => $request->pelajar_id,
                    'subjek_id' => $request->subjek_id,
                    'penilaian_berterusan_component_id' => $key
                ],[
                    'peratus_markah' => $value
                ]);
            }

            Alert::toast('Berjaya kemaskini markah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.show', $request->subjek_id);

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Builder $builder, Request $request)
    {
        // try {

            $title = "Penilaian Berterusan";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan" =>  false,
                "Penilaian Berterusan" =>  false,
            ];

            //get subjek kelas
            $kelas_ids = JadualWaktu::whereHas('jadualWaktuDetail', function ($q) use ($id) {
                $q->where('subjek_id', $id);
            })->pluck('id')->toArray();

            $pelajar = Pelajar::with('syukbah', 'kelas')->whereIn('kelas_id', $kelas_ids)->where('is_berhenti', 0)->get();

            if (request()->ajax()) {
                $data = Pelajar::with('syukbah', 'kelas')->whereIn('kelas_id', $kelas_ids)->where('is_berhenti', 0);
                if($request->has('nama_pelajar') && $request->nama_pelajar != NULL)
                {
                    $data->where('nama', 'LIKE', '%'. $request->nama_pelajar . '%');
                }
                if($request->has('no_matrik') && $request->no_matrik != NULL)
                {
                    $data->where('no_matrik', 'LIKE', '%'. $request->no_matrik . '%');
                }

                return DataTables::of($data)
                ->addColumn('syukbah', function($data) {
                   return $data->syukbah->nama ?? null;
                })
                ->addColumn('kelas_id', function($data) {
                    return $data->kelas->nama ?? null;
                 })
                ->addColumn('action', function($data) use ($id){
                    return '
                            <a href="'.route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.markah', [$data->id, $id, $data->kelas_id]).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Markah Penilaian">
                                <i class="fa fa-plus"></i>
                            </a>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('nama', 'asc');
                })
                ->rawColumns(['action'])
                ->toJson();
            }
    
            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'no_matrik', 'name' => 'no_matrik', 'title' => 'No Matrik', 'orderable'=> false],
                ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama Pelajar', 'orderable'=> false ],
                ['data' => 'syukbah', 'name' => 'syukbah', 'title' => 'Syukbah', 'orderable'=> false],
                ['data' => 'kelas_id', 'name' => 'kelas_id', 'title' => 'Kelas', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
    
            ])
            ->minifiedAjax();
    
            return view($this->baseView.'show', compact('title', 'breadcrumbs', 'dataTable', 'id'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $subjek_id, $kelas_id)
    {
        // try {

            $title = "Penilaian Berterusan";
            $page_title = "Markah Penilaian Berterusan";
            $action = route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.store');
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan" =>  false,
                "Penilaian Berterusan" =>  route('pengurusan.akademik.pengurusan_jabatan.penilaian_berterusan.show',$subjek_id),
                "Markah Penilaian Berterusan" => false,
            ];

            $items = PenilaianBerterusanItem::with('components')->where('subjek_id', $subjek_id)->get();

            return view($this->baseView.'edit', compact('title', 'page_title', 'breadcrumbs', 'action', 'subjek_id', 'kelas_id', 'id', 'items'));


            // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');
        //     return redirect()->back();
        // }
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
}
