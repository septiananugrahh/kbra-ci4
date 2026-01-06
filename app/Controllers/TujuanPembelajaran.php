<?php

namespace App\Controllers;

use App\Models\CapaianPembelajaranModel;
use App\Models\TujuanPembelajaranModel;

class TujuanPembelajaran extends CustomController
{
  protected $capaianPembelajaranModel;
  protected $tujuanPembelajaranModel;

  public function __construct()
  {
    $this->capaianPembelajaranModel = new CapaianPembelajaranModel();
    $this->tujuanPembelajaranModel = new TujuanPembelajaranModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();

    $validationRules = [
      'nama'         => 'required',
      'urut'        => 'required',
    ];

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Data Modul Ajar gagal validasi',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $capaianPembelajaranData = [
      'urut'         => $data['urut'],
      'nama'         => $data['nama'],
      'setting'        => session("tahun"),

    ];

    $this->capaianPembelajaranModel->insert($capaianPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Capaian Pembelajaran berhasil disimpan'
    ]);
  }

  public function simpandataTP()
  {
    $data = $this->request->getPost();

    $validationRules = [
      'nama'        => 'required',
      'urut'        => 'required',
      'capaian'     => 'required',
    ];

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Data Modul Ajar gagal validasi',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $tujuanPembelajaranData = [
      'urut'         => $data['urut'],
      'nama'         => $data['nama'],
      'capaian'      => $data['capaian'],

    ];

    $this->tujuanPembelajaranModel->insert($tujuanPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Capaian Pembelajaran berhasil disimpan'
    ]);
  }

  public function ubahdata()
  {

    $data = $this->request->getPost();
    $id   = $data['id'];

    $validationRules = [
      'nama'         => 'required',
      'urut'        => 'required',

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
      'urut'         => $data['urut'],
    ];

    $this->capaianPembelajaranModel->save($capaianPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Capaian Pembelajaran berhasil diperbarui'
    ]);
  }

  public function ubahdataTP()
  {

    $data = $this->request->getPost();
    $id   = $data['id'];

    $validationRules = [
      'nama'         => 'required',
      'urut'        => 'required',

    ];

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Validasi gagal saat mengubah data Modul Ajar',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $tujuanPembelajaranData = [
      'id' => $id,
      'nama'         => $data['nama'],
      'urut'         => $data['urut'],
    ];

    $this->tujuanPembelajaranModel->save($tujuanPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Capaian Pembelajaran berhasil diperbarui'
    ]);
  }


  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdcapaianpembelajaran');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->capaianPembelajaranModel->update($id, ['deleted' => 1]);

    $update2 = $this->tujuanPembelajaranModel
      ->where('capaian', $id)
      ->set(['deleted' => 1])
      ->update();

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

  public function hapusdata_softTP()
  {
    $id = $this->request->getPost('delIdtujuanpembelajaran');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->tujuanPembelajaranModel->update($id, ['deleted' => 1]);

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
      'title' => 'Capaian Pembelajaran | KBRA Islamic Center',
      'nav' => 'tujuanpembelajaran',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_capaianPembelajaran', $data); // pakai render() dari CustomController
  }

  public function indexTP($cpid)
  {
    $data = [
      'title' => 'Tujuan Pembelajaran | KBRA Islamic Center',
      'nav' => 'tujuanpembelajaran',
      'cpid' => $cpid,
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_tujuanPembelajaran', $data); // pakai render() dari CustomController
  }

  public function ambil_data_capaianpembelajaran()
  {
    $data = $this->capaianPembelajaranModel
      ->where('deleted', 0)
      ->where('setting', $this->session->get('tahun'))
      ->orderBy('urut', 'ASC') // Urutkan pertama berdasarkan kategori
      ->orderBy('nama', 'ASC') // Kemudian berdasarkan nama_capaian dalam setiap kategori
      ->findAll();

    // dd($data);

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }

  public function ambil_data_tujuanpembelajaran($cpid)
  {
    $data = $this->tujuanPembelajaranModel
      ->where('deleted', 0)
      ->where('capaian', $cpid)
      ->orderBy('urut', 'ASC') // Urutkan pertama berdasarkan kategori
      ->orderBy('nama', 'ASC')
      ->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }
}
