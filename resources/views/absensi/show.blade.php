@extends('layouts.app')

@section('title', 'Detail Absensi - SIS')
@section('breadcrumb', 'Absensi / Detail')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
    <style>
        .absensi-show-hero {
            background: linear-gradient(135deg, #0f1923, #0d3b3e);
            border-radius: 16px;
            padding: 32px;
            color: white;
            display: flex;
            align-items: center;
            gap: 28px;
            margin-bottom: 24px;
        }
        .absensi-show-hero-avatar {
            width: 68px;
            height: 68px;
            border-radius: 18px;
            background: rgba(94,234,212,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5eead4;
            font-weight: 800;
            font-size: 24px;
            font-family: 'Space Grotesk', sans-serif;
            flex-shrink: 0;
        }
        .absensi-show-hero h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .absensi-show-hero p {
            font-size: 14px;
            color: #8899aa;
        }
        .absensi-show-status {
            display: inline-flex;
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            margin-top: 12px;
        }
        .absensi-show-status.hadir  { background: rgba(22,163,74,0.2); color: #4ade80; }
        .absensi-show-status.sakit  { background: rgba(245,158,11,0.2); color: #fbbf24; }
        .absensi-show-status.izin   { background: rgba(59,130,246,0.2); color: #60a5fa; }
        .absensi-show-status.alpha  { background: rgba(220,38,38,0.2); color: #f87171; }

        .history-table { width: 100%; border-collapse: collapse; }
        .history-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--muted);
            background: #f8faf7;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }
        .history-table tbody td {
            padding: 12px 16px;
            font-size: 13px;
            border-bottom: 1px solid #eef2ee;
        }
        .history-table tbody tr:hover { background: rgba(13,148,136,0.02); }

        .persen-bar-wrapper {
            width: 100%;
            height: 8px;
            background: #eef2ee;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 6px;
        }
        .persen-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.8s cubic-bezier(0.16,1,0.3,1);
        }

        @media (max-width: 768px) {
            .absensi-show-hero { flex-direction: column; text-align: center; }
        }
    </style>
@endsection

@section('content')

<div class="fade-up">

    {{-- Header --}}
    <div class="form-page-header" style="margin-bottom: 24px;">
        <a href="{{ route('admin.absensi.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Detail Absensi</h1>
            <p class="form-page-subtitle">Riwayat kehadiran siswa</p>
        </div>
    </div>

    {{-- Hero card --}}
    <div class="absensi-show-hero">
        <div class="absensi-show-hero-avatar">
            {{ strtoupper(substr($absensi->siswa->nama, 0, 2)) }}
        </div>
        <div>
            <h2>{{ $absensi->siswa->nama }}</h2>
            <p>{{ $absensi->siswa->kelas }} &middot; NIS {{ $absensi->siswa->nis }}</p>
            <div class="absensi-show-status {{ strtolower($absensi->status) }}">
                Status: {{ $absensi->status }}
            </div>
        </div>
    </div>

    {{-- Statistik kehadiran --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
        <div class="form-card">
            <div class="show-card-header" style="padding:18px 24px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;">
                Statistik Kehadiran
            </div>
            <div class="show-card-body" style="padding:24px;">
                @foreach($kehadiranStats as $stat)
                    <div style="margin-bottom:18px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <span style="font-size:13px;font-weight:600;">{{ $stat['label'] }}</span>
                            <span style="font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:{{ $stat['color'] }};">{{ $stat['count'] }}x ({{ $stat['persen'] }}%)</span>
                        </div>
                        <div class="persen-bar-wrapper">
                            <div class="persen-bar-fill" style="width:{{ $stat['persen'] }}%;background:{{ $stat['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-card">
            <div class="show-card-header" style="padding:18px 24px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;">
                Info Absensi Ini
            </div>
            <div class="show-card-body" style="padding:24px;">
                <div class="show-row"><span class="show-label">Tanggal</span><span class="show-value">{{ $absensi->tanggal->locale('id')->translatedFormat('l, d F Y') }}</span></div>
                <div class="show-row"><span class="show-label">Status</span><span class="show-value"><span class="status-badge {{ strtolower($absensi->status) }}">{{ $absensi->status }}</span></span></div>
                <div class="show-row"><span class="show-label">Kelas</span><span class="show-value">{{ $absensi->siswa->kelas }}</span></div>
                <div class="show-row"><span class="show-label">Jurusan</span><span class="show-value">{{ $absensi->siswa->jurusan }}</span></div>
                @if($absensi->keterangan)
                    <div style="margin-top:16px;padding:14px;background:var(--bg);border-radius:10px;font-size:13px;color:var(--muted);">
                        <strong style="color:var(--fg);">Keterangan:</strong><br>
                        {{ $absensi->keterangan }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Riwayat 30 hari terakhir --}}
    <div class="guru-table-card">
        <div class="table-header" style="padding:18px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <h3 style="font-family:'Space Grotesk',sans-serif;font-size:16px;font-weight:700;">Riwayat 30 Hari Terakhir</h3>
        </div>
        <div style="overflow-x:auto;">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                        <tr>
                            <td style="font-weight:600;">{{ $r->tanggal->format('d M Y') }}</td>
                            <td style="color:var(--muted);">{{ $r->tanggal->locale('id')->translatedFormat('l') }}</td>
                            <td style="text-align:center;"><span class="status-badge {{ strtolower($r->status) }}">{{ $r->status }}</span></td>
                            <td style="text-align:center;color:var(--muted);">{{ $r->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:32px;color:var(--muted);">Belum ada riwayat</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Aksi --}}
    <div style="display:flex;gap:12px;margin-top:20px;">
        <a href="{{ route('admin.absensi.edit', $absensi->id) }}" class="btn-submit-form"
           style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Absensi
        </a>
        <a href="{{ route('admin.absensi.index') }}" class="btn-cancel-form">Kembali ke Daftar</a>
    </div>
</div>

@endsection