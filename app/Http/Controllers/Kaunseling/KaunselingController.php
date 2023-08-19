<?php

namespace App\Http\Controllers\Kaunseling;

use App\Http\Controllers\Controller;
use App\Jobs\Kaunseling\PermohonBaruJob;
use App\Models\Kaunseling;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KaunselingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('kaunseling.dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.kaunseling.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Kaunseling::class);

        $this->validate($request, [
            'jenis_fasiliti' => 'required',
            'tarikh_permohonan' => 'required|date',
        ]);

        $kaunseling = Kaunseling::create([
            'jenis_fasiliti' => $request->jenis_fasiliti,
            'tarikh_permohonan' => $request->tarikh_permohonan,
            'status' => Kaunseling::STATUS_BARU,
            'user_id' => auth()->id(),
            'no_permohonan' => 'K-'.date('Ymd').'-'.rand(1000, 9999),
        ]);

        Alert::success('Berjaya! Permohonan kaunseling anda telah berjaya dihantar.');

        PermohonBaruJob::dispatch($kaunseling);

        return redirect()->route('kaunseling.show', $kaunseling->id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Kaunseling $kaunseling)
    {
        $this->authorize('view', $kaunseling);

        return view('pages.kaunseling.show', compact('kaunseling'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Kaunseling $kaunseling)
    {
        $this->authorize('update', $kaunseling);

        return view('pages.kaunseling.form', compact('kaunseling'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kaunseling $kaunseling)
    {
        $this->authorize('store', Kaunseling::class);

        $this->validate($request, [
            'jenis_fasiliti' => 'required',
            'tarikh_permohonan' => 'required|date',
        ]);

        $kaunseling->update([
            'jenis_fasiliti' => $request->jenis_fasiliti,
            'tarikh_permohonan' => $request->tarikh_permohonan,
        ]);

        Alert::success('Berjaya! Permohonan kaunseling anda telah berjaya dikemaskini.');

        return redirect()->route('kaunseling.dashboard.show', $kaunseling->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kaunseling $kaunseling)
    {
        $this->authorize('delete', $kaunseling);

        $kaunseling->delete();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berjaya! Permohonan kaunseling anda telah berjaya dipadam.',
        ]);

        return redirect()->route('kaunseling.dashboard.index');
    }
}
