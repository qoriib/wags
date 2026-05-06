@extends('layouts.app')

@section('title', 'Pengaturan Aturan - PT WAGS')
@section('header_title', 'Basis Aturan Forward Chaining')
@section('header_subtitle', 'Kelola parameter dan ambang batas untuk klasifikasi kualitas material')

@section('content')
<div class="card" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 class="section-title" style="font-size: 1.125rem; margin-bottom: 0;">BASIS ATURAN FORWARD CHAINING</h3>
        <button class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);" onclick="resetForm()">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            Tambah Aturan
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
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rules as $rule)
                <tr>
                    <td style="font-weight: 600;">{{ $rule->material->name }}</td>
                    <td><code style="background: var(--bg); padding: 0.2rem 0.5rem; border-radius: 4px;">{{ $rule->material->chemical_formula }}</code></td>
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
                    <td>{{ $rule->value * 100 }}%</td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 1rem; justify-content: flex-end; align-items: center;">
                            <a href="javascript:void(0)" 
                               onclick="editRule({{ json_encode($rule) }})"
                               style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 0.875rem;">Edit</a>
                            
                            <form action="{{ route('settings.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 0.75rem;"><i data-lucide="trash-2" style="width: 14px; height: 14px;"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card" id="form-card">
    <h3 class="section-title" style="font-size: 1.125rem;" id="form-title">TAMBAH / EDIT ATURAN</h3>
    
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
                <input type="text" id="formula-display" class="form-control" value="—" disabled style="background: #f8fafc;">
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
                <input type="number" step="0.0001" name="input_value" id="input_value" class="form-control" placeholder="0,5" required oninput="updateHiddenValue()">
                <input type="hidden" name="value" id="hidden_value">
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="button" class="btn btn-outline" style="flex: 1; padding: 1rem; background: #f8fafc;" onclick="resetForm()">Batal</button>
            <button type="submit" class="btn btn-primary" id="submit-btn" style="flex: 1; padding: 1rem; background: #d0e1f9; color: #1e40af;">Simpan Aturan</button>
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
        submitBtn.innerText = 'Perbarui Aturan';
        
        materialSelect.value = rule.material_id;
        updateFormulaDisplay();
        
        document.getElementById('operator').value = rule.operator;
        inputValue.value = rule.value * 100;
        updateHiddenValue();
        
        document.getElementById('form-card').scrollIntoView({ behavior: 'smooth' });
    }

    function resetForm() {
        title.innerText = 'TAMBAH ATURAN';
        form.action = "{{ route('settings.rules.store') }}";
        methodField.innerHTML = '';
        submitBtn.innerText = 'Simpan Aturan';
        form.reset();
        formulaDisplay.value = '—';
    }
</script>
@endsection
@endsection
