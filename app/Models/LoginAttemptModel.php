<?php

// app/Models/LoginAttemptModel.php
namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
  protected $table = 'login_attempts';
  protected $allowedFields = ['ip_address', 'attempted_at'];
  public $timestamps = false;
}
