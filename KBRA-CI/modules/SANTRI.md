---
created: 2026-09-02
---
# Santri

## Overview
Manajemen data santri (murid KB/RA).

## Database
- **Tabel**: `santri`
- **Field**: id, nama, nis_lokal, nisn, nik, jenis_kelamin, tempat_lahir, tanggal_lahir, telp, alamat, nama_ayah, nama_ibu, pekerjaan_ayah, pekerjaan_ibu, foto_santri, jenjang, status, deleted

## Backend
- **Controller**: `Santri.php`
- **Model**: `SantriModel.php`
- **Route**: `/santri` (CRUD via POST `simpandata`, `ubahdata`, `hapusdata_soft`)
- **Fitur**: import Excel, ubah jenjang massal, simpan bulk
- **Filter**: `auth`, `role:3` untuk simpan/hapus/import, `role:4` untuk ambil data by kelas

## Business Rules
- Soft delete via field `deleted`
- Jenjang: KB, RA
- Status: 1 (aktif)

## Belum diketahui
- Format import Excel (kolom apa saja)
- Validasi NISN/NIK
