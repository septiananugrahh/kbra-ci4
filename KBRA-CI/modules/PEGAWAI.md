---
created: 2026-09-02
---
# Pegawai

## Overview
Manajemen pegawai/guru dan pemberian role.

## Database
- **Tabel**: `guru`, `user_level_list` (relasi user↔role)
- **guru**: id, nama, username, password (bcrypt), tempat_lahir, tanggal_lahir, alamat, token, deleted
- **user_level_list**: id, user, type

## Backend
- **Controller**: `Pegawai.php`
- **Model**: `UserModel.php` (table `guru`), `RoleModel.php`, `UserRoleModel.php`
- **Route**: `/pegawai` (CRUD + role assignment)
- **Fitur**: CRUD pegawai, tambah/hapus role user, get all roles
- **Filter**: `auth`

## Business Rules
- `guru` berfungsi sebagai tabel user sekaligus pegawai
- Password di-hash bcrypt
- Role assignment melalui `user_level_list`

## Belum diketahui
- Apakah ada pemisahan pegawai non-guru (staf TU)?
