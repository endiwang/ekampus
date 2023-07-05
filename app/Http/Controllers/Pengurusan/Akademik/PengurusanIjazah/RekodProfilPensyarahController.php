<?php

namespace App\Http\Controllers\Pengurusan\Akademik\PengurusanIjazah;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\IjazahProfilPensyarah;
use App\Models\IjazahProfilPensyarahDetail;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class RekodProfilPensyarahController extends Controller
{
    protected $baseView = 'pages.pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        try {    
            $title = "Rekod Profil Pensyarah";
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Profil Pensyarah" =>  false,
            ];

            $buttons = [
                [
                    'title' => "Tambah Rekod Profil Pensyarah",
                    'route' => route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];

            if (request()->ajax()) {
                $data = IjazahProfilPensyarah::where('deleted_at', NULL);
                if($request->has('nama_pensyarah') && $request->nama_pensyarah != NULL)
                {
                    $data = $data->where('lecturer_name', 'LIKE', '%' . $request->nama_pensyarah . '%');
                }
                if($request->has('id_pensyarah') && $request->id_pensyarah != NULL)
                {
                    $data = $data->where('lecturer_id', 'LIKE', '%' . $request->id_pensyarah . '%');
                }

                return DataTables::of($data)
                ->addColumn('action', function($data){
                    return '<a href="'.route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.edit',$data->id).'" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.destroy', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>';
                })
                ->addIndexColumn()
                ->order(function ($data) {
                    $data->orderBy('id', 'desc');
                })
                ->rawColumns(['uploaded_document', 'action'])
                ->toJson();
            }

            $dataTable = $builder
            ->columns([
                ['defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'lecturer_name', 'name' => 'lecturer_name', 'title' => 'Nama Pensyarah', 'orderable'=> false, 'class'=>'text-bold'],
                ['data' => 'lecturer_id', 'name' => 'lecturer_id', 'title' => 'ID Pensyarah', 'orderable'=> false],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

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

            $title = 'Tambah Rekod Profil Pensyarah';
            $action = route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.store');
            $page_title = 'Maklumat Rekod Profil Pensyarah';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Profil Pensyarah" =>  route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index'),
                "Tambah Rekod Profil Pensyarah" => false,
            ];

            $model = new IjazahProfilPensyarah();

            $nationalities = [
                1 => 'Warganegara',
                2 => 'Bukan Warganegara'
            ];

            $genders = [
                1 => 'Lelaki',
                2 => 'Perempuan'
            ];

            return view($this->baseView.'add', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'nationalities', 'genders'));


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
        $validation = $request->validate([
            'nama_pensyarah'    => 'required',
            'id_pensyarah'      => 'required',
            'jantina'           => 'required',
            'warganegara'       => 'required',
            'alamat_1'          => 'required',
            'poskod'            => 'required',
            'bandar'            => 'required',
            'negeri'            => 'required',
            'emel'              => 'required',
            'phone'             => 'required',
        ],[
            'nama_pensyarah.required'   => 'Sila masukkan maklumat nama pensyarah',
            'id_pensyarah.required'     => 'Sila masukkan maklumat id pensyarah',
            'jantina.required'          => 'Sila pilih jantina',
            'warganegara.required'      => 'Sila pilih warganegara',
            'alamat_1.required'         => 'Sila masukkan maklumat alamat 1',
            'poskod.required'           => 'Sila masukkan maklumat poskod',
            'bandar.required'           => 'Sila masukkan maklumat bandar',
            'negeri.required'           => 'Sila masukkan maklumat negeri',
            'emel.required'             => 'Sila masukkan maklumat emel',
            'phone.required'            => 'Sila masukkan maklumat no telefon',
        ]);
        
        try {
            
            $data = new IjazahProfilPensyarah();
            $data->lecturer_name    = $request->nama_pensyarah;
            $data->lecturer_id      = $request->id_pensyarah;
            $data->designation      = $request->jawatan;
            $data->gred             = $request->gred;
            $data->gender           = $request->jantina;
            $data->nationality      = $request->warganegara;
            $data->address_1        = $request->alamat_1;
            $data->address_2        = $request->alamat_2;
            $data->postcode         = $request->poskod;
            $data->city             = $request->bandar;
            $data->state            = $request->negeri;
            $data->email            = $request->emel;
            $data->phone            = $request->phone;
            $data->home             = $request->home;
            $data->office           = $request->office;
            $data->created_by       = auth()->user()->id;
            $data->save();

            foreach($request->data as $value)
            {
                if(!empty($value['file']))
                {

                    $file_name = uniqid() . '.' . $value['file']->getClientOriginalExtension();
                    $file_path = 'uploads/ijazah/profil_pensyarah';
                    $file = $value['file'];
                    $file->move($file_path, $file_name);
                    $file = $file_path . '/' .$file_name;

                    IjazahProfilPensyarahDetail::create([
                        'ijazah_profil_pensyarah_id'    => $data->id,
                        'file_name'                     => $value['file_name'],
                        'uploaded_document'             => $file,
                    ]);
                }    
            }

            Alert::toast('Maklumat rekod profil berjaya ditambah!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index');


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
    public function edit($id, Builder $builder)
    {
        try {

            $title = 'Pinda Rekod Profil Pensyarah';
            $action = route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.update', $id);
            $page_title = 'Maklumat Rekod Profil Pensyarah';
            $breadcrumbs = [
                "Akademik" =>  false,
                "Pengurusan Ijazah" =>  false,
                "Rekod Profil Pensyarah" =>  route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index'),
                "Pinda Rekod Profil Pensyarah" => false,
            ];

            $model = IjazahProfilPensyarah::find($id);

            $nationalities = [
                1 => 'Warganegara',
                2 => 'Bukan Warganegara'
            ];

            $genders = [
                1 => 'Lelaki',
                2 => 'Perempuan'
            ];

            if (request()->ajax()) {
                $data = IjazahProfilPensyarahDetail::where('ijazah_profil_pensyarah_id', $id);
                return DataTables::of($data)
                ->addColumn('created_at', function($data) {
                    return Utils::formatDate($data->created_at);
                })
                ->addColumn('action', function($data){
                    return '
                            <a href="'.route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.download',$data->id).'" class="btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" target="_blank" title="Lihat Dokumen">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <form id="delete-'.$data->id.'" action="'.route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.delete_file', $data->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="POST">
                            </form>';
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
                [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
                ['data' => 'file_name', 'name' => 'file_name', 'title' => 'Nama Fail', 'orderable'=> false, ],
                ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tarikh Muat Naik', 'orderable'=> false, ],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],
            ])
            ->minifiedAjax();

            return view($this->baseView.'edit', compact('model', 'title', 'breadcrumbs', 'page_title',  'action', 'id', 'dataTable', 'nationalities', 'genders'));


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
        $validation = $request->validate([
            'nama_pensyarah'    => 'required',
            'id_pensyarah'      => 'required',
            'jantina'           => 'required',
            'warganegara'       => 'required',
            'alamat_1'          => 'required',
            'poskod'            => 'required',
            'bandar'            => 'required',
            'negeri'            => 'required',
            'emel'              => 'required',
            'phone'             => 'required',
        ],[
            'nama_pensyarah.required'   => 'Sila masukkan maklumat nama pensyarah',
            'id_pensyarah.required'     => 'Sila masukkan maklumat id pensyarah',
            'jantina.required'          => 'Sila pilih jantina',
            'warganegara.required'      => 'Sila pilih warganegara',
            'alamat_1.required'         => 'Sila masukkan maklumat alamat 1',
            'poskod.required'           => 'Sila masukkan maklumat poskod',
            'bandar.required'           => 'Sila masukkan maklumat bandar',
            'negeri.required'           => 'Sila masukkan maklumat negeri',
            'emel.required'             => 'Sila masukkan maklumat emel',
            'phone.required'            => 'Sila masukkan maklumat no telefon',
        ]);
        
        try {
            
            $data = IjazahProfilPensyarah::find($id);
            $data->lecturer_name    = $request->nama_pensyarah;
            $data->lecturer_id      = $request->id_pensyarah;
            $data->designation      = $request->jawatan;
            $data->gred             = $request->gred;
            $data->gender           = $request->jantina;
            $data->nationality      = $request->warganegara;
            $data->address_1        = $request->alamat_1;
            $data->address_2        = $request->alamat_2;
            $data->postcode         = $request->poskod;
            $data->city             = $request->bandar;
            $data->state            = $request->negeri;
            $data->email            = $request->emel;
            $data->phone            = $request->phone;
            $data->home             = $request->home;
            $data->office           = $request->office;
            $data->created_by       = auth()->user()->id;
            $data->save();

            Alert::toast('Maklumat rekod profil berjaya dikemaskini!', 'success');
            return redirect()->back();


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

            $data_pensyarah = IjazahProfilPensyarah::find($id);

            $data_fail_pensyarah = IjazahProfilPensyarahDetail::where('ijazah_profil_pensyarah_id', $id)->delete();

            $delete = $data_pensyarah->delete();

            Alert::toast('Rekod maklumat profil pensyarah berjaya dihapuskan!', 'success');
            return redirect()->route('pengurusan.akademik.pengurusan_ijazah.profil_pensyarah.index');


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function deleteFile($id)
    {
        try {

            IjazahProfilPensyarahDetail::find($id)->delete();

            Alert::toast('Rekod maklumat dokumen tambahan berjaya dihapuskan!', 'success');
            return redirect()->back();


        } catch (Exception $e) {
            report($e);

            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function uploadFile($id, Request $request)
    {
        try {
            $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
            $file_extension = $request->file->getClientOriginalExtension();
            $file_path = 'uploads/ijazah/profil_pensyarah';
            $file = $request->file('file');
            $file->move($file_path, $file_name);
            $file = $file_path . '/' .$file_name;

            IjazahProfilPensyarahDetail::create([
                'ijazah_profil_pensyarah_id'=> $id,
                'file_name'                 => $request->file_name,
                'uploaded_document'         => $file,
            ]);

            Alert::toast('Maklumat fail dokumen tambahan berjaya ditambah!', 'success');
            return redirect()->back();

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function download($id)
    {
        $download = IjazahProfilPensyarahDetail::find($id);

        return response()->file(public_path($download->uploaded_document));
    }
}
