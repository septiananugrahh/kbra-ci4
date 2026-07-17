<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
  protected $table = 'santri';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nama',
    'nis_lokal',
    'nisn',
    'nik',
    'jenis_kelamin',
    'tempat_lahir',
    'tanggal_lahir',
    'telp',
    'alamat',
    'nama_ayah',
    'nama_ibu',
    'pekerjaan_ayah',
    'pekerjaan_ibu',
    'foto_santri',
    'jenjang',
    'status',
    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getSantriByFilter($tahun = null, $kelasId = null, $jenjang = null)
  {
    $db = \Config\Database::connect();

    // Kelompok A: santri yang punya baris ruang_kelas, dengan kelas.tahun sesuai filter
    $builderA = $db->table('santri s')
      ->select('s.*, rk.kelas_id, k.nama AS nama_kelas, k.tahun AS tahun')
      ->join('ruang_kelas rk', 'rk.santri_id = s.id')
      ->join('kelas k', 'k.id = rk.kelas_id', 'left')
      ->where('s.deleted', 0);

    if ($tahun) {
      $builderA->where('k.tahun', $tahun);
    } else {
      // tanpa filter tahun, tetap hanya ambil yang punya kelas
      $builderA->where('rk.id IS NOT NULL');
    }

    if ($kelasId) {
      $builderA->where('rk.kelas_id', $kelasId);
    }

    $resultA = $builderA->get()->getResultArray();

    // Kelompok B: santri tanpa kelas sama sekali, jenjang KB/RA
    $resultB = [];
    if (!$kelasId) {
      $resultB = $db->table('santri s')
        ->select('s.*, NULL AS kelas_id, NULL AS nama_kelas, NULL AS tahun')
        ->where('s.deleted', 0)
        ->whereIn('s.jenjang', ['KB', 'RA'])
        ->where("NOT EXISTS (SELECT 1 FROM ruang_kelas rk2 WHERE rk2.santri_id = s.id)", null, false)
        ->get()->getResultArray();
    }

    $result = array_merge($resultA, $resultB);

    if ($jenjang) {
      $result = array_values(array_filter($result, fn($row) => $row['jenjang'] === $jenjang));
    }

    return $result;
  }
}
