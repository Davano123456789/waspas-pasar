@extends('layouts.master')

@section('title', 'Pilih Alternatif Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white p-3 rounded mr-3">
                        <i class="fas fa-filter fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="card-title mb-1 font-weight-bold">Pilih Alternatif Pasar</h4>
                        <p class="card-description text-muted mb-0">Tentukan pasar mana saja yang akan diikutkan dalam proses perhitungan perangkingan WASPAS.</p>
                    </div>
                </div>

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <form action="{{ route('waspas.hitung') }}" method="GET" class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th width="80">No</th>
                                    <th width="150">
                                        <div class="form-check m-0 d-flex justify-content-center align-items-center">
                                            <label class="form-check-label font-weight-bold p-0">
                                                <input type="checkbox" id="check-all" class="form-check-input" checked>
                                                Pilih Semua
                                            </label>
                                        </div>
                                    </th>
                                    <th class="text-left">Nama Pasar</th>
                                    <th class="text-left">Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasars as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="form-check m-0 d-flex justify-content-center align-items-center">
                                            <label class="form-check-label p-0">
                                                <input type="checkbox" name="pasar_ids[]" value="{{ $p->id_pasar }}" class="form-check-input pasar-checkbox" checked>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                                    <td class="text-left">{{ $p->alamat }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2 btn-lg">
                            <i class="fas fa-calculator mr-2"></i> Mulai Hitung WASPAS
                        </button>
                        <a href="{{ route('waspas.index') }}" class="btn btn-light btn-lg">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('check-all');
        const checkboxes = document.querySelectorAll('.pasar-checkbox');

        // Check/uncheck all checkboxes
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = checkAll.checked;
            });
        });

        // Update check-all status based on individual checkboxes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                const someChecked = Array.from(checkboxes).some(c => c.checked);
                checkAll.checked = allChecked;
                checkAll.indeterminate = someChecked && !allChecked;
            });
        });
    });
</script>
@endpush
