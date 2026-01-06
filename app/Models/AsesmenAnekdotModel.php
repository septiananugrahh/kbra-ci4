<?php

namespace App\Models;

use CodeIgniter\Model;

class AsesmenAnekdotModel extends Model
{
  protected $table = 'asesmen_anekdot';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'santri',
    'kelas',
    'semester',
    'modul_ajar_id',
    'tanggal',
    'tempat',
    'peristiwa',
    'keterangan',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getAnekdotDetail($modulAjarId, $tanggalKolom)
  {
    $modulAjarTable = $this->db->table('modul_ajar');
    $modulAjarTanggal = $modulAjarTable->select($tanggalKolom)
      ->where('id', $modulAjarId)
      ->get()
      ->getRow();

    if (!$modulAjarTanggal) {
      return null; // Modul ajar atau tanggal tidak ditemukan
    }

    $tanggalVal = $modulAjarTanggal->$tanggalKolom;

    // Ini akan mengembalikan array dari semua baris yang cocok
    return $this->select('asesmen_anekdot.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_anekdot.santri')
      ->join('kelas', 'kelas.id = asesmen_anekdot.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_anekdot.modul_ajar_id')
      ->where('asesmen_anekdot.modul_ajar_id', $modulAjarId)
      ->where('asesmen_anekdot.tanggal', $tanggalVal)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getAnekdotDetailByModulAjar($modulAjarId)
  {
    return $this->select('asesmen_anekdot.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_anekdot.santri')
      ->join('kelas', 'kelas.id = asesmen_anekdot.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_anekdot.modul_ajar_id')
      ->where('asesmen_anekdot.modul_ajar_id', $modulAjarId)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getAnekdotDetailWithSantri($kelas)
  {
    return $this->select('asesmen_anekdot.*, santri.nama as santri_nama, santri.id as santri_id')
      ->join('santri', 'santri.id = asesmen_anekdot.santri')
      ->where('asesmen_anekdot.kelas', $kelas)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }
}
