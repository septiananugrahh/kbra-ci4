<?php

namespace App\Models;

use CodeIgniter\Model;

class SemesterModel extends Model
{
  protected $table = 'semester';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'semester',
    'tahun',
    'tingkat',
    'kepala',
    'tanggal_rapor',
    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getSemesterWithGuru()
  {
    return $this->select('semester.*, guru.nama as nama_kepala')
      ->join('guru', 'guru.id = semester.kepala', 'left')
      ->findAll();
  }
}
