@extends('layouts.app')

@section('title', 'Input Data Uji - ' . $materialName)
@section('header_title', 'Halaman Input Data Uji')
@section('header_subtitle', 'Masukkan hasil uji laboratorium untuk material ' . $materialName)

@section('content')
<form action="{{ route('samples.store') }}" method="POST">
    @csrf
    <div class="row g-4 mb-4">
        <!-- Informasi Sampel -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="section-title mb-4">Informasi Sampel</h3>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Material</label>
                        <select name="material_id" class="form-select" required>
                            <option value="">Pilih Material</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" {{ old('material_id', $selectedMaterial?->id) == $material->id ? 'selected' : '' }}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_id')
                            <div class="text-danger small mt-1 fw-medium">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Sampel *</label>
                        <input type="text" name="sample_no" class="form-control" placeholder="Contoh: LAB-2026-001" required value="{{ old('sample_no', $defaultSampleNo) }}">
                        @error('sample_no') 
                            <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Uji *</label>
                        <input type="date" name="test_date" class="form-control" required value="{{ old('test_date', date('Y-m-d')) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Operator *</label>
                        <input type="text" name="operator" class="form-control" placeholder="Nama petugas lab" required value="{{ old('operator', $defaultOperator) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Parameter Hasil Uji -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="section-title mb-3">Parameter Hasil Uji</h3>
                    <p class="text-muted small mb-4">Isi parameter sesuai hasil uji laboratorium (Standar SNI 0449:2010)</p>

                    <div class="row g-3">
                        @foreach($parameters as $parameter)
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">{{ $parameter->name }} (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.0001" min="0" max="100" name="{{ $parameter->slug }}" class="form-control" placeholder="0.0000" value="{{ old($parameter->slug) }}">
                                    <span class="input-group-text bg-light text-muted small">%</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 py-2">Batal</a>
        <button type="submit" class="btn btn-primary px-5 py-2">
            <span class="me-2">Proses Klasifikasi</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </div>
</form>
@endsection
