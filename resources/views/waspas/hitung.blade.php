@extends('layouts.master')

@section('title', 'Proses Perhitungan WASPAS - WASPAS Pasar')

@section('content')
<div class="row">
    @if(isset($error))
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}
        </div>
    </div>
    @else
    
    <div class="col-md-12 mb-4 d-flex justify-content-between align-items-center">
        <h3 class="font-weight-bold">Tahapan Perhitungan WASPAS</h3>
        <form action="{{ route('waspas.simpan') }}" method="POST">
            @csrf
            @foreach($results as $index => $res)
                <input type="hidden" name="hasil[{{ $index }}][id_pasar]" value="{{ $res['id_pasar'] }}">
                <input type="hidden" name="hasil[{{ $index }}][wsm]" value="{{ $res['wsm'] }}">
                <input type="hidden" name="hasil[{{ $index }}][wpm]" value="{{ $res['wpm'] }}">
                <input type="hidden" name="hasil[{{ $index }}][qi]" value="{{ $res['qi'] }}">
                <input type="hidden" name="hasil[{{ $index }}][rank]" value="{{ $res['rank'] }}">
            @endforeach
            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                <i class="fas fa-save mr-2"></i> Simpan Hasil & Konfirmasi Ranking
            </button>
        </form>
    </div>

    <!-- 1. Matriks Keputusan (X) -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">1. Matriks Keputusan (X)</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Pasar</th>
                                @foreach($kriterias as $k)
                                <th>{{ $k->nama_kriteria }} ({{ $k->bobot }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluatedPasars as $p)
                            <tr>
                                <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                                @foreach($kriterias as $k)
                                <td>{{ $matrix[$p->id_pasar][$k->id_kriteria] }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Matriks Normalisasi (R) -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">2. Matriks Normalisasi (R)</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Pasar</th>
                                @foreach($kriterias as $k)
                                <th>{{ $k->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluatedPasars as $p)
                            <tr>
                                <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                                @foreach($kriterias as $k)
                                <td>{{ number_format($normalizedMatrix[$p->id_pasar][$k->id_kriteria], 4) }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Hasil Perhitungan (Qi) -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">3. Skor Qi & Perangkingan Sementara</h4>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-light font-weight-bold">
                            <tr>
                                <th>Rank</th>
                                <th>Nama Pasar</th>
                                <th>WSM (Q1)</th>
                                <th>WPM (Q2)</th>
                                <th class="bg-primary text-white">Skor Akhir (Qi)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $res)
                            <tr class="{{ $res['rank'] == 1 ? 'bg-success text-white' : '' }}">
                                <td><strong>{{ $res['rank'] }}</strong></td>
                                <td class="text-left font-weight-bold">{{ $res['nama_pasar'] }}</td>
                                <td>{{ number_format($res['wsm'], 4) }}</td>
                                <td>{{ number_format($res['wpm'], 4) }}</td>
                                <td class="font-weight-bold">{{ number_format($res['qi'], 4) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection
