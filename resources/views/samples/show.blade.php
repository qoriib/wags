@extends('layouts.app')

@section('title', 'Hasil Klasifikasi - ' . $sample->sample_no)
@section('header_title', 'Hasil Klasifikasi Kualitas')
@section('header_subtitle', 'Analisis kelayakan pengiriman material berdasarkan parameter kimia')

@section('content')
<div class="card" style="margin-bottom: 2rem; border-left: 6px solid {{ $sample->status == 'Layak Kirim' ? 'var(--success)' : 'var(--danger)' }};">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $sample->material->name }} — {{ $sample->sample_no }}</h3>
            <p style="color: var(--text-muted); font-size: 0.875rem;">
                {{ \Carbon\Carbon::parse($sample->test_date)->translatedFormat('d F Y') }} • Operator: {{ $sample->operator }}
            </p>
        </div>
        <div class="badge {{ $sample->status == 'Layak Kirim' ? 'badge-success' : 'badge-danger' }}" style="padding: 0.5rem 1.5rem; font-size: 1rem;">
            <i data-lucide="{{ $sample->status == 'Layak Kirim' ? 'check-circle' : 'x-circle' }}" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 0.5rem;"></i>
            {{ strtoupper($sample->status) }}
        </div>
    </div>

    <div style="background: {{ $sample->status == 'Layak Kirim' ? 'var(--success-light)' : 'var(--danger-light)' }}; border-radius: 8px; padding: 1.5rem; border: 1px solid {{ $sample->status == 'Layak Kirim' ? 'var(--success)' : 'var(--danger)' }};">
        <h4 style="font-weight: 700; color: {{ $sample->status == 'Layak Kirim' ? 'var(--success)' : 'var(--danger)' }}; margin-bottom: 0.5rem;">
            {{ $sample->status == 'Layak Kirim' ? 'Material memenuhi standar kualitas' : 'Material tidak memenuhi standar kualitas' }}
        </h4>
        <p style="color: var(--text-main); font-size: 0.875rem;">
            {{ $sample->status == 'Layak Kirim' 
                ? 'Material ini layak dikirim ke semua pabrik tujuan PT WAGS karena semua parameter kimia berada dalam rentang toleransi yang ditentukan.' 
                : 'Ditemukan parameter yang tidak memenuhi standar. Material ini tidak direkomendasikan untuk pengiriman reguler.' 
            }}
        </p>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <h3 class="section-title" style="font-size: 1.125rem;">Detail Parameter</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Nilai Input</th>
                    <th>Standar Ambang Batas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $params = [
                        ['label' => 'Fe₂O₃', 'val' => $sample->fe2o3, 'key' => 'Fe2O3'],
                        ['label' => 'CaO', 'val' => $sample->cao, 'key' => 'CaO'],
                        ['label' => 'SiO₂', 'val' => $sample->sio2, 'key' => 'SiO2'],
                        ['label' => 'Al₂O₃', 'val' => $sample->al2o3, 'key' => 'Al2O3'],
                        ['label' => 'CaCO₃', 'val' => $sample->caco3, 'key' => 'CaCO3'],
                        ['label' => 'LoI', 'val' => $sample->loi, 'key' => 'LoI'],
                    ];
                @endphp

                @foreach($params as $param)
                    @if($param['val'] !== null)
                        @php
                            $rule = $sample->material->rules->where('parameter', $param['key'])->first();
                            $status = 'Memenuhi';
                            $standard = '—';
                            
                            if ($rule) {
                                $standard = $rule->operator . ' ' . $rule->value . '%';
                                $passed = match($rule->operator) {
                                    'Kurang dari' => $param['val'] < $rule->value,
                                    'Lebih dari' => $param['val'] > $rule->value,
                                    default => true
                                };
                                $status = $passed ? 'Memenuhi' : 'Tidak Memenuhi';
                            }
                        @endphp
                        <tr>
                            <td style="font-weight: 600;">{{ $param['label'] }}</td>
                            <td>{{ number_format($param['val'], 2) }}%</td>
                            <td>{{ $standard }}</td>
                            <td>
                                <span class="badge {{ $status == 'Memenuhi' ? 'badge-success' : 'badge-danger' }}" style="font-size: 0.7rem;">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="background: #f8fafc; border-style: dashed;">
    <h3 class="section-title" style="font-size: 1rem; margin-bottom: 1rem;">Aturan Forward Chaining yang Digunakan</h3>
    <div style="background: white; border-radius: 8px; padding: 1.5rem; border: 1px solid var(--border); font-family: 'Courier New', Courier, monospace; font-size: 0.875rem; color: var(--primary);">
        <p>IF material = <strong>{{ $sample->material->name }}</strong></p>
        @foreach($sample->material->rules as $rule)
            <p>AND {{ $rule->parameter }} {{ $rule->operator }} {{ $rule->value }}%</p>
        @endforeach
        <p>THEN status = <strong>Layak Kirim</strong></p>
    </div>
</div>

<div style="display: flex; gap: 1rem; justify-content: space-between; margin-top: 2rem;">
    <a href="{{ route('dashboard') }}" class="btn btn-outline">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        Uji Material Lain
    </a>
    <div style="display: flex; gap: 1rem;">
        <button onclick="window.print()" class="btn btn-primary">
            Simpan & Cetak Laporan
            <i data-lucide="printer" style="width: 16px; height: 16px;"></i>
        </button>
    </div>
</div>
@endsection
