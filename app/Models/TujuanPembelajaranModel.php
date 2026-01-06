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

  public function getRecordsByIdsGroupedByCapaian(array $ids)
  {
    return $this->select('tujuan_pembelajaran.*, capaian_pembelajaran.nama AS nama_capaian_pembelajaran') // Pilih kolom yang diperlukan, termasuk dari tabel relasi
      ->join('capaian_pembelajaran', 'tujuan_pembelajaran.capaian = capaian_pembelajaran.id', 'left') // Gunakan JOIN
      ->whereIn('tujuan_pembelajaran.' . $this->primaryKey, $ids) // Filter berdasarkan ID tujuan_pembelajaran yang diberikan
      ->groupBy('tujuan_pembelajaran.capaian') // Grouping berdasarkan kolom 'capaian' di tabel tujuan_pembelajaran
      ->findAll();
  }
}
