<!DOCTYPE html>
<html>

<head>
  <title>Laporan Bulanan <?= esc($bulan) ?></title>
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
      line-height: 1.1em;
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

    .section-title {
      margin-top: 25px;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    .table-bulanan {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .table-bulanan th,
    .table-bulanan td {
      border: 1px solid black;
      padding: 5px 8px;
      /* Lebih kecil padding */
      text-align: left;
      vertical-align: top;
    }

    .table-bulanan th {
      background-color: #f2f2f2;
      font-weight: bold;
      text-align: center;
      font-size: 9pt;
      /* Ukuran font judul lebih kecil */
    }

    .keterangan-item {
      display: block;
      margin-bottom: 2px;
      /* Mengurangi margin bawah */
      padding: 0;
      /* Menghilangkan padding */
      line-height: 1.2;
      /* Menurunkan jarak antar teks */
      font-size: 9pt;
      /* Menurunkan ukuran font */
    }

    .page-break {
      page-break-before: always;
    }
  </style>

</head>

<body>

  <?php foreach ($listSantris as $santri): ?>

    <center>
      <h2>PENILAIAN BULANAN</h2>
      <h2><?= esc($nama_tingkat) ?></h2>
      <h4>Tahun Pelajaran <?= esc($tahun) ?></h4>
    </center>
    <img src="<?= base_url('logo-200px.png') ?>" alt="" style="position:absolute; top:0px; width:80px;">
    <hr>

    <div>
      <div class="header-info">
        <table>
          <tr>
            <td>Nama Santri</td>
            <td>:</td>
            <td><strong><?= esc($santri['nama']) ?></strong></td>
          </tr>

          <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?= esc($santri['kelas_tingkat']) ?> <?= esc($santri['kelas_nama']) ?></td>
          </tr>

          <tr>
            <td>Semester</td>
            <td>:</td>
            <td><?= esc($semester) ?></td>
          </tr>

          <tr>
            <td>Bulan</td>
            <td>:</td>
            <td><?= esc($bulan) ?></td>
          </tr>
        </table>
      </div>

      <table class="table-bulanan">
        <thead>
          <tr>
            <?php foreach ($capaian_list as $index => $nama_capaian) : ?>
              <th style="width: 33%; font-size: 11pt; background-color: <?= htmlspecialchars($capaian_list_warna[$index]) ?>;">
                <?= esc($nama_capaian) ?>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php foreach ($capaian_list_id as $id_capaian) : ?>
              <td>
                <?php
                // Cek apakah santri ini ada di data laporan
                if (isset($laporan_data[$santri['id']])) {
                  $santri_data = $laporan_data[$santri['id']];

                  // Cek apakah ada data untuk capaian ini
                  if (
                    isset($santri_data['capaian'][$id_capaian]) &&
                    is_array($santri_data['capaian'][$id_capaian]) &&
                    !empty($santri_data['capaian'][$id_capaian])
                  ) {

                    // Loop setiap keterangan
                    foreach ($santri_data['capaian'][$id_capaian] as $keterangan) {
                      if (!empty($keterangan)) {
                        echo '<div class="keterangan-item">• ' . esc($keterangan) . '</div>';
                      }
                    }
                  } else {
                    echo '<div class="text-center">-</div>';
                  }
                } else {
                  echo '<div class="text-center">-</div>';
                }
                ?>
              </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
    </div>

    <table width="100%" border="0" style="text-align: center; margin-top:3px">
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

    <?php if ($santri !== end($listSantris)): ?>
      <div class="page-break"></div>
    <?php endif; ?>

  <?php endforeach; ?>

</body>

</html>