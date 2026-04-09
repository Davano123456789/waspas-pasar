@extends('layouts.master')

@section('title', 'Tambah Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Kriteria Baru</h4>
                <p class="card-description text-muted">Definisikan kriteria dan sub-kriteria (deskripsi nilai 1-5) di bawah ini.</p>
                
                <form action="{{ route('kriteria.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text" name="nama_kriteria" class="form-control" placeholder="Contoh: Realisasi Retribusi" required>
                                @error('nama_kriteria') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bobot (W)</label>
                                <input type="number" step="0.01" name="bobot" class="form-control" placeholder="Contoh: 0.5" required>
                                @error('bobot') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipe Kriteria</label>
                                <select name="tipe_kriteria" class="form-control" required>
                                    <option value="1">Benefit (Semakin besar semakin baik)</option>
                                    <option value="0">Cost (Semakin kecil semakin baik)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-primary"><i class="fas fa-list-ol mr-2"></i> Definisi Sub-Kriteria (Likert)</h5>
                    <p class="text-muted small">Tentukan deskripsi untuk setiap tingkat nilai yang akan muncul saat pengisian penilaian.</p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold text-success">Nilai 5 (Sangat Baik)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[5]" class="form-control" placeholder="Deskripsi untuk skor tertinggi (misal: 95% - 100%)" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nilai 4 (Baik)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[4]" class="form-control" placeholder="Deskripsi untuk skor 4" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-warning">Nilai 3 (Cukup)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[3]" class="form-control" placeholder="Deskripsi untuk skor 3" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nilai 2 (Kurang)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[2]" class="form-control" placeholder="Deskripsi untuk skor 2" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-danger">Nilai 1 (Buruk)</label>
                                <div class="col-sm-9">
                                    <input type="text" name="subs[1]" class="form-control" placeholder="Deskripsi untuk skor terendah" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Simpan Kriteria & Sub</button>
                        <a href="{{ route('kriteria.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
