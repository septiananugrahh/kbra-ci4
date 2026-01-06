<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
  protected $table = 'user_level_desc';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nama', 'ket', 'deleted'];
}
