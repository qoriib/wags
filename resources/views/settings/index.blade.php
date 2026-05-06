@extends('layouts.app')

@section('title', 'Pengaturan Aturan - PT WAGS')
@section('header_title', 'Basis Aturan Forward Chaining')
@section('header_subtitle', 'Kelola parameter dan ambang batas untuk klasifikasi kualitas material')

@section('content')
<div class="card mb-8">
    <div class="flex-between mb-8">
        <h3 class="section-title text-xl mb-0">BASIS ATURAN FORWARD CHAINING</h3>
        <button class="btn btn-outline primary-text" onclick="resetForm()">
            <i data-lucide="plus"></i>
            <span>Tambah Aturan</span>
        </button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Parameter (Rumus)</th>
                    <th>Kondisi</th>
                    <th>Nilai Batas</th>
                    <th class="align-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rules as $rule)
                <tr>
                    <td class="font-bold">{{ $rule->material->name }}</td>
                    <td><code class="code-badge">{{ $rule->material->chemical_formula }}</code></td>
                    <td>
                        @php
                            $opLabel = match($rule->operator) {
                                '<' => 'Kurang dari',
                                '>' => 'Lebih dari',
                                '<=' => 'Kurang dari sama dengan',
                                '>=' => 'Lebih dari sama dengan',
                            };
                        @endphp
                        {{ $opLabel }} ({{ $rule->operator }})
                    </td>
                    <td class="font-semibold">{{ $rule->value * 100 }}%</td>
                    <td class="align-right">
                        <div class="d-flex flex-gap-3 justify-end items-center">
                            <button onclick="editRule({{ json_encode($rule) }})" class="btn btn-outline btn-sm">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                <span>Edit</span>
                            </button>
                            
                            <form action="{{ route('settings.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm danger-outline">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card scroll-mt-8" id="form-card">
    <h3 class="section-title text-xl" id="form-title">TAMBAH ATURAN BARU</h3>
    
    <form id="rule-form" action="{{ route('settings.rules.store') }}" method="POST">
        @csrf
        <div id="method-field"></div>
        
        <div class="grid grid-2">
            <div class="form-group">
                <label class="form-label">Material</label>
                <select name="material_id" id="material_id" class="form-control" required onchange="updateFormulaDisplay()">
                    <option value="">Pilih Material</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}" data-formula="{{ $material->chemical_formula }}">{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Parameter Terdeteksi</label>
                <input type="text" id="formula-display" class="form-control bg-muted" value="—" disabled>
            </div>

            <div class="form-group">
                <label class="form-label">Kondisi</label>
                <select name="operator" id="operator" class="form-control" required>
                    <option value="<">Kurang dari (<)</option>
                    <option value=">">Lebih dari (>)</option>
                    <option value="<=">Kurang dari sama dengan (<=)</option>
                    <option value=">=">Lebih dari sama dengan (>=)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nilai Batas (%)</label>
                <input type="number" step="0.0001" name="input_value" id="input_value" class="form-control" placeholder="0.5" required oninput="updateHiddenValue()">
                <input type="hidden" name="value" id="hidden_value">
            </div>
        </div>

        <div class="d-flex flex-gap-4 mt-10">
            <button type="button" class="btn btn-outline flex-1 p-4" onclick="resetForm()">Batal</button>
            <button type="submit" class="btn btn-primary flex-2 p-4" id="submit-btn">Simpan Aturan</button>
        </div>
    </form>
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
