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

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot (W)</th>
                                <th>Tipe</th>
                                <th>Sub-Kriteria (Likert)</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriterias as $k)
                            <tr>
                                <td>C{{ $k->id_kriteria }}</td>
                                <td class="font-weight-bold">{{ $k->nama_kriteria }}</td>
                                <td>{{ $k->bobot }}</td>
                                <td>
                                    <span class="badge {{ $k->tipe_kriteria == 1 ? 'badge-info' : 'badge-dark' }}">
                                        {{ $k->tipe_kriteria == 1 ? 'Benefit' : 'Cost' }}
                                    </span>
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
                                    <form action="{{ route('kriteria.destroy', $k->id_kriteria) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kriteria ini?')">
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
