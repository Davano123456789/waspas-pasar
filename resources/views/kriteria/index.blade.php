@extends('layouts.master')

@section('title', 'Data Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <div>
                        <h4 class="card-title mb-1">Daftar Kriteria & Sub-Kriteria</h4>
                        <p class="card-description text-muted mb-md-0">Kelola kriteria penilaian dan definisikan parameter sub-kriteria (Likert) di sini.</p>
                    </div>
                    <div class="d-flex align-items-center flex-wrap">
                        <form action="#" method="GET" class="mr-2 my-1" id="search-form">
                            <div class="input-group">
                                <input type="text" id="search-input" class="form-control" placeholder="Cari kriteria..." style="height: 38px;">
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
                        <a href="{{ route('kriteria.create') }}" class="btn btn-primary font-weight-bold my-1" style="height: 38px; display: inline-flex; align-items: center;">
                            <i class="fas fa-plus mr-2"></i> Tambah Kriteria
                        </a>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot (W)</th>
                                <th>Tipe Kriteria</th>
                                <th>Sub-Kriteria (Likert)</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kriterias as $k)
                            <tr class="kriteria-row">
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">
                                    {{ $k->nama_kriteria }}
                                </td>
                                <td>{{ $k->bobot }}</td>
                                <td>
                                    <span class="badge {{ $k->tipe_kriteria == 1 ? 'badge-info' : 'badge-dark' }} mr-1">
                                        {{ $k->tipe_kriteria == 1 ? 'Benefit' : 'Cost' }}
                                    </span>
                                    <span class="badge {{ $k->tipe_input === 'manual' ? 'badge-primary text-white' : 'badge-light border' }}">
                                        {{ ucfirst($k->tipe_input) }}{{ $k->satuan ? ' ('.$k->satuan.')' : '' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-xs" type="button" data-toggle="collapse" data-target="#sub{{ $k->id_kriteria }}">
                                        <i class="fas fa-eye mr-1"></i> Lihat Sub
                                    </button>
                                    <div class="collapse mt-2" id="sub{{ $k->id_kriteria }}">
                                        <div class="p-2 bg-light rounded border">
                                            <ul class="list-unstyled mb-0 small text-left">
                                                @foreach($k->sub_kriteria as $sub)
                                                <li>
                                                    <strong class="text-primary">{{ $sub->nilai_likert }}:</strong> {{ $sub->nama_sub_kriteria }}
                                                    @if($k->tipe_input === 'manual' && $sub->minimal_nilai !== null && $sub->maksimal_nilai !== null)
                                                        <span class="text-muted">(Min: {{ $sub->minimal_nilai }}, Max: {{ $sub->maksimal_nilai }})</span>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('kriteria.edit', $k->id_kriteria) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kriteria.destroy', $k->id_kriteria) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Data kriteria belum tersedia.</td>
                            </tr>
                            @endforelse
                            <tr id="empty-search-row" style="display: none;">
                                <td colspan="6" class="text-center text-muted py-4">
                                    Data kriteria dengan kata kunci "<strong id="search-keyword"></strong>" tidak ditemukan.
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
    $('.form-delete').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Kriteria ini akan dihapus permanen beserta sub-kriterianya!",
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

        $('.kriteria-row').each(function() {
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
