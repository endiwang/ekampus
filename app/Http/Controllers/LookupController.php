<?php

namespace App\Http\Controllers;

use App\DataTables\LookupDataTable;
use App\Models\Lookup;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LookupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LookupDataTable $dataTable)
    {
        $this->authorize('viewAny', Lookup::class);

        abort_if($request->category && !in_array($request->category, Lookup::categories()), 404);

        return $dataTable->render('lookup.index', ['category' => $request->category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lookup.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Lookup::class);

        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'key' => 'required|min:3|max:255',
            // 'values' => 'required|array',
            'category' => 'required|min:3|max:255',
        ]);

        $lookup = Lookup::create($request->only([
            'name',
            'description',
            'key',
            'value',
            'values',
            'category',
        ]));

        Alert::success('Maklumat berjaya disimpan.');

        return redirect()->route('lookup.show', $lookup->id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Lookup $lookup)
    {
        return view('lookup.show', compact('lookup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Lookup $lookup)
    {
        return view('lookup.form', $lookup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lookup $lookup)
    {
        $this->authorize('create', $lookup);

        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'key' => 'required|min:3|max:255',
            // 'values' => 'required|array',
            'category' => 'required|min:3|max:255',
        ]);

        $lookup->update($request->only([
            'name',
            'description',
            'key',
            'value',
            'values',
            'category',
        ]));

        Alert::success('Maklumat berjaya disimpan.');

        return redirect()->route('lookup.show', $lookup->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lookup $lookup)
    {
        //
    }
}
