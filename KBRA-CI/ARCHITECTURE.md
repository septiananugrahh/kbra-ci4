---
created: 2026-09-02
---
# Architecture

## Pola
CodeIgniter 4 MVC (Model-View-Controller).

## Struktur Folder
- `app/Controllers/` — 17 controller
- `app/Models/` — 23 model
- `app/Views/admin/` — 17 file view (PHP + Bootstrap 5 + Sneat)
- `app/Config/` — Konfigurasi CI4
- `app/Database/Migrations/` — Migration (1 file: rotasi foto asesmen)
- `app/Filters/` — AuthFilter, RoleFilter
- `app/Helpers/` — Helper functions
- `public/` — Entry point, assets, uploads
- `writable/` — Logs, cache, uploads, session
- `template-sneat/` — Template asset Sneat

## Alur Request
1. `public/index.php` → bootstrap CI4
2. Router (`app/Config/Routes.php`) → Controller
3. Filter `auth` → AuthFilter (cek session `logged_in`)
4. Filter `role:{id}` → RoleFilter (cek session `roles`)
5. Controller → Model → View

## Database
- **Nama**: `new_kbra`
- **Engine**: InnoDB
- **Charset**: utf8mb4
- **Tabel**: 17 tabel (lihat [[infrastructure/DATABASE]])

## Auth
- **Tabel**: `guru` (sebagai user), `user_level_list` (role mapping), `user_level_desc` (role definition)
- **Login**: username + password (bcrypt), session-based
- **Remember Me**: Cookie-based token
- **Role**: 3 = Tata Usaha, 4 = Guru
- **Filter**: `AuthFilter` & `RoleFilter`

## Frontend
- Bootstrap 5 + Sneat admin template
- jQuery untuk AJAX
- View: PHP native di `app/Views/admin/`
- Template assets di `template-sneat/`

## PDF
- DomPDF untuk cetak laporan, rapor, asesmen

## Migration
- 1 migration: `2026-09-01-010659_AddRotationToAsesmenTables` (menambah kolom rotasi foto pada tabel `asesmen_fotoberseri` dan `asesmen_hasilkarya`)

## Belum diketahui
- Apakah ada API endpoint? Tidak ditemukan route REST API.
- Apakah ada modul pembayaran/keuangan? Tidak ditemukan.
