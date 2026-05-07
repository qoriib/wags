@extends('layouts.app')

@section('title', 'Hasil Klasifikasi - ' . $sample->sample_no)
@section('header_title', 'Hasil Klasifikasi Kualitas')
@section('header_subtitle', 'Analisis kelayakan pengiriman material berdasarkan parameter kimia')

@section('content')
<div class="card mb-4 border-0 shadow-sm {{ $sample->status == 'Layak Kirim' ? 'border-start border-5 border-success' : 'border-start border-5 border-danger' }}">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h3 class="text-3xl font-bold mb-2 tracking-tight">{{ $sample->material->name }} — {{ $sample->sample_no }}</h3>
                <div class="d-flex align-items-center text-muted small">
                    <i data-lucide="calendar" class="w-4 h-4 me-2"></i>
                    <span>{{ \Carbon\Carbon::parse($sample->test_date)->translatedFormat('d F Y') }}</span>
                    <span class="mx-3 opacity-25">|</span>
                    <i data-lucide="user" class="w-4 h-4 me-2"></i>
                    <span>Operator: {{ $sample->operator }}</span>
                </div>
            </div>
            <div class="badge {{ $sample->status == 'Layak Kirim' ? 'bg-success' : 'bg-danger' }} rounded-pill px-4 py-3">
                <div class="d-flex align-items-center">
                    <i data-lucide="{{ $sample->status == 'Layak Kirim' ? 'check-circle' : 'x-circle' }}" class="me-2 w-5 h-5"></i>
                    <span class="fw-bold">{{ strtoupper($sample->status) }}</span>
                </div>
            </div>
        </div>

        <div class="alert {{ $sample->status == 'Layak Kirim' ? 'alert-success' : 'alert-danger' }} border-0 shadow-none mb-0">
            <h4 class="alert-heading fw-bold d-flex align-items-center gap-2 mb-2">
                <i data-lucide="{{ $sample->status == 'Layak Kirim' ? 'info' : 'alert-triangle' }}"></i>
                {{ $sample->status == 'Layak Kirim' ? 'Material memenuhi standar kualitas' : 'Material tidak memenuhi standar kualitas' }}
            </h4>
            <p class="mb-0">
                {{ $sample->status == 'Layak Kirim' 
                    ? 'Material ini layak dikirim ke semua pabrik tujuan PT WAGS karena semua parameter kimia berada dalam rentang toleransi yang ditentukan dalam Standar SNI 0449:2010.' 
                    : 'Ditemukan parameter yang tidak memenuhi standar. Material ini tidak direkomendasikan untuk pengiriman reguler karena risiko ketidaksesuaian kualitas produksi.' 
                }}
            </p>
        </div>
    </div>
</div>

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
        <h3 class="section-title mb-4">Detail Parameter Laboratorium</h3>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4 text-nowrap">Parameter Kimia</th>
                    <th class="text-nowrap">Nilai Hasil Uji</th>
                    <th class="text-nowrap">Standar Ambang Batas</th>
                    <th class="text-end pe-4 text-nowrap">Status Analisis</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rulesByParameter = $sample->material->rules->keyBy('parameter_id');
                @endphp
                @foreach($sample->details as $detail)
                    @php
                        $rule = $rulesByParameter->get($detail->parameter_id);
                        $status = 'Informasi';
                        $standard = '—';
                        
                        if ($rule) {
                            $standard = $rule->operator . ' ' . ($rule->value * 100) . '%';
                            $passed = match($rule->operator) {
                                '<' => $detail->value < $rule->value,
                                '>' => $detail->value > $rule->value,
                                '<=' => $detail->value <= $rule->value,
                                '>=' => $detail->value >= $rule->value,
                                default => true
                            };
                            $status = $passed ? 'Memenuhi' : 'Tidak Memenuhi';
                        }
                    @endphp
                    <tr>
                        <td class="ps-4 fw-bold text-nowrap">
                            {{ $detail->parameter->name }}
                        </td>
                        <td class="fw-semibold text-primary text-nowrap">{{ number_format($detail->value * 100, 2) }}%</td>
                        <td class="text-muted text-nowrap">{{ $standard }}</td>
                        <td class="text-end pe-4 text-nowrap">
                            <span class="badge {{ $status == 'Memenuhi' ? 'bg-success-subtle text-success' : ($status == 'Tidak Memenuhi' ? 'bg-danger-subtle text-danger' : 'bg-light text-muted border') }} rounded-pill px-3 py-2">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm bg-light-subtle dashed-card border-dashed">
    <div class="card-body p-4">
        <h3 class="section-title mb-4 d-flex align-items-center gap-2">
            <i data-lucide="cpu" class="text-primary"></i>
            Logika Sistem Pakar (Forward Chaining)
        </h3>
        <div class="bg-white rounded-3 p-4 border shadow-sm font-monospace small">
            <p class="mb-2 text-muted">// Analisis material</p>
            <p class="mb-2"><span class="text-danger fw-bold">IF</span> material == <strong>"{{ $sample->material->name }}"</strong></p>
            @foreach($sample->material->rules as $rule)
                <p class="mb-2 ps-4"><span class="text-danger fw-bold">AND</span> {{ $rule->parameter?->name ?? '—' }} {{ $rule->operator }} {{ $rule->value * 100 }}%</p>
            @endforeach
            <p class="mt-4"><span class="text-danger fw-bold">THEN</span> status = <span class="badge bg-primary-subtle text-primary fw-bold px-3">"{{ $sample->status }}"</span></p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-4 d-print-none">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 py-2">
        <i data-lucide="arrow-left" class="me-2 w-4 h-4"></i>
        <span>Kembali</span>
    </a>
    <button onclick="window.print()" class="btn btn-primary px-5 py-2 shadow-sm">
        <i data-lucide="printer" class="me-2 w-4 h-4"></i>
        <span>Simpan & Cetak Laporan</span>
    </button>
</div>
@endsection
