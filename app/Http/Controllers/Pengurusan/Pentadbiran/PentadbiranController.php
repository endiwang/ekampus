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
use App\Models\Pentadbiran\PermohonanKenderaan;
use App\Models\Pentadbiran\PermohonanKuarters;
use App\Models\Pentadbiran\PermohonanPelekatKenderaan;
use App\Models\Pentadbiran\PermohonanPenginapan;
use App\Models\Pentadbiran\RunningNo;



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


    
}