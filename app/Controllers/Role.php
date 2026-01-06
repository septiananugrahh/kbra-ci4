<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Role extends CustomController
{
  protected $userModel;
  protected $userRoleModel;
  protected $roleModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->userRoleModel = new UserRoleModel();
    $this->roleModel = new RoleModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();
    //dd($this->request->getPost());
    //log_message('debug', print_r($this->request->getPost(), true));

    if (!$this->validate([
      'nama' => 'required',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }
    $this->roleModel->save([
      'nama'     => $data['nama'],
      'ket' => $data['ket'],
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
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }
    $updateData = [
      'nama'     => $data['nama'],
      'ket' => $data['ket'],

    ];

    // Jika password diisi saat edit, update juga password-nya
    if (!empty($data['password'])) {
      $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    $this->roleModel->update($data['id'], $updateData);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Data berhasil disimpan'
    ]);
  }

  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdRole');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->roleModel->update($id, ['deleted' => 1]);

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
      'title' => 'Hak Akses User | KBRA Islamic Center',
      'nav' => 'role',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_role', $data); // pakai render() dari CustomController
  }

  public function ambil_data_role()
  {
    $data = $this->roleModel->where('deleted', 0)->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }
}
