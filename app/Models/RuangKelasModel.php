<?php

namespace App\Models;

use CodeIgniter\Model;

class RuangKelasModel extends Model
{
  protected $table = 'ruang_kelas';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'santri_id',
    'kelas_id',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getSantriByKelas($kelas_id)
  {
    return $this->select('kelas.*, santri.*, santri.nama as santri_nama, kelas.tingkat as kelas_tingkat, kelas.nama as kelas_nama') // Pilih kolom yang Anda inginkan dari kedua tabel
      ->join('santri', 'ruang_kelas.santri_id = santri.id')
      ->join('kelas', 'ruang_kelas.kelas_id = kelas.id')
      ->where('kelas.id', $kelas_id)
      ->findAll();
  }
}
