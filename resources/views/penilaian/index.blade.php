@extends('layouts.master')

@section('title', 'Penilaian Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <div>
                        <h4 class="card-title mb-1">Daftar Penilaian Pasar</h4>
                        <p class="card-description mb-md-0">Berikan nilai untuk setiap pasar berdasarkan kriteria yang telah ditentukan.</p>
                    </div>
                    <form action="#" method="GET" class="my-1" id="search-form">
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control" placeholder="Cari pasar..." style="height: 38px;">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" style="padding: 0 15px; height: 38px; pointer-events: none;">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="#" id="btn-reset-search" class="btn btn-light border" title="Reset Pencarian" style="padding: 0 15px; height: 38px; display: none; align-items: center; justify-content: center;">
                                    <i class="fas fa-times text-danger"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
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
                            <tr class="penilaian-row">
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
                                <td colspan="4" class="text-center text-muted py-4">Data pasar belum tersedia.</td>
                            </tr>
                            @endforelse
                            <tr id="empty-search-row" style="display: none;">
                                <td colspan="4" class="text-center text-muted py-4">
                                    Data pasar dengan kata kunci "<strong id="search-keyword"></strong>" tidak ditemukan.
                                </td>
                            </tr>
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

    // Real-time Search using jQuery
    $('#search-input').on('input', function() {
        let value = $(this).val().toLowerCase().trim();
        let visibleRowsCount = 0;

        $('.penilaian-row').each(function() {
            let rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(value) > -1) {
                $(this).show();
                visibleRowsCount++;
            } else {
                $(this).hide();
            }
        });

        // Tampilkan pesan kosong jika tidak ada baris yang cocok
        if (visibleRowsCount === 0 && value !== '') {
            $('#empty-search-row').show();
            $('#search-keyword').text(value);
        } else {
            $('#empty-search-row').hide();
        }

        // Tampilkan/sembunyikan tombol reset
        if (value !== '') {
            $('#btn-reset-search').css('display', 'inline-flex');
        } else {
            $('#btn-reset-search').css('display', 'none');
        }
    });

    // Reset button handler
    $('#btn-reset-search').on('click', function(e) {
        e.preventDefault();
        $('#search-input').val('').trigger('input');
    });

    // Prevent default form submit on enter
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
    });
</script>
@endpush
