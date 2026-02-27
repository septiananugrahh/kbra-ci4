<!DOCTYPE html>
<html>

<head>
  <title>Laporan Bulanan <?= esc($bulan) ?></title>
  <style>
    @page {
      margin-top: <?= $customSettings['margin_top'] ?? '0.5cm' ?>;
      margin-bottom: <?= $customSettings['margin_bottom'] ?? '0.9cm' ?>;
      margin-right: <?= $customSettings['margin_right'] ?? '0.9cm' ?>;
      margin-left: <?= $customSettings['margin_left'] ?? '3cm' ?>;
      size: 330mm 210mm;
    }

    .page:last-child {
      page-break-after: unset;
    }

    body {
      font-family: "Times New Roman", "DejaVu Sans", serif;
      font-size: <?= $customSettings['font_size'] ?? '9pt' ?>;
      line-height: <?= $customSettings['line_height'] ?? '1.1' ?>;
      margin: 0;
      padding: 0;
    }

    p {
      line-height: 0.9em;
      margin-top: 0.2em;
      margin-bottom: 0.2em;
      padding: 0;
      text-align: justify;
      color: #555;
    }

    h4 {
      line-height: 0.3em;
      margin: 0;
      padding: 0;
    }

    h2 {
      line-height: 0.5em;
      margin-top: 0.2em;
      margin-bottom: 0.2em;
      padding: 0;
      text-align: center;
      color: #333;
      font-size: <?= $customSettings['font_judul'] ?? '12pt' ?>;
    }

    .header-info {
      text-align: center;
      margin-bottom: 1px;
      margin-top: 2px;
    }

    .header-info td {
      padding: 1px 3px;
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

    .table-bulanan {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .table-bulanan th,
    .table-bulanan td {
      border: 1px solid black;
      padding: <?= $customSettings['cell_padding'] ?? '3px 5px' ?>;
      text-align: left;
      vertical-align: top;
    }

    .table-bulanan th {
      background-color: #f2f2f2;
      font-weight: bold;
      text-align: center;
      font-size: <?= $customSettings['font_judul'] ?? '12pt' ?>;
    }

    .keterangan-item {
      display: block;
      font-size: <?= $customSettings['font_size'] ?? '9pt' ?>;
      margin-bottom: <?= $customSettings['point_spacing'] ?? '1px' ?>;
      padding: 1px;
      line-height: <?= $customSettings['line_height'] ?? '1.1' ?>;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <?php
  $print_mode = $print_mode ?? 'all';
  $selected_santri_id = $selected_santri_id ?? null;
  foreach ($listSantris as $santri):
    if ($print_mode === 'single' && $santri['santri_id'] != $selected_santri_id) {
      continue;
    }
  ?>
    <center style="margin-bottom: 3px;">
      <h2 style="margin-bottom: 13px;">PENILAIAN BULANAN</h2>
      <h2 style="margin-bottom: 13px;"><?= esc($nama_tingkat) ?></h2>
      <h4 style="margin-top: 1px; font-size: <?= $customSettings['font_size'] ?? '9pt' ?>;">Tahun Pelajaran <?= esc($tahun) ?></h4>
    </center>
    <img src="<?= base_url('logo-200px.png') ?>" alt="" style="position:absolute; top:0px; width:50px;">
    <hr style="margin: 3px 0;">

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
              <th style="width: 33%; background-color: <?= htmlspecialchars($capaian_list_warna[$index]) ?>;">
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
                if (isset($laporan_data[$santri['id']])) {
                  $santri_data = $laporan_data[$santri['id']];
                  if (
                    isset($santri_data['capaian'][$id_capaian]) &&
                    is_array($santri_data['capaian'][$id_capaian]) &&
                    !empty($santri_data['capaian'][$id_capaian])
                  ) {
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