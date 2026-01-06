<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanBulananDetailModel extends Model
{
  protected $table = 'laporan_bulanan_detail';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'laporan_bulanan_id',
    'santri_id',
    'capaian_pembelajaran_id',
    'keterangan',
    'urutan'
  ];
  protected $useTimestamps = false;

  /**
   * Ambil semua detail laporan berdasarkan laporan_id
   */
  public function getDetailByLaporanId($laporan_id)
  {
    return $this->select('laporan_bulanan_detail.*, 
                             santri.nama as santri_nama, 
                             santri.foto_santri as santri_foto,
                             capaian_pembelajaran.nama as capaian_nama,
                             capaian_pembelajaran.warna as capaian_warna')
      ->join('santri', 'santri.id = laporan_bulanan_detail.santri_id', 'left')
      ->join('capaian_pembelajaran', 'capaian_pembelajaran.id = laporan_bulanan_detail.capaian_pembelajaran_id', 'left')
      ->where('laporan_bulanan_id', $laporan_id)
      ->orderBy('santri_id', 'ASC')
      ->orderBy('capaian_pembelajaran_id', 'ASC')
      ->orderBy('urutan', 'ASC')
      ->findAll();
  }

  /**
   * Ambil detail per santri dan capaian (untuk edit/tampil)
   */
  public function getDetailBySantriCapaian($laporan_id, $santri_id, $capaian_id)
  {
    return $this->where([
      'laporan_bulanan_id' => $laporan_id,
      'santri_id' => $santri_id,
      'capaian_pembelajaran_id' => $capaian_id
    ])->orderBy('urutan', 'ASC')->findAll();
  }

  /**
   * Ambil data terstruktur untuk santri (grouped by santri dan capaian)
   */
  public function getDetailGroupedBySantri($laporan_id)
  {
    $details = $this->getDetailByLaporanId($laporan_id);
    $grouped = [];

    foreach ($details as $detail) {
      $santri_id = $detail['santri_id'];
      $capaian_id = $detail['capaian_pembelajaran_id'];

      if (!isset($grouped[$santri_id])) {
        $grouped[$santri_id] = [
          'santri_nama' => $detail['santri_nama'],
          'santri_foto' => $detail['santri_foto'],
          'capaian' => []
        ];
      }

      if (!isset($grouped[$santri_id]['capaian'][$capaian_id])) {
        $grouped[$santri_id]['capaian'][$capaian_id] = [
          'nama' => $detail['capaian_nama'],
          'warna' => $detail['capaian_warna'],
          'keterangan' => []
        ];
      }

      if (!empty($detail['keterangan'])) {
        $grouped[$santri_id]['capaian'][$capaian_id]['keterangan'][] = [
          'id' => $detail['id'],
          'keterangan' => $detail['keterangan'],
          'urutan' => $detail['urutan']
        ];
      }
    }

    return $grouped;
  }

  /**
   * Ambil data terstruktur untuk PDF (format berbeda dari edit)
   */
  public function getDetailGroupedForPDF($laporan_id)
  {
    $details = $this->getDetailByLaporanId($laporan_id);
    $grouped = [];

    foreach ($details as $detail) {
      $santri_id = $detail['santri_id'];
      $capaian_id = $detail['capaian_pembelajaran_id'];

      if (!isset($grouped[$santri_id])) {
        $grouped[$santri_id] = [
          'nama' => $detail['santri_nama'],
          'capaian' => []
        ];
      }

      if (!isset($grouped[$santri_id]['capaian'][$capaian_id])) {
        $grouped[$santri_id]['capaian'][$capaian_id] = [];
      }

      if (!empty($detail['keterangan'])) {
        // Format simple untuk PDF - hanya string keterangan
        $grouped[$santri_id]['capaian'][$capaian_id][] = $detail['keterangan'];
      }
    }

    return $grouped;
  }

  /**
   * Hapus semua detail berdasarkan laporan_id
   */
  public function deleteByLaporanId($laporan_id)
  {
    return $this->where('laporan_bulanan_id', $laporan_id)->delete();
  }

  /**
   * Insert batch untuk detail laporan
   */
  public function insertBatchDetails($data)
  {
    return $this->insertBatch($data);
  }
}
