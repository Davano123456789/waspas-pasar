@extends('layouts.master')

@section('title', 'Input Penilaian - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penilaian Pasar: {{ $pasar->nama_pasar }}</h4>
                <p class="card-description">Berikan nilai untuk masing-masing kriteria menggunakan Skala Likert (1-5).</p>
                <form action="{{ route('penilaian.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <input type="hidden" name="id_pasar" value="{{ $pasar->id_pasar }}">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Nilai (Variabel Likert)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kriterias as $k)
                                <tr>
                                    <td>{{ $k->nama_kriteria }}</td>
                                    <td>{{ $k->bobot }}</td>
                                    <td>
                                        <select name="nilai[{{ $k->id_kriteria }}]" class="form-control" required>
                                            <option value="">-- Pilih Nilai --</option>
                                            <option value="5" {{ isset($penilaians[$k->id_kriteria]) && $penilaians[$k->id_kriteria] == 5 ? 'selected' : '' }}>Sangat Baik (5)</option>
                                            <option value="4" {{ isset($penilaians[$k->id_kriteria]) && $penilaians[$k->id_kriteria] == 4 ? 'selected' : '' }}>Baik (4)</option>
                                            <option value="3" {{ isset($penilaians[$k->id_kriteria]) && $penilaians[$k->id_kriteria] == 3 ? 'selected' : '' }}>Cukup Baik (3)</option>
                                            <option value="2" {{ isset($penilaians[$k->id_kriteria]) && $penilaians[$k->id_kriteria] == 2 ? 'selected' : '' }}>Tidak Baik (2)</option>
                                            <option value="1" {{ isset($penilaians[$k->id_kriteria]) && $penilaians[$k->id_kriteria] == 1 ? 'selected' : '' }}>Sangat Tidak Baik (1)</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-save mr-2"></i> Simpan Penilaian
                        </button>
                        <a href="{{ route('penilaian.index') }}" class="btn btn-light">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
