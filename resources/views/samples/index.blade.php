@extends('layouts.app')

@section('title', 'Laporan Uji - PT WAGS')
@section('header_title', 'Laporan Hasil Uji Material')
@section('header_subtitle', 'Daftar keseluruhan data hasil klasifikasi laboratorium')

@section('content')
<div class="card filter-card">
    <form action="{{ route('samples.index') }}" method="GET" id="filter-form">
        <div class="filter-grid d-flex items-center gap-6">
            <div class="form-group flex-1 mb-0">
                <label class="form-label text-xs mb-2">Jenis Material</label>
                <select name="material_id" class="form-control btn-sm" onchange="this.form.submit()">
                    <option value="">Semua Material</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group flex-1 mb-0">
                <label class="form-label text-xs mb-2">Status</label>
                <select name="status" class="form-control btn-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Layak Kirim" {{ request('status') == 'Layak Kirim' ? 'selected' : '' }}>Layak Kirim</option>
                    <option value="Tidak Layak" {{ request('status') == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                </select>
            </div>

            <div class="form-group flex-1 mb-0">
                <label class="form-label text-xs mb-2">Bulan</label>
                <input type="month" name="month" class="form-control btn-sm" value="{{ request('month') }}" onchange="this.form.submit()">
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="flex-between mb-8">
        <h3 class="section-title mb-0">REKAPITULASI HASIL UJI</h3>
        <a href="{{ route('samples.export', request()->all()) }}" class="btn btn-outline success-outline">
            <i data-lucide="download"></i>
            <span>Export CSV</span>
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
                    <th class="align-right">Detail</th>
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
                    <td class="font-semibold">{{ $sample->material->name }}</td>
                    <td><code class="code-badge">{{ $sample->sample_no }}</code></td>
                    <td>{{ $sample->operator }}</td>
                    <td>{{ $fe2o3 ? number_format($fe2o3->value * 100, 2) . '%' : '-' }}</td>
                    <td>{{ $cao ? number_format($cao->value * 100, 2) . '%' : '-' }}</td>
                    <td>
                        <span class="badge {{ $sample->status == 'Layak Kirim' ? 'badge-success' : 'badge-danger' }}">
                            {{ $sample->status }}
                        </span>
                    </td>
                    <td class="align-right">
                        <a href="{{ route('samples.show', $sample->id) }}" class="primary-text">
                            <i data-lucide="eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center p-12 text-muted">
                        <i data-lucide="inbox" class="mb-4 opacity-50 w-12 h-12"></i>
                        <p>Belum ada data laporan untuk kriteria ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
