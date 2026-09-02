---
created: 2026-09-02
---
# Database

## Info
- **Engine**: MariaDB 10.4.32 (MySQL)
- **Charset**: utf8mb4
- **Nama DB**: `new_kbra`

## Tabel (17)

### User & Auth
- `guru` — Tabel user sekaligus data pegawai/guru
- `user_level_desc` — Deskripsi role (3=Tata Usaha, 4=Guru)
- `user_level_list` — Mapping user↔role
- `login_attempts` — Log percobaan login (ip, timestamp)

### Santri
- `santri` — Data santri/murid
- `ruang_kelas` — Relasi santri↔kelas

### Kelas
- `kelas` — Data kelas (jenjang KB/RA, tingkat)
- `guru_kelas` — Relasi guru↔kelas

### Kurikulum
- `capaian_pembelajaran` — Capaian Pembelajaran (CP)
- `tujuan_pembelajaran` — Tujuan Pembelajaran (TP)
- `modul_ajar` — Modul ajar/RPP

### Asesmen
- `asesmen_anekdot` — Asesmen anekdot
- `asesmen_checklist` — Asesmen checklist
- `asesmen_fotoberseri` — Asesmen foto berseri
- `asesmen_hasilkarya` — Asesmen hasil karya

### System
- `migrations` — Migration tracking

## Catatan
- Beberapa tabel mungkin tidak ada di dump SQL: `laporan_bulanan`, `laporan_bulanandetail`, `laporan_bulanansumber` (model ada, dump tidak). Bisa ditambah manual atau via migration.
- Tabel dimensi_profil_lulusan dan kurikulum_cinta juga tidak ditemukan di dump.
