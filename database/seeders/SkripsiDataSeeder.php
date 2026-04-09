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
        // Jangan hapus Admin (id=1), tapi hapus penguna lain
        User::where('id_pengguna', '>', 1)->delete();
        Pasar::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Insert Kriteria
        $kriterias = [
            ['id_kriteria' => 1, 'nama_kriteria' => 'Realisasi Retribusi', 'bobot' => 0.5, 'tipe_kriteria' => 1],
            ['id_kriteria' => 2, 'nama_kriteria' => 'Jumlah Pengunjung', 'bobot' => 0.15, 'tipe_kriteria' => 1],
            ['id_kriteria' => 3, 'nama_kriteria' => 'Kebersihan', 'bobot' => 0.1, 'tipe_kriteria' => 1],
            ['id_kriteria' => 4, 'nama_kriteria' => 'Keamanan', 'bobot' => 0.1, 'tipe_kriteria' => 1],
            ['id_kriteria' => 5, 'nama_kriteria' => 'Kondisi Bangunan', 'bobot' => 0.15, 'tipe_kriteria' => 1],
        ];
        foreach ($kriterias as $k) { Kriteria::create($k); }

        // 3. Insert Sub Kriteria
        $subs = [
            // C1
            ['id_kriteria' => 1, 'nilai_likert' => 5, 'nama_sub_kriteria' => '95% – 100%'],
            ['id_kriteria' => 1, 'nilai_likert' => 4, 'nama_sub_kriteria' => '85% – 94%'],
            ['id_kriteria' => 1, 'nilai_likert' => 3, 'nama_sub_kriteria' => '75% – 84%'],
            ['id_kriteria' => 1, 'nilai_likert' => 2, 'nama_sub_kriteria' => '60% – 74%'],
            ['id_kriteria' => 1, 'nilai_likert' => 1, 'nama_sub_kriteria' => '< 60%'],
            // C2
            ['id_kriteria' => 2, 'nilai_likert' => 5, 'nama_sub_kriteria' => '≥ 1.000 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 4, 'nama_sub_kriteria' => '751 – 999 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 3, 'nama_sub_kriteria' => '501 – 750 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 2, 'nama_sub_kriteria' => '251 – 500 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 1, 'nama_sub_kriteria' => '≤ 250 orang per hari'],
            // C3
            ['id_kriteria' => 3, 'nilai_likert' => 5, 'nama_sub_kriteria' => 'Sangat Baik (Pengelolaan sampah & limbah sangat baik)'],
            ['id_kriteria' => 3, 'nilai_likert' => 4, 'nama_sub_kriteria' => 'Baik (Pengelolaan sampah cukup baik, sedikit penumpukan)'],
            ['id_kriteria' => 3, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Cukup (Kurang konsisten, beberapa area kotor)'],
            ['id_kriteria' => 3, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Tidak Baik (Sampah sering menumpuk)'],
            ['id_kriteria' => 3, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Sangat Tidak Baik (Lingkungan sangat kotor)'],
            // C4
            ['id_kriteria' => 4, 'nilai_likert' => 5, 'nama_sub_kriteria' => 'Sangat Baik (Kondisi pasar sangat aman dan tertib)'],
            ['id_kriteria' => 4, 'nilai_likert' => 4, 'nama_sub_kriteria' => 'Baik (Kondisi pasar relatif aman dan terkendali)'],
            ['id_kriteria' => 4, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Cukup (Keamanan cukup terjaga walau petugas terbatas)'],
            ['id_kriteria' => 4, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Tidak Baik (Petugas kurang memadai, kurang aman)'],
            ['id_kriteria' => 4, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Sangat Tidak Baik (Tidak ada pengamanan memadai)'],
            // C5
            ['id_kriteria' => 5, 'nilai_likert' => 5, 'nama_sub_kriteria' => 'Sangat Baik (Struktur sangat kokoh, tata letak rapi)'],
            ['id_kriteria' => 5, 'nilai_likert' => 4, 'nama_sub_kriteria' => 'Baik (Struktur baik, tata letak cukup teratur)'],
            ['id_kriteria' => 5, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Cukup (Cukup layak, tata letak kurang tertata)'],
            ['id_kriteria' => 5, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Tidak Baik (Struktur mulai rusak, tidak teratur)'],
            ['id_kriteria' => 5, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Sangat Tidak Baik (Bangunan tidak layak digunakan)'],
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

        // 5. Insert Penilaian (Sesuai Matriks Excel - Likert 1-5)
        /*
        A1 Simo: 2,3,3,2,2
        A2 Pabean: 2,4,4,4,4
        A3 Babaan: 4,3,3,3,3
        A4 Pecindilan: 1,3,2,3,2
        A5 Pegirian: 2,3,3,3,3
        */
        $ratings = [
            1 => [1 => 2, 2 => 3, 3 => 3, 4 => 2, 5 => 2],
            2 => [1 => 2, 2 => 4, 3 => 4, 4 => 4, 5 => 4],
            3 => [1 => 4, 2 => 3, 3 => 3, 4 => 3, 5 => 3],
            4 => [1 => 1, 2 => 3, 3 => 2, 4 => 3, 5 => 2],
            5 => [1 => 2, 2 => 3, 3 => 3, 4 => 3, 5 => 3],
        ];

        foreach ($ratings as $idPasar => $vals) {
            foreach ($vals as $idKrit => $val) {
                Penilaian::create([
                    'id_pasar' => $idPasar,
                    'id_kriteria' => $idKrit,
                    'nilai' => $val,
                    'id_pengguna' => 1, // Diinput oleh Admin
                ]);
            }
        }
    }
}
