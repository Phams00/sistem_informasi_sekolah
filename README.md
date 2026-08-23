# Sistem Informasi Sekolah

Aplikasi manajemen sekolah berbasis Laravel — mengelola data guru, siswa, mata pelajaran, jadwal, nilai, dan absensi, lengkap dengan sistem login admin.

## Fitur

- CRUD Data Guru & Siswa
- Manajemen Mata Pelajaran & Jadwal Pelajaran
- Input Nilai (Tugas, UTS, UAS) per kelas & semester
- Rekap Absensi harian per kelas
- Autentikasi (Login & Registrasi akun)

## Teknologi

- Laravel 13
- MySQL
- Blade Templating

## Cara Install

1. Clone repo ini:
```bash
   git clone <url-repo-kamu>
   cd daftar_guru
```

2. Install dependency:
```bash
   composer install
```

3. Duplikat file environment, lalu generate application key:
```bash
   cp .env.example .env
   php artisan key:generate
```

4. Sesuaikan koneksi database di `.env`:
   DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=


5. Jalankan migration **beserta seeder** (⚠️ wajib, tanpa ini tidak ada akun untuk login):
```bash
   php artisan migrate --seed
```

6. Jalankan server:
```bash
   php artisan serve
```

## Login

Setelah migrate + seed, gunakan akun default:
- **Email**: `admin@sekolah.com`
- **Password**: `rahasia123`

Atau, kalau kamu lupa jalankan seeder / mau buat akun baru, buka halaman **`/register`** untuk daftar akun sendiri.

## Struktur Role

| Role | Keterangan |
|---|---|
| `admin` | Akses penuh ke semua modul |
| `guru` | (belum dibatasi hak aksesnya — semua role saat ini punya akses sama) |
| `tu` | (belum dibatasi hak aksesnya — semua role saat ini punya akses sama) |

> Catatan: kolom `role` sudah tersedia di database, tapi pembatasan hak akses per role **belum diterapkan** di aplikasi ini — semua user yang login (apapun role-nya) saat ini punya akses yang sama ke semua menu.
