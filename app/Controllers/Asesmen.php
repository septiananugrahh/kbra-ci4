<?php

namespace App\Controllers;

use App\Models\AsesmenAnekdotModel;
use App\Models\AsesmenChecklistModel;
use App\Models\AsesmenFotoBerseriModel;
use App\Models\AsesmenHasilKaryaModel;
use App\Models\CapaianPembelajaranModel;
use App\Models\KelasModel;
use App\Models\ModulAjarModel;
use App\Models\RuangKelasModel;
use App\Models\SantriModel;
use App\Models\SemesterModel;
use App\Models\TujuanPembelajaranModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Asesmen extends CustomController
{
  protected $santriModel;
  protected $modulAjarModel;
  protected $asesmenFotoModel;
  protected $asesmenAnekdotModel;
  protected $asesmenKaryaModel;
  protected $asesmenChecklistModel;
  protected $tujuanPembelajaranModel;
  protected $semesterModel;
  protected $guruModel;
  protected $kelasModel;
  protected $capaianPembelajaranModel;
  protected $ruangKelasModel;

  public function __construct()
  {
    $this->santriModel = new SantriModel();
    $this->modulAjarModel = new ModulAjarModel();
    $this->asesmenFotoModel = new AsesmenFotoBerseriModel();
    $this->asesmenAnekdotModel = new AsesmenAnekdotModel();
    $this->asesmenKaryaModel = new AsesmenHasilKaryaModel();
    $this->asesmenChecklistModel = new AsesmenChecklistModel();
    $this->tujuanPembelajaranModel = new TujuanPembelajaranModel();
    $this->semesterModel = new SemesterModel();
    $this->guruModel = new UserModel();
    $this->kelasModel = new KelasModel();
    $this->capaianPembelajaranModel = new CapaianPembelajaranModel();
    $this->ruangKelasModel = new RuangKelasModel();
  }

  public function simpan()
  {
    helper(['form']);

    $request = service('request');
    $response = service('response');

    // Pastikan ini adalah request POST
    if ($request->getMethod() !== 'POST') {
      return $response->setJSON(['status' => 'error', 'message' => 'Metode request tidak diizinkan.']);
    }

    $penilaianDisimpan = [];
    $santri_id = $this->request->getPost('santri_id');
    $modul_ajar_id = $this->request->getPost('modul_ajar_id');
    $tanggal = $this->request->getPost('tanggal');

    // Hanya proses jenis asesmen yang dikirim, supaya tab lain tidak tertimpa NULL.
    // ponytail: kalau nanti ada form gabungan multi-tab, ubah jadi array of jenis.
    $jenis = $this->request->getPost('jenis_asesmen');

    switch ($jenis) {
      case 'fotoberseri':
        $this->processFotoBerseri($santri_id, $modul_ajar_id, $tanggal, $request, $penilaianDisimpan);
        break;
      case 'checklist':
        $this->processChecklist($santri_id, $modul_ajar_id, $tanggal, $request, $penilaianDisimpan);
        break;
      case 'anekdot':
        $this->processAnekdot($santri_id, $modul_ajar_id, $tanggal, $request, $penilaianDisimpan);
        break;
      case 'hasilkarya':
        $this->processHasilKarya($santri_id, $modul_ajar_id, $tanggal, $request, $penilaianDisimpan);
        break;
      default:
        return $response->setJSON(['status' => 'error', 'message' => 'Jenis asesmen tidak valid.']);
    }

    return $this->response->setJSON([
      'status' => 'success',
      'penilaianDisimpan' => $penilaianDisimpan,
      'message' => 'Data Asesmen berhasil disimpan'
    ]);
  }



  /**
   * Process Foto Berseri
   */
  private function processFotoBerseri($santri_id, $modul_ajar_id, $tanggal, $request, &$penilaianDisimpan)
  {
    $existingAsesmenFoto = $this->asesmenFotoModel
      ->where('santri', $santri_id)
      ->where('modul_ajar_id', $modul_ajar_id)
      ->first();

    $foto_ket1 = $request->getPost('foto_ket1');
    $foto_ket2 = $request->getPost('foto_ket2');
    $foto_ket3 = $request->getPost('foto_ket3');
    $umpan_balik = $request->getPost('foto_umpan_balik');
    $analisis_guru = $request->getPost('foto_analisis') ?? [];

    $result_analisis_guru = [];
    foreach ($analisis_guru as $item) {
      if (!empty($item['analisis'])) {
        $result_analisis_guru[] = [
          'id_capaian' => $item['id_capaian'],
          'analisis' => $item['analisis'],
        ];
      }
    }

    // Handle file uploads
    $fotoPaths = [];
    for ($i = 1; $i <= 3; $i++) {
      $foto = $request->getFile("foto_$i");
      $fieldName = "foto$i"; // ✅ Konsisten dengan nama kolom di database (foto1, foto2, foto3)
      $oldFotoName = $existingAsesmenFoto[$fieldName] ?? null;
      $rotation = $request->getPost("rotation_foto_$i") ?? 0;

      if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        // Delete old file if exists
        if ($oldFotoName) {
          $oldFilePath = FCPATH . 'uploads/penilaian/' . $oldFotoName;
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }

        // Move new file
        $newName = $foto->getRandomName();
        $tempPath = FCPATH . 'uploads/penilaian/temp_' . $newName;
        $finalPath = FCPATH . 'uploads/penilaian/' . $newName;

        // Upload ke temporary path dulu
        $foto->move(FCPATH . 'uploads/penilaian', 'temp_' . $newName);

        // COMPRESS & RESIZE IMAGE (sekalian terapkan rotasi)
        if ($this->compressImage($tempPath, $finalPath, 1920, 75, $rotation)) {
          // Hapus file temporary setelah kompresi berhasil
          if (file_exists($tempPath)) {
            unlink($tempPath);
          }
          $fotoPaths[$fieldName] = $newName;
        } else {
          // Jika kompresi gagal, gunakan file asli (rename dari temp)
          if (file_exists($tempPath)) {
            rename($tempPath, $finalPath);
          }
          $this->_rotateExistingImage($newName, $rotation);
          $fotoPaths[$fieldName] = $newName;
        }
      } else {
        // ✅ PENTING: Keep old file name if no new file uploaded
        // Rotasi tetap diterapkan kalau user memutar gambar lama (tanpa upload ulang)
        $this->_rotateExistingImage($oldFotoName, $rotation);
        if ($oldFotoName) {
          $fotoPaths[$fieldName] = $oldFotoName;
        }
      }
    }

    $hasData = !empty($fotoPaths) ||
      !empty($foto_ket1) ||
      !empty($foto_ket2) ||
      !empty($foto_ket3) ||
      !empty($umpan_balik) ||
      !empty($result_analisis_guru);

    if ($hasData) {
      $dataFotoBerseri = [
        'santri' => $santri_id,
        'kelas' => session("kelas_id"),
        'semester' => '-',
        'modul_ajar_id' => $modul_ajar_id,
        'tanggal' => $tanggal,
        'foto1' => $fotoPaths['foto1'] ?? null, // ✅ Sekarang konsisten
        'foto2' => $fotoPaths['foto2'] ?? null,
        'foto3' => $fotoPaths['foto3'] ?? null,
        'ket_foto1' => $foto_ket1 ?: null,
        'ket_foto2' => $foto_ket2 ?: null,
        'ket_foto3' => $foto_ket3 ?: null,
        'analisis_guru' => !empty($result_analisis_guru) ? json_encode($result_analisis_guru) : null,
        'umpan_balik' => $umpan_balik ?: null,
        // Simpan rotasi ke database
        'rotation_foto1' => $request->getPost('rotation_foto_1') ?? 0,
        'rotation_foto2' => $request->getPost('rotation_foto_2') ?? 0,
        'rotation_foto3' => $request->getPost('rotation_foto_3') ?? 0,
      ];

      if ($existingAsesmenFoto) {
        $dataFotoBerseri['id'] = $existingAsesmenFoto['id'];
      }

      if ($this->asesmenFotoModel->save($dataFotoBerseri)) {
        $penilaianDisimpan[] = 'Foto Berseri';
      }
    }
  }

  /**
   * Process Checklist - FIX UNTUK KONTEKS DAN TEMPAT_WAKTU
   */
  private function processChecklist($santri_id, $modul_ajar_id, $tanggal, $request, &$penilaianDisimpan)
  {
    $penilaian_data_json = $request->getPost('penilaian_data_json');
    $konteks = $request->getPost('konteks_json');
    $tempat_waktu = $request->getPost('tempat_waktu_json');
    $kejadian_teramati_json = $request->getPost('kejadian_teramati_json');

    // 🔍 DEBUG: Log data yang diterima
    log_message('debug', '=== CHECKLIST DEBUG ===');
    log_message('debug', 'Penilaian JSON: ' . $penilaian_data_json);
    log_message('debug', 'Konteks JSON: ' . $konteks);
    log_message('debug', 'Tempat Waktu JSON: ' . $tempat_waktu);
    log_message('debug', 'Kejadian JSON: ' . $kejadian_teramati_json);

    $hasData = !empty($penilaian_data_json) ||
      !empty($konteks) ||
      !empty($tempat_waktu) ||
      !empty($kejadian_teramati_json);

    log_message('debug', 'Has Data: ' . ($hasData ? 'YES' : 'NO'));

    if ($hasData) {
      $existing = $this->asesmenChecklistModel
        ->where('santri', $santri_id)
        ->where('modul_ajar_id', $modul_ajar_id)
        ->first();

      $data = [
        'santri' => $santri_id,
        'kelas' => session("kelas_id"),
        'semester' => '-',
        'modul_ajar_id' => $modul_ajar_id,
        'tanggal' => $tanggal,
        'isi' => $penilaian_data_json ?: null,
        'konteks' => $konteks ?: null,
        'tempat_waktu' => $tempat_waktu ?: null,
        'kejadian' => $kejadian_teramati_json ?: null,
      ];

      log_message('debug', 'Data to save: ' . json_encode($data));

      if ($existing) {
        $data['id'] = $existing['id'];
        log_message('debug', 'Updating existing ID: ' . $existing['id']);
      }

      if ($this->asesmenChecklistModel->save($data)) {
        $penilaianDisimpan[] = 'Checklist';
        log_message('debug', 'Checklist saved successfully');
      } else {
        log_message('error', 'Failed to save checklist');
      }
    }
  }

  /**
   * Process Anekdot
   */
  private function processAnekdot($santri_id, $modul_ajar_id, $tanggal, $request, &$penilaianDisimpan)
  {
    $anekdot_tempat = $request->getPost('anekdot_tempat');
    $anekdot_peristiwa = $request->getPost('anekdot_peristiwa');
    $anekdot_keterangan = $request->getPost('anekdot_keterangan') ?? [];

    // Process keterangan
    $result_anekdot_keterangan = [];
    foreach ($anekdot_keterangan as $item) {
      if (!empty($item['keterangan'])) {
        $result_anekdot_keterangan[] = [
          'id_capaian' => $item['id_capaian'],
          'keterangan' => $item['keterangan'],
        ];
      }
    }

    if (!empty($anekdot_tempat) || !empty($anekdot_peristiwa) || !empty($result_anekdot_keterangan)) {
      $existing = $this->asesmenAnekdotModel
        ->where('santri', $santri_id)
        ->where('modul_ajar_id', $modul_ajar_id)
        ->first();

      $data = [
        'santri' => $santri_id,
        'kelas' => session("kelas_id"),
        'semester' => '-',
        'modul_ajar_id' => $modul_ajar_id,
        'tanggal' => $tanggal,
        'tempat' => $anekdot_tempat,
        'peristiwa' => $anekdot_peristiwa,
        'keterangan' => json_encode($result_anekdot_keterangan),
      ];

      if ($existing) {
        $data['id'] = $existing['id'];
      }

      if ($this->asesmenAnekdotModel->save($data)) {
        $penilaianDisimpan[] = 'Anekdot';
      }
    }
  }

  /**
   * Process Hasil Karya
   */
  private function processHasilKarya($santri_id, $modul_ajar_id, $tanggal, $request, &$penilaianDisimpan)
  {
    $existingAsesmenKarya = $this->asesmenKaryaModel
      ->where('santri', $santri_id)
      ->where('modul_ajar_id', $modul_ajar_id)
      ->first();

    // Get form data
    $kegiatan_hasil_karya = $request->getPost('kegiatan_hasil_karya');
    $hasil_karya_catatan = $request->getPost('hasil_karya_catatan') ?? [];

    // Process catatan
    $result_hasil_karya_catatan = [];
    foreach ($hasil_karya_catatan as $item) {
      if (!empty($item['catatan'])) {
        $result_hasil_karya_catatan[] = [
          'id_capaian' => $item['id_capaian'],
          'catatan' => $item['catatan'],
        ];
      }
    }

    // Handle file upload
    $foto_hk = $request->getFile("foto_hasil_karya");
    $foto_hasil_karya_name = null;
    $rotation = $request->getPost('rotation_hasil_karya') ?? 0;

    if ($foto_hk && $foto_hk->isValid() && !$foto_hk->hasMoved()) {
      // Delete old file if exists
      if ($existingAsesmenKarya && !empty($existingAsesmenKarya['foto'])) {
        $oldFilePath = FCPATH . 'uploads/penilaian/' . $existingAsesmenKarya['foto'];
        if (file_exists($oldFilePath)) {
          unlink($oldFilePath);
        }
      }

      // Move new file
      $newName_hk = $foto_hk->getRandomName();
      $tempPath = FCPATH . 'uploads/penilaian/temp_' . $newName_hk;
      $finalPath = FCPATH . 'uploads/penilaian/' . $newName_hk;

      // Upload ke temporary path dulu
      $foto_hk->move(FCPATH . 'uploads/penilaian', 'temp_' . $newName_hk);

      // COMPRESS & RESIZE IMAGE (sekalian terapkan rotasi)
      if ($this->compressImage($tempPath, $finalPath, 1920, 75, $rotation)) {
        // Hapus file temporary setelah kompresi berhasil
        if (file_exists($tempPath)) {
          unlink($tempPath);
        }
        $foto_hasil_karya_name = $newName_hk;
      } else {
        // Jika kompresi gagal, gunakan file asli (rename dari temp)
        if (file_exists($tempPath)) {
          rename($tempPath, $finalPath);
        }
        $this->_rotateExistingImage($newName_hk, $rotation);
        $foto_hasil_karya_name = $newName_hk;
      }
    } else {
      // Keep old file name if no new file uploaded
      // Rotasi tetap diterapkan kalau user memutar gambar lama (tanpa upload ulang)
      $oldName = $existingAsesmenKarya['foto'] ?? null;
      $this->_rotateExistingImage($oldName, $rotation);
      $foto_hasil_karya_name = $oldName;
    }

    // Save data if any content exists
    if (!empty($kegiatan_hasil_karya) || !empty($foto_hasil_karya_name) || !empty($result_hasil_karya_catatan)) {
      $dataHasilKarya = [
        'santri' => $santri_id,
        'kelas' => session("kelas_id"),
        'semester' => '-',
        'modul_ajar_id' => $modul_ajar_id,
        'tanggal' => $tanggal,
        'foto' => $foto_hasil_karya_name,
        'kegiatan' => $kegiatan_hasil_karya,
        'catatan' => json_encode($result_hasil_karya_catatan),
        'rotation_foto' => $rotation,
      ];

      if ($existingAsesmenKarya) {
        $dataHasilKarya['id'] = $existingAsesmenKarya['id'];
      }

      if ($this->asesmenKaryaModel->save($dataHasilKarya)) {
        $penilaianDisimpan[] = 'Hasil Karya';
      }
    }
  }

  private function compressImage($sourcePath, $destinationPath, $maxWidth = 1920, $quality = 75, $rotation = 0)
  {
    try {
      $image = \Config\Services::image()->withFile($sourcePath);

      // Cek apakah gambar perlu di-resize
      if ($image->getWidth() > $maxWidth) {
        $ratio = $maxWidth / $image->getWidth();
        $newHeight = (int)($image->getHeight() * $ratio);

        $image->resize($maxWidth, $newHeight, true, 'height');
      }

      // Terapkan rotasi kalau user memutar gambar di form
      $rotation = $this->_normalizeRotation($rotation);
      if ($rotation !== 0) {
        $image->rotate($rotation);
      }

      // Save dengan kompresi
      $image->save($destinationPath, $quality);

      return true;
    } catch (\Exception $e) {
      log_message('error', 'Image compression failed: ' . $e->getMessage());
      return false;
    }
  }

  /**
   * Normalisasi derajat rotasi ke nilai yang didukung CI Image: 0/90/180/270.
   * Form mengirim -90 untuk putar kiri, jadi perlu dikonversi ke positif.
   */
  private function _normalizeRotation($rotation): int
  {
    $deg = ((int) $rotation % 360 + 360) % 360;
    return in_array($deg, [90, 180, 270], true) ? $deg : 0;
  }

  /**
   * Rotasi file yang sudah tersimpan (kasus: user hanya memutar gambar lama,
   * tanpa upload file baru). Rotasi dilakukan in-place.
   */
  private function _rotateExistingImage(?string $filename, $rotation): void
  {
    $rotation = $this->_normalizeRotation($rotation);
    if (!$filename || $rotation === 0) {
      return;
    }

    $path = FCPATH . 'uploads/penilaian/' . $filename;
    if (!is_file($path)) {
      return;
    }

    try {
      \Config\Services::image()
        ->withFile($path)
        ->rotate($rotation)
        ->save($path);
    } catch (\Exception $e) {
      log_message('error', 'Image rotation failed: ' . $e->getMessage());
    }
  }

  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdSantri');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->santriModel->update($id, ['deleted' => 1]);

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

  public function index($modulAjarId)
  {
    $modul = $this->modulAjarModel->find($modulAjarId);

    // Ambil semua tanggal subtopik yang tersedia
    $tanggalList = [];
    $subTopikList = [];
    for ($i = 1; $i <= 5; $i++) {
      $field = 'subsubTopik_tanggal' . $i;
      if (!empty($modul[$field])) {
        $tanggalList[] = $modul[$field];
        $subTopikList[] = $i;
      }
    }

    $data = [
      'title'       => 'Asesmen Tanggal | KBRA Islamic Center',
      'nav'         => 'modul_ajar',
      'username'    => $this->session->get('username'),
      'modul_ajar'  => $modul,
      'tanggalList' => $tanggalList,
      'subTopikList' => $subTopikList
    ];

    return $this->render('admin/v_asesmenPerHari', $data);
  }



  public function form($modulAjarId)
  {
    $kelasId = $this->session->get('kelas_id');
    $santri = $this->santriModel
      ->select('santri.nama, santri.id')
      ->join('ruang_kelas', 'santri.id = ruang_kelas.santri_id')
      ->where('ruang_kelas.kelas_id', $kelasId)
      ->where('santri.deleted', 0)
      ->findAll();

    $modul = $this->modulAjarModel->find($modulAjarId);
    if (!$modul) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Modul Ajar tidak ditemukan.");
    }

    // Kumpulkan tanggal yang tersedia
    $tanggalList = [];
    for ($i = 1; $i <= 5; $i++) {
      $field = 'subsubTopik_tanggal' . $i;
      if (!empty($modul[$field])) {
        $tanggalList[] = ['index' => $i, 'tanggal' => $modul[$field]];
      }
    }

    // Tujuan pembelajaran
    $tujuanPembelajaranIds = json_decode($modul['tujuan_pembelajaran'] ?? '[]', true);
    $validIds = [];
    if (is_array($tujuanPembelajaranIds)) {
      foreach ($tujuanPembelajaranIds as $item) {
        if (is_array($item) && isset($item['id'])) {
          $validIds[] = $item['id'];
        } elseif (is_numeric($item)) {
          $validIds[] = $item;
        }
      }
    }

    $dataTujuanPembelajaranDetail = [];
    if (!empty($validIds)) {
      $dataTujuanPembelajaranDetail = $this->tujuanPembelajaranModel
        ->select('id, capaian, nama as text')
        ->whereIn('id', $validIds)
        ->findAll();
    }

    $data = [
      'title'                      => 'Asesmen Santri | KBRA Islamic Center',
      'nav'                        => 'modul_ajar',
      'username'                   => $this->session->get('username'),
      'modul'                      => $modul,
      'tanggalList'                => $tanggalList,
      'santriList'                 => $santri,
      'asesmenBadges'              => $this->_getAsesmenBadges($modulAjarId, $tanggalList),
      'capaianPembelajaran'        => $this->capaianPembelajaranModel->where('setting', $this->session->get('tahun'))->findAll(),
      'tujuan_pembelajaran_detail' => $dataTujuanPembelajaranDetail,
    ];

    return $this->render('admin/v_asesmenForm', $data);
  }

  /**
   * Ambil daftar asesmen yang sudah terisi per santri untuk modul ajar ini.
   * Return: { santri_id: [ ['jenis' => 'checklist', 'hari' => 1], ... ], ... }
   * "hari" = index tanggal di $tanggalList (hari ke-N pembelajaran).
   */
  private function _getAsesmenBadges($modulAjarId, array $tanggalList): array
  {
    // Map tanggal -> index hari, supaya badge bisa tampil "checklist -3"
    $tanggalToHari = [];
    foreach ($tanggalList as $tgl) {
      $tanggalToHari[$tgl['tanggal']] = $tgl['index'];
    }

    $sources = [
      'checklist'   => $this->asesmenChecklistModel,
      'hasilkarya'  => $this->asesmenKaryaModel,
      'fotoberseri' => $this->asesmenFotoModel,
      'anekdot'     => $this->asesmenAnekdotModel,
    ];

    $badges = [];
    foreach ($sources as $jenis => $model) {
      $rows = $model->select('santri, tanggal')
        ->where('modul_ajar_id', $modulAjarId)
        ->findAll();

      foreach ($rows as $row) {
        $santriId = $row['santri'] ?? null;
        if (!$santriId) continue;

        $hari = $tanggalToHari[$row['tanggal']] ?? null;
        if ($hari === null) continue;

        $badges[$santriId][] = ['jenis' => $jenis, 'hari' => $hari];
      }
    }

    return $badges;
  }


  // Lokasi: app/Controllers/Asesmen.php

  public function getData()
  {
    if ($this->request->isAJAX()) {
      $input = $this->request->getJSON();

      $santriId = $input->santri_id ?? null;
      $modulAjarId = $input->modul_ajar_id ?? null;

      if (!$santriId || !$modulAjarId) {
        return $this->response->setJSON(['error' => 'Parameter tidak lengkap.']);
      }

      $db = \Config\Database::connect();

      $finalData = [
        'foto1' => null,
        'ket_foto1' => null,
        'foto2' => null,
        'ket_foto2' => null,
        'foto3' => null,
        'ket_foto3' => null,
        'rotation_foto1' => 0,
        'rotation_foto2' => 0,
        'rotation_foto3' => 0,
        'analisis_guru_json' => null,
        'umpan_balik' => null,
        'tempat' => null,
        'peristiwa' => null,
        'keterangan_anekdot_json' => null,
        'kegiatan' => null,
        'foto_hk' => null,
        'rotation_foto_hk' => 0,
        'catatan_hasil_karya_json' => null,
        'hasil_penilaian_decoded' => [],
        'kejadian_checklist_json' => null,
        'konteks' => null,
        'tempat_waktu' => null,
        // tanggal per tab
        'tanggal_checklist' => null,
        'tanggal_hasilkarya' => null,
        'tanggal_fotoberseri' => null,
        'tanggal_anekdot' => null,
      ];

      $finalData['santri'] = $santriId;
      $finalData['modul_ajar_id'] = $modulAjarId;

      // Foto Berseri
      $fotoberseriData = $db->table('asesmen_fotoberseri')
        ->where('santri', $santriId)
        ->where('modul_ajar_id', $modulAjarId)
        ->get()->getRowArray();
      if ($fotoberseriData) {
        $finalData['foto1'] = $fotoberseriData['foto1'] ?? null;
        $finalData['foto2'] = $fotoberseriData['foto2'] ?? null;
        $finalData['foto3'] = $fotoberseriData['foto3'] ?? null;
        $finalData['ket_foto1'] = $fotoberseriData['ket_foto1'] ?? null;
        $finalData['ket_foto2'] = $fotoberseriData['ket_foto2'] ?? null;
        $finalData['ket_foto3'] = $fotoberseriData['ket_foto3'] ?? null;
        $finalData['rotation_foto1'] = $fotoberseriData['rotation_foto1'] ?? 0;
        $finalData['rotation_foto2'] = $fotoberseriData['rotation_foto2'] ?? 0;
        $finalData['rotation_foto3'] = $fotoberseriData['rotation_foto3'] ?? 0;
        $finalData['analisis_guru_json'] = $fotoberseriData['analisis_guru'] ?? null;
        $finalData['umpan_balik'] = $fotoberseriData['umpan_balik'] ?? null;
        $finalData['tanggal_fotoberseri'] = $fotoberseriData['tanggal'] ?? null;
      }

      // Anekdot
      $anekdotData = $db->table('asesmen_anekdot')
        ->where('santri', $santriId)
        ->where('modul_ajar_id', $modulAjarId)
        ->get()->getRowArray();
      if ($anekdotData) {
        $finalData['tempat'] = $anekdotData['tempat'] ?? null;
        $finalData['peristiwa'] = $anekdotData['peristiwa'] ?? null;
        $finalData['keterangan_anekdot_json'] = $anekdotData['keterangan'] ?? null;
        $finalData['tanggal_anekdot'] = $anekdotData['tanggal'] ?? null;
      }

      // Hasil Karya
      $hasilkaryaData = $db->table('asesmen_hasilkarya')
        ->where('santri', $santriId)
        ->where('modul_ajar_id', $modulAjarId)
        ->get()->getRowArray();
      if ($hasilkaryaData) {
        $finalData['kegiatan'] = $hasilkaryaData['kegiatan'] ?? null;
        $finalData['foto_hk'] = $hasilkaryaData['foto'] ?? null;
        $finalData['rotation_foto_hk'] = $hasilkaryaData['rotation_foto'] ?? 0;
        $finalData['catatan_hasil_karya_json'] = $hasilkaryaData['catatan'] ?? null;
        $finalData['tanggal_hasilkarya'] = $hasilkaryaData['tanggal'] ?? null;
      }

      // Checklist
      $checklistData = $db->table('asesmen_checklist')
        ->where('santri', $santriId)
        ->where('modul_ajar_id', $modulAjarId)
        ->get()->getRowArray();
      if ($checklistData) {
        $finalData['konteks'] = $checklistData['konteks'] ?? null;
        $finalData['tempat_waktu'] = $checklistData['tempat_waktu'] ?? null;
        $finalData['kejadian_checklist_json'] = $checklistData['kejadian'] ?? null;
        $finalData['tanggal_checklist'] = $checklistData['tanggal'] ?? null;

        $isi = $checklistData['isi'] ?? null;
        if ($isi) {
          $decoded = json_decode($isi, true);
          $finalData['hasil_penilaian_decoded'] = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
        }
      }

      return $this->response->setJSON($finalData);
    }

    return redirect()->to('/');
  }

  public function hapusAsesmen($jenis)
  {
    if (!$this->request->isAJAX()) {
      return redirect()->to('/');
    }

    $input = $this->request->getJSON();
    $santriId = $input->santri_id ?? null;
    $modulAjarId = $input->modul_ajar_id ?? null;

    if (!$santriId || !$modulAjarId) {
      return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
    }

    $modelMap = [
      'checklist'   => $this->asesmenChecklistModel,
      'hasilkarya'  => $this->asesmenKaryaModel,
      'fotoberseri' => $this->asesmenFotoModel,
      'anekdot'     => $this->asesmenAnekdotModel,
    ];

    if (!isset($modelMap[$jenis])) {
      return $this->response->setJSON(['status' => 'error', 'message' => 'Jenis asesmen tidak dikenali.']);
    }

    $model = $modelMap[$jenis];
    $existing = $model->where('santri', $santriId)->where('modul_ajar_id', $modulAjarId)->first();

    if (!$existing) {
      return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
    }

    // Hapus file foto fisik terkait sebelum hapus record
    $fotoFields = [];
    if ($jenis === 'hasilkarya') $fotoFields = ['foto'];
    if ($jenis === 'fotoberseri') $fotoFields = ['foto1', 'foto2', 'foto3'];

    foreach ($fotoFields as $field) {
      if (!empty($existing[$field])) {
        $path = FCPATH . 'uploads/penilaian/' . $existing[$field];
        if (file_exists($path)) {
          unlink($path);
        }
      }
    }

    if ($model->delete($existing['id'])) {
      return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
    }

    return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus data.']);
  }


  public function ambil_data_modulajar()
  {
    $data = $this->modulAjarModel->where('deleted', 0)->where('kelas_id', $this->session->get('kelas_id'))->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }

  public function download($modulId, $tanggalUrut, $jenisDokumen)
  {

    $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();
    if ($kelas['jenjang'] == 'RA') {
      $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
      $nama_kepala = "Kepala Sekolah";
    } else {
      $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
      $nama_kepala = "Kepala KB IT Islamic Center";
    }

    $semester = $this->semesterModel
      ->where('tingkat', $kelas['jenjang'])
      ->where('tahun', $this->session->get('tahun'))
      ->where('semester', $this->session->get('semester'))->first();



    if ($jenisDokumen === 'fotoseri') {
      // Dapatkan nama kolom tanggal dari modul_ajar berdasarkan tanggalUrut
      $tanggalKolom = 'subsubTopik_tanggal' . $tanggalUrut;
      $topikKolom = 'subsubTopik_' . $tanggalUrut;

      $tanggalValue = '';
      $dataFotoseri = []; // Inisialisasi

      $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('tahun'))->findAll();

      // dd($capaian_pembelajaran);

      //if ($tanggalUrut == 0) {
      $tanggalValue = 'Semua Tanggal';
      $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      // Get all foto berseri data with joins. This will return an array of arrays.
      if ($tanggalUrut == 0) {
        $dataFotoseri = $this->asesmenFotoModel->getFotoBerseriDetailByModulAjar($modulId);
      } else {
        $dataFotoseri = $this->asesmenFotoModel->getFotoBerseriDetail($modulId, $tanggalKolom); // Passing nama kolom

      }

      if (!empty($dataFotoseri)) {
        foreach ($dataFotoseri as $key => $record) {
          // CORRECTED: Access 'tanggal' using array syntax
          $fotoTanggal = $record['tanggal'];
          // dd($fotoTanggal);
          $matched = false;

          for ($i = 1; $i <= 5; $i++) { // Adjust loop limit if you have more date columns
            $kolomNamaTanggalDiModulAjar = 'subsubTopik_tanggal' . $i;
            $kolomNamaTopikDiModulAjar = 'subsubTopik_' . $i;

            // Accessing $modulAjar as an array (assuming it's an array)
            // dd($modulAjar[$kolomNamaTanggalDiModulAjar]);
            if (
              isset($modulAjar[$kolomNamaTanggalDiModulAjar]) &&
              $modulAjar[$kolomNamaTanggalDiModulAjar] == $fotoTanggal
            ) {
              // Assign new properties as array keys
              $record['matched_tanggal_index'] = $i;
              $record['matched_topik_value'] = $modulAjar[$kolomNamaTopikDiModulAjar];
              $matched = true;
              break;
            }
          }

          if (!$matched) {
            $record['matched_tanggal_index'] = "data tidak ditemukan";
            $record['matched_topik_value'] = "data tidak ditemukan";
          }

          // IMPORTANT: Save changes back to the array
          $dataFotoseri[$key] = $record;
        }
      }
      // } else {
      //   $dataFotoseri = $this->asesmenFotoModel->getFotoBerseriDetail($modulId, $tanggalKolom); // Passing nama kolom
      //   // Pastikan kolom tanggal ada di model modul ajar Anda
      //   $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      //   if (!$modulAjar || !isset($modulAjar[$tanggalKolom])) {
      //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Modul Ajar atau Tanggal tidak ditemukan.');
      //   }

      //   // Dapatkan nilai tanggal dari kolom di modul_ajar
      //   // $tanggalValue = $modulAjar[$tanggalKolom];
      //   $topik_kolom = $modulAjar[$topikKolom];
      // }

      $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

      $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
      $wali = $this->guruModel->where('id', $kelas['wali'])->first();



      // Ambil semua data foto berseri untuk modul dan tanggal tersebut

      // Data untuk view PDF
      $data = [
        'modul_ajar_id' => $modulId,
        // 'tanggal_asesmen' => $tanggalValue, // Tanggal yang sebenarnya
        'semester' => session("semester"), // Tanggal yang sebenarnya
        'tahun' => session("tahun"), // Tanggal yang sebenarnya
        'capaian_pembelajaran' => $capaian_pembelajaran, // Tanggal yang sebenarnya
        // 'tema_pembelajaran' => $dataFotoseri['tema_pembelajaran'], // Ambil tema dari modul ajar
        // 'pekan_pembelajaran' => $dataFotoseri['pekan'], // Ambil tema dari modul ajar
        // 'topik_pembelajaran' => $dataFotoseri['topik_pembelajaran'], // Ambil tema dari modul ajar
        // 'subtopik_pembelajaran' => $dataFotoseri['matched_topik_value'], // Ambil tema dari modul ajar
        'nama_tingkat' => $nama_tingkat, // Ambil tema dari modul ajar
        'nama_kepala' => $nama_kepala, // Ambil tema dari modul ajar
        'kepala' => $kepala['nama'], // Ambil tema dari modul ajar
        'wali' => $wali['nama'], // Ambil tema dari modul ajar
        'records' => $dataFotoseri,
      ];

      // Render view HTML menjadi string
      $html = view('admin/pdf/fotoseri_pdf_template', $data); // Buat view ini di app/Views/pdf/

      // Inisialisasi Dompdf
      $options = new Options();
      $options->set('chroot', FCPATH);
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true); // Penting untuk gambar eksternal (CDN) atau jika jalur gambar diatur relatif ke root project
      $options->set('defaultFont', 'sans-serif'); // Set font default
      $options->set('tempDir', WRITEPATH . 'dompdf');
      $options->set('fontDir', WRITEPATH . 'dompdf/fonts');
      $options->set('fontCache', WRITEPATH . 'dompdf/fonts');

      $dompdf = new Dompdf($options);
      $dompdf->set_option('isHtml5ParserEnabled', true);
      $dompdf->set_option('isRemoteEnabled', true);
      $dompdf->set_option('defaultFont', 'Times New Roman');
      $html = preg_replace('/>\s+</', "><", $html);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'landscape');
      $dompdf->render();

      header('Cache-Control: no-cache, no-store, must-revalidate');
      header('Pragma: no-cache');
      header('Expires: 0');
      $filename = 'fotoseri_modul_' . $modulId . '_tanggal_' . $tanggalUrut . '.pdf';
      $dompdf->stream($filename, ['Attachment' => 0]); // 1 untuk download, 0 untuk display di browser

    } else if ($jenisDokumen === 'hastakarya') {
      // Dapatkan nama kolom tanggal dari modul_ajar berdasarkan tanggalUrut
      $tanggalKolom = 'subsubTopik_tanggal' . $tanggalUrut;
      $topikKolom = 'subsubTopik_' . $tanggalUrut;

      $tanggalValue = '';
      $dataHastaKarya = []; // Inisialisasi

      //if ($tanggalUrut == 0) {
      $tanggalValue = 'Semua Tanggal';
      $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      // Get all foto berseri data with joins. This will return an array of arrays.
      if ($tanggalUrut == 0) {
        $dataHastaKarya = $this->asesmenKaryaModel->getHastaKaryaDetailByModulAjar($modulId);
      } else {
        $dataHastaKarya = $this->asesmenKaryaModel->getHastaKaryaDetail($modulId, $tanggalKolom); // Passing nama kolom

      }

      if (!empty($dataHastaKarya)) {
        foreach ($dataHastaKarya as $key => $record) {
          // CORRECTED: Access 'tanggal' using array syntax
          $fotoTanggal = $record['tanggal'];
          // dd($fotoTanggal);
          $matched = false;

          for ($i = 1; $i <= 5; $i++) { // Adjust loop limit if you have more date columns
            $kolomNamaTanggalDiModulAjar = 'subsubTopik_tanggal' . $i;
            $kolomNamaTopikDiModulAjar = 'subsubTopik_' . $i;

            // Accessing $modulAjar as an array (assuming it's an array)
            // dd($modulAjar[$kolomNamaTanggalDiModulAjar]);
            if (
              isset($modulAjar[$kolomNamaTanggalDiModulAjar]) &&
              $modulAjar[$kolomNamaTanggalDiModulAjar] == $fotoTanggal
            ) {
              // Assign new properties as array keys
              $record['matched_tanggal_index'] = $i;
              $record['matched_topik_value'] = $modulAjar[$kolomNamaTopikDiModulAjar];
              $matched = true;
              break;
            }
          }

          if (!$matched) {
            $record['matched_tanggal_index'] = "data tidak ditemukan";
            $record['matched_topik_value'] = "data tidak ditemukan";
          }

          // IMPORTANT: Save changes back to the array
          $dataHastaKarya[$key] = $record;
        }
      }

      $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

      $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
      $wali = $this->guruModel->where('id', $kelas['wali'])->first();
      $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('tahun'))->findAll();

      // Data untuk view PDF
      $data = [
        'modul_ajar_id' => $modulId,
        'tanggal_asesmen' => $tanggalValue, // Tanggal yang sebenarnya
        'capaian_pembelajaran' => $capaian_pembelajaran, // Tanggal yang sebenarnya
        'semester' => session("semester"), // Tanggal yang sebenarnya
        'tahun' => session("tahun"), // Tanggal yang sebenarnya
        'nama_tingkat' => $nama_tingkat, // Ambil tema dari modul ajar
        'nama_kepala' => $nama_kepala, // Ambil tema dari modul ajar
        'kepala' => $kepala['nama'], // Ambil tema dari modul ajar
        'wali' => $wali['nama'], // Ambil tema dari modul ajar
        'records' => $dataHastaKarya,
      ];

      // Render view HTML menjadi string
      $html = view('admin/pdf/hastakarya_pdf_template', $data); // Buat view ini di app/Views/pdf/

      // Inisialisasi Dompdf
      $options = new Options();
      $options->set('chroot', FCPATH);
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true); // Penting untuk gambar eksternal (CDN) atau jika jalur gambar diatur relatif ke root project
      $options->set('defaultFont', 'sans-serif'); // Set font default
      $options->set('tempDir', WRITEPATH . 'dompdf');
      $options->set('fontDir', WRITEPATH . 'dompdf/fonts');
      $options->set('fontCache', WRITEPATH . 'dompdf/fonts');

      $dompdf = new Dompdf($options);
      $dompdf->set_option('isHtml5ParserEnabled', true);
      $dompdf->set_option('isRemoteEnabled', true);
      $dompdf->set_option('defaultFont', 'Times New Roman');
      $html = preg_replace('/>\s+</', "><", $html);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      header('Cache-Control: no-cache, no-store, must-revalidate');
      header('Pragma: no-cache');
      header('Expires: 0');
      // Nama file PDF
      $filename = 'hastakarya_modul_' . $modulId . '_tanggal_' . $tanggalUrut . '.pdf';

      // Output PDF ke browser untuk di-download
      $dompdf->stream($filename, ['Attachment' => 0]); // 1 untuk download, 0 untuk display di browser

    } else if ($jenisDokumen === 'anekdot') {
      // Dapatkan nama kolom tanggal dari modul_ajar berdasarkan tanggalUrut
      $tanggalKolom = 'subsubTopik_tanggal' . $tanggalUrut;
      $topikKolom = 'subsubTopik_' . $tanggalUrut;

      $tanggalValue = '';
      $dataAnekdot = []; // Inisialisasi

      //if ($tanggalUrut == 0) {
      $tanggalValue = 'Semua Tanggal';
      $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      // Get all foto berseri data with joins. This will return an array of arrays.
      if ($tanggalUrut == 0) {
        $dataAnekdot = $this->asesmenAnekdotModel->getAnekdotDetailByModulAjar($modulId);
      } else {
        $dataAnekdot = $this->asesmenAnekdotModel->getAnekdotDetail($modulId, $tanggalKolom); // Passing nama kolom

      }

      if (!empty($dataAnekdot)) {
        foreach ($dataAnekdot as $key => $record) {
          // CORRECTED: Access 'tanggal' using array syntax
          $fotoTanggal = $record['tanggal'];
          // dd($fotoTanggal);
          $matched = false;

          for ($i = 1; $i <= 5; $i++) { // Adjust loop limit if you have more date columns
            $kolomNamaTanggalDiModulAjar = 'subsubTopik_tanggal' . $i;
            $kolomNamaTopikDiModulAjar = 'subsubTopik_' . $i;

            // Accessing $modulAjar as an array (assuming it's an array)
            // dd($modulAjar[$kolomNamaTanggalDiModulAjar]);
            if (
              isset($modulAjar[$kolomNamaTanggalDiModulAjar]) &&
              $modulAjar[$kolomNamaTanggalDiModulAjar] == $fotoTanggal
            ) {
              // Assign new properties as array keys
              $record['matched_tanggal_index'] = $i;
              $record['matched_topik_value'] = $modulAjar[$kolomNamaTopikDiModulAjar];
              $matched = true;
              break;
            }
          }

          if (!$matched) {
            $record['matched_tanggal_index'] = "data tidak ditemukan";
            $record['matched_topik_value'] = "data tidak ditemukan";
          }

          // IMPORTANT: Save changes back to the array
          $dataAnekdot[$key] = $record;
        }
      }

      $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

      $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
      $wali = $this->guruModel->where('id', $kelas['wali'])->first();
      $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('tahun'))->findAll();

      // Data untuk view PDF
      $data = [
        'modul_ajar_id' => $modulId,
        'capaian_pembelajaran' => $capaian_pembelajaran, // Tanggal yang sebenarnya
        'tanggal_asesmen' => $tanggalValue, // Tanggal yang sebenarnya
        'semester' => session("semester"), // Tanggal yang sebenarnya
        'tahun' => session("tahun"), // Tanggal yang sebenarnya
        'nama_tingkat' => $nama_tingkat, // Ambil tema dari modul ajar
        'nama_kepala' => $nama_kepala, // Ambil tema dari modul ajar
        'kepala' => $kepala['nama'], // Ambil tema dari modul ajar
        'wali' => $wali['nama'], // Ambil tema dari modul ajar
        'records' => $dataAnekdot,
      ];

      // Render view HTML menjadi string
      $html = view('admin/pdf/anekdot_pdf_template', $data); // Buat view ini di app/Views/pdf/

      // Inisialisasi Dompdf
      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true); // Penting untuk gambar eksternal (CDN) atau jika jalur gambar diatur relatif ke root project
      $options->set('defaultFont', 'sans-serif'); // Set font default

      $dompdf = new Dompdf($options);
      $dompdf->set_option('isHtml5ParserEnabled', true);
      $dompdf->set_option('isRemoteEnabled', true);
      $dompdf->set_option('defaultFont', 'Times New Roman');
      $html = preg_replace('/>\s+</', "><", $html);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'landscape');
      $dompdf->render();

      header('Cache-Control: no-cache, no-store, must-revalidate');
      header('Pragma: no-cache');
      header('Expires: 0');
      // Nama file PDF
      $filename = 'anekdot_modul_' . $modulId . '_tanggal_' . $tanggalUrut . '.pdf';

      // Output PDF ke browser untuk di-download
      $dompdf->stream($filename, ['Attachment' => 0]); // 1 untuk download, 0 untuk display di browser


      // ======================== PENILAIAN CHECKLIST ========================
      // ======================== PENILAIAN CHECKLIST ========================
      // ======================== PENILAIAN CHECKLIST ========================

    } else if ($jenisDokumen === 'checklist') {
      // Dapatkan nama kolom tanggal dari modul_ajar berdasarkan tanggalUrut
      $tanggalKolom = 'subsubTopik_tanggal' . $tanggalUrut;
      $topikKolom = 'subsubTopik_' . $tanggalUrut;

      $tanggalValue = '';
      $dataChecklist = []; // Inisialisasi

      //if ($tanggalUrut == 0) {
      $tanggalValue = 'Semua Tanggal';
      $modulAjar = $this->modulAjarModel->where('id', $modulId)->first();
      // Get all foto berseri data with joins. This will return an array of arrays.
      if ($tanggalUrut == 0) {
        $dataChecklist = $this->asesmenChecklistModel->getChecklistDetailByModulAjar($modulId);
      } else {
        $dataChecklist = $this->asesmenChecklistModel->getChecklistDetail($modulId, $tanggalKolom); // Passing nama kolom

      }

      if (!empty($dataChecklist)) {
        foreach ($dataChecklist as $key => $record) {
          // CORRECTED: Access 'tanggal' using array syntax
          $fotoTanggal = $record['tanggal'];
          // dd($fotoTanggal);
          $matched = false;

          for ($i = 1; $i <= 5; $i++) { // Adjust loop limit if you have more date columns
            $kolomNamaTanggalDiModulAjar = 'subsubTopik_tanggal' . $i;
            $kolomNamaTopikDiModulAjar = 'subsubTopik_' . $i;

            // Accessing $modulAjar as an array (assuming it's an array)
            // dd($modulAjar[$kolomNamaTanggalDiModulAjar]);
            if (
              isset($modulAjar[$kolomNamaTanggalDiModulAjar]) &&
              $modulAjar[$kolomNamaTanggalDiModulAjar] == $fotoTanggal
            ) {
              // Assign new properties as array keys
              $record['matched_tanggal_index'] = $i;
              $record['tanggal_value'] = $modulAjar[$kolomNamaTanggalDiModulAjar];
              $record['matched_topik_value'] = $modulAjar[$kolomNamaTopikDiModulAjar];
              $matched = true;
              break;
            }
          }

          if (!$matched) {
            $record['matched_tanggal_index'] = "data tidak ditemukan";
            $record['matched_topik_value'] = "data tidak ditemukan";
          }

          // IMPORTANT: Save changes back to the array
          $dataChecklist[$key] = $record;
        }
      }

      $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

      $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
      $wali = $this->guruModel->where('id', $kelas['wali'])->first();
      $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('tahun'))->findAll();

      $tujuan_pembelajaran = $this->tujuanPembelajaranModel->getWithCapaianPembelajaran($this->session->get('tahun'));
      // dd($tujuan_pembelajaran);
      // Data untuk view PDF
      $data = [
        'modul_ajar_id' => $modulId,
        'capaian_pembelajaran' => $capaian_pembelajaran, // Tanggal yang sebenarnya
        'tujuan_pembelajaran' => $tujuan_pembelajaran, // Tanggal yang sebenarnya
        'tanggal_asesmen' => $tanggalValue, // Tanggal yang sebenarnya
        'semester' => session("semester"), // Tanggal yang sebenarnya
        'tahun' => session("tahun"), // Tanggal yang sebenarnya
        'nama_tingkat' => $nama_tingkat, // Ambil tema dari modul ajar
        'nama_kepala' => $nama_kepala, // Ambil tema dari modul ajar
        'kepala' => $kepala['nama'], // Ambil tema dari modul ajar
        'wali' => $wali['nama'], // Ambil tema dari modul ajar
        'records' => $dataChecklist,
      ];


      // Render view HTML menjadi string
      $html = view('admin/pdf/checklist_pdf_template', $data); // Buat view ini di app/Views/pdf/

      // Inisialisasi Dompdf
      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true); // Penting untuk gambar eksternal (CDN) atau jika jalur gambar diatur relatif ke root project
      $options->set('defaultFont', 'sans-serif'); // Set font default

      $dompdf = new Dompdf($options);
      $dompdf->set_option('isHtml5ParserEnabled', true);
      $dompdf->set_option('isRemoteEnabled', true);
      $dompdf->set_option('defaultFont', 'Times New Roman');
      $html = preg_replace('/>\s+</', "><", $html);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'landscape');
      $dompdf->render();

      header('Cache-Control: no-cache, no-store, must-revalidate');
      header('Pragma: no-cache');
      header('Expires: 0');
      // Nama file PDF
      $filename = 'checklist_modul_' . $modulId . '_tanggal_' . $tanggalUrut . '.pdf';

      // Output PDF ke browser untuk di-download
      $dompdf->stream($filename, ['Attachment' => 0]); // 1 untuk download, 0 untuk display di browser
    } else {
      // Lanjutkan dengan jenis dokumen lain atau tampilkan error
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Jenis dokumen tidak didukung.');
    }
  }



  public function downloadLaporan()
  {
    $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();
    if ($kelas['jenjang'] == 'RA') {
      $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
      $nama_kepala = "Kepala Sekolah";
    } else {
      $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
      $nama_kepala = "Kepala KB IT Islamic Center";
    }

    $semester = $this->semesterModel
      ->where('tingkat', $kelas['jenjang'])
      ->where('tahun', $this->session->get('tahun'))
      ->where('semester', $this->session->get('semester'))
      ->first();
    $kelas = $this->kelasModel->where('id', $this->session->get('kelas_id'))->first();

    $kepala = $this->guruModel->where('id', $semester['kepala'])->first();
    $wali = $this->guruModel->where('id', $kelas['wali'])->first();


    $bulan = $this->request->getGet('bulan');

    $bulanIndo = [
      "01" => "Januari",
      "02" => "Februari",
      "03" => "Maret",
      "04" => "April",
      "05" => "Mei",
      "06" => "Juni",
      "07" => "Juli",
      "08" => "Agustus",
      "09" => "September",
      "10" => "Oktober",
      "11" => "November",
      "12" => "Desember"
    ];
    $bulanNama = $bulanIndo[$bulan];

    // Ambil data laporan
    $dataLaporanChecklist = $this->asesmenChecklistModel->getChecklistDetailWithSantri($this->session->get('kelas_id'));
    $dataLaporanAnekdot = $this->asesmenAnekdotModel->getAnekdotDetailWithSantri($this->session->get('kelas_id'));
    $dataLaporanHastaKarya = $this->asesmenKaryaModel->getHastaKaryaDetailWithSantri($this->session->get('kelas_id'));
    $dataLaporanFotoBerseri = $this->asesmenFotoModel->getFotoBerseriDetailWithSantri($this->session->get('kelas_id'));

    if (empty($dataLaporanChecklist) && empty($dataLaporanAnekdot) && empty($dataLaporanHastaKarya) && empty($dataLaporanFotoBerseri)) {
      // Arahkan ke halaman 404 jika semua data kosong
      return redirect()->to('/404');  // Bisa juga pakai show_404()
    }
    // echo '<pre>'; // Menggunakan tag <pre> untuk menjaga format spasi dan baris baru di browser
    // print_r($dataLaporanHastaKarya);
    // echo '</pre>';
    // exit;
    // Filter data berdasarkan bulan
    $filteredData = [];

    // Filter data berdasarkan bulan untuk Checklist
    foreach ($dataLaporanChecklist as $laporan) {
      $tanggal = $laporan['tanggal'];
      $parts = explode(",", $tanggal);
      $bulanTeks = trim($parts[1]);
      $bulanNamaDB = explode(" ", $bulanTeks)[1];

      if ($bulanNamaDB == $bulanNama) {
        $filteredData['checklist'][] = $laporan;
      }
    }

    foreach ($dataLaporanHastaKarya as $laporan) {
      $tanggal = $laporan['tanggal'];
      $parts = explode(",", $tanggal);
      $bulanTeks = trim($parts[1]);
      $bulanNamaDB = explode(" ", $bulanTeks)[1];

      if ($bulanNamaDB == $bulanNama) {
        $filteredData['hastakarya'][] = $laporan;
      }
    }

    foreach ($dataLaporanFotoBerseri as $laporan) {
      $tanggal = $laporan['tanggal'];
      $parts = explode(",", $tanggal);
      $bulanTeks = trim($parts[1]);
      $bulanNamaDB = explode(" ", $bulanTeks)[1];

      if ($bulanNamaDB == $bulanNama) {
        $filteredData['fotoberseri'][] = $laporan;
      }
    }

    // Filter data berdasarkan bulan untuk Anekdot
    foreach ($dataLaporanAnekdot as $laporan) {
      $tanggal = $laporan['tanggal'];
      $parts = explode(",", $tanggal);
      $bulanTeks = trim($parts[1]);
      $bulanNamaDB = explode(" ", $bulanTeks)[1];

      if ($bulanNamaDB == $bulanNama) {
        $filteredData['anekdot'][] = $laporan;
      }
    }

    // Ambil data capaian dan santri
    $capaian_pembelajaran = $this->capaianPembelajaranModel->where('setting', $this->session->get('tahun'))->findAll();
    $listSantri = $this->ruangKelasModel->getSantriByKelas($this->session->get('kelas_id'));

    $capaian_list = [];
    foreach ($capaian_pembelajaran as $item) {
      $capaian_list[] = $item['nama'];  // Nama capaian untuk header tabel
      $capaian_list_id[] = $item['id']; // ID capaian untuk referensi
      $capaian_list_warna[] = $item['warna']; // ID capaian untuk referensi
    }
    // Siapkan data untuk mengelompokkan laporan per santri dan capaian
    $laporan_data = [];

    // Proses laporan untuk setiap jenis (Checklist, Anekdot, dsb)
    foreach ($filteredData as $key => $data) {
      foreach ($data as $laporan) {
        $santri_id = $laporan['santri_id'];
        $santri_nama = $laporan['santri_nama'];
        $keterangan = []; // Reset if decoding failed

        // Determine which key to use based on the report type ($key)
        if ($key === 'checklist') {
          // Assume 'foto_keterangan' is the column for Foto Berseri
          if (isset($laporan['kejadian']) && !empty($laporan['kejadian'])) {
            $keterangan = json_decode($laporan['kejadian'], true);
          }
        } else if ($key === 'fotoberseri') {
          // Assume 'foto_keterangan' is the column for Foto Berseri
          if (isset($laporan['analisis_guru']) && !empty($laporan['analisis_guru'])) {
            $keterangan = json_decode($laporan['analisis_guru'], true);
          }
        } else if ($key === 'hastakarya') {
          // Assume 'hastakarya_deskripsi' is the column for Hasta Karya
          if (isset($laporan['catatan']) && !empty($laporan['catatan'])) {
            $keterangan = json_decode($laporan['catatan'], true);
          }
        } else if ($key === 'anekdot') {
          // For 'checklist' and 'anekdot' (and any future types using 'keterangan')
          if (isset($laporan['keterangan']) && !empty($laporan['keterangan'])) {
            $keterangan = json_decode($laporan['keterangan'], true);
          }
        }

        // Check if json_decode failed
        if (json_last_error() !== JSON_ERROR_NONE) {
          $keterangan = []; // Reset if decoding failed
        }

        if (!isset($laporan_data[$santri_id])) {
          $laporan_data[$santri_id] = [
            'nama' => $santri_nama,
            'capaian' => []
          ];
        }

        // Group achievements by achievement ID
        foreach ($keterangan as $item) {
          // Ensure $item is an array and contains 'id_capaian' and 'keterangan'
          if (is_array($item) && isset($item['id_capaian'])) {
            $id_capaian = $item['id_capaian'];

            // Ambil isi keterangan sesuai jenis
            if (isset($item['keterangan'])) {
              $item_keterangan = $item['keterangan'];
            } elseif (isset($item['analisis'])) {
              $item_keterangan = $item['analisis'];
            } elseif (isset($item['catatan'])) {
              $item_keterangan = $item['catatan'];
            } elseif (isset($item['kejadian'])) {
              $item_keterangan = $item['kejadian'];
            } else {
              $item_keterangan = ''; // fallback
            }

            if (!empty($item_keterangan)) {
              if (!isset($laporan_data[$santri_id]['capaian'][$id_capaian])) {
                $laporan_data[$santri_id]['capaian'][$id_capaian] = [];
              }
              $laporan_data[$santri_id]['capaian'][$id_capaian][] = $item_keterangan;
            }
          }
        }
      }
    }

    // Menyiapkan data untuk view
    $data = [
      'kepala' => $kepala['nama'], // Ambil tema dari modul ajar
      'wali' => $wali['nama'], // Ambil tema dari modul ajar
      'capaian_pembelajaran' => $capaian_pembelajaran, // Capaian untuk header
      'semester' => session("semester"),
      'tahun' => session("tahun"),
      'nama_tingkat' => $nama_tingkat,
      'nama_kepala' => $nama_kepala,
      'bulan' => $bulanNama,
      // 'tanggal' => $bulanNama,
      'listSantris' => $listSantri,
      'capaian_list' => $capaian_list,
      'capaian_list_id' => $capaian_list_id,
      'capaian_list_warna' => $capaian_list_warna,
      'laporan_data' => $laporan_data, // Data laporan yang sudah dikelompokkan
    ];

    // Menggunakan Dompdf untuk menghasilkan PDF
    $options = new Options();
    $options->setIsRemoteEnabled(true);
    $dompdf = new Dompdf($options);
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->set_option('defaultFont', 'Times New Roman');
    $html = view('admin/pdf/bulanan_pdf_template', $data);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    // Download PDF
    // $dompdf->stream("laporan_bulan_" . $bulanNama . ".pdf", ["Attachment" => 0]);
    $pdfFileName = 'laporan_bulanan_' . $bulan . '.pdf';
    $dompdf->stream($pdfFileName, [
      'Attachment' => 0 // 0: tampilkan di browser, 1: unduh langsung
    ]);

    // Mengirimkan respons dengan status sukses dan URL PDF
    return $this->response->setJSON([
      'success' => true,
      'pdf_url' => base_url('asesmen/downloadlaporan?bulan=' . $bulan) // Pastikan URL ini sesuai
    ]);
  }
}
