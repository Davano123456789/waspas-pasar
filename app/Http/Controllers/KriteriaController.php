<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = Kriteria::all();
        return view('kriteria.index', compact('kriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'tipe_kriteria' => 'required|numeric',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        return redirect()->route('kriteria.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'tipe_kriteria' => 'required|numeric',
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Kriteria::destroy($id);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
