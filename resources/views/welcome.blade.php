<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .welcome-full { min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:40px 24px; position:relative; overflow:hidden; }
        .welcome-full::before { content:''; position:absolute; top:-200px; right:-200px; width:500px; height:500px; background:radial-gradient(circle,rgba(13,148,136,0.06) 0%,transparent 70%); border-radius:50%; }
        .welcome-full::after { content:''; position:absolute; bottom:-150px; left:-150px; width:400px; height:400px; background:radial-gradient(circle,rgba(6,182,212,0.04) 0%,transparent 70%); border-radius:50%; }
        .welcome-logo { width:80px; height:80px; border-radius:20px; background:linear-gradient(135deg,var(--accent),#06b6d4); display:flex; align-items:center; justify-content:center; margin:0 auto 28px; box-shadow:0 12px 40px rgba(13,148,136,0.3); }
        .welcome-logo svg { width:40px; height:40px; color:white; }
        .welcome-full h1 { font-family:'Space Grotesk',sans-serif; font-size:36px; font-weight:700; margin-bottom:8px; position:relative; }
        .welcome-full p { font-size:16px; color:var(--muted); max-width:440px; line-height:1.6; margin-bottom:32px; position:relative; }
        .welcome-features { display:flex; gap:20px; flex-wrap:wrap; justify-content:center; margin-bottom:40px; position:relative; }
        .welcome-feature-card { background:white; border:1px solid var(--border); border-radius:14px; padding:20px 24px; width:180px; transition:all 0.3s; }
        .welcome-feature-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,0.06); border-color:var(--accent); }
        .welcome-feature-card svg { width:28px; height:28px; margin-bottom:10px; }
        .welcome-feature-card h3 { font-family:'Space Grotesk',sans-serif; font-size:14px; font-weight:700; margin-bottom:4px; }
        .welcome-feature-card p { font-size:12px; color:var(--muted); margin:0; line-height:1.4; }
        .welcome-btn { display:inline-flex; align-items:center; gap:10px; padding:14px 32px; background:linear-gradient(135deg,var(--accent),var(--accent-light)); color:white; border:none; border-radius:12px; font-size:16px; font-weight:600; cursor:pointer; transition:all 0.25s; box-shadow:0 6px 24px rgba(13,148,136,0.3); text-decoration:none; font-family:'Plus Jakarta Sans',sans-serif; position:relative; }
        .welcome-btn:hover { transform:translateY(-3px); box-shadow:0 10px 36px rgba(13,148,136,0.4); }
        .welcome-btn svg { width:20px; height:20px; }
        .welcome-footer { position:relative; margin-top:48px; font-size:12px; color:var(--muted); }
        @media(max-width:640px){
            .welcome-full h1 { font-size:28px; }
            .welcome-features { flex-direction:column; align-items:center; }
            .welcome-feature-card { width:100%; max-width:300px; }
        }
    </style>
</head>
<body>
    <div class="welcome-full">
        <div class="welcome-logo fade-up">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/></svg>
        </div>
        <h1 class="fade-up" style="animation-delay:0.1s;">Sistem Informasi Sekolah</h1>
        <p class="fade-up" style="animation-delay:0.15s;">Platform digital terpadu untuk mengelola data akademik SMK Negeri 2 secara efisien dan terorganisir.</p>

        <div class="welcome-features">
            <div class="welcome-feature-card fade-up" style="animation-delay:0.2s;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <h3>Data Guru & Siswa</h3>
                <p>Kelola profil lengkap</p>
            </div>
            <div class="welcome-feature-card fade-up" style="animation-delay:0.25s;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <h3>Jadwal Pelajaran</h3>
                <p>Tabel mingguan otomatis</p>
            </div>
            <div class="welcome-feature-card fade-up" style="animation-delay:0.3s;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <h3>Nilai & Absensi</h3>
                <p>Rekap instan dan akurat</p>
            </div>
        </div>

        {{-- ===== TOMBOL: beda tujuan tergantung status login ===== --}}
        @auth
            <a href="{{ route('admin.dashboard') }}" class="welcome-btn fade-up" style="animation-delay:0.35s;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Ke Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="welcome-btn fade-up" style="animation-delay:0.35s;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Masuk ke Sistem
            </a>
        @endauth
        {{-- ===== akhir bagian tombol ===== --}}

        <div class="welcome-footer fade-up" style="animation-delay:0.4s;">
            &copy; {{ date('Y') }} SMK Negeri 2 &mdash; Sistem Informasi Sekolah v2.1
        </div>
    </div>

    <script src="{{ asset('js/global.js') }}"></script>
</body>
</html>