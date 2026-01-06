<?php

namespace App\Models;

use CodeIgniter\Model;

class AsesmenChecklistModel extends Model
{
  protected $table = 'asesmen_checklist';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'santri',
    'kelas',
    'semester',
    'modul_ajar_id',
    'tanggal',
    'isi',
    'konteks',
    'tempat_waktu',
    'kejadian',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];


  public function getChecklistDetail($modulAjarId, $tanggalKolom)
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
    return $this->select('asesmen_checklist.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_checklist.santri')
      ->join('kelas', 'kelas.id = asesmen_checklist.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_checklist.modul_ajar_id')
      ->where('asesmen_checklist.modul_ajar_id', $modulAjarId)
      ->where('asesmen_checklist.tanggal', $tanggalVal)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getChecklistDetailByModulAjar($modulAjarId)
  {
    return $this->select('asesmen_checklist.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_checklist.santri')
      ->join('kelas', 'kelas.id = asesmen_checklist.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_checklist.modul_ajar_id')
      ->where('asesmen_checklist.modul_ajar_id', $modulAjarId)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getChecklistDetailWithSantri($kelas)
  {
    return $this->select('asesmen_checklist.*, santri.nama as santri_nama, santri.id as santri_id')
      ->join('santri', 'santri.id = asesmen_checklist.santri')
      ->where('asesmen_checklist.kelas', $kelas)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }
}
