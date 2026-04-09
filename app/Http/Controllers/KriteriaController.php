<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::with('sub_kriteria')->get();
        return view('kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'tipe_kriteria' => 'required|numeric',
            'subs' => 'required|array|size:5', // Harus ada 5 sub kriteria (1-5)
        ]);

        DB::transaction(function() use ($request) {
            $kriteria = Kriteria::create([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot,
                'tipe_kriteria' => $request->tipe_kriteria,
            ]);

            // Simpan Sub Kriteria (Nilai 5 sampai 1)
            foreach ($request->subs as $nilai => $nama_sub) {
                SubKriteria::create([
                    'id_kriteria' => $kriteria->id_kriteria,
                    'nama_sub_kriteria' => $nama_sub,
                    'nilai_likert' => $nilai,
                ]);
            }
        });

        return redirect()->route('kriteria.index')->with('success', 'Kriteria dan Sub-Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::with('sub_kriteria')->findOrFail($id);
        // Pastikan urutan sub kriteria teratur (5 ke 1)
        $subs = $kriteria->sub_kriteria->pluck('nama_sub_kriteria', 'nilai_likert')->toArray();
        return view('kriteria.edit', compact('kriteria', 'subs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'tipe_kriteria' => 'required|numeric',
            'subs' => 'required|array|size:5',
        ]);

        DB::transaction(function() use ($request, $id) {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->update([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot,
                'tipe_kriteria' => $request->tipe_kriteria,
            ]);

            // Update atau Create Sub Kriteria
            foreach ($request->subs as $nilai => $nama_sub) {
                SubKriteria::updateOrCreate(
                    ['id_kriteria' => $kriteria->id_kriteria, 'nilai_likert' => $nilai],
                    ['nama_sub_kriteria' => $nama_sub]
                );
            }
        });

        return redirect()->route('kriteria.index')->with('success', 'Kriteria dan Sub-Kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kriteria::destroy($id);
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
