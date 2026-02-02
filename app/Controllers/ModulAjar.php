<?php

namespace App\Controllers;

use App\Models\CapaianPembelajaranModel;
use App\Models\DataSelectKBC_DPL;
use App\Models\DesainPembelajaranModel;
use App\Models\DimensiProfilModel;
use App\Models\KelasModel;
use App\Models\KurikulumCintaModel;
use App\Models\ModulAjarModel;
use App\Models\RuangKelasModel;
use App\Models\SantriModel;
use App\Models\SemesterModel;
use App\Models\TujuanPembelajaranModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

class ModulAjar extends CustomController
{
  protected $santriModel;
  protected $modulAjarModel;
  protected $capaianPembelajaranModel;
  protected $tujuanPembelajaranModel;
  protected $guruModel;
  protected $kelasModel;
  protected $semesterModel;
  protected $dimensiProfilModel;
  protected $kurikulumCintaModel;
  protected $desainPembelajaran;
  protected $selectKBCDPL;


  protected $format    = 'json';

  public function __construct()
  {
    $this->santriModel = new SantriModel();
    $this->modulAjarModel = new ModulAjarModel();
    $this->capaianPembelajaranModel = new CapaianPembelajaranModel();
    $this->tujuanPembelajaranModel = new TujuanPembelajaranModel();
    $this->guruModel = new UserModel();
    $this->kelasModel = new KelasModel();
    $this->semesterModel = new SemesterModel();
    $this->dimensiProfilModel = new DimensiProfilModel();
    $this->kurikulumCintaModel = new KurikulumCintaModel();
    $this->desainPembelajaran = new DesainPembelajaranModel();
    $this->selectKBCDPL = new DataSelectKBC_DPL();
  }

  public function simpandata()
  {

    log_message('debug', 'Masuk ke simpandata()');
    log_message('debug', 'POST: ' . print_r($this->request->getPost(), true));
    log_message('debug', 'FILES: ' . print_r($_FILES, true));

    $data = $this->request->getPost();
    $file = $this->request->getFile('foto_modulajar');
    $fotoName = null;

    $inti_select_json_1 = json_decode($data['inti_select_json_1'], true);
    $inti_select_json_2 = json_decode($data['inti_select_json_2'], true);
    $inti_select_json_3 = json_decode($data['inti_select_json_3'], true);
    $inti_select_json_4 = json_decode($data['inti_select_json_4'], true);
    $inti_select_json_5 = json_decode($data['inti_select_json_5'], true);

    $pembukaan_select_json_1 = json_decode($data['pembukaan_select_json_1'], true);
    $pembukaan_select_json_2 = json_decode($data['pembukaan_select_json_2'], true);
    $pembukaan_select_json_3 = json_decode($data['pembukaan_select_json_3'], true);
    $pembukaan_select_json_4 = json_decode($data['pembukaan_select_json_4'], true);
    $pembukaan_select_json_5 = json_decode($data['pembukaan_select_json_5'], true);

    $merefleksi_select_json_1 = json_decode($data['merefleksi_select_json_1'], true);
    $merefleksi_select_json_2 = json_decode($data['merefleksi_select_json_2'], true);
    $merefleksi_select_json_3 = json_decode($data['merefleksi_select_json_3'], true);
    $merefleksi_select_json_4 = json_decode($data['merefleksi_select_json_4'], true);
    $merefleksi_select_json_5 = json_decode($data['merefleksi_select_json_5'], true);


    $pembukaan1 = json_decode($data['pembukaan_json_1'], true);
    $kegiatan_inti1 = json_decode($this->request->getPost('inti_json_1'), true);
    $pertanyaan_pemantik1 = json_decode($this->request->getPost('pemantik_json_1'), true);
    $merefleksi1 = json_decode($this->request->getPost('merefleksi_json_1'), true);

    $pembukaan2 = json_decode($data['pembukaan_json_2'], true);
    $kegiatan_inti2 = json_decode($this->request->getPost('inti_json_2'), true);
    $pertanyaan_pemantik2 = json_decode($this->request->getPost('pemantik_json_2'), true);
    $merefleksi2 = json_decode($this->request->getPost('merefleksi_json_2'), true);

    $pembukaan3 = json_decode($data['pembukaan_json_3'], true);
    $kegiatan_inti3 = json_decode($this->request->getPost('inti_json_3'), true);
    $pertanyaan_pemantik3 = json_decode($this->request->getPost('pemantik_json_3'), true);
    $merefleksi3 = json_decode($this->request->getPost('merefleksi_json_3'), true);

    $pembukaan4 = json_decode($data['pembukaan_json_4'], true);
    $kegiatan_inti4 = json_decode($this->request->getPost('inti_json_4'), true);
    $pertanyaan_pemantik4 = json_decode($this->request->getPost('pemantik_json_4'), true);
    $merefleksi4 = json_decode($this->request->getPost('merefleksi_json_4'), true);

    $pembukaan5 = json_decode($data['pembukaan_json_5'], true);
    $kegiatan_inti5 = json_decode($this->request->getPost('inti_json_5'), true);
    $pertanyaan_pemantik5 = json_decode($this->request->getPost('pemantik_json_5'), true);
    $merefleksi5 = json_decode($this->request->getPost('merefleksi_json_5'), true);

    $validationRules = [
      'tanggal'         => 'required',
      'semester'        => 'required',
      'pekan'           => 'required|numeric',
      'model_pembelajaran' => 'required',
      'subtopik_pembelajaran'  => 'required',
      'topik_pembelajaran' => 'required',
    ];

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Data Modul Ajar gagal validasi',
        'errors'  => $this->validator->getErrors()
      ]);
    }


    if ($file && $file->isValid() && !$file->hasMoved()) {
      $fotoName = $file->getRandomName();
      $file->move('uploads/foto_modulajar', $fotoName);
    }

    // Simpan ke database
    $modulAjarData = [
      'kelas_id'         => session("kelas_id"),
      'dibuat_tanggal'         => $data['tanggal'],
      'semester'        => session("id_set"),

      'pembukaan_1' => json_encode($pembukaan1),
      'kegiatan_inti_1' => json_encode($kegiatan_inti1),
      'pertanyaan_pemantik_1' => json_encode($pertanyaan_pemantik1),
      'merefleksi_1' => json_encode($merefleksi1),

      'pembukaan_2' => json_encode($pembukaan2),
      'kegiatan_inti_2' => json_encode($kegiatan_inti2),
      'pertanyaan_pemantik_2' => json_encode($pertanyaan_pemantik2),
      'merefleksi_2' => json_encode($merefleksi2),

      'pembukaan_3' => json_encode($pembukaan3),
      'kegiatan_inti_3' => json_encode($kegiatan_inti3),
      'pertanyaan_pemantik_3' => json_encode($pertanyaan_pemantik3),
      'merefleksi_3' => json_encode($merefleksi3),

      'pembukaan_4' => json_encode($pembukaan4),
      'kegiatan_inti_4' => json_encode($kegiatan_inti4),
      'pertanyaan_pemantik_4' => json_encode($pertanyaan_pemantik4),
      'merefleksi_4' => json_encode($merefleksi4),

      'pembukaan_5' => json_encode($pembukaan5),
      'kegiatan_inti_5' => json_encode($kegiatan_inti5),
      'pertanyaan_pemantik_5' => json_encode($pertanyaan_pemantik5),
      'merefleksi_5' => json_encode($merefleksi5),

      'pekan'           => $data['pekan'],
      'model_pembelajaran' => $data['model_pembelajaran'],
      'topik_pembelajaran' => $data['topik_pembelajaran'],
      'subtopik_pembelajaran'  => $data['subtopik_pembelajaran'],
      'tujuan_pembelajaran' => $data['tujuan_pembelajaran_json'],
      'dimensi_profil_lulusan' => $data['dimensi_profil_lulusan_json'],
      'kurikulum_cinta' => $data['kurikulum_cinta_json'],
      'deskripsi_mediaPembelajaran' => '-',
      'foto_mediaPembelajaran'  => $fotoName,
      'subsubTopik_tanggal1'   => $data['tgl_subsubtopik1'],
      'subsubTopik_1'       => $data['subsubtopik1'],
      'subsubTopik_tanggal2'   => $data['tgl_subsubtopik2'],
      'subsubTopik_2'       => $data['subsubtopik2'],
      'subsubTopik_tanggal3'   => $data['tgl_subsubtopik3'],
      'subsubTopik_3'       => $data['subsubtopik3'],
      'subsubTopik_tanggal4'   => $data['tgl_subsubtopik4'],
      'subsubTopik_4'       => $data['subsubtopik4'],
      'subsubTopik_tanggal5'   => $data['tgl_subsubtopik5'],
      'subsubTopik_5'       => $data['subsubtopik5'],

      'mediapembelajaran_1' => $data['alatbahan1'],
      'mediapembelajaran_2' => $data['alatbahan2'],
      'mediapembelajaran_3' => $data['alatbahan3'],
      'mediapembelajaran_4' => $data['alatbahan4'],
      'mediapembelajaran_5' => $data['alatbahan5'],


      'pembuat' => session("user_id"),
    ];

    $this->modulAjarModel->insert($modulAjarData);
    $modulajar_id = $this->modulAjarModel->getInsertID();

    $desainPembelajaranData = [
      'modulajar_id_dp' => $modulajar_id,
      'pedagogik_model' => $data['model_praktik_pedagogik'],
      'pedagogik_strategi' => $data['strategi_praktik_pedagogik'],
      'pedagogik_metode' => $data['metode_praktik_pedagogik'],
      'kemitraan' => $data['kemitraaan_pembelajaran'],
      'ruang_fisik' => $data['lingkungan_pembelajaran_ruang_fisik'],
      'ruang_virtual' => $data['lingkungan_pembelajaran_ruang_virtual'],
      'pemanfaatan_digital' => $data['pemanfaatan_digital'],
    ];

    $selectData = [
      'modulajar_id_select' => $modulajar_id,

      // ✅ HAPUS SPASI di akhir key
      'pembukaan_1_select' => json_encode($pembukaan_select_json_1),
      'pembukaan_2_select' => json_encode($pembukaan_select_json_2),
      'pembukaan_3_select' => json_encode($pembukaan_select_json_3),
      'pembukaan_4_select' => json_encode($pembukaan_select_json_4),
      'pembukaan_5_select' => json_encode($pembukaan_select_json_5),

      'inti_1_select' => json_encode($inti_select_json_1),
      'inti_2_select' => json_encode($inti_select_json_2),
      'inti_3_select' => json_encode($inti_select_json_3),
      'inti_4_select' => json_encode($inti_select_json_4),
      'inti_5_select' => json_encode($inti_select_json_5),

      'merefleksi_1_select' => json_encode($merefleksi_select_json_1),
      'merefleksi_2_select' => json_encode($merefleksi_select_json_2),
      'merefleksi_3_select' => json_encode($merefleksi_select_json_3),
      'merefleksi_4_select' => json_encode($merefleksi_select_json_4),
      'merefleksi_5_select' => json_encode($merefleksi_select_json_5),
    ];

    $this->desainPembelajaran->insert($desainPembelajaranData);
    $this->selectKBCDPL->insert($selectData);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Modul Ajar berhasil disimpan'
    ]);
  }

  public function ubahdata()
  {
    log_message('debug', 'Masuk ke ubahdata()');
    log_message('debug', 'POST: ' . print_r($this->request->getPost(), true));
    log_message('debug', 'FILES: ' . print_r($_FILES, true));

    $data = $this->request->getPost();
    $id   = $data['id'];
    $file = $this->request->getFile('foto_modulajar');


    $inti_select_json_1 = json_decode($data['inti_select_json_1'], true);
    $inti_select_json_2 = json_decode($data['inti_select_json_2'], true);
    $inti_select_json_3 = json_decode($data['inti_select_json_3'], true);
    $inti_select_json_4 = json_decode($data['inti_select_json_4'], true);
    $inti_select_json_5 = json_decode($data['inti_select_json_5'], true);

    $pembukaan_select_json_1 = json_decode($data['pembukaan_select_json_1'], true);
    $pembukaan_select_json_2 = json_decode($data['pembukaan_select_json_2'], true);
    $pembukaan_select_json_3 = json_decode($data['pembukaan_select_json_3'], true);
    $pembukaan_select_json_4 = json_decode($data['pembukaan_select_json_4'], true);
    $pembukaan_select_json_5 = json_decode($data['pembukaan_select_json_5'], true);

    $merefleksi_select_json_1 = json_decode($data['merefleksi_select_json_1'], true);
    $merefleksi_select_json_2 = json_decode($data['merefleksi_select_json_2'], true);
    $merefleksi_select_json_3 = json_decode($data['merefleksi_select_json_3'], true);
    $merefleksi_select_json_4 = json_decode($data['merefleksi_select_json_4'], true);
    $merefleksi_select_json_5 = json_decode($data['merefleksi_select_json_5'], true);


    $pembukaan1 = json_decode($data['pembukaan_json_1'], true);
    $kegiatan_inti1 = json_decode($this->request->getPost('inti_json_1'), true);
    $pertanyaan_pemantik1 = json_decode($this->request->getPost('pemantik_json_1'), true);
    $merefleksi1 = json_decode($this->request->getPost('merefleksi_json_1'), true);

    $pembukaan2 = json_decode($data['pembukaan_json_2'], true);
    $kegiatan_inti2 = json_decode($this->request->getPost('inti_json_2'), true);
    $pertanyaan_pemantik2 = json_decode($this->request->getPost('pemantik_json_2'), true);
    $merefleksi2 = json_decode($this->request->getPost('merefleksi_json_2'), true);

    $pembukaan3 = json_decode($data['pembukaan_json_3'], true);
    $kegiatan_inti3 = json_decode($this->request->getPost('inti_json_3'), true);
    $pertanyaan_pemantik3 = json_decode($this->request->getPost('pemantik_json_3'), true);
    $merefleksi3 = json_decode($this->request->getPost('merefleksi_json_3'), true);

    $pembukaan4 = json_decode($data['pembukaan_json_4'], true);
    $kegiatan_inti4 = json_decode($this->request->getPost('inti_json_4'), true);
    $pertanyaan_pemantik4 = json_decode($this->request->getPost('pemantik_json_4'), true);
    $merefleksi4 = json_decode($this->request->getPost('merefleksi_json_4'), true);

    $pembukaan5 = json_decode($data['pembukaan_json_5'], true);
    $kegiatan_inti5 = json_decode($this->request->getPost('inti_json_5'), true);
    $pertanyaan_pemantik5 = json_decode($this->request->getPost('pemantik_json_5'), true);
    $merefleksi5 = json_decode($this->request->getPost('merefleksi_json_5'), true);
    // dd($merefleksi1);

    $validationRules = [
      'tanggal'         => 'required',
      'semester'        => 'required',
      'pekan'           => 'required|numeric',
      'model_pembelajaran' => 'required',
      'subtopik_pembelajaran'  => 'required',
      'topik_pembelajaran' => 'required',
    ];

    // Validasi upload foto jika ada file baru
    if ($file && $file->isValid() && !$file->hasMoved()) {
      $validationRules['foto_modulajar'] = 'is_image[foto_modulajar]|mime_in[foto_modulajar,image/jpg,image/jpeg,image/png]|max_size[foto_modulajar,512]';
    }

    if (!$this->validate($validationRules)) {
      log_message('debug', 'Validasi gagal: ' . print_r($this->validator->getErrors(), true));

      return $this->response->setStatusCode(400)->setJSON([
        'status'  => 'errors validation',
        'message' => 'Validasi gagal saat mengubah data Modul Ajar',
        'errors'  => $this->validator->getErrors()
      ]);
    }

    $modulAjarLama = $this->modulAjarModel->find($id);
    $fotoName = $modulAjarLama['foto_mediaPembelajaran'] ?? "";

    // Jika upload foto baru
    if ($file && $file->isValid() && !$file->hasMoved()) {
      $fotoName = $file->getRandomName();
      $file->move('public/uploads/foto_modulajar', $fotoName);

      // Hapus foto lama
      if ($modulAjarLama['foto_mediaPembelajaran'] && file_exists('public/uploads/foto_modulajar/' . $modulAjarLama['foto_mediaPembelajaran'])) {
        unlink('public/uploads/foto_modulajar/' . $modulAjarLama['foto_mediaPembelajaran']);
      }
    }

    $modulAjarData = [
      'id' => $id,
      'kelas_id'         => session("kelas_id"),
      'dibuat_tanggal'   => $data['tanggal'],
      // 'semester'         => session("id_set"),
      'pembukaan_1' => json_encode($pembukaan1),
      'kegiatan_inti_1' => json_encode($kegiatan_inti1),
      'pertanyaan_pemantik_1' => json_encode($pertanyaan_pemantik1),
      'merefleksi_1' => json_encode($merefleksi1),

      'pembukaan_2' => json_encode($pembukaan2),
      'kegiatan_inti_2' => json_encode($kegiatan_inti2),
      'pertanyaan_pemantik_2' => json_encode($pertanyaan_pemantik2),
      'merefleksi_2' => json_encode($merefleksi2),

      'pembukaan_3' => json_encode($pembukaan3),
      'kegiatan_inti_3' => json_encode($kegiatan_inti3),
      'pertanyaan_pemantik_3' => json_encode($pertanyaan_pemantik3),
      'merefleksi_3' => json_encode($merefleksi3),

      'pembukaan_4' => json_encode($pembukaan4),
      'kegiatan_inti_4' => json_encode($kegiatan_inti4),
      'pertanyaan_pemantik_4' => json_encode($pertanyaan_pemantik4),
      'merefleksi_4' => json_encode($merefleksi4),

      'pembukaan_5' => json_encode($pembukaan5),
      'kegiatan_inti_5' => json_encode($kegiatan_inti5),
      'pertanyaan_pemantik_5' => json_encode($pertanyaan_pemantik5),
      'merefleksi_5' => json_encode($merefleksi5),

      'pekan'           => $data['pekan'],
      'model_pembelajaran' => $data['model_pembelajaran'],
      'topik_pembelajaran' => $data['topik_pembelajaran'],
      'subtopik_pembelajaran'  => $data['subtopik_pembelajaran'],
      'tujuan_pembelajaran' => $data['tujuan_pembelajaran_json'],
      'dimensi_profil_lulusan' => $data['dimensi_profil_lulusan_json'],
      'kurikulum_cinta' => $data['kurikulum_cinta_json'],
      'deskripsi_mediaPembelajaran' => '-',
      'foto_mediaPembelajaran'  => $fotoName,
      'subsubTopik_tanggal1'   => $data['tgl_subsubtopik1'],
      'subsubTopik_1'       => $data['subsubtopik1'],
      'subsubTopik_tanggal2'   => $data['tgl_subsubtopik2'],
      'subsubTopik_2'       => $data['subsubtopik2'],
      'subsubTopik_tanggal3'   => $data['tgl_subsubtopik3'],
      'subsubTopik_3'       => $data['subsubtopik3'],
      'subsubTopik_tanggal4'   => $data['tgl_subsubtopik4'],
      'subsubTopik_4'       => $data['subsubtopik4'],
      'subsubTopik_tanggal5'   => $data['tgl_subsubtopik5'],
      'subsubTopik_5'       => $data['subsubtopik5'],

      'mediapembelajaran_1' => $data['alatbahan1'],
      'mediapembelajaran_2' => $data['alatbahan2'],
      'mediapembelajaran_3' => $data['alatbahan3'],
      'mediapembelajaran_4' => $data['alatbahan4'],
      'mediapembelajaran_5' => $data['alatbahan5'],
    ];

    $simpan = $this->modulAjarModel->save($modulAjarData);

    log_message('debug', 'Hasil save modulAjarModel: ' . ($simpan ? 'Berhasil' : 'Gagal'));


    // Cek apakah data untuk modulajar_id ini sudah ada
    $existingData = $this->desainPembelajaran->where('modulajar_id_dp', $id)->first();
    $existingData2 = $this->selectKBCDPL->where('modulajar_id_select', $id)->first();

    // Siapkan data yang akan disimpan
    $desainPembelajaranData = [
      'pedagogik_model' => $data['model_praktik_pedagogik'],
      'pedagogik_strategi' => $data['strategi_praktik_pedagogik'],
      'pedagogik_metode' => $data['metode_praktik_pedagogik'],
      'kemitraan' => $data['kemitraaan_pembelajaran'],
      'ruang_fisik' => $data['lingkungan_pembelajaran_ruang_fisik'],
      'ruang_virtual' => $data['lingkungan_pembelajaran_ruang_virtual'],
      'pemanfaatan_digital' => $data['pemanfaatan_digital'],
    ];

    $selectData = [
      'pembukaan_1_select' => json_encode($pembukaan_select_json_1),
      'pembukaan_2_select' => json_encode($pembukaan_select_json_2),
      'pembukaan_3_select' => json_encode($pembukaan_select_json_3),
      'pembukaan_4_select' => json_encode($pembukaan_select_json_4),
      'pembukaan_5_select' => json_encode($pembukaan_select_json_5),

      'inti_1_select' => json_encode($inti_select_json_1),
      'inti_2_select' => json_encode($inti_select_json_2),
      'inti_3_select' => json_encode($inti_select_json_3),
      'inti_4_select' => json_encode($inti_select_json_4),
      'inti_5_select' => json_encode($inti_select_json_5),

      'merefleksi_1_select' => json_encode($merefleksi_select_json_1),
      'merefleksi_2_select' => json_encode($merefleksi_select_json_2),
      'merefleksi_3_select' => json_encode($merefleksi_select_json_3),
      'merefleksi_4_select' => json_encode($merefleksi_select_json_4),
      'merefleksi_5_select' => json_encode($merefleksi_select_json_5),
    ];

    // Tambahkan error handling
    if ($existingData) {
      $desainPembelajaranData['id'] = $existingData['id'];
      $result = $this->desainPembelajaran->save($desainPembelajaranData);

      if (!$result) {
        log_message('error', 'Gagal update desain pembelajaran: ' . print_r($this->desainPembelajaran->errors(), true));
      }
    } else {
      $desainPembelajaranData['modulajar_id_dp'] = $id;
      $result = $this->desainPembelajaran->save($desainPembelajaranData);

      if (!$result) {
        log_message('error', 'Gagal insert desain pembelajaran: ' . print_r($this->desainPembelajaran->errors(), true));
      }
    }

    if ($existingData2) {
      // Jika data sudah ada, tambahkan primary key dari tabel desain_pembelajaran
      // Asumsi primary key-nya adalah 'id'
      $selectData['id'] = $existingData2['id'];

      // Lakukan UPDATE dengan metode save()
      $this->selectKBCDPL->save($selectData);
    } else {
      // Jika data belum ada, tambahkan modulajar_id ke data
      $selectData['modulajar_id_select'] = $id;

      // Lakukan INSERT dengan metode save()
      $this->selectKBCDPL->save($selectData);
    }

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data Modul Ajar berhasil diperbarui'
    ]);
  }


  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdmodulajar');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->modulAjarModel->update($id, ['deleted' => 1]);

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
    // $kurikulum_cinta_model = new KurikulumCintaModel();
    $kurikulum_cinta = $this->kurikulumCintaModel->where('deleted', 0)->findAll(); // Ambil semua kategori
    $dimensi_profil = $this->dimensiProfilModel->where('deleted', 0)->findAll(); // Ambil semua kategori
    $data = [
      'title' => 'Modul Ajar | KBRA Islamic Center',
      'nav' => 'modul_ajar',
      'kurikulum_cinta' => json_encode($kurikulum_cinta),
      'dimensi_profil' => json_encode($dimensi_profil),
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_modulAjar', $data); // pakai render() dari CustomController
  }

  public function get_data_select_dpl_kbc($id)
  {
    $query = $this->selectKBCDPL->getByModulajar($id);
    //$result = $query->row(); // 1 baris, karena 1 modulajar_id biasanya 1 set pilihan

    header('Content-Type: application/json');
    return $this->response->setJSON($query);
  }

  public function ambil_data_modulajar()
  {
    $data = $this->modulAjarModel
      ->select('modul_ajar.*, desain_pembelajaran.modulajar_id_dp as modulajar_id_dp, pedagogik_model, 
      pedagogik_strategi, pedagogik_metode, kemitraan, ruang_fisik, ruang_virtual, pemanfaatan_digital, 
      pembukaan_1_select, inti_1_select, merefleksi_1_select, 
      pembukaan_2_select, inti_2_select, merefleksi_2_select, 
      pembukaan_3_select, inti_3_select, merefleksi_3_select, 
      pembukaan_4_select, inti_4_select, merefleksi_4_select, 
      pembukaan_5_select, inti_5_select, merefleksi_5_select, 
      COALESCE(guru.nama, "Tidak ada pemiliknya") as pembuat_nama,
      semester.semester as nama_semester') // Select all columns from modul_ajar and the semester name
      ->where('modul_ajar.deleted', 0)
      ->where('modul_ajar.kelas_id', $this->session->get('kelas_id'))
      ->join('semester', 'semester.id = modul_ajar.semester') // Assuming the foreign key in modul_ajar is 'semester_id'
      ->join('guru', 'guru.id = modul_ajar.pembuat', 'left')
      ->join('desain_pembelajaran', 'desain_pembelajaran.modulajar_id_dp = modul_ajar.id', 'left') // Assuming the foreign key in modul_ajar is 'semester_id'
      ->join('data_select_dpl_kbc', 'data_select_dpl_kbc.modulajar_id_select = modul_ajar.id', 'left') // Assuming the foreign key in modul_ajar is 'semester_id'
      ->orderBy('modul_ajar.id', 'DESC')
      ->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }

  public function ambil_data_tp()
  {
    $request = $this->request;
    $search = $request->getGet('q'); // Query pencarian dari Select2
    $page = $request->getGet('page') ?? 1; // Halaman dari Select2
    $perPage = 100; // Jumlah item per halaman
    $id_set_session = $this->session->get('tahun'); // Ambil id_set dari session

    // Mulai builder dari TujuanPembelajaranModel karena itu yang ingin kita tampilkan
    $builder = $this->tujuanPembelajaranModel->builder();

    // ** LANGKAH 1: Lakukan JOIN dengan tabel capaianPembelajaran **
    // Asumsi: 'tujuanPembelajaran.id_capaian' adalah foreign key yang merujuk ke 'capaianPembelajaran.id'
    $builder->join(
      'capaian_pembelajaran', // Nama tabel yang akan di-JOIN
      'capaian_pembelajaran.id = tujuan_pembelajaran.capaian', // Kondisi JOIN
      'inner' // Gunakan inner join untuk hanya mengambil yang cocok di kedua tabel
    );

    // ** LANGKAH 2: Terapkan kondisi WHERE dari tabel capaianPembelajaran **
    $builder->where('capaian_pembelajaran.deleted', 0);
    $builder->where('capaian_pembelajaran.setting', $id_set_session);

    // ** LANGKAH 3: Terapkan kondisi WHERE dari tabel tujuanPembelajaran **
    $builder->where('tujuan_pembelajaran.deleted', 0); // Kondisi deleted untuk tujuan pembelajaran itu sendiri

    // Jika ada pencarian, tambahkan kondisi LIKE pada kolom nama tujuan pembelajaran
    if (!empty($search)) {
      $builder->like('tujuan_pembelajaran.nama', $search, 'both'); // Pastikan spesifik ke kolom 'nama' di tabel tujuanPembelajaran
      // Anda bisa tambahkan kolom lain untuk pencarian jika diperlukan:
      // ->orLike('tujuanPembelajaran.kode_tp', $search, 'both');
    }

    // ** LANGKAH 4: Hitung total_count untuk pagination (tanpa limit dan offset) **
    // Penting: countAllResults(false) untuk tidak mereset builder setelah penghitungan
    $total_count = $builder->countAllResults(false);

    // ** LANGKAH 5: Tambahkan limit, offset, dan orderBy untuk hasil yang sebenarnya **
    $query = $builder
      ->select('tujuan_pembelajaran.id, tujuan_pembelajaran.nama') // Pilih kolom yang dibutuhkan (id dan nama)
      ->limit($perPage, ($page - 1) * $perPage)
      ->orderBy('capaian_pembelajaran.urut', 'ASC')
      ->orderBy('tujuan_pembelajaran.id', 'ASC')
      ->get(); // Eksekusi kueri dengan get()

    $tujuan = $query->getResultArray();

    // ** LANGKAH 6: Format hasil untuk Select2 **
    $results = [];
    foreach ($tujuan as $item) {
      $results[] = [
        'id' => $item['id'], // ID unik untuk setiap tujuan
        'text' => $item['nama'] // Teks yang akan ditampilkan di dropdown Select2
      ];
    }

    // ** LANGKAH 7: Kembalikan respons dalam format JSON yang diharapkan Select2 **
    $response = [
      'results' => $results,
      'pagination' => [
        'more' => ($page * $perPage) < $total_count // Menunjukkan apakah ada lebih banyak halaman
      ],
      // 'total_count' => $total_count // Opsional, bisa membantu debugging
    ];

    return $this->response->setJSON($response);
  }

  public function ambil_data_dimensi()
  {
    $tahun = session()->get('tahun');

    $builder = \Config\Database::connect()->table('dimensi_profil_lulusan');
    $data = $builder->select('id, nama AS text')
      ->where('setting', $tahun)
      ->where('deleted', '0')
      ->get()
      ->getResult();

    return $this->response->setJSON($data);
  }

  public function ambil_data_kurikulum()
  {
    $tahun = session()->get('tahun');

    $builder = \Config\Database::connect()->table('kurikulum_cinta');
    $data = $builder->select('id, nama AS text')
      ->where('setting', $tahun)
      ->where('deleted', '0')
      ->get()
      ->getResult();

    return $this->response->setJSON($data);
  }

  public function ambil_selected_texts()
  {
    $request = service('request');
    $ids = $request->getGet('ids');

    if (!is_array($ids)) {
      $ids = [$ids];
    }

    $tujuan = $this->tujuanPembelajaranModel->select('id, nama')
      ->whereIn('id', $ids)
      ->findAll();

    $formattedData = array_map(function ($item) {
      return ['id' => (string)$item['id'], 'text' => $item['nama']];
    }, $tujuan);

    // Mengambil objek Response
    $response = service('response'); // atau $this->response jika menggunakan CodeIgniter\Controller

    // Mengatur Content-Type header
    $response->setHeader('Content-Type', 'application/json');

    // Mengembalikan respons dalam format JSON
    return $response->setJSON($formattedData);
  }

  public function download($modulId)
  {
    // Redirect ke halaman customize
    return redirect()->to(base_url("modulajar/customize/{$modulId}"));
  }

  public function customize($modulId)
  {
    // Ambil semua data seperti di fungsi download
    $tanggalValue = '';
    $dataChecklist = [];

    $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

    if ($kelas['jenjang'] == 'RA') {
      $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
      $nama_kepala = "Kepala Sekolah";
      $kelompok_usia = "Usia 5-6 Tahun";
    } else {
      $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
      $nama_kepala = "Kepala KB IT Islamic Center";
      $kelompok_usia = "Usia 4-5 Tahun";
    }

    $semester = $this->semesterModel
      ->where('tingkat', $kelas['jenjang'])
      ->where('tahun', $this->session->get('tahun'))
      ->where('semester', $this->session->get('semester'))->first();

    $tanggalValue = 'Semua Tanggal';
    $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
    $kbcdpl = $this->selectKBCDPL->where('modulajar_id_select', $modulId)->first();
    $dp = $this->desainPembelajaran->where('modulajar_id_dp', $modulId)->first();

    $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
    $wali = $this->guruModel->where('id', $kelas['wali'])->first();
    $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('id_set'))->findAll();

    $tujuan_pembelajaran = $this->tujuanPembelajaranModel->getWithCapaianPembelajaran($this->session->get('id_set'));

    $ids = json_decode($modulAjar['tujuan_pembelajaran']);
    $dataTujuanPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIds($ids);
    $dataCapaianPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIdsGroupedByCapaian($ids);

    $idsdimensi = json_decode($modulAjar['dimensi_profil_lulusan']);
    $dataDimensiPembelajaran = $this->dimensiProfilModel->getRecordsByIds($idsdimensi);

    $idskurikulum = json_decode($modulAjar['kurikulum_cinta']);
    $dataKurikulumCinta = $this->kurikulumCintaModel->getRecordsByIds($idskurikulum);

    $data = [
      'modul_ajar_id' => $modulId,
      'capaian_pembelajaran' => $capaian_pembelajaran,
      'tujuan_pembelajaran' => $tujuan_pembelajaran,
      'tanggal_asesmen' => $tanggalValue,
      'semester_nama' => $semester['semester'],
      'semester' => session("semester"),
      'tahun' => session("tahun"),
      'kelompok_usia' => $kelompok_usia,
      'nama_tingkat' => $nama_tingkat,
      'nama_kepala' => $nama_kepala,
      'kepala' => $kepala['nama'],
      'wali' => $wali['nama'],
      'data_modulajar' => $modulAjar,
      'data_kbcdpl' => $kbcdpl,
      'data_dp' => $dp,
      'records' => $dataChecklist,
      'dataTujuanPembelajarans' => $dataTujuanPembelajaran,
      'dataDimensiPembelajarans' => $dataDimensiPembelajaran,
      'dataKurikulumCintas' => $dataKurikulumCinta,
      'dataCapaianPembelajarans' => $dataCapaianPembelajaran,
    ];

    // Render ke halaman customize
    return view('admin/pdf/customize_pdf', $data);
  }

  public function generateCustomPdf()
  {
    // Ambil data POST dari form customize
    $customSettings = [
      'margin_top' => $this->request->getPost('margin_top') ?? '1.3cm',
      'margin_bottom' => $this->request->getPost('margin_bottom') ?? '2cm',
      'margin_left' => $this->request->getPost('margin_left') ?? '3cm',
      'margin_right' => $this->request->getPost('margin_right') ?? '1cm',
      'font_size' => $this->request->getPost('font_size') ?? '10pt',
      'line_height' => $this->request->getPost('line_height') ?? '1.08',
      'point_spacing' => $this->request->getPost('point_spacing') ?? '5px',
      'font_judul' => $this->request->getPost('font_judul') ?? '14px',
    ];

    $modulId = $this->request->getPost('modul_id');

    // Ambil semua data seperti sebelumnya (copy dari fungsi download)
    $tanggalValue = '';
    $dataChecklist = [];

    $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

    if ($kelas['jenjang'] == 'RA') {
      $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
      $nama_kepala = "Kepala Sekolah";
      $kelompok_usia = "Usia 5-6 Tahun";
    } else {
      $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
      $nama_kepala = "Kepala KB IT Islamic Center";
      $kelompok_usia = "Usia 4-5 Tahun";
    }

    $semester = $this->semesterModel
      ->where('tingkat', $kelas['jenjang'])
      ->where('tahun', $this->session->get('tahun'))
      ->where('semester', $this->session->get('semester'))->first();

    $tanggalValue = 'Semua Tanggal';
    $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
    $kbcdpl = $this->selectKBCDPL->where('modulajar_id_select', $modulId)->first();
    $dp = $this->desainPembelajaran->where('modulajar_id_dp', $modulId)->first();

    $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
    $wali = $this->guruModel->where('id', $kelas['wali'])->first();
    $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('id_set'))->findAll();

    $tujuan_pembelajaran = $this->tujuanPembelajaranModel->getWithCapaianPembelajaran($this->session->get('id_set'));

    $ids = json_decode($modulAjar['tujuan_pembelajaran']);
    $dataTujuanPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIds($ids);
    $dataCapaianPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIdsGroupedByCapaian($ids);

    $idsdimensi = json_decode($modulAjar['dimensi_profil_lulusan']);
    $dataDimensiPembelajaran = $this->dimensiProfilModel->getRecordsByIds($idsdimensi);

    $idskurikulum = json_decode($modulAjar['kurikulum_cinta']);
    $dataKurikulumCinta = $this->kurikulumCintaModel->getRecordsByIds($idskurikulum);

    $data = [
      'modul_ajar_id' => $modulId,
      'capaian_pembelajaran' => $capaian_pembelajaran,
      'tujuan_pembelajaran' => $tujuan_pembelajaran,
      'tanggal_asesmen' => $tanggalValue,
      'semester_nama' => $semester['semester'],
      'semester' => session("semester"),
      'tahun' => session("tahun"),
      'kelompok_usia' => $kelompok_usia,
      'nama_tingkat' => $nama_tingkat,
      'nama_kepala' => $nama_kepala,
      'kepala' => $kepala['nama'],
      'wali' => $wali['nama'],
      'data_modulajar' => $modulAjar,
      'data_kbcdpl' => $kbcdpl,
      'data_dp' => $dp,
      'records' => $dataChecklist,
      'dataTujuanPembelajarans' => $dataTujuanPembelajaran,
      'dataDimensiPembelajarans' => $dataDimensiPembelajaran,
      'dataKurikulumCintas' => $dataKurikulumCinta,
      'dataCapaianPembelajarans' => $dataCapaianPembelajaran,
      'customSettings' => $customSettings, // Tambahkan custom settings
    ];

    // Render view HTML dengan custom settings
    $html = view('admin/pdf/modulajar_pdf_template_custom', $data);

    // Generate PDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'sans-serif');

    $dompdf = new Dompdf($options);
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->set_option('defaultFont', 'Times New Roman');
    $html = preg_replace('/>\s+</', "><", $html);
    $dompdf->loadHtml($html);
    $dompdf->setPaper([0, 0, 609.45, 935.43], 'portrait'); // F4: 215mm x 330mm
    $dompdf->render();

    $filename = 'ModulAjar_' . date('YmdHis') . '.pdf';
    $dompdf->stream($filename, ['Attachment' => 1]);
  }

  public function previewPdf()
  {
    try {
      // Ambil data POST dari customize
      $customSettings = [
        'margin_top' => $this->request->getPost('margin_top') ?? '1.3cm',
        'margin_bottom' => $this->request->getPost('margin_bottom') ?? '2cm',
        'margin_left' => $this->request->getPost('margin_left') ?? '3cm',
        'margin_right' => $this->request->getPost('margin_right') ?? '1cm',
        'font_size' => $this->request->getPost('font_size') ?? '10pt',
        'line_height' => $this->request->getPost('line_height') ?? '1.08',
        'point_spacing' => $this->request->getPost('point_spacing') ?? '5px',
        'font_judul' => $this->request->getPost('font_judul') ?? '14px',
      ];

      $modulId = $this->request->getPost('modul_id');

      if (!$modulId) {
        return $this->response->setStatusCode(400)->setBody('Modul ID tidak ditemukan');
      }

      // Ambil semua data
      $tanggalValue = '';
      $dataChecklist = [];

      $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

      if ($kelas['jenjang'] == 'RA') {
        $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
        $nama_kepala = "Kepala Sekolah";
        $kelompok_usia = "Usia 5-6 Tahun";
      } else {
        $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
        $nama_kepala = "Kepala KB IT Islamic Center";
        $kelompok_usia = "Usia 4-5 Tahun";
      }

      $semester = $this->semesterModel
        ->where('tingkat', $kelas['jenjang'])
        ->where('tahun', $this->session->get('tahun'))
        ->where('semester', $this->session->get('semester'))->first();

      $tanggalValue = 'Semua Tanggal';
      $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      $kbcdpl = $this->selectKBCDPL->where('modulajar_id_select', $modulId)->first();
      $dp = $this->desainPembelajaran->where('modulajar_id_dp', $modulId)->first();

      $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
      $wali = $this->guruModel->where('id', $kelas['wali'])->first();
      $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('id_set'))->findAll();

      $tujuan_pembelajaran = $this->tujuanPembelajaranModel->getWithCapaianPembelajaran($this->session->get('id_set'));

      $ids = json_decode($modulAjar['tujuan_pembelajaran']);
      $dataTujuanPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIds($ids);
      $dataCapaianPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIdsGroupedByCapaian($ids);

      $idsdimensi = json_decode($modulAjar['dimensi_profil_lulusan']);
      $dataDimensiPembelajaran = $this->dimensiProfilModel->getRecordsByIds($idsdimensi);

      $idskurikulum = json_decode($modulAjar['kurikulum_cinta']);
      $dataKurikulumCinta = $this->kurikulumCintaModel->getRecordsByIds($idskurikulum);

      $data = [
        'modul_ajar_id' => $modulId,
        'capaian_pembelajaran' => $capaian_pembelajaran,
        'tujuan_pembelajaran' => $tujuan_pembelajaran,
        'tanggal_asesmen' => $tanggalValue,
        'semester_nama' => $semester['semester'],
        'semester' => session("semester"),
        'tahun' => session("tahun"),
        'kelompok_usia' => $kelompok_usia,
        'nama_tingkat' => $nama_tingkat,
        'nama_kepala' => $nama_kepala,
        'kepala' => $kepala['nama'],
        'wali' => $wali['nama'],
        'data_modulajar' => $modulAjar,
        'data_kbcdpl' => $kbcdpl,
        'data_dp' => $dp,
        'records' => $dataChecklist,
        'dataTujuanPembelajarans' => $dataTujuanPembelajaran,
        'dataDimensiPembelajarans' => $dataDimensiPembelajaran,
        'dataKurikulumCintas' => $dataKurikulumCinta,
        'dataCapaianPembelajarans' => $dataCapaianPembelajaran,
        'customSettings' => $customSettings,
      ];

      // ✅ Render view
      $html = view('admin/pdf/modulajar_pdf_template_custom', $data);

      // ✅ Bersihkan semua debug toolbar artifacts
      $html = preg_replace('/<!-- DEBUG-VIEW START.*?-->/s', '', $html);
      $html = preg_replace('/<!-- DEBUG-VIEW ENDED.*?-->/s', '', $html);
      $html = preg_replace('/<script id="debugbar_loader".*?<\/script>/s', '', $html);
      $html = preg_replace('/<script id="debugbar_dynamic_script".*?<\/script>/s', '', $html);
      $html = preg_replace('/<style id="debugbar_dynamic_style".*?<\/style>/s', '', $html);
      $html = preg_replace('/<div id="toolbarContainer".*?<\/div>/s', '', $html);

      // ✅ Return clean HTML
      return $this->response
        ->setHeader('Content-Type', 'text/html; charset=UTF-8')
        ->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->setBody($html);
    } catch (\Exception $e) {
      log_message('error', 'Preview PDF Error: ' . $e->getMessage());
      return $this->response->setStatusCode(500)->setBody('Error: ' . $e->getMessage());
    }
  }

  /**
   * Preview PDF Direct (100% Accurate - No Imagick)
   * Render PDF dengan DomPDF, return PDF binary ke iframe
   */
  public function previewPdfDirect()
  {
    try {
      // Ambil data POST dari customize
      $customSettings = [
        'margin_top' => $this->request->getPost('margin_top') ?? '1.3cm',
        'margin_bottom' => $this->request->getPost('margin_bottom') ?? '2cm',
        'margin_left' => $this->request->getPost('margin_left') ?? '3cm',
        'margin_right' => $this->request->getPost('margin_right') ?? '1cm',
        'font_size' => $this->request->getPost('font_size') ?? '10pt',
        'line_height' => $this->request->getPost('line_height') ?? '1.08',
        'point_spacing' => $this->request->getPost('point_spacing') ?? '5px',
        'font_judul' => $this->request->getPost('font_judul') ?? '14px',
      ];

      $modulId = $this->request->getPost('modul_id');

      if (!$modulId) {
        return $this->response->setStatusCode(400)->setBody('Modul ID tidak ditemukan');
      }

      // Ambil semua data (sama seperti generateCustomPdf)
      $tanggalValue = '';
      $dataChecklist = [];

      $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

      if ($kelas['jenjang'] == 'RA') {
        $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
        $nama_kepala = "Kepala Sekolah";
        $kelompok_usia = "Usia 5-6 Tahun";
      } else {
        $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
        $nama_kepala = "Kepala KB IT Islamic Center";
        $kelompok_usia = "Usia 4-5 Tahun";
      }

      $semester = $this->semesterModel
        ->where('tingkat', $kelas['jenjang'])
        ->where('tahun', $this->session->get('tahun'))
        ->where('semester', $this->session->get('semester'))->first();

      $tanggalValue = 'Semua Tanggal';
      $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      $kbcdpl = $this->selectKBCDPL->where('modulajar_id_select', $modulId)->first();
      $dp = $this->desainPembelajaran->where('modulajar_id_dp', $modulId)->first();

      $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
      $wali = $this->guruModel->where('id', $kelas['wali'])->first();
      $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('id_set'))->findAll();

      $tujuan_pembelajaran = $this->tujuanPembelajaranModel->getWithCapaianPembelajaran($this->session->get('id_set'));

      $ids = json_decode($modulAjar['tujuan_pembelajaran']);
      $dataTujuanPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIds($ids);
      $dataCapaianPembelajaran = $this->tujuanPembelajaranModel->getRecordsByIdsGroupedByCapaian($ids);

      $idsdimensi = json_decode($modulAjar['dimensi_profil_lulusan']);
      $dataDimensiPembelajaran = $this->dimensiProfilModel->getRecordsByIds($idsdimensi);

      $idskurikulum = json_decode($modulAjar['kurikulum_cinta']);
      $dataKurikulumCinta = $this->kurikulumCintaModel->getRecordsByIds($idskurikulum);

      $data = [
        'modul_ajar_id' => $modulId,
        'capaian_pembelajaran' => $capaian_pembelajaran,
        'tujuan_pembelajaran' => $tujuan_pembelajaran,
        'tanggal_asesmen' => $tanggalValue,
        'semester_nama' => $semester['semester'],
        'semester' => session("semester"),
        'tahun' => session("tahun"),
        'kelompok_usia' => $kelompok_usia,
        'nama_tingkat' => $nama_tingkat,
        'nama_kepala' => $nama_kepala,
        'kepala' => $kepala['nama'],
        'wali' => $wali['nama'],
        'data_modulajar' => $modulAjar,
        'data_kbcdpl' => $kbcdpl,
        'data_dp' => $dp,
        'records' => $dataChecklist,
        'dataTujuanPembelajarans' => $dataTujuanPembelajaran,
        'dataDimensiPembelajarans' => $dataDimensiPembelajaran,
        'dataKurikulumCintas' => $dataKurikulumCinta,
        'dataCapaianPembelajarans' => $dataCapaianPembelajaran,
        'customSettings' => $customSettings,
      ];

      // ✅ Render HTML untuk PDF
      $html = view('admin/pdf/modulajar_pdf_template_custom', $data);

      // ✅ Generate PDF dengan DomPDF
      $options = new \Dompdf\Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true);
      $options->set('defaultFont', 'Times New Roman');

      $dompdf = new \Dompdf\Dompdf($options);
      $html = preg_replace('/>\s+</', "><", $html);
      $dompdf->loadHtml($html);
      $dompdf->setPaper([0, 0, 609.45, 935.43], 'portrait'); // F4: 215mm x 330mm
      $dompdf->render();

      // ✅ Get total pages
      $canvas = $dompdf->getCanvas();
      $totalPages = $canvas->get_page_count();

      // ✅ Output PDF ke browser
      $pdfOutput = $dompdf->output();

      // ✅ Return PDF dengan headers yang benar
      return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'inline; filename="preview.pdf"')
        ->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->setHeader('X-Total-Pages', $totalPages) // ✅ Kirim jumlah halaman via header
        ->setBody($pdfOutput);
    } catch (\Exception $e) {
      log_message('error', 'Preview PDF Direct Error: ' . $e->getMessage());
      return $this->response->setStatusCode(500)->setBody('Error: ' . $e->getMessage());
    }
  }
}
