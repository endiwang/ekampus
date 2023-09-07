<?php

namespace App\Http\Controllers\Pelajar\eLearning;

use App\Events\QuizMarkEvent;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\ELearning\ELearningAnswer;
use App\Models\ELearning\ELearningQuestion;
use App\Models\ELearning\ELearningQuestionOption;
use App\Models\ELearning\ELearningQuiz;
use App\Models\ELearning\ELearningStudentMark;
use App\Models\ELearning\ELearningSyllabus;
use App\Models\Pelajar;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class UjianAtasTalianController extends Controller
{
    protected $baseView = 'pages.pelajar.e_learning.ujian_atas_talian.';
    protected $baseRoute = 'pelajar.e_learning.ujian_atas_talian.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {

            $title = 'Ujian/Kuiz Atas Talian';
            $breadcrumbs = [
                'Pelajar' => false,
                'E-Learning' => false,
                'Ujian Atas Talian' => false,
            ];

            //get pelajar kursus
            $student_id = auth()->user()->id;
            $pelajar = Pelajar::select('kursus_id', 'kelas_id')->where('user_id', $student_id)->first();
            //get current semester
            $current_sem = Utils::getCurrenSemester($pelajar->kursus_id);

            if (request()->ajax()) {
                $data = ELearningQuiz::with('kursus', 'semester', 'syllabus')->where('kursus_id', $pelajar->kursus_id)
                        ->where('semester_id', $current_sem->semester_no)
                        ->where('status', 1);

                return DataTables::of($data)
                    ->addColumn('kursus', function ($data) {
                        return $data->kursus->nama ?? null;
                    })
                    ->addColumn('pembelajaran', function ($data) {
                        return $data->syllabus->nama ?? null;
                    })
                    ->addColumn('subjek', function ($data) {
                        return $data->subjek->nama ?? null;
                    })
                    ->addColumn('created_by', function ($data) {
                        return $data->createdBy->nama ?? null;
                    })
                    ->addColumn('markah', function ($data) use($student_id){
                        $mark = ELearningStudentMark::select('student_id', 'quiz_id', 'total_mark')
                                ->where('student_id', $student_id)
                                ->where('quiz_id', $data->id)
                                ->first();
                            
                        return !empty($mark->total_mark) ? number_format($mark->total_mark) : '<span class="badge badge-danger">BELUM JAWAB</span>';
                    })
                    ->addColumn('markah_penuh', function ($data) use($student_id){
                        return $data->total_mark ?? null;
                    })
                    ->addColumn('action', function ($data) use ($student_id) {
                        $mark = ELearningStudentMark::select('student_id', 'quiz_id', 'total_mark')
                                ->where('student_id', $student_id)
                                ->where('quiz_id', $data->id)
                                ->first();

                        if(empty($mark->total_mark))
                        {
                            return '
                            <a href="'.route($this->baseRoute . 'show', $data->id).'" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Jawab Kuiz">
                                <i class="fa fa-eye"></i>
                            </a>
                            ';
                        }
                        else {
                            return '
                            <a href="#" class="edit btn btn-icon btn-info btn-sm hover-elevate-up mb-1 disabled" data-bs-toggle="tooltip" title="Jawab Kuiz">
                                <i class="fa fa-eye"></i>
                            </a>
                            '; 
                        }
                    })
                    ->addIndexColumn()
                    ->order(function ($data) {
                        $data->orderBy('id', 'desc');
                    })
                    ->rawColumns(['action', 'markah'])
                    ->toJson();
            }

            $dataTable = $builder
                ->columns([
                    ['defaultContent' => '', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'Bil', 'orderable' => false, 'searchable' => false],
                    ['data' => 'name', 'name' => 'name', 'title' => 'Nama Kuiz', 'orderable' => false],
                    ['data' => 'pembelajaran', 'name' => 'pembelajaran', 'title' => 'Pembelajaran', 'orderable' => false],
                    ['data' => 'kursus', 'name' => 'kursus', 'title' => 'Kursus', 'orderable' => false],
                    ['data' => 'markah', 'name' => 'markah', 'title' => 'Markah', 'orderable' => false],
                    ['data' => 'markah_penuh', 'name' => 'markah_penuh', 'title' => 'Markah Penuh', 'orderable' => false],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Tindakan', 'orderable' => false, 'class' => 'text-bold', 'searchable' => false],

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $student_id = auth()->user()->id;;
            //check with option answer to get overall mark
            if(!empty($request->data['radio_answer']))
            {
                foreach($request->data['radio_answer'] as $key => $value)
                {
                    ELearningAnswer::create([
                        'quiz_id'       => $request->quiz_id,
                        'question_id'   => $key,
                        'student_id'    => $student_id,
                        'answer'        => $value,
                        'question_option_id' => $value
                    ]);

                }
            }

            if(!empty($request->data['checkboxanswer']))
            {
                foreach($request->data['checkboxanswer'] as $checkbox)
                {
                    foreach($checkbox as $key => $value)
                    {
                        ELearningAnswer::create([
                            'quiz_id'       => $request->quiz_id,
                            'question_id'   => $key,
                            'student_id'    => $student_id,
                            'answer'        => $value,
                            'question_option_id' => $value
                        ]);
                    }
                    
                }
            }

            if(!empty($request->data['textanswer']))
            {
                foreach($request->data['textanswer'] as $key => $value)
                {
                    //get question option -id
                    $qs_option_id = ELearningQuestionOption::where('question_id', $key)->first();

                    ELearningAnswer::create([
                        'quiz_id'       => $request->quiz_id,
                        'question_id'   => $key,
                        'student_id'    => $student_id,
                        'answer'        => $value,
                        'question_option_id' => $qs_option_id->id,
                    ]);
                }
            }

            //calculate total quiz mark
            
            $quiz_id = $request->quiz_id;

            event(new QuizMarkEvent($student_id, $quiz_id));
            
            Alert::toast('Kuiz berjaya dihantar! Markah anda sedang dikira', 'success');

            //redirect to view keputusan page
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
        try {

            $quiz_data = ELearningQuiz::find($id);

            $title = 'Ujian/Kuiz Atas Talian';
            $action = route($this->baseRoute . 'store');
            $page_title = 'Kuiz : ' . $quiz_data->name;
            $breadcrumbs = [
                'Pelajar' => false,
                'E-Learning' => false,
                'Ujian/Kuiz Atas Talian' => route($this->baseRoute . 'index'),
                'Jawab Ujian/Kuiz' => false
            ];

            $date = Utils::formatDate(Carbon::now());
            $models = ELearningQuestion::with('questionOptions')->where('quiz_id', $id)->get();

            return view($this->baseView.'show', compact('title', 'action', 'page_title', 'breadcrumbs', 'models' , 'quiz_data', 'date'));

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

    public function keputusan($student_id, $quiz_id)
    {
        try {

            $quiz = ELearningQuiz::find($quiz_id);

            $title = 'Ujian/Kuiz Atas Talian';
            $page_title = 'Markah Bagi : ' . $quiz->name;
            $breadcrumbs = [
                'Pelajar' => false,
                'E-Learning' => false,
                'Ujian/Kuiz Atas Talian' => route($this->baseRoute . 'index'),
                'Keputusan Ujian/Kuiz' => false
            ];

            $model = ELearningStudentMark::where('student_id', $student_id)->where('quiz_id', $quiz_id)->first();

            return view($this->baseView.'keputusan', compact('title', 'page_title', 'breadcrumbs', 'model', 'quiz'));

        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');

            return redirect()->back();
        }
    }
}
