@extends('layouts.master')

@section('title', 'Kelola Akun - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h4 class="card-title mb-md-0">Daftar Pengguna / Akun</h4>
                    <div class="d-flex align-items-center flex-wrap">
                        <form action="#" method="GET" class="mr-2 my-1" id="search-form">
                            <div class="input-group">
                                <input type="text" id="search-input" class="form-control" placeholder="Cari akun..." style="height: 38px;">
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
                        <a href="{{ route('pengguna.create') }}" class="btn btn-primary btn-sm my-1" style="height: 38px; display: inline-flex; align-items: center;">
                            <i class="fas fa-user-plus mr-2"></i> Tambah Akun Manual
                        </a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Peran</th>
                                <th>Pasar / Cabang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggunas as $p)
                            <tr class="pengguna-row">
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
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Data pengguna belum tersedia.
                                </td>
                            </tr>
                            @endforelse
                            <tr id="empty-search-row" style="display: none;">
                                <td colspan="6" class="text-center text-muted py-4">
                                    Data akun dengan kata kunci "<strong id="search-keyword"></strong>" tidak ditemukan.
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

    // Real-time Search using jQuery
    $('#search-input').on('input', function() {
        let value = $(this).val().toLowerCase().trim();
        let visibleRowsCount = 0;

        $('.pengguna-row').each(function() {
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
