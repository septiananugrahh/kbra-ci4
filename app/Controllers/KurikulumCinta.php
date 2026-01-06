<?php

namespace App\Controllers;

use App\Models\KurikulumCintaModel;

class KurikulumCinta extends CustomController
{
  protected $kurikulumCintaModel;

  public function __construct()
  {
    $this->kurikulumCintaModel = new KurikulumCintaModel();
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
        'message' => 'Kurikulum Berbasis Cinta gagal validasi',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $capaianPembelajaranData = [
      'nama'         => $data['nama'],
      'setting'        => session("tahun"),
    ];

    $this->kurikulumCintaModel->insert($capaianPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Kurikulum Berbasis Cinta berhasil disimpan'
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
        'message' => 'Validasi gagal saat mengubah data Kurikulum Berbasis Cinta',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $capaianPembelajaranData = [
      'id' => $id,
      'nama'         => $data['nama'],
    ];

    $this->kurikulumCintaModel->save($capaianPembelajaranData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Kurikulum Berbasis Cinta berhasil diperbarui'
    ]);
  }



  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdkurikulumcinta');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->kurikulumCintaModel->update($id, ['deleted' => 1]);

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
      'title' => 'Kurikulum Berbasis Cinta | KBRA Islamic Center',
      'nav' => 'kurikulumcinta',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_kurikulumCinta', $data); // pakai render() dari CustomController
  }


  public function ambil_data()
  {
    $data = $this->kurikulumCintaModel
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
