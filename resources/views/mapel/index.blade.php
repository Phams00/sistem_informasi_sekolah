@extends('layouts.app')

@section('title', 'Mata Pelajaran - SIS')
@section('breadcrumb', 'Mata Pelajaran')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mapel.css') }}">
@endsection

@section('content')

    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Mata Pelajaran</h1>
            <p class="guru-page-subtitle">Kelola mata pelajaran yang tersedia &mdash; {{ $totalMapel }} mata pelajaran</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.mapel.create') }}" class="btn-primary-guru">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Mapel
            </a>
        </div>
    </div>

    <div class="mapel-grid fade-up-delay">
        @forelse($mapels as $i => $m)
            @php
                $cardColors = [
                    ['bg'=>'rgba(13,148,136,0.1)',  'text'=>'#0d9488', 'bar'=>'#0d9488'],
                    ['bg'=>'rgba(245,158,11,0.1)',  'text'=>'#f59e0b', 'bar'=>'#f59e0b'],
                    ['bg'=>'rgba(6,182,212,0.1)',   'text'=>'#06b6d4', 'bar'=>'#06b6d4'],
                    ['bg'=>'rgba(139,92,246,0.1)',  'text'=>'#8b5cf6', 'bar'=>'#8b5cf6'],
                    ['bg'=>'rgba(244,63,94,0.1)',   'text'=>'#f43f5e', 'bar'=>'#f43f5e'],
                    ['bg'=>'rgba(16,185,129,0.1)',  'text'=>'#10b981', 'bar'=>'#10b981'],
                    ['bg'=>'rgba(59,130,246,0.1)',  'text'=>'#3b82f6', 'bar'=>'#3b82f6'],
                    ['bg'=>'rgba(236,72,153,0.1)',  'text'=>'#ec4899', 'bar'=>'#ec4899'],
                    ['bg'=>'rgba(251,146,60,0.1)',  'text'=>'#fb923c', 'bar'=>'#fb923c'],
                    ['bg'=>'rgba(34,197,94,0.1)',   'text'=>'#22c55e', 'bar'=>'#22c55e'],
                    ['bg'=>'rgba(168,85,247,0.1)',  'text'=>'#a855f7', 'bar'=>'#a855f7'],
                    ['bg'=>'rgba(232,121,249,0.1)', 'text'=>'#e879f9', 'bar'=>'#e879f9'],
                ];
                $c = $cardColors[$i % count($cardColors)];
                $initials = strtoupper(substr($m->nama, 0, 2));
            @endphp
            <div class="mapel-card" style="animation:fadeUp 0.5s ease {{ $i * 0.06 }}s both;">
                <div style="position:absolute;top:0;left:0;right:0;height:4px;background:{{ $c['bar'] }};border-radius:14px 14px 0 0;"></div>
                <div class="mapel-card-top">
                    <div class="mapel-card-icon" style="background:{{ $c['bg'] }};color:{{ $c['text'] }};">{{ $initials }}</div>
                    <div class="mapel-card-menu">
                        <button class="mapel-card-menu-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                        <div class="mapel-card-dropdown">
                            <a href="{{ route('admin.mapel.show', $m->id) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat Detail
                            </a>
                            <a href="{{ route('admin.mapel.edit', $m->id) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <button class="is-danger" onclick="openDeleteModal({{ $m->id }}, '{{ $m->nama }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mapel-card-name">{{ $m->nama }}</div>
                <div class="mapel-card-kode">Kode: {{ $m->kode ?? '-' }}</div>
                <div class="mapel-card-meta">
                    <div class="mapel-card-meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>Guru: <strong>{{ $m->guru->nama ?? 'Belum ditugaskan' }}</strong></span>
                    </div>
                    <div class="mapel-card-meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        <span>Diajarkan di <strong>{{ $m->kelas_count ?? 0 }} kelas</strong></span>
                    </div>
                </div>
                <div class="mapel-card-footer">
                    <div class="mapel-card-kkm">KKM: {{ $m->kkm ?? 75 }}</div>
                    <div class="mapel-card-jam"><span>{{ $m->jam_minggu ?? 0 }}</span> jam/minggu</div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 24px;color:var(--muted);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:0.3;margin-bottom:12px;"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <p style="font-size:15px;font-weight:500;margin-bottom:16px;">Belum ada mata pelajaran</p>
                <a href="{{ route('admin.mapel.create') }}" class="btn-primary-guru" style="display:inline-flex;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Mapel Pertama
                </a>
            </div>
        @endforelse
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

    <div class="modal-overlay" id="deleteOverlay"></div>
    <div class="modal-box" id="deleteModal">
        <div style="text-align:center;">
            <div class="modal-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></div>
            <h3 class="modal-title">Hapus Mata Pelajaran?</h3>
            <p class="modal-text">Yakin ingin menghapus <strong id="deleteNama"></strong>? Data jadwal terkait mungkin terpengaruh.</p>
            <div class="modal-actions">
                <button class="btn-cancel-form" id="deleteCancelBtn" style="flex:1;">Batal</button>
                <button class="btn-danger" id="deleteConfirmBtn" style="flex:1;">Hapus</button>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/mapel.js') }}"></script>
@endsection