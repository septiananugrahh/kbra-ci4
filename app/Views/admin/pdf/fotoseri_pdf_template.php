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
      height: 140px;
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
  </style>
</head>

<body>


  <?php if (empty($records)): ?>
    <p style="text-align: center; color: #777;">Belum ada penilaian foto berseri untuk tanggal ini.</p>
  <?php else: ?>
    <?php foreach ($records as $record): ?>
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
            <td></strong> <?= esc($record['topik_pembelajaran']) ?> /<?= esc($record['matched_topik_value']) ?> </td>
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
              <td> Bagian 1 </td>
            <?php endif; ?>
            <?php if (!empty($record['foto2'])): ?>
              <td> Bagian 2 </td>
            <?php endif; ?>
            <?php if (!empty($record['foto3'])): ?>
              <td> Bagian 3 </td>
            <?php endif; ?>
          </tr>
          <tr>
            <?php if (!empty($record['foto1'])): ?>
              <td>
                <table>
                  <tr>
                    <td style="border: 0px;">
                      <img src="<?= base_url('uploads/penilaian/' . $record['foto1']) ?>" alt="Foto 1">
                    </td>
                    <td style="border: 0px;padding-left:20px;">
                      <div class="photo-caption"><?= esc($record['ket_foto1']) ?: 'Tanpa Keterangan' ?></div>
                    </td>
                  </tr>
                </table>
              </td>
            <?php endif; ?>
            <?php if (!empty($record['foto2'])): ?>
              <td>
                <table>
                  <tr>
                    <td style="border: 0px;">
                      <img src="<?= base_url('uploads/penilaian/' . $record['foto2']) ?>" alt="Foto 2">
                    </td>
                    <td style="border: 0px;padding-left:20px;">
                      <div class="photo-caption"><?= esc($record['ket_foto2']) ?: 'Tanpa Keterangan' ?></div>
                    </td>
                  </tr>
                </table>
              </td>
            <?php endif; ?>
            <?php if (!empty($record['foto3'])): ?>
              <td>
                <table>
                  <tr>
                    <td style="border: 0px;">
                      <img src="<?= base_url('uploads/penilaian/' . $record['foto3']) ?>" alt="Foto 3">
                    </td>
                    <td style="border: 0px;padding-left:20px;">
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
            <td>Analisis Guru</td>
            <td>:</td>
            <td>
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
            <td>Umpan Balik</td>
            <td>:</td>
            <td><?= nl2br(esc($record['umpan_balik'])) ?></td>
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