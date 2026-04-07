@extends('layouts.master')

@section('title', 'Edit Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Detail Kriteria</h4>
                <p class="card-description"> Perbarui informasi kriteria WASPAS di bawah ini. </p>
                <form action="{{ route('kriteria.update', $kriteria->id_kriteria) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_kriteria">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" id="nama_kriteria" value="{{ $kriteria->nama_kriteria }}" required>
                    </div>
                    <div class="form-group">
                        <label for="bobot">Bobot Kriteria (0 - 1)</label>
                        <input type="number" step="0.01" name="bobot" class="form-control" id="bobot" value="{{ $kriteria->bobot }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tipe_kriteria">Tipe Kriteria</label>
                        <select name="tipe_kriteria" class="form-control" id="tipe_kriteria" required>
                            <option value="1" {{ $kriteria->tipe_kriteria == 1 ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                            <option value="0" {{ $kriteria->tipe_kriteria == 0 ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
