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
        $nilai_asli_input = $request->nilai_asli ?? []; // Array [id_kriteria => nilai_angka_riil]

        $kriterias = Kriteria::with('sub_kriteria')->get();

        foreach ($kriterias as $k) {
            $id_kriteria = $k->id_kriteria;

            if ($k->tipe_input === 'manual') {
                $rawVal = $nilai_asli_input[$id_kriteria] ?? null;
                if ($rawVal !== null && $rawVal !== '') {
                    // Pencocokan otomatis dengan batas range minimal & maksimal
                    $matchedLikert = 1; // Default fallback terendah jika tidak cocok
                    foreach ($k->sub_kriteria as $sub) {
                        $min = $sub->minimal_nilai;
                        $max = $sub->maksimal_nilai;

                        if ($min !== null && $max !== null) {
                            if ($rawVal >= $min && $rawVal <= $max) {
                                $matchedLikert = $sub->nilai_likert;
                                break;
                            }
                        }
                    }

                    Penilaian::updateOrCreate(
                        ['id_pasar' => $id_pasar, 'id_kriteria' => $id_kriteria],
                        [
                            'nilai' => $matchedLikert,
                            'nilai_asli' => $rawVal,
                            'id_pengguna' => $user->id_pengguna
                        ]
                    );
                }
            } else {
                $likertValue = $nilai_pilihan[$id_kriteria] ?? null;

                if ($likertValue !== null && $likertValue !== '') {
                    Penilaian::updateOrCreate(
                        ['id_pasar' => $id_pasar, 'id_kriteria' => $id_kriteria],
                        [
                            'nilai' => $likertValue,
                            'nilai_asli' => null,
                            'id_pengguna' => $user->id_pengguna
                        ]
                    );
                }
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan!');
    }

    public function destroy($id_pasar)
    {
        $user = Auth::user();

        // Proteksi Tambahan: Jangan biarkan Kepala Pasar hapus data pasar lain
        if ($user->peran === 'Kepala Pasar' && $user->id_pasar != $id_pasar) {
            abort(403, 'Anda dilarang menghapus penilaian untuk pasar lain.');
        }

        // Hapus semua penilaian untuk pasar ini
        Penilaian::where('id_pasar', $id_pasar)->delete();

        return redirect()->route('penilaian.index')->with('success', 'Penilaian pasar berhasil dikosongkan!');
    }
}
