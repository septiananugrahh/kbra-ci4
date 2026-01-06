<?php

namespace App\Models;

use CodeIgniter\Model;

class KurikulumCintaModel extends Model
{
  protected $table = 'kurikulum_cinta';
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
