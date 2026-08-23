@extends('layouts.app')

@section('title', 'Detail Mapel - SIS')
@section('breadcrumb', 'Mata Pelajaran / Detail')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .show-grid { display:grid; grid-template-columns:1.5fr 1fr; gap:24px; }
        .show-card { background:var(--card); border:1px solid var(--border); border-radius:14px; overflow:hidden; }
        .show-card-header { padding:20px 24px; border-bottom:1px solid var(--border); font-family:'Space Grotesk',sans-serif; font-size:15px; font-weight:700; display:flex; align-items:center; gap:10px; }
        .show-card-body { padding:24px; }
        .show-row { display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f0f4f0; }
        .show-row:last-child { border-bottom:none; }
        .show-label { font-size:13px; color:var(--muted); }
        .show-value { font-size:14px; font-weight:600; text-align:right; max-width:60%; }
        .show-big-icon { width:80px; height:80px; border-radius:20px; display:flex; align-items:center; justify-content:center; font-family:'Space Grotesk',sans-serif; font-size:32px; font-weight:800; margin:0 auto 20px; }
        .show-action-list a { display:flex; align-items:center; gap:12px; padding:14px 16px; border-radius:10px; font-size:14px; font-weight:600; color:var(--fg); text-decoration:none; transition:all 0.2s; border:1px solid var(--border); margin-bottom:10px; }
        .show-action-list a:hover { border-color:var(--accent); color:var(--accent); transform:translateX(4px); }
        .show-action-list a svg { width:18px; height:18px; flex-shrink:0; opacity:0.6; }
        @media(max-width:768px){ .show-grid{grid-template-columns:1fr;} }
    </style>
@endsection

@section('content')

<div class="fade-up">
    <div class="form-page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.mapel.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Detail Mata Pelajaran</h1>
            <p class="form-page-subtitle">Informasi lengkap {{ $mapel->nama }}</p>
        </div>
    </div>

    <div class="show-grid">
        <div>
            <div class="show-card" style="margin-bottom:24px;">
                <div class="show-card-body" style="text-align:center;padding:36px 24px;">
                    <div class="show-big-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6;">{{ strtoupper(substr($mapel->nama,0,2)) }}</div>
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:700;">{{ $mapel->nama }}</h2>
                    <p style="font-size:13px;color:var(--muted);margin-top:4px;">Kode: {{ $mapel->kode ?? '-' }} &middot; {{ ucfirst($mapel->kelompok ?? 'umum') }}</p>
                </div>
            </div>
            <div class="show-card">
                <div class="show-card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Informasi Lengkap
                </div>
                <div class="show-card-body">
                    <div class="show-row"><span class="show-label">Nama</span><span class="show-value">{{ $mapel->nama }}</span></div>
                    <div class="show-row"><span class="show-label">Kode</span><span class="show-value">{{ $mapel->kode ?? '-' }}</span></div>
                    <div class="show-row"><span class="show-label">Kelompok</span><span class="show-value">{{ ucfirst($mapel->kelompok ?? 'umum') }}</span></div>
                    <div class="show-row"><span class="show-label">KKM</span><span class="show-value">{{ $mapel->kkm ?? 75 }}</span></div>
                    <div class="show-row"><span class="show-label">Jam/Minggu</span><span class="show-value">{{ $mapel->jam_minggu ?? 0 }} jam</span></div>
                    <div class="show-row"><span class="show-label">Guru Pengampu</span><span class="show-value">{{ $mapel->guru->nama ?? 'Belum ditugaskan' }}</span></div>
                    <div class="show-row"><span class="show-label">Dibuat</span><span class="show-value">{{ $mapel->created_at->format('d M Y, H:i') }}</span></div>
                    @if($mapel->deskripsi)
                        <div style="margin-top:16px;padding:16px;background:var(--bg);border-radius:10px;font-size:13px;color:var(--muted);line-height:1.6;">{{ $mapel->deskripsi }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="show-card" style="margin-bottom:24px;">
                <div class="show-card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Aksi Cepat
                </div>
                <div class="show-card-body show-action-list">
                    <a href="{{ route('admin.mapel.edit', $mapel->id) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Mata Pelajaran
                    </a>
                    <a href="{{ route('admin.jadwal.index', ['mapel' => $mapel->id]) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Lihat Jadwal
                    </a>
                    <a href="{{ route('admin.nilai.index', ['mapel' => $mapel->id]) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3 3 6 3s6-1 6-3v-5"/></svg>
                        Lihat Nilai
                    </a>
                </div>
            </div>
            <div class="show-card">
                <div class="show-card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Guru Terkait
                </div>
                <div class="show-card-body">
                    @if($mapel->guru)
                        <div style="display:flex;align-items:center;gap:14px;">
                            <div style="width:44px;height:44px;border-radius:12px;background:rgba(13,148,136,0.1);display:flex;align-items:center;justify-content:center;color:var(--accent);font-weight:700;font-size:15px;">{{ strtoupper(substr($mapel->guru->nama,0,1)) }}</div>
                            <div>
                                <div style="font-weight:600;font-size:14px;">{{ $mapel->guru->nama }}</div>
                                <div style="font-size:12px;color:var(--muted);">{{ $mapel->guru->email }}</div>
                            </div>
                        </div>
                    @else
                        <p style="font-size:13px;color:var(--muted);text-align:center;padding:12px 0;">Belum ada guru ditugaskan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection