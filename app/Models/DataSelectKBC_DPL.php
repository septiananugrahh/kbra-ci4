<?php

namespace App\Models;

use CodeIgniter\Model;

class DataSelectKBC_DPL extends Model
{
  protected $table = 'data_select_dpl_kbc';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'id',
    'modulajar_id_select',

    'pembukaan_1_select',
    'inti_1_select',
    'merefleksi_1_select',

    'pembukaan_2_select',
    'inti_2_select',
    'merefleksi_2_select',

    'pembukaan_3_select',
    'inti_3_select',
    'merefleksi_3_select',

    'pembukaan_4_select',
    'inti_4_select',
    'merefleksi_4_select',

    'pembukaan_5_select',
    'inti_5_select',
    'merefleksi_5_select',
    'deleted'
  ];

  public function getRecordsByIds(array $ids)
  {
    if (empty($ids)) {
      return []; // atau bisa juga return null atau exception, tergantung kebutuhan
    }
    return $this->whereIn($this->primaryKey, $ids)->findAll();
  }

  public function getByModulajar($id)
  {
    return $this->where('modulajar_id_select', $id)->first();
  }
}
