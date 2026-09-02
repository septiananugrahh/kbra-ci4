---
created: 2026-09-02
---
# Modul Ajar

## Overview
Manajemen modul ajar / RPP per kelas, pekan, dan tema.

## Database
- **Tabel**: `modul_ajar`
- **Field**: id, kelas_id, dibuat_tanggal, semester, pekan, model_pembelajaran, tema_pembelajaran, topik_pembelajaran, deskripsi_pembelajaran, tujuan_pembelajaran (JSON array id TP), foto_mediaPembelajaran, deskripsi_mediaPembelajaran, subTopik_tanggal1-5, subTopik_1-5, deleted, created_at, updated_at

## Backend
- **Controller**: `ModulAjar.php`
- **Model**: `ModulAjarModel.php`
- **Route**: `/modulajar` (CRUD)
- **Route**: `/modulajar/customize/(:num)` — kustomisasi tampilan
- **Route**: `/modulajar/generate-pdf`, `preview-pdf`, `generate-docx`
- **Filter**: `auth`

## Business Rules
- `tujuan_pembelajaran` disimpan sebagai JSON array berisi id TP
- Subtopik hingga 5 (masing-masing punya tanggal)
- Model pembelajaran: Daring/Luring
- Export: PDF (DomPDF) & DOCX

## Belum diketahui
- Mekanisme preview PDF (halaman vs langsung)
