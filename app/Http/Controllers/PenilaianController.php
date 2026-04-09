<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // JIKA Kepala Pasar, hanya tampilkan pasarnya sendiri
        if ($user->peran === 'Kepala Pasar') {
            $pasars = Pasar::where('id_pasar', $user->id_pasar)->get();
        } else {
            // Admin bisa melihat semua
            $pasars = Pasar::all();
        }

        // Cek status penilaian untuk setiap pasar
        foreach ($pasars as $pasar) {
            $count = Penilaian::where('id_pasar', $pasar->id_pasar)->count();
            $kriteriaCount = Kriteria::count();
            $pasar->is_evaluated = ($count >= $kriteriaCount && $kriteriaCount > 0);
        }
        
        return view('penilaian.index', compact('pasars'));
    }

    public function input($id_pasar)
    {
        $user = Auth::user();

        // Proteksi Tambahan: Jangan biarkan Kepala Pasar input pasar lain lewat URL
        if ($user->peran === 'Kepala Pasar' && $user->id_pasar != $id_pasar) {
            abort(403, 'Anda tidak memiliki hak akses untuk memberikan penilaian pada pasar lain.');
        }

        $pasar = Pasar::findOrFail($id_pasar);
        $kriterias = Kriteria::with('sub_kriteria')->get();
        
        // Ambil nilai yang sudah ada jika ada
        $penilaians = Penilaian::where('id_pasar', $id_pasar)->pluck('nilai', 'id_kriteria')->toArray();
        
        return view('penilaian.input', compact('pasar', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $id_pasar = $request->id_pasar;

        // Proteksi Tambahan: Jangan biarkan Kepala Pasar simpan data pasar lain
        if ($user->peran === 'Kepala Pasar' && $user->id_pasar != $id_pasar) {
            abort(403, 'Anda dilarang menyimpan penilaian untuk pasar lain.');
        }

        $nilai = $request->nilai; // Array [id_kriteria => nilai]

        foreach ($nilai as $id_kriteria => $val) {
            Penilaian::updateOrCreate(
                ['id_pasar' => $id_pasar, 'id_kriteria' => $id_kriteria],
                ['nilai' => $val, 'id_pengguna' => $user->id_pengguna]
            );
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan!');
    }
}
