@extends('layouts.master')

@section('title', 'Kelola Akun - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Pengguna / Akun</h4>
                    <a href="{{ route('pengguna.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus mr-2"></i> Tambah Akun Manual
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Peran</th>
                                <th>Pasar / Cabang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penggunas as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $p->username }}</td>
                                <td>{{ $p->nama_lengkap }}</td>
                                <td>
                                    <span class="badge @if($p->peran == 'Admin') badge-danger @elseif($p->peran == 'Direktur') badge-info @else badge-success @endif">
                                        {{ $p->peran }}
                                    </span>
                                </td>
                                <td>{{ $p->pasar->nama_pasar ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pengguna.edit', $p->id_pengguna) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    @if($p->id_pengguna != auth()->id())
                                    <form action="{{ route('pengguna.destroy', $p->id_pengguna) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.form-delete').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Akun ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush
