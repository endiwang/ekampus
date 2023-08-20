<?php

namespace App\Http\Controllers\Pengurusan\Pentadbiran;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Auth;
use File;
use Redirect;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sesi;
use App\Models\Kualiti\JaminanKualiti;
use Yajra\DataTables\Html\Builder;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Lookup\LookupKategoriMaklumat;
use Illuminate\Support\Facades\Storage;
use App\Models\Kualiti\KursusDanLatihanPensyarah;
use App\Models\Kualiti\MaklumatKursusDanLatihan;
use App\Models\Kualiti\Akreditasi;
use App\Models\Kualiti\Muadalah;
use App\Models\Kualiti\RekodKompetensiPensyarah;
use App\Models\Kualiti\Penyelidikan;
use App\Models\Kualiti\PenyumbangArtikel;
use App\Models\Kualiti\EditorArtikel;
use App\Models\Kualiti\Artikel;
use App\Models\Kualiti\KomenArtikel;
use App\Models\Pentadbiran\Fasiliti;
use App\Models\Pentadbiran\PermohonanFasiliti;
use App\Models\Pentadbiran\PermohonanPeralatan;
use App\Models\Pentadbiran\PermohonanKenderaan;
use App\Models\Pentadbiran\PermohonanKuarters;
use App\Models\Pentadbiran\PermohonanPelekatKenderaan;
use App\Models\Pentadbiran\PermohonanPenginapan;
use App\Models\Pentadbiran\RunningNo;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;



class PentadbiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fasilitiIndex(Builder $builder)
    {
        $title = "Fasiliti";
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Senarai Fasiliti" =>  false,
        ];

        $buttons = [
            [
                'title' => "Tambah Fasiliti", 
                'route' => route('pengurusan.pentadbiran.fasiliti.create'), 
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];
        
        if (request()->ajax()) {
            // $data = JaminanKualiti::query();
            $data = Fasiliti::get();        
            return DataTables::of($data)
            ->addColumn('jenis', function($data) {
                if($data->jenis == 1)
                {
                    return 'Fasiliti';
                }else{
                    return 'Peralatan';
                }
            })
            // ->addColumn('tarikh', function($data) {
            //     return date('d-m-Y',$data->tarikh);
            // })            
            ->addColumn('action', function($data){
                // $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm hover-elevate-up me-2">View</a>';
                // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm hover-elevate-up me-2">Edit</a>';
                // $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm hover-elevate-up">Delete</a>';

                $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/edit/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Pinda</a>';

                 return $btn;
            })
            ->addIndexColumn()
            // ->order(function ($data) {
            //     $data->orderBy('created_at');
            // })
            ->rawColumns(['tarikh','jenis','action'])
            ->toJson();
        }

        

        $dataTable = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'jenis', 'name' => 'jenis', 'title' => 'Jenis', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'kategori', 'name' => 'kategori', 'title' => 'Kategori', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'kuantiti', 'name' => 'kuantiti', 'title' => 'Kuantiti', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'pengguna', 'name' => 'pengguna', 'title' => 'Pengguna', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'tarikh', 'name' => 'Tarikh', 'title' => 'Tarikh', 'orderable'=> false],
            ['data' => 'masa', 'name' => 'masa', 'title' => 'Masa', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        
        return view('pages.pengurusan.pentadbiran.fasiliti.list', compact('dataTable','buttons'));
        
    }


    public function fasilitiCreate()
    {
        $title = "Fasiliti";
        $action = route('pengurusan.pentadbiran.fasiliti.store');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Tambah Fasiliti" =>  false,
        ];
        $page_title = 'Fasiliti';
        // $jenisDoc = [
        //     1 => 'Dokumen Baru',
        //     2 => 'Dokumen Tambahan',
        //     3 => 'Dokumen Ganti (Versi Baru)',
        //     4 => 'Dokumen Hapus (delete)'
        // ];
        $status = [
            1 => 'Digunakan',
            2 => 'Tidak Digunakan'
        ];
        $jenis = [
            1 => 'Fasiliti',
            2 => 'Peralatan'
        ];

        $model = new Fasiliti();
        
        return view('pages.pengurusan.pentadbiran.fasiliti.add_new', compact(['status','page_title','breadcrumbs','title','model','action','jenis']));
    }

    public function fasilitiStore(Request $request)
    {

        // dd($request);
        $validation = $request->validate([
            'kategori'=> 'required',
            'pengguna'=> 'required',
            
            
        ],[
            'kategori.required'     => 'Sila masukkan maklumat kategori',
            'pengguna.required'     => 'Sila masukkan maklumat pengguna ',
        ]);

        $user = auth()->user();

        

        try{

            
            Fasiliti::create([
                'jenis'                     => $request->jenis,
                'kategori'                  => $request->kategori,
                'kuantiti'                  => $request->kuantiti,
                'status_penggunaan'         => $request->status_penggunaan,
                'pengguna'                  => $request->pengguna,
                'tarikh'                    => $request->tarikh,
                'masa'                      => $request->masa,
                'status'                    => 1
            ]);

            

            Alert::toast('Maklumat fasiliti/peralatan berjaya ditambah!', 'success');
            return redirect::to('/pengurusan/pentadbiran/fasiliti/index');
            // return redirect()->route('pengurusan.akademik.peraturan_akademik.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function fasilitiEdit(Request $request)
    {
        $title = "Fasiliti";
        $action = route('pengurusan.pentadbiran.fasiliti.update');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Kemaskini Fasiliti" =>  false,
        ];
        $page_title = 'Kemaskini Fasiliti';
        
        $status = [
            1 => 'Digunakan',
            2 => 'Tidak Digunakan'
        ];
        $jenis = [
            1 => 'Fasiliti',
            2 => 'Peralatan'
        ];

        $model = Fasiliti::find($request->id);
        
        return view('pages.pengurusan.pentadbiran.fasiliti.add_new', compact(['status','page_title','breadcrumbs','title','model','action','jenis']));
    }

    public function fasilitiUpdate(Request $request)
    {
        $validation = $request->validate([
            'kategori'=> 'required',
            'pengguna'=> 'required',
            
            
        ],[
            'kategori.required'     => 'Sila masukkan maklumat kategori',
            'pengguna.required'     => 'Sila masukkan maklumat pengguna ',
        ]);

        $user = auth()->user();

        $model = Fasiliti::find($request->id);

        try{

            
            $model = $model->update([
                'jenis'                     => $request->jenis,
                'kategori'                  => $request->kategori,
                'kuantiti'                  => $request->kuantiti,
                'status_penggunaan'         => $request->status_penggunaan,
                'pengguna'                  => $request->pengguna,
                'tarikh'                    => $request->tarikh,
                'masa'                      => $request->masa
            ]);

            

            Alert::toast('Maklumat fasiliti/peralatan berjaya dikemaskini!', 'success');
            return redirect::to('/pengurusan/pentadbiran/fasiliti/index');
            

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

    }



    // Permohonan Fasiliti oleh pelajar dan kakitangan

    public function permohonanFasilitiIndex(Builder $builder,Request $request)
    {
        $user = Auth::user();
        // $roles = Role::all()->pluck('name');
        
        
        // dd($user->is_student);

        
        $title = "Permohonan Fasiliti";
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Senarai Permohonan Fasiliti" =>  false,
        ];

        $buttons = [
            [
                'title' => "Mohon Fasiliti", 
                'route' => route('pengurusan.pentadbiran.fasiliti.permohonan.tambah'), 
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            
            if($user->is_student == 1){
                $data = PermohonanFasiliti::where('user_id',$user->id)->with('fasiliti')->get();  
            }elseif($user->is_staff == 1){
                $data = PermohonanFasiliti::with('fasiliti')->get(); 
            }else{
                $data = PermohonanFasiliti::with('fasiliti')->get(); 
            }
                  
            return DataTables::of($data)
            ->addColumn('fasiliti_id', function($data) {
                if($data->fasiliti->jenis == 1)
                {
                    return 'Fasiliti';
                }else{
                    return 'Peralatan';
                }
            })
            ->addColumn('status_permohonan', function($data) {
                if($data->status_permohonan == 1)
                {
                    return 'Baru Diterima';
                }elseif($data->status_permohonan == 2){
                    return 'Proses';
                }elseif($data->status_permohonan == 3){
                    return 'Lulus';
                }elseif($data->status_permohonan == 4){
                    return 'Tolak';
                }else{
                    return 'Tiada Status';
                }

            })
                      
            ->addColumn('action', function($data){  
                if(Auth::user()->is_student == 1){          
                    $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                }elseif(Auth::user()->is_staff == 1){
                    if($data->status_permohonan != 3){
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                    }else{
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }
                    
                }else{
                    $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                }
                return $btn;    
            })
            ->addIndexColumn()            
            ->rawColumns(['fasiliti_id','action','status'])
            ->toJson();
        }

        

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'tarikh_penggunaan', 'name' => 'tarikh_penggunaan', 'title' => 'Tarikh Penggunaan', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'fasiliti_id', 'name' => 'fasiliti_id', 'title' => 'Fasiliti', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'jumlah_peserta', 'name' => 'jumlah_peserta', 'title' => 'Jumlah Peserta', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'status_permohonan', 'name' => 'status_permohonan', 'title' => 'Status', 'orderable'=> false],            
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        
        return view('pages.pengurusan.pentadbiran.fasiliti.list', compact('dataTable','buttons'));


    }

    public function permohonanFasilitiTambah(Request $request)
    {
        $title = "Permohonan Fasiliti";
        $action = route('pengurusan.pentadbiran.fasiliti.permohonan.store');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Permohonan Fasiliti" =>  false,
        ];
        $page_title = 'Permohonan Fasiliti';
        $jenisMakan = [
            1 => 'Sarapan',
            2 => 'Makan Tengahari',
            3 => 'Makan Petang',
            4 => 'Makan Malam',
            5 => 'Tiada'
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak'
        ];
        $peserta = [
            1 => 'VIP',
            2 => 'Biasa'
        ];

        $selFasilitiPelajar = Fasiliti::where('jenis',1)->where('status_penggunaan','2')->whereNot('id',[4,6])->pluck('kategori','id');
        $selFasilitiAll = Fasiliti::where('jenis',1)->where('status_penggunaan','2')->pluck('kategori','id');
        $selPeralatan = Fasiliti::where('jenis',2)->where('status_penggunaan',2)->pluck('kategori','id');
        $model = new PermohonanFasiliti();
        $user = Auth::user();
        return view('pages.pengurusan.pentadbiran.permohonan.fasiliti.add_new', compact(
            'title','action','page_title',
            'breadcrumbs','jenisMakan','status',
            'selFasilitiPelajar','selFasilitiAll',
            'selPeralatan','model','user',
            'peserta'
            ));
    }


    public function permohonanFasilitiStore(Request $request)
    {
        // dd($request);
        $user = auth()->user();

        try{

            if(!empty($request->file))
            {
                
                $file_name = uniqid() . '.' . $request->file->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/fasiliti/';
                $file = $request->file('file');
                $file->move($file_path, $file_name);
                $file = $file_path . '' .$file_name;
    
                $original_filename = $request->file->getClientOriginalName();
            }else{
                $original_filename = NULL;
                $file = NULL;
            }



            $runningno = $this->runningMan('fasiliti');
            $appno = "FASILITI".str_pad($runningno, 4, "0", STR_PAD_LEFT).date('Y');

            $insert = PermohonanFasiliti::create([
                'no_permohonan'             => $appno,
                'user_id'                   => $user->id,                
                'document_name'             => $original_filename,
                'upload_document'           => $file,
                'fasiliti_id'               => $request->kategori,
                'tarikh_penggunaan'         => $request->tarikh,
                'makan_minum'               => data_get($request,'makan_minum'),
                'peserta'                   => $request->peserta,
                'jumlah_peserta'            => $request->jumlah_peserta,
                'catatan_tambahan'          => $request->catatan_tambahan,
                'status_permohonan'         => 1 // baru terima
            ]);

            foreach($request->peralatan as $alat){
                PermohonanPeralatan::create([
                    'permohonan_fasiliti_id' => $insert->id,
                    'peralatan_id' => $alat,
                    'status' => 1

                ]);
            }


            Alert::toast('Maklumat permohonan fasiliti berjaya dihantar!', 'success');
            return redirect()->route('pengurusan.pentadbiran.fasiliti.permohonan.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

    }



    // function running man
    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function runningMan($code)
    {

        $lowercode = strtolower($code);
        $data = RunningNo::find(1);

        $no = $data->$lowercode;

        $dateup = $data->updated_at;

        $now = date('Y');
        $y_db = date('Y', strtotime($dateup));

        if(($no < 999) AND ($now == $y_db)){
            $run_no = $no+1;

        }else{
            $run_no = 1;
        }

        
        $data->$code = $run_no;
        $data->save();
        


        while(strlen($run_no) <= 3){
            $run_no = '0' . $run_no;
        }

        return $run_no;

    } //



    public function permohonanFasilitiShow(Request $request)
    {
        $title = "Fasiliti";
        $action = route('pengurusan.pentadbiran.fasiliti.update');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Kelulusan PermohonanFasiliti" =>  false,
        ];
        $page_title = 'Kelulusan Permohonan Fasiliti';

        $jenisMakan = [
            1 => 'Sarapan',
            2 => 'Makan Tengahari',
            3 => 'Makan Petang',
            4 => 'Makan Malam',
            5 => 'Tiada'
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak'
        ];
        $peserta = [
            1 => 'VIP',
            2 => 'Biasa'
        ];

        $selFasilitiPelajar = Fasiliti::where('jenis',1)->where('status_penggunaan','2')->whereNot('id',[4,6])->pluck('kategori','id');
        $selFasilitiAll = Fasiliti::where('jenis',1)->where('status_penggunaan','2')->pluck('kategori','id');
        $selPeralatan = Fasiliti::where('jenis',2)->where('status_penggunaan',2)->pluck('kategori','id');
        $model = PermohonanFasiliti::with('fasiliti','peralatan.fasiliti','user.pelajar','user.staff','approvedby')->find($request->id);
        // dump($model);
        $user = Auth::user();
        return view('pages.pengurusan.pentadbiran.permohonan.fasiliti.action', compact(
            'title','action','page_title',
            'breadcrumbs','jenisMakan','status',
            'selFasilitiPelajar','selFasilitiAll',
            'selPeralatan','model','user',
            'peserta'
            ));

    }



    public function permohonanFasilitiUpdate(Request $request)
    {
        // dd($request);

        $user = auth()->user();

        $model = PermohonanFasiliti::find($request->id);

        try{

            $model = $model->update([                
            'status_permohonan'                    => $request->status,
            'approved_by'                          => $user->id,
            'approved_date'                        => date('Y-m-d H:s:i')
            ]); 

            if($request->status == 3){
                Alert::toast('Permohonan fasiliti diluluskan!', 'success');
            }elseif($request->status == 4){
                Alert::toast('Permohonan fasiliti ditolak!', 'success');
            }else{
                Alert::toast('Permohonan fasiliti dikemaskini!', 'success');
            }
            
            return redirect()->route('pengurusan.pentadbiran.fasiliti.permohonan.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }

    }


    public function permohonanFasilitiShowOnly(Request $request)
    {
        $title = "Fasiliti";
        $action = route('pengurusan.pentadbiran.fasiliti.update');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Kelulusan PermohonanFasiliti" =>  false,
        ];
        $page_title = 'Kelulusan Permohonan Fasiliti';

        $jenisMakan = [
            1 => 'Sarapan',
            2 => 'Makan Tengahari',
            3 => 'Makan Petang',
            4 => 'Makan Malam',
            5 => 'Tiada'
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak'
        ];
        $peserta = [
            1 => 'VIP',
            2 => 'Biasa'
        ];

        $selFasilitiPelajar = Fasiliti::where('jenis',1)->where('status_penggunaan','2')->whereNot('id',[4,6])->pluck('kategori','id');
        $selFasilitiAll = Fasiliti::where('jenis',1)->where('status_penggunaan','2')->pluck('kategori','id');
        $selPeralatan = Fasiliti::where('jenis',2)->where('status_penggunaan',2)->pluck('kategori','id');
        $model = PermohonanFasiliti::with('fasiliti','peralatan.fasiliti','user.pelajar','user.staff','approvedby')->find($request->id);
        // dump($model);
        $user = Auth::user();
        return view('pages.pengurusan.pentadbiran.permohonan.fasiliti.show', compact(
            'title','action','page_title',
            'breadcrumbs','jenisMakan','status',
            'selFasilitiPelajar','selFasilitiAll',
            'selPeralatan','model','user',
            'peserta'
            ));

    }


    public function permohonanPenginapanIndex(Builder $builder, Request $request)
    {
        $user = Auth::user();
       
        $title = "Permohonan Penginapan";
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Senarai Permohonan Penginapan" =>  false,
        ];

        $buttons = [
            [
                'title' => "Mohon Penginapan", 
                'route' => route('pengurusan.pentadbiran.penginapan.permohonan.tambah'), 
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        if (request()->ajax()) {
            
            if($user->is_staff == 1){
                $data = PermohonanPenginapan::with('approvedby')->get(); 
            }else{
                $data = PermohonanPenginapan::with('approvedby')->get(); 
            }
                  
            return DataTables::of($data)
            ->addColumn('bilik', function($data) {
                if($data->bilik == 1)
                {
                    return 'Bilik Rehat 1';
                }elseif($data->bilik == 2){
                    return 'Bilik Rehat 2';
                }elseif($data->bilik == 3){
                    return 'Ruang Tamu 1';
                }elseif($data->bilik == 4){
                    return 'Ruang Tamu 2';
                }else{
                    return 'Ruang Tamu 3';
                }

                
            })
            ->addColumn('status', function($data) {
                if($data->status == 1)
                {
                    return 'Baru Diterima';
                }elseif($data->status == 2){
                    return 'Proses';
                }elseif($data->status == 3){
                    return 'Lulus';
                }elseif($data->status == 4){
                    return 'Tolak';
                }else{
                    return 'Tiada Status';
                }

            })
            ->addColumn('tarikh', function($data) {
                return date('d-m-Y',$data->tarikh);

            })
            ->addColumn('tarikh_keluar', function($data) {
                return date('d-m-Y',$data->tarikh);

            })
                      
            ->addColumn('action', function($data){  
                if(Auth::user()->is_student == 1){          
                    // $btn = '<a href="'.url('/pengurusan/pentadbiran/fasiliti/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                }elseif(Auth::user()->is_staff == 1){
                    
                    if($data->status != 3){
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/penginapan/permohonan/action/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Tindakan</a>';
                    }else{
                        $btn = '<a href="'.url('/pengurusan/pentadbiran/penginapan/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                    }
                    
                }else{
                    $btn = '<a href="'.url('/pengurusan/pentadbiran/penginapan/permohonan/show/'.$data->id).'" class="edit btn btn-primary btn-sm hover-elevate-up me-2 mb-1">Lihat</a>';
                }
                return $btn;    
            })
            ->addIndexColumn()            
            ->rawColumns(['bilik','tarikh','tarikh_keluar','action','status'])
            ->toJson();
        }

        

        $dataTable = $builder
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'no_permohonan', 'name' => 'no_permohonan', 'title' => 'No Permohonan', 'orderable'=> false, 'class'=>'text-bold'],
            ['data' => 'bilik', 'name' => 'bilik', 'title' => 'Bilik', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'tarikh', 'name' => 'tarikh', 'title' => 'Tarikh Menginap', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'tarikh_keluar', 'name' => 'tarikh_keluar', 'title' => 'Tarikh Keluar', 'orderable'=> false, 'class'=>'text-bold'],            
            // ['data' => 'jumlah_peserta', 'name' => 'jumlah_peserta', 'title' => 'Jumlah Peserta', 'orderable'=> false, 'class'=>'text-bold'],            
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],            
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        
        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.list', compact('dataTable','buttons'));
    }

    public function permohonanPenginapanTambah(Request $request)
    {
        $title = "Permohonan Penginapan";
        $action = route('pengurusan.pentadbiran.penginapan.permohonan.store');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Permohonan Penginapan" =>  false,
        ];
        $page_title = 'Permohonan Penginapan';
        
        $selectbilik = [
            1 => 'Bilik Rehat 1',
            2 => 'Bilik Rehat 2',
            3 => 'Ruang Tamu 1',
            4 => 'Ruang Tamu 2',
            5 => 'Ruang Tamu 3'
        ];
        $status = [
            1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak'
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        
        $model = new PermohonanPenginapan();
        $user = Auth::user();
        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.add_new', compact(
            'title','action','page_title',
            'breadcrumbs','selectbilik','status',
            'model','user',
            
            ));
    }

    public function permohonanPenginapanStore(Request $request)
    {
        // dd($request);

        $user = auth()->user();

        try{
            
            $startDate = Carbon::createFromFormat('Y-m-d', $request->tarikh);
            $endDate = Carbon::createFromFormat('Y-m-d', $request->tarikh_keluar);
        
            $interval = $startDate->diff($endDate);
            $days = $interval->days + 1;

            $runningno = $this->runningMan('penginapan');
            $appno = "PENGINAPAN".str_pad($runningno, 4, "0", STR_PAD_LEFT).date('Y');

            $insert = PermohonanPenginapan::create([
                'no_permohonan'             => $appno,
                'user_id'                   => $user->id,                                
                'bilik'                     => $request->bilik,
                'tarikh_masuk'              => $request->tarikh,
                'tempoh_hari'               => $days,
                'tarikh_keluar'             => data_get($request,'tarikh_keluar'),
                'tujuan'                    => $request->tujuan,               
                'status'                    => 1 // baru terima
            ]);

            


            Alert::toast('Maklumat permohonan penginapan berjaya dihantar!', 'success');
            return redirect()->route('pengurusan.pentadbiran.penginapan.permohonan.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }

    public function permohonanPenginapanShow(Request $request)
    {
        $title = "Permohonan Penginapan";
        $action = route('pengurusan.pentadbiran.penginapan.permohonan.store');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Permohonan Penginapan" =>  false,
        ];
        $page_title = 'Permohonan Penginapan';
        
        $selectbilik = [
            1 => 'Bilik Rehat 1',
            2 => 'Bilik Rehat 2',
            3 => 'Ruang Tamu 1',
            4 => 'Ruang Tamu 2',
            5 => 'Ruang Tamu 3'
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak'
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        
        $model = PermohonanPenginapan::find($request->id);
        $user = Auth::user();
        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.action', compact(
            'title','action','page_title',
            'breadcrumbs','selectbilik','status',
            'model','user',
            
            ));
    }

    public function permohonanPenginapanUpdate(Request $request)
    {
        $user = auth()->user();

        try{
            $model = PermohonanPenginapan::find($request->id);

            $model = $model->update([
                
                'approved_by'               => $user->id,  
                // 'approved_date'             => date('Y-m-d H:s:i'),             
                'status'                    => $request->status
            ]);

            


            if($request->status == 3){
                Alert::toast('Permohonan fasiliti diluluskan!', 'success');
            }elseif($request->status == 4){
                Alert::toast('Permohonan fasiliti ditolak!', 'success');
            }else{
                Alert::toast('Permohonan fasiliti dikemaskini!', 'success');
            }
            return redirect()->route('pengurusan.pentadbiran.penginapan.permohonan.index');

        }catch (Exception $e) {
            report($e);
    
            Alert::toast('Uh oh! Something went Wrong', 'error');
            return redirect()->back();
        }
    }


    public function permohonanPenginapanShowOnly(Request $request)
    {
        $title = "Permohonan Penginapan";
        $action = route('pengurusan.pentadbiran.penginapan.permohonan.store');
        $breadcrumbs = [
            "Pentadbiran" =>  false,
            "Permohonan Penginapan" =>  false,
        ];
        $page_title = 'Permohonan Penginapan';
        
        $selectbilik = [
            1 => 'Bilik Rehat 1',
            2 => 'Bilik Rehat 2',
            3 => 'Ruang Tamu 1',
            4 => 'Ruang Tamu 2',
            5 => 'Ruang Tamu 3'
        ];
        $status = [
            // 1 => 'Baru diterima',
            2 => 'Proses',
            3 => 'Lulus',
            4 => 'Tolak'
        ];
        // $peserta = [
        //     1 => 'VIP',
        //     2 => 'Biasa'
        // ];

        
        $model = PermohonanPenginapan::with('user.staff','approvedby')->find($request->id);
        $user = Auth::user();
        return view('pages.pengurusan.pentadbiran.permohonan.penginapan.show', compact(
            'title','action','page_title',
            'breadcrumbs','selectbilik','status',
            'model','user',
            
            ));
    }


    
}