<?php

namespace App\Controllers;

use App\Models\LaporanBulananModel;
use App\Models\LaporanBulananDetailModel;
use App\Models\LaporanBulananSumberModel;
use App\Models\KelasModel;
use App\Models\SantriModel;
use App\Models\UserModel;
use App\Models\SemesterModel;
use App\Models\CapaianPembelajaranModel;
use App\Models\RuangKelasModel;
use App\Models\AsesmenChecklistModel;
use App\Models\AsesmenAnekdotModel;
use App\Models\AsesmenHasilKaryaModel;
use App\Models\AsesmenFotoBerseriModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanBulanan extends CustomController
{
  protected $laporanModel;
  protected $detailModel;
  protected $sumberModel;
  protected $kelasModel;
  protected $santriModel;
  protected $capaianModel;
  protected $guruModel;
  protected $semesterModel;
  protected $ruangKelasModel;
  protected $asesmenChecklistModel;
  protected $asesmenAnekdotModel;
  protected $asesmenKaryaModel;
  protected $asesmenFotoModel;

  public function __construct()
  {
    $this->laporanModel = new LaporanBulananModel();
    $this->detailModel = new LaporanBulananDetailModel();
    $this->sumberModel = new LaporanBulananSumberModel();
    $this->kelasModel = new KelasModel();
    $this->santriModel = new SantriModel();
    $this->capaianModel = new CapaianPembelajaranModel();
    $this->guruModel = new UserModel();
    $this->semesterModel = new SemesterModel();
    $this->ruangKelasModel = new RuangKelasModel();
    $this->asesmenChecklistModel = new AsesmenChecklistModel();
    $this->asesmenAnekdotModel = new AsesmenAnekdotModel();
    $this->asesmenKaryaModel = new AsesmenHasilKaryaModel();
    $this->asesmenFotoModel = new AsesmenFotoBerseriModel();
  }

  /**
   * Halaman index - menampilkan daftar laporan bulanan
   */
  public function index()
  {
    $kelas_id = session()->get('kelas_id');
    $tahun = session()->get('tahun');
    $semester = session()->get('semester');
    $guru_id = session()->get('user_id');

    // Ambil daftar laporan yang sudah dibuat
    $laporanList = $this->laporanModel->getLaporanByKelas($kelas_id, $tahun, $semester);

    // Ambil data kelas
    $kelas = $this->kelasModel->find($kelas_id);

    $bulanList = [
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => 'Mei',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember'
    ];

    $data = [
      'title' => 'Laporan Bulanan | KBRA Islamic Center',
      'nav' => 'laporan_bulanan',
      'laporan_list' => $laporanList,
      'kelas' => $kelas,
      'tahun' => $tahun,
      'semester' => $semester,
      'guru_id' => $guru_id,
      'bulan_list' => json_encode($bulanList),
      'username' => session()->get('username')
    ];

    return $this->render('admin/v_laporan_bulanan', $data);
  }

  /**
   * Generate laporan bulanan baru dari data asesmen
   */
  public function generate()
  {
    $bulan = $this->request->getPost('bulan');
    $kelas_id = session()->get('kelas_id');
    $tahun = session()->get('tahun');
    $semester = session()->get('semester');
    $guru_id = session()->get('user_id');

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

    // Cek apakah laporan sudah ada
    $existingLaporan = $this->laporanModel->isLaporanExist($kelas_id, $bulan, $tahun, $semester);
    if ($existingLaporan) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Laporan untuk bulan ' . $bulanIndo[$bulan] . ' sudah ada!'
      ]);
    }

    // Ambil data asesmen
    $dataLaporanChecklist = $this->asesmenChecklistModel->getChecklistDetailWithSantri($kelas_id);
    $dataLaporanAnekdot = $this->asesmenAnekdotModel->getAnekdotDetailWithSantri($kelas_id);
    $dataLaporanHastaKarya = $this->asesmenKaryaModel->getHastaKaryaDetailWithSantri($kelas_id);
    $dataLaporanFotoBerseri = $this->asesmenFotoModel->getFotoBerseriDetailWithSantri($kelas_id);

    // Filter data berdasarkan bulan
    $filteredData = $this->filterDataByMonth(
      $bulanIndo[$bulan],
      $dataLaporanChecklist,
      $dataLaporanAnekdot,
      $dataLaporanHastaKarya,
      $dataLaporanFotoBerseri
    );
    // echo '<pre>';
    // var_dump($filteredData);
    // echo '</pre>';
    // die;

    if (
      empty($filteredData['checklist']) && empty($filteredData['anekdot']) &&
      empty($filteredData['hastakarya']) && empty($filteredData['fotoberseri'])
    ) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Tidak ada data asesmen untuk bulan ' . $bulanIndo[$bulan]
      ]);
    }

    // Buat laporan baru
    $laporanData = [
      'kelas_id' => $kelas_id,
      'bulan' => $bulan,
      'tahun' => $tahun,
      'semester' => $semester,
      'nama_bulan' => $bulanIndo[$bulan],
      'dibuat_oleh' => $guru_id,
      'status' => 'draft'
    ];

    $this->laporanModel->insert($laporanData);
    $laporan_id = $this->laporanModel->getInsertID();

    // Proses dan simpan detail laporan
    $this->saveDetailFromAsesmen($laporan_id, $filteredData);

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Laporan bulan ' . $bulanIndo[$bulan] . ' berhasil dibuat!',
      'laporan_id' => $laporan_id
    ]);
  }

  /**
   * Filter data asesmen berdasarkan bulan
   */
  private function filterDataByMonth($bulanNama, $dataChecklist, $dataAnekdot, $dataHastaKarya, $dataFotoBerseri)
  {
    $result = ['checklist' => [], 'anekdot' => [], 'hastakarya' => [], 'fotoberseri' => []];

    // ============================================
    // LOG AWAL: Cek data yang masuk
    // ============================================
    log_message('debug', '========== MULAI FILTER BULAN ==========');
    log_message('debug', 'Target Bulan: ' . $bulanNama);
    log_message('debug', 'Total data checklist: ' . count($dataChecklist));
    log_message('debug', 'Total data anekdot: ' . count($dataAnekdot));
    log_message('debug', 'Total data hastakarya: ' . count($dataHastaKarya));
    log_message('debug', 'Total data fotoberseri: ' . count($dataFotoBerseri));
    log_message('debug', '========================================');

    // ============================================
    // FILTER CHECKLIST
    // ============================================
    log_message('debug', '');
    log_message('debug', '--- PROSES FILTER CHECKLIST ---');
    $checklistCounter = 0;

    foreach ($dataChecklist as $index => $laporan) {
      $checklistCounter++;
      $tanggal = $laporan['tanggal'] ?? 'NULL';
      $santriNama = $laporan['santri_nama'] ?? 'Unknown';

      log_message('debug', "Checklist #{$checklistCounter} - Santri: {$santriNama}");
      log_message('debug', "  Tanggal Raw: {$tanggal}");

      if (isset($laporan['tanggal']) && !empty($laporan['tanggal'])) {
        $parts = explode(",", $laporan['tanggal']);
        log_message('debug', "  Explode koma, parts count: " . count($parts));
        log_message('debug', "  Parts: " . json_encode($parts));

        if (count($parts) > 1) {
          $bulanTeks = trim($parts[1]);
          log_message('debug', "  Bulan Teks (setelah trim): '{$bulanTeks}'");

          $dateArray = explode(" ", $bulanTeks);
          log_message('debug', "  Explode spasi, array count: " . count($dateArray));
          log_message('debug', "  Date Array: " . json_encode($dateArray));

          $bulanNamaDB = $dateArray[1] ?? '';
          log_message('debug', "  Bulan Extracted: '{$bulanNamaDB}'");
          log_message('debug', "  Perbandingan: '{$bulanNamaDB}' == '{$bulanNama}' ? " . ($bulanNamaDB == $bulanNama ? 'TRUE' : 'FALSE'));

          if ($bulanNamaDB == $bulanNama) {
            $result['checklist'][] = $laporan;
            log_message('debug', "  ✓ MATCH! Data ditambahkan ke result");
          } else {
            log_message('debug', "  ✗ TIDAK MATCH!");
          }
        } else {
          log_message('debug', "  ✗ Format tanggal tidak ada koma atau parts < 2");
        }
      } else {
        log_message('debug', "  ✗ Tanggal kosong atau null");
      }
      log_message('debug', '');
    }

    log_message('debug', "HASIL FILTER CHECKLIST: " . count($result['checklist']) . " dari " . $checklistCounter . " data");
    log_message('debug', '========================================');

    // ============================================
    // FILTER ANEKDOT
    // ============================================
    log_message('debug', '');
    log_message('debug', '--- PROSES FILTER ANEKDOT ---');
    $anekdotCounter = 0;

    foreach ($dataAnekdot as $index => $laporan) {
      $anekdotCounter++;
      $tanggal = $laporan['tanggal'] ?? 'NULL';
      $santriNama = $laporan['santri_nama'] ?? 'Unknown';

      log_message('debug', "Anekdot #{$anekdotCounter} - Santri: {$santriNama}");
      log_message('debug', "  Tanggal Raw: {$tanggal}");

      if (isset($laporan['tanggal']) && !empty($laporan['tanggal'])) {
        $parts = explode(",", $laporan['tanggal']);
        log_message('debug', "  Explode koma, parts count: " . count($parts));
        log_message('debug', "  Parts: " . json_encode($parts));

        if (count($parts) > 1) {
          $bulanTeks = trim($parts[1]);
          log_message('debug', "  Bulan Teks (setelah trim): '{$bulanTeks}'");

          $dateArray = explode(" ", $bulanTeks);
          log_message('debug', "  Explode spasi, array count: " . count($dateArray));
          log_message('debug', "  Date Array: " . json_encode($dateArray));

          $bulanNamaDB = $dateArray[1] ?? '';
          log_message('debug', "  Bulan Extracted: '{$bulanNamaDB}'");
          log_message('debug', "  Perbandingan: '{$bulanNamaDB}' == '{$bulanNama}' ? " . ($bulanNamaDB == $bulanNama ? 'TRUE' : 'FALSE'));

          if ($bulanNamaDB == $bulanNama) {
            $result['anekdot'][] = $laporan;
            log_message('debug', "  ✓ MATCH! Data ditambahkan ke result");
          } else {
            log_message('debug', "  ✗ TIDAK MATCH!");
          }
        } else {
          log_message('debug', "  ✗ Format tanggal tidak ada koma atau parts < 2");
        }
      } else {
        log_message('debug', "  ✗ Tanggal kosong atau null");
      }
      log_message('debug', '');
    }

    log_message('debug', "HASIL FILTER ANEKDOT: " . count($result['anekdot']) . " dari " . $anekdotCounter . " data");
    log_message('debug', '========================================');

    // ============================================
    // FILTER HASTA KARYA
    // ============================================
    log_message('debug', '');
    log_message('debug', '--- PROSES FILTER HASTA KARYA ---');
    $hastaCounter = 0;

    foreach ($dataHastaKarya as $index => $laporan) {
      $hastaCounter++;
      $tanggal = $laporan['tanggal'] ?? 'NULL';
      $santriNama = $laporan['santri_nama'] ?? 'Unknown';

      log_message('debug', "Hasta Karya #{$hastaCounter} - Santri: {$santriNama}");
      log_message('debug', "  Tanggal Raw: {$tanggal}");

      if (isset($laporan['tanggal']) && !empty($laporan['tanggal'])) {
        $parts = explode(",", $laporan['tanggal']);
        log_message('debug', "  Explode koma, parts count: " . count($parts));
        log_message('debug', "  Parts: " . json_encode($parts));

        if (count($parts) > 1) {
          $bulanTeks = trim($parts[1]);
          log_message('debug', "  Bulan Teks (setelah trim): '{$bulanTeks}'");

          $dateArray = explode(" ", $bulanTeks);
          log_message('debug', "  Explode spasi, array count: " . count($dateArray));
          log_message('debug', "  Date Array: " . json_encode($dateArray));

          $bulanNamaDB = $dateArray[1] ?? '';
          log_message('debug', "  Bulan Extracted: '{$bulanNamaDB}'");
          log_message('debug', "  Perbandingan: '{$bulanNamaDB}' == '{$bulanNama}' ? " . ($bulanNamaDB == $bulanNama ? 'TRUE' : 'FALSE'));

          if ($bulanNamaDB == $bulanNama) {
            $result['hastakarya'][] = $laporan;
            log_message('debug', "  ✓ MATCH! Data ditambahkan ke result");
          } else {
            log_message('debug', "  ✗ TIDAK MATCH!");
          }
        } else {
          log_message('debug', "  ✗ Format tanggal tidak ada koma atau parts < 2");
        }
      } else {
        log_message('debug', "  ✗ Tanggal kosong atau null");
      }
      log_message('debug', '');
    }

    log_message('debug', "HASIL FILTER HASTA KARYA: " . count($result['hastakarya']) . " dari " . $hastaCounter . " data");
    log_message('debug', '========================================');

    // ============================================
    // FILTER FOTO BERSERI
    // ============================================
    log_message('debug', '');
    log_message('debug', '--- PROSES FILTER FOTO BERSERI ---');
    $fotoBerseriCounter = 0;

    foreach ($dataFotoBerseri as $index => $laporan) {
      $fotoBerseriCounter++;
      $tanggal = $laporan['tanggal'] ?? 'NULL';
      $santriNama = $laporan['santri_nama'] ?? 'Unknown';

      log_message('debug', "Foto Berseri #{$fotoBerseriCounter} - Santri: {$santriNama}");
      log_message('debug', "  Tanggal Raw: {$tanggal}");

      if (isset($laporan['tanggal']) && !empty($laporan['tanggal'])) {
        $parts = explode(",", $laporan['tanggal']);
        log_message('debug', "  Explode koma, parts count: " . count($parts));
        log_message('debug', "  Parts: " . json_encode($parts));

        if (count($parts) > 1) {
          $bulanTeks = trim($parts[1]);
          log_message('debug', "  Bulan Teks (setelah trim): '{$bulanTeks}'");

          $dateArray = explode(" ", $bulanTeks);
          log_message('debug', "  Explode spasi, array count: " . count($dateArray));
          log_message('debug', "  Date Array: " . json_encode($dateArray));

          $bulanNamaDB = $dateArray[1] ?? '';
          log_message('debug', "  Bulan Extracted: '{$bulanNamaDB}'");
          log_message('debug', "  Perbandingan: '{$bulanNamaDB}' == '{$bulanNama}' ? " . ($bulanNamaDB == $bulanNama ? 'TRUE' : 'FALSE'));

          if ($bulanNamaDB == $bulanNama) {
            $result['fotoberseri'][] = $laporan;
            log_message('debug', "  ✓ MATCH! Data ditambahkan ke result");
          } else {
            log_message('debug', "  ✗ TIDAK MATCH!");
          }
        } else {
          log_message('debug', "  ✗ Format tanggal tidak ada koma atau parts < 2");
        }
      } else {
        log_message('debug', "  ✗ Tanggal kosong atau null");
      }
      log_message('debug', '');
    }

    log_message('debug', "HASIL FILTER FOTO BERSERI: " . count($result['fotoberseri']) . " dari " . $fotoBerseriCounter . " data");
    log_message('debug', '========================================');

    // ============================================
    // RINGKASAN AKHIR
    // ============================================
    log_message('debug', '');
    log_message('debug', '========== RINGKASAN HASIL FILTER ==========');
    log_message('debug', "Bulan Target: {$bulanNama}");
    log_message('debug', "Checklist   : " . count($result['checklist']) . " / {$checklistCounter}");
    log_message('debug', "Anekdot     : " . count($result['anekdot']) . " / {$anekdotCounter}");
    log_message('debug', "Hasta Karya : " . count($result['hastakarya']) . " / {$hastaCounter}");
    log_message('debug', "Foto Berseri: " . count($result['fotoberseri']) . " / {$fotoBerseriCounter}");
    log_message('debug', '============================================');
    log_message('debug', '');

    return $result;
  }

  /**
   * Get data untuk DataTables (AJAX)
   */
  public function getData()
  {
    $kelas_id = session()->get('kelas_id');
    $tahun = session()->get('tahun');
    $semester = session()->get('semester');

    // Ambil daftar laporan yang sudah dibuat
    $laporanList = $this->laporanModel->getLaporanByKelas($kelas_id, $tahun, $semester);

    return $this->response->setJSON($laporanList);
  }

  /**
   * Simpan detail laporan dari data asesmen
   */
  private function saveDetailFromAsesmen($laporan_id, $filteredData)
  {
    $detailsToInsert = [];

    foreach ($filteredData as $key => $data) {
      foreach ($data as $laporan) {
        $santri_id = $laporan['santri_id'];
        $keterangan = [];

        // Decode keterangan sesuai jenis asesmen
        if ($key === 'checklist' && isset($laporan['kejadian']) && isset($laporan['isi'])) {
          $kejadian = json_decode($laporan['kejadian'], true) ?: [];
          $isi = json_decode($laporan['isi'], true) ?: [];

          // Filter kejadian berdasarkan status 'sudah_muncul' di kolom isi
          $keterangan = [];
          foreach ($kejadian as $index => $item) {
            if (isset($isi[$index]) && $isi[$index]['status'] === 'sudah_muncul') {
              $keterangan[] = $item;
            }
          }
        } elseif ($key === 'fotoberseri' && isset($laporan['analisis_guru'])) {
          $keterangan = json_decode($laporan['analisis_guru'], true) ?: [];
        } elseif ($key === 'hastakarya' && isset($laporan['catatan'])) {
          $keterangan = json_decode($laporan['catatan'], true) ?: [];
        } elseif ($key === 'anekdot' && isset($laporan['keterangan'])) {
          $keterangan = json_decode($laporan['keterangan'], true) ?: [];
        }

        // Proses setiap keterangan
        foreach ($keterangan as $urutan => $item) {
          if (is_array($item) && isset($item['id_capaian'])) {
            $id_capaian = $item['id_capaian'];

            // Ambil isi keterangan
            $item_keterangan = $item['keterangan'] ??
              $item['analisis'] ??
              $item['catatan'] ??
              $item['kejadian'] ?? '';

            if (!empty($item_keterangan)) {
              $detailsToInsert[] = [
                'laporan_bulanan_id' => $laporan_id,
                'santri_id' => $santri_id,
                'capaian_pembelajaran_id' => $id_capaian,
                'keterangan' => $item_keterangan,
                'urutan' => $urutan
              ];
            }
          }
        }
      }
    }

    if (!empty($detailsToInsert)) {
      $this->detailModel->insertBatchDetails($detailsToInsert);
    }
  }

  /**
   * Halaman edit laporan
   */
  public function edit($laporan_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);

    if (!$laporan) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Cek apakah user berhak mengedit
    $guru_id = session()->get('user_id');
    $roles = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit laporan ini');
    }

    // Ambil detail laporan
    $details = $this->detailModel->getDetailGroupedBySantri($laporan_id);

    // Ambil daftar capaian pembelajaran
    $capaianList = $this->capaianModel->where('setting', session()->get('tahun'))->findAll();

    $data = [
      'title' => 'Edit Laporan Bulanan | KBRA Islamic Center',
      'nav' => 'laporan_bulanan',
      'laporan' => $laporan,
      'details' => $details,
      'capaian_list' => $capaianList,
      'username' => session()->get('username')
    ];

    return $this->render('admin/v_laporan_bulanan_edit', $data);
  }

  /**
   * Update detail laporan
   */
  public function updateDetail()
  {
    $detail_id = $this->request->getPost('detail_id');
    $keterangan = $this->request->getPost('keterangan');

    $detail = $this->detailModel->find($detail_id);
    if (!$detail) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Data tidak ditemukan'
      ]);
    }

    // Cek kepemilikan
    $laporan = $this->laporanModel->find($detail['laporan_bulanan_id']);
    $guru_id = session()->get('user_id');
    $roles = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Anda tidak memiliki akses'
      ]);
    }

    $this->detailModel->update($detail_id, ['keterangan' => $keterangan]);

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Data berhasil diupdate'
    ]);
  }

  /**
   * Hapus laporan
   */
  public function delete($laporan_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);

    if (!$laporan) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Laporan tidak ditemukan'
      ]);
    }

    // Cek kepemilikan
    $guru_id = session()->get('user_id');
    $roles = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Anda tidak memiliki akses untuk menghapus laporan ini'
      ]);
    }

    // Delete akan otomatis menghapus detail karena CASCADE
    $this->laporanModel->delete($laporan_id);

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Laporan berhasil dihapus'
    ]);
  }

  /**
   * Download/Print PDF laporan
   */
  public function downloadPDF($laporan_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);

    if (!$laporan) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Ambil data yang diperlukan
    $kelas = $this->kelasModel->find($laporan['kelas_id']);
    $semester = $this->semesterModel
      ->where('tingkat', $kelas['jenjang'])
      ->where('tahun', $laporan['tahun'])
      ->where('semester', $laporan['semester'])
      ->first();

    $kepala = $this->guruModel->find($semester['kepala']);
    $wali = $this->guruModel->find($kelas['wali']);

    // Ambil detail laporan - gunakan method khusus untuk PDF
    $laporan_data = $this->detailModel->getDetailGroupedForPDF($laporan_id);

    // Ambil capaian pembelajaran
    $capaian_pembelajaran = $this->capaianModel->where('setting', $laporan['tahun'])->findAll();

    $capaian_list = [];
    $capaian_list_id = [];
    $capaian_list_warna = [];

    foreach ($capaian_pembelajaran as $item) {
      $capaian_list[] = $item['nama'];
      $capaian_list_id[] = $item['id'];
      $capaian_list_warna[] = $item['warna'];
    }

    // Ambil list santri
    $listSantri = $this->ruangKelasModel->getSantriByKelas($laporan['kelas_id']);

    // Tentukan nama tingkat
    if ($kelas['jenjang'] == 'RA') {
      $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
      $nama_kepala = "Kepala Sekolah";
    } else {
      $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
      $nama_kepala = "Kepala KB IT Islamic Center";
    }

    $data = [
      'kepala' => $kepala['nama'],
      'wali' => $wali['nama'],
      'capaian_pembelajaran' => $capaian_pembelajaran,
      'semester' => $laporan['semester'],
      'tahun' => $laporan['tahun'],
      'nama_tingkat' => $nama_tingkat,
      'nama_kepala' => $nama_kepala,
      'bulan' => $laporan['nama_bulan'],
      'listSantris' => $listSantri,
      'capaian_list' => $capaian_list,
      'capaian_list_id' => $capaian_list_id,
      'capaian_list_warna' => $capaian_list_warna,
      'laporan_data' => $laporan_data,
    ];

    // Generate PDF
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

    $pdfFileName = 'laporan_bulanan_' . $laporan['bulan'] . '_' . str_replace('/', '-', $laporan['tahun']) . '.pdf';
    $dompdf->stream($pdfFileName, ['Attachment' => 0]);
  }
}
