@extends('layouts.app')

@section('title', 'Input Nilai - SIS')
@section('breadcrumb', 'Nilai Siswa / Input')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .nilai-input-table { width:100%; border-collapse:collapse; }
        .nilai-input-table thead th { padding:12px 16px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--muted); background:#f8faf7; border-bottom:1px solid var(--border); text-align:left; }
        .nilai-input-table tbody td { padding:10px 16px; border-bottom:1px solid #eef2ee; vertical-align:middle; }
        .nilai-input-table .nilai-input { width:80px; padding:8px 10px; border:1.5px solid var(--border); border-radius:8px; font-size:14px; font-weight:600; text-align:center; font-family:'Space Grotesk',sans-serif; outline:none; transition:all 0.2s; }
        .nilai-input-table .nilai-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(13,148,136,0.1); }
        .nilai-input-table .nilai-input.is-low { border-color:var(--danger); background:rgba(220,38,38,0.03); }
        .nilai-na { font-family:'Space Grotesk',sans-serif; font-size:16px; font-weight:700; text-align:center; min-width:50px; }
        @media(max-width:768px){ .nilai-input-table{font-size:12px;} .nilai-input-table .nilai-input{width:60px;padding:6px;} }
    </style>
@endsection

@section('content')

<div class="fade-up">
    <div class="form-page-header" style="margin-bottom:24px;">
        <a href="{{ route('admin.nilai.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="form-page-title">Input Nilai Siswa</h1>
            <p class="form-page-subtitle">Masukkan nilai untuk kelas <strong style="color:var(--fg);">{{ $selectedKelas }}</strong> &middot; {{ $selectedMapel->nama ?? 'Semua Mapel' }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.nilai.store') }}" id="formNilai">
        @csrf
        <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
        <input type="hidden" name="mapel_id" value="{{ $selectedMapel->id ?? '' }}">
        <input type="hidden" name="semester" value="{{ $semester }}">

        <div class="guru-table-card">
            <div style="overflow-x:auto;">
                <table class="nilai-input-table">
                    <thead>
                        <tr>
                            <th style="width:40px;">No</th>
                            <th>Nama Siswa</th>
                            <th style="width:100px;text-align:center;">Tugas (30%)</th>
                            <th style="width:100px;text-align:center;">UTS (30%)</th>
                            <th style="width:100px;text-align:center;">UAS (40%)</th>
                            <th style="width:80px;text-align:center;">NA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswas as $i => $s)
                            @php $existing = $existingNilai[$s->id] ?? null; @endphp
                            <tr>
                                <td style="font-weight:600;color:var(--muted);font-size:13px;">{{ $i + 1 }}</td>
                                <td>
                                    <div class="guru-name-cell" style="font-size:14px;">
                                        <div class="guru-avatar" style="width:30px;height:30px;font-size:11px;border-radius:8px;background:{{ ['#0d9488','#f59e0b','#06b6d4','#8b5cf6','#f43f5e','#10b981'][$i % 6] }};">{{ strtoupper(substr($s->nama,0,1)) }}</div>
                                        {{ $s->nama }}
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <input type="number" class="nilai-input" name="tugas[{{ $s->id }}]" value="{{ old('tugas.'.$s->id, $existing->tugas ?? '') }}" min="0" max="100" data-siswa="{{ $s->id }}" data-type="tugas">
                                </td>
                                <td style="text-align:center;">
                                    <input type="number" class="nilai-input" name="uts[{{ $s->id }}]" value="{{ old('uts.'.$s->id, $existing->uts ?? '') }}" min="0" max="100" data-siswa="{{ $s->id }}" data-type="uts">
                                </td>
                                <td style="text-align:center;">
                                    <input type="number" class="nilai-input" name="uas[{{ $s->id }}]" value="{{ old('uas.'.$s->id, $existing->uas ?? '') }}" min="0" max="100" data-siswa="{{ $s->id }}" data-type="uas">
                                </td>
                                <td style="text-align:center;">
                                    <div class="nilai-na" id="na-{{ $s->id }}" style="color:var(--muted);">-</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-card-footer">
                <a href="{{ route('admin.nilai.index') }}" class="btn-cancel-form">Batal</a>
                <button type="submit" class="btn-submit-form">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Semua Nilai
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
    <script src="{{ asset('js/form.js') }}"></script>
    <script>
        // Hitung NA realtime
        document.querySelectorAll('.nilai-input').forEach(function(input) {
            input.addEventListener('input', function() {
                var siswaId = this.getAttribute('data-siswa');
                var row = this.closest('tr');
                var tugas = parseFloat(row.querySelector('[data-type="tugas"]').value) || 0;
                var uts = parseFloat(row.querySelector('[data-type="uts"]').value) || 0;
                var uas = parseFloat(row.querySelector('[data-type="uas"]').value) || 0;
                var na = Math.round(tugas * 0.3 + uts * 0.3 + uas * 0.4);
                var naEl = document.getElementById('na-' + siswaId);
                if (naEl) {
                    naEl.textContent = (tugas || uts || uas) ? na : '-';
                    naEl.style.color = na >= 75 ? 'var(--success)' : (na >= 60 ? '#f59e0b' : 'var(--danger)');
                }
                // Tandai input rendah
                this.classList.toggle('is-low', this.value && parseFloat(this.value) < 60);
            });
            // Trigger initial
            input.dispatchEvent(new Event('input'));
        });
    </script>
@endsection