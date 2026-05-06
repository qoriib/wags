@extends('layouts.app')

@section('title', 'Laporan Uji - PT WAGS')
@section('header_title', 'Laporan Hasil Uji Material')
@section('header_subtitle', 'Daftar keseluruhan data hasil klasifikasi laboratorium')

@section('content')
<div class="card" style="margin-bottom: 1.5rem; padding: 1.25rem;">
    <form action="{{ route('samples.index') }}" method="GET" id="filter-form">
        <div style="display: flex; gap: 1.5rem; align-items: center;">
            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Jenis Material</label>
                <select name="material_id" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border-radius: 8px;">
                    <option value="">Semua Material</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Status</label>
                <select name="status" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border-radius: 8px;">
                    <option value="">Semua Status</option>
                    <option value="Layak Kirim" {{ request('status') == 'Layak Kirim' ? 'selected' : '' }}>Layak Kirim</option>
                    <option value="Tidak Layak" {{ request('status') == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                </select>
            </div>

            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Bulan</label>
                <input type="month" name="month" class="form-control" value="{{ request('month') }}" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border-radius: 8px;">
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 class="section-title" style="margin-bottom: 0;">REKAPITULASI HASIL UJI</h3>
        <a href="{{ route('samples.export', request()->all()) }}" class="btn btn-outline" style="border-color: #10b981; color: #10b981;">
            <i data-lucide="download" style="width: 16px; height: 16px;"></i>
            Export CSV
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Material</th>
                    <th>No. Sampel</th>
                    <th>Operator</th>
                    <th>Fe₂O₃ (%)</th>
                    <th>CaO (%)</th>
                    <th>Status</th>
                    <th style="text-align: right;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($samples as $index => $sample)
                @php
                    $fe2o3 = $sample->details->where('material.slug', 'fe2o3')->first();
                    $cao = $sample->details->where('material.slug', 'cao')->first();
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($sample->test_date)->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">{{ $sample->material->name }}</td>
                    <td><code style="background: var(--bg); padding: 0.2rem 0.5rem; border-radius: 4px;">{{ $sample->sample_no }}</code></td>
                    <td>{{ $sample->operator }}</td>
                    <td>{{ $fe2o3 ? number_format($fe2o3->value * 100, 2) . '%' : '-' }}</td>
                    <td>{{ $cao ? number_format($cao->value * 100, 2) . '%' : '-' }}</td>
                    <td>
                        <span class="badge {{ $sample->status == 'Layak Kirim' ? 'badge-success' : 'badge-danger' }}">
                            {{ $sample->status }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('samples.show', $sample->id) }}" style="color: var(--primary); text-decoration: none;">
                            <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        <i data-lucide="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Belum ada data laporan untuk kriteria ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
