<?php

namespace App\Models;

use CodeIgniter\Model;

class AsesmenHasilKaryaModel extends Model
{
  protected $table = 'asesmen_hasilkarya';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'santri',
    'kelas',
    'semester',
    'modul_ajar_id',
    'tanggal',
    'kegiatan',
    'foto',
    'catatan',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];


  public function getHastaKaryaDetail($modulAjarId, $tanggalKolom)
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

    return $this->select('asesmen_hasilkarya.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_hasilkarya.santri')
      ->join('kelas', 'kelas.id = asesmen_hasilkarya.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_hasilkarya.modul_ajar_id')
      ->where('asesmen_hasilkarya.tanggal', $tanggalVal)
      ->where('asesmen_hasilkarya.modul_ajar_id', $modulAjarId)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getHastaKaryaDetailByModulAjar($modulAjarId)
  {
    return $this->select('asesmen_hasilkarya.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_hasilkarya.santri')
      ->join('kelas', 'kelas.id = asesmen_hasilkarya.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_hasilkarya.modul_ajar_id')
      ->where('asesmen_hasilkarya.modul_ajar_id', $modulAjarId)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getHastaKaryaDetailWithSantri($kelas)
  {
    return $this->select('asesmen_hasilkarya.*, santri.nama as santri_nama, santri.id as santri_id')
      ->join('santri', 'santri.id = asesmen_hasilkarya.santri')
      ->where('asesmen_hasilkarya.kelas', $kelas)

      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }
}
