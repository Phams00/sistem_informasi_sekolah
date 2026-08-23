@extends('layouts.app')

@section('title', 'Data Siswa - SIS')
@section('breadcrumb', 'Data Siswa')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">
@endsection

@section('content')

    {{-- Header --}}
    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Data Siswa</h1>
            <p class="guru-page-subtitle">Kelola data siswa SMK Negeri 2 &mdash; Total {{ $totalSiswa }} siswa terdaftar</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.siswa.export') }}" class="btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="btn-primary-guru">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="guru-table-card fade-up-delay">
        <div class="guru-table-header" style="flex-direction:column;align-items:stretch;gap:16px;">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <h2 class="guru-table-title">Daftar Siswa</h2>
                <div class="guru-search" style="width:220px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari NIS / nama..." id="siswaSearch">
                </div>
            </div>
            <div class="siswa-filters">
                <button class="siswa-filter-chip active" data-kelas="">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Semua
                </button>
                @foreach($kelasList as $k)
                    <button class="siswa-filter-chip" data-kelas="{{ $k }}">{{ $k }}</button>
                @endforeach
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" class="guru-checkbox" id="selectAll"></th>
                        <th style="width:80px;">NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>L/P</th>
                        <th>Email</th>
                        <th style="width:110px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="siswaTableBody">
                    @forelse($siswas as $i => $s)
                        @php
                            $colors = ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981','#3b82f6','#ec4899'];
                            $ac = $colors[$i % count($colors)];
                            $jurusanKey = strtolower(str_replace(' ','', $s->jurusan ?? ''));
                        @endphp
                        <tr data-id="{{ $s->id }}" data-nama="{{ $s->nama }}" data-nis="{{ $s->nis }}" data-kelas="{{ $s->kelas }}"
                            style="animation:fadeUp 0.4s ease {{ $i * 0.03 }}s both;">
                            <td><input type="checkbox" class="guru-checkbox guru-row-checkbox" value="{{ $s->id }}"></td>
                            <td style="font-weight:600;color:var(--muted);font-size:12px;">{{ $s->nis }}</td>
                            <td>
                                <div class="siswa-name-cell">
                                    <div class="guru-avatar" style="background:{{ $ac }};width:32px;height:32px;font-size:12px;border-radius:8px;">
                                        {{ strtoupper(substr($s->nama,0,1)) }}
                                    </div>
                                    {{ $s->nama }}
                                </div>
                            </td>
                            <td><span class="kelas-badge">{{ $s->kelas }}</span></td>
                            <td><span class="jurusan-badge {{ $jurusanKey }}">{{ $s->jurusan }}</span></td>
                            <td>
                                <span class="gender-icon {{ strtolower($s->jenis_kelamin) }}">
                                    {{ $s->jenis_kelamin === 'L' ? '♂' : '♀' }}
                                </span>
                            </td>
                            <td class="guru-email-cell">{{ $s->email }}</td>
                            <td>
                                <div class="guru-action-btns">
                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn-icon edit" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="btn-icon delete" title="Hapus" onclick="openDeleteModal({{ $s->id }}, '{{ $s->nama }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="guru-empty">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    <p>Belum ada data siswa</p>
                                    <a href="{{ route('admin.siswa.create') }}" class="btn-primary-guru" style="display:inline-flex;">Tambah Siswa Pertama</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="guru-table-footer">
            <span class="guru-table-info">Menampilkan {{ $siswas->count() }} dari {{ $totalSiswa }} data</span>
            {{ $siswas->appends(request()->query())->links('partials.pagination-custom') }}
        </div>
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

    {{-- Modal Hapus (reuse guru.css) --}}
    <div class="modal-overlay" id="deleteOverlay"></div>
    <div class="modal-box" id="deleteModal">
        <div style="text-align:center;">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <h3 class="modal-title">Hapus Data Siswa?</h3>
            <p class="modal-text">Yakin ingin menghapus data <strong id="deleteNama"></strong>?</p>
            <div class="modal-actions">
                <button class="btn-cancel-form" id="deleteCancelBtn" style="flex:1;">Batal</button>
                <button class="btn-danger" id="deleteConfirmBtn" style="flex:1;">Hapus</button>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/siswa.js') }}"></script>
@endsection