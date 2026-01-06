<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
  protected $table = 'kelas';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'jenjang',
    'tingkat',
    'nama',
    'set',
    'tahun',
    'wali',
    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getKelasWithSemester()
  {
    return $this->select('kelas.*, kelas.tingkat AS kelas_tingkat, kelas.id AS kelas_id');
  }
}
