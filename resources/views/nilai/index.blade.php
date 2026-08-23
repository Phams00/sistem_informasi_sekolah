@extends('layouts.app')

@section('title', 'Nilai Siswa - SIS')
@section('breadcrumb', 'Nilai Siswa')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nilai.css') }}">
@endsection

@section('content')

    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Nilai Siswa</h1>
            <p class="guru-page-subtitle">Rekapitulasi nilai &mdash; Semester {{ $semester === 1 ? 'Ganjil' : 'Genap' }} {{ $tahunAjaran }}</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.nilai.create', ['kelas' => $selectedKelas, 'mapel_id' => request('mapel_id'), 'semester' => $semester]) }}" class="btn-primary-guru">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Input Nilai
            </a>
        </div>
    </div>

    {{-- Rata-rata --}}
    <div class="nilai-rata-card fade-up">
        <div class="nilai-rata-number">{{ number_format($rataRata, 1) }}</div>
        <div class="nilai-rata-info">
            <div class="nilai-rata-title">Rata-rata Keseluruhan</div>
            <div class="nilai-rata-desc">Berdasarkan {{ $totalNilai }} nilai yang tercatat di kelas {{ $selectedKelas }}</div>
        </div>
    </div>

    {{-- Summary per predikat --}}
    <div class="nilai-summary-grid fade-up">
        @foreach($predikatSummary as $ps)
            <div class="nilai-summary-card">
                <div class="nilai-summary-count" style="color:{{ $ps['color'] }};">{{ $ps['count'] }}</div>
                <div class="nilai-summary-label">Predikat {{ $ps['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.nilai.index') }}" style="margin-bottom:20px;">
        <div class="jadwal-controls fade-up-delay" style="margin-bottom:0;">
            <div class="jadwal-filter">
                <span>Kelas:</span>
                <select name="kelas" class="nilai-auto-submit">
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas', $selectedKelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="jadwal-filter">
                <span>Mapel:</span>
                <select name="mapel_id" class="nilai-auto-submit">
                    <option value="">Semua</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="jadwal-filter">
                <span>Semester:</span>
                <select name="semester" class="nilai-auto-submit">
                    <option value="1" {{ request('semester', 1) == 1 ? 'selected' : '' }}>Ganjil</option>
                    <option value="2" {{ request('semester') == 2 ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="guru-table-card fade-up-delay" style="animation-delay:0.15s;">
        <div style="overflow-x:auto;">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Tugas</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>NA</th>
                        <th style="width:80px;text-align:center;">Predikat</th>
                    </tr>
                </thead>
                <tbody id="nilaiTableBody">
                    @forelse($nilais as $i => $n)
                        @php
                            $na = $n->nilai_akhir;
                            $grade = $na >= 88 ? 'a' : ($na >= 75 ? 'b' : ($na >= 60 ? 'c' : ($na >= 50 ? 'd' : 'e')));
                            $gradeLabel = strtoupper($grade);
                        @endphp
                        <tr data-id="{{ $n->id }}" style="animation:fadeUp 0.3s ease {{ $i * 0.03 }}s both;">
                            <td style="font-weight:600;color:var(--muted);font-size:13px;">{{ $i + 1 }}</td>
                            <td>
                                <div class="guru-name-cell">
                                    <div class="guru-avatar" style="width:32px;height:32px;font-size:12px;border-radius:8px;background:{{ ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981','#3b82f6','#ec4899'][$i % 8] }};">{{ strtoupper(substr($n->siswa->nama,0,1)) }}</div>
                                    {{ $n->siswa->nama }}
                                </div>
                            </td>
                            <td style="font-size:13px;">{{ $n->mapel->nama }}</td>
                            <td style="text-align:center;font-weight:600;">{{ $n->tugas }}</td>
                            <td style="text-align:center;font-weight:600;">{{ $n->uts }}</td>
                            <td style="text-align:center;font-weight:600;">{{ $n->uas }}</td>
                            <td style="text-align:center;"><span class="nilai-grade {{ $grade }}">{{ number_format($na,0) }}</span></td>
                            <td style="text-align:center;font-weight:700;font-size:13px;color:{{ $grade === 'a' || $grade === 'b' ? 'var(--success)' : ($grade === 'c' ? '#f59e0b' : 'var(--danger)') }};">{{ $gradeLabel }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8"><div class="guru-empty"><p>Belum ada data nilai</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="guru-table-footer">
            <span class="guru-table-info">{{ $nilais->count() }} data</span>
            {{ $nilais->appends(request()->query())->links('partials.pagination-custom') }}
        </div>
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

@endsection

@section('js')
    <script src="{{ asset('js/nilai.js') }}"></script>
@endsection