---
created: 2026-09-02
---
# Asesmen

## Overview
Asesmen perkembangan anak — 4 jenis penilaian.

## Database
- **Tabel**: `asesmen_anekdot`, `asesmen_checklist`, `asesmen_fotoberseri`, `asesmen_hasilkarya`
- **asesmen_anekdot**: id, santri, kelas, semester, modul_ajar_id, tanggal, tempat, peristiwa, keterangan
- **asesmen_checklist**: id, santri, kelas, semester, modul_ajar_id, tanggal, isi (JSON array: [{id, status}])
- **asesmen_fotoberseri**: id, santri, kelas, semester, modul_ajar_id, tanggal, foto1-3, ket_foto1-3, analisis_guru, umpan_balik, rotation_foto1-3
- **asesmen_hasilkarya**: id, santri, kelas, semester, modul_ajar_id, tanggal, kegiatan, foto, catatan, rotation_foto

## Backend
- **Controller**: `Asesmen.php`
- **Model**: `AsesmenAnekdotModel.php`, `AsesmenChecklistModel.php`, `AsesmenFotoBerseriModel.php`, `AsesmenHasilKaryaModel.php`
- **Route**: `/asesmen/index/(:num)`, `/asesmen/form/(:num)`, simpan, getData, hapus, download
- **Filter**: `auth`

## Business Rules
- Checklist status: `sudah_muncul` / `belum_muncul`
- Foto berseri: maks 3 foto + analisis guru + umpan balik
- Hasil karya: kegiatan + foto + catatan
- Image compression & rotation support
- Download: `/asesmen/download/(:num)/(:num)/(:segment)`

## Jenis Asesmen
1. **Anekdot** — Catatan peristiwa harian (tempat, peristiwa, keterangan)
2. **Checklist** — Ceklis capaian TP (sudah/belum muncul)
3. **Foto Berseri** — Dokumentasi foto berseri + analisis
4. **Hasil Karya** — Dokumentasi hasil karya anak
