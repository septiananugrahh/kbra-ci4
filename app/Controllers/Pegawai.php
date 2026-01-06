<?php

namespace App\Controllers;

use App\Models\GuruKelasModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Pegawai extends CustomController
{
  protected $userModel;
  protected $userRoleModel;
  protected $roleModel;
  protected $GuruKelasModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->userRoleModel = new UserRoleModel();
    $this->GuruKelasModel = new GuruKelasModel();
    $this->roleModel = new RoleModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();
    //dd($this->request->getPost());
    //log_message('debug', print_r($this->request->getPost(), true));

    if (!$this->validate([
      'nama' => 'required',
      'username' => 'required|is_unique[guru.username]',
      'password' => 'required|min_length[6]',
      'alamat' => 'required',
      'tempat' => 'required',
      'tanggal' => 'required',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }

    $tanggal_input = $this->request->getPost('tanggal'); // 18-09-2025
    $tanggal_db = date('d-m-Y', strtotime($tanggal_input));

    $this->userModel->save([
      'nama'     => $data['nama'],
      'username' => $data['username'],
      'password' => password_hash($data['password'], PASSWORD_DEFAULT),
      'alamat'   => $data['alamat'],
      'tempat_lahir'   => $data['tempat'],
      'tanggal_lahir'   => $tanggal_db,
    ]);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Data berhasil disimpan'
    ]);
  }

  public function ubahdata()
  {
    $data = $this->request->getPost();

    if (!$this->validate([
      'id'       => 'required|numeric',
      'nama'     => 'required',
      'username' => 'required',
      'alamat'   => 'required',
      'tempat' => 'required',
      'tanggal' => 'required',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }
    $tanggal_input = $this->request->getPost('tanggal'); // 18-09-2025
    $tanggal_db = date('d-m-Y', strtotime($tanggal_input));

    $updateData = [
      'nama'     => $data['nama'],
      'username' => $data['username'],
      'alamat'   => $data['alamat'],
      'tempat_lahir'   => $data['tempat'],
      'tanggal_lahir'   => $tanggal_db,

    ];

    // Jika password diisi saat edit, update juga password-nya
    if (!empty($data['password'])) {
      $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    $this->userModel->update($data['id'], $updateData);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Data berhasil disimpan'
    ]);
  }

  public function formPilihKelas()
  {
    $guruId = session('user_id'); // atau sesuai nama session login

    $kelasList = $this->GuruKelasModel->getKelasByGuru($guruId);

    return view('form_kelas', ['kelasList' => $kelasList]);
  }

  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdPegawai');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->userModel->update($id, ['deleted' => 1]);

    if ($update) {
      return $this->response->setJSON([
        'status' => 'sukses'
      ]);
    } else {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'Gagal menghapus data.'
      ]);
    }
  }


  public function index()
  {
    $data = [
      'title' => 'Pegawai | KBRA Islamic Center',
      'nav' => 'ptk',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_pegawai', $data); // pakai render() dari CustomController
  }

  public function ambil_data_pegawai()
  {
    $data = $this->userModel->where('deleted', 0)->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }


  // Start Role
  // Start Role

  public function get_roles_by_user($userId)
  {
    $roles = $this->userRoleModel->getUserRoles($userId);
    return $this->response->setJSON(['userRoles' => $roles]);
  }

  public function get_all_roles()
  {
    $db = \Config\Database::connect();
    $roles = $db->table('user_level_desc')->where("deleted=0")->get()->getResultArray();
    return $this->response->setJSON(['roles' => $roles]);
  }

  public function tambah_role()
  {
    $userId = $this->request->getPost('user_id');
    $levelId = $this->request->getPost('level_id');

    $db = \Config\Database::connect();
    // Cek jika belum ada
    $exists = $db->table('user_level_list')
      ->where('user', $userId)
      ->where('type', $levelId)
      ->countAllResults();

    if ($exists == 0) {
      $db->table('user_level_list')->insert([
        'user' => $userId,
        'type' => $levelId
      ]);
      return $this->response->setJSON(['status' => 'success']);
    }

    return $this->response->setJSON(['status' => 'exists']);
  }

  public function hapus_role()
  {
    $userId = $this->request->getPost('user_id');
    $levelId = $this->request->getPost('level_id');

    $db = \Config\Database::connect();
    $builder = $db->table('user_level_list');
    $builder->where('user', $userId)
      ->where('type', $levelId)
      ->delete();

    return $this->response->setJSON(['status' => 'success']);
  }



  // End Role
  // End Role
}
