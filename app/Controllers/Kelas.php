<?php

namespace App\Controllers;

use App\Models\GuruKelasModel;
use App\Models\KelasModel;
use App\Models\RuangKelasModel;
use App\Models\SantriModel;
use App\Models\SemesterModel;
use App\Models\UserModel;

class Kelas extends CustomController
{
  protected $santriModel;
  protected $kelasModel;
  protected $userModel;
  protected $ruangKelasModel;
  protected $guruKelasModel;
  protected $semesterModel;

  public function __construct()
  {
    $this->santriModel = new SantriModel();
    $this->kelasModel = new KelasModel();
    $this->userModel = new UserModel();
    $this->ruangKelasModel = new RuangKelasModel();
    $this->guruKelasModel = new GuruKelasModel();
    $this->semesterModel = new SemesterModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();

    if (!$this->validate([
      'jenjang' => 'required',
      'nama' => 'required',
      'tingkat' => 'required',
      'tahun' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }

    $this->kelasModel->save([
      'jenjang' => $data['jenjang'],
      'nama' => $data['nama'],
      'tingkat' => $data['tingkat'],
      'tahun' => $data['tahun'],
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
      'id' => 'required|numeric',
      'nama' => 'required',
      'tingkat' => 'required',
      'jenjang' => 'required',
      'tahun' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }

    $updateData = [
      'nama' => $data['nama'],
      'tingkat' => $data['tingkat'],
      'jenjang' => $data['jenjang'],
      'tahun' => $data['tahun'],
    ];

    $this->kelasModel->update($data['id'], $updateData);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Data berhasil diperbarui'
    ]);
  }

  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdKelas');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->kelasModel->update($id, ['deleted' => 1]);

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
      'title' => 'Kelas | KBRA Islamic Center',
      'nav' => 'kelas',
      'username' => $this->session->get('username')
    ];
    // $data['tingkat'] = $tingkatModel->findAll();
    return $this->render('admin/v_kelas', $data); // pakai render() dari CustomController
  }

  public function get_tahun_list()
  {
    $data = $this->semesterModel
      ->select('tahun')
      ->distinct()
      ->where('deleted', 0)
      ->orderBy('tahun', 'DESC')
      ->findAll();

    return $this->response->setJSON(['data' => $data]);
  }

  public function get_tahun_by_kelas()
  {
    $id = $this->request->getPost('id');
    $kelas = $this->kelasModel->find($id);

    return $this->response->setJSON([
      'tahun' => $kelas['tahun'] ?? ''
    ]);
  }

  public function ambil_data_kelas()
  {
    $request = \Config\Services::request();

    // Ambil filter dari POST
    $filterTahun = $request->getPost('tahun');
    $filterJenjang = $request->getPost('jenjang');

    // Builder query awal
    $builder = $this->kelasModel
      ->getKelasWithSemester()
      ->where('kelas.deleted', 0);

    // Terapkan filter tahun hanya jika ada filter tahun
    if (!empty($filterTahun)) {
      $builder->where('kelas.tahun', $filterTahun);
    }

    // Terapkan filter jenjang jika ada
    if (!empty($filterJenjang)) {
      $builder->where('kelas.jenjang', $filterJenjang);
    }

    // Ambil data sesuai query yang telah dibangun
    $data = $builder->findAll();

    // Kembalikan data dalam format JSON
    return $this->response->setJSON(['data' => $data]);
  }


  public function getSemestersByJenjang()
  {
    $jenjang = $this->request->getPost('jenjang');

    $semesterModel = new SemesterModel();
    // Ambil semester berdasarkan tingkat_id
    $semesters = $semesterModel->where('tingkat', $jenjang)->findAll();

    // Format data untuk dikirim kembali sebagai JSON
    $output = '<option value="">-- Pilih Semester --</option>';
    foreach ($semesters as $semester) {
      // Cek apakah id semester sama dengan session('id_set')
      $selected = ($semester['semester'] == session()->get('semester') && $semester['tahun'] == session()->get('tahun')) ? 'selected' : '';

      // Tambahkan atribut selected jika kondisi terpenuhi
      $output .= '<option value="' . $semester['id'] . '" ' . $selected . '>' . $semester['tahun'] . ' - ' . $semester['semester'] . '</option>';
    }

    return $this->response->setJSON(['html' => $output]);
  }


  // menejemen kelas
  // menejemen kelas

  public function get_santri_by_kelas($kelasId)
  {
    $data = $this->santriModel
      ->join('ruang_kelas', 'santri.id = ruang_kelas.santri_id')
      ->where('ruang_kelas.kelas_id', $kelasId)
      ->where('santri.deleted=0')
      ->findAll();

    return $this->response->setJSON(['data' => $data]);
  }

  public function get_guru_by_kelas($kelasId)
  {
    $kelasData = $this->kelasModel->find($kelasId);
    $currentWaliGuruId = $kelasData ? $kelasData['wali'] : null;

    $dataGurus = $this->userModel
      ->join('guru_kelas', 'guru.id = guru_kelas.guru_id')
      ->where('guru_kelas.kelas_id', $kelasId)
      ->where('guru.deleted=0')
      ->findAll();
    $modifiedData = [];

    foreach ($dataGurus as $row) {
      // Konversi objek ke array jika perlu, atau gunakan properti objek langsung
      $rowData = (array) $row; // Ubah ke array jika findAll() mengembalikan objek

      // Tambahkan flag 'is_selected_wali'
      // Bandingkan guru_id dari baris ini dengan currentWaliGuruId
      $rowData['is_selected_wali'] = ($rowData['guru_id'] == $currentWaliGuruId);
      $modifiedData[] = $rowData;
    }

    // 4. Kirim data dalam format yang diharapkan DataTables
    return $this->response->setJSON(['data' => $modifiedData]);
  }

  public function simpandata_wali()
  {
    $data = $this->request->getPost();

    if (!$this->validate([
      'guru_id'       => 'required',
      'kelas_id'       => 'required',
    ])) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }

    $updateData = [
      'wali'     => $data['guru_id'],
    ];

    $this->kelasModel->update($data['kelas_id'], $updateData);

    return $this->response->setJSON([
      'status' => 'success',
      'message' => 'Data berhasil disimpan'
    ]);
  }


  public function get_santri_tanpa_kelas($kelasId)
  {
    $kelas = $this->kelasModel->find($kelasId);
    $semester = $kelas['set']; // Ambil id_set (semester)
    $jenjang = $kelas['jenjang']; // Ambil id_set (semester)

    // Ambil santri yang belum ada di kelas manapun pada semester ini
    $santriInSemester = $this->ruangKelasModel
      ->select('santri_id')
      ->join('kelas', 'kelas.id = ruang_kelas.kelas_id')
      ->where('kelas.set', $semester)
      ->findAll();

    // Ambil ID santri yang sudah masuk kelas berdasarkan semester tertentu
    $subQuery = $this->ruangKelasModel
      ->select('santri_id')
      ->join('kelas', 'kelas.id = ruang_kelas.kelas_id')
      ->where('kelas.set', $semester)
      ->builder(); // gunakan builder untuk subquery

    // Ambil santri yang belum masuk ke kelas semester ini dan belum dihapus
    $availableSantri = $this->santriModel
      ->whereNotIn('id', $subQuery)
      ->where('deleted', 0)
      ->where('jenjang', $jenjang)
      ->where('status', 1)
      ->findAll();

    // Kembalikan sebagai response JSON
    return $this->response->setJSON(['data' => $availableSantri]);
  }

  public function tambah_santri_ke_kelas()
  {
    $data = $this->request->getPost();  // << kemungkinan kosong
    log_message('debug', json_encode($data));  // Tambahkan untuk debug

    $kelas_id = $data['kelas_id'] ?? null;
    $santri_id = $data['santri_id'] ?? null;

    if (!$kelas_id || !$santri_id) {
      return $this->response->setStatusCode(400)->setJSON(['message' => 'Data tidak lengkap']);
    }

    // Simpan ke model
    $this->ruangKelasModel->save([
      'kelas_id'     => $kelas_id,
      'santri_id'    => $santri_id,
    ]);

    return $this->response->setJSON(['status' => 'success']);
  }

  public function tambah_santri_ke_kelas_batch()
  {
    $kelasId = $this->request->getPost('kelas_id');
    $santriIds = $this->request->getPost('santri_ids');

    if (!$kelasId || !$santriIds || !is_array($santriIds)) {
      return $this->response->setStatusCode(400)->setJSON(['message' => 'Data tidak valid']);
    }

    foreach ($santriIds as $santriId) {
      $this->ruangKelasModel->save([
        'santri_id' => $santriId,
        'kelas_id' => $kelasId,
      ]);
    }

    return $this->response->setJSON(['status' => 'success']);
  }


  public function hapus_santri_dari_kelas()
  {
    $santriId = $this->request->getPost('santri_id');
    $this->ruangKelasModel->where('id', $santriId)->delete();
    return $this->response->setJSON(['status' => 'deleted']);
  }

  public function get_guru($kelasId)
  {
    $kelas = $this->kelasModel->find($kelasId);
    $semester = $kelas['set']; // Ambil id_set (semester)

    // Ambil santri yang belum ada di kelas manapun pada semester ini
    $guruInSemester = $this->guruKelasModel
      ->select('guru_id')
      ->join('kelas', 'kelas.id = guru_kelas.kelas_id')
      ->where('kelas.set', $semester)
      ->findAll();

    $ids = array_column($guruInSemester, 'guru_id');

    $availableSantri = empty($ids)
      ? $this->userModel->findAll()
      : $this->userModel->whereNotIn('id', $ids)->findAll();

    return $this->response->setJSON(['data' => $availableSantri]);
  }

  public function tambah_guru_ke_kelas()
  {
    $data = $this->request->getPost();  // << kemungkinan kosong
    log_message('debug', json_encode($data));  // Tambahkan untuk debug

    $kelas_id = $data['kelas_id'] ?? null;
    $guru_id = $data['guru_id'] ?? null;

    if (!$kelas_id || !$guru_id) {
      return $this->response->setStatusCode(400)->setJSON(['message' => 'Data tidak lengkap']);
    }

    // Simpan ke model
    $this->guruKelasModel->save([
      'kelas_id'     => $kelas_id,
      'guru_id'    => $guru_id,
    ]);

    return $this->response->setJSON(['status' => 'success']);
  }

  public function hapus_guru_dari_kelas()
  {
    $id_data = $this->request->getPost('id_data');
    $this->guruKelasModel->where('id', $id_data)->delete();
    return $this->response->setJSON(['status' => 'deleted']);
  }

  // menejemen kelas
  // menejemen kelas
}
