@extends('layouts.app')

@section('title', 'Hasil Klasifikasi - ' . $sample->sample_no)
@section('header_title', 'Hasil Klasifikasi Kualitas')
@section('header_subtitle', 'Analisis kelayakan pengiriman material berdasarkan parameter kimia')

@section('content')
<div class="card mb-8 {{ $sample->status == 'Layak Kirim' ? 'report-card-success' : 'report-card-danger' }}">
    <div class="flex-between mb-8">
        <div>
            <h3 class="text-3xl font-bold mb-2 leading-tight tracking-tight">{{ $sample->material->name }} — {{ $sample->sample_no }}</h3>
            <div class="align-center text-muted text-sm">
                <i data-lucide="calendar"></i>
                <span>{{ \Carbon\Carbon::parse($sample->test_date)->translatedFormat('d F Y') }}</span>
                <span class="opacity-30">|</span>
                <i data-lucide="user"></i>
                <span>Operator: {{ $sample->operator }}</span>
            </div>
        </div>
        <div class="badge {{ $sample->status == 'Layak Kirim' ? 'badge-success' : 'badge-danger' }} badge-lg">
            <i data-lucide="{{ $sample->status == 'Layak Kirim' ? 'check-circle' : 'x-circle' }}" class="v-middle mr-2"></i>
            <span>{{ strtoupper($sample->status) }}</span>
        </div>
    </div>

    <div class="analysis-box {{ $sample->status == 'Layak Kirim' ? 'analysis-box-success' : 'analysis-box-danger' }}">
        <h4 class="font-bold text-lg mb-2 d-flex items-center gap-3">
            <i data-lucide="{{ $sample->status == 'Layak Kirim' ? 'info' : 'alert-triangle' }}"></i>
            {{ $sample->status == 'Layak Kirim' ? 'Material memenuhi standar kualitas' : 'Material tidak memenuhi standar kualitas' }}
        </h4>
        <p class="text-main">
            {{ $sample->status == 'Layak Kirim' 
                ? 'Material ini layak dikirim ke semua pabrik tujuan PT WAGS karena semua parameter kimia berada dalam rentang toleransi yang ditentukan dalam Standar SNI 0449:2010.' 
                : 'Ditemukan parameter yang tidak memenuhi standar. Material ini tidak direkomendasikan untuk pengiriman reguler karena risiko ketidaksesuaian kualitas produksi.' 
            }}
        </p>
    </div>
</div>

<div class="card mb-8">
    <h3 class="section-title text-xl">Detail Parameter Laboratorium</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Parameter Kimia</th>
                    <th>Nilai Hasil Uji</th>
                    <th>Standar Ambang Batas</th>
                    <th class="align-right">Status Analisis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sample->details as $detail)
                    @php
                        $isTarget = strtolower($sample->material->chemical_formula) == strtolower($detail->material->name) 
                                 || strtolower($sample->material->chemical_formula) == strtolower($detail->material->slug);
                        
                        $rule = $sample->material->rules->first();
                        $status = 'Informasi';
                        $standard = '—';
                        
                        if ($isTarget && $rule) {
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
                        <td class="font-bold text-sm">
                            {{ $detail->material->name }}
                            @if($isTarget) <span class="badge badge-primary text-xs ml-2 font-bold p-1">TARGET</span> @endif
                        </td>
                        <td>{{ number_format($detail->value * 100, 2) }}%</td>
                        <td class="text-muted">{{ $standard }}</td>
                        <td class="align-right">
                            <span class="badge {{ $status == 'Memenuhi' ? 'badge-success' : ($status == 'Tidak Memenuhi' ? 'badge-danger' : 'badge-outline') }}">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card dashed-card">
    <h3 class="section-title text-xl mb-6 d-flex items-center gap-3">
        <i data-lucide="cpu" class="primary-text"></i>
        Logika Sistem Pakar (Forward Chaining)
    </h3>
    <div class="code-box">
        <p class="mb-2"><span class="text-muted">// Analisis material</span></p>
        <p class="mb-2"><span class="danger-text font-bold">IF</span> material == <strong>"{{ $sample->material->name }}"</strong></p>
        @foreach($sample->material->rules as $rule)
            <p class="mb-2 pl-4"><span class="danger-text font-bold">AND</span> {{ $sample->material->chemical_formula }} {{ $rule->operator }} {{ $rule->value * 100 }}%</p>
        @endforeach
        <p class="mt-4"><span class="danger-text font-bold">THEN</span> status = <span class="badge badge-primary font-bold">"{{ $sample->status }}"</span></p>
    </div>
</div>

<div class="flex-between mt-10">
    <a href="{{ route('dashboard') }}" class="btn btn-outline min-w-160">
        <i data-lucide="arrow-left"></i>
        <span>Kembali</span>
    </a>
    <div class="d-flex flex-gap-4">
        <button onclick="window.print()" class="btn btn-primary min-w-240">
            <i data-lucide="printer"></i>
            <span>Simpan & Cetak Laporan</span>
        </button>
    </div>
</div>
@endsection
