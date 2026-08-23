<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Sekolah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-wrapper">
    {{-- Kiri: Form Login --}}
    <div class="auth-left">
        <div class="auth-card fade-up">

            <div class="auth-card-logo">
                <div class="auth-card-logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/></svg>
                </div>
                <div>
                    <div class="auth-card-logo-text">SIS</div>
                    <div class="auth-card-logo-sub">Sistem Informasi Sekolah</div>
                </div>
            </div>

            <h1 class="auth-title">Masuk ke Akun</h1>
            <p class="auth-subtitle">Gunakan akun admin yang telah terdaftar untuk mengakses dashboard.</p>

            @if(session('error'))
                <div class="auth-alert error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="loginEmail">Email</label>
                    <input type="email" class="form-input" id="loginEmail" name="email"
                           value="{{ old('email') }}" placeholder="admin@smkn2.sch.id" required autofocus>
                    <span class="form-error"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="loginPassword">Password</label>
                    <div class="auth-password-wrapper">
                        <input type="password" class="form-input" id="loginPassword" name="password"
                               placeholder="Masukkan password" required style="padding-right:48px;">
                        <button type="button" class="auth-password-toggle" tabindex="-1" aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <span class="form-error"></span>
                </div>

                <div class="auth-extras">
                    <label class="auth-remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-forgot">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="auth-submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk
                </button>
            </form>

            <div class="auth-footer">
                @if(Route::has('register'))
                    Belum punya akun? <a href="{{ route('register') }}">Hubungi administrator</a>
                @else
                    Hubungi administrator untuk membuat akun.
                @endif
            </div>
        </div>
    </div>

    {{-- Kanan: Branding --}}
    <div class="auth-right">
        <div class="auth-right-content fade-up" style="animation-delay:0.2s;">
            <div class="auth-right-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/></svg>
            </div>
            <h2>SMK Negeri 2</h2>
            <p>Sistem Informasi Sekolah terpadu untuk mengelola data guru, siswa, jadwal, nilai, dan absensi.</p>

            <div class="auth-right-features">
                <div class="auth-feature">
                    <div class="auth-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <span>Kelola data guru &amp; siswa</span>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <span>Jadwal pelajaran otomatis</span>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <span>Rekap nilai &amp; absensi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>