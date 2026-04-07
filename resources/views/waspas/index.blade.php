@extends('layouts.master')

@section('title', 'Riwayat Perhitungan - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card bg-facebook text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title text-white">Riwayat Perhitungan WASPAS</h4>
                        <p class="card-description text-white-50">Daftar seluruh perhitungan yang pernah Anda simpan.</p>
                    </div>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('waspas.hitung') }}" class="btn btn-warning btn-lg font-weight-bold">
                        <i class="fas fa-play-circle mr-2"></i> Jalankan Perhitungan Baru
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Sesi Perhitungan</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal & Waktu</th>
                                <th>Kode Batch</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $h)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($h->created_at)->translatedFormat('d F Y (H:i)') }}
                                </td>
                                <td><code class="text-muted">{{ $h->batch_id }}</code></td>
                                <td>
                                    <a href="{{ route('waspas.show', $h->batch_id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                                    </a>
                                    <form action="{{ route('waspas.destroy', $h->batch_id) }}" method="POST" class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted p-4">
                                    Belum ada riwayat perhitungan yang tersimpan.
                                </td>
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
            title: 'Hapus Riwayat?',
            text: "Seluruh data ranking pada sesi ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4B49AC',
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
