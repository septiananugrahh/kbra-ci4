<?php

namespace App\Models;

use CodeIgniter\Model;

class AsesmenFotoBerseriModel extends Model
{
  protected $table = 'asesmen_fotoberseri';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'santri',
    'kelas',
    'semester',
    'modul_ajar_id',
    'tanggal',
    'foto1',
    'foto2',
    'foto3',
    'ket_foto1',
    'ket_foto2',
    'ket_foto3',
    'analisis_guru',
    'umpan_balik',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];

  public function getFotoBerseriDetail($modulAjarId, $tanggalKolom)
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

    return $this->select('asesmen_fotoberseri.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_fotoberseri.santri')
      ->join('kelas', 'kelas.id = asesmen_fotoberseri.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_fotoberseri.modul_ajar_id')
      ->where('asesmen_fotoberseri.tanggal', $tanggalVal)
      ->where('asesmen_fotoberseri.modul_ajar_id', $modulAjarId)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getFotoBerseriDetailByModulAjar($modulAjarId)
  {
    return $this->select('asesmen_fotoberseri.*, modul_ajar.*, santri.nama as santri_nama, kelas.nama as kelas_nama, kelas.tingkat as kelas_tingkat')
      ->join('santri', 'santri.id = asesmen_fotoberseri.santri')
      ->join('kelas', 'kelas.id = asesmen_fotoberseri.kelas')
      ->join('modul_ajar', 'modul_ajar.id = asesmen_fotoberseri.modul_ajar_id')
      ->where('asesmen_fotoberseri.modul_ajar_id', $modulAjarId)
      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }

  public function getFotoBerseriDetailWithSantri($kelas)
  {
    return $this->select('asesmen_fotoberseri.*, santri.nama as santri_nama, santri.id as santri_id')
      ->join('santri', 'santri.id = asesmen_fotoberseri.santri')
      ->where('asesmen_fotoberseri.kelas', $kelas)

      ->findAll(); // Pastikan ini findAll() untuk mendapatkan semua record
  }
}
