<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
  protected $table = 'user_level_list';
  protected $primaryKey = 'id';
  protected $allowedFields = ['user', 'type'];

  public function getUserRoles($userId)
  {
    return $this->db->table('user_level_list ull')
      ->select('uld.id, uld.nama, ull.type')
      ->join('user_level_desc uld', 'uld.id = ull.type')
      ->where('ull.user', $userId)
      ->get()
      ->getResultArray();
  }
}
