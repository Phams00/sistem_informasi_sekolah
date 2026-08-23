@extends('layouts.app')

@section('title', 'Tambah Guru - SIS')
@section('breadcrumb', 'Data Guru / Tambah')

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
            <h1 class="form-page-title">Tambah Guru Baru</h1>
            <p class="form-page-subtitle">Isi data lengkap guru yang akan ditambahkan</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.guru.store') }}" id="formGuru">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <span class="form-card-header-text">Informasi Pribadi</span>
            </div>
            <div class="form-card-body">
                <div class="form-section">
                    <div class="form-section-title">Data Diri</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" data-validate="required|min:3" autofocus>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-input" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP" data-validate="numeric" maxlength="20">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-input" name="email" value="{{ old('email') }}" placeholder="contoh@smkn2.sch.id" data-validate="required|email">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" class="form-input" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx" data-validate="numeric" maxlength="15">
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-radio-group">
                                <label class="form-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'checked' : '' }}>
                                    Laki-laki
                                </label>
                                <label class="form-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }}>
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-input" name="ttl" value="{{ old('ttl') }}" placeholder="Kota, DD MM YYYY">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Profesional</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mata Pelajaran <span class="required">*</span></label>
                            <select class="form-select" name="mapel" data-validate="required">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mapelList as $m)
                                    <option value="{{ $m }}" {{ old('mapel') === $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                            <span class="form-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-input" name="jabatan" value="{{ old('jabatan') }}" placeholder="Guru / Kepala Sekolah / Wakil, dll">
                        </div>
                        <div class="form-group--full form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-input" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" data-max-chars="500">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card-footer">
                <a href="{{ route('admin.guru.index') }}" class="btn-cancel-form">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batal
                </a>
                <button type="submit" class="btn-submit-form">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
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