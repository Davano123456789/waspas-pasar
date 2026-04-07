<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilWaspas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WaspasController extends Controller
{
    /**
     * Menampilkan daftar riwayat perhitungan (Grup by batch_id)
     */
    public function index()
    {
        $history = HasilWaspas::select('batch_id', 'created_at')
            ->groupBy('batch_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('waspas.index', compact('history'));
    }

    /**
     * Melakukan proses perhitungan detail (Step-by-step)
     */
    public function hitung()
    {
        $kriterias = Kriteria::all();
        $pasars = Pasar::all();
        
        $evaluatedPasars = $pasars->filter(function($pasar) use ($kriterias) {
            return Penilaian::where('id_pasar', $pasar->id_pasar)->count() >= $kriterias->count() && $kriterias->count() > 0;
        });

        if ($evaluatedPasars->isEmpty()) {
            return view('waspas.hitung', [
                'error' => 'Belum ada data penilaian yang lengkap untuk dilakukan perhitungan.'
            ]);
        }

        $matrix = [];
        foreach ($evaluatedPasars as $pasar) {
            foreach ($kriterias as $k) {
                $nilai = Penilaian::where('id_pasar', $pasar->id_pasar)
                                 ->where('id_kriteria', $k->id_kriteria)
                                 ->first();
                $matrix[$pasar->id_pasar][$k->id_kriteria] = $nilai ? $nilai->nilai : 0;
            }
        }

        $maxValues = [];
        $minValues = [];
        foreach ($kriterias as $k) {
            $columnValues = array_column($matrix, $k->id_kriteria);
            $maxValues[$k->id_kriteria] = !empty($columnValues) ? max($columnValues) : 0;
            $minValues[$k->id_kriteria] = !empty($columnValues) ? min($columnValues) : 0;
        }

        $normalizedMatrix = [];
        foreach ($evaluatedPasars as $pasar) {
            foreach ($kriterias as $k) {
                $val = $matrix[$pasar->id_pasar][$k->id_kriteria];
                if ($k->tipe_kriteria == 1) { // Benefit
                    $normalizedMatrix[$pasar->id_pasar][$k->id_kriteria] = $maxValues[$k->id_kriteria] > 0 ? $val / $maxValues[$k->id_kriteria] : 0;
                } else { // Cost
                    $normalizedMatrix[$pasar->id_pasar][$k->id_kriteria] = $val > 0 ? $minValues[$k->id_kriteria] / $val : 0;
                }
            }
        }

        $results = [];
        $lambda = 0.5;
        foreach ($evaluatedPasars as $pasar) {
            $wsm = 0;
            $wpm = 1;
            foreach ($kriterias as $k) {
                $r = $normalizedMatrix[$pasar->id_pasar][$k->id_kriteria];
                $w = $k->bobot;
                $wsm += ($r * $w);
                $wpm *= pow($r, $w);
            }
            $qi = ($lambda * $wsm) + ((1 - $lambda) * $wpm);
            $results[] = [
                'id_pasar' => $pasar->id_pasar,
                'nama_pasar' => $pasar->nama_pasar,
                'wsm' => $wsm,
                'wpm' => $wpm,
                'qi' => $qi
            ];
        }

        usort($results, function($a, $b) {
            return $b['qi'] <=> $a['qi'];
        });

        foreach ($results as $index => &$res) {
            $res['rank'] = $index + 1;
        }

        return view('waspas.hitung', compact('kriterias', 'evaluatedPasars', 'matrix', 'normalizedMatrix', 'results'));
    }

    /**
     * Menyimpan hasil perhitungan ke tabel hasil_waspas dengan batch_id baru
     */
    public function simpan(Request $request)
    {
        $data = $request->input('hasil');
        $batch_id = 'BATCH-' . strtoupper(Str::random(8));

        DB::transaction(function() use ($data, $batch_id) {
            foreach ($data as $row) {
                HasilWaspas::create([
                    'batch_id' => $batch_id,
                    'id_pasar' => $row['id_pasar'],
                    'id_pengguna' => 1,
                    'skor_wsm' => $row['wsm'],
                    'skor_wpm' => $row['wpm'],
                    'skor_total_qi' => $row['qi'],
                    'rangking' => $row['rank'],
                ]);
            }
        });

        return redirect()->route('waspas.index')->with('success', 'Perhitungan berhasil disimpan kedalam riwayat!');
    }

    /**
     * Menampilkan detail dari satu riwayat perhitungan
     */
    public function show($batch_id)
    {
        $hasil = HasilWaspas::with('pasar')
            ->where('batch_id', $batch_id)
            ->orderBy('rangking', 'asc')
            ->get();
            
        if ($hasil->isEmpty()) {
            return redirect()->route('waspas.index')->with('error', 'Riwayat tidak ditemukan.');
        }

        return view('waspas.show', compact('hasil', 'batch_id'));
    }

    /**
     * Menghapus satu batch riwayat
     */
    public function destroy($batch_id)
    {
        HasilWaspas::where('batch_id', $batch_id)->delete();
        return redirect()->route('waspas.index')->with('success', 'Riwayat perhitungan berhasil dihapus.');
    }

    /**
     * Menampilkan halaman cetak laporan yang bersih untuk print/PDF
     * Termasuk detail tahapan perhitungan (X dan R)
     */
    public function cetak($batch_id)
    {
        $hasil = HasilWaspas::with('pasar')
            ->where('batch_id', $batch_id)
            ->orderBy('rangking', 'asc')
            ->get();
            
        if ($hasil->isEmpty()) {
            return redirect()->route('waspas.index')->with('error', 'Data laporan tidak ditemukan.');
        }

        $kriterias = Kriteria::all();
        $evaluatedPasars = Pasar::whereIn('id_pasar', $hasil->pluck('id_pasar'))->get();

        // --- Rekonstruksi Matriks untuk Laporan Cetak ---
        $matrix = [];
        foreach ($evaluatedPasars as $pasar) {
            foreach ($kriterias as $k) {
                $nilai = Penilaian::where('id_pasar', $pasar->id_pasar)
                                 ->where('id_kriteria', $k->id_kriteria)
                                 ->first();
                $matrix[$pasar->id_pasar][$k->id_kriteria] = $nilai ? $nilai->nilai : 0;
            }
        }

        $maxValues = [];
        $minValues = [];
        foreach ($kriterias as $k) {
            $columnValues = array_column($matrix, $k->id_kriteria);
            $maxValues[$k->id_kriteria] = !empty($columnValues) ? max($columnValues) : 0;
            $minValues[$k->id_kriteria] = !empty($columnValues) ? min($columnValues) : 0;
        }

        $normalizedMatrix = [];
        foreach ($evaluatedPasars as $pasar) {
            foreach ($kriterias as $k) {
                $val = $matrix[$pasar->id_pasar][$k->id_kriteria];
                if ($k->tipe_kriteria == 1) { // Benefit
                    $normalizedMatrix[$pasar->id_pasar][$k->id_kriteria] = $maxValues[$k->id_kriteria] > 0 ? $val / $maxValues[$k->id_kriteria] : 0;
                } else { // Cost
                    $normalizedMatrix[$pasar->id_pasar][$k->id_kriteria] = $val > 0 ? $minValues[$k->id_kriteria] / $val : 0;
                }
            }
        }

        return view('waspas.cetak', compact('hasil', 'batch_id', 'kriterias', 'evaluatedPasars', 'matrix', 'normalizedMatrix'));
    }
}
