<?php

namespace App\Http\Controllers\Pelajar\Permohonan;

use App\Http\Controllers\Controller;
use App\Models\Negeri;
use App\Models\Pelajar;
use App\Models\PermohonanSijilTahfiz;
use App\Models\PermohonanSijilTahfizFile;
use App\Models\PusatPeperiksaan;
use App\Models\PusatPeperiksaanNegeri;
use App\Models\TetapanPeperiksaanSijilTahfiz;
use App\Models\Zon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class SijilTahfizController extends Controller
{
    public function index(Builder $builder){
        $title = "Permohonan Sijil Tahfiz";
        $breadcrumbs = [
            "Pelajar" =>  '#',
            "Permohonan" =>  '#',
            "Sijil Tahfiz" =>  '#',
        ];

        $now = Carbon::now()->toDateString();

        //check tetapan peperiksaan sijil tahfiz
        $availableSiri = TetapanPeperiksaanSijilTahfiz::whereDate('tarikh_permohonan_dibuka', '>=', date($now))
            ->whereDate('tarikh_permohonan_ditutup', '<=', date($now))
            ->first();

        // $sql_with_bindings = Str::replaceArray('?', $availableSiri->getBindings(), $availableSiri->toSql());
        // dd($sql_with_bindings);
        // if(!empty($availableSiri)){
            $buttons = [
                [
                    'title' => "Permohonan Baru",
                    'route' => route('pelajar.permohonan.sijil_tahfiz.create'),
                    'button_class' => "btn btn-sm btn-primary fw-bold",
                    'icon_class' => "fa fa-plus-circle"
                ],
            ];
        // } else {
        //     $buttons = [];
        // }

        if (request()->ajax()) {
            $data = PermohonanSijilTahfiz::all();
            return DataTables::of($data)
            ->addColumn('permohonan', function($data) {
                return 'Permohonan';

            })
            ->addColumn('tarikh_permohonan', function($data) {
                return Carbon::parse($data->created_at)->format('d/m/Y');

            })
            ->addColumn('status', function($data) {
                switch ($data->status) {
                    case 1:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-success">Layak</span>';
                        break;
                    case 2:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-info">Dihantar</span>';
                        break;
                    case 0:
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Tidak Layak</span>';
                    default:
                      return '<span class="badge py-3 px-4 fs-7 badge-light-info">Dihantar</span>';
                  }
            })
            ->addColumn('action', function($data){
                $btn = '<a href="'.route('pelajar.permohonan.sijil_tahfiz.show',$data->id).'" class="btn btn-icon btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>';
                if($data->status == 2){
                    $btn .=' <a href="'.route('pelajar.permohonan.sijil_tahfiz.edit',$data->id).'" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil"></i></a>';
                
                    $btn .=' <a class="btn btn-icon btn-danger btn-sm" onclick="remove('.$data->id .')" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fa fa-trash"></i>
                        </a>
                        <form id="delete-'.$data->id.'" action="'.route('pelajar.permohonan.sijil_tahfiz.destroy',$data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>';
                }

                 return $btn;
            })
            ->addIndexColumn()
            ->order(function ($data) {
                // $data->orderBy('id', 'desc');
            })
            ->rawColumns(['tempoh_permohonan','status','action'])
            ->toJson();
        }

        // $dom_setting = "<'row' <'col-sm-6 d-flex align-items-center justify-conten-start'l> <'col-sm-6 d-flex align-items-center justify-content-end'f> >
        // <'table-responsive'tr> <'row' <'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>
        // <'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>";

        $html = $builder
        ->parameters([
            // 'language' => '{ "lengthMenu": "Show _MENU_", }',
            // 'dom' => $dom_setting,
        ])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false, 'orderable'=> false],
            ['data' => 'permohonan', 'name' => 'permohonan', 'title' => 'Permohonan', 'orderable'=> false],
            ['data' => 'tarikh_permohonan', 'name' => 'tarikh_permohonan', 'title' => 'Tarikh Permohonan', 'orderable'=> true],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action','title' => 'Tindakan', 'orderable' => false, 'class'=>'text-bold', 'searchable' => false],

        ])
        ->minifiedAjax();

        return view('pages.pelajar.permohonan.sijil_tahfiz.main', compact('title','breadcrumbs', 'html', 'buttons'));
    }

    public function create(){
        $title = "Permohonan Baru";
        $breadcrumbs = [
            "Pelajar" =>  '#',
            "Permohonan" =>  '#',
            "Sijil Tahfiz" =>  '#',
            "Permohonan Baru" => '#',
        ];

        $pelajar = Pelajar::where('user_id', Auth::id())->first();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeriSelection = Negeri::pluck('nama', 'id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'pelajar' => $pelajar,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeriSelection' => $negeriSelection,
        ];

        return view('pages.pelajar.permohonan.sijil_tahfiz.add_new', $data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'masalah_penglihatan' => 'required',
            'siri_id' => 'required',
            'pusat_peperiksaan_id' => 'required',
            'pusat_peperiksaan_negeri_id' => 'required',
            'nama_tahfiz' => 'required|max:255',
            'alamat_tahfiz' => 'required',
            'poskod_tahfiz' => 'required|numeric',
            'negeri_tahfiz' => 'required',
            'jenis_pengajian' => 'required',
            'tahun_mula' => 'required|numeric',
            'tahun_tamat' => 'required|numeric',
            'tahap_pencapaian_hafazan' => 'required',
            'mykad' => 'required',
            'dokumen_sokongan' => 'required',
            'resit_bayaran' => 'required',
        ],[
            'masalah_penglihatan.required' => 'Ruangan ini perlu diisi.',
            'siri_id.required' => 'Sila pilih siri peperiksaan sijil tahfiz yang ingin dipohon.',
            'pusat_peperiksaan_id.required' => 'Sila pilih pusat peperiksaan.',
            'pusat_peperiksaan_negeri_id.required' => 'Sila pilih negeri pusat peperiksaan.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'alamat_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.Numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:53999).',
            'negeri.required' => 'Sila pilih negeri',
            'tahun_mula.required' => 'Ruangan ini perlu diisi.',
            'tahun_mula.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahun_tamat.required' => 'Ruangan ini perlu diisi.',
            'tahun_tamat.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahap_pencapaian_hafazan.required' => 'Ruangan ini perlu diisi.',
            'mykad.required'    => 'Sila lampirkan salinan MyKad anda.',
            'dokumen_sokongan.required' => 'Sila lampirkan dokumen sokongan yang telah disahkan.',
            'resit_bayaran.required'    => 'Sila lampirkan resit/bukti pembayaran.',
        ]);

        $pelajar = Pelajar::where('user_id', Auth::id())->first();
        $request['created_by'] = Auth::id();
        $request['pelajar_id'] = $pelajar->id;
        $request['status'] = 2;

        DB::beginTransaction();

        try {

            $permohonan = PermohonanSijilTahfiz::create($request->except('_token','mykad', 'dokumen_sokongan', 'resit_bayaran', 'pusat_peperiksaan_negeri', 'pusat_peperiksaan'));

            if($request->mykad)
            {
                $file_name = uniqid() . '.' . $request->mykad->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pelajar->id;
                $file = $request->file('mykad');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->mykad->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'mykad',
                ]);
            }

            if($request->dokumen_sokongan)
            {
                $file_name = uniqid() . '.' . $request->dokumen_sokongan->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pelajar->id;
                $file = $request->file('dokumen_sokongan');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->dokumen_sokongan->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'dokumen',
                ]);
            }

            if($request->resit_bayaran)
            {
                $file_name = uniqid() . '.' . $request->resit_bayaran->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pelajar->id;
                $file = $request->file('resit_bayaran');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->resit_bayaran->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'resit',
                ]);
            }
            
            DB::commit();
            Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Maklumat permohonan Tidak berjaya dihantar!', 'error');
        }

        return redirect()->route('pelajar.permohonan.sijil_tahfiz.index');
    }

    public function show($id){
        $title = "Lihat Permohonan";
        $breadcrumbs = [
            "Pelajar" =>  '#',
            "Permohonan" =>  '#',
            "Sijil Tahfiz" =>  '#',
            "Lihat Permohonan" => '#',
        ];

        $pelajar = Pelajar::where('user_id', Auth::id())->first();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeriSelection = Negeri::pluck('nama', 'id');
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id',$id)->first();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($permohonan->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $permohonan->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'pelajar' => $pelajar,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeriSelection' => $negeriSelection,
            'permohonan'    => $permohonan,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pelajar.permohonan.sijil_tahfiz.view', $data);
    }

    public function edit($id){
        $title = "Pinda Permohonan";
        $breadcrumbs = [
            "Pelajar" =>  '#',
            "Permohonan" =>  '#',
            "Sijil Tahfiz" =>  '#',
            "Pinda Permohonan" => '#',
        ];

        $pelajar = Pelajar::where('user_id', Auth::id())->first();
        $siri_peperiksaan = TetapanPeperiksaanSijilTahfiz::where('status', 1)->pluck('siri', 'id');
        $negeriSelection = Negeri::pluck('nama', 'id');
        $permohonan = PermohonanSijilTahfiz::with('permohonanSijilTahfizFile')->where('id',$id)->first();
        $pusatPeperiksaans = PusatPeperiksaan::whereIn('id', json_decode($permohonan->tetapanSiriPeperiksaan->lokasi_peperiksaan))
            ->pluck('name', 'id');
        $pusatPeperiksaanNegeris = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $permohonan->pusat_peperiksaan_id)
            ->pluck('negeri.nama', 'pusat_peperiksaan_negeris.id');

        $data = [
            'title' => $title,
            'breadcrumbs' => $breadcrumbs,
            'pelajar' => $pelajar,
            'siri_peperiksaan' => $siri_peperiksaan,
            'negeriSelection' => $negeriSelection,
            'permohonan'    => $permohonan,
            'pusatPeperiksaans' => $pusatPeperiksaans,
            'pusatPeperiksaanNegeris' => $pusatPeperiksaanNegeris,
        ];

        return view('pages.pelajar.permohonan.sijil_tahfiz.edit', $data);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'masalah_penglihatan' => 'required',
            'siri_id' => 'required',
            'pusat_peperiksaan_id' => 'required',
            'pusat_peperiksaan_negeri_id' => 'required',
            'nama_tahfiz' => 'required|max:255',
            'alamat_tahfiz' => 'required',
            'poskod_tahfiz' => 'required|numeric',
            'negeri_tahfiz' => 'required',
            'jenis_pengajian' => 'required',
            'tahun_mula' => 'required|numeric',
            'tahun_tamat' => 'required|numeric',
            'tahap_pencapaian_hafazan' => 'required',
        ],[
            'masalah_penglihatan.required' => 'Ruangan ini perlu diisi.',
            'siri_id.required' => 'Sila pilih siri peperiksaan sijil tahfiz yang ingin dipohon.',
            'pusat_peperiksaan_id.required' => 'Sila pilih pusat peperiksaan.',
            'pusat_peperiksaan_negeri_id.required' => 'Sila pilih negeri pusat peperiksaan.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'alamat_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'nama_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.required' => 'Ruangan ini perlu diisi.',
            'poskod_tahfiz.Numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:53999).',
            'negeri.required' => 'Sila pilih negeri',
            'tahun_mula.required' => 'Ruangan ini perlu diisi.',
            'tahun_mula.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahun_tamat.required' => 'Ruangan ini perlu diisi.',
            'tahun_tamat.numeric' => 'Ruangan ini perlu diisi dengan angka sahaja (cth:2017).',
            'tahap_pencapaian_hafazan.required' => 'Ruangan ini perlu diisi.',
        ]);

        $pelajar = Pelajar::where('id', 15044)->first();
        $permohonan = PermohonanSijilTahfiz::where('id',$id)->first();

        DB::beginTransaction();

        try {

            $permohonan->update($request->except('_token','mykad', 'dokumen_sokongan', 'resit_bayaran'));

            if($request->mykad)
            {
                PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id',$id)->where('document_type','mykad')->delete();
                $file_name = uniqid() . '.' . $request->mykad->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pelajar->id;
                $file = $request->file('mykad');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->mykad->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'mykad',
                ]);
            }

            if($request->dokumen_sokongan)
            {
                PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id',$id)->where('document_type','dokumen')->delete();
                $file_name = uniqid() . '.' . $request->dokumen_sokongan->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pelajar->id;
                $file = $request->file('dokumen_sokongan');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->dokumen_sokongan->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'dokumen',
                ]);
            }

            if($request->resit_bayaran)
            {
                PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id',$id)->where('document_type','resit')->delete();
                $file_name = uniqid() . '.' . $request->resit_bayaran->getClientOriginalExtension();
                $file_path = 'uploads/permohonan/sijil_tahfiz/'.$pelajar->id;
                $file = $request->file('resit_bayaran');
                $file->move($file_path, $file_name);

                PermohonanSijilTahfizFile::create([
                    'permohonan_sijil_tahfiz_id' => $permohonan->id,
                    'file_upload_name' => $request->resit_bayaran->getClientOriginalName(),
                    'file_upload_path' => $file_path.'/'.$file_name,
                    'document_type' => 'resit',
                ]);
            }
            
            DB::commit();
            Alert::toast('Maklumat permohonan berjaya dihantar!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::toast('Maklumat permohonan Tidak berjaya dihantar!', 'error');
        }

        return redirect()->route('pelajar.permohonan.sijil_tahfiz.index');
    }

    public function destroy($id){
        PermohonanSijilTahfiz::where('id',$id)->delete();
        PermohonanSijilTahfizFile::where('permohonan_sijil_tahfiz_id',$id)->delete();

        Alert::toast('Permohonan berjaya dipadamkan', 'success');
        return redirect()->route('pelajar.permohonan.sijil_tahfiz.index');
    }

    public function fetchPusatPeperiksaan(Request $request){
        $tetapan = TetapanPeperiksaanSijilTahfiz::where('id', $request->siri_id)->first();
        $ppeperiksaan = PusatPeperiksaan::whereIn('id', json_decode($tetapan->lokasi_peperiksaan))
            ->get(['id','name as text']);
        return $ppeperiksaan;
    }

    public function fetchPusatPeperiksaanNegeri(Request $request){
        $ppnegeri = PusatPeperiksaanNegeri::join('negeri', 'negeri.id', '=', 'pusat_peperiksaan_negeris.state_id')
            ->where('pusat_peperiksaan_negeris.pusat_peperiksaan_id', $request->pusat_peperiksaan_id)
            ->get(['pusat_peperiksaan_negeris.id','negeri.nama as text']);
        return $ppnegeri;
    }
}
