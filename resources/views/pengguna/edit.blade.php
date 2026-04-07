@extends('layouts.master')

@section('title', 'Edit Akun - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card border-warning">
            <div class="card-body">
                <h4 class="card-title">Edit Akun: {{ $user->username }}</h4>
                <p class="card-description text-muted">Perbarui informasi akun di bawah ini. Kosongkan password jika tidak ingin diubah.</p>
                
                <form action="{{ route('pengguna.update', $user->id_pengguna) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required @if($user->peran == 'Kepala Pasar') readonly @endif>
                                @if($user->peran == 'Kepala Pasar')
                                <small class="text-muted">Username Kepala Pasar bersifat tetap (sesuai nama cabang).</small>
                                @endif
                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password Baru (Opsional)</label>
                                <input type="password" name="password" class="form-control" placeholder="Isi hanya jika ingin ganti password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Peran (Role)</label>
                                <select name="peran" class="form-control" @if($user->peran == 'Kepala Pasar') disabled @else required @endif>
                                    <option value="Admin" {{ $user->peran == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Direktur" {{ $user->peran == 'Direktur' ? 'selected' : '' }}>Direktur</option>
                                    @if($user->peran == 'Kepala Pasar')
                                    <option value="Kepala Pasar" selected>Kepala Pasar</option>
                                    @endif
                                </select>
                                @if($user->peran == 'Kepala Pasar')
                                <input type="hidden" name="peran" value="Kepala Pasar">
                                <small class="text-muted">Role Kepala Pasar tidak dapat diubah di sini.</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning mr-2">Simpan Perubahan</button>
                        <a href="{{ route('pengguna.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
