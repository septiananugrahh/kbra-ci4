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

  // Debug logging untuk filterDataByMonth() - matikan di production
  private $debugFilterLog = false;

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

    $laporanList = $this->laporanModel->getLaporanByKelas($kelas_id, $tahun, $semester);
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

    $existingLaporan = $this->laporanModel->isLaporanExist($kelas_id, $bulan, $tahun, $semester);
    if ($existingLaporan) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Laporan untuk bulan ' . $bulanIndo[$bulan] . ' sudah ada!'
      ]);
    }

    $dataLaporanChecklist = $this->asesmenChecklistModel->getChecklistDetailWithSantri($kelas_id);
    $dataLaporanAnekdot = $this->asesmenAnekdotModel->getAnekdotDetailWithSantri($kelas_id);
    $dataLaporanHastaKarya = $this->asesmenKaryaModel->getHastaKaryaDetailWithSantri($kelas_id);
    $dataLaporanFotoBerseri = $this->asesmenFotoModel->getFotoBerseriDetailWithSantri($kelas_id);

    $filteredData = $this->filterDataByMonth(
      $bulanIndo[$bulan],
      $dataLaporanChecklist,
      $dataLaporanAnekdot,
      $dataLaporanHastaKarya,
      $dataLaporanFotoBerseri
    );

    if (
      empty($filteredData['checklist']) && empty($filteredData['anekdot']) &&
      empty($filteredData['hastakarya']) && empty($filteredData['fotoberseri'])
    ) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Tidak ada data asesmen untuk bulan ' . $bulanIndo[$bulan]
      ]);
    }

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

    $this->saveDetailFromAsesmen($laporan_id, $filteredData);

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Laporan bulan ' . $bulanIndo[$bulan] . ' berhasil dibuat!',
      'laporan_id' => $laporan_id
    ]);
  }

  /**
   * Filter data asesmen berdasarkan bulan
   * Logging debug dibungkus flag $this->debugFilterLog supaya tidak membebani
   * proses generate saat production (ratusan log_message() per generate itu mahal).
   */
  private function filterDataByMonth($bulanNama, $dataChecklist, $dataAnekdot, $dataHastaKarya, $dataFotoBerseri)
  {
    $result = ['checklist' => [], 'anekdot' => [], 'hastakarya' => [], 'fotoberseri' => []];

    $sources = [
      'checklist'   => $dataChecklist,
      'anekdot'     => $dataAnekdot,
      'hastakarya'  => $dataHastaKarya,
      'fotoberseri' => $dataFotoBerseri,
    ];

    if ($this->debugFilterLog) {
      log_message('debug', '========== MULAI FILTER BULAN: ' . $bulanNama . ' ==========');
    }

    foreach ($sources as $key => $rows) {
      $counter = 0;
      foreach ($rows as $laporan) {
        $counter++;
        if (empty($laporan['tanggal'])) continue;

        $parts = explode(',', $laporan['tanggal']);
        if (count($parts) < 2) continue;

        $dateArray = explode(' ', trim($parts[1]));
        $bulanNamaDB = $dateArray[1] ?? '';

        if ($bulanNamaDB === $bulanNama) {
          $result[$key][] = $laporan;
        }
      }

      if ($this->debugFilterLog) {
        log_message('debug', "HASIL FILTER {$key}: " . count($result[$key]) . " dari {$counter} data");
      }
    }

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

        if ($key === 'checklist' && isset($laporan['kejadian']) && isset($laporan['isi'])) {
          $kejadian = json_decode($laporan['kejadian'], true) ?: [];
          $isi = json_decode($laporan['isi'], true) ?: [];

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

        foreach ($keterangan as $urutan => $item) {
          if (is_array($item) && isset($item['id_capaian'])) {
            $id_capaian = $item['id_capaian'];

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

    $guru_id = session()->get('user_id');
    $roles = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit laporan ini');
    }

    $details = $this->detailModel->getDetailGroupedBySantri($laporan_id);
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

  public function deleteDetail()
  {
    $detail_id = $this->request->getPost('detail_id');
    $detail = $this->detailModel->find($detail_id);

    if (!$detail) {
      return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
    }

    $laporan = $this->laporanModel->find($detail['laporan_bulanan_id']);
    $guru_id = session()->get('user_id');
    $roles = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return $this->response->setJSON(['success' => false, 'message' => 'Anda tidak memiliki akses']);
    }

    $this->detailModel->delete($detail_id);
    return $this->response->setJSON(['success' => true, 'message' => 'Item berhasil dihapus']);
  }

  public function addDetail()
  {
    $laporan_id   = $this->request->getPost('laporan_id');
    $santri_id    = $this->request->getPost('santri_id');
    $capaian_id   = $this->request->getPost('capaian_id');
    $keterangan   = $this->request->getPost('keterangan');

    if (!$keterangan) {
      return $this->response->setJSON(['success' => false, 'message' => 'Keterangan tidak boleh kosong']);
    }

    $laporan = $this->laporanModel->find($laporan_id);
    $guru_id = session()->get('user_id');
    $roles   = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return $this->response->setJSON(['success' => false, 'message' => 'Anda tidak memiliki akses']);
    }

    $lastUrutan = $this->detailModel
      ->where(['laporan_bulanan_id' => $laporan_id, 'santri_id' => $santri_id, 'capaian_pembelajaran_id' => $capaian_id])
      ->orderBy('urutan', 'DESC')
      ->first();

    $urutan = $lastUrutan ? ($lastUrutan['urutan'] + 1) : 0;

    $this->detailModel->insert([
      'laporan_bulanan_id'      => $laporan_id,
      'santri_id'               => $santri_id,
      'capaian_pembelajaran_id' => $capaian_id,
      'keterangan'              => $keterangan,
      'urutan'                  => $urutan
    ]);

    return $this->response->setJSON([
      'success'    => true,
      'message'    => 'Item berhasil ditambahkan',
      'new_id'     => $this->detailModel->getInsertID(),
      'keterangan' => $keterangan
    ]);
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

    $guru_id = session()->get('user_id');
    $roles = session()->get('roles');

    if ($laporan['dibuat_oleh'] != $guru_id && !in_array('3', $roles)) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'Anda tidak memiliki akses untuk menghapus laporan ini'
      ]);
    }

    $this->laporanModel->delete($laporan_id);

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Laporan berhasil dihapus'
    ]);
  }

  /**
   * Download/Print PDF laporan per santri (non-custom, dipakai di tempat lain)
   */
  public function downloadPDFPerSantri($laporan_id, $santri_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);
    if (!$laporan) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $santri = $this->santriModel->find($santri_id);
    if (!$santri) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data = $this->_buildPdfData($laporan, 'single', $santri_id);
    $data['print_mode'] = 'single';
    $data['selected_santri_id'] = $santri_id;

    $html = view('admin/pdf/bulanan_pdf_template', $data);
    $pdfFileName = 'laporan_' . strtolower(str_replace(' ', '_', $santri['nama'])) . '_' . $laporan['bulan'] . '_' . str_replace('/', '-', $laporan['tahun']) . '.pdf';
    $this->_streamPdf($html, $pdfFileName);
  }

  /**
   * Download/Print PDF laporan (non-custom)
   */
  public function downloadPDF($laporan_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);
    if (!$laporan) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data = $this->_buildPdfData($laporan, 'all');
    $data['print_mode'] = 'all';

    $html = view('admin/pdf/bulanan_pdf_template', $data);
    $pdfFileName = 'laporan_bulanan_' . $laporan['bulan'] . '_' . str_replace('/', '-', $laporan['tahun']) . '.pdf';
    $this->_streamPdf($html, $pdfFileName);
  }

  /**
   * Halaman customize PDF - semua santri
   */
  public function customize($laporan_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);
    if (!$laporan) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data = $this->_buildPdfData($laporan, 'all');
    $data['laporan_id']  = $laporan_id;
    $data['santri_id']   = null;
    $data['santri_nama'] = null;
    $data['print_mode']  = 'all';
    $data['back_url']    = base_url('laporan-bulanan');

    return view('admin/pdf/customize_pdf_bulanan', $data);
  }

  /**
   * Halaman customize PDF - per santri
   */
  public function customizeSantri($laporan_id, $santri_id)
  {
    $laporan = $this->laporanModel->find($laporan_id);
    if (!$laporan) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $santri = $this->santriModel->find($santri_id);
    if (!$santri) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data = $this->_buildPdfData($laporan, 'single', $santri_id);
    $data['laporan_id']  = $laporan_id;
    $data['santri_id']   = $santri_id;
    $data['santri_nama'] = $santri['nama'];
    $data['print_mode']  = 'single';
    $data['back_url']    = base_url('laporan-bulanan/edit/' . $laporan_id);

    return view('admin/pdf/customize_pdf_bulanan', $data);
  }

  /**
   * Preview PDF Direct - semua santri
   */
  public function previewPdfDirect()
  {
    try {
      $laporan_id = $this->request->getPost('laporan_id');
      if (!$laporan_id) {
        return $this->response->setStatusCode(400)->setBody('Laporan ID tidak ditemukan');
      }

      $laporan = $this->laporanModel->find($laporan_id);
      $customSettings = $this->_getCustomSettings();
      $data = $this->_buildPdfData($laporan, 'all');
      $data['customSettings'] = $customSettings;
      $data['columnWidths']   = $this->_getColumnWidths();
      $data['print_mode'] = 'all';

      return $this->_renderPdf($data);
    } catch (\Exception $e) {
      log_message('error', 'Preview PDF Bulanan Error: ' . $e->getMessage());
      return $this->response->setStatusCode(500)->setBody('Error: ' . $e->getMessage());
    }
  }

  /**
   * Preview PDF Direct - per santri
   */
  public function previewPdfDirectSantri()
  {
    try {
      $laporan_id = $this->request->getPost('laporan_id');
      $santri_id  = $this->request->getPost('santri_id');
      if (!$laporan_id || !$santri_id) {
        return $this->response->setStatusCode(400)->setBody('Parameter tidak lengkap');
      }

      $laporan = $this->laporanModel->find($laporan_id);
      $customSettings = $this->_getCustomSettings();
      $data = $this->_buildPdfData($laporan, 'single', $santri_id);
      $data['customSettings'] = $customSettings;
      $data['columnWidths']   = $this->_getColumnWidths();
      $data['print_mode'] = 'single';
      $data['selected_santri_id'] = $santri_id;

      return $this->_renderPdf($data);
    } catch (\Exception $e) {
      log_message('error', 'Preview PDF Bulanan Santri Error: ' . $e->getMessage());
      return $this->response->setStatusCode(500)->setBody('Error: ' . $e->getMessage());
    }
  }

  /**
   * Generate/Download PDF custom - semua santri
   */
  public function generateCustomPdf()
  {
    $laporan_id = $this->request->getPost('laporan_id');
    $laporan = $this->laporanModel->find($laporan_id);
    $customSettings = $this->_getCustomSettings();

    $data = $this->_buildPdfData($laporan, 'all');
    $data['customSettings'] = $customSettings;
    $data['columnWidths']   = $this->_getColumnWidths();
    $data['print_mode'] = 'all';

    $html = view('admin/pdf/bulanan_pdf_template', $data);
    $filename = 'laporan_bulanan_' . $laporan['bulan'] . '_' . str_replace('/', '-', $laporan['tahun']) . '.pdf';
    $this->_streamPdf($html, $filename);
  }

  /**
   * Generate/Download PDF custom - per santri
   */
  public function generateCustomPdfSantri()
  {
    $laporan_id = $this->request->getPost('laporan_id');
    $santri_id  = $this->request->getPost('santri_id');
    $laporan = $this->laporanModel->find($laporan_id);
    $santri  = $this->santriModel->find($santri_id);
    $customSettings = $this->_getCustomSettings();

    $data = $this->_buildPdfData($laporan, 'single', $santri_id);
    $data['customSettings'] = $customSettings;
    $data['columnWidths']   = $this->_getColumnWidths();
    $data['print_mode'] = 'single';
    $data['selected_santri_id'] = $santri_id;

    $html = view('admin/pdf/bulanan_pdf_template', $data);
    $filename = 'laporan_' . strtolower(str_replace(' ', '_', $santri['nama'])) . '_' . $laporan['bulan'] . '.pdf';
    $this->_streamPdf($html, $filename);
  }

  // =====================================================================
  // PRIVATE HELPER METHODS
  // =====================================================================

  /**
   * Ambil customSettings dari POST
   */
  private function _getCustomSettings(): array
  {
    return [
      'margin_top'    => $this->request->getPost('margin_top')    ?? '0.5cm',
      'margin_bottom' => $this->request->getPost('margin_bottom') ?? '0.9cm',
      'margin_left'   => $this->request->getPost('margin_left')   ?? '3cm',
      'margin_right'  => $this->request->getPost('margin_right')  ?? '0.9cm',
      'font_size'     => $this->request->getPost('font_size')     ?? '9pt',
      'font_judul'    => $this->request->getPost('font_judul')    ?? '12pt',
      'line_height'   => $this->request->getPost('line_height')   ?? '1.1',
      'point_spacing' => $this->request->getPost('point_spacing') ?? '1px',
      'cell_padding'  => $this->request->getPost('cell_padding')  ?? '3px 5px',
    ];
  }

  /**
   * Ambil & decode column_widths_json dari POST.
   * Format: { "santri_id": [30, 30, 40], ... }
   * Santri yang tidak ada di dalamnya akan pakai lebar default (equal split) di template.
   */
  private function _getColumnWidths(): array
  {
    $json = $this->request->getPost('column_widths_json');
    if (!$json) {
      return [];
    }

    $decoded = json_decode($json, true);
    if (!is_array($decoded)) {
      return [];
    }

    // Validasi ringan: pastikan tiap value berupa array angka
    $clean = [];
    foreach ($decoded as $santriId => $widths) {
      if (is_array($widths)) {
        $clean[$santriId] = array_map('floatval', $widths);
      }
    }

    return $clean;
  }

  /**
   * Sanitasi cache key: CodeIgniter cache menolak karakter khusus
   * seperti {}()/\@: — ganti dengan underscore.
   */
  private function _safeCacheKey(string $key): string
  {
    return preg_replace('/[^a-zA-Z0-9_.-]/', '_', $key);
  }

  /**
   * Build data array untuk PDF (dipakai bersama oleh semua method)
   * Query capaian_pembelajaran & listSantri di-cache singkat karena
   * dipanggil berulang kali saat user mengubah setting di halaman customize
   * (preview di-trigger tiap kali slider digeser).
   */
  private function _buildPdfData(array $laporan, string $print_mode, $santri_id = null): array
  {
    $kelas = $this->kelasModel->find($laporan['kelas_id']);
    $semester = $this->semesterModel
      ->where('tingkat', $kelas['jenjang'])
      ->where('tahun', $laporan['tahun'])
      ->where('semester', $laporan['semester'])
      ->first();

    $kepala = $this->guruModel->find($semester['kepala']);
    $wali   = $this->guruModel->find($kelas['wali']);

    if ($print_mode === 'single' && $santri_id) {
      $laporan_data = $this->detailModel->getDetailForSingleSantri($laporan['id'], $santri_id);
    } else {
      $laporan_data = $this->detailModel->getDetailGroupedForPDF($laporan['id']);
    }

    // ✅ Cache listSantri per kelas - jarang berubah selama sesi edit/customize
    // Key di-sanitize karena cache key CodeIgniter menolak karakter {}()/\@:
    $cacheKeySantri = $this->_safeCacheKey('santri_kelas_' . $laporan['kelas_id']);
    $listSantri = cache($cacheKeySantri);
    if ($listSantri === null) {
      $listSantri = $this->ruangKelasModel->getSantriByKelas($laporan['kelas_id']);
      cache()->save($cacheKeySantri, $listSantri, 300);
    }

    // ✅ Cache capaian pembelajaran per tahun ajaran - jarang berubah
    // $laporan['tahun'] biasanya berformat "2024/2025" -> karakter "/" harus disanitize dulu
    $cacheKeyCapaian = $this->_safeCacheKey('capaian_' . $laporan['tahun']);
    $capaian_pembelajaran = cache($cacheKeyCapaian);
    if ($capaian_pembelajaran === null) {
      $capaian_pembelajaran = $this->capaianModel->where('setting', $laporan['tahun'])->findAll();
      cache()->save($cacheKeyCapaian, $capaian_pembelajaran, 300);
    }

    $capaian_list        = [];
    $capaian_list_id     = [];
    $capaian_list_warna  = [];
    foreach ($capaian_pembelajaran as $item) {
      $capaian_list[]       = $item['nama'];
      $capaian_list_id[]    = $item['id'];
      $capaian_list_warna[] = $item['warna'];
    }

    if ($kelas['jenjang'] == 'RA') {
      $nama_tingkat = "RA ISLAMIC CENTER ABDULLAH GHANIM AS SAMAIL";
      $nama_kepala  = "Kepala Sekolah";
    } else {
      $nama_tingkat = "KB IT ISLAMIC CENTER PONOROGO";
      $nama_kepala  = "Kepala KB IT Islamic Center";
    }

    return [
      'kepala'             => $kepala['nama'],
      'wali'               => $wali['nama'],
      'capaian_pembelajaran' => $capaian_pembelajaran,
      'semester'           => $laporan['semester'],
      'tahun'              => $laporan['tahun'],
      'nama_tingkat'       => $nama_tingkat,
      'nama_kepala'        => $nama_kepala,
      'bulan'              => $laporan['nama_bulan'],
      'listSantris'        => $listSantri,
      'capaian_list'       => $capaian_list,
      'capaian_list_id'    => $capaian_list_id,
      'capaian_list_warna' => $capaian_list_warna,
      'laporan_data'       => $laporan_data,
      'selected_santri_id' => $santri_id,
      'columnWidths'       => [], // default kosong, di-override di method publik yang butuh
    ];
  }

  /**
   * Buat instance Dompdf dengan opsi yang sudah dituning untuk kecepatan.
   * - isRemoteEnabled: false karena logo sudah base64 (tidak fetch network)
   * - isFontSubsettingEnabled: true supaya output lebih kecil & cepat di-stream
   * - isPhpEnabled: false karena template tidak eval PHP inline (dan lebih aman)
   */
  private function _createDompdf(): Dompdf
  {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', false);
    $options->set('isFontSubsettingEnabled', true);
    $options->set('isPhpEnabled', false);
    $options->set('defaultFont', 'Times New Roman');

    return new Dompdf($options);
  }

  /**
   * Render HTML ke PDF dan return sebagai response (untuk preview)
   */
  private function _renderPdf(array $data)
  {
    $html = view('admin/pdf/bulanan_pdf_template', $data);
    $html = preg_replace('/>\s+</', '><', $html);

    $dompdf = $this->_createDompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $canvas     = $dompdf->getCanvas();
    $totalPages = $canvas->get_page_count();

    return $this->response
      ->setHeader('Content-Type', 'application/pdf')
      ->setHeader('Content-Disposition', 'inline; filename="preview.pdf"')
      ->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
      ->setHeader('X-Total-Pages', $totalPages)
      ->setBody($dompdf->output());
  }

  /**
   * Stream PDF ke browser sebagai download
   */
  private function _streamPdf(string $html, string $filename)
  {
    $html = preg_replace('/>\s+</', '><', $html);

    $dompdf = $this->_createDompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream($filename, ['Attachment' => 1]);
  }
}
