@extends('layouts.master')

@section('title', 'Input Penilaian - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Penilaian: {{ $pasar->nama_pasar }}</h4>
                <p class="card-description text-muted">Silakan pilih sub-kriteria yang paling sesuai dengan kondisi lapangan.</p>
                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_pasar" value="{{ $pasar->id_pasar }}">
                    
                    @foreach($kriterias as $k)
                    <div class="form-group row border-bottom pb-3">
                        <label class="col-sm-4 col-form-label font-weight-bold">
                            {{ $k->nama_kriteria }}
                            <br>
                            <small class="text-muted font-weight-normal">C{{ $k->id_kriteria }} (Bobot: {{ $k->bobot }}, Tipe: {{ $k->tipe_kriteria == 1 ? 'Benefit' : 'Cost' }})</small>
                        </label>
                        <div class="col-sm-8">
                            @if($k->tipe_input == 'manual')
                                <div class="input-group">
                                    <input type="number" step="0.01" name="nilai_asli[{{ $k->id_kriteria }}]" class="form-control" 
                                        placeholder="Masukkan angka..." 
                                        value="{{ isset($penilaians_asli[$k->id_kriteria]) ? $penilaians_asli[$k->id_kriteria] : '' }}" required>
                                    @if($k->satuan)
                                        <div class="input-group-append"><span class="input-group-text">{{ $k->satuan }}</span></div>
                                    @endif
                                </div>
                            @else
                                <select name="nilai[{{ $k->id_kriteria }}]" class="form-control" required>
                                    <option value="">-- Pilih Penilaian --</option>
                                    @foreach($k->sub_kriteria as $sub)
                                    <option value="{{ $sub->nilai_likert }}" 
                                        {{ (isset($penilaians[$k->id_kriteria]) && $penilaians[$k->id_kriteria] == $sub->nilai_likert) ? 'selected' : '' }}>
                                        {{ $sub->nilai_likert }} - {{ $sub->nama_sub_kriteria }}
                                    </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Simpan Seluruh Penilaian</button>
                        <a href="{{ route('penilaian.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
