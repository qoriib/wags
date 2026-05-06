@extends('layouts.app')

@section('title', 'Laporan Uji - PT WAGS')
@section('header_title', 'Laporan Riwayat Pengujian')
@section('header_subtitle', 'Kelola dan pantau seluruh riwayat hasil klasifikasi kualitas material')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <form action="{{ route('samples.index') }}" method="GET" class="grid grid-3">
        <div class="form-group">
            <label class="form-label">Jenis Material</label>
            <select name="material_id" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Material</option>
                @foreach($materials as $material)
                    <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>
                        {{ $material->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Layak Kirim" {{ request('status') == 'Layak Kirim' ? 'selected' : '' }}>Layak Kirim</option>
                <option value="Tidak Layak" {{ request('status') == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Bulan</label>
            <input type="month" name="month" class="form-control" value="{{ request('month') }}" onchange="this.form.submit()">
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 class="section-title" style="font-size: 1.125rem; margin-bottom: 0;">Riwayat Pengujian</h3>
        <div style="display: flex; gap: 0.75rem;">
            <button class="btn btn-outline">
                <i data-lucide="download" style="width: 16px; height: 16px;"></i>
                Export Excel
            </button>
            <button class="btn btn-outline">
                <i data-lucide="file-text" style="width: 16px; height: 16px;"></i>
                Export PDF
            </button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Material</th>
                    <th>No. Sampel</th>
                    <th>Operator</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($samples as $index => $sample)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($sample->test_date)->format('d/m/y') }}</td>
                    <td style="font-weight: 600;">{{ $sample->material->name }}</td>
                    <td>{{ $sample->sample_no }}</td>
                    <td>{{ $sample->operator }}</td>
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
                    <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">Tidak ada data pengujian yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
