<?php

namespace App\Http\Controllers;

use App\Models\AnnulmentIndv;
use Illuminate\Http\Request;

class AnnulmentIndvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annulmentIndv = AnnulmentIndv::where('is_active', true)->orderBy('annulment_indv_id')->get();
        return view('annulment-indv.index', compact('annulmentIndv'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('annulment-indv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'annulment_indv_id' => 'required|string|unique:annulment_indv,annulment_indv_id',
            'annulment_indv_position' => 'required|string',
            'annulment_indv_branch' => 'required|string',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        AnnulmentIndv::create($request->all());

        return redirect()->route('annulment-indv.index')
            ->with('success', 'Annulment Individual created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnulmentIndv $annulmentIndv)
    {
        return view('annulment-indv.show', compact('annulmentIndv'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnnulmentIndv $annulmentIndv)
    {
        return view('annulment-indv.edit', compact('annulmentIndv'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnulmentIndv $annulmentIndv)
    {
        $request->validate([
            'annulment_indv_id' => 'required|string|unique:annulment_indv,annulment_indv_id,' . $annulmentIndv->id,
            'annulment_indv_position' => 'required|string',
            'annulment_indv_branch' => 'required|string',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $annulmentIndv->update($request->all());

        return redirect()->route('annulment-indv.index')
            ->with('success', 'Annulment Individual updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnulmentIndv $annulmentIndv)
    {
        $annulmentIndv->update(['is_active' => false]);

        return redirect()->route('annulment-indv.index')
            ->with('success', 'Annulment Individual deactivated successfully.');
    }
}
