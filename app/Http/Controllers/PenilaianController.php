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
        $penilaians_asli = Penilaian::where('id_pasar', $id_pasar)->pluck('nilai_asli', 'id_kriteria')->toArray();
        
        return view('penilaian.input', compact('pasar', 'kriterias', 'penilaians', 'penilaians_asli'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $id_pasar = $request->id_pasar;

        // Proteksi Tambahan: Jangan biarkan Kepala Pasar simpan data pasar lain
        if ($user->peran === 'Kepala Pasar' && $user->id_pasar != $id_pasar) {
            abort(403, 'Anda dilarang menyimpan penilaian untuk pasar lain.');
        }

        $nilai_pilihan = $request->nilai ?? []; // Array [id_kriteria => nilai_likert]
        $nilai_manual = $request->nilai_asli ?? []; // Array [id_kriteria => nilai_asli]

        $kriterias = Kriteria::all();

        foreach ($kriterias as $k) {
            $id_kriteria = $k->id_kriteria;
            $likertValue = null;
            $asliValue = null;

            if ($k->tipe_input == 'manual') {
                $asliValue = $nilai_manual[$id_kriteria] ?? 0;
                // Ubah koma menjadi titik agar desimalnya terbaca oleh PHP & Database
                $asliValue = str_replace(',', '.', $asliValue);
                
                // Mapping otomatis berdasarkan range
                $sub = \App\Models\SubKriteria::where('id_kriteria', $id_kriteria)
                    ->where('minimal_nilai', '<=', $asliValue)
                    ->where('maksimal_nilai', '>=', $asliValue)
                    ->first();
                
                $likertValue = $sub ? $sub->nilai_likert : 1; // Default ke 1 jika tidak ketemu range
            } else {
                $likertValue = $nilai_pilihan[$id_kriteria] ?? null;
            }

            if ($likertValue !== null) {
                Penilaian::updateOrCreate(
                    ['id_pasar' => $id_pasar, 'id_kriteria' => $id_kriteria],
                    [
                        'nilai' => $likertValue, 
                        'nilai_asli' => $asliValue,
                        'id_pengguna' => $user->id_pengguna
                    ]
                );
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan!');
    }
}
