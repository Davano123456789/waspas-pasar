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
            ['id_kriteria' => 1, 'nama_kriteria' => 'Realisasi Retribusi', 'bobot' => 0.5, 'tipe_kriteria' => 1],
            ['id_kriteria' => 2, 'nama_kriteria' => 'Jumlah Pengunjung', 'bobot' => 0.15, 'tipe_kriteria' => 1],
            ['id_kriteria' => 3, 'nama_kriteria' => 'Kebersihan', 'bobot' => 0.1, 'tipe_kriteria' => 1],
            ['id_kriteria' => 4, 'nama_kriteria' => 'Keamanan', 'bobot' => 0.1, 'tipe_kriteria' => 1],
            ['id_kriteria' => 5, 'nama_kriteria' => 'Kondisi Bangunan', 'bobot' => 0.15, 'tipe_kriteria' => 1],
        ];
        foreach ($kriterias as $k) { Kriteria::create($k); }

        // 3. Insert Sub Kriteria
        $subs = [
            // C1 (Realisasi Retribusi)
            ['id_kriteria' => 1, 'nilai_likert' => 5, 'nama_sub_kriteria' => '95% – 100%'],
            ['id_kriteria' => 1, 'nilai_likert' => 4, 'nama_sub_kriteria' => '85% – 94%'],
            ['id_kriteria' => 1, 'nilai_likert' => 3, 'nama_sub_kriteria' => '75% – 84%'],
            ['id_kriteria' => 1, 'nilai_likert' => 2, 'nama_sub_kriteria' => '60% – 74%'],
            ['id_kriteria' => 1, 'nilai_likert' => 1, 'nama_sub_kriteria' => '< 60%'],
            
            // C2 (Jumlah Pengunjung)
            ['id_kriteria' => 2, 'nilai_likert' => 5, 'nama_sub_kriteria' => '≥ 1.000 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 4, 'nama_sub_kriteria' => '751 – 999 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 3, 'nama_sub_kriteria' => '501 – 750 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 2, 'nama_sub_kriteria' => '251 – 500 orang per hari'],
            ['id_kriteria' => 2, 'nilai_likert' => 1, 'nama_sub_kriteria' => '≤ 250 orang per hari'],
            
            // C3 (Kebersihan)
            ['id_kriteria' => 3, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Pembersihan sampah >1 kali/hari'],
            ['id_kriteria' => 3, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Pembersihan sampah 1 kali/hari'],
            ['id_kriteria' => 3, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Pembersihan sampah <1 kali/hari'],
            
            // C4 (Keamanan)
            ['id_kriteria' => 4, 'nilai_likert' => 3, 'nama_sub_kriteria' => '≥ 6 petugas keamanan'],
            ['id_kriteria' => 4, 'nilai_likert' => 2, 'nama_sub_kriteria' => '4 – 5 petugas keamanan'],
            ['id_kriteria' => 4, 'nilai_likert' => 1, 'nama_sub_kriteria' => '< 4 petugas keamanan'],
            
            // C5 (Kondisi Bangunan)
            ['id_kriteria' => 5, 'nilai_likert' => 3, 'nama_sub_kriteria' => 'Kondisi bangunan baik >75%'],
            ['id_kriteria' => 5, 'nilai_likert' => 2, 'nama_sub_kriteria' => 'Kondisi bangunan baik 50% - 75%'],
            ['id_kriteria' => 5, 'nilai_likert' => 1, 'nama_sub_kriteria' => 'Kondisi bangunan baik <50%'],
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

    }
}
