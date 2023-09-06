<?php

namespace App\Http\Controllers\Pengurusan\Akademik\eLearning;

use App\Http\Controllers\Controller;
use App\Models\ELearning\ELearningQuestion;
use App\Models\ELearning\ELearningQuestionOption;
use App\Models\ELearning\ELearningQuestionType;
use App\Models\ELearning\ELearningQuiz;
use App\Models\ELearning\ELearningSyllabus;
use App\Models\Kursus;
use App\Models\Semester;
use App\Models\Subjek;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PengurusanUjianAtasTalianController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.e_learning.pengurusan_ujian_atas_talian.';
    protected $baseRoute = 'pengurusan.akademik.e_learning.pengurusan_ujian_atas_talian.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        // try {

            $title = 'Pengurusan Ujian/Kuiz Atas Talian';
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => false,
                'Pengurusan Ujian/Kuiz Atas Talian' => false,
            ];

            $buttons = [
                [
                    'title' => 'Tambah Kuiz/Ujian',
                    'route' => route($this->baseRoute . 'create'),
                    'button_class' => 'btn btn-sm btn-primary fw-bold',
                    'icon_class' => 'fa fa-plus-circle',
                ],
            ];

            if (request()->ajax()) {
                $data = ELearningQuiz::with('kursus', 'semester')->where('deleted_at', null)->where('status', 1);

                return DataTables::of($data)
                    ->addColumn('kursus_id', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('semester_id', function ($data) {
                        return $data->semester->nama ?? null;
                    })
                    ->addColumn('created_by', function ($data) {
                        return $data->createdBy->nama ?? null;
                    })
                    ->addColumn('status', function ($data) {
                        if ($data->status == 0) {
                            return 'Aktif';
                        } elseif ($data->status == 1) {
                            return 'Tidak Aktif';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a href="'.route($this->baseRoute . 'add_question', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Tambah Soalan">
                                <i class="fa-solid fa-plus-circle"></i>
                            </a>
                            <a href="'.route($this->baseRoute . 'edit', $data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route($this->baseRoute . 'destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
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
                    ['data' => 'name', 'name' => 'name', 'title' => 'Nama Kuiz', 'orderable' => false],
                    ['data' => 'kursus_id', 'name' => 'subjek', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'semester_id', 'name' => 'kursus', 'title' => 'Semester', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            $courses = Subjek::select('id', 'nama', 'kod_subjek')->where('deleted_at', null)->where('status', 1)->get();
            $semesters = Semester::where('deleted_at', NULL)->pluck('nama', 'id');

            return view($this->baseView.'main', compact('title', 'breadcrumbs', 'dataTable', 'courses', 'semesters', 'buttons'));

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $title = 'Pengurusan Ujian/Kuiz Atas Talian';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Tambah Ujian/Kuiz';
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => false,
                'Pengurusan Ujian/Kuiz Atas Talian' => route($this->baseRoute . 'store'),
                'Tambah Ujian/Kuiz' => false
            ];

            $model = new ELearningQuiz();

            $courses = Subjek::select('id', 'nama', 'kod_subjek')->where('deleted_at', null)->where('status', 1)->get();
            $semesters = Semester::where('deleted_at', NULL)->pluck('nama', 'id');
            $syllabi = ELearningSyllabus::where('status', 0)->pluck('nama', 'id');

            return view($this->baseView.'create', compact('title', 'action', 'page_title', 'breadcrumbs', 'model', 'courses', 'semesters', 'syllabi'));

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
        try {

            $data = new ELearningQuiz();
            $data->kursus_id    = $request->kursus;
            $data->e_learning_syllabi_id = $request->syllabi;
            $data->semester_id  = $request->semester;
            $data->name         = $request->nama;
            $data->description  = $request->description;
            $data->total_mark   = $request->markah_penuh;
            $data->minimum_mark = $request->markah_lulus;
            $data->status       = $request->status;
            //$data->created_by   = auth()->user()->id;
            $data->save();

            Alert::toast('Kuiz berjaya dicipta!', 'success');

            return redirect()->route($this->baseRoute . 'index');

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

            $title = 'Pengurusan Ujian/Kuiz Atas Talian';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Kemaskini Ujian/Kuiz';
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => false,
                'Pengurusan Ujian/Kuiz Atas Talian' => route($this->baseRoute . 'store'),
                'Kemaskini Ujian/Kuiz' => false
            ];

            $model = ELearningQuiz::find($id);

            $courses = Subjek::select('id', 'nama', 'kod_subjek')->where('deleted_at', null)->where('status', 1)->get();
            $semesters = Semester::where('deleted_at', NULL)->pluck('nama', 'id');
            $syllabi = ELearningSyllabus::where('status', 0)->pluck('nama', 'id');

            return view($this->baseView.'create', compact('title', 'action', 'page_title', 'breadcrumbs', 'model', 'courses', 'semesters', 'syllabi'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
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
        try {

            $data = ELearningQuiz::find($id);
            $data->kursus_id    = $request->kursus;
            $data->e_learning_syllabi_id = $request->syllabi;
            $data->semester_id  = $request->semester;
            $data->name         = $request->nama;
            $data->description  = $request->description;
            $data->total_mark   = $request->markah_penuh;
            $data->minimum_mark = $request->markah_lulus;
            $data->status       = $request->status;
            $data->created_by   = auth()->user()->id ?? 1;
            $data->save();

            Alert::toast('Kuiz berjaya dikemaskini!', 'success');

            return redirect()->route($this->baseRoute . 'index');

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

            $question = ELearningQuestion::where('quiz_id', $id)->first();
            if(!empty($question))
            {
                ELearningQuestionOption::where('question_id', $question->id)->delete();
                $question = $question->delete();
            }
            
            ELearningQuiz::find($id)->delete();

            Alert::toast('Soalan berjaya dibuang!', 'success');

            return redirect()->back();
        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function addQuestion($id, Builder $builder)
    {
        try {
            $quiz = ELearningQuiz::find($id);

            $title = 'Pengurusan Ujian/Kuiz Atas Talian';
            $action = route($this->baseRoute . 'store_question', $id);
            $page_title = 'Tambah Soalan bagi ' . $quiz->name;
            $breadcrumbs = [
                'Akademik' => false,
                'E-Learning' => false,
                'Pengurusan Ujian/Kuiz Atas Talian' => route($this->baseRoute . 'store'),
                'Tambah Soalan' => false
            ];

            $types = ELearningQuestionType::pluck('name', 'id');

            if (request()->ajax()) {
                $data = ELearningQuestion::with('questionType', 'questionOptions')->where('quiz_id', $id);

                return DataTables::of($data)
                    ->addColumn('question_type_id', function ($data) {
                        if($data->question_type_id == 1)
                        {
                            return 'Soalan Aneka Pilihan Satu Jawapan';
                        }
                        elseif($data->question_type_id == 2)
                        {
                            return 'Soalan Aneka Pilihan Banyak Jawapan';
                        }
                        else {
                            return 'Soalan Isi Tempat Kosong';
                        }
                        return $data->questionType->name ?? null;
                    })
                    ->addColumn('answer', function ($data) {
                        $options = ELearningQuestionOption::where('question_id', $data->id)->get();

                        $answer = '';
                        foreach($options as $option)
                        {
                            $answer . '</br>';
                            if($option->is_correct == 1)
                            {
                                $answer .= 'Jawapan : ' .$option->name . ' [Jawapan Betul : Ya] </br>';
                            }
                            else {
                                $answer .= 'Jawapan : ' .$option->name . ' [Jawapan Betul : Tidak] </br>';
                            }
                            
                        }
                        
                        return $answer;
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id.')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route($this->baseRoute . 'delete_question', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            ';
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action', 'answer', 'name'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'name', 'name' => 'name', 'title' => 'Nama Soalan', 'orderable' => false],
                    ['data' => 'question_type_id', 'name' => 'question_type_id', 'title' => 'Jenis Soalan', 'orderable' => false],
                    ['data' => 'answer', 'name' => 'answer', 'title' => 'Jawapan', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

                ])
                ->minifiedAjax();

            return view($this->baseView.'create_question', compact('title', 'action', 'page_title', 'breadcrumbs', 'dataTable', 'types', 'id'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }

    public function storeQuestion($id, Request $request)
    {
        // try {

            $data = new ELearningQuestion();
            $data->name         = $request->soalan;
            $data->quiz_id      = $id;
            $data->question_type_id = $request->jenis;
            $data->is_active    = $request->status;
            $data->created_by   = auth()->user()->id ?? 1;
            $data->save();

            if($request->jenis == 1 || $request->jenis == 2)
            {
                foreach($request->data as $value)
                {
                    ELearningQuestionOption::create([
                        'question_id' => $data->id,
                        'name' => $value['name'],
                        'is_correct' => $value['is_correct']
                    ]);
                }
            }
            else {
                ELearningQuestionOption::create([
                    'question_id' => $data->id,
                    'name' => $request->jawapan,
                    'is_correct' => 1
                ]);
            }

            Alert::toast('Soalan berjaya dicipta!', 'success');

            return redirect()->back();

        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

    public function deleteQuestion($id)
    {
        // try {

            ELearningQuestionOption::where('question_id', $id)->delete();
            ELearningQuestion::find($id)->delete();

            Alert::toast('Soalan berjaya dibuang!', 'success');

            return redirect()->back();
        // } catch (Exception $e) {
        //     report($e);

        //     Alert::toast('Uh oh! Something went Wrong', 'error');

        //     return redirect()->back();
        // }
    }

}
