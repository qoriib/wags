@extends('layouts.app')

@section('title', 'Laporan Uji - PT WAGS')
@section('header_title', 'Laporan Hasil Uji Material')
@section('header_subtitle', 'Daftar keseluruhan data hasil klasifikasi laboratorium')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('samples.index') }}" method="GET" id="filter-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-muted fw-semibold small mb-2">Jenis Material</label>
                    <select name="material_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Material</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label text-muted fw-semibold small mb-2">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Layak Kirim" {{ request('status') == 'Layak Kirim' ? 'selected' : '' }}>Layak Kirim</option>
                        <option value="Tidak Layak" {{ request('status') == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted fw-semibold small mb-2">Bulan</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}" onchange="this.form.submit()">
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-light w-100 py-2" onclick="window.location.href='{{ route('samples.index') }}'">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="section-title mb-0">REKAPITULASI HASIL UJI</h3>
            <a href="{{ route('samples.export', request()->all()) }}" class="btn btn-outline-success">
                <i data-lucide="download" class="me-2 w-4 h-4"></i>
                <span>Export CSV</span>
            </a>
        </div>

        <div class="table-responsive table-container border-0 shadow-none">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Tanggal</th>
                        <th>Material</th>
                        <th>No. Sampel</th>
                        <th>Operator</th>
                        <th>Fe₂O₃ (%)</th>
                        <th>CaO (%)</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($samples as $index => $sample)
                    @php
                        $fe2o3 = $sample->details->where('material.slug', 'fe2o3')->first();
                        $cao = $sample->details->where('material.slug', 'cao')->first();
                    @endphp
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($sample->test_date)->format('d/m/Y') }}</td>
                        <td class="font-semibold">{{ $sample->material->name }}</td>
                        <td><code class="code-badge text-primary">{{ $sample->sample_no }}</code></td>
                        <td>{{ $sample->operator }}</td>
                        <td class="fw-medium text-primary">{{ $fe2o3 ? number_format($fe2o3->value * 100, 2) . '%' : '-' }}</td>
                        <td class="fw-medium text-primary">{{ $cao ? number_format($cao->value * 100, 2) . '%' : '-' }}</td>
                        <td>
                            <span class="badge {{ $sample->status == 'Layak Kirim' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-3 py-2">
                                {{ $sample->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('samples.show', $sample->id) }}" class="btn btn-sm btn-light text-primary border-0 shadow-none">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i data-lucide="inbox" class="mb-3 opacity-25" style="width: 48px; height: 48px;"></i>
                            <p>Belum ada data laporan untuk kriteria ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
