<?php

namespace App\Controllers;

use App\Models\DimensiProfilModel;

class DimensiProfilLulusan extends CustomController
{
  protected $dimensiProfilModel;

  public function __construct()
  {
    $this->dimensiProfilModel = new DimensiProfilModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();

    $validationRules = [
      'nama'         => 'required',
    ];

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Data Dimensi Profil Lulusan gagal validasi',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $capaianPembelajaranData = [
      'nama'         => $data['nama'],
      'setting'        => session("tahun"),
    ];

    $this->dimensiProfilModel->insert($capaianPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Dimensi Profil Lulusan berhasil disimpan'
    ]);
  }

  public function ubahdata()
  {

    $data = $this->request->getPost();
    $id   = $data['id'];

    $validationRules = [
      'nama'         => 'required',
    ];

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Validasi gagal saat mengubah data Modul Ajar',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $capaianPembelajaranData = [
      'id' => $id,
      'nama'         => $data['nama'],
    ];

    $this->dimensiProfilModel->save($capaianPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Dimensi Profil Lulusan berhasil diperbarui'
    ]);
  }



  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIddimensiprofil');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->dimensiProfilModel->update($id, ['deleted' => 1]);

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
      'title' => 'DImensi Profil Lulusan | KBRA Islamic Center',
      'nav' => 'dimensiprofil',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_dimensiProfil', $data); // pakai render() dari CustomController
  }


  public function ambil_data()
  {
    $data = $this->dimensiProfilModel
      ->where('deleted', 0)
      ->where('setting', $this->session->get('tahun'))
      ->orderBy('nama', 'ASC') // Kemudian berdasarkan nama_capaian dalam setiap kategori
      ->findAll();

    // dd($data);

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }
}
