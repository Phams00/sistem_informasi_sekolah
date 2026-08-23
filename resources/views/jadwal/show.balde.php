@extends('layouts.app')

@section('title', 'Detail Jadwal - SIS')
@section('breadcrumb', 'Jadwal Pelajaran / Detail')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <style>
        .jadwal-show-hero { background:linear-gradient(135deg,#0f1923,#0d3b3e);border-radius:16px;padding:36px;color:white;display:flex;align-items:center;gap:28px;margin-bottom:24px; }
        .jadwal-show-hero-icon { width:72px;height:72px;border-radius:18px;background:rgba(94,234,212,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
        .jadwal-show-hero-icon svg { width:32px;height:32px;color:#5eead4; }
        .jadwal-show-hero h2 { font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:700;margin-bottom:4px; }
        .jadwal-show-hero p { font-size:14px;color:#8899aa; }
        .jadwal-show-badges { display:flex;gap:10px;margin-top:14px;flex-wrap:wrap; }
        .jadwal-show-badge { padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;background:rgba(255,255,255,0.08);color:#5eead4; }
        .detail-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:24px; }
        .detail-item { background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px;text-align:center; }
        .detail-item-value { font-family:'Space Grotesk',sans-serif;font-size:20px;font-weight:700; }
        .detail-item-label { font-size:12px;color:var(--muted);margin-top:4px; }
        @media(max-width:768px){ .jadwal-show-hero{flex-direction:column;text-align:center;} .detail-grid{grid-template-columns:1fr;} }
    </style>
@endsection

@section('content')

<div class="fade-up">
    <div class="form-page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.jadwal.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Detail Jadwal</h1>
            <p class="form-page-subtitle">Informasi lengkap jadwal ini</p>
        </div>
    </div>

    <div class="jadwal-show-hero">
        <div class="jadwal-show-hero-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <h2>{{ $jadwal->mapel->nama }}</h2>
            <p>{{ $jadwal->guru->nama }} &middot; {{ $jadwal->kelas }}</p>
            <div class="jadwal-show-badges">
                <span class="jadwal-show-badge">{{ $jadwal->hari }}</span>
                <span class="jadwal-show-badge">Jam ke-{{ $jadwal->jam_ke }}</span>
                <span class="jadwal-show-badge">Semester {{ $jadwal->semester === 1 ? 'Ganjil' : 'Genap' }}</span>
            </div>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-item-value" style="color:var(--accent);">{{ $jadwal->hari }}</div>
            <div class="detail-item-label">Hari</div>
        </div>
        <div class="detail-item">
            <div class="detail-item-value" style="color:#f59e0b;">{{ $jadwal->jam_ke }}</div>
            <div class="detail-item-label">Jam Ke-</div>
        </div>
        <div class="detail-item">
            <div class="detail-item-value" style="color:#06b6d4;">{{ $jadwal->kelas }}</div>
            <div class="detail-item-label">Kelas</div>
        </div>
    </div>

    <div class="form-card">
        <div class="show-card-header" style="padding:20px 24px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;">Rincian</div>
        <div class="show-card-body" style="padding:24px;">
            <div class="show-row"><span class="show-label">Mata Pelajaran</span><span class="show-value">{{ $jadwal->mapel->nama }}</span></div>
            <div class="show-row"><span class="show-label">Guru Pengampu</span><span class="show-value">{{ $jadwal->guru->nama }}</span></div>
            <div class="show-row"><span class="show-label">Kelas</span><span class="show-value">{{ $jadwal->kelas }}</span></div>
            <div class="show-row"><span class="show-label">Hari</span><span class="show-value">{{ $jadwal->hari }}</span></div>
            <div class="show-row"><span class="show-label">Jam Ke-</span><span class="show-value">{{ $jadwal->jam_ke }}</span></div>
            <div class="show-row"><span class="show-label">Semester</span><span class="show-value">{{ $jadwal->semester === 1 ? 'Ganjil' : 'Genap' }}</span></div>
            <div class="show-row"><span class="show-label">Dibuat</span><span class="show-value">{{ $jadwal->created_at->format('d M Y, H:i') }}</span></div>
        </div>
    </div>

    <div style="display:flex;gap:12px;margin-top:20px;">
        <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Jadwal
        </a>
        <a href="{{ route('admin.jadwal.index') }}" class="btn-cancel-form">Kembali</a>
    </div>
</div>

@endsection