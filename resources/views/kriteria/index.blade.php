@extends('layouts.master')

@section('title', 'Manajemen Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Manajemen Kriteria</h4>
                    <a href="{{ route('kriteria.create') }}" class="btn btn-primary btn-icon-text">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kriteria
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kriterias as $kriteria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kriteria->nama_kriteria }}</td>
                                <td>{{ $kriteria->bobot }}</td>
                                <td>
                                    @if($kriteria->tipe_kriteria == 1)
                                    <span class="badge badge-success">Benefit</span>
                                    @else
                                    <span class="badge badge-warning">Cost</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('kriteria.edit', $kriteria->id_kriteria) }}" class="btn btn-warning btn-sm btn-icon-text">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('kriteria.destroy', $kriteria->id_kriteria) }}" method="POST" class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-icon-text btn-hapus">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Data kriteria belum tersedia. Silakan klik tombol "Tambah Kriteria".</td>
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
            text: "Data kriteria ini akan dihapus secara permanen!",
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
