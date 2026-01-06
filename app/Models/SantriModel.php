<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
  protected $table = 'santri';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nama',
    'nis_lokal',
    'nisn',
    'nik',
    'jenis_kelamin',
    'tempat_lahir',
    'tanggal_lahir',
    'telp',
    'alamat',
    'nama_ayah',
    'nama_ibu',
    'pekerjaan_ayah',
    'pekerjaan_ibu',
    'foto_santri',
    'jenjang',
    'status',
    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];
}
