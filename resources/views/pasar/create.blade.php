@extends('layouts.master')

@section('title', 'Tambah Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Pasar Baru</h4>
                <p class="card-description"> Masukkan data pasar yang akan dievaluasi. </p>
                <form action="{{ route('pasar.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                        <label for="nama_pasar">Nama Pasar</label>
                        <input type="text" name="nama_pasar" class="form-control" id="nama_pasar" placeholder="Nama Pasar" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" rows="4" placeholder="Alamat lengkap pasar"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" rows="4" placeholder="Keterangan tambahan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('pasar.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
