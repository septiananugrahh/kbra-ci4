<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\SemesterModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Semester extends CustomController
{
  protected $userModel;
  protected $semesterModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->semesterModel = new SemesterModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();
    //dd($this->request->getPost());
    //log_message('debug', print_r($this->request->getPost(), true));

    // Cek apakah kombinasi sudah ada di DB
    $exists = $this->semesterModel
      ->where('semester', $data['semester'])
      ->where('tahun', $data['tahun'])
      ->where('tingkat', $data['tingkat'])
      ->first();

    if ($exists) {
      return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Semester, tahun, dan tingkat sudah terdaftar.'
      ]);
    }


    if (!$this->validate([
      'semester' => 'required',
      'tahun' => 'required',
      'tingkat' => 'required',
      'kepala' => 'required',
      'tanggal_rapor' => 'required',
    ])) {
      return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Validasi Gagal.'
      ]);
    }

    $this->semesterModel->save([
      'semester'     => $data['semester'],
      'tahun' => $data['tahun'],
      'tingkat' => $data['tingkat'],
      'kepala'   => $data['kepala'],
      'tanggal_rapor'   => $data['tanggal_rapor'],
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
      'semester' => 'required',
      'tahun' => 'required',
      'tingkat' => 'required',
      'kepala' => 'required',
      'tanggal_rapor' => 'required',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }

    $updateData = [
      'semester'     => $data['semester'],
      'tahun' => $data['tahun'],
      'tingkat' => $data['tingkat'],
      'kepala'   => $data['kepala'],
      'tanggal_rapor'   => $data['tanggal_rapor'],
    ];

    $this->semesterModel->update($data['id'], $updateData);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Data berhasil disimpan'
    ]);
  }


  public function index()
  {
    $data = [
      'title' => 'Semester | KBRA Islamic Center',
      'nav' => 'semester',
      'username' => $this->session->get('username')
    ];
    $data['gurus'] = $this->userModel->where('deleted=0')->findAll();
    return $this->render('admin/v_semester', $data); // pakai render() dari CustomController
  }

  public function ambil_data_semester()
  {
    $data = $this->semesterModel->getSemesterWithGuru();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }
}
