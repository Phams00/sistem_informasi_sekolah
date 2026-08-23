@extends('layouts.app')

@section('title', 'Edit Guru - SIS')
@section('breadcrumb', 'Data Guru / Edit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')

<div class="form-page fade-up">
    <div class="form-page-header">
        <a href="{{ route('admin.guru.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Edit Data Guru</h1>
            <p class="form-page-subtitle">Perbarui informasi {{ $guru->nama }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.guru.update', $guru->id) }}">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                <div class="form-card-header-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <span class="form-card-header-text">Edit Informasi Guru</span>
            </div>
            <div class="form-card-body">
                <div class="form-section">
                    <div class="form-section-title">Data Diri</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nama" value="{{ old('nama', $guru->nama) }}" data-validate="required|min:3">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-input" name="nip" value="{{ old('nip', $guru->nip) }}" data-validate="numeric" maxlength="20">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-input" name="email" value="{{ old('email', $guru->email) }}" data-validate="required|email">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" class="form-input" name="telepon" value="{{ old('telepon', $guru->telepon) }}" data-validate="numeric" maxlength="15">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-radio-group">
                                <label class="form-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'L' ? 'checked' : '' }}>
                                    Laki-laki
                                </label>
                                <label class="form-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'P' ? 'checked' : '' }}>
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-input" name="ttl" value="{{ old('ttl', $guru->ttl) }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Profesional</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mata Pelajaran <span class="required">*</span></label>
                            <select class="form-select" name="mapel" data-validate="required">
                                <option value="">-- Pilih --</option>
                                @foreach($mapelList as $m)
                                    <option value="{{ $m }}" {{ old('mapel', $guru->mapel) === $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-input" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}">
                        </div>
                        <div class="form-group--full form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-input" name="alamat" rows="3" data-max-chars="500">{{ old('alamat', $guru->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card-footer">
                <a href="{{ route('admin.guru.index') }}" class="btn-cancel-form">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 16px rgba(245,158,11,0.25);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Perbarui Data
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
@endsection