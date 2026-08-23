@extends('layouts.app')

@section('title', 'Data Guru - SIS')
@section('breadcrumb', 'Data Guru')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
@endsection

@section('content')

    {{-- Stats --}}
    <div class="guru-stats fade-up">
        <div class="guru-stat-card">
            <div class="guru-stat-icon" style="background:rgba(13,148,136,0.1);">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <div class="guru-stat-number" style="color:var(--accent);">{{ $totalGuru }}</div>
                <div class="guru-stat-label">Total Guru</div>
            </div>
        </div>
        <div class="guru-stat-card">
            <div class="guru-stat-icon" style="background:rgba(245,158,11,0.1);">
                <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div>
                <div class="guru-stat-number" style="color:#f59e0b;">{{ $totalMapel }}</div>
                <div class="guru-stat-label">Mata Pelajaran Diampu</div>
            </div>
        </div>
        <div class="guru-stat-card">
            <div class="guru-stat-icon" style="background:rgba(6,182,212,0.1);">
                <svg viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div>
                <div class="guru-stat-number" style="color:#06b6d4;">{{ $jamMengajar }}</div>
                <div class="guru-stat-label">Jam Mengajar / Minggu</div>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Daftar Guru</h1>
            <p class="guru-page-subtitle">Kelola data guru SMK Negeri 2</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.guru.export') }}" class="btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export
            </a>
            <a href="{{ route('admin.guru.create') }}" class="btn-primary-guru">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Guru
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="guru-table-card fade-up-delay">
        <div class="guru-table-header">
            <h2 class="guru-table-title">Data Guru</h2>
            <div class="guru-table-actions">
                <div class="guru-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari guru..." id="guruSearch">
                </div>
                <select class="guru-filter-select" id="guruFilterMapel">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Bulk actions --}}
        <div class="bulk-actions" id="bulkActions">
            <span id="bulkCount">0 data dipilih</span>
            <button class="btn-bulk-delete" id="bulkDeleteBtn">Hapus Terpilih</button>
        </div>

        <div style="overflow-x:auto;">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" class="guru-checkbox" id="selectAll"></th>
                        <th style="width:70px;">ID</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Email</th>
                        <th style="width:130px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="guruTableBody">
                    @forelse($gurus as $i => $guru)
                        @php
                            $colors = ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981','#3b82f6','#ec4899','#fb923c','#22c55e'];
                            $ac = $colors[$i % count($colors)];
                            $mc = $mapelColors[$guru->mata_pelajaran] ?? ['bg'=>'rgba(107,127,107,0.1)','text'=>'#6b7f6b'];
                        @endphp
                        <tr data-id="{{ $guru->id }}" data-nama="{{ $guru->nama }}" data-mapel="{{ $guru->mata_pelajaran }}" data-email="{{ $guru->email }}"
                            style="animation:fadeUp 0.4s ease {{ $i * 0.04 }}s both;">
                            <td><input type="checkbox" class="guru-checkbox guru-row-checkbox" value="{{ $guru->id }}"></td>
                            <td style="font-weight:600;color:var(--muted);font-size:13px;">#{{ str_pad($guru->id,3,'0',STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="guru-name-cell">
                                    <div class="guru-avatar" style="background:{{ $ac }};">{{ strtoupper(substr($guru->nama,0,1)) }}</div>
                                    {{ $guru->nama }}
                                </div>
                            </td>
                            <td><span class="mapel-badge" style="background:{{ $mc['bg'] }};color:{{ $mc['text'] }};">{{ $guru->mata_pelajaran }}</span></td>
                            <td class="guru-email-cell">{{ $guru->email }}</td>
                            <td>
                                <div class="guru-action-btns">
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn-icon edit" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="btn-icon delete" title="Hapus" onclick="openDeleteModal({{ $guru->id }}, '{{ $guru->nama }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="guru-empty">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                    <p>Belum ada data guru</p>
                                    <a href="{{ route('admin.guru.create') }}" class="btn-primary-guru" style="display:inline-flex;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Tambah Guru Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="guru-table-footer">
            <span class="guru-table-info">Menampilkan {{ $gurus->count() }} dari {{ $totalGuru }} data</span>
            {{ $gurus->appends(request()->query())->links('partials.pagination-custom') }}
        </div>
    </div>

    {{-- Toast --}}
    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

    {{-- Modal Hapus --}}
    <div class="modal-overlay" id="deleteOverlay"></div>
    <div class="modal-box" id="deleteModal">
        <div style="text-align:center;">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <h3 class="modal-title">Hapus Data Guru?</h3>
            <p class="modal-text">Data yang dihapus tidak dapat dikembalikan. Yakin ingin menghapus <strong id="deleteNama"></strong>?</p>
            <div class="modal-actions">
                <button class="btn-cancel-form" id="deleteCancelBtn" style="flex:1;">Batal</button>
                <button class="btn-danger" id="deleteConfirmBtn" style="flex:1;">Hapus</button>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/guru.js') }}"></script>
@endsection