@extends('layouts.master')

@section('title', 'Detail Perhitungan - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title">Detail Hasil Perhitungan</h4>
                        <p class="card-description text-muted">ID Batch: <strong>{{ $batch_id }}</strong> | Tanggal: {{ $hasil->first()->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('waspas.index') }}" class="btn btn-light mr-2">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        <a href="{{ route('waspas.cetak', $batch_id) }}" target="_blank" class="btn btn-primary font-weight-bold">
                            <i class="fas fa-print mr-2"></i> Cetak Laporan
                        </a>
                    </div>
                </div>

                <!-- Tahap 1: Matriks Keputusan -->
                <div class="mt-5">
                    <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-table mr-2"></i> Tahap 1: Matriks Keputusan (X)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Alternatif (Pasar)</th>
                                    @foreach($kriterias as $k)
                                        <th>C{{ $k->id_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($evaluatedPasars as $p)
                                <tr>
                                    <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                                    @foreach($kriterias as $k)
                                        <td>{{ $matrix[$p->id_pasar][$k->id_kriteria] ?? 0 }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tahap 2: Matriks Normalisasi -->
                <div class="mt-5">
                    <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-percentage mr-2"></i> Tahap 2: Matriks Normalisasi (R)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Alternatif (Pasar)</th>
                                    @foreach($kriterias as $k)
                                        <th>C{{ $k->id_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($evaluatedPasars as $p)
                                <tr>
                                    <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                                    @foreach($kriterias as $k)
                                        <td>{{ number_format($normalizedMatrix[$p->id_pasar][$k->id_kriteria] ?? 0, 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tahap 3: Hasil Akhir & Ranking -->
                <div class="mt-5">
                    <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-award mr-2"></i> Tahap Akhir: Ranking Hasil WASPAS</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th width="80">Ranking</th>
                                    <th class="text-left">Nama Pasar (Alternatif)</th>
                                    <th>Skor WSM</th>
                                    <th>Skor WPM</th>
                                    <th>Skor Akhir (Qi)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil as $row)
                                <tr class="{{ $row->rangking == 1 ? 'table-success' : '' }}">
                                    <td class="text-center">
                                        @if($row->rangking == 1)
                                            <span class="badge badge-warning">#1</span>
                                        @else
                                            <span class="badge badge-light border">{{ $row->rangking }}</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">{{ $row->pasar->nama_pasar }}</td>
                                    <td class="text-center">{{ number_format($row->skor_wsm, 4) }}</td>
                                    <td class="text-center">{{ number_format($row->skor_wpm, 4) }}</td>
                                    <td class="text-center">
                                        <div class="badge badge-primary font-weight-bold" style="font-size: 1rem;">
                                            {{ number_format($row->skor_total_qi, 4) }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-light rounded border">
                    <p class="mb-0 small text-muted">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Keterangan:</strong> Skor Akhir (Qi) dihitung menggunakan kombinasi WSM dan WPM dengan bobot preferensi (λ) sebesar 0.5.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
