@extends('layouts.master')

@section('title', 'Manajemen Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h4 class="card-title mb-md-0">Daftar Pasar</h4>
                    <div class="d-flex align-items-center flex-wrap">
                        <form action="{{ route('pasar.index') }}" method="GET" class="mr-2 my-1" id="search-form">
                            <div class="input-group">
                                <input type="text" id="search-input" name="search" class="form-control" placeholder="Cari pasar..." value="{{ request('search') }}" style="height: 38px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" style="padding: 0 15px; height: 38px; pointer-events: none;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="#" id="btn-reset-search" class="btn btn-light border" title="Reset Pencarian" style="padding: 0 15px; height: 38px; display: {{ request('search') ? 'inline-flex' : 'none' }}; align-items: center; justify-content: center;">
                                        <i class="fas fa-times text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('pasar.create') }}" class="btn btn-primary btn-icon-text my-1" style="height: 38px; display: inline-flex; align-items: center;">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Pasar
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasar</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pasars as $pasar)
                            <tr class="pasar-row">
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
                                <td colspan="5" class="text-center text-muted py-4">
                                    Data pasar belum tersedia.
                                </td>
                            </tr>
                            @endforelse
                            <tr id="empty-search-row" style="display: none;">
                                <td colspan="5" class="text-center text-muted py-4">
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

    // Real-time Search using jQuery
    $('#search-input').on('input', function() {
        let value = $(this).val().toLowerCase().trim();
        let visibleRowsCount = 0;

        $('.pasar-row').each(function() {
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

    // Auto-run if there is initial value (e.g. page reload with value)
    if ($('#search-input').val() !== '') {
        $('#search-input').trigger('input');
    }
</script>
@endpush
