@extends('layouts.master')

@section('title', 'Data Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title">Daftar Kriteria & Sub-Kriteria</h4>
                        <p class="card-description text-muted">Kelola kriteria penilaian dan definisikan parameter sub-kriteria (Likert) di sini.</p>
                    </div>
                    <a href="{{ route('kriteria.create') }}" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-plus mr-2"></i> Tambah Kriteria
                    </a>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot (W)</th>
                                <th>Tipe Kriteria</th>
                                <th>Tipe Input</th>
                                <th>Sub-Kriteria (Likert)</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriterias as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $k->nama_kriteria }}</td>
                                <td>{{ $k->bobot }}</td>
                                <td>
                                    <span class="badge {{ $k->tipe_kriteria == 1 ? 'badge-info' : 'badge-dark' }}">
                                        {{ $k->tipe_kriteria == 1 ? 'Benefit' : 'Cost' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $k->tipe_input == 'manual' ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ ucfirst($k->tipe_input) }}
                                    </span>
                                    @if($k->satuan)
                                        <small class="d-block text-muted mt-1">Satuan: {{ $k->satuan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-xs" type="button" data-toggle="collapse" data-target="#sub{{ $k->id_kriteria }}">
                                        <i class="fas fa-eye mr-1"></i> Lihat Sub
                                    </button>
                                    <div class="collapse mt-2" id="sub{{ $k->id_kriteria }}">
                                        <div class="p-2 bg-light rounded border">
                                            <ul class="list-unstyled mb-0 small">
                                                @foreach($k->sub_kriteria as $sub)
                                                <li>
                                                  <strong class="text-primary">{{ $sub->nilai_likert }}:</strong> {{ $sub->nama_sub_kriteria }}
                                                  @if($k->tipe_input == 'manual')
                                                    <em class="text-muted ml-1">({{ $sub->minimal_nilai }} - {{ $sub->maksimal_nilai }})</em>
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
</script>
@endpush
