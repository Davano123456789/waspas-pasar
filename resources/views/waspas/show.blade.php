@extends('layouts.master')

@section('title', 'Detail Riwayat - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Detail Riwayat: {{ \Carbon\Carbon::parse($hasil->first()->created_at)->translatedFormat('d F Y (H:i)') }}</h4>
                    <div>
                        <a href="{{ route('waspas.cetak', $batch_id) }}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-print mr-2"></i> Cetak Laporan
                        </a>
                        <a href="{{ route('waspas.index') }}" class="btn btn-light ml-2">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <p class="text-muted mb-4">Kode Batch: <code>{{ $batch_id }}</code></p>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="bg-light font-weight-bold">
                            <tr>
                                <th>Rank</th>
                                <th>Nama Pasar</th>
                                <th>Skor WSM</th>
                                <th>Skor WPM</th>
                                <th class="bg-primary text-white">Skor Akhir (Qi)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil as $h)
                            <tr class="{{ $h->rangking == 1 ? 'bg-success text-white' : '' }}">
                                <td>
                                    @if($h->rangking == 1)
                                        <i class="fas fa-trophy mr-2 text-warning"></i>
                                    @endif
                                    <strong>{{ $h->rangking }}</strong>
                                </td>
                                <td class="text-left font-weight-bold">{{ $h->pasar->nama_pasar }}</td>
                                <td>{{ number_format($h->skor_wsm, 4) }}</td>
                                <td>{{ number_format($h->skor_wpm, 4) }}</td>
                                <td class="font-weight-bold {{ $h->rangking == 1 ? 'text-white' : 'text-primary' }}">
                                    {{ number_format($h->skor_total_qi, 4) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
