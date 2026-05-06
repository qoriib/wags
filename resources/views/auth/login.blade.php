@extends('layouts.auth')

@section('title', 'Login - PT WAGS')

@section('content')
<div class="login-card">
    <!-- Icon Container -->
    <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
        <div style="width: 60px; height: 60px; background: #e0ebff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="box" style="width: 32px; height: 32px; color: #a1b8e1;"></i>
        </div>
    </div>

    <h2 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 0.25rem;">PT WAGS</h2>
    <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 2.5rem;">Sistem Pakar Klasifikasi Material</p>

    <form action="{{ route('login') }}" method="POST" style="text-align: left;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: #1e293b;">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="admin@wags.com" required style="padding: 1rem; border-radius: 12px;" value="{{ old('email') }}">
            @error('email') <p style="color: var(--danger); font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group" style="margin-bottom: 2.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: #1e293b;">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" value="password123" required style="padding: 1rem; border-radius: 12px;">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.25rem; border-radius: 12px; background: #d0e1f9; color: #1e40af; font-weight: 700; border: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
            Masuk
            <i data-lucide="arrow-right" style="width: 20px; height: 20px;"></i>
        </button>
    </form>

    <p style="margin-top: 2.5rem; color: #94a3b8; font-size: 0.75rem;">
        Sistem hanya dapat diakses oleh admin PT WAGS
    </p>
</div>
@endsection
