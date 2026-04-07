@extends('layouts.master')

@section('title', 'Tambah Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Kriteria Baru</h4>
                <p class="card-description"> Masukkan detail kriteria yang akan digunakan dalam perhitungan WASPAS. </p>
                <form action="{{ route('kriteria.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kriteria">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" id="nama_kriteria" placeholder="Contoh: Luas Lahan atau Harga Sewa" required>
                    </div>
                    <div class="form-group">
                        <label for="bobot">Bobot Kriteria (0 - 1)</label>
                        <input type="number" step="0.01" name="bobot" class="form-control" id="bobot" placeholder="0.25" required>
                        <small class="text-muted">Total bobot seluruh kriteria idealnya berjumlah 1.</small>
                    </div>
                    <div class="form-group">
                        <label for="tipe_kriteria">Tipe Kriteria</label>
                        <select name="tipe_kriteria" class="form-control" id="tipe_kriteria" required>
                            <option value="1">Benefit (Semakin besar semakin baik)</option>
                            <option value="0">Cost (Semakin kecil semakin baik)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
