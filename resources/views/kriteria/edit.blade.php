@extends('layouts.master')

@section('title', 'Edit Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card border-warning">
            <div class="card-body">
                <h4 class="card-title">Edit Kriteria: {{ $kriteria->nama_kriteria }}</h4>
                <p class="card-description text-muted">Perbarui kriteria dan deskripsi sub-kriterianya.</p>
                
                <form action="{{ route('kriteria.update', $kriteria->id_kriteria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text" name="nama_kriteria" class="form-control" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>
                                @error('nama_kriteria') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bobot (W)</label>
                                <input type="number" step="0.01" name="bobot" class="form-control" value="{{ old('bobot', $kriteria->bobot) }}" required>
                                @error('bobot') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipe Kriteria</label>
                                <select name="tipe_kriteria" class="form-control" required>
                                    <option value="1" {{ $kriteria->tipe_kriteria == 1 ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                                    <option value="0" {{ $kriteria->tipe_kriteria == 0 ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-primary"><i class="fas fa-list-ol mr-2"></i> Edit Definisi Sub-Kriteria (Likert)</h5>
                    <p class="text-muted small">Tentukan deskripsi untuk setiap tingkat nilai yang akan muncul saat pengisian penilaian.</p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold text-success">Nilai 5 (Sangat Baik)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[5]" class="form-control" value="{{ old('subs.5', $subs[5] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nilai 4 (Baik)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[4]" class="form-control" value="{{ old('subs.4', $subs[4] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-warning">Nilai 3 (Cukup)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[3]" class="form-control" value="{{ old('subs.3', $subs[3] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nilai 2 (Kurang)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[2]" class="form-control" value="{{ old('subs.2', $subs[2] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-danger">Nilai 1 (Buruk)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[1]" class="form-control" value="{{ old('subs.1', $subs[1] ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning mr-2 text-white">Update Kriteria & Sub</button>
                        <a href="{{ route('kriteria.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
