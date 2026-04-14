@extends('layouts.master')

@section('title', 'Edit Kriteria - WASPAS Pasar')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card border-warning">
            <div class="card-body">
                <h4 class="card-title">Edit Kriteria: {{ $kriteria->nama_kriteria }}</h4>
                <p class="card-description text-muted">Perbarui kriteria dan deskripsi sub-kriterianya.</p>
                
                <form action="{{ route('kriteria.update', $kriteria->id_kriteria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text" name="nama_kriteria" class="form-control" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>
                                @error('nama_kriteria') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bobot (W)</label>
                                <input type="number" step="0.01" name="bobot" class="form-control" value="{{ old('bobot', $kriteria->bobot) }}" required>
                                @error('bobot') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipe Kriteria</label>
                                <select name="tipe_kriteria" class="form-control" required>
                                    <option value="1" {{ $kriteria->tipe_kriteria == 1 ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                                    <option value="0" {{ $kriteria->tipe_kriteria == 0 ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Input Penilaian</label>
                                <select name="tipe_input" id="tipe_input" class="form-control" required>
                                    <option value="pilihan" {{ $kriteria->tipe_input == 'pilihan' ? 'selected' : '' }}>Pilihan (Dropdown Skala 1-5)</option>
                                    <option value="manual" {{ $kriteria->tipe_input == 'manual' ? 'selected' : '' }}>Manual (Ketik Angka dengan Aturan Batas)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="satuan_container" style="display: none;">
                            <div class="form-group">
                                <label>Satuan (Opsional)</label>
                                <input type="text" name="satuan" class="form-control" placeholder="Contoh: %, Orang per hari, Rp" value="{{ old('satuan', $kriteria->satuan) }}">
                                <small class="text-muted">Ditampilkan di sebelah kanan kotak input saat penilaian.</small>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-primary"><i class="fas fa-list-ol mr-2"></i> Edit Definisi Sub-Kriteria (Likert)</h5>
                    <p class="text-muted small">Tentukan deskripsi untuk setiap tingkat nilai yang akan muncul saat pengisian penilaian.</p>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Helper Text for Manual -->
                            <div id="manual_helper" style="display: none;" class="alert alert-info py-2">
                                <i class="fas fa-info-circle mr-2"></i> Isi rentang nilai angka untuk setiap skor. Jika angka yang diisi masuk dalam rentang Min - Max, skor ini akan otomatis terpilih.
                            </div>

                            @php
                                $skors = [
                                    5 => ['label' => 'Nilai 5 (Sangat Baik)', 'class' => 'font-weight-bold text-success'],
                                    4 => ['label' => 'Nilai 4 (Baik)', 'class' => ''],
                                    3 => ['label' => 'Nilai 3 (Cukup)', 'class' => 'text-warning'],
                                    2 => ['label' => 'Nilai 2 (Kurang)', 'class' => ''],
                                    1 => ['label' => 'Nilai 1 (Buruk)', 'class' => 'text-danger'],
                                ];
                            @endphp

                            @foreach($skors as $nilai => $cfg)
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label {{ $cfg['class'] }}">{{ $cfg['label'] }}</label>
                                <div class="col-sm-5 name-col">
                                    <input type="text" name="subs[{{ $nilai }}]" class="form-control" value="{{ old('subs.'.$nilai, $subs[$nilai]['nama_sub_kriteria'] ?? '') }}" required>
                                </div>
                                <div class="col-sm-2 manual-input" style="display: none;">
                                    <input type="number" step="any" name="subs_min[{{ $nilai }}]" class="form-control manual-req" placeholder="Minimal" value="{{ old('subs_min.'.$nilai, $subs[$nilai]['minimal_nilai'] ?? '') }}">
                                </div>
                                <div class="col-sm-2 manual-input" style="display: none;">
                                    <input type="number" step="any" name="subs_max[{{ $nilai }}]" class="form-control manual-req" placeholder="Maksimal" value="{{ old('subs_max.'.$nilai, $subs[$nilai]['maksimal_nilai'] ?? '') }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning mr-2 text-white">Update Kriteria & Sub</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const tipeInput = document.getElementById('tipe_input');
        const satuanContainer = document.getElementById('satuan_container');
        const manualInputs = document.querySelectorAll('.manual-input');
        const manualReqs = document.querySelectorAll('.manual-req');
        const nameCols = document.querySelectorAll('.name-col');
        const manualHelper = document.getElementById('manual_helper');

        function toggleInputs() {
            if (tipeInput.value === 'manual') {
                satuanContainer.style.display = 'block';
                manualHelper.style.display = 'block';
                manualInputs.forEach(el => el.style.display = 'block');
                manualReqs.forEach(el => el.setAttribute('required', 'required'));
                nameCols.forEach(el => {
                    el.classList.remove('col-sm-9');
                    el.classList.add('col-sm-5');
                });
            } else {
                satuanContainer.style.display = 'none';
                manualHelper.style.display = 'none';
                manualInputs.forEach(el => el.style.display = 'none');
                manualReqs.forEach(el => el.removeAttribute('required'));
                nameCols.forEach(el => {
                    el.classList.remove('col-sm-5');
                    el.classList.add('col-sm-9');
                });
            }
        }

        tipeInput.addEventListener('change', toggleInputs);
        toggleInputs(); // Run on load
    });
</script>
@endpush
