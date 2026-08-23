@extends('layouts.app')

@section('title', 'Profil Akun - SIS')
@section('breadcrumb', 'Pengaturan / Akun / Profil')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .profile-hero {
            background: linear-gradient(135deg, #0f1923, #0d3b3e);
            border-radius: 16px;
            padding: 36px;
            color: white;
            display: flex;
            align-items: center;
            gap: 28px;
            margin-bottom: 24px;
        }
        .profile-avatar-lg {
            width: 88px;
            height: 88px;
            border-radius: 22px;
            background: linear-gradient(135deg, var(--accent), #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 32px;
            font-family: 'Space Grotesk', sans-serif;
            flex-shrink: 0;
        }
        .profile-hero h2 { font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:700;margin-bottom:4px; }
        .profile-hero p { font-size:14px;color:#8899aa; }
        .profile-badges { display:flex;gap:10px;margin-top:14px;flex-wrap:wrap; }
        .profile-badge { padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;background:rgba(255,255,255,0.08);color:#5eead4; }
        .profile-actions { display:flex;gap:12px;margin-left:auto;flex-shrink:0; }
        .profile-actions a { display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:10px;border:1px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.06);color:white;font-size:13px;font-weight:600;text-decoration:none;transition:all 0.2s;backdrop-filter:blur(8px);font-family:'Plus Jakarta Sans',sans-serif; }
        .profile-actions a:hover { background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.3);transform:translateY(-2px); }
        .profile-actions a svg { width:16px;height:16px; }
        .profile-detail-grid { display:grid;grid-template-columns:1fr 1fr;gap:20px; }
        @media(max-width:768px){
            .profile-hero{flex-direction:column;text-align:center;}
            .profile-actions{margin-left:0;justify-content:center;}
            .profile-detail-grid{grid-template-columns:1fr;}
        }
    </style>
@endsection

@section('content')

<div class="fade-up">
    <div class="form-page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.users.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Profil Akun</h1>
            <p class="form-page-subtitle">Detail informasi akun pengguna</p>
        </div>
    </div>

    <div class="profile-hero">
        <div class="profile-avatar-lg">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div>
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>
            <div class="profile-badges">
                <span class="profile-badge">{{ ucfirst($user->role ?? 'admin') }}</span>
                <span class="profile-badge">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                @if($user->email_verified_at)
                    <span class="profile-badge">Terverifikasi</span>
                @endif
            </div>
        </div>
        <div class="profile-actions">
            <a href="{{ route('admin.users.edit', $user->id) }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.users.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="profile-detail-grid">
        <div class="form-card">
            <div class="show-card-header" style="padding:18px 24px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;">Data Akun</div>
            <div class="show-card-body" style="padding:24px;">
                <div class="show-row"><span class="show-label">ID</span><span class="show-value">#{{ $user->id }}</span></div>
                <div class="show-row"><span class="show-label">Nama</span><span class="show-value">{{ $user->name }}</span></div>
                <div class="show-row"><span class="show-label">Email</span><span class="show-value">{{ $user->email }}</span></div>
                <div class="show-row"><span class="show-label">Role</span><span class="show-value">{{ ucfirst($user->role ?? 'admin') }}</span></div>
                <div class="show-row"><span class="show-label">Status</span><span class="show-value">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></div>
            </div>
        </div>
        <div class="form-card">
            <div class="show-card-header" style="padding:18px 24px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;">Aktivitas</div>
            <div class="show-card-body" style="padding:24px;">
                <div class="show-row"><span class="show-label">Dibuat</span><span class="show-value">{{ $user->created_at->format('d M Y, H:i') }}</span></div>
                <div class="show-row"><span class="show-label">Diperbarui</span><span class="show-value">{{ $user->updated_at->format('d M Y, H:i') }}</span></div>
                <div class="show-row"><span class="show-label">Login Terakhir</span><span class="show-value">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}</span></div>
                <div class="show-row"><span class="show-label">Email Diverifikasi</span><span class="show-value">{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Belum' }}</span></div>
            </div>
        </div>
    </div>
</div>

@endsection