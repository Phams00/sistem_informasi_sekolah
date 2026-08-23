@extends('layouts.app')

@section('title', 'Tambah Mapel - SIS')
@section('breadcrumb', 'Mata Pelajaran / Tambah')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.mapel.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Tambah Mata Pelajaran</h1>
            <p class="form-page-subtitle">Daftarkan mata pelajaran baru ke sistem</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.mapel.store') }}">
        @csrf
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <span class="form-card-header-text">Detail Mata Pelajaran</span>
            </div>
            <div class="form-card-body">
                <div class="form-section">
                    <div class="form-section-title">Informasi Umum</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Mapel <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Matematika" data-validate="required|min:2" autofocus>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Mapel</label>
                            <input type="text" class="form-input" name="kode" value="{{ old('kode') }}" placeholder="MTK / BInd / BIng" maxlength="10" style="text-transform:uppercase;">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelompok</label>
                            <select class="form-select" name="kelompok">
                                <option value="umum" {{ old('kelompok', 'umum') === 'umum' ? 'selected' : '' }}>Muatan Nasional</option>
                                <option value="lokal" {{ old('kelompok') === 'lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                                <option value="peminatan" {{ old('kelompok') === 'peminatan' ? 'selected' : '' }}>Peminatan Kejuruan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">KKM</label>
                            <input type="number" class="form-input" name="kkm" value="{{ old('kkm', 75) }}" min="0" max="100">
                            <p class="form-hint">Kriteria Ketuntasan Minimal (0-100)</p>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-section-title">Pengaturan</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Guru Pengampu</label>
                            <select class="form-select" name="guru_id">
                                <option value="">-- Pilih Guru --</option>
                                @foreach($guruList as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }} ({{ $g->mapel }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jam Per Minggu</label>
                            <input type="number" class="form-input" name="jam_minggu" value="{{ old('jam_minggu', 2) }}" min="1" max="10">
                        </div>
                        <div class="form-group--full form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-input" name="deskripsi" rows="3" placeholder="Deskripsi singkat mata pelajaran (opsional)" data-max-chars="300">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.mapel.index') }}" class="btn-cancel-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection