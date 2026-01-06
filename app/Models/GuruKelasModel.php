<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruKelasModel extends Model
{
  protected $table = 'guru_kelas';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'guru_id',
    'kelas_id',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getKelasByGuru($guruId)
  {
    return $this->db->table('guru_kelas gk')
      ->select('k.id, k.nama, k.tingkat, k.jenjang')
      ->join('kelas k', 'k.id = gk.kelas_id')
      ->where('gk.guru_id', $guruId)
      ->get()
      ->getResultArray();
  }
}
