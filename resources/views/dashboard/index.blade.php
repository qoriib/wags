@extends('layouts.app')

@section('title', 'Dashboard - PT WAGS')
@section('header_title', 'Selamat Datang, Admin!')
@section('header_subtitle', 'Ringkasan aktivitas uji kualitas material bulan ini')

@section('content')
<div class="grid grid-3 mb-10">
    <div class="card stat-card">
        <p class="stat-label">Total Uji Bulan Ini</p>
        <h3 class="stat-value">{{ $totalUji }}</h3>
    </div>
    <div class="card stat-card success">
        <p class="stat-label">Layak Kirim</p>
        <h3 class="stat-value success-text">{{ $layakKirim }}</h3>
    </div>
    <div class="card stat-card danger">
        <p class="stat-label">Tidak Layak</p>
        <h3 class="stat-value danger-text">{{ $tidakLayak }}</h3>
    </div>
</div>

<section class="mb-10">
    <h3 class="section-title text-xl">Mulai Klasifikasi Baru</h3>
    <div class="auto-grid">
        @foreach($materials as $material)
        <div class="card material-card">
            <div class="icon-box">
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
            <div>
                <h4 class="font-bold text-lg mb-2">{{ $material->name }}</h4>
                <p class="text-xs text-muted">Uji Kualitas Material</p>
            </div>
            <a href="{{ route('samples.create', $material->id) }}" class="btn btn-outline w-full">Mulai Uji</a>
        </div>
        @endforeach
    </div>
</section>

<section>
    <div class="flex-between mb-6">
        <h3 class="section-title text-xl m-0">Uji Terbaru</h3>
        <a href="{{ route('samples.index') }}" class="primary-text text-sm font-semibold no-underline">Lihat Semua</a>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Material</th>
                    <th>No. Sampel</th>
                    <th>Status</th>
                    <th class="align-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestSamples as $sample)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sample->test_date)->format('d/m/Y') }}</td>
                    <td class="font-bold">{{ $sample->material->name }}</td>
                    <td><code class="code-badge">{{ $sample->sample_no }}</code></td>
                    <td>
                        <span class="badge {{ $sample->status == 'Layak Kirim' ? 'badge-success' : 'badge-danger' }}">
                            {{ $sample->status }}
                        </span>
                    </td>
                    <td class="align-right">
                        <a href="{{ route('samples.show', $sample->id) }}" class="btn btn-outline btn-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-16 text-muted">
                        <i data-lucide="inbox" class="mb-4 opacity-30 w-12 h-12"></i>
                        <p>Belum ada data uji terbaru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
