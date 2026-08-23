@extends('layouts.app')

@section('title', 'Detail Nilai - SIS')
@section('breadcrumb', 'Nilai Siswa / Detail')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .nilai-show-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:24px; }
        .nilai-show-card { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:28px; text-align:center; }
        .nilai-show-card .big-num { font-family:'Space Grotesk',sans-serif; font-size:42px; font-weight:700; line-height:1; }
        .nilai-show-card .label { font-size:13px; color:var(--muted); margin-top:8px; }
        .nilai-predikat-badge { display:inline-flex; padding:8px 24px; border-radius:10px; font-family:'Space Grotesk',sans-serif; font-size:20px; font-weight:800; }
        @media(max-width:768px){ .nilai-show-grid{grid-template-columns:1fr;} }
    </style>
@endsection

@section('content')

<div class="fade-up">
    <div class="form-page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.nilai.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Detail Nilai</h1>
            <p class="form-page-subtitle">{{ $nilai->siswa->nama }} &middot; {{ $nilai->mapel->nama }}</p>
        </div>
    </div>

    @php
        $grade = $nilai->nilai_akhir >= 88 ? 'A' : ($nilai->nilai_akhir >= 75 ? 'B' : ($nilai->nilai_akhir >= 60 ? 'C' : ($nilai->nilai_akhir >= 50 ? 'D' : 'E')));
        $gradeColors = ['A'=>'var(--success)','B'=>'var(--accent)','C'=>'#f59e0b','D'=>'#f43f5e','E'=>'var(--danger)'];
        $gradeBgs = ['A'=>'rgba(22,163,74,0.1)','B'=>'rgba(13,148,136,0.1)','C'=>'rgba(245,158,11,0.1)','D'=>'rgba(244,63,94,0.1)','E'=>'rgba(220,38,38,0.1)'];
    @endphp

    <div class="nilai-show-grid">
        <div class="nilai-show-card">
            <div class="big-num" style="color:#f59e0b;">{{ $nilai->tugas }}</div>
            <div class="label">Nilai Tugas (30%)</div>
        </div>
        <div class="nilai-show-card">
            <div class="big-num" style="color:#06b6d4;">{{ $nilai->uts }}</div>
            <div class="label">Nilai UTS (30%)</div>
        </div>
        <div class="nilai-show-card">
            <div class="big-num" style="color:#8b5cf6;">{{ $nilai->uas }}</div>
            <div class="label">Nilai UAS (40%)</div>
        </div>
    </div>

    <div style="text-align:center;margin-bottom:32px;">
        <div style="font-size:13px;color:var(--muted);margin-bottom:8px;font-weight:600;">Nilai Akhir</div>
        <div style="font-family:'Space Grotesk',sans-serif;font-size:64px;font-weight:800;color:{{ $gradeColors[$grade] }};line-height:1;">{{ $nilai->nilai_akhir }}</div>
        <div class="nilai-predikat-badge" style="background:{{ $gradeBgs[$grade] }};color:{{ $gradeColors[$grade] }};margin-top:12px;">Predikat {{ $grade }}</div>
    </div>

    <div class="form-card">
        <div class="show-card-header" style="padding:20px 24px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;">Info Lengkap</div>
        <div class="show-card-body" style="padding:24px;">
            <div class="show-row"><span class="show-label">Siswa</span><span class="show-value">{{ $nilai->siswa->nama }}</span></div>
            <div class="show-row"><span class="show-label">Kelas</span><span class="show-value">{{ $nilai->siswa->kelas }}</span></div>
            <div class="show-row"><span class="show-label">Mata Pelajaran</span><span class="show-value">{{ $nilai->mapel->nama }}</span></div>
            <div class="show-row"><span class="show-label">Semester</span><span class="show-value">{{ $nilai->semester === 1 ? 'Ganjil' : 'Genap' }}</span></div>
            <div class="show-row"><span class="show-label">Diperbarui</span><span class="show-value">{{ $nilai->updated_at->format('d M Y, H:i') }}</span></div>
        </div>
    </div>

    <div style="display:flex;gap:12px;margin-top:20px;">
        <a href="{{ route('admin.nilai.edit', $nilai->id) }}" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Nilai
        </a>
        <a href="{{ route('admin.nilai.index') }}" class="btn-cancel-form">Kembali</a>
    </div>
</div>

@endsection