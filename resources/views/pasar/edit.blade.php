@extends('layouts.master')

@section('title', 'Edit Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Detail Pasar</h4>
                <p class="card-description"> Perbarui informasi pasar di bawah ini. </p>
                <form action="{{ route('pasar.update', $pasar->id_pasar) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_pasar">Nama Pasar</label>
                        <input type="text" name="nama_pasar" class="form-control" id="nama_pasar" value="{{ $pasar->nama_pasar }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" rows="4">{{ $pasar->alamat }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" rows="4">{{ $pasar->keterangan }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('pasar.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
