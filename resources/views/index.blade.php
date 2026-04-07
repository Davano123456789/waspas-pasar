@extends('layouts.master')

@section('title', 'Dashboard - WASPAS Pasar')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="row">
      <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Selamat Datang, {{ auth()->user()->nama_lengkap }}!</h3>
        <h6 class="font-weight-normal mb-0">Sistem Pendukung Keputusan Pemilihan Pasar Terbaik Metro Pasar Surya Surabaya.</h6>
      </div>
      <div class="col-12 col-xl-4">
       <div class="justify-content-end d-flex">
        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
          <button class="btn btn-sm btn-light bg-white" type="button">
           <i class="mdi mdi-calendar"></i> Hari ini: {{ date('d F Y') }}
          </button>
        </div>
       </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <p class="mb-4">Total Data Pasar</p>
        <p class="fs-30 mb-2">{{ $totalPasar }}</p>
        <p>Pasar Terdaftar</p>
      </div>
    </div>
  </div>
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-dark text-white">
      <div class="card-body">
        <p class="mb-4">Total Kriteria</p>
        <p class="fs-30 mb-2">{{ $totalKriteria }}</p>
        <p>Kriteria Aktif</p>
      </div>
    </div>
  </div>
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-info text-white">
      <div class="card-body">
        <p class="mb-4">Total Pengguna</p>
        <p class="fs-30 mb-2">{{ $totalPengguna }}</p>
        <p>Admin & Cabang</p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Ranking #1 Perhitungan Terakhir</h4>
        @if($latestWinner)
        <div class="d-flex align-items-center p-3 mt-4 border rounded bg-light">
          <i class="fas fa-medal fa-3x text-warning mr-4"></i>
          <div>
            <h3 class="text-primary font-weight-bold mb-1">{{ $latestWinner->pasar->nama_pasar }}</h3>
            <p class="mb-0 text-muted">Berdasarkan perhitungan WASPAS terakhir dengan skor Qi: <strong>{{ number_format($latestWinner->skor_total_qi, 4) }}</strong></p>
          </div>
          <div class="ml-auto">
            <a href="{{ route('waspas.show', $latestWinner->batch_id) }}" class="btn btn-outline-primary btn-sm">Lihat Detail Laporan</a>
          </div>
        </div>
        @else
        <div class="text-center py-4">
          <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
          <p class="text-muted">Belum ada perhitungan yang disimpan dalam sistem.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection