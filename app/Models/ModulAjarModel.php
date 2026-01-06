<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulAjarModel extends Model
{
  protected $table = 'modul_ajar';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true; // ✅ Pastikan true
  protected $allowedFields = [
    'kelas_id',
    'dibuat_tanggal',
    'semester',
    'pekan',
    'model_pembelajaran',
    'topik_pembelajaran',
    'subtopik_pembelajaran',
    'tujuan_pembelajaran',
    'dimensi_profil_lulusan',
    'kurikulum_cinta',
    'foto_mediaPembelajaran',
    'deskripsi_mediaPembelajaran',

    'subsubTopik_tanggal1',
    'subsubTopik_1',
    'pembukaan_1',
    'kegiatan_inti_1',
    'pertanyaan_pemantik_1',

    'subsubTopik_tanggal2',
    'subsubTopik_2',
    'pembukaan_2',
    'kegiatan_inti_2',
    'pertanyaan_pemantik_2',

    'subsubTopik_tanggal3',
    'subsubTopik_3',
    'pembukaan_3',
    'kegiatan_inti_3',
    'pertanyaan_pemantik_3',

    'subsubTopik_tanggal4',
    'subsubTopik_4',
    'pembukaan_4',
    'kegiatan_inti_4',
    'pertanyaan_pemantik_4',

    'subsubTopik_tanggal5',
    'subsubTopik_5',
    'pembukaan_5',
    'kegiatan_inti_5',
    'pertanyaan_pemantik_5',

    'mediapembelajaran_1',
    'mediapembelajaran_2',
    'mediapembelajaran_3',
    'mediapembelajaran_4',
    'mediapembelajaran_5',

    'merefleksi_1',
    'merefleksi_2',
    'merefleksi_3',
    'merefleksi_4',
    'merefleksi_5',

    'pembuat',

    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];
}
