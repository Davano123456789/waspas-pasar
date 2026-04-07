@extends('layouts.master')

@section('title', 'Manajemen Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Daftar Pasar</h4>
                    <a href="{{ route('pasar.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Pasar
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pasar</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pasars as $pasar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pasar->nama_pasar }}</td>
                                <td>{{ $pasar->alamat ?? '-' }}</td>
                                <td>{{ $pasar->keterangan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pasar.edit', $pasar->id_pasar) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('pasar.destroy', $pasar->id_pasar) }}" method="POST" class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Data pasar belum tersedia.</td>
                            </tr>
                            @endforelse
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
    $(document).on('click', '.btn-hapus', function() {
        let form = $(this).closest('.form-hapus');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pasar ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4B49AC',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush
