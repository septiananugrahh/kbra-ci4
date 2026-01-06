<!DOCTYPE html>
<html>

<head>
  <title>Laporan Checklist <?= esc($modul_ajar_id) ?></title>
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
    /* .belum-muncul {
      background-color: #ffcccc;
      
    }

    .sudah-muncul {
      background-color: #c8e6c9;
      
    } */
  </style>
</head>

<body>


  <?php if (empty($records)): ?>
    <p style="text-align: center; color: #777;">Belum ada penilaian anekdot untuk tanggal ini.</p>
  <?php else: ?>
    <?php foreach ($records as $record): ?>
      <center>
        <h2>CHECKLIST PENILAIAN</h2>
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
            <td>Semester/Pekan</td>
            <td>:</td>
            <td></strong> <?= esc($semester) ?> / <?= esc($record['pekan']) ?></td>
          </tr>

          <tr>
            <td>Hari/Tanggal</td>
            <td>:</td>
            <td></strong> <?= str_replace(",", " /", esc($record['tanggal_value'])); ?></td>
          </tr>
        </table>
      </div>

      <div class="record-card">
        <table class="table-checklist">
          <thead>
            <tr>
              <td>Tujuan Pembelajaran</td>
              <td>Sudah Muncul</td>
              <td>Konteks</td>
              <td>Tempat dan Waktu</td>
              <td>Kejadian Yang Teramati</td>
            </tr>
          </thead>

          <tbody>
            <?php
            // Asumsikan $record, $tujuan_pembelajaran sudah terdefinisi dari scope yang lebih tinggi.

            // Decode data status JSON untuk seluruh record
            $statusData = json_decode($record['isi'], true);

            // Decode JSON kejadian untuk seluruh record, jika ada
            $kejadian_data = [];
            $konteks_data = [];
            $tempat_waktu_data = [];
            if (!empty($record['kejadian'])) {
              $kejadian_data = json_decode($record['kejadian'], true);
              $konteks_data = json_decode($record['konteks'], true);
              $tempat_waktu_data = json_decode($record['tempat_waktu'], true);
              // Pastikan $kejadian_data adalah array, jika gagal decode, set ke array kosong
              if (!is_array($kejadian_data)) {
                $kejadian_data = [];
                $konteks_data = [];
                $tempat_waktu_data = [];
              }
            }

            // --- LANGKAH 1: Hitung total baris yang akan ditampilkan untuk record ini ---
            $dynamicRowspan = 0;
            if (!empty($statusData)) {
              foreach ($statusData as $statusItem) {
                foreach ($tujuan_pembelajaran as $item) {
                  // Hanya hitung jika kombinasi $statusItem dan $item akan menghasilkan baris
                  if ($item['tujuan_id'] == $statusItem['id']) {
                    $dynamicRowspan++;
                  }
                }
              }
            }

            // Cek apakah ada baris yang perlu ditampilkan. Jika tidak, tampilkan pesan "Data status kosong."
            if ($dynamicRowspan === 0) {
              echo "<tr><td colspan='5'>Data status kosong atau tidak ada kecocokan.</td></tr>";
            } else {
              $firstRowPrintedForRecord = false; // Flag untuk memastikan kolom rowspan dicetak hanya sekali per $record
              $kejadianIndex = 0; // Inisialisasi indeks untuk mengakses $kejadian_data

              // Loop utama untuk mencetak baris
              foreach ($statusData as $statusItem) {
                foreach ($tujuan_pembelajaran as $item) {
                  if ($item['tujuan_id'] == $statusItem['id']) {
                    // Item ini akan dicetak
                    $statusClass = ($statusItem['status'] == 'belum_muncul') ? '' : '✔️';

                    echo "<tr>";
                    echo "<td style='width:35%'>" . htmlspecialchars($item['tujuan_nama']) . "</td>";
                    echo "<td style='width:10%; text-align:center'>" . $statusClass . "</td>";

                    // Cetak kolom dengan rowspan hanya pada baris pertama dari record ini
                    // if (!$firstRowPrintedForRecord) {
                    //   echo "<td rowspan='" . $dynamicRowspan . "' style='vertical-align: middle;'>" . htmlspecialchars($record['konteks']) . "</td>";
                    //   echo "<td rowspan='" . $dynamicRowspan . "' style='vertical-align: middle;'>" . htmlspecialchars($record['tempat_waktu']) . "</td>";
                    //   $firstRowPrintedForRecord = true; // Set flag menjadi true setelah dicetak
                    // }

                    if (isset($konteks_data[$kejadianIndex]) && isset($konteks_data[$kejadianIndex]['konteks'])) {
                      echo "<td style='color: {$item['warna']}'>" . htmlspecialchars($konteks_data[$kejadianIndex]['konteks']) . "</td>";
                    } else {
                      echo "<td>-</td>";
                    }

                    if (isset($tempat_waktu_data[$kejadianIndex]) && isset($tempat_waktu_data[$kejadianIndex]['tempat_waktu'])) {
                      echo "<td style='color: {$item['warna']}'>" . htmlspecialchars($tempat_waktu_data[$kejadianIndex]['tempat_waktu']) . "</td>";
                    } else {
                      echo "<td>-</td>";
                    }

                    // Tampilkan kejadian berdasarkan kejadianIndex
                    if (isset($kejadian_data[$kejadianIndex]) && isset($kejadian_data[$kejadianIndex]['kejadian'])) {
                      echo "<td style='color: {$item['warna']}'>" . htmlspecialchars($kejadian_data[$kejadianIndex]['kejadian']) . "</td>";
                    } else {
                      echo "<td>-</td>";
                    }

                    $kejadianIndex++; // Tingkatkan indeks untuk kejadian berikutnya
                    echo "</tr>";
                  }
                }
              }
            }
            ?>
          </tbody>

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

        <div style="margin-top: 10px;">
          <?php echo implode("\n", $capaian_list); ?>
        </div>
        <!-- legend detail -->


        <table width="100%" border="0" style="text-align: center; margin-top:5px">
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