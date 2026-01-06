<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'guru';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nama', 'username', 'password', 'alamat', 'tempat_lahir', 'tanggal_lahir', 'remember_token', 'remember_expires_at', 'deleted'];
}
