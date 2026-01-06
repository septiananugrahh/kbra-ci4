<?php

function getDplData($dpl_id)
{
  // Query ke database untuk mendapatkan data berdasarkan dpl_id
  $db = \Config\Database::connect();
  $query = $db->table('dimensi_profil_lulusan')->where('id', $dpl_id)->get();
  $result = $query->getRow();
  return $result ? $result->nama : ''; // Mengambil nama atau data yang relevan dari tabel
}

function getKbcData($kbc_id)
{
  // Query ke database untuk mendapatkan data berdasarkan kbc_id
  $db = \Config\Database::connect();
  $query = $db->table('kurikulum_cinta')->where('id', $kbc_id)->get();
  $result = $query->getRow();
  return $result ? $result->nama : ''; // Mengambil nama atau data yang relevan dari tabel
}

// ✅ COLOR CONFIGURATION
$dpl_color = '#6c5ce7';
$dpl_bg_color = '#f4f3ff';
$kbc_color = '#e74c3c';
$kbc_bg_color = '#ffeaa7';
$ukuran_font_judul = '14px';
$ukuran_font_judul_dimensi_pembelajaran = '14px';

// ✅ HELPER FUNCTION untuk generate style
function getSelectStyle($select_key, $dpl_color, $dpl_bg_color, $kbc_color, $kbc_bg_color)
{
  if (strpos($select_key, 'dpl') !== false) {
    $dpl_id = str_replace('dpl-', '', $select_key);
    $dpl_data = getDplData($dpl_id);
    return "<span style='color: {$dpl_color}; background-color: {$dpl_bg_color}; padding: 2px 6px; border-radius: 3px; font-size: 9pt; font-weight: 600;'>({$dpl_data})</span>";
  } elseif (strpos($select_key, 'kbc') !== false) {
    $kbc_id = str_replace('kbc-', '', $select_key);
    $kbc_data = getKbcData($kbc_id);
    return "<span style='color: {$kbc_color}; background-color: {$kbc_bg_color}; padding: 2px 6px; border-radius: 3px; font-size: 9pt; font-weight: 600;'>({$kbc_data})</span>";
  }
  return '';
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Modul Ajar <?= esc($modul_ajar_id) ?></title>
  <style>
    @page {
      margin-top: 1.3cm;
      margin-bottom: 2cm;
      margin-right: 1cm;
      margin-left: 3cm;
    }

    .page:last-child {
      page-break-after: unset;
    }

    body {
      font-family: "Times New Roman", "DejaVu Sans", serif;
      font-size: 10pt;
      line-height: 1.08;
      /* DomPDF perlu sedikit lebih kecil */
      margin: 0;
      padding: 0;
    }


    h4 {
      line-height: 0.5em;
    }

    h2 {
      line-height: 0.8em;
      /* Adjust this value to control space between lines in the title */
      margin-top: 0.5em;
      /* Optional: Adjust top margin */
      margin-bottom: 0.5em;
      /* Optional: Adjust bottom margin */
      padding: 0;
      /* Remove default padding */
      text-align: center;
      /* Example: Center your title */
      color: #333;
      /* Example: Dark grey color */
    }

    /* Text formatting for paragraphs and other general text */
    p {
      line-height: 1.4em;
      /* Adjust this value for general text to prevent large gaps */
      margin-top: 0.5em;
      /* Optional: Adjust top margin */
      margin-bottom: 0.5em;
      /* Optional: Adjust bottom margin */
      padding: 0;
      /* Remove default padding */
      text-align: justify;
      /* Example: Justify your paragraphs */
      color: #555;
      /* Example: Medium grey color */
    }


    .header-info {
      text-align: center;
      margin-bottom: 2px;
    }

    .record-card {
      padding: 2px;
      margin-bottom: 20px;
      border-radius: 5px;
      page-break-inside: avoid;
      /* Hindari pemotongan di tengah card */
      page-break-after: always;
      /* Paksa halaman baru setelah setiap santri (opsional, sesuaikan) */
    }

    /* Hapus page-break-after jika Anda ingin beberapa santri dalam satu halaman */
    /* .record-card:last-of-type { page-break-after: auto; } */


    .record-card p {
      margin-bottom: 5px;
    }

    .photo-table img {
      max-width: 100%;
      height: 120px;
      object-fit: contain;
      display: block;
      margin: 0 auto;
      border: 1px solid #ddd;
      padding: 3px;
      background-color: #fff;
    }

    .photo-caption {
      font-size: 8pt;
      color: #555;
      margin-top: 5px;
      word-wrap: break-word;
    }

    .section-title {
      margin-top: 25px;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    .table-checklist {
      width: 100%;
      /* Pastikan tabel mengisi lebar yang tersedia */
      border-collapse: collapse;
      /* Ini sangat penting untuk border tunggal */
      margin-bottom: 20px;
      /* Jarak bawah tabel */
    }

    .table-checklist th,
    .table-checklist td {
      border: 1px solid black;
      /* Border 1px solid hitam */
      padding: 2px;
      /* Padding di dalam sel */
      text-align: left;
      /* Perataan teks */
      vertical-align: top;
      /* Perataan vertikal teks */
    }

    /* (Opsional) Styling tambahan untuk header tabel */
    .table-checklist th {
      background-color: #f2f2f2;
      /* Warna latar belakang header */
      font-weight: bold;
    }
  </style>

  <style>
    .arrow {
      margin-right: 5px;
      font-weight: bold;
    }

    .tab {
      margin-left: 20px;
    }
  </style>

  <style>
    .myDataTable td {
      vertical-align: top;
    }
  </style>

  <style>
    /* Signature section tetap di halaman yang sama */
    .signature-section {
      page-break-inside: avoid;
      break-inside: avoid;
      margin-top: 30px;
    }
  </style>
</head>

<body>

  <?php $abjadBesar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
  $urutan_abjad = 0; ?>
  <center style="margin-left: 40px; margin-right: 40px;">
    <h3 style="line-height: 1.0; margin: 2px 0;">MODUL AJAR</h3>
    <h3 style="line-height: 1.0; margin: 2px 0;"><?= esc($nama_tingkat) ?></h3>
    <h5 style="line-height: 1.0; margin: 2px 0;">Tahun Pelajaran <?= esc($tahun) ?></h5>
  </center>
  <img src="<?= base_url('logo-200px.png') ?>" alt="" style="position:absolute; top:5px; left:5px; width:55px;">
  <hr>

  <h3>
    <strong>
      I. Informasi Umum
    </strong>
  </h3>
  <div class="header-info">
    <table>
      <tr>
        <td>Instansi</td>
        <td>:</td>
        <td><?= esc($nama_tingkat) ?></td>
      </tr>

      <tr>
        <td>Penulis</td>
        <td>:</td>
        <td><?= esc($wali) ?></td>
      </tr>

      <tr>
        <td>Fase/Kelompok Usia</td>
        <td>:</td>
        <td>Fondasi/<?= esc($kelompok_usia) ?></td>
      </tr>

      <tr>
        <td>Tahun Pelajaran</td>
        <td>:</td>
        <td><?= esc($tahun) ?></td>
      </tr>

      <tr>
        <td>Semester/Pekan</td>
        <td>:</td>
        <td><?= esc($semester_nama) ?>/Pekan <?= esc($data_modulajar['pekan'])  ?></td>
      </tr>

      <tr>
        <td>Estimasi Waktu</td>
        <td>:</td>
        <td>5 hari(<?= esc($data_modulajar['dibuat_tanggal'])  ?>)</td>
      </tr>

      <tr>
        <td>Topik/SubTopik</td>
        <td>:</td>
        <td><?= esc($data_modulajar['topik_pembelajaran']) . "/" . esc($data_modulajar['subtopik_pembelajaran'])  ?></td>
      </tr>

      <tr>
        <td style="vertical-align: top;">Elemen CP</td>
        <td style="vertical-align: top;">:</td>
        <td>
          <table class="myDataTable">
            <?php
            foreach ($dataCapaianPembelajarans as $dataCapaianPembelajaran): ?>
              <tr>
                <td>&#8594;</td>
                <td><?= esc($dataCapaianPembelajaran['nama_capaian_pembelajaran']) ?></td>
              </tr>
            <?php
            endforeach; ?>
          </table>
        </td>
      </tr>
    </table>
  </div>

  <h3>
    <strong>
      II. Komponen Inti
    </strong>
  </h3>

  <div class="tab">
    <h5 style="margin-top: 0; margin-bottom:0; font-size:<?= $ukuran_font_judul ?>;">
      <strong><?php echo strtoupper($abjadBesar[$urutan_abjad]);
              $urutan_abjad++; ?>. Tujuan Pembelajaran</strong>
    </h5>
    <div class="tab">
      <table class="myDataTable">
        <?php $no = 1;
        foreach ($dataTujuanPembelajarans as $dataTujuanPembelajaran): ?>
          <tr>
            <td><?= $no . '. ' ?></td>
            <td><?= esc($dataTujuanPembelajaran['nama']) ?></td>
          </tr>
        <?php $no++;
        endforeach; ?>
      </table>
    </div>

    <?php if (!empty($dataDimensiPembelajarans)): ?> <!-- Cek jika ada data -->
      <h5 style="margin-top: 20px; margin-bottom: 0px; font-size:<?= $ukuran_font_judul ?>; display: inline; color: <?= $dpl_color ?>; background-color: <?= $dpl_bg_color ?>;">
        <strong><?php echo strtoupper($abjadBesar[$urutan_abjad]);
                $urutan_abjad++; ?>. Dimensi Profil Lulusan</strong>
      </h5>
      <div class="tab">
        <table class="myDataTable">
          <?php $no = 1;
          foreach ($dataDimensiPembelajarans as $dataDimensiPembelajaran): ?>
            <tr>
              <td><?= $no . '. ' ?></td>
              <td><?= esc($dataDimensiPembelajaran['nama']) ?></td>
            </tr>
          <?php $no++;
          endforeach; ?>
        </table>
      </div>
    <?php endif; ?>

    <?php if (!empty($dataKurikulumCintas)): ?> <!-- Cek jika ada data -->
      <h5 style="margin-top: 20; margin-bottom:0; font-size:<?= $ukuran_font_judul ?>; display: inline; color: <?= $kbc_color ?>; background-color: <?= $kbc_bg_color ?>;">
        <strong><?php echo strtoupper($abjadBesar[$urutan_abjad]);
                $urutan_abjad++; ?>. Kurikulum Berbasis Cinta</strong>
      </h5>
      <div class="tab">
        <table class="myDataTable">
          <?php $no = 1;
          foreach ($dataKurikulumCintas as $dataKurikulumCinta): ?>
            <tr>
              <td><?= $no . '. ' ?></td>
              <td><?= esc($dataKurikulumCinta['nama']) ?></td>
            </tr>
          <?php $no++;
          endforeach; ?>
        </table>
      </div>
    <?php endif; ?>

    <h5 style="margin-top: 20; margin-bottom:0; font-size:<?= $ukuran_font_judul ?>;"><strong><?php echo strtoupper($abjadBesar[$urutan_abjad]);
                                                                                              $urutan_abjad++; ?>. Desain Pembelajaran</strong></h5>
    <div class="tab">
      <table class="myDataTable">
        <tr>
          <td>●</td>
          <td>
            <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">
              Praktik Pedagogik<br>
            </span>
            Model: <?= esc($data_dp['pedagogik_model'] ?? '-Kosong-') ?><br>
            Strategi: <?= esc($data_dp['pedagogik_strategi'] ?? '-Kosong-') ?><br>
            Metode: <?= esc($data_dp['pedagogik_metode'] ?? '-Kosong-') ?><br>
          </td>
        </tr>
        <tr>
          <td>●</td>
          <td>
            <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">
              Kemitraan Pembelajaran
            </span> <br>
            <?= nl2br(esc($data_dp['kemitraan'] ?? '-Kosong-')) ?> <br>
          </td>
        </tr>
        <tr>
          <td>●</td>
          <td>
            <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">
              Lingkungan Pembelajaran
            </span> <br>
            Ruang Fisik: <?= esc($data_dp['ruang_fisik'] ?? '-Kosong-') ?><br>
            Ruang Virtual: <?= esc($data_dp['ruang_virtual'] ?? '-Kosong-') ?><br>
          </td>
        </tr>
        <tr>
          <td>●</td>
          <td>
            <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">
              Pemanfaatan Digital
            </span> <br>
            <?= nl2br(esc($data_dp['pemanfaatan_digital'] ?? '-Kosong-')) ?> <br>
          </td>
        </tr>
      </table>
    </div>
    <h5 style="margin-top: 20; margin-bottom:0; font-size:<?= $ukuran_font_judul ?>;">
      <?php echo strtoupper($abjadBesar[$urutan_abjad]);
      $urutan_abjad++; ?>. Langkah-Langkah Kegiatan</strong>
    </h5>

    <div class="tab">
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <?php
        $tanggal = $data_modulajar["subsubTopik_tanggal{$i}"] ?? '';
        $subsubtopik = $data_modulajar["subsubTopik_{$i}"] ?? '';
        $pembukaans = $data_modulajar["pembukaan_{$i}"] ?? '';
        $intis = $data_modulajar["kegiatan_inti_{$i}"] ?? '';
        $pemantiks = $data_modulajar["pertanyaan_pemantik_{$i}"] ?? '';
        $merefleksi = $data_modulajar["merefleksi_{$i}"] ?? '';
        $media_ajar = $data_modulajar["mediapembelajaran_{$i}"] ?? '';

        if (empty($tanggal)) continue; // skip kalau tidak ada tanggal
        ?>

        <h4 style="color:#27ae60;margin-bottom: 0; font-size:16px" class="mt-4"><span class="arrow">&#10148;</span> Hari Ke-<?= $i ?> (<?= esc($subsubtopik) ?>)</h4>

        <h5 style="margin-top: 0;">Alat dan Bahan : <?= ucwords(esc($media_ajar)) ?></h5>


        <h5 style="margin-bottom: 0; margin-top: 0;">Pertanyaan Pemantik</h5>
        <div class="tab">
          <table class="myDataTable">
            <?php $decoded_pemantiks = json_decode($pemantiks);
            if (is_array($decoded_pemantiks) || is_object($decoded_pemantiks)) {
              $no = 1;
              $abjad = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];
              foreach ($decoded_pemantiks as $pemantik) { ?>
                <tr>
                  <td><?= $abjad[$no - 1] . '. ' ?></td>
                  <td><?= esc($pemantik) ?></td>
                </tr>

            <?php
                $no++;
              }
            } else {
              echo "Data tidak valid atau kosong.<br>";
            } ?>
          </table>
        </div>

        <h5 style="margin-bottom: 0;">1. Pembukaan(Berkesadaran, Bermakna, Menggembirakan, Memahami, Mengaplikasikan)</h5>
        <div class="tab">
          <table class="myDataTable">
            <?php $decoded_pembukaans = json_decode($pembukaans);
            $select_value = isset($data_kbcdpl["pembukaan_{$i}_select"]) ? json_decode($data_kbcdpl["pembukaan_{$i}_select"]) : [];

            if (is_array($decoded_pembukaans) || is_object($decoded_pembukaans)) {
              $no = 1;
              $abjad = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];

              foreach ($decoded_pembukaans as $index => $pembukaan) {
                // Ambil data tambahan berdasarkan index select_value
                $extra_data = '';
                $select_key = $select_value[$index] ?? ''; // Menyesuaikan dengan index yang sesuai
                $color = ''; // Variabel untuk warna

                $extra_data = getSelectStyle($select_key, $dpl_color, $dpl_bg_color, $kbc_color, $kbc_bg_color);

            ?>
                <tr>
                  <td><?= $abjad[$no - 1] . '. ' ?></td>
                  <td><?= esc($pembukaan) ?> <?= $extra_data ?></td> <!-- Menambahkan data berdasarkan kondisi -->
                </tr>
            <?php
                $no++;
              }
            } else {
              echo "Data tidak valid atau kosong.<br>";
            } ?>
          </table>
        </div>


        <h5 style="margin-bottom: 0;">2. Kegiatan Inti(Berkesadaran, Bermakna, Menggembirakan, Memahami, Mengaplikasikan)</h5>
        <div class="tab">
          <table class="myDataTable">
            <?php $decoded_intis = json_decode($intis);
            $select_value = isset($data_kbcdpl["inti_{$i}_select"]) ? json_decode($data_kbcdpl["inti_{$i}_select"]) : [];

            if (is_array($decoded_intis) || is_object($decoded_intis)) {
              $no = 1;
              $abjad = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];
              // foreach ($decoded_intis as $inti) {
              foreach ($decoded_intis as $index => $inti) {
                // Ambil data tambahan berdasarkan index select_value
                $extra_data = '';
                $select_key = $select_value[$index] ?? ''; // Menyesuaikan dengan index yang sesuai
                $color = ''; // Variabel untuk warna

                $extra_data = getSelectStyle($select_key, $dpl_color, $dpl_bg_color, $kbc_color, $kbc_bg_color);

            ?>
                <tr>
                  <td width="20%"><?= $abjad[$no - 1] . '. Kegiatan ' . $no . ': ' ?></td>
                  <td width="80%"><?= esc($inti)  ?> <?= $extra_data ?></td>
                </tr>
            <?php
                $no++;
              }
            } else {
              echo "Data tidak valid atau kosong.<br>";
            } ?>
          </table>
        </div>


        <!-- <h5 style="margin-bottom: 0;">3. Merefleksi</h5>
        <div class="tab">
          <table class="myDataTable">
            <?php $decoded_merefleksi = json_decode($merefleksi);
            $select_value = isset($data_kbcdpl["merefleksi_{$i}_select"]) ? json_decode($data_kbcdpl["merefleksi_{$i}_select"]) : [];

            if (is_array($decoded_merefleksi) || is_object($decoded_merefleksi)) {
              $no = 1;
              $abjad = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'];
              // foreach ($decoded_merefleksi as $merefleksi_extr) {
              foreach ($decoded_merefleksi as $index => $merefleksi_extr) {

                $extra_data = '';
                $select_key = $select_value[$index] ?? ''; // Menyesuaikan dengan index yang sesuai
                $color = ''; // Variabel untuk warna

                $extra_data = getSelectStyle($select_key, $dpl_color, $dpl_bg_color, $kbc_color, $kbc_bg_color);
            ?>
                <tr>
                  <td><?= $abjad[$no - 1] . '. ' ?></td>
                  <td><?= esc($merefleksi_extr) ?><?= $extra_data ?></td>
                </tr>

            <?php
                $no++;
              }
            } else {
              echo "Data tidak valid atau kosong.<br>";
            } ?>
          </table>
        </div> -->
        <div style="margin-bottom: 50px;"></div>

      <?php endfor; ?>
    </div>

    <h5><strong><?php echo strtoupper($abjadBesar[$urutan_abjad]);
                $urutan_abjad++; ?>. Penutup (Merefleksi)</strong></h5>
    <div class="tab">
      <table>
        <tr>
          <td style="vertical-align: top;">1.</td>
          <td>Membereskan Area Kegiatan Main</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">2.</td>
          <td>Menguatkan konsep yang telah dibangun anak selama bermain sesuai dengan tujuan pembelajaran</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">3.</td>
          <td>Memberikan apresiasi/penghargaan atas perilaku positif yang dilakukan anak</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">4.</td>
          <td>Memberikan kesempatan kepada anak untuk mengkomunikasikan hasil karya atau pengalaman mainnya kepada teman dan juga guru</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">5.</td>
          <td>Membuat refleksi bersama anak mengenai keberhasilan atau hal positif yang telah dilakukan oleh dirinya atau temannya yang lain</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">6.</td>
          <td>Penyampaian informasi kegiatan esok hari</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">7.</td>
          <td>Salam dan doa penutup</td>
        </tr>
      </table>
    </div>

    <div class="signature-section">
      <h5><strong><?php echo strtoupper($abjadBesar[$urutan_abjad]);
                  $urutan_abjad++; ?>. Rencana Penilaian</strong></h5>
      <div class="tab">
        1. Checklist <br>
        2. Hasil Karya <br>
        3. Catatan Anekdot <br>
        4. Foto Berseri <br>
      </div>

    </div>
  </div>

  <!-- SIGNATURE SECTION -->
  <div class="signature-section">
    <table width="100%" border="0" style="text-align: center; margin-top:15px">
      <tr>
        <td width="50%">Mengetahui</td>
        <td width="50%"></td>
      </tr>
      <tr>
        <td><?= esc($nama_kepala) ?></td>
        <td>Wali Kelas</td>
      </tr>
      <tr>
        <td height="50px"></td>
        <td></td>
      </tr>
      <tr>
        <td><?= esc($kepala) ?></td>
        <td><?= esc($wali) ?></td>
      </tr>
    </table>
  </div>