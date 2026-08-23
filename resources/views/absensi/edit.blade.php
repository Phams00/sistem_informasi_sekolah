@extends('layouts.app')

@section('title', 'Edit Absensi - SIS')
@section('breadcrumb', 'Absensi / Edit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
    <style>
        .absensi-radio { display: none; }
        .absensi-radio-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 24px;
            border-radius: 12px;
            border: 2px solid var(--border);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s;
            user-select: none;
            min-width: 110px;
        }
        .absensi-radio-label:hover {
            border-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        }
        .absensi-radio:checked + .absensi-radio-label.hadir {
            background: rgba(22,163,74,0.12);
            border-color: #16a34a;
            color: #16a34a;
            box-shadow: 0 6px 20px rgba(22,163,74,0.2);
            transform: translateY(-3px);
        }
        .absensi-radio:checked + .absensi-radio-label.sakit {
            background: rgba(245,158,11,0.12);
            border-color: #f59e0b;
            color: #f59e0b;
            box-shadow: 0 6px 20px rgba(245,158,11,0.2);
            transform: translateY(-3px);
        }
        .absensi-radio:checked + .absensi-radio-label.izin {
            background: rgba(59,130,246,0.12);
            border-color: #3b82f6;
            color: #3b82f6;
            box-shadow: 0 6px 20px rgba(59,130,246,0.2);
            transform: translateY(-3px);
        }
        .absensi-radio:checked + .absensi-radio-label.alpha {
            background: rgba(220,38,38,0.12);
            border-color: #dc2626;
            color: #dc2626;
            box-shadow: 0 6px 20px rgba(220,38,38,0.2);
            transform: translateY(-3px);
        }
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }
        .student-profile {
            text-align: center;
            margin-bottom: 28px;
            padding: 24px;
            background: var(--bg);
            border-radius: 14px;
        }
        .student-avatar-lg {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 26px;
            font-family: 'Space Grotesk', sans-serif;
            margin: 0 auto 14px;
        }
        @media (max-width: 768px) {
            .status-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
@endsection

@section('content')

<div class="form-page fade-up">

    {{-- Header --}}
    <div class="form-page-header">
        <a href="{{ route('admin.absensi.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
        </a>
        <div>
            <h1 class="form-page-title">Edit Absensi</h1>
            <p class="form-page-subtitle">
                {{ $absensi->siswa->nama }} &middot;
                {{ $absensi->tanggal->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.absensi.update', $absensi->id) }}">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <span class="form-card-header-text">Ubah Status Kehadiran</span>
            </div>

            <div class="form-card-body">
                {{-- Profil siswa --}}
                <div class="student-profile">
                    <div class="student-avatar-lg" style="background:linear-gradient(135deg, var(--accent), #06b6d4);">
                        {{ strtoupper(substr($absensi->siswa->nama, 0, 2)) }}
                    </div>
                    <h3 style="font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:700;">
                        {{ $absensi->siswa->nama }}
                    </h3>
                    <p style="font-size:13px;color:var(--muted);margin-top:4px;">
                        {{ $absensi->siswa->kelas }} &middot; NIS {{ $absensi->siswa->nis }}
                    </p>
                </div>

                {{-- Pilihan status --}}
                <div class="status-grid">
                    @foreach(['Hadir','Sakit','Izin','Alpha'] as $st)
                        @php $key = strtolower($st); @endphp
                        <input type="radio" class="absensi-radio" name="status" value="{{ $st }}"
                               id="edit-{{ $key }}"
                               {{ $absensi->status === $st ? 'checked' : '' }}>
                        <label for="edit-{{ $key }}" class="absensi-radio-label {{ $key }}">
                            {{ $st }}
                        </label>
                    @endforeach
                </div>

                {{-- Keterangan opsional --}}
                <div style="margin-top:24px;">
                    <label class="form-label" for="editKeterangan">Keterangan (opsional)</label>
                    <textarea class="form-input" id="editKeterangan" name="keterangan" rows="2"
                              placeholder="Misal: sakit demam, izin keperluan keluarga, dll"
                              data-max-chars="200">{{ old('keterangan', $absensi->keterangan ?? '') }}</textarea>
                </div>
            </div>

            <div class="form-card-footer">
                <a href="{{ route('admin.absensi.index') }}" class="btn-cancel-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form"
                        style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Perbarui Status
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection