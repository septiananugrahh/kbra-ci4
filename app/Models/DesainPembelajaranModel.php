<?php

namespace App\Models;

use CodeIgniter\Model;

class DesainPembelajaranModel extends Model
{
  protected $table = 'desain_pembelajaran';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'id',
    'modulajar_id_dp',
    'pedagogik_model',
    'pedagogik_strategi',
    'pedagogik_metode',
    'kemitraan',
    'ruang_fisik',
    'ruang_virtual',
    'pemanfaatan_digital',
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
