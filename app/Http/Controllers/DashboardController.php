<?php

namespace App\Http\Controllers;

use App\Models\Pasar;
use App\Models\Kriteria;
use App\Models\User;
use App\Models\HasilWaspas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPasar = Pasar::count();
        $totalKriteria = Kriteria::count();
        $totalPengguna = User::count();
        
        // Ambil pemenang (Rank 1) dari perhitungan terakhir
        $latestWinner = HasilWaspas::with('pasar')
            ->where('rangking', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('index', compact('totalPasar', 'totalKriteria', 'totalPengguna', 'latestWinner'));
    }
}
