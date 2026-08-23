@extends('layouts.app')

@section('title', 'Edit Akun - SIS')
@section('breadcrumb', 'Pengaturan / Akun / Edit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.users.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Edit Akun Pengguna</h1>
            <p class="form-page-subtitle">Perbarui data <strong style="color:var(--fg);">{{ $user->name }}</strong></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf @method('PUT')

        <div class="form-card" style="margin-bottom:24px;">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <span class="form-card-header-text">Informasi Akun</span>
            </div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" class="form-input" name="name" value="{{ old('name', $user->name) }}" data-validate="required">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" class="form-input" name="email" value="{{ old('email', $user->email) }}" data-validate="required|email">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="guru" {{ old('role', $user->role) === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="tu" {{ old('role', $user->role) === 'tu' ? 'selected' : '' }}>Tata Usaha</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-radio-group">
                            <label class="form-radio-label">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                Aktif
                            </label>
                            <label class="form-radio-label">
                                <input type="radio" name="is_active" value="0" {{ !old('is_active', $user->is_active) ? 'checked' : '' }}>
                                Nonaktif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.users.index') }}" class="btn-cancel-form">Batal</a>
                <button type="submit" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Perbarui Akun
                </button>
            </div>
        </div>
    </form>

    {{-- Reset password terpisah --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-header-icon" style="background:rgba(220,38,38,0.1);color:var(--danger);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <span class="form-card-header-text">Reset Password</span>
        </div>
        <div class="form-card-body">
            <p style="font-size:13px;color:var(--muted);margin-bottom:16px;">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter.</p>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <div class="auth-password-wrapper">
                        <input type="password" class="form-input" name="password" placeholder="Biarkan kosong jika tidak diubah" style="padding-right:48px;" minlength="8">
                        <button type="button" class="auth-password-toggle" tabindex="-1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="auth-password-wrapper">
                        <input type="password" class="form-input" name="password_confirmation" placeholder="Ulangi password baru" style="padding-right:48px;">
                        <button type="button" class="auth-password-toggle" tabindex="-1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-card-footer">
            <span></span>
            <button type="submit" formaction="{{ route('admin.users.update-password', $user->id) }}" formmethod="POST" class="btn-submit-form" style="background:var(--danger);box-shadow:0 4px 16px rgba(220,38,38,0.2);flex:none;padding:12px 24px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Reset Password
            </button>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
@endsection