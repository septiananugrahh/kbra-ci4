---
created: 2026-09-02
---
# Laporan Bulanan

## Overview
Laporan perkembangan santri per bulan — digenerate dari data asesmen 4 jenis.

## Database
- **Tabel**: `laporan_bulanan` (model: `LaporanBulananModel`), `laporan_bulanandetail` (model: `LaporanBulananDetailModel`), `laporan_bulanansumber` (model: `LaporanBulananSumberModel`)
- Tabel tidak ditemukan di `new_kbra.sql` — kemungkinan ditambah via migration atau manual.

## Backend
- **Controller**: `LaporanBulanan.php`
- **Models**: `LaporanBulananModel`, `LaporanBulananDetailModel`, `LaporanBulananSumberModel`
- **Route**: `/laporan-bulanan/` (group routes)
  - `GET /` — index (daftar laporan)
  - `GET /get-data` — ambil data laporan
  - `POST /generate` — generate laporan dari asesmen
  - `GET /edit/(:num)` — edit laporan
  - `POST /update-detail`, `POST /add-detail`, `POST /delete-detail`
  - `DELETE /delete/(:num)` — hapus laporan
  - `GET /download-pdf/(:num)` — download PDF laporan kelas
  - `GET /download-pdf-per-santri/(:num)/(:num)` — download PDF per santri
  - `POST /preview-pdf-direct`, `POST /generate-pdf` — kustomisasi & cetak
- **Filter**: `auth`

## Business Rules
- Laporan digenerate dari data asesmen (checklist, anekdot, hasil karya, foto berseri) per bulan
- Filter by bulan, tahun, semester
- Preview PDF dengan kustomisasi
- Export per kelas atau per santri
- Data disimpan di `laporan_bulanandetail` sebagai detail

## Alur Generate
1. Guru pilih kelas, bulan, tahun
2. Sistem query data asesmen 4 jenis untuk kelas tersebut
3. Filter data berdasarkan bulan target
4. Insert ke `laporan_bulanan` + `laporan_bulanandetail`
5. Hasil dapat diedit, ditambah, atau dihapus detailnya
6. Export PDF (per kelas atau per santri)

## Belum diketahui
- Struktur tepat tabel `laporan_bulanan` dan `laporan_bulanandetail`
