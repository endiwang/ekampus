<?php

namespace App\Http\Controllers\Main_Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AduanSalahlakuPelajar;
use App\Models\KesalahanKolejKediaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AduanSalahlakuPelajarController extends Controller
{
    protected $baseView = 'pages.main_dashboard.aduan_salahlaku_pelajar.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Aduan Salah Laku Pelajar';
        $action = route('aduan_salahlaku_pelajar.store');
        $page_title = 'Aduan Salah Laku Pelajar';
        $breadcrumbs = [
            'Aduan Salah Laku Pelajar' => false,
        ];

        $model = new AduanSalahlakuPelajar();

        $jenis_kesalahan = [
            'U' => 'Kesalahan Umum',
            'KK' => 'Kesalahan Hal-ehwal Kolej Kediaman',
        ];

        $kesalahan_kolej_kediaman = KesalahanKolejKediaman::pluck('nama_kesalahan', 'id');

        return view($this->baseView.'main', compact('model', 'title', 'breadcrumbs', 'page_title', 'action', 'jenis_kesalahan', 'kesalahan_kolej_kediaman'));
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

        $validation = $request->validate([
            'nama_pelaku' => 'required',
            'tarikh_kes' => 'required',
            'masa_kes' => 'required',
            'tempat_kes' => 'required',
            'jenis_kesalahan' => 'required',
            'aduan' => 'required',
            'bukti_1' => 'required',
        ], [
            'nama_pelaku.required' => 'Sila masukkan nama pelaku',
            'tarikh_kes.required' => 'Sila masukkan tarikh kes',
            'masa_kes.required' => 'Sila masukkan masa kes',
            'tempat_kes.required' => 'Sila masukkan tempat kes',
            'jenis_kesalahan.required' => 'Sila pilih jenis kesalahan',
            'aduan.required' => 'Sila tulis keterangan aduan anda',
            'bukti_1.required' => 'Sila muat naik bukti',
        ]);

        $bukti_1 = uniqid().'.'.$request->bukti_1->getClientOriginalExtension();
        $bukti_1_path = 'uploads/aduan_salahlaku/bukti';
        $file_bukti_1 = $request->file('bukti_1')->storeAs($bukti_1_path, $bukti_1, 'public');

        $request->request->add([
            'tarikh_aduan' => Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d'),
            'masa_aduan' => Carbon::now('Asia/Kuala_Lumpur')->format('H:i'),
            'user_id' => Auth::user()->id,
            'tarikh_kes' => Carbon::createFromFormat('d/m/Y', $request->tarikh_kes)->format('Y-m-d'),
            'bukti' => $file_bukti_1,
        ]);

        if($request->has('bukti_2'))
        {
            $bukti_2 = uniqid().'.'.$request->bukti_2->getClientOriginalExtension();
            $bukti_2_path = 'uploads/aduan_salahlaku/bukti';
            $file_bukti_2 = $request->file('bukti_2');
            $file_bukti_2->move($bukti_2_path, $bukti_2);
            $file_bukti_2 = $bukti_2_path.'/'.$bukti_2;
            $request->request->add([
                'bukti_2' => $file_bukti_2,
            ]);
        }

        if($request->has('bukti_3'))
        {
            $bukti_3 = uniqid().'.'.$request->bukti_3->getClientOriginalExtension();
            $bukti_3_path = 'uploads/aduan_salahlaku/bukti';
            $file_bukti_3 = $request->file('bukti_3');
            $file_bukti_3->move($bukti_3_path, $bukti_3);
            $file_bukti_3 = $bukti_3_path.'/'.$bukti_3;
            $request->request->add([
                'bukti_3' => $file_bukti_3,
            ]);
        }

        $aduan = AduanSalahlakuPelajar::create($request->all());

        Alert::toast('Aduan berjaya dihantar!', 'success');

        return redirect()->route('home');

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
