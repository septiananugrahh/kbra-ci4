<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanBulananModel extends Model
{
  protected $table = 'laporan_bulanan';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = [
    'kelas_id',
    'bulan',
    'tahun',
    'semester',
    'nama_bulan',
    'dibuat_oleh',
    'dibuat_pada',
    'diupdate_pada',
    'status'
  ];
  protected $useTimestamps = false;
  protected $validationRules = [
    'kelas_id' => 'required|integer',
    'bulan' => 'required|max_length[2]',
    'tahun' => 'required|max_length[9]',
    'semester' => 'required|max_length[10]',
    'nama_bulan' => 'required|max_length[20]',
    'dibuat_oleh' => 'required|integer'
  ];

  /**
   * Ambil semua laporan berdasarkan kelas, tahun, dan semester
   */
  public function getLaporanByKelas($kelas_id, $tahun, $semester)
  {
    return $this->select('laporan_bulanan.*, guru.nama as pembuat_nama')
      ->join('guru', 'guru.id = laporan_bulanan.dibuat_oleh', 'left')
      ->where('kelas_id', $kelas_id)
      ->where('tahun', $tahun)
      ->where('semester', $semester)
      ->orderBy('bulan', 'ASC')
      ->findAll();
  }

  /**
   * Cek apakah laporan sudah ada
   */
  public function isLaporanExist($kelas_id, $bulan, $tahun, $semester)
  {
    return $this->where([
      'kelas_id' => $kelas_id,
      'bulan' => $bulan,
      'tahun' => $tahun,
      'semester' => $semester
    ])->first();
  }

  /**
   * Ambil laporan lengkap dengan detail
   */
  public function getLaporanWithDetail($laporan_id)
  {
    $laporan = $this->find($laporan_id);
    if (!$laporan) {
      return null;
    }

    $detailModel = new LaporanBulananDetailModel();
    $laporan['details'] = $detailModel->getDetailByLaporanId($laporan_id);

    return $laporan;
  }
}
