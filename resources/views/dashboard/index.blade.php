@extends('layouts.app')

@section('title', 'Dashboard - PT WAGS')
@section('header_title', 'Selamat Datang, Admin!')
@section('header_subtitle', 'Ringkasan aktivitas uji kualitas material bulan ini')

@section('content')
<div class="grid grid-3" style="margin-bottom: 2.5rem;">
    <div class="card" style="text-align: center; padding: 2rem;">
        <p style="color: var(--text-muted); font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem;">Total Uji Bulan Ini</p>
        <h3 style="font-size: 2.5rem; font-weight: 700; color: var(--text-main);">{{ $totalUji }}</h3>
    </div>
    <div class="card" style="text-align: center; padding: 2rem; border-bottom: 4px solid var(--success);">
        <p style="color: var(--text-muted); font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem;">Layak Kirim</p>
        <h3 style="font-size: 2.5rem; font-weight: 700; color: var(--success);">{{ $layakKirim }}</h3>
    </div>
    <div class="card" style="text-align: center; padding: 2rem; border-bottom: 4px solid var(--danger);">
        <p style="color: var(--text-muted); font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem;">Tidak Layak</p>
        <h3 style="font-size: 2.5rem; font-weight: 700; color: var(--danger);">{{ $tidakLayak }}</h3>
    </div>
</div>

<section style="margin-bottom: 2.5rem;">
    <h3 class="section-title" style="font-size: 1.125rem;">Mulai Klasifikasi Baru</h3>
    <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
        @foreach($materials as $material)
        <div class="card" style="display: flex; flex-direction: column; align-items: center; gap: 1rem; text-align: center;">
            <div style="width: 80px; height: 80px; background: var(--bg); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
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
                <i data-lucide="{{ $icon }}" style="width: 32px; height: 32px; color: var(--primary);"></i>
            </div>
            <div>
                <h4 style="font-weight: 700; margin-bottom: 0.25rem;">{{ $material->name }}</h4>
                <p style="font-size: 0.75rem; color: var(--text-muted);">Cek Kualitas</p>
            </div>
            <a href="{{ route('samples.create', $material->id) }}" class="btn btn-outline" style="width: 100%;">Mulai Uji</a>
        </div>
        @endforeach
    </div>
</section>

<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 class="section-title" style="font-size: 1.125rem; margin-bottom: 0;">Uji Terbaru</h3>
        <a href="{{ route('samples.index') }}" style="color: var(--primary); font-size: 0.875rem; font-weight: 600; text-decoration: none;">Lihat Semua</a>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Material</th>
                    <th>No. Sampel</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestSamples as $sample)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sample->test_date)->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">{{ $sample->material->name }}</td>
                    <td>{{ $sample->sample_no }}</td>
                    <td>
                        <span class="badge {{ $sample->status == 'Layak Kirim' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($sample->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('samples.show', $sample->id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">Belum ada data uji terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
