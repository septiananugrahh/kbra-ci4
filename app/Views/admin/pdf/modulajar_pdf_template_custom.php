<?php

function getDplData($dpl_id)
{
  $db = \Config\Database::connect();
  $query = $db->table('dimensi_profil_lulusan')->where('id', $dpl_id)->get();
  $result = $query->getRow();
  return $result ? $result->nama : '';
}

function getKbcData($kbc_id)
{
  $db = \Config\Database::connect();
  $query = $db->table('kurikulum_cinta')->where('id', $kbc_id)->get();
  $result = $query->getRow();
  return $result ? $result->nama : '';
}

// Color configuration
$dpl_color = '#6c5ce7';
$dpl_bg_color = '#f4f3ff';
$kbc_color = '#e74c3c';
$kbc_bg_color = '#ffeaa7';
$ukuran_font_judul = '14px';
$ukuran_font_judul_dimensi_pembelajaran = '14px';

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
      margin-top: <?= $customSettings['margin_top'] ?? '1.3cm' ?>;
      margin-bottom: <?= $customSettings['margin_bottom'] ?? '2cm' ?>;
      margin-right: <?= $customSettings['margin_right'] ?? '1cm' ?>;
      margin-left: <?= $customSettings['margin_left'] ?? '3cm' ?>;
      size: 215mm 330mm;
    }

    body {
      font-family: "Times New Roman", "DejaVu Sans", serif;
      font-size: <?= $customSettings['font_size'] ?? '10pt' ?>;
      line-height: <?= $customSettings['line_height'] ?? '1.08' ?>;
      margin: 0;
      padding: 0;
      background: white;
    }

    .page-wrapper {
      background: white;
      margin: 0;
      padding: 0;
    }

    h4 {
      line-height: 0.5em;
    }

    h2 {
      line-height: 0.8em;
      margin-top: 0.5em;
      margin-bottom: 0.5em;
      padding: 0;
      text-align: center;
      color: #333;
    }

    p {
      line-height: 1.4em;
      margin-top: 0.5em;
      margin-bottom: 0.5em;
      padding: 0;
      text-align: justify;
      color: #555;
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
      page-break-after: always;
    }

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
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .table-checklist th,
    .table-checklist td {
      border: 1px solid black;
      padding: 2px;
      text-align: left;
      vertical-align: top;
    }

    .table-checklist th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .arrow {
      margin-right: 5px;
      font-weight: bold;
    }

    .tab {
      margin-left: 20px;
    }

    .myDataTable td {
      vertical-align: top;
      padding-bottom: <?= $customSettings['point_spacing'] ?? '5px' ?>;
    }

    h5 {
      font-size: <?= $customSettings['font_judul'] ?? '14px' ?>;
    }

    .myDataTable tr {
      margin-bottom: <?= $customSettings['point_spacing'] ?? '5px' ?>;
    }

    .signature-section {
      page-break-inside: avoid;
      break-inside: avoid;
      margin-top: 30px;
    }

    /* Hide page break indicators - tidak diperlukan di PDF */
    .page-break {
      display: none !important;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="contentWrapper">
    <?php $abjadBesar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
    $urutan_abjad = 0; ?>

    <center style="margin-left: 40px; margin-right: 40px;">
      <h3 style="line-height: 1.0; margin: 2px 0;">MODUL AJAR</h3>
      <h3 style="line-height: 1.0; margin: 2px 0;"><?= esc($nama_tingkat) ?></h3>
      <h5 style="line-height: 1.0; margin: 2px 0;">Tahun Pelajaran <?= esc($tahun) ?></h5>
    </center>
    <img src="<?= base_url('logo-200px.png') ?>" alt="" style="position:absolute; top:5px; left:5px; width:55px;">
    <hr>

    <h3><strong>I. Informasi Umum</strong></h3>
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
              <?php foreach ($dataCapaianPembelajarans as $dataCapaianPembelajaran): ?>
                <tr>
                  <td>&#8594;</td>
                  <td><?= esc($dataCapaianPembelajaran['nama_capaian_pembelajaran']) ?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </td>
        </tr>
      </table>
    </div>

    <h3><strong>II. Komponen Inti</strong></h3>

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

      <?php if (!empty($dataDimensiPembelajarans)): ?>
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

      <?php if (!empty($dataKurikulumCintas)): ?>
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
              <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">Praktik Pedagogik<br></span>
              Model: <?= esc($data_dp['pedagogik_model'] ?? '-Kosong-') ?><br>
              Strategi: <?= esc($data_dp['pedagogik_strategi'] ?? '-Kosong-') ?><br>
              Metode: <?= esc($data_dp['pedagogik_metode'] ?? '-Kosong-') ?><br>
            </td>
          </tr>
          <tr>
            <td>●</td>
            <td>
              <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">Kemitraan Pembelajaran</span> <br>
              <?= nl2br(esc($data_dp['kemitraan'] ?? '-Kosong-')) ?> <br>
            </td>
          </tr>
          <tr>
            <td>●</td>
            <td>
              <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">Lingkungan Pembelajaran</span> <br>
              Ruang Fisik: <?= esc($data_dp['ruang_fisik'] ?? '-Kosong-') ?><br>
              Ruang Virtual: <?= esc($data_dp['ruang_virtual'] ?? '-Kosong-') ?><br>
            </td>
          </tr>
          <tr>
            <td>●</td>
            <td>
              <span style="font-size:<?= $ukuran_font_judul_dimensi_pembelajaran ?>;">Pemanfaatan Digital</span> <br>
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

          if (empty($tanggal)) continue;
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
                  $extra_data = '';
                  $select_key = $select_value[$index] ?? '';
                  $extra_data = getSelectStyle($select_key, $dpl_color, $dpl_bg_color, $kbc_color, $kbc_bg_color);
              ?>
                  <tr>
                    <td><?= $abjad[$no - 1] . '. ' ?></td>
                    <td><?= esc($pembukaan) ?> <?= $extra_data ?></td>
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
                foreach ($decoded_intis as $index => $inti) {
                  $extra_data = '';
                  $select_key = $select_value[$index] ?? '';
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
  </div>
</body>

</html>