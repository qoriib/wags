@extends('layouts.auth')

@section('title', 'Login - PT WAGS')

@section('content')
<div class="login-card">
    <h2 class="login-title">PT WAGS</h2>
    <p class="login-subtitle">Sistem Pakar Klasifikasi Material</p>

    <form action="{{ route('login') }}" method="POST" class="text-left">
        @csrf
        
        <div class="form-group mb-6">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email', 'admin@wags.com') }}" required autofocus>
            @error('email') 
                <p class="error-message">{{ $message }}</p> 
            @enderror
        </div>

        <div class="form-group mb-10">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" value="password123" required>
            @error('password') 
                <p class="error-message">{{ $message }}</p> 
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-full">
            <span>Masuk</span>
            <i data-lucide="arrow-right"></i>
        </button>
    </form>
</div>
@endsection
