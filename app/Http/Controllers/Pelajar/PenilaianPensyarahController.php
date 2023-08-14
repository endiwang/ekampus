<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\JadualWaktu;
use App\Models\JadualWaktuDetail;
use App\Models\Pelajar;
use App\Models\SoalanPenilaian;
use App\Models\SoalanPenilaianAnswer;
use App\Models\SoalanPenilaianAnswerDetail;
use App\Models\SoalanPenilaianRating;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PenilaianPensyarahController extends Controller
{
    protected $baseView = 'pages.pelajar.penilaian_pensyarah.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        try {

            $title = 'Penilaian Pensyarah';
            $breadcrumbs = [
                'Pelajar' => false,
                'Penilaian Pensyarah' => false,
            ];

            $getClassId = Pelajar::select('kelas_id')->where('user_id', auth()->user()->id)->first();
            $getJadualId = JadualWaktu::where('kelas_id', $getClassId->kelas_id)->where('status_pengajian', 1)->first();

            if (request()->ajax()) {
                if (! empty($getJadualId)) {
                    $data = JadualWaktuDetail::with('subjek')->where('jadual_waktu_id', $getJadualId->id);
                } else {
                    $data = [];
                }

                return DataTables::of($data)
                    ->addColumn('kod_subjek', function ($data) {
                        return $data->subjek->kod_subjek ?? null;
                    })
                    ->addColumn('subjek', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('jam_kredit', function ($data) {
                        return $data->subjek->kredit ?? null;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route('pelajar.penilaian_pensyarah.show', $data->subjek_id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'kod_subjek', 'name' => 'kod_subjek', 'title' => 'Kod Subjek', 'orderable' => false],
                    ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Nama Subjek', 'orderable' => false],
                    ['data' => 'jam_kredit', 'name' => 'jam_kredit', 'title' => 'Jam Kredit', 'orderable' => false],
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
        try {

            foreach ($request->rating as $key => $value) {
                SoalanPenilaianAnswer::updateOrCreate([
                    'subjek_id' => $request->subjek_id,
                    'kelas_id' => $request->kelas_id,
                    'soalan_penilaian_id' => $key,
                    'submitted_by' => $request->student_id,
                ], [
                    'score' => $value,
                ]);
            }

            //save into comment table
            SoalanPenilaianAnswerDetail::updateOrCreate([
                'subjek_id' => $request->subjek_id,
                'submitted_by' => $request->student_id,
            ], [
                'comment' => $request->comment,
            ]);

            Alert::toast('Maklumat penilaian berjaya dihantar!', 'success');

            return redirect()->route('pelajar.penilaian_pensyarah.index');

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

            $title = 'Kemaskini Maklumat Penilaian Pengajaran dan Pembelajaran';
            $page_title = 'Penilaian Pensyarah';
            $action = route('pelajar.penilaian_pensyarah.store');
            $breadcrumbs = [
                'Pelajar' => false,
                'Penilaian' => false,
                'Penilaian Pensyarah' => route('pelajar.penilaian_pensyarah.index'),
                'Kemaskini Maklumat Penilaian Pengajaran dan Pembelajaran' => false,
            ];

            $models = SoalanPenilaianAnswer::where('subjek_id', $id)->where('submitted_by', auth()->user()->id)->get();

            $answers = [];
            foreach ($models as $model) {
                $answers[$model->soalan_penilaian_id] = $model->score;
            }

            $comment = SoalanPenilaianAnswerDetail::where('subjek_id', $id)->where('submitted_by', auth()->user()->id)->first();

            $datas = SoalanPenilaian::all();
            $ratings = SoalanPenilaianRating::all();

            $subjek = Subjek::find($id);
            $student_detail = Pelajar::with('kelas')->where('user_id', auth()->user()->id)->first();

            $subjek_detail = JadualWaktuDetail::with('staff')->where('subjek_id', $id)->first();

            $submitted_by = auth()->user()->id;

            return view($this->baseView.'create-update', compact(
                'title',
                'breadcrumbs',
                'page_title',
                'action',
                'answers',
                'datas',
                'ratings',
                'id',
                'subjek',
                'student_detail',
                'subjek_detail',
                'comment',
                'submitted_by'
            ));

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
        //
    }
}
