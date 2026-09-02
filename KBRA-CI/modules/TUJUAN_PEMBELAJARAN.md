---
created: 2026-09-02
---
# Tujuan Pembelajaran

## Overview
Manajemen capaian pembelajaran (CP) dan tujuan pembelajaran (TP) — Kurikulum Merdeka PAUD.

## Database
- **Tabel**: `capaian_pembelajaran`, `tujuan_pembelajaran`
- **capaian_pembelajaran**: id, nama, urut, setting, deleted
  - 3 CP: Nilai Agama dan Budi Pekerti, Jati Diri, Dasar-dasar Literasi
- **tujuan_pembelajaran**: id, capaian (FK ke CP), nama, urut, deleted
  - 45+ TP terverifikasi

## Backend
- **Controller**: `TujuanPembelajaran.php`
- **Model**: `CapaianPembelajaranModel.php`, `TujuanPembelajaranModel.php`
- **Route**: `/tujuanpembelajaran` (CRUD CP), `/tujuanpembelajaran/tp/(:num)` (CRUD TP per CP)
- **Fitur**: Salin data TP antar semester
- **Filter**: `auth`

## Business Rules
- CP sebagai parent dari TP (relasi `capaian` → `capaian_pembelajaran.id`)
- `deleted` field untuk soft delete
- `setting` field — detail belum diketahui

## Belum diketahui
- Fungsi field `setting` di tabel capaian_pembelajaran
