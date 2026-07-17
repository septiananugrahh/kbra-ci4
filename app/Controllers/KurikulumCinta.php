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

  public function salindata()
  {
    $tahunAsal   = $this->request->getPost('tahun_asal');
    $tahunTujuan = $this->request->getPost('tahun_tujuan');

    if (!$tahunAsal || !$tahunTujuan) {
      return $this->response->setJSON([
        'status'  => 'gagal',
        'message' => 'Tahun asal dan tahun tujuan wajib dipilih'
      ]);
    }

    if ($tahunAsal === $tahunTujuan) {
      return $this->response->setJSON([
        'status'  => 'gagal',
        'message' => 'Tahun asal dan tujuan tidak boleh sama'
      ]);
    }

    $dataAsal = $this->kurikulumCintaModel
      ->where('deleted', 0)
      ->where('setting', $tahunAsal)
      ->findAll();

    if (empty($dataAsal)) {
      return $this->response->setJSON([
        'status'  => 'gagal',
        'message' => 'Tidak ada data pada tahun ajar asal'
      ]);
    }

    foreach ($dataAsal as $row) {
      $sudahAda = $this->kurikulumCintaModel
        ->where('deleted', 0)
        ->where('setting', $tahunTujuan)
        ->where('nama', $row['nama'])
        ->first();

      if (!$sudahAda) {
        $this->kurikulumCintaModel->insert([
          'nama'    => $row['nama'],
          'setting' => $tahunTujuan,
        ]);
      }
    }

    return $this->response->setJSON([
      'status'  => 'sukses',
      'message' => 'Data berhasil disalin dari tahun ajar ' . $tahunAsal
    ]);
  }

  public function index()
  {
    $tahunList = [
      '2025/2026',
      '2026/2027',
      '2027/2028',
    ];

    $data = [
      'title' => 'Kurikulum Berbasis Cinta | KBRA Islamic Center',
      'nav' => 'kurikulumcinta',
      'username' => $this->session->get('username'),
      'tahun_list' => $tahunList,
      'tahun_aktif' => $this->session->get('tahun'),
    ];
    return $this->render('admin/v_kurikulumCinta', $data);
  }


  public function ambil_data()
  {
    $tahun = $this->request->getPost('tahun') ?: $this->session->get('tahun');

    $data = $this->kurikulumCintaModel
      ->where('deleted', 0)
      ->where('setting', $tahun)
      ->orderBy('nama', 'ASC')
      ->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }
}
