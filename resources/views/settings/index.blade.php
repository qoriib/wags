@extends('layouts.app')

@section('title', 'Pengaturan Aturan - PT WAGS')
@section('header_title', 'Basis Aturan Pakar')
@section('header_subtitle', 'Kelola parameter dan ambang batas untuk klasifikasi kualitas material')

@section('content')
<div class="card" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 class="section-title" style="font-size: 1.125rem; margin-bottom: 0;">Basis Aturan Forward Chaining</h3>
        <button class="btn btn-primary" onclick="toggleForm()">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            Tambah Aturan
        </button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Parameter</th>
                    <th>Kondisi</th>
                    <th>Nilai Batas (%)</th>
                    <th>Hasil</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rules as $rule)
                <tr>
                    <td style="font-weight: 600;">{{ $rule->material->name }}</td>
                    <td>{{ $rule->parameter }}</td>
                    <td>{{ $rule->operator }}</td>
                    <td>{{ number_format($rule->value, 2) }}%</td>
                    <td>
                        <span class="badge badge-success">{{ strtoupper($rule->result_status) }}</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn btn-outline" style="padding: 0.25rem 0.5rem;"><i data-lucide="edit" style="width: 14px; height: 14px;"></i></button>
                            <form action="{{ route('settings.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 0.25rem 0.5rem; color: var(--danger);"><i data-lucide="trash-2" style="width: 14px; height: 14px;"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="ruleForm" class="card animate-fade-in" style="display: none;">
    <h3 class="section-title" style="font-size: 1.125rem;">Tambah / Edit Aturan</h3>
    <form action="{{ route('settings.rules.store') }}" method="POST">
        @csrf
        <div class="grid grid-2">
            <div class="form-group">
                <label class="form-label">Material</label>
                <select name="material_id" class="form-control" required>
                    <option value="">Pilih Material</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Parameter</label>
                <select name="parameter" class="form-control" required>
                    <option value="Fe2O3">Fe₂O₃</option>
                    <option value="CaO">CaO</option>
                    <option value="SiO2">SiO₂</option>
                    <option value="Al2O3">Al₂O₃</option>
                    <option value="CaCO3">CaCO₃</option>
                    <option value="LoI">LoI</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Kondisi</label>
                <select name="operator" class="form-control" required>
                    <option value="Kurang dari">Kurang dari</option>
                    <option value="Lebih dari">Lebih dari</option>
                    <option value="Kurang dari sama dengan">Kurang dari sama dengan</option>
                    <option value="Lebih dari sama dengan">Lebih dari sama dengan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nilai Batas (%)</label>
                <input type="number" step="0.01" name="value" class="form-control" placeholder="0,00" required>
            </div>
            <div class="form-group">
                <label class="form-label">Hasil Klasifikasi</label>
                <select name="result_status" class="form-control" required>
                    <option value="Layak Kirim">Layak Kirim</option>
                </select>
            </div>
        </div>
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
            <button type="button" class="btn btn-outline" onclick="toggleForm()">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Aturan</button>
        </div>
    </form>
</div>

<script>
    function toggleForm() {
        const form = document.getElementById('ruleForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        if(form.style.display === 'block') {
            form.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>
@endsection
