<!DOCTYPE html>
<html>

<head>
  <title>Laporan Foto Berseri Modul</title>
  <style>
    @page {
      margin-top: 0.7cm;
      margin-bottom: 2cm;
      margin-right: 1cm;
      margin-left: 3cm;
      size: 330mm 210mm;
      /* F4 */
      margin: 10mm;
    }

    .page:last-child {
      page-break-after: unset;
    }

    body {
      font-family: "Times New Roman", "DejaVu Sans", serif;
      font-size: 8pt;
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

    .header-info table {
      font-size: 7pt;
      margin-bottom: 5px;
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
      width: auto;
      height: 100px;
      max-width: 120px;
      object-fit: contain;
      display: block;
      margin-left: auto;
      /* Ubah dari margin: 0 auto ke margin-left: auto untuk rata kanan */
      margin-right: 0;
      border: 1px solid #ddd;
      padding: 2px;
      background-color: #fff;
    }

    .photo-caption {
      font-size: 7pt;
      color: #555;
      margin: 0;
      padding-left: 10px;
      word-wrap: break-word;
      vertical-align: top;
      text-align: left;
      /* Pastikan teks rata kiri */
    }


    .photo-cell {
      padding: 5px !important;
      width: 33.33%;
      /* Tambahkan ini agar setiap kolom sama besar (100%/3) */
    }

    .inner-table {
      border: 0 !important;
      margin: 0;
      padding: 0;
      width: 100%;
    }

    .inner-table td {
      border: 0 !important;
      padding: 3px !important;
      vertical-align: top;
    }

    .inner-table td:first-child {
      text-align: right;
      /* Gambar rata kanan */
      width: 120px;
    }

    .inner-table td:last-child {
      text-align: left;
      /* Teks rata kiri */
    }

    .photo-wrapper {
      text-align: center;
      margin-bottom: 10px;
    }



    .section-title {
      margin-top: 25px;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    .photo-table {
      width: 100%;
      /* Pastikan tabel mengisi lebar yang tersedia */
      border-collapse: collapse;
      /* Ini sangat penting untuk border tunggal */
      margin-bottom: 20px;
      /* Jarak bawah tabel */
    }

    .photo-table th,
    .photo-table td {
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
    .photo-table th {
      background-color: #f2f2f2;
      /* Warna latar belakang header */
      font-weight: bold;
    }


    .header-info td {
      padding: 1px 3px;
    }

    /* Kecilkan section title */
    .section-title {
      margin-top: 10px;
      font-size: 8pt;
      padding-bottom: 3px;
      margin-bottom: 5px;
    }

    /* Kecilkan record card */
    .record-card {
      padding: 2px;
      margin-bottom: 10px;
    }

    .record-card table {
      font-size: 7pt;
      margin-bottom: 8px;
    }

    .record-card td {
      padding: 2px 3px;
    }

    /* Kecilkan legend */
    .record-card>div:last-of-type {
      margin-top: 10px;
      font-size: 7pt;
    }
  </style>
</head>

<body>


  <?php if (empty($records)): ?>
    <p style="text-align: center; color: #777;">Belum ada penilaian foto berseri untuk tanggal ini.</p>
  <?php else: ?>
    <?php foreach ($records as $record): ?>
      <?php
      // ===== TAMBAHKAN PENGECEKAN INI DI AWAL =====
      // Cek apakah santri memiliki minimal 1 foto
      $hasFoto = !empty($record['foto1']) || !empty($record['foto2']) || !empty($record['foto3']);

      // Skip santri ini jika tidak ada foto sama sekali
      if (!$hasFoto) {
        continue; // Lanjut ke santri berikutnya
      }
      // ===== AKHIR PENGECEKAN =====
      ?>
      <center>
        <h2>PENILAIAN FOTO BERSERI</h2>
        <h2><?= esc($nama_tingkat) ?></h2>
        <h4>Tahun Pelajaran <?= esc($tahun) ?></h4>
      </center>
      <img src="<?= base_url('logo-200px.png') ?>" alt="" style="position:absolute; top:0px; width:70px;">

      <hr>

      <div class="header-info">
        <table>
          <tr>
            <td>Nama Santri</td>
            <td>:</td>
            <td><?= esc($record['santri_nama']) ?></td>
          </tr>

          <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?= esc($record['kelas_tingkat']) ?> <?= esc($record['kelas_nama']) ?></td>
          </tr>

          <tr>
            <td>Hari/Tanggal</td>
            <td>:</td>
            <td></strong> <?= esc($record['tanggal']) ?></td>
          </tr>

          <tr>
            <td>Topik/SubTopik</td>
            <td>:</td>
            <td></strong> <?= esc($record['topik_pembelajaran']) ?> /<?= esc($record['subtopik_pembelajaran']) ?> </td>
          </tr>

          <tr>
            <td>Semester/Pekan</td>
            <td>:</td>
            <td></strong> <?= esc($semester) ?> / <?= esc($record['pekan']) ?></td>
          </tr>
        </table>
      </div>

      <div class="record-card">
        <table class="photo-table">
          <tr>
            <?php if (!empty($record['foto1'])): ?>
              <th style="font-size: 7pt; padding: 3px; width: 33.33%;">Bagian 1</th>
            <?php endif; ?>
            <?php if (!empty($record['foto2'])): ?>
              <th style="font-size: 7pt; padding: 3px; width: 33.33%;">Bagian 2</th>
            <?php endif; ?>
            <?php if (!empty($record['foto3'])): ?>
              <th style="font-size: 7pt; padding: 3px; width: 33.33%;">Bagian 3</th>
            <?php endif; ?>
          </tr>
          <tr>
            <?php if (!empty($record['foto1'])): ?>
              <td class="photo-cell">
                <table class="inner-table">
                  <tr>
                    <td style="width: 160px; text-align: right;">
                      <img src="<?= FCPATH . 'uploads/penilaian/' . $record['foto1'] ?>" alt="Foto 1">
                    </td>
                    <td style="text-align: left;">
                      <div class="photo-caption"><?= esc($record['ket_foto1']) ?: 'Tanpa Keterangan' ?></div>
                    </td>
                  </tr>
                </table>
              </td>
            <?php endif; ?>

            <?php if (!empty($record['foto2'])): ?>
              <td class="photo-cell">
                <table class="inner-table">
                  <tr>
                    <td style="width: 120px; text-align: right;">
                      <img src="<?= FCPATH . 'uploads/penilaian/' . $record['foto2'] ?>" alt="Foto 2">
                    </td>
                    <td style="text-align: left;">
                      <div class="photo-caption"><?= esc($record['ket_foto2']) ?: 'Tanpa Keterangan' ?></div>
                    </td>
                  </tr>
                </table>
              </td>
            <?php endif; ?>

            <?php if (!empty($record['foto3'])): ?>
              <td class="photo-cell">
                <table class="inner-table">
                  <tr>
                    <td style="width: 120px; text-align: right;">
                      <img src="<?= FCPATH . 'uploads/penilaian/' . $record['foto3'] ?>" alt="Foto 3">
                    </td>
                    <td style="text-align: left;">
                      <div class="photo-caption"><?= esc($record['ket_foto3']) ?: 'Tanpa Keterangan' ?></div>
                    </td>
                  </tr>
                </table>
              </td>
            <?php endif; ?>
          </tr>
        </table>


        <table>
          <tr>
            <td style="vertical-align: top;">Analisis Guru</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;">
              <?php
              // Menyusun array warna berdasarkan capaian
              $capaianWarna = [];
              foreach ($capaian_pembelajaran as $capaian) {
                $capaianWarna[$capaian['id']] = $capaian['warna']; // Menyimpan warna berdasarkan id_capaian
              }

              // Memastikan analisis guru ada dan valid
              if (!empty($record['analisis_guru'])) {
                // Dekode data JSON menjadi array PHP
                $analisisData = json_decode($record['analisis_guru'], true);

                // Periksa apakah JSON terdekode dengan benar
                if (json_last_error() === JSON_ERROR_NONE) {
                  // Debugging: Menampilkan data JSON yang telah terdekode
                  // echo '<pre>';
                  // print_r($analisisData);
                  // echo '</pre>';

                  // Menggunakan array_map() untuk menggabungkan data analisis dengan warna
                  $analisisData = array_map(function ($analisis) use ($capaianWarna) {
                    $idCapaian = $analisis['id_capaian'];

                    // Cari warna berdasarkan id_capaian
                    $analisis['warna'] = isset($capaianWarna[$idCapaian]) ? $capaianWarna[$idCapaian] : '#000000'; // Warna default
                    return $analisis;
                  }, $analisisData);

                  // Debugging: Menampilkan analisisData setelah warna digabungkan
                  // echo '<pre>';
                  // print_r($analisisData);
                  // echo '</pre>';

                  // Format output HTML
                  $kalimat = '';
                  foreach ($analisisData as $analisis) {
                    // Pastikan output aman dari XSS
                    $analisisText = htmlspecialchars($analisis['analisis']);
                    $kalimat .= "<span style='color: {$analisis['warna']}'>{$analisisText}. </span> ";
                  }

                  // Tampilkan hasil
                  echo nl2br($kalimat); // Untuk memformat newlines jika ada
                } else {
                  echo "Data analisis tidak valid (JSON parsing error).";
                }
              } else {
                echo "Data analisis kosong.";
              }
              ?>



            </td>
          </tr>

          <tr>
            <td style="vertical-align: top;">Umpan Balik</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><?= nl2br(esc($record['umpan_balik'])) ?></td>
          </tr>
        </table>


        <!-- legend detail -->
        <?php
        // Misalkan $capaian_pembelajaran sudah ada
        $capaian_list = [];
        foreach ($capaian_pembelajaran as $item) {
          $capaian_list[] = '
    <span style="
        border: 1px solid #eee;
        padding: 3px 6px;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-right: 15px;
        margin-bottom: 10px;
        display: inline-block; /* Penting untuk vertical-align dan margin */
    ">
        <span style="
            background-color: ' . htmlspecialchars($item['warna']) . ';
            width: 13px;
            height: 13px;
            border-radius: 4px;
            display: inline-block; /* Penting untuk vertical-align */
            vertical-align: middle; /* Sejajarkan vertikal di tengah */
            margin-right: 8px; /* Beri jarak antara kotak warna dan teks */
        "></span>
        <span style="
            color: #333;
            font-size: 8px;
            display: inline-block; /* Penting untuk vertical-align */
            vertical-align: middle; /* Sejajarkan vertikal di tengah */
        ">' . htmlspecialchars($item['nama']) . '</span>
    </span>';
        }
        ?>

        <div style="margin-top: 20px;">
          <?php echo implode("\n", $capaian_list); ?>
        </div>
        <!-- legend detail -->



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



    <?php endforeach; ?>
  <?php endif; ?>