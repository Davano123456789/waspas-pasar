@extends('layouts.master')

@section('title', 'Tambah Akun - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Akun Baru</h4>
                <p class="card-description text-muted">Silakan lengkapi data akun baru (Admin/Direktur) di bawah ini.</p>
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username_login" required>
                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Kata sandi" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama asli pengguna" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Peran (Role)</label>
                                <select name="peran" class="form-control" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Direktur">Direktur</option>
                                </select>
                                <small class="text-muted">Akun Kepala Pasar dibuat otomatis melalui menu Tambah Pasar.</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Simpan Akun</button>
                        <a href="{{ route('pengguna.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
