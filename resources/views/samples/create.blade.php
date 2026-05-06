@extends('layouts.app')

@section('title', 'Input Data Uji - ' . $material->name)
@section('header_title', 'Halaman Input Data Uji')
@section('header_subtitle', 'Masukkan hasil uji laboratorium untuk material ' . $material->name)

@section('content')
<form action="{{ route('samples.store') }}" method="POST">
    @csrf
    <input type="hidden" name="material_id" value="{{ $material->id }}">

    <div class="grid grid-2 mb-8">
        <!-- Informasi Sampel -->
        <div class="card">
            <h3 class="section-title text-xl">Informasi Sampel</h3>
            
            <div class="form-group">
                <label class="form-label">Jenis Material</label>
                <input type="text" class="form-control bg-muted" value="{{ $material->name }}" disabled>
            </div>

            <div class="form-group">
                <label class="form-label">No. Sampel *</label>
                <input type="text" name="sample_no" class="form-control" placeholder="Contoh: LAB-2026-001" required value="{{ old('sample_no') }}">
                @error('sample_no') 
                    <p class="error-message">{{ $message }}</p> 
                @enderror
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
            <h3 class="section-title text-xl">Parameter Hasil Uji</h3>
            <p class="text-muted text-sm mb-8">Isi parameter sesuai hasil uji laboratorium (Standar SNI 0449:2010)</p>

            <div class="grid grid-2">
                @foreach(['fe2o3' => 'Fe₂O₃', 'cao' => 'CaO', 'sio2' => 'SiO₂', 'al2o3' => 'Al₂O₃', 'caco3' => 'CaCO₃', 'loi' => 'LoI'] as $key => $label)
                <div class="form-group">
                    <label class="form-label">{{ $label }} (%)</label>
                    <input type="number" step="0.0001" name="{{ $key }}" class="form-control" placeholder="0.0000" value="{{ old($key) }}">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex flex-gap-4 justify-end">
        <a href="{{ route('dashboard') }}" class="btn btn-outline min-w-140">Batal</a>
        <button type="submit" class="btn btn-primary min-w-220">
            <span>Proses Klasifikasi</span>
            <i data-lucide="arrow-right"></i>
        </button>
    </div>
</form>
@endsection
