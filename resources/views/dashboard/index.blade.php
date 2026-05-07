@extends('layouts.app')

@section('title', 'Dashboard - PT WAGS')
@section('header_title', 'Selamat Datang, Admin!')
@section('header_subtitle', 'Ringkasan aktivitas uji kualitas material bulan ini')

@section('content')
<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3 g-lg-4 mb-4 mb-lg-5">
    <div class="col">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body p-3 p-lg-4">
                <p class="stat-label text-uppercase text-muted small fw-semibold mb-1">Total Uji Bulan Ini</p>
                <h3 class="stat-value fw-bold mb-0">{{ $totalUji }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card success border-0 shadow-sm h-100">
            <div class="card-body p-3 p-lg-4">
                <p class="stat-label text-uppercase text-muted small fw-semibold mb-1">Layak Kirim</p>
                <h3 class="stat-value success-text fw-bold mb-0">{{ $layakKirim }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card danger border-0 shadow-sm h-100">
            <div class="card-body p-3 p-lg-4">
                <p class="stat-label text-uppercase text-muted small fw-semibold mb-1">Tidak Layak</p>
                <h3 class="stat-value danger-text fw-bold mb-0">{{ $tidakLayak }}</h3>
            </div>
        </div>
    </div>
</div>

<section class="mb-5">
    <h3 class="section-title mb-4">Mulai Klasifikasi Baru</h3>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3 g-lg-4">
        @foreach($materials as $material)
        <div class="col">
            <div class="card material-card border-0 shadow-sm h-100">
                <div class="card-body p-3 p-lg-4 d-flex flex-column align-items-center text-center gap-2">
                    <div class="icon-box mb-3">
                        @php
                            $icon = match($material->slug) {
                                'kaolin' => 'mountain',
                                'limestone' => 'container',
                                'clay-f1' => 'brick',
                                'feldspar' => 'diamond',
                                'clay-pasiran' => 'loader',
                                default => 'box'
                            };
                        @endphp
                        <i data-lucide="{{ $icon }}"></i>
                    </div>
                    <div class="mb-3">
                        <h4 class="h5 fw-semibold mb-1">{{ $material->name }}</h4>
                        <p class="small text-muted mb-0">Uji Kualitas Material</p>
                    </div>
                    <a href="{{ route('samples.create', $material->id) }}" class="btn btn-outline-primary w-100 mt-auto fw-semibold">Mulai Uji</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
        <h3 class="section-title m-0">Uji Terbaru</h3>
        <a href="{{ route('samples.index') }}" class="primary-text small fw-semibold text-decoration-none mt-1 mt-sm-0">Lihat Semua</a>
    </div>

    <div class="card border-0 shadow-sm table-container rounded-4">
        <div class="table-responsive-lg">
            <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4 text-nowrap">Tanggal</th>
                    <th>Material</th>
                    <th>No. Sampel</th>
                    <th>Status</th>
                    <th class="text-end pe-4 text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestSamples as $sample)
                <tr>
                    <td class="ps-4 text-nowrap">{{ \Carbon\Carbon::parse($sample->test_date)->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $sample->material->name }}</td>
                    <td><code class="code-badge">{{ $sample->sample_no }}</code></td>
                    <td>
                        <span class="badge {{ $sample->status == 'Layak Kirim' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-3 py-2">
                            {{ $sample->status }}
                        </span>
                    </td>
                    <td class="text-end pe-4 text-nowrap">
                        <a href="{{ route('samples.show', $sample->id) }}" class="btn btn-sm btn-outline-primary rounded-3 fw-semibold">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 py-md-5 text-muted">
                        <i data-lucide="inbox" class="mb-3 opacity-25" style="width: 48px; height: 48px;"></i>
                        <p>Belum ada data uji terbaru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
