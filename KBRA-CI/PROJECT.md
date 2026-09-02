---
created: 2026-09-02
---
# KBRA - Knowledge Base RA / KB Islamic Center

## Deskripsi
Aplikasi administrasi sekolah/madrasah tingkat TK/KB (KB/RA Islamic Center).

## Tujuan
Manajemen data santri, pegawai, kelas, modul ajar, asesmen perkembangan anak, capaian pembelajaran, dan laporan bulanan.

## Stack Teknologi
- **Backend**: PHP 8.2, CodeIgniter 4
- **Database**: MariaDB 10.4 (MySQL)
- **Frontend**: Bootstrap 5, Sneat Template, jQuery
- **PDF**: DomPDF
- **Server**: Laragon (Apache + MySQL)

## Lokasi
- **Webroot**: `d:\laragon\www\kbra-ci`
- **Database**: `new_kbra`

## Modul Teridentifikasi
- [[modules/SANTRI]] — Manajemen data santri
- [[modules/KELAS]] — Manajemen kelas dan jenjang
- [[modules/PEGAWAI]] — Manajemen pegawai/guru
- [[modules/MODUL_AJAR]] — Modul ajar pembelajaran
- [[modules/ASESMEN]] — Asesmen perkembangan anak (4 jenis)
- [[modules/TUJUAN_PEMBELAJARAN]] — Capaian & tujuan pembelajaran
- [[modules/DIMENSI_PROFIL_LULUSAN]] — Dimensi profil lulusan (Kurikulum Merdeka)
- [[modules/KURIKULUM_CINTA]] — Kurikulum cinta/karakter
- [[modules/LAPORAN_BULANAN]] — Laporan perkembangan bulanan

## Modus Operasi
- **Role**: Tata Usaha (id=3), Guru (id=4)
- **Auth**: Session-based, filter `auth` & `role:{id}`
- **CSRF**: Active on `login/auth`

## Related Notes
- [[ARCHITECTURE]]
- [[DECISIONS]]
- [[TODO]]
- [[BUGS]]
