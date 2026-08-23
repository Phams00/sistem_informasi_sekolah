@extends('layouts.app')

@section('title', 'Input Absensi - SIS')
@section('breadcrumb', 'Absensi / Input')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
    <style>
        .absensi-radio { display:none; }
        .absensi-radio-label { display:inline-flex; align-items:center; justify-content:center; padding:8px 18px; border-radius:8px; border:1.5px solid var(--border); font-size:12px; font-weight:700; cursor:pointer; transition:all 0.2s; user-select:none; min-width:72px; text-align:center; }
        .absensi-radio-label:hover { border-color:var(--accent); }
        .absensi-radio:checked + .absensi-radio-label.hadir  { background:rgba(22,163,74,0.1); border-color:#16a34a; color:#16a34a; }
        .absensi-radio:checked + .absensi-radio-label.sakit  { background:rgba(245,158,11,0.1); border-color:#f59e0b; color:#f59e0b; }
        .absensi-radio:checked + .absensi-radio-label.izin   { background:rgba(59,130,246,0.1); border-color:#3b82f6; color:#3b82f6; }
        .absensi-radio:checked + .absensi-radio-label.alpha  { background:rgba(220,38,38,0.1); border-color:#dc2626; color:#dc2626; }
        .absensi-input-row td { padding:12px 16px !important; }
        .absensi-status-group { display:flex; gap:6px; justify-content:center; }
    </style>
@endsection

@section('content')

<div class="fade-up">
    <div class="form-page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.absensi.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Input Absensi</h1>
            <p class="form-page-subtitle">Kelas <strong style="color:var(--fg);">{{ $selectedKelas }}</strong> &middot; {{ $tanggal->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.absensi.store') }}">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal->format('Y-m-d') }}">
        <input type="hidden" name="kelas" value="{{ $selectedKelas }}">

        {{-- Quick fill --}}
        <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
            <button type="button" class="btn-outline" onclick="fillAll('Hadir')" style="font-size:12px;padding:8px 16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Semua Hadir
            </button>
            <button type="button" class="btn-outline" onclick="clearAll()" style="font-size:12px;padding:8px 16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Reset
            </button>
        </div>

        <div class="guru-table-card">
            <div style="overflow-x:auto;">
                <table class="guru-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">No</th>
                            <th>Nama Siswa</th>
                            <th style="width:340px;text-align:center;">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswas as $i => $s)
                            @php $existing = $existingAbsensi[$s->id] ?? null; @endphp
                            <tr class="absensi-input-row" style="animation: fadeUp 0.3s ease {{ ($i * 0.03) }}s both;">
                                <td style="font-weight:600;color:var(--muted);font-size:13px;">{{ $i + 1 }}</td>
                                <td>
                                    <div class="guru-name-cell" style="font-size:14px;">
                                        <div class="guru-avatar" style="width:30px;height:30px;font-size:11px;border-radius:8px;background:{{ ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981'][$i % 6] }};">{{ strtoupper(substr($s->nama,0,1)) }}</div>
                                        {{ $s->nama }}
                                    </div>
                                </td>
                                <td>
                                    <div class="absensi-status-group">
                                        <input type="radio" class="absensi-radio" name="status[{{ $s->id }}]" value="Hadir" id="h-{{ $s->id }}" {{ (!$existing || $existing->status === 'Hadir') ? 'checked' : '' }}>
                                        <label for="h-{{ $s->id }}" class="absensi-radio-label hadir">H</label>

                                        <input type="radio" class="absensi-radio" name="status[{{ $s->id }}]" value="Sakit" id="s-{{ $s->id }}" {{ $existing && $existing->status === 'Sakit' ? 'checked' : '' }}>
                                        <label for="s-{{ $s->id }}" class="absensi-radio-label sakit">S</label>

                                        <input type="radio" class="absensi-radio" name="status[{{ $s->id }}]" value="Izin" id="i-{{ $s->id }}" {{ $existing && $existing->status === 'Izin' ? 'checked' : '' }}>
                                        <label for="i-{{ $s->id }}" class="absensi-radio-label izin">I</label>

                                        <input type="radio" class="absensi-radio" name="status[{{ $s->id }}]" value="Alpha" id="a-{{ $s->id }}" {{ $existing && $existing->status === 'Alpha' ? 'checked' : '' }}>
                                        <label for="a-{{ $s->id }}" class="absensi-radio-label alpha">A</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.absensi.index') }}" class="btn-cancel-form">Batal</a>
                <button type="submit" class="btn-submit-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    Simpan Absensi
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script>
        function fillAll(status) {
            document.querySelectorAll('.absensi-radio[value="' + status + '"]').forEach(function(r) { r.checked = true; });
        }
        function clearAll() {
            document.querySelectorAll('.absensi-radio').forEach(function(r) { r.checked = false; });
        }
    </script>
@endsection