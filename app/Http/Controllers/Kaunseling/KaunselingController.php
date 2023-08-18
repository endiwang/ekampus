<?php

namespace App\Http\Controllers\Kaunseling;

use App\Enums\StatusKaunseling;
use App\Http\Controllers\Controller;
use App\Models\Kaunseling;
use Illuminate\Http\Request;

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
        return view('pages.kaunseling.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', Kaunseling::class);

        $this->validate($request, [
            'jenis_fasiliti' => 'required',
            'tarikh_permohonan' => 'required|date',
        ]);

        $kaunseling = Kaunseling::create([
            'jenis_fasiliti' => $request->jenis_fasiliti,
            'tarikh_permohonan' => $request->tarikh_permohonan,
            'status' => StatusKaunseling::baru()->value,
            'user_id' => auth()->id(),
            'no_permohonan' => 'K' . date('YmdHi') . rand(1000, 9999),
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berjaya! Permohonan kaunseling anda telah berjaya dihantar.'
        ]);

        return redirect()->route('kaunseling.dashboard.show', $kaunseling->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kaunseling  $kaunseling
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
     * @param  \App\Models\Kaunseling  $kaunseling
     * @return \Illuminate\Http\Response
     */
    public function edit(Kaunseling $kaunseling)
    {
        $this->authorize('update', $kaunseling);

        return view('pages.kaunseling.show', compact('kaunseling'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kaunseling  $kaunseling
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

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berjaya! Permohonan kaunseling anda telah berjaya dikemaskini.'
        ]);

        return redirect()->route('kaunseling.dashboard.show', $kaunseling->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kaunseling  $kaunseling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kaunseling $kaunseling)
    {
        $this->authorize('delete', $kaunseling);

        $kaunseling->delete();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berjaya! Permohonan kaunseling anda telah berjaya dipadam.'
        ]);

        return redirect()->route('kaunseling.dashboard.index');
    }
}
