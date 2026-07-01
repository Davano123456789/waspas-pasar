@extends('layouts.master')

@section('title', 'Tambah Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Kriteria Baru</h4>
                <p class="card-description text-muted">Definisikan kriteria dan sub-kriteria (deskripsi nilai 1-5) di bawah ini.</p>
                
                <form action="{{ route('kriteria.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text" name="nama_kriteria" class="form-control" placeholder="Contoh: Realisasi Retribusi" value="{{ old('nama_kriteria') }}" required>
                                @error('nama_kriteria') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Bobot (W)</label>
                                <input type="number" step="0.01" name="bobot" class="form-control" placeholder="Contoh: 0.5" value="{{ old('bobot') }}" required>
                                @error('bobot') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipe Kriteria</label>
                                <select name="tipe_kriteria" class="form-control" required>
                                    <option value="1" {{ old('tipe_kriteria') == 1 ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                                    <option value="0" {{ old('tipe_kriteria') == 0 ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipe Input</label>
                                <select name="tipe_input" id="tipe_input" class="form-control" required>
                                    <option value="pilihan" {{ old('tipe_input') == 'pilihan' ? 'selected' : '' }}>Pilihan (Dropdown)</option>
                                    <option value="manual" {{ old('tipe_input') == 'manual' ? 'selected' : '' }}>Manual (Ketik Angka)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="satuan-wrapper">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" class="form-control" placeholder="Contoh: %, petugas, orang" value="{{ old('satuan') }}">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-primary"><i class="fas fa-list-ol mr-2"></i> Definisi Sub-Kriteria (Likert)</h5>
                    <p class="text-muted small">Tentukan deskripsi untuk setiap tingkat nilai yang akan muncul saat pengisian penilaian. Untuk tipe input manual, Anda juga wajib menentukan batas nilai minimum dan maksimum.</p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $skors = [
                                    5 => ['label' => 'Nilai 5 (Sangat Baik)', 'class' => 'font-weight-bold text-success'],
                                    4 => ['label' => 'Nilai 4 (Baik)', 'class' => ''],
                                    3 => ['label' => 'Nilai 3 (Cukup Baik)', 'class' => 'text-warning'],
                                    2 => ['label' => 'Nilai 2 (Tidak Baik)', 'class' => ''],
                                    1 => ['label' => 'Nilai 1 (Sangat Tidak Baik)', 'class' => 'text-danger'],
                                ];
                            @endphp

                            @foreach($skors as $nilai => $cfg)
                            <div class="form-group row align-items-center">
                                <label class="col-sm-3 col-form-label {{ $cfg['class'] }}">
                                    {{ $cfg['label'] }}
                                    @if(in_array($nilai, [1, 2, 3])) <span class="text-danger">*</span> @endif
                                </label>
                                <div class="col-sm-9 name-col">
                                    <input type="text" name="subs[{{ $nilai }}]" class="form-control" value="{{ old('subs.'.$nilai) }}" placeholder="Deskripsi untuk nilai {{ $nilai }}" {{ in_array($nilai, [1, 2, 3]) ? 'required' : '' }}>
                                </div>
                                <div class="col-sm-2 min-col" style="display: none;">
                                    <input type="number" step="any" name="subs_min[{{ $nilai }}]" class="form-control" value="{{ old('subs_min.'.$nilai) }}" placeholder="Min">
                                    @error('subs_min.'.$nilai) <small class="text-danger d-block">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-sm-2 max-col" style="display: none;">
                                    <input type="number" step="any" name="subs_max[{{ $nilai }}]" class="form-control" value="{{ old('subs_max.'.$nilai) }}" placeholder="Max">
                                    @error('subs_max.'.$nilai) <small class="text-danger d-block">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Simpan Kriteria & Sub</button>
                        <a href="{{ route('kriteria.index') }}" class="btn btn-light">Batal</a>
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
        const tipeInput = document.getElementById('tipe_input');
        const satuanWrapper = document.getElementById('satuan-wrapper');
        const nameCols = document.querySelectorAll('.name-col');
        const minCols = document.querySelectorAll('.min-col');
        const maxCols = document.querySelectorAll('.max-col');

        function toggleInputs() {
            if (tipeInput.value === 'manual') {
                satuanWrapper.style.display = 'block';
                nameCols.forEach(col => {
                    col.classList.remove('col-sm-9');
                    col.classList.add('col-sm-5');
                });
                minCols.forEach(col => {
                    col.style.display = 'block';
                });
                maxCols.forEach(col => {
                    col.style.display = 'block';
                });
            } else {
                satuanWrapper.style.display = 'none';
                nameCols.forEach(col => {
                    col.classList.remove('col-sm-5');
                    col.classList.add('col-sm-9');
                });
                minCols.forEach(col => {
                    col.style.display = 'none';
                });
                maxCols.forEach(col => {
                    col.style.display = 'none';
                });
            }
        }

        tipeInput.addEventListener('change', toggleInputs);
        toggleInputs(); // Jalankan saat load pertama kali
    });
</script>
@endpush
