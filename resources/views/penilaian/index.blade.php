@extends('layouts.master')

@section('title', 'Penilaian Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Penilaian Pasar</h4>
                <p class="card-description">Berikan nilai untuk setiap pasar berdasarkan kriteria yang telah ditentukan.</p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pasars as $pasar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pasar->nama_pasar }}</td>
                                <td>
                                    @if($pasar->is_evaluated)
                                        <span class="badge badge-success">Terisi</span>
                                    @else
                                        <span class="badge badge-warning">Belum Terisi</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('penilaian.input', $pasar->id_pasar) }}" class="btn btn-primary btn-sm btn-icon-text">
                                        <i class="fas fa-edit mr-1"></i>
                                        {{ $pasar->is_evaluated ? 'Edit Nilai' : 'Input Nilai' }}
                                    </a>
                                    @if($pasar->is_evaluated)
                                        <form action="{{ route('penilaian.destroy', $pasar->id_pasar) }}" method="POST" class="d-inline form-reset-penilaian">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon-text">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus Nilai
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Data pasar belum tersedia.</td>
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
    $('.form-reset-penilaian').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Penilaian untuk pasar ini akan dihapus dan dikosongkan kembali!",
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
