<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Pasar;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\HasilWaspas;

class SkripsiDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan Data Lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        HasilWaspas::truncate();
        Penilaian::truncate();
        SubKriteria::truncate();
        Kriteria::truncate();
        User::truncate(); // Hapus semua demi keamanan seeder baru
        Pasar::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1.5 Buat Akun Admin Utama
        User::create([
            'id_pengguna' => 1,
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'nama_lengkap' => 'Administrator Utama',
            'peran' => 'Admin',
            'id_pasar' => null,
        ]);

        // 2. Insert Kriteria
        $kriterias = [
            ['id_kriteria' => 1, 'nama_kriteria' => 'Realisasi Retribusi', 'bobot' => 0.5, 'tipe_kriteria' => 1, 'tipe_input' => 'manual', 'satuan' => '%'],
            ['id_kriteria' => 2, 'nama_kriteria' => 'Jumlah Pengunjung', 'bobot' => 0.15, 'tipe_kriteria' => 1, 'tipe_input' => 'pilihan', 'satuan' => null],
            ['id_kriteria' => 3, 'nama_kriteria' => 'Kebersihan', 'bobot' => 0.1, 'tipe_kriteria' => 1, 'tipe_input' => 'pilihan', 'satuan' => null],
            ['id_kriteria' => 4, 'nama_kriteria' => 'Keamanan', 'bobot' => 0.1, 'tipe_kriteria' => 1, 'tipe_input' => 'pilihan', 'satuan' => null],
            ['id_kriteria' => 5, 'nama_kriteria' => 'Kondisi Bangunan', 'bobot' => 0.15, 'tipe_kriteria' => 1, 'tipe_input' => 'pilihan', 'satuan' => null],
        ];
        foreach ($kriterias as $k) { Kriteria::create($k); }

        // 3. Insert Sub Kriteria (DENGAN RANGE NILAI)
        $subs = [
            // C1 (Retribusi - Persentase)
            ['id_kriteria' => 1, 'nilai_likert' => 5, 'nama_sub_kriteria' => '95% – 100%', 'minimal_nilai' => 95, 'maksimal_nilai' => 100],
            ['id_kriteria' => 1, 'nilai_likert' => 4, 'nama_sub_kriteria' => '85% – 94%', 'minimal_nilai' => 85, 'maksimal_nilai' => 94.99],
            ['id_kriteria' => 1, 'nilai_likert' => 3, 'nama_sub_kriteria' => '75% – 84%', 'minimal_nilai' => 75, 'maksimal_nilai' => 84.99],
            ['id_kriteria' => 1, 'nilai_likert' => 2, 'nama_sub_kriteria' => '60% – 74%', 'minimal_nilai' => 60, 'maksimal_nilai' => 74.99],
            ['id_kriteria' => 1, 'nilai_likert' => 1, 'nama_sub_kriteria' => '< 60%', 'minimal_nilai' => 0, 'maksimal_nilai' => 59.99],
            
            // C2 (Jumlah Pengunjung - Orang)
            ['id_kriteria' => 2, 'nilai_likert' => 5, 'nama_sub_kriteria' => '≥ 1.000 orang per hari', 'minimal_nilai' => 1000, 'maksimal_nilai' => 9999999],
            ['id_kriteria' => 2, 'nilai_likert' => 4, 'nama_sub_kriteria' => '751 – 999 orang per hari', 'minimal_nilai' => 751, 'maksimal_nilai' => 999],
            ['id_kriteria' => 2, 'nilai_likert' => 3, 'nama_sub_kriteria' => '501 – 750 orang per hari', 'minimal_nilai' => 501, 'maksimal_nilai' => 750],
            ['id_kriteria' => 2, 'nilai_likert' => 2, 'nama_sub_kriteria' => '251 – 500 orang per hari', 'minimal_nilai' => 251, 'maksimal_nilai' => 500],
            ['id_kriteria' => 2, 'nilai_likert' => 1, 'nama_sub_kriteria' => '≤ 250 orang per hari', 'minimal_nilai' => 0, 'maksimal_nilai' => 250],
            
            // C3 (Kebersihan - Pilihan)
            ['id_kriteria' => 3, 'nilai_likert' => 5, 'nama_sub_kriteria' => 'Sangat Baik (Pengelolaan sampah sangat baik)'],
            ['id_kriteria' => 3, 'nilai_likert' => 4, 'nama_sub_kriteria' => 'Baik (Pengelolaan sampah cukup baik)'],
            ['id_kriteria' => 3, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Cukup (Kurang konsisten)'],
            ['id_kriteria' => 3, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Tidak Baik (Sampah sering menumpuk)'],
            ['id_kriteria' => 3, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Sangat Tidak Baik (Lingkungan sangat kotor)'],
            
            // C4 (Keamanan - Pilihan)
            ['id_kriteria' => 4, 'nilai_likert' => 5, 'nama_sub_kriteria' => 'Sangat Baik (Sangat aman dan tertib)'],
            ['id_kriteria' => 4, 'nilai_likert' => 4, 'nama_sub_kriteria' => 'Baik (Relatif aman dan terkendali)'],
            ['id_kriteria' => 4, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Cukup (Keamanan cukup terjaga)'],
            ['id_kriteria' => 4, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Tidak Baik (Petugas kurang memadai)'],
            ['id_kriteria' => 4, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Sangat Tidak Baik (Tidak ada pengamanan)'],
            
            // C5 (Kondisi Bangunan - Pilihan)
            ['id_kriteria' => 5, 'nilai_likert' => 5, 'nama_sub_kriteria' => 'Sangat Baik (Struktur sangat kokoh)'],
            ['id_kriteria' => 5, 'nilai_likert' => 4, 'nama_sub_kriteria' => 'Baik (Struktur baik)'],
            ['id_kriteria' => 5, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Cukup (Cukup layak)'],
            ['id_kriteria' => 5, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Tidak Baik (Struktur mulai rusak)'],
            ['id_kriteria' => 5, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Sangat Tidak Baik (Bangunan tidak layak)'],
        ];
        foreach ($subs as $s) { SubKriteria::create($s); }

        // 4. Insert Pasar & Buat Akun Cabang
        $pasars = [
            ['id_pasar' => 1, 'nama_pasar' => 'Simo', 'alamat' => 'Surabaya'],
            ['id_pasar' => 2, 'nama_pasar' => 'Pabean', 'alamat' => 'Surabaya'],
            ['id_pasar' => 3, 'nama_pasar' => 'Babaan', 'alamat' => 'Surabaya'],
            ['id_pasar' => 4, 'nama_pasar' => 'Pecindilan', 'alamat' => 'Surabaya'],
            ['id_pasar' => 5, 'nama_pasar' => 'Pegirian', 'alamat' => 'Surabaya'],
        ];
        foreach ($pasars as $p) { 
            $newPasar = Pasar::create($p); 
            User::create([
                'username' => strtolower($p['nama_pasar']),
                'password' => Hash::make('rahasia'),
                'nama_lengkap' => 'Kepala Pasar ' . $p['nama_pasar'],
                'peran' => 'Kepala Pasar',
                'id_pasar' => $newPasar->id_pasar,
            ]);
        }

        // 5. Insert Penilaian Awal (Contoh Input Manual)
        // Kita gunakan nilai_asli untuk yang manual, dan nilai (Likert) tetap dihitung.
        $ratings = [
            1 => [1 => 70, 2 => 3, 3 => 3, 4 => 2, 5 => 2], // Simo
            2 => [1 => 65, 2 => 4, 3 => 4, 4 => 4, 5 => 4], // Pabean
            3 => [1 => 96, 2 => 3, 3 => 3, 4 => 3, 5 => 3], // Babaan
            4 => [1 => 50, 2 => 3, 3 => 2, 4 => 3, 5 => 2], // Pecindilan
            5 => [1 => 60, 2 => 3, 3 => 3, 4 => 3, 5 => 3], // Pegirian
        ];

        foreach ($ratings as $idPasar => $vals) {
            foreach ($vals as $idKrit => $val) {
                // Cari kriteria untuk cek tipe_input
                $k = Kriteria::find($idKrit);
                $likert = $val;
                $asli = null;

                if ($k->tipe_input == 'manual') {
                    $asli = $val;
                    // Cari likert berdasarkan range
                    $sub = SubKriteria::where('id_kriteria', $idKrit)
                        ->where('minimal_nilai', '<=', $val)
                        ->where('maksimal_nilai', '>=', $val)
                        ->first();
                    $likert = $sub ? $sub->nilai_likert : 1;
                }

                Penilaian::create([
                    'id_pasar' => $idPasar,
                    'id_kriteria' => $idKrit,
                    'nilai' => $likert,
                    'nilai_asli' => $asli,
                    'id_pengguna' => 1,
                ]);
            }
        }
    }
}
