<?php

namespace App\Models;

use CodeIgniter\Model;

class DimensiProfilModel extends Model
{
  protected $table = 'dimensi_profil_lulusan';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nama',
    'setting',
    'deleted'
  ];

  public function getRecordsByIds(array $ids)
  {
    if (empty($ids)) {
      return []; // atau bisa juga return null atau exception, tergantung kebutuhan
    }
    return $this->whereIn($this->primaryKey, $ids)->findAll();
  }
}
