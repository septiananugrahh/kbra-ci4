<?php

namespace App\Models;

use CodeIgniter\Model;

class CapaianPembelajaranModel extends Model
{
  protected $table = 'capaian_pembelajaran';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nama',
    'setting',
    'urut',
    'deleted',
    'created_at',    // ✅ TAMBAH INI
    'updated_at'
  ];
}
