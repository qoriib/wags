@extends('layouts.app')

@section('title', 'Pengaturan Aturan - PT WAGS')
@section('header_title', 'Basis Aturan Forward Chaining')
@section('header_subtitle', 'Kelola parameter dan ambang batas untuk klasifikasi kualitas material')

@section('content')
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="section-title mb-1">BASIS ATURAN FORWARD CHAINING</h3>
                <p class="text-muted small mb-0">Kelola parameter dan ambang batas aturan</p>
            </div>
            <button class="btn btn-primary fw-semibold" onclick="resetForm()">
                <i data-lucide="plus" class="me-2"></i>
                <span>Tambah Aturan</span>
            </button>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Material</th>
                        <th>Parameter (Rumus)</th>
                        <th>Kondisi</th>
                        <th>Nilai Batas</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rules as $rule)
                    <tr>
                        <td class="ps-4 font-bold">{{ $rule->material->name }}</td>
                        <td><code class="code-badge text-primary">{{ $rule->parameter?->name ?? '—' }}</code></td>
                        <td>
                            @php
                                $opLabel = match($rule->operator) {
                                    '<' => 'Kurang dari',
                                    '>' => 'Lebih dari',
                                    '<=' => 'Kurang dari sama dengan',
                                    '>=' => 'Lebih dari sama dengan',
                                };
                            @endphp
                            <span class="text-muted">{{ $opLabel }}</span> 
                            <span class="badge bg-light text-dark ms-1">{{ $rule->operator }}</span>
                        </td>
                        <td class="font-semibold text-primary">{{ $rule->value * 100 }}%</td>
                        <td class="text-end hstack justify-content-end gap-2">
                            <button onclick="editRule({{ json_encode($rule) }})" class="btn btn-sm btn-outline-secondary">
                                Edit
                            </button>
                            
                            <form action="{{ route('settings.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm scroll-mt-8" id="form-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <h3 class="section-title mb-0" id="form-title">TAMBAH ATURAN BARU</h3>
        </div>
        
        <form id="rule-form" action="{{ route('settings.rules.store') }}" method="POST">
            @csrf
            <div id="method-field"></div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Material</label>
                        <select name="material_id" id="material_id" class="form-select" required onchange="updateFormulaDisplay()">
                            <option value="">Pilih Material</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" data-formula="{{ $material->formula }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Formula Material</label>
                        <input type="text" id="formula-display" class="form-control" value="—" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parameter</label>
                        <select name="parameter_id" id="parameter_id" class="form-select" required>
                            <option value="">Pilih Parameter</option>
                            @foreach($parameters as $parameter)
                                <option value="{{ $parameter->id }}">{{ $parameter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi</label>
                        <select name="operator" id="operator" class="form-select" required>
                            <option value="<">Kurang dari (<)</option>
                            <option value=">">Lebih dari (>)</option>
                            <option value="<=">Kurang dari sama dengan (<=)</option>
                            <option value=">=">Lebih dari sama dengan (>=)</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nilai Batas (%)</label>
                        <div class="input-group">
                            <input type="number" step="0.0001" name="input_value" id="input_value" class="form-control" placeholder="0.5" required oninput="updateHiddenValue()">
                            <span class="input-group-text bg-light">%</span>
                        </div>
                        <input type="hidden" name="value" id="hidden_value">
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">Batal</button>
                <button type="submit" class="btn btn-primary" id="submit-btn">Simpan Aturan</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    const form = document.getElementById('rule-form');
    const title = document.getElementById('form-title');
    const methodField = document.getElementById('method-field');
    const submitBtn = document.getElementById('submit-btn');
    const materialSelect = document.getElementById('material_id');
    const formulaDisplay = document.getElementById('formula-display');
    const inputValue = document.getElementById('input_value');
    const hiddenValue = document.getElementById('hidden_value');

    function updateFormulaDisplay() {
        const selected = materialSelect.options[materialSelect.selectedIndex];
        formulaDisplay.value = selected.dataset.formula || '—';
    }

    function updateHiddenValue() {
        hiddenValue.value = inputValue.value / 100;
    }

    function editRule(rule) {
        title.innerText = 'EDIT ATURAN';
        form.action = `/settings/rules/${rule.id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        submitBtn.innerHTML = '<span>Perbarui Aturan</span>';
        
        materialSelect.value = rule.material_id;
        updateFormulaDisplay();
        
        document.getElementById('parameter_id').value = rule.parameter_id;
        document.getElementById('operator').value = rule.operator;
        inputValue.value = rule.value * 100;
        updateHiddenValue();
        
        document.getElementById('form-card').scrollIntoView({ behavior: 'smooth' });
    }

    function resetForm() {
        title.innerText = 'TAMBAH ATURAN BARU';
        form.action = "{{ route('settings.rules.store') }}";
        methodField.innerHTML = '';
        submitBtn.innerHTML = '<span>Simpan Aturan</span>';
        form.reset();
        formulaDisplay.value = '—';
    }
</script>
@endsection
@endsection
