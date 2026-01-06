<?php

namespace App\Controllers;

use App\Models\GuruKelasModel;
use App\Models\SemesterModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time; // Tetap gunakan Time untuk kemudahan

class Login extends BaseController
{
  protected $GuruKelasModel;

  public function __construct()
  {
    $this->GuruKelasModel = new GuruKelasModel();
  }

  public function index()
  {
    if (session()->get('logged_in')) {
      return redirect()->to('/dashboard');
    }

    if ($this->checkRememberMe()) {
      return redirect()->to('/dashboard');
    }

    return view('login');
  }

  public function auth()
  {
    $session = session();
    $model = new UserModel();
    $semester_model = new SemesterModel();

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    $semester_post = $this->request->getPost('semester');
    $tahun_post = $this->request->getPost('tahun');
    $rememberMe = $this->request->getPost('remember_me');

    $ip = $this->request->getIPAddress();
    $maxAttempts = 5;
    $lockoutSeconds = 600;

    $loginAttemptModel = new \App\Models\LoginAttemptModel();

    $attempts = $loginAttemptModel
      ->where('ip_address', $ip)
      ->where('attempted_at >=', date('Y-m-d H:i:s', time() - $lockoutSeconds))
      ->countAllResults();

    if ($attempts >= $maxAttempts) {
      return redirect()->back()->with('message', 'Terlalu banyak percobaan login. Silakan coba lagi dalam 10 menit.');
    }

    $semester = $semester_model->where('tahun', $tahun_post)->where('semester', $semester_post)->first();
    if ($semester) {
      $semester_data = $semester['semester'];
      $tahun_data = $semester['tahun'];
      $id_set_data = $semester['id'];
    } else {
      $semester_data = 0;
      $tahun_data = 0;
      $id_set_data = 0;
    }

    $user = $model->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
      $loginAttemptModel
        ->where('ip_address', $ip)
        ->delete();

      $this->setUserSession($user, $semester_post, $tahun_post, $semester_data, $tahun_data, $id_set_data);

      if ($rememberMe) {
        // --- PERUBAHAN UTAMA DI SINI ---
        $this->setPermanentRememberMeCookie($user['id']);
      } else {
        $this->clearRememberMeCookie();
      }

      return redirect()->to('/dashboard');
    } else {
      $loginAttemptModel->insert([
        'ip_address' => $ip,
        'attempted_at' => date('Y-m-d H:i:s')
      ]);

      return redirect()->back()->with('message', 'Username atau password salah.');
    }
  }

  protected function setUserSession($user, $semester_post, $tahun_post, $semester_data, $tahun_data, $id_set_data)
  {
    $session = session();
    $session->set([
      'user_id' => $user['id'],
      'username' => $user['username'],
      'nama' => $user['nama'],
      'logged_in' => true
    ]);

    $userId = $user['id'];
    $roles = (new \App\Models\UserRoleModel())->getUserRoles($userId);
    session()->set([
      'roles' => array_column($roles, 'type'),
    ]);

    $kelasList = $this->GuruKelasModel
      ->select('semester.id as semester_id, semester, semester.tahun, kelas.tahun, kelas.id, kelas.nama, kelas.jenjang, kelas.tingkat')
      ->join('kelas', 'kelas.id = guru_kelas.kelas_id')
      ->join(
        'semester',
        'kelas.tahun = semester.tahun AND kelas.jenjang = semester.tingkat'
      )
      ->where('guru_kelas.guru_id', $user['id'])
      ->where('semester.semester', $semester_post)
      ->where('semester.tahun', $tahun_post)
      ->orderBy('kelas.id', 'DESC')
      ->findAll();

    if (!empty($kelasList)) {
      $kelasIdTertinggi = $kelasList[0]['id'];
      session()->set('kelas_id', $kelasIdTertinggi);
      session()->set('semester', $kelasList[0]['semester']);
      session()->set('tahun', $kelasList[0]['tahun']);
      session()->set('id_set', $kelasList[0]['semester_id']);
    }

    if (array_intersect(['5'], session()->get('roles'))) {
      session()->set('semester', $semester_data);
      session()->set('tahun', $tahun_data);
      session()->set('id_set', $id_set_data);
    }
  }

  /**
   * Mengatur cookie "ingat saya" untuk tidak kedaluwarsa (sangat tidak disarankan).
   * @param int $userId
   */
  protected function setPermanentRememberMeCookie(int $userId)
  {
    $model = new UserModel();
    $token = bin2hex(random_bytes(32)); // Buat token acak yang aman

    // --- PENTING: Set kedaluwarsa ke tanggal yang sangat jauh di masa depan ---
    // Misalnya, 100 tahun dari sekarang. Ini akan membuat token "praktis" tidak kedaluwarsa.
    $expires = Time::now()->addMonths(2);

    // Perbarui record pengguna dengan token dan kedaluwarsa baru
    $model->update($userId, [
      'remember_token' => $token,
      'remember_expires_at' => $expires->toDateTimeString() // Simpan tanggal yang sangat jauh
    ]);

    // Atur cookie di browser pengguna
    $response = service('response');
    $cookie = [
      'name'     => 'KBRA REMEMBER ME',
      'value'    => $token,
      'expire'   =>  $expires->getTimestamp(),
      'domain'   => 'null',
      'path'     => '/',
      'prefix'   => 'myprefix_',
      'secure'   => true,
      'httponly' => false,
      'samesite' => 'Lax',
    ];

    $response->setCookie($cookie);
  }

  /**
   * Memeriksa cookie "ingat saya" dan meng-login pengguna jika valid.
   * Tidak ada perubahan signifikan di sini karena pengecekan kedaluwarsa tetap ada,
   * hanya saja tanggal di database sudah sangat jauh.
   * @return bool
   */
  protected function checkRememberMe(): bool
  {
    $request = service('request');
    $model = new UserModel();
    $session = session();

    $rememberMeToken = $request->getCookie('remember_me');

    if ($rememberMeToken) {
      // Cari user berdasarkan token. Karena remember_expires_at sudah diset sangat jauh,
      // baris ini akan selalu dianggap valid selama token cocok.
      $user = $model->where('remember_token', $rememberMeToken)
        ->where('remember_expires_at >=', Time::now()->toDateTimeString())
        ->first();

      if ($user) {
        $this->setUserSession($user, 0, 0, 0, 0, 0);

        // Tetap lakukan rotasi token untuk keamanan, meskipun tidak ada kedaluwarsa
        // Ini mencegah token yang dicuri digunakan lebih dari sekali.
        $this->setPermanentRememberMeCookie($user['id']);

        return true;
      } else {
        // Token tidak valid (misal: dicuri dan sudah dirotasi, atau salah)
        $this->clearRememberMeCookie();
      }
    }
    return false;
  }

  /**
   * Menghapus cookie "ingat saya" dari browser.
   */
  protected function clearRememberMeCookie()
  {
    $response = service('response');
    $response->deleteCookie('remember_me');
  }

  public function logout()
  {
    $userId = session()->get('user_id');

    if ($userId) {
      $model = new UserModel();
      // Hapus token dan tanggal kedaluwarsa dari database saat logout
      $model->update($userId, [
        'remember_token' => null,
        'remember_expires_at' => null
      ]);
    }

    $this->clearRememberMeCookie();
    session()->destroy();
    return redirect()->to('/login');
  }
}
