<!DOCTYPE html>
<html>

<head>
  <title>Laporan Bulanan <?= esc($bulan) ?></title>
  <style>
    @page {
      /* Margin kiri 3cm untuk lubang binder/penjilidan */
      margin: <?= $customSettings['margin_top'] ?? '0.5cm' ?> <?= $customSettings['margin_right'] ?? '0.9cm' ?> <?= $customSettings['margin_bottom'] ?? '0.9cm' ?> <?= $customSettings['margin_left'] ?? '3cm' ?>;
      size: 330mm 210mm;
      /* F4 Landscape */
    }

    body {
      font-family: "DejaVu Sans", "Times New Roman", serif;
      font-size: <?= $customSettings['font_size'] ?? '9pt' ?>;
      line-height: 1.2;
      margin: 0;
    }

    /* Container Kop & Info dalam Table Header */
    .header-wrapper {
      width: 100%;
      text-align: center;
      border-bottom: 2px solid #000;
      margin-bottom: 10px;
    }

    .logo {
      position: absolute;
      top: 0;
      left: 0;
      width: 60px;
    }

    /* Container tabel info agar tidak ada jarak luar */
    .info-table {
      width: auto;
      border-collapse: collapse;
      margin: 0;
      padding: 0;
      line-height: 1;
      /* Mengatur kerapatan teks vertikal */
    }

    /* Mengatur sel tabel info */
    .info-table td {
      padding: 0px 2px;
      /* 0px atas-bawah, 2px kiri-kanan untuk spasi titik dua */
      border: none !important;
      vertical-align: baseline;
      font-size: 9pt;
      /* Sesuaikan dengan kebutuhan */
    }

    /* Opsional: Jika ingin lebih rengket lagi, paksa tinggi baris */
    .info-table tr {
      height: 0;
    }

    /* Tabel Utama */
    .table-bulanan {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      /* Menjaga lebar kolom konsisten */
    }

    .table-bulanan th {
      border: 1px solid #000;
      padding: 5px;
      background-color: #f2f2f2;
      font-weight: bold;
      text-align: center;
    }

    .table-bulanan td {
      border: 1px solid #000;
      padding: 5px;
      vertical-align: top;
      word-wrap: break-word;
    }

    .signature-table {
      width: 100%;
      margin-top: 20px;
      page-break-inside: avoid;
      /* Jangan potong tanda tangan */
    }

    .page-break {
      page-break-after: always;
    }

    .keterangan-item {
      margin-bottom: 2px;
    }
  </style>
</head>

<body>

  <?php
  // Fungsi bantu untuk gambar (letakkan di atas atau di Helper CI4)
  function imageToBase64($path)
  {
    if (!file_exists($path)) return '';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
  }

  $logoBase64 = imageToBase64(FCPATH . 'logo-200px.png');
  ?>

  <?php foreach ($listSantris as $indexSantri => $santri):
    $lookup_id = $santri['id'] ?? $santri['santri_id'];

    // Skip jika mode single
    if (isset($print_mode) && $print_mode === 'single' && $lookup_id != $selected_santri_id) continue;

    // Siapkan data per kolom agar bisa di-loop sekaligus
    $data_per_kolom = [];
    $max_rows = 0;
    foreach ($capaian_list_id as $id_capaian) {
      $items = isset($laporan_data[$lookup_id]['capaian'][$id_capaian]) ?
        array_values(array_filter($laporan_data[$lookup_id]['capaian'][$id_capaian])) : [];
      $data_per_kolom[$id_capaian] = $items;
      $max_rows = max($max_rows, count($items));
    }
  ?>

    <table class="table-bulanan">
      <thead>
        <tr>
          <th colspan="<?= count($capaian_list) ?>" style="border:none; background:none; padding:0;">
            <div style="position: relative; text-align: center; padding-bottom: 5px;">
              <?php if ($logoBase64): ?>
                <img src="<?= $logoBase64 ?>" class="logo" style="position:absolute; left:0;">
              <?php endif; ?>
              <h2 style="margin:0; font-size: 14pt;">PENILAIAN BULANAN <br><?= esc($nama_tingkat) ?></h2>
              <p style="margin:2px 0;">Tahun Pelajaran <?= esc($tahun) ?></p>
              <hr style="border: 1px solid #000;">
            </div>

            <table class="info-table">
              <tr>
                <td style="width: 100px;">Nama Santri</td>
                <td>: <strong><?= esc($santri['nama']) ?></strong></td>
              </tr>
              <tr>
                <td>Kelas</td>
                <td>: <?= esc($santri['kelas_tingkat'] ?? '') ?> <?= esc($santri['kelas_nama'] ?? '') ?></td>
              </tr>
              <tr>
                <td>Semester</td>
                <td>: <?= esc($semester) ?></td>
              </tr>
              <tr>
                <td>Bulan</td>
                <td>: <?= esc($bulan) ?></td>
              </tr>
            </table>
          </th>
        </tr>

        <tr>
          <?php foreach ($capaian_list as $idx => $nama): ?>
            <th style="width: <?= 100 / count($capaian_list) ?>%; background-color: <?= $capaian_list_warna[$idx] ?? '#f2f2f2' ?>;">
              <?= esc($nama) ?>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>

      <tbody>
        <?php if ($max_rows > 0): ?>
          <?php for ($i = 0; $i < $max_rows; $i++): ?>
            <tr>
              <?php foreach ($capaian_list_id as $id_capaian): ?>
                <td>
                  <?php if (isset($data_per_kolom[$id_capaian][$i])): ?>
                    <div class="keterangan-item">• <?= esc($data_per_kolom[$id_capaian][$i]) ?></div>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endfor; ?>
        <?php else: ?>
          <tr>
            <td colspan="<?= count($capaian_list) ?>" style="text-align:center; padding: 20px;">Data Belum Tersedia</td>
          </tr>
        <?php endif; ?>
      </tbody>

      <tfoot>
        <tr>
          <td colspan="<?= count($capaian_list) ?>" style="border:none; padding:0;">
            <table class="signature-table">
              <tr>
                <td style="width: 50%; text-align: center; border:none;">
                  Mengetahui,<br>Kepala Madrasah<br><br><br><br>
                  <strong><?= esc($kepala ?? '....................') ?></strong>
                </td>
                <td style="width: 50%; text-align: center; border:none;">
                  &nbsp <br>Wali Kelas<br><br><br><br>
                  <strong><?= esc($wali ?? '....................') ?></strong>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </tfoot>
    </table>

    <?php if ($indexSantri < count($listSantris) - 1): ?>
      <div class="page-break"></div>
    <?php endif; ?>

  <?php endforeach; ?>

</body>

</html>