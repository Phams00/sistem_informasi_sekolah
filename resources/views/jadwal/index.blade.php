@extends('layouts.app')

@section('title', 'Jadwal Pelajaran - SIS')
@section('breadcrumb', 'Jadwal Pelajaran')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
@endsection

@section('content')

    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Jadwal Pelajaran</h1>
            <p class="guru-page-subtitle">Tabel jadwal mingguan &mdash; {{ Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.jadwal.create') }}" class="btn-primary-guru">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.jadwal.index') }}">
        <div class="jadwal-controls fade-up">
            <div class="jadwal-filter">
                <span>Kelas:</span>
                <select name="kelas" id="filterKelas">
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas', $selectedKelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="jadwal-filter">
                <span>Semester:</span>
                <select name="semester">
                    <option value="1" {{ request('semester', 1) == 1 ? 'selected' : '' }}>Ganjil</option>
                    <option value="2" {{ request('semester') == 2 ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
        </div>
    </form>

    <div class="timetable-wrapper fade-up-delay">
        <table class="timetable">
            <thead>
                <tr>
                    <th>Jam</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                    <th>Sabtu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jamList as $jam)
                    <tr>
                        <td>{{ $jam['label'] }}<br><span style="font-weight:400;font-size:10px;">{{ $jam['waktu'] }}</span></td>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <td>
                                @php $slot = $jadwalData[$hari][$jam['ke']] ?? null; @endphp
                                @if($slot)
                                    <a href="{{ route('admin.jadwal.edit', $slot->id) }}" class="jadwal-slot" style="background:{{ $slot->color_bg }};color:{{ $slot->color_text }};text-decoration:none;display:block;">
                                        <div class="jadwal-slot-name">{{ $slot->mapel->nama }}</div>
                                        <div class="jadwal-slot-teacher">{{ $slot->guru->nama }}</div>
                                        <div class="jadwal-slot-class">{{ $slot->kelas }}</div>
                                    </a>
                                @else
                                    <a href="{{ route('admin.jadwal.create', ['hari' => $hari, 'jam' => $jam['ke']]) }}" class="jadwal-empty-add" title="Tambah jadwal">+</a>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="jadwal-legend">
            @foreach($legendColors as $lc)
                <div class="jadwal-legend-item">
                    <div class="jadwal-legend-dot" style="background:{{ $lc['color'] }};"></div>
                    {{ $lc['nama'] }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

@endsection

@section('js')
    <script src="{{ asset('js/jadwal.js') }}"></script>
@endsection