<!DOCTYPE html>
<html>

<head>
  <title>Laporan Checklist <?= esc($modul_ajar_id) ?></title>
  <style>
    /* Ukuran Tabel  */
    /* Tujuan Pembelajaran */
    .table-checklist td:nth-child(1),
    .table-checklist th:nth-child(1) {
      width: 25%;
    }

    /* Sudah Muncul */
    .table-checklist td:nth-child(2),
    .table-checklist th:nth-child(2) {
      width: 5%;
      text-align: center;
    }

    /* Konteks */
    .table-checklist td:nth-child(3),
    .table-checklist th:nth-child(3) {
      width: 20%;
    }

    /* Tempat Dan Waktu */
    .table-checklist td:nth-child(4),
    .table-checklist th:nth-child(4) {
      width: 10%;
    }

    /* Kejadian Teramati */
    .table-checklist td:nth-child(5),
    .table-checklist th:nth-child(5) {
      width: 40%;
    }

    @page {
      margin-top: 0.7cm;
      margin-bottom: 0.7cm;
      margin-right: 1cm;
      margin-left: 3cm;
      size: 330mm 210mm;
    }

    .page:last-child {
      page-break-after: unset;
    }

    body {
      font-family: "Times New Roman", "DejaVu Sans", serif;
      font-size: 10pt;
      line-height: 1.12;
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
      table-layout: fixed;
      /* TAMBAHKAN INI */
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
    <p style="text-align: center; color: #777;">Belum ada penilaian checklist untuk tanggal ini.</p>
  <?php else: ?>
    <?php foreach ($records as $record): ?>
      <?php
      // ===== TAMBAHKAN PENGECEKAN INI DI AWAL =====
      // Decode data status untuk pengecekan awal
      $statusData = json_decode($record['isi'], true);

      // Hitung apakah ada baris yang valid
      $dynamicRowspan = 0;
      if (!empty($statusData)) {
        foreach ($statusData as $statusItem) {
          foreach ($tujuan_pembelajaran as $item) {
            if ($item['tujuan_id'] == $statusItem['id']) {
              $dynamicRowspan++;
            }
          }
        }
      }

      // Skip santri ini jika tidak ada data penilaian
      if ($dynamicRowspan === 0) {
        continue; // Lanjut ke santri berikutnya
      }
      // ===== AKHIR PENGECEKAN =====
      ?>
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
        <table class="table-checklist" style="width:100%;">

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

                    $isKosong = empty($statusItem['status']);

                    $statusClass = $isKosong ? '' : (($statusItem['status'] === 'belum_muncul') ? '' : '✔️');


                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($item['tujuan_nama']) . "</td>";
                    echo "<td style='text-align:center'>" . $statusClass . "</td>";

                    // Tentukan warna text
                    $warnaText = $item['warna'] ?? 'black';
                    if ($statusItem['status'] === 'belum_muncul') {
                      $warnaText = 'black';
                    }

                    // ===============================
                    // ⛔ SKIP DATA JIKA STATUS KOSONG
                    // ===============================
                    if ($isKosong) {

                      echo "<td>-</td>"; // konteks
                      echo "<td>-</td>"; // tempat & waktu
                      echo "<td>-</td>"; // kejadian

                    } else {

                      // 1️⃣ Konteks
                      echo "<td style='color:black'>"
                        . htmlspecialchars($konteks_data[$kejadianIndex]['konteks'] ?? '-')
                        . "</td>";

                      // 2️⃣ Tempat & Waktu
                      echo "<td style='color:black'>"
                        . htmlspecialchars($tempat_waktu_data[$kejadianIndex]['tempat_waktu'] ?? '-')
                        . "</td>";

                      // 3️⃣ Kejadian
                      echo "<td style='color:{$warnaText}'>"
                        . htmlspecialchars($kejadian_data[$kejadianIndex]['kejadian'] ?? '-')
                        . "</td>";

                      // ✅ indeks hanya naik kalau data dipakai
                      $kejadianIndex++;
                    }

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