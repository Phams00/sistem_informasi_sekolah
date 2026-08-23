@extends('layouts.app')

@section('title', 'Manajemen Akun - SIS')
@section('breadcrumb', 'Pengaturan / Akun')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/guru.css') }}">
    <style>
        .role-badge {
            display: inline-flex; padding: 4px 12px; border-radius: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 0.3px;
        }
        .role-badge.admin { background: rgba(13,148,136,0.1); color: #0d9488; }
        .role-badge.guru  { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .role-badge.tu    { background: rgba(245,158,11,0.1); color: #f59e0b; }
        .user-status { width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:6px; }
        .user-status.active { background:var(--success); }
        .user-status.inactive { background:var(--muted); opacity:0.4; }
    </style>
@endsection

@section('content')

    <div class="guru-page-header fade-up">
        <div>
            <h1 class="guru-page-title">Manajemen Akun</h1>
            <p class="guru-page-subtitle">Kelola akun pengguna yang memiliki akses ke sistem &mdash; {{ $totalUsers }} akun</p>
        </div>
        <div class="guru-header-actions">
            <a href="{{ route('admin.users.create') }}" class="btn-primary-guru">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Akun
            </a>
        </div>
    </div>

    <div class="guru-table-card fade-up-delay">
        <div style="overflow-x:auto;">
            <table class="guru-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width:120px;text-align:center;">Role</th>
                        <th style="width:90px;text-align:center;">Status</th>
                        <th style="width:60px;text-align:center;">Login Terakhir</th>
                        <th style="width:110px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                        <tr style="animation:fadeUp 0.3s ease {{ $i * 0.03 }}s both;">
                            <td style="font-weight:600;color:var(--muted);font-size:13px;">{{ $i + 1 }}</td>
                            <td>
                                <div class="guru-name-cell">
                                    <div class="guru-avatar" style="background:{{ ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981'][$i % 6] }};">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                    {{ $u->name }}
                                </div>
                            </td>
                            <td class="guru-email-cell">{{ $u->email }}</td>
                            <td style="text-align:center;"><span class="role-badge {{ $u->role ?? 'admin' }}">{{ ucfirst($u->role ?? 'admin') }}</span></td>
                            <td style="text-align:center;">
                                <span class="user-status {{ $u->is_active ? 'active' : 'inactive' }}"></span>
                                <span style="font-size:12px;color:var(--muted);">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td style="font-size:12px;color:var(--muted);text-align:center;">{{ $u->last_login_at ? $u->last_login_at->diffForHumans() : '-' }}</td>
                            <td>
                                <div class="guru-action-btns">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn-icon edit" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="btn-icon delete" title="Hapus" onclick="openDeleteModal({{ $u->id }}, '{{ $u->name }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="guru-empty"><p>Belum ada akun pengguna</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="guru-table-footer">
            <span class="guru-table-info">{{ $users->count() }} akun</span>
                    {{ $users->appends(request()->query())->links('partials.pagination-custom') }}
        </div>
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite"></div>
    @if(session('success'))
        <input type="hidden" id="flashSuccess" value="{{ session('success') }}">
    @endif

    <div class="modal-overlay" id="deleteOverlay"></div>
    <div class="modal-box" id="deleteModal">
        <div style="text-align:center;">
            <div class="modal-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></div>
            <h3 class="modal-title">Hapus Akun?</h3>
            <p class="modal-text">Yakin ingin menghapus akun <strong id="deleteNama"></strong>?</p>
            <div class="modal-actions">
                <button class="btn-cancel-form" id="deleteCancelBtn" style="flex:1;">Batal</button>
                <button class="btn-danger" id="deleteConfirmBtn" style="flex:1;">Hapus</button>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteOverlay = document.getElementById('deleteOverlay');
            var deleteModal = document.getElementById('deleteModal');
            var deleteNama = document.getElementById('deleteNama');
            var deleteTargetId = null;

            window.openDeleteModal = function (id, nama) {
                deleteTargetId = id;
                deleteNama.textContent = nama;
                deleteModal.classList.add('open');
                deleteOverlay.classList.add('open');
            };

            function closeDeleteModal() {
                deleteModal.classList.remove('open');
                deleteOverlay.classList.remove('open');
                deleteTargetId = null;
            }

            document.getElementById('deleteCancelBtn').addEventListener('click', closeDeleteModal);
            deleteOverlay.addEventListener('click', closeDeleteModal);

            document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
                if (deleteTargetId === null) return;
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/users/' + deleteTargetId;
                var csrf = document.createElement('input');
                csrf.type = 'hidden'; csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrf);
                var method = document.createElement('input');
                method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeDeleteModal();
            });

            // Toast
            var flash = document.getElementById('flashSuccess');
            if (flash && flash.value) {
                var toast = document.createElement('div');
                toast.className = 'toast';
                toast.innerHTML = '<div class="toast-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><span>' + flash.value + '</span><button class="toast-close"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
                document.getElementById('toastContainer').appendChild(toast);
                toast.querySelector('.toast-close').addEventListener('click', function () { toast.classList.add('exiting'); setTimeout(function(){ toast.remove(); }, 300); });
                setTimeout(function(){ toast.classList.add('exiting'); setTimeout(function(){ toast.remove(); }, 300); }, 4000);
            }
        });
    </script>
@endsection