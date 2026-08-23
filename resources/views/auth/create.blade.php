<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Informasi Sekolah</title>
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
    <div class="auth-left">
        <div class="auth-card fade-up">

            <div class="auth-card-logo">
                <div class="auth-card-logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                </div>
                <div>
                    <div class="auth-card-logo-text">SIS</div>
                    <div class="auth-card-logo-sub">Buat Akun Baru</div>
                </div>
            </div>

            <h1 class="auth-title">Daftar Akun</h1>
            <p class="auth-subtitle">Lengkapi data berikut untuk membuat akun akses sistem.</p>

            @if(session('error'))
                <div class="auth-alert error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="regName">Nama Lengkap</label>
                    <input type="text" class="form-input" id="regName" name="name"
                           value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus>
                    <span class="form-error"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="regEmail">Email</label>
                    <input type="email" class="form-input" id="regEmail" name="email"
                           value="{{ old('email') }}" placeholder="email@smkn2.sch.id" required>
                    <span class="form-error"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="regRole">Role / Jabatan</label>
                    <select class="form-select" id="regRole" name="role" required>
                        <option value="admin" {{ old('role', 'admin') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="tu" {{ old('role') === 'tu' ? 'selected' : '' }}>Tata Usaha</option>
                    </select>
                    <span class="form-error"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="regPassword">Password</label>
                    <div class="auth-password-wrapper">
                        <input type="password" class="form-input" id="regPassword" name="password"
                               placeholder="Minimal 8 karakter" required style="padding-right:48px;">
                        <button type="button" class="auth-password-toggle" tabindex="-1" aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <span class="form-error"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="regPasswordConfirm">Konfirmasi Password</label>
                    <div class="auth-password-wrapper">
                        <input type="password" class="form-input" id="regPasswordConfirm" name="password_confirmation"
                               placeholder="Ulangi password" required style="padding-right:48px;">
                        <button type="button" class="auth-password-toggle" tabindex="-1" aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <span class="form-error"></span>
                </div>

                <button type="submit" class="auth-submit" style="margin-top:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Daftar Akun
                </button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    {{-- Kanan: Branding (sama dengan login) --}}
    <div class="auth-right">
        <div class="auth-right-content fade-up" style="animation-delay:0.2s;">
            <div class="auth-right-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            </div>
            <h2>SMK Negeri 2</h2>
            <p>Bergabung dengan tim pengelola sistem informasi sekolah untuk mengelola data secara digital.</p>
            <div class="auth-right-features">
                <div class="auth-feature">
                    <div class="auth-feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                    <span>Akses terproteksi</span>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg></div>
                    <span>Data tersinkronisasi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>