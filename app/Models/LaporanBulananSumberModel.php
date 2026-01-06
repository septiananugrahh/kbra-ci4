<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanBulananSumberModel extends Model
{
  protected $table = 'laporan_bulanan_sumber';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'laporan_bulanan_detail_id',
    'jenis_asesmen',
    'asesmen_id',
    'tanggal_asesmen'
  ];
  protected $useTimestamps = false;

  /**
   * Simpan sumber data untuk tracking
   */
  public function insertBatchSumber($data)
  {
    return $this->insertBatch($data);
  }

  /**
   * Ambil sumber berdasarkan detail_id
   */
  public function getSumberByDetailId($detail_id)
  {
    return $this->where('laporan_bulanan_detail_id', $detail_id)->findAll();
  }
}
