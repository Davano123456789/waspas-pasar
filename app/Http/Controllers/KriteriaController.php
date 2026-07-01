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
            'tipe_input' => 'required|string|in:pilihan,manual',
            'satuan' => 'nullable|string|max:50',
            'subs' => 'required|array',
            'subs.1' => 'required|string|max:255',
            'subs.2' => 'required|string|max:255',
            'subs.3' => 'required|string|max:255',
        ]);

        if ($request->tipe_input === 'manual') {
            foreach ($request->subs as $nilai => $nama_sub) {
                if (!empty($nama_sub)) {
                    if ($request->input("subs_min.{$nilai}") === null || $request->input("subs_max.{$nilai}") === null) {
                        return back()->withErrors(["subs_min.{$nilai}" => "Batas nilai min/max untuk Nilai {$nilai} wajib diisi jika tipe input manual."])->withInput();
                    }
                }
            }
        }

        DB::transaction(function() use ($request) {
            $kriteria = Kriteria::create([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot,
                'tipe_kriteria' => $request->tipe_kriteria,
                'tipe_input' => $request->tipe_input,
                'satuan' => $request->satuan,
            ]);

            // Simpan Sub Kriteria (Hanya jika diisi)
            foreach ($request->subs as $nilai => $nama_sub) {
                if (!empty($nama_sub)) {
                    $min = ($request->tipe_input === 'manual') ? ($request->input("subs_min.{$nilai}") ?? null) : null;
                    $max = ($request->tipe_input === 'manual') ? ($request->input("subs_max.{$nilai}") ?? null) : null;

                    SubKriteria::create([
                        'id_kriteria' => $kriteria->id_kriteria,
                        'nama_sub_kriteria' => $nama_sub,
                        'nilai_likert' => $nilai,
                        'minimal_nilai' => $min,
                        'maksimal_nilai' => $max,
                    ]);
                }
            }
        });

        return redirect()->route('kriteria.index')->with('success', 'Kriteria dan Sub-Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::with('sub_kriteria')->findOrFail($id);
        // Pastikan urutan sub kriteria teratur (5 ke 1)
        $subs = $kriteria->sub_kriteria->keyBy('nilai_likert')->toArray();
        return view('kriteria.edit', compact('kriteria', 'subs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'tipe_kriteria' => 'required|numeric',
            'tipe_input' => 'required|string|in:pilihan,manual',
            'satuan' => 'nullable|string|max:50',
            'subs' => 'required|array',
            'subs.1' => 'required|string|max:255',
            'subs.2' => 'required|string|max:255',
            'subs.3' => 'required|string|max:255',
        ]);

        if ($request->tipe_input === 'manual') {
            foreach ($request->subs as $nilai => $nama_sub) {
                if (!empty($nama_sub)) {
                    if ($request->input("subs_min.{$nilai}") === null || $request->input("subs_max.{$nilai}") === null) {
                        return back()->withErrors(["subs_min.{$nilai}" => "Batas nilai min/max untuk Nilai {$nilai} wajib diisi jika tipe input manual."])->withInput();
                    }
                }
            }
        }

        DB::transaction(function() use ($request, $id) {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->update([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot,
                'tipe_kriteria' => $request->tipe_kriteria,
                'tipe_input' => $request->tipe_input,
                'satuan' => $request->satuan,
            ]);

            // Update, Create, atau Delete Sub Kriteria
            foreach ($request->subs as $nilai => $nama_sub) {
                if (!empty($nama_sub)) {
                    $min = ($request->tipe_input === 'manual') ? ($request->input("subs_min.{$nilai}") ?? null) : null;
                    $max = ($request->tipe_input === 'manual') ? ($request->input("subs_max.{$nilai}") ?? null) : null;

                    SubKriteria::updateOrCreate(
                        ['id_kriteria' => $kriteria->id_kriteria, 'nilai_likert' => $nilai],
                        [
                            'nama_sub_kriteria' => $nama_sub,
                            'minimal_nilai' => $min,
                            'maksimal_nilai' => $max,
                        ]
                    );
                } else {
                    SubKriteria::where('id_kriteria', $kriteria->id_kriteria)
                        ->where('nilai_likert', $nilai)
                        ->delete();
                }
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
