---
created: 2026-09-02
---
# Kelas

## Overview
Manajemen kelas/ruang kelas dan penempatan santri & guru.

## Database
- **Tabel**: `kelas`, `ruang_kelas`, `guru_kelas`
- **kelas**: id, jenjang, tingkat, nama, set, wali, deleted
- **ruang_kelas**: id, kelas_id, santri_id (relasi santri↔kelas)
- **guru_kelas**: id, kelas_id, guru_id (relasi guru↔kelas)

## Backend
- **Controller**: `Kelas.php`
- **Model**: `KelasModel.php`, `RuangKelasModel.php`, `GuruKelasModel.php`
- **Route**: `/kelas` (CRUD + wali kelas)
- **Fitur**: tambah/hapus santri dari kelas, tambah/hapus guru dari kelas, get santri/guru by kelas
- **Filter**: `auth`

## Business Rules
- Jenjang: KB, RA
- Tingkat: A, B (contoh data: RA-A Matahari, RA-A Bulan)
- `set` dan `wali` field — detail belum diverifikasi

## Belum diketahui
- Mekanisme field `set`
- Aturan pemilihan wali kelas
