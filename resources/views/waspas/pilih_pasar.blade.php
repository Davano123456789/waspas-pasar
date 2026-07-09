@extends('layouts.master')

@section('title', 'Pilih Alternatif Pasar - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white p-3 rounded mr-3">
                            <i class="fas fa-filter fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="card-title mb-1 font-weight-bold">Pilih Alternatif Pasar</h4>
                            <p class="card-description text-muted mb-0">Tentukan pasar mana saja yang akan diikutkan dalam proses perhitungan perangkingan WASPAS.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap my-2">
                        <form action="#" method="GET" class="mr-2 my-1" id="search-form">
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
                                 <tr class="pasar-row">
                                     <td>{{ $loop->iteration }}</td>
                                     <td>
                                         <div class="form-check m-0 d-flex justify-content-center align-items-center">
                                             <label class="form-check-label p-0">
                                                 <input type="checkbox" name="pasar_ids[]" value="{{ $p->id_pasar }}" class="form-check-input pasar-checkbox" checked>
                                             </label>
                                         </div>
                                     </td>
                                     <td class="text-left font-weight-bold pasar-name-cell">{{ $p->nama_pasar }}</td>
                                     <td class="text-left">{{ $p->alamat }}</td>
                                 </tr>
                                 @endforeach
                                 <tr id="empty-search-row" style="display: none;">
                                     <td colspan="4" class="text-center text-muted py-4">
                                         Data pasar dengan kata kunci "<strong id="search-keyword"></strong>" tidak ditemukan.
                                     </td>
                                 </tr>
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
    $(document).ready(function() {
        // Check/uncheck all checkboxes
        $('#check-all').on('change', function() {
            let isChecked = $(this).prop('checked');
            $('.pasar-row:visible .pasar-checkbox').prop('checked', isChecked);
        });

        // Update check-all status based on individual checkboxes
        $(document).on('change', '.pasar-checkbox', function() {
            let visibleCheckboxes = $('.pasar-row:visible .pasar-checkbox');
            let checkedCount = visibleCheckboxes.filter(':checked').length;
            let totalCount = visibleCheckboxes.length;

            $('#check-all').prop('checked', totalCount > 0 && checkedCount === totalCount);
            $('#check-all').prop('indeterminate', checkedCount > 0 && checkedCount < totalCount);
        });

        // Real-time Search using jQuery
        $('#search-input').on('input', function() {
            let value = $(this).val().toLowerCase().trim();
            let visibleRowsCount = 0;

            $('.pasar-row').each(function() {
                let rowText = $(this).find('.pasar-name-cell').text().toLowerCase();
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

            // Update status 'check-all' based on new visible checkboxes
            let visibleCheckboxes = $('.pasar-row:visible .pasar-checkbox');
            let checkedCount = visibleCheckboxes.filter(':checked').length;
            let totalCount = visibleCheckboxes.length;

            $('#check-all').prop('checked', totalCount > 0 && checkedCount === totalCount);
            $('#check-all').prop('indeterminate', checkedCount > 0 && checkedCount < totalCount);
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
    });
</script>
@endpush
