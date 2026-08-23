@extends('layouts.app')

@section('title', 'Absensi - SIS')
@section('breadcrumb', 'Absensi')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
@endsection

@section('content')

    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Absensi Siswa</h1>
            <p class="guru-page-subtitle">Rekap kehadiran harian &mdash; {{ $tanggal->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.absensi.create') }}" class="btn-primary-guru">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Input Absensi
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="absensi-stats fade-up">
        <div class="absensi-stat">
            <div class="absensi-stat-dot" style="background:#16a34a;"></div>
            <div>
                <div class="absensi-stat-count" style="color:#16a34a;">{{ $stats['hadir'] }}</div>
                <div class="absensi-stat-label">Hadir</div>
            </div>
        </div>
        <div class="absensi-stat">
            <div class="absensi-stat-dot" style="background:#f59e0b;"></div>
            <div>
                <div class="absensi-stat-count" style="color:#f59e0b;">{{ $stats['sakit'] }}</div>
                <div class="absensi-stat-label">Sakit</div>
            </div>
        </div>
        <div class="absensi-stat">
            <div class="absensi-stat-dot" style="background:#3b82f6;"></div>
            <div>
                <div class="absensi-stat-count" style="color:#3b82f6;">{{ $stats['izin'] }}</div>
                <div class="absensi-stat-label">Izin</div>
            </div>
        </div>
        <div class="absensi-stat">
            <div class="absensi-stat-dot" style="background:#dc2626;"></div>
            <div>
                <div class="absensi-stat-count" style="color:#dc2626;">{{ $stats['alpha'] }}</div>
                <div class="absensi-stat-label">Alpha</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.absensi.index') }}">
        <div class="jadwal-controls fade-up" style="margin-bottom:20px;">
            <div class="jadwal-filter">
                <span>Tanggal:</span>
                <input type="date" name="tanggal" value="{{ request('tanggal', $tanggal->format('Y-m-d')) }}" class="absensi-auto-submit" style="padding:8px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;outline:none;">
            </div>
            <div class="jadwal-filter">
                <span>Kelas:</span>
                <select name="kelas" class="absensi-auto-submit">
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas', $selectedKelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="guru-table-card fade-up-delay">
        <div style="overflow-x:auto;">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th style="width:100px;text-align:center;">Status</th>
                        <th style="width:100px;text-align:center;">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensis as $i => $a)
                        @php
                            $persen = $a->persen_kehadiran ?? 100;
                            $persenClass = $persen >= 85 ? 'high' : ($persen >= 70 ? 'mid' : 'low');
                        @endphp
                        <tr style="animation:fadeUp 0.3s ease {{ $i * 0.03 }}s both;">
                            <td style="font-weight:600;color:var(--muted);font-size:13px;">{{ $i + 1 }}</td>
                            <td>
                                <div class="guru-name-cell">
                                    <div class="guru-avatar" style="width:32px;height:32px;font-size:12px;border-radius:8px;background:{{ ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981'][$i % 6] }};">{{ strtoupper(substr($a->siswa->nama,0,1)) }}</div>
                                    {{ $a->siswa->nama }}
                                </div>
                            </td>
                            <td style="font-size:13px;">{{ $a->siswa->kelas }}</td>
                            <td style="text-align:center;">
                                <span class="status-badge {{ strtolower($a->status) }}">{{ ucfirst($a->status) }}</span>
                            </td>
                            <td style="text-align:center;">
                                <span class="absensi-persen {{ $persenClass }}">{{ number_format($persen, 1) }}%</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="guru-empty"><p>Belum ada data absensi untuk tanggal ini</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="guru-table-footer">
            <span class="guru-table-info">{{ $absensis->count() }} data</span>
            {{ $absensis->appends(request()->query())->links('partials.pagination-custom') }}
        </div>
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

@endsection

@section('js')
    <script src="{{ asset('js/absensi.js') }}"></script>
@endsection