@extends('layouts.app')

@section('title', 'Dasbor - Sistem Informasi Sekolah')
@section('breadcrumb', 'Dasbor')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

    {{-- Welcome Banner --}}
    <div class="welcome-banner fade-up">
        <div class="welcome-text">
            <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p>Berikut ringkasan informasi sekolah hari ini.</p>
            <div class="welcome-date">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </div>
        </div>
        <div class="welcome-quick-actions">
            <a href="{{ route('admin.siswa.create') }}" class="welcome-quick-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Siswa
            </a>
            <a href="{{ route('admin.absensi.create') }}" class="welcome-quick-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Input Absensi
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="dash-stats">
        <div class="dash-stat-card fade-up">
            <div class="dash-stat-icon" style="background:rgba(13,148,136,0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <div class="dash-stat-number" style="color:var(--accent);">{{ $totalGuru }}</div>
                <div class="dash-stat-label">Total Guru</div>
                <div class="dash-stat-change up">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                    +2 bulan ini
                </div>
            </div>
        </div>
        <div class="dash-stat-card fade-up">
            <div class="dash-stat-icon" style="background:rgba(245,158,11,0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div>
                <div class="dash-stat-number" style="color:#f59e0b;">{{ $totalSiswa }}</div>
                <div class="dash-stat-label">Total Siswa</div>
                <div class="dash-stat-change up">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                    +12 bulan ini
                </div>
            </div>
        </div>
        <div class="dash-stat-card fade-up">
            <div class="dash-stat-icon" style="background:rgba(6,182,212,0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="dash-stat-number" style="color:#06b6d4;">{{ $totalMapel }}</div>
                <div class="dash-stat-label">Mata Pelajaran</div>
            </div>
        </div>
        <div class="dash-stat-card fade-up">
            <div class="dash-stat-icon" style="background:rgba(16,185,129,0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="dash-stat-number" style="color:#10b981;">{{ $kehadiranHariIni }}%</div>
                <div class="dash-stat-label">Kehadiran Hari Ini</div>
                <div class="dash-stat-change {{ $kehadiranHariIni >= 90 ? 'up' : 'down' }}">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        @if($kehadiranHariIni >= 90)
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                        @else
                            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
                        @endif
                    </svg>
                    {{ $kehadiranHariIni >= 90 ? 'Bagus' : 'Perlu perhatian' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Chart + Activity --}}
    <div class="dash-grid-2 fade-up-delay">
        <div class="chart-card">
            <div class="chart-card-header">
                <h3 class="chart-card-title">Statistik Kehadiran</h3>
                <div class="chart-tabs">
                    <button class="chart-tab active" data-chart="chartMinggu">Minggu Ini</button>
                    <button class="chart-tab" data-chart="chartBulan">Bulan Ini</button>
                </div>
            </div>
            <div class="bar-chart" id="chartMinggu">
                @foreach($kehadiranMinggu as $item)
                    <div class="bar-col">
                        <div class="bar-fill" data-height="{{ $item['persen'] }}" style="background:linear-gradient(to top, {{ $item['color'] }}, {{ $item['colorLight'] }});">
                            <div class="bar-tooltip">{{ $item['persen'] }}%</div>
                        </div>
                        <span class="bar-label">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
            <div class="bar-chart" id="chartBulan" style="display:none;">
                @foreach($kehadiranBulan as $item)
                    <div class="bar-col">
                        <div class="bar-fill" data-height="{{ $item['persen'] }}" style="background:linear-gradient(to top, {{ $item['color'] }}, {{ $item['colorLight'] }});">
                            <div class="bar-tooltip">{{ $item['persen'] }}%</div>
                        </div>
                        <span class="bar-label">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="activity-card">
            <h3 class="activity-card-title">Aktivitas Terbaru</h3>
            <div class="activity-list">
                @foreach($aktivitas as $akt)
                    <div class="activity-item">
                        <div class="activity-dot" style="background:{{ $akt['color'] }};"></div>
                        <div class="activity-content">
                            <div class="activity-text">{!! $akt['text'] !!}</div>
                            <div class="activity-time">{{ $akt['waktu'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Jadwal Hari Ini --}}
    <div class="schedule-card fade-up-delay" style="animation-delay:0.35s;">
        <h3 class="schedule-card-title">Jadwal Hari Ini</h3>
        @foreach($jadwalHariIni as $j)
            <div class="schedule-item">
                <div class="schedule-time">{{ $j['jam'] }}</div>
                <div class="schedule-info">
                    <div class="schedule-mapel">{{ $j['mapel'] }}</div>
                    <div class="schedule-detail">{{ $j['guru'] }} &middot; {{ $j['kelas'] }}</div>
                </div>
                <span class="schedule-status">-</span>
            </div>
        @endforeach
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection