<?php

namespace App\Models;

use CodeIgniter\Model;

class TujuanPembelajaranModel extends Model
{
  protected $table = 'tujuan_pembelajaran';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nama',
    'capaian',
    'urut',
    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getWithCapaianPembelajaran($setting)
  {
    return $this->select('tujuan_pembelajaran.id as tujuan_id, tujuan_pembelajaran.nama as tujuan_nama, capaian_pembelajaran.*')
      ->join('capaian_pembelajaran', 'capaian_pembelajaran.id = tujuan_pembelajaran.capaian')
      ->where('capaian_pembelajaran.setting', $setting)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getRecordsByIds(array $ids)
  {
    return $this->whereIn($this->primaryKey, $ids)->findAll();
  }

  public function getRecordsByIdsGroupedByCapaian($ids)
  {
    if (empty($ids)) {
      return [];
    }

    $results = $this->select('tujuan_pembelajaran.*, capaian_pembelajaran.nama as nama_capaian_pembelajaran')
      ->join('capaian_pembelajaran', 'capaian_pembelajaran.id = tujuan_pembelajaran.capaian')
      ->whereIn('tujuan_pembelajaran.id', $ids)
      ->orderBy('capaian_pembelajaran.id', 'ASC')
      ->findAll();

    // Group manually di PHP jika diperlukan
    $grouped = [];
    foreach ($results as $row) {
      $grouped[$row['nama_capaian_pembelajaran']][] = $row;
    }

    return $results; // atau return $grouped jika ingin hasil terkelompok
  }
}
