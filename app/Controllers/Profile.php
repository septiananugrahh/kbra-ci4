<?php

namespace App\Controllers;

use App\Models\GuruKelasModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Profile extends CustomController
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
      'title' => 'Profile | KBRA Islamic Center',
      'nav' => 'ptk',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_profile', $data); // pakai render() dari CustomController
  }
}
