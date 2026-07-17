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

    $capaianAsal = $this->capaianPembelajaranModel
      ->where('deleted', 0)
      ->where('setting', $tahunAsal)
      ->findAll();

    if (empty($capaianAsal)) {
      return $this->response->setJSON([
        'status'  => 'gagal',
        'message' => 'Tidak ada data pada tahun ajar asal'
      ]);
    }

    foreach ($capaianAsal as $capaian) {
      // Cek apakah capaian dengan nama sama sudah ada di tahun tujuan
      $capaianBaru = $this->capaianPembelajaranModel
        ->where('deleted', 0)
        ->where('setting', $tahunTujuan)
        ->where('nama', $capaian['nama'])
        ->first();

      if (!$capaianBaru) {
        $idCapaianBaru = $this->capaianPembelajaranModel->insert([
          'nama'    => $capaian['nama'],
          'urut'    => $capaian['urut'],
          'setting' => $tahunTujuan,
        ], true); // true supaya dapat insert id
      } else {
        $idCapaianBaru = $capaianBaru['id'];
      }

      // Salin Tujuan Pembelajaran anak dari capaian ini
      $tujuanAsal = $this->tujuanPembelajaranModel
        ->where('deleted', 0)
        ->where('capaian', $capaian['id'])
        ->findAll();

      foreach ($tujuanAsal as $tujuan) {
        $sudahAda = $this->tujuanPembelajaranModel
          ->where('deleted', 0)
          ->where('capaian', $idCapaianBaru)
          ->where('nama', $tujuan['nama'])
          ->first();

        if (!$sudahAda) {
          $this->tujuanPembelajaranModel->insert([
            'nama'    => $tujuan['nama'],
            'urut'    => $tujuan['urut'],
            'capaian' => $idCapaianBaru,
          ]);
        }
      }
    }

    return $this->response->setJSON([
      'status'  => 'sukses',
      'message' => 'Data berhasil disalin dari tahun ajar ' . $tahunAsal
    ]);
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
    $tahunList = [
      '2025/2026',
      '2026/2027',
      '2027/2028',
    ];

    $data = [
      'title' => 'Capaian Pembelajaran | KBRA Islamic Center',
      'nav' => 'tujuanpembelajaran',
      'username' => $this->session->get('username'),
      'tahun_list' => $tahunList,
      'tahun_aktif' => $this->session->get('tahun'),
    ];
    return $this->render('admin/v_capaianPembelajaran', $data);
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
    $tahun = $this->request->getPost('tahun') ?: $this->session->get('tahun');

    $data = $this->capaianPembelajaranModel
      ->where('deleted', 0)
      ->where('setting', $tahun)
      ->orderBy('urut', 'ASC')
      ->orderBy('nama', 'ASC')
      ->findAll();

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
