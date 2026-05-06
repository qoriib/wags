@extends('layouts.app')

@section('title', 'Input Data Uji - ' . $material->name)
@section('header_title', 'Halaman Input Data Uji')
@section('header_subtitle', 'Masukkan hasil uji laboratorium untuk material ' . $material->name)

@section('content')
<form action="{{ route('samples.store') }}" method="POST">
    @csrf
    <input type="hidden" name="material_id" value="{{ $material->id }}">

    <div class="grid grid-2" style="margin-bottom: 2rem;">
        <!-- Informasi Sampel -->
        <div class="card">
            <h3 class="section-title" style="font-size: 1.125rem;">Informasi Sampel</h3>
            
            <div class="form-group">
                <label class="form-label">Jenis Material</label>
                <input type="text" class="form-control" value="{{ $material->name }}" disabled>
            </div>

            <div class="form-group">
                <label class="form-label">No. Sampel *</label>
                <input type="text" name="sample_no" class="form-control" placeholder="Contoh: LAB-2026-001" required value="{{ old('sample_no') }}">
                @error('sample_no') <p style="color: var(--danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Uji *</label>
                <input type="date" name="test_date" class="form-control" required value="{{ old('test_date', date('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Operator *</label>
                <input type="text" name="operator" class="form-control" placeholder="Nama petugas lab" required value="{{ old('operator') }}">
            </div>
        </div>

        <!-- Parameter Hasil Uji -->
        <div class="card">
            <h3 class="section-title" style="font-size: 1.125rem;">Parameter Kimia Hasil Uji Lab</h3>
            <p style="color: var(--text-muted); font-size: 0.75rem; margin-bottom: 1.5rem;">Isi parameter sesuai hasil uji laboratorium (SNI 0449:2010)</p>

            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Fe₂O₃ (%)</label>
                    <input type="number" step="0.0001" name="fe2o3" class="form-control" placeholder="0,00" value="{{ old('fe2o3') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">CaO (%)</label>
                    <input type="number" step="0.0001" name="cao" class="form-control" placeholder="0,00" value="{{ old('cao') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">SiO₂ (%)</label>
                    <input type="number" step="0.0001" name="sio2" class="form-control" placeholder="0,00" value="{{ old('sio2') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Al₂O₃ (%)</label>
                    <input type="number" step="0.0001" name="al2o3" class="form-control" placeholder="0,00" value="{{ old('al2o3') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">CaCO₃ (%)</label>
                    <input type="number" step="0.0001" name="caco3" class="form-control" placeholder="0,00" value="{{ old('caco3') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">LoI (%)</label>
                    <input type="number" step="0.0001" name="loi" class="form-control" placeholder="0,00" value="{{ old('loi') }}">
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline" style="min-width: 120px;">Batal</a>
        <button type="submit" class="btn btn-primary" style="min-width: 200px;">
            Proses Klasifikasi
            <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
        </button>
    </div>
</form>
@endsection
