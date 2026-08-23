@extends('layouts.app')

@section('title', 'Edit Nilai - SIS')
@section('breadcrumb', 'Nilai Siswa / Edit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .nilai-input-table { width:100%; border-collapse:collapse; }
        .nilai-input-table thead th { padding:12px 16px; font-size:11px; font-weight:700; text-transform:uppercase; color:var(--muted); background:#f8faf7; border-bottom:1px solid var(--border); }
        .nilai-input-table tbody td { padding:10px 16px; border-bottom:1px solid #eef2ee; }
        .nilai-input { width:100px; padding:10px; border:1.5px solid var(--border); border-radius:8px; font-size:16px; font-weight:600; text-align:center; font-family:'Space Grotesk',sans-serif; outline:none; transition:all 0.2s; }
        .nilai-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(13,148,136,0.1); }
    </style>
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.nilai.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Edit Nilai</h1>
            <p class="form-page-subtitle">{{ $nilai->siswa->nama }} &middot; {{ $nilai->mapel->nama }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.nilai.update', $nilai->id) }}">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <span class="form-card-header-text">Perbarui Nilai</span>
            </div>
            <div class="form-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nilai Tugas (30%)</label>
                        <input type="number" class="form-input" name="tugas" value="{{ old('tugas', $nilai->tugas) }}" min="0" max="100" style="text-align:center;font-size:20px;font-family:'Space Grotesk',sans-serif;font-weight:700;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-input" name="uts" value="{{ old('uts', $nilai->uts) }}" min="0" max="100" style="text-align:center;font-size:20px;font-family:'Space Grotesk',sans-serif;font-weight:700;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-input" name="uas" value="{{ old('uas', $nilai->uas) }}" min="0" max="100" style="text-align:center;font-size:20px;font-family:'Space Grotesk',sans-serif;font-weight:700;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nilai Akhir</label>
                        <input type="text" class="form-input" value="{{ $nilai->nilai_akhir }}" disabled style="text-align:center;font-size:24px;font-family:'Space Grotesk',sans-serif;font-weight:700;color:{{ $nilai->nilai_akhir >= 75 ? 'var(--success)' : 'var(--danger)' }};background:{{ $nilai->nilai_akhir >= 75 ? 'rgba(22,163,74,0.05)' : 'rgba(220,38,38,0.05)' }};">
                    </div>
                </div>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.nilai.index') }}" class="btn-cancel-form">Batal</a>
                <button type="submit" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Perbarui Nilai
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection