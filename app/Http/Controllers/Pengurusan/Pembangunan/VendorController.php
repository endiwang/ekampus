<?php

namespace App\Http\Controllers\Pengurusan\Pembangunan;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class VendorController extends Controller
{
    protected $baseView = 'pages.pengurusan.pembangunan.vendor.';
    protected $baseRoute = 'pengurusan.pembangunan.kemaskini.vendor.';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            
            $data = Vendor::query();

            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $html = '';
                $html .= '<a href="' . route($this->baseRoute . 'edit', $data->id) . '" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil-alt"></i></a> ';
                $html .= '<a class="btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hapus" onclick="remove(' . $data->id . ')"><i class="fa fa-trash"></i></a>' . 
                '<form id="delete-' . $data->id . '" action="'. route($this->baseRoute . 'destroy', $data->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                </form>';

                return $html;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
        }

        $dataTable = $builder
        ->parameters([])
        ->columns([
            [ 'defaultContent'=> '', 'data'=> 'DT_RowIndex', 'name'=> 'DT_RowIndex', 'title'=> 'Bil','orderable'=> false, 'searchable'=> false],
            ['data' => 'nama_syarikat', 'name' => 'nama_syarikat', 'title' => 'Nama Syarikat', 'orderable'=> false],
            ['data' => 'nama_pengurus', 'name' => 'nama_pengurus', 'title' => 'Nama Pengurus', 'orderable'=> false],
            ['data' => 'no_tel_pengurus', 'name' => 'no_tel_pengurus', 'title' => 'No Telefon Pengurus', 'orderable'=> false],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],

        ])
        ->minifiedAjax();

        $data['dataTable'] = $dataTable;

        $data['title'] = "Senarai Vendor";
        $data['breadcrumbs'] = [
            "Pembangunan" =>  false,
            "Kemaskini" =>  false,
            "Senarai Vendor" =>  false,
        ];
        $data['buttons'] = [
            [
                'title' => "Tambah Vendor",
                'route' => route($this->baseRoute . 'create'),
                'button_class' => "btn btn-sm btn-primary fw-bold",
                'icon_class' => "fa fa-plus-circle"
            ],
        ];

        return view($this->baseView . 'list')->with($data);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Vendor";
        $data['page_title'] = "Tambah Vendor";
        $data['breadcrumbs'] = [
            "Pembangunan" =>  false,
            "Kemaskini" =>  false,
            "Senarai Vendor" =>  false,
        ];
        $data['action'] = route($this->baseRoute . 'store');
        $data['model'] = new Vendor;

        return view($this->baseView . 'form')->with($data);  
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
            'nama_syarikat' => 'required',
            'nama_pengurus' => 'required',
            'no_tel_pengurus' => 'required',
            'emel_pengurus' => 'required',
        ],[
            'nama_syarikat.required'       => 'Sila tulis nama syarikat',
            'nama_pengurus.required'       => 'Sila tulis nama pengurus',
            'no_tel_pengurus.required'       => 'Sila tulis no tel pengurus',
            'emel_pengurus.required'       => 'Sila tulis emel pengurus',
        ]);


        $result = true;
        try
        { 
            DB::transaction(function () use($request) {

                $vendor = new Vendor;
                $vendor->nama_syarikat = $request->nama_syarikat;
                $vendor->no_tel_syarikat = $request->no_tel_syarikat;
                $vendor->alamat = $request->alamat;
                $vendor->nama_pengurus = $request->nama_pengurus;
                $vendor->no_tel_pengurus = $request->no_tel_pengurus;
                $vendor->emel_pengurus = $request->emel_pengurus;
                $vendor->status = $request->status;

                if($vendor->save())
                {
                    $user = User::where('username', $vendor->emel_pengurus)->first();
                    if(empty($user))
                    {
                        $user = new User;
                        $user->username = $vendor->emel_pengurus;
                        $user->password = Hash::make($vendor->no_tel_pengurus);
                        $user->is_vendor = 1;
                        if($user->save())
                        {
                            $vendor->user_id = $user->id;
                            $vendor->save();
                        }
                    }
                }
            });

        }
        catch (\Exception $e)
        {
            $result = false;                
        }


        if($result)
        {
            Alert::toast('Maklumat Vendor Berjaya Ditambah', 'success');
            return redirect(route($this->baseRoute . 'index'));
        }
        else {
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
        $data['title'] = "Pinda Vendor";
        $data['page_title'] = "Pinda Vendor";
        $data['breadcrumbs'] = [
            "Pembangunan" =>  false,
            "Kemaskini" =>  false,
            "Senarai Vendor" =>  false,
        ];
        $data['action'] = route($this->baseRoute . 'update', $id);
        $data['model'] = Vendor::find($id);

        return view($this->baseView . 'form')->with($data);
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
            'nama_syarikat' => 'required',
            'nama_pengurus' => 'required',
            'no_tel_pengurus' => 'required',
            'emel_pengurus' => 'required',
        ],[
            'nama_syarikat.required'       => 'Sila tulis nama syarikat',
            'nama_pengurus.required'       => 'Sila tulis nama pengurus',
            'no_tel_pengurus.required'       => 'Sila tulis no tel pengurus',
            'emel_pengurus.required'       => 'Sila tulis emel pengurus',
        ]);


        $result = true;
        try
        { 
            DB::transaction(function () use($request, $id) {

                $vendor = Vendor::findOrFail($id);
                $vendor->nama_syarikat = $request->nama_syarikat;
                $vendor->no_tel_syarikat = $request->no_tel_syarikat;
                $vendor->alamat = $request->alamat;
                $vendor->nama_pengurus = $request->nama_pengurus;
                $vendor->no_tel_pengurus = $request->no_tel_pengurus;
                $vendor->emel_pengurus = $request->emel_pengurus;
                $vendor->status = $request->status;

                if($vendor->save())
                {
                    if(!empty($vendor->user_id))
                    {                           
                        $user = User::find($vendor->user_id);
                        $user->username = $vendor->emel_pengurus;
                        $user->password = Hash::make($vendor->no_tel_pengurus);
                        $user->is_vendor = 1;
                        $user->save();
                    }
                    
                }
            });

        }
        catch (\Exception $e)
        {
            $result = false;                
        }


        if($result)
        {
            Alert::toast('Maklumat Vendor Berjaya Dipinda', 'success');
            return redirect(route($this->baseRoute . 'index'));
        }
        else {
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
        $vendor = Vendor::find($id);
        
        if(!empty($vendor))
        {
            $vendor->delete();
        }

        Alert::toast('Maklumat vendor berjaya dihapus!', 'success');
        return redirect()->back();
    }
}
