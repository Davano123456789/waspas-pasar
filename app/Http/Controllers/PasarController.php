<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use Illuminate\Http\Request;

class PasarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasars = Pasar::all();
        return view('pasar.index', compact('pasars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasar' => 'required',
            'alamat' => 'required',
        ]);

        $pasar = Pasar::create($request->all());

        // Otomatis bikin akun Kepala Pasar
        $username = strtolower(str_replace(' ', '', $pasar->nama_pasar));
        \App\Models\User::create([
            'username' => $username,
            'password' => bcrypt('rahasia'),
            'nama_lengkap' => 'Kepala ' . $pasar->nama_pasar,
            'peran' => 'Kepala Pasar',
            'id_pasar' => $pasar->id_pasar,
        ]);

        return redirect()->route('pasar.index')->with('success', 'Data pasar dan akun kepala pasar berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pasar = Pasar::findOrFail($id);
        return view('pasar.edit', compact('pasar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasar' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $pasar = Pasar::findOrFail($id);
        $pasar->update($request->all());

        return redirect()->route('pasar.index')->with('success', 'Data Pasar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Pasar::destroy($id);

        return redirect()->route('pasar.index')->with('success', 'Data Pasar berhasil dihapus!');
    }
}
