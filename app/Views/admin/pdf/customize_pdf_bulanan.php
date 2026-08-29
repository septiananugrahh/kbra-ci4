<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customize PDF - Laporan Bulanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

  <style>
    body {
      background: #f0f2f5;
    }

    .control-panel {
      position: sticky;
      top: 20px;
      height: calc(100vh - 40px);
      overflow-y: auto;
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-container {
      background: #e5e7eb;
      border-radius: 12px;
      padding: 30px 20px;
      min-height: calc(100vh - 40px);
      overflow-y: auto;
    }

    .preview-iframe-wrapper {
      background: white;
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      transform-origin: top center;
      transition: transform 0.3s ease;
      position: relative;
      border-radius: 8px;
      overflow: hidden;
    }

    #previewFrame {
      width: 100%;
      height: 700px;
      border: none;
      display: block;
      background: white;
    }

    .form-label {
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 14px;
      color: #374151;
    }

    .range-value {
      display: inline-block;
      min-width: 60px;
      text-align: right;
      font-weight: bold;
      color: #2563eb;
      font-size: 15px;
    }

    .btn-download {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      font-weight: 600;
      border-radius: 8px;
    }

    .reset-btn {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      font-weight: 600;
      border-radius: 8px;
    }

    .zoom-controls {
      text-align: center;
      margin-bottom: 20px;
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .zoom-controls button {
      margin: 0 8px;
      border-radius: 6px;
      padding: 8px 20px;
      font-weight: 600;
    }

    .preview-info {
      background: #fef3c7;
      border: 2px solid #fbbf24;
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: center;
      font-size: 14px;
      font-weight: 500;
    }

    .loading-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.95);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      border-radius: 8px;
    }

    .loading-content {
      text-align: center;
    }

    .spinner-border {
      width: 3.5rem;
      height: 3.5rem;
      border-width: 0.3em;
    }

    h4.mb-4 {
      color: #1f2937;
      font-weight: 700;
      font-size: 22px;
    }

    h6.text-primary {
      font-weight: 700;
      font-size: 15px;
      margin-top: 25px !important;
      margin-bottom: 15px !important;
      color: #2563eb !important;
    }

    .form-range {
      cursor: pointer;
    }

    .form-range::-webkit-slider-thumb {
      background: #2563eb;
      cursor: pointer;
    }

    .form-range::-moz-range-thumb {
      background: #2563eb;
      cursor: pointer;
    }

    /* ===== TABS ===== */
    .nav-tabs .nav-link {
      color: #6b7280;
      font-weight: 600;
      font-size: 14px;
      border: none;
      border-bottom: 3px solid transparent;
    }

    .nav-tabs .nav-link.active {
      color: #2563eb;
      border-bottom: 3px solid #2563eb;
      background: transparent;
    }

    /* ===== SETTING KOLOM ===== */
    .santri-select-wrapper {
      background: #f8fafc;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 15px;
    }

    .santri-badge-custom {
      font-size: 10px;
      padding: 2px 8px;
      border-radius: 10px;
      background: #dbeafe;
      color: #1d4ed8;
      font-weight: 600;
    }

    .santri-badge-default {
      font-size: 10px;
      padding: 2px 8px;
      border-radius: 10px;
      background: #f3f4f6;
      color: #6b7280;
      font-weight: 600;
    }

    .kolom-item {
      background: #f8fafc;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 10px 12px;
      margin-bottom: 10px;
    }

    .kolom-bar {
      display: flex;
      height: 58px;
      width: 100%;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      overflow: visible;
      background: #f8fafc;
      user-select: none;
    }

    .kolom-segment {
      position: relative;
      min-width: 0;
      padding: 8px 3px;
      color: #1e3a8a;
      background: #dbeafe;
      border-right: 1px solid #fff;
      text-align: center;
      font-size: 10px;
      font-weight: 600;
      overflow: visible;
    }

    .kolom-segment:nth-child(even) {
      background: #bfdbfe;
    }

    .kolom-handle {
      position: absolute;
      top: -1px;
      right: -5px;
      z-index: 2;
      width: 10px;
      height: 58px;
      cursor: col-resize;
      background: #2563eb;
      border: 2px solid #fff;
      border-radius: 5px;
    }

    .kolom-handle:hover,
    .kolom-handle.dragging {
      background: #1d4ed8;
    }

    .total-width-indicator {
      text-align: center;
      padding: 10px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 14px;
      margin-top: 10px;
      background: #dcfce7;
      color: #15803d;
      transition: all 0.2s ease;
    }

    .btn-reset-kolom {
      font-size: 12px;
      padding: 4px 10px;
    }

    @media (max-width: 991px) {
      .control-panel {
        position: relative !important;
        height: auto !important;
        margin-bottom: 20px;
      }

      .preview-container {
        min-height: auto;
      }

      #previewFrame {
        height: 600px;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid py-4">
    <div class="row">
      <!-- Control Panel -->
      <div class="col-md-4 col-lg-3">
        <div class="control-panel">
          <h4 class="mb-4"><i class="ri-settings-3-fill"></i> Pengaturan PDF</h4>

          <!-- Info mode -->
          <?php if ($print_mode === 'single'): ?>
            <div class="alert alert-info py-2 px-3 mb-3" style="font-size:13px;">
              <i class="ri-user-line"></i> <strong>Mode:</strong> Per Santri<br>
              <small><?= esc($santri_nama ?? '') ?></small>
            </div>
          <?php else: ?>
            <div class="alert alert-info py-2 px-3 mb-3" style="font-size:13px;">
              <i class="ri-group-line"></i> <strong>Mode:</strong> Semua Santri
            </div>
          <?php endif; ?>

          <!-- Action buttons -->
          <div class="d-flex align-items-center gap-1 mb-3">
            <a href="<?= $back_url ?>" class="btn btn-secondary reset-btn" title="Kembali">
              <i class="ri-arrow-left-line"></i>
            </a>
            <button type="button" class="btn btn-secondary reset-btn" id="resetBtn" title="Reset Kertas & Font">
              <i class="ri-reset-left-line"></i>
            </button>
            <button type="submit" form="pdfCustomForm" class="btn btn-primary btn-download" title="Download PDF">
              <i class="ri-download-2-line"></i>
            </button>
          </div>

          <!-- Tabs -->
          <ul class="nav nav-tabs mb-3" id="settingTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-kertas-btn" data-bs-toggle="tab" data-bs-target="#tab-kertas" type="button" role="tab">
                <i class="ri-file-paper-line"></i> Kertas
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-kolom-btn" data-bs-toggle="tab" data-bs-target="#tab-kolom" type="button" role="tab">
                <i class="ri-layout-column-line"></i> Kolom
              </button>
            </li>
          </ul>

          <form id="pdfCustomForm" method="POST"
            action="<?= base_url('laporan-bulanan/generate-pdf' . ($print_mode === 'single' ? '-santri' : '')) ?>">

            <input type="hidden" name="laporan_id" value="<?= $laporan_id ?>">
            <?php if ($print_mode === 'single'): ?>
              <input type="hidden" name="santri_id" value="<?= $santri_id ?? '' ?>">
            <?php endif; ?>
            <!-- ✅ JSON berisi lebar kolom per santri, format: {"santri_id": [w1,w2,...]} -->
            <input type="hidden" name="column_widths_json" id="columnWidthsJson" value="{}">

            <div class="tab-content" id="settingTabsContent">

              <!-- ============ TAB SETTING KERTAS ============ -->
              <div class="tab-pane fade show active" id="tab-kertas" role="tabpanel">

                <h6 class="text-primary">Margin (cm)</h6>

                <div class="mb-3">
                  <label class="form-label">Margin Atas: <span class="range-value" id="marginTopValue">0.5</span></label>
                  <input type="range" class="form-range" id="marginTop" min="0.3" max="5" step="0.1" value="0.5">
                  <input type="hidden" name="margin_top" id="marginTopInput" value="0.5cm">
                </div>

                <div class="mb-3">
                  <label class="form-label">Margin Bawah: <span class="range-value" id="marginBottomValue">0.9</span></label>
                  <input type="range" class="form-range" id="marginBottom" min="0.3" max="5" step="0.1" value="0.9">
                  <input type="hidden" name="margin_bottom" id="marginBottomInput" value="0.9cm">
                </div>

                <div class="mb-3">
                  <label class="form-label">Margin Kiri: <span class="range-value" id="marginLeftValue">3</span></label>
                  <input type="range" class="form-range" id="marginLeft" min="0.3" max="5" step="0.1" value="3">
                  <input type="hidden" name="margin_left" id="marginLeftInput" value="3cm">
                </div>

                <div class="mb-3">
                  <label class="form-label">Margin Kanan: <span class="range-value" id="marginRightValue">0.9</span></label>
                  <input type="range" class="form-range" id="marginRight" min="0.3" max="5" step="0.1" value="0.9">
                  <input type="hidden" name="margin_right" id="marginRightInput" value="0.9cm">
                </div>

                <h6 class="text-primary">Font</h6>

                <div class="mb-3">
                  <label class="form-label">Ukuran Font: <span class="range-value" id="fontSizeValue">11</span>pt</label>
                  <input type="range" class="form-range" id="fontSize" min="10" max="19" step="0.1" value="11">
                  <input type="hidden" name="font_size" id="fontSizeInput" value="11pt">
                </div>

                <div class="mb-3">
                  <label class="form-label">Ukuran Font Judul: <span class="range-value" id="fontJudulValue">12</span>pt</label>
                  <input type="range" class="form-range" id="fontJudul" min="8" max="18" step="1" value="12">
                  <input type="hidden" name="font_judul" id="fontJudulInput" value="12pt">
                </div>

                <h6 class="text-primary">Spasi</h6>

                <div class="mb-3">
                  <label class="form-label">Tinggi Baris: <span class="range-value" id="lineHeightValue">1.1</span></label>
                  <input type="range" class="form-range" id="lineHeight" min="1" max="2" step="0.05" value="1.1">
                  <input type="hidden" name="line_height" id="lineHeightInput" value="1.1">
                </div>

                <div class="mb-3">
                  <label class="form-label">Jarak Antar Poin: <span class="range-value" id="pointSpacingValue">1</span>px</label>
                  <input type="range" class="form-range" id="pointSpacing" min="0" max="15" step="1" value="1">
                  <input type="hidden" name="point_spacing" id="pointSpacingInput" value="1px">
                </div>

                <div class="mb-3">
                  <label class="form-label">Padding Cell: <span class="range-value" id="cellPaddingValue">3</span>px</label>
                  <input type="range" class="form-range" id="cellPadding" min="1" max="12" step="1" value="3">
                  <input type="hidden" name="cell_padding" id="cellPaddingInput" value="3px 5px">
                </div>

              </div>

              <!-- ============ TAB SETTING KOLOM ============ -->
              <div class="tab-pane fade" id="tab-kolom" role="tabpanel">

                <h6 class="text-primary">Pilih Santri</h6>
                <div class="santri-select-wrapper">
                  <select class="form-select form-select-sm" id="santriSelector">
                    <?php $no = 1;
                    foreach ($listSantris as $s):
                      $sid = $s['santri_id'] ?? $s['id'];
                      $sname = $s['santri_nama'] ?? $s['nama'];
                    ?>
                      <option value="<?= $sid ?>"><?= $no++ ?>. <?= esc($sname) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="mt-2">
                    <span id="santriStatusBadge" class="santri-badge-default">Default (equal split)</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-reset-kolom float-end" id="btnResetKolomSantri">
                      <i class="ri-refresh-line"></i> Reset ke Default
                    </button>
                  </div>
                </div>

                <h6 class="text-primary">Lebar Kolom (geser garis pemisah)</h6>
                <div id="kolomBar" class="kolom-bar"></div>

                <div class="total-width-indicator" id="totalWidthIndicator">
                  Total: 100%
                </div>

                <div class="alert alert-light border mt-3" style="font-size: 12px;">
                  <i class="ri-information-line"></i>
                  Geser garis pemisah. Hanya dua kolom di sebelahnya yang berubah.
                  Setting ini hanya berlaku sementara (tidak disimpan permanen).
                </div>

              </div>

            </div>
          </form>
        </div>
      </div>

      <!-- Preview Panel -->
      <div class="col-md-8 col-lg-9">
        <div class="preview-info">
          <strong>📄 Preview 100% Akurat:</strong> Preview ini menggunakan PDF yang sama dengan hasil download
          <span id="pageCountBadge" class="badge bg-primary ms-2" style="display: none;">
            📄 Menghitung...
          </span>
        </div>

        <!-- Zoom Controls -->
        <div class="zoom-controls">
          <button type="button" class="btn btn-sm btn-outline-secondary" onclick="zoomOut()">
            <strong>−</strong> Zoom Out
          </button>
          <span id="zoomLevel" class="mx-3"><strong>80%</strong></span>
          <button type="button" class="btn btn-sm btn-outline-secondary" onclick="zoomIn()">
            <strong>+</strong> Zoom In
          </button>
        </div>

        <div class="preview-container">
          <div class="preview-iframe-wrapper" id="previewWrapper" style="transform: scale(0.8); transform-origin: top center;">
            <div class="loading-overlay" id="loadingOverlay">
              <div class="loading-content">
                <div class="spinner-border text-primary mb-3" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-primary mb-0"><strong>Generating PDF Preview...</strong></p>
                <p class="text-muted small">Mohon tunggu 2-5 detik</p>
              </div>
            </div>
            <iframe id="previewFrame" src="about:blank"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const LAPORAN_ID = '<?= $laporan_id ?>';
    const SANTRI_ID = '<?= $santri_id ?? '' ?>';
    const PRINT_MODE = '<?= $print_mode ?>';
    const PREVIEW_URL = '<?= base_url('laporan-bulanan/preview-pdf-direct' . ($print_mode === 'single' ? '-santri' : '')) ?>';

    // ✅ Daftar santri (untuk dropdown "Setting Kolom") — hanya label, bukan data tabel
    const SANTRI_LIST = <?= json_encode(array_map(function ($s) {
                          return [
                            'id' => $s['santri_id'] ?? $s['id'],
                            'nama' => $s['santri_nama'] ?? $s['nama'],
                          ];
                        }, $listSantris)) ?>;

    // ✅ Nama kolom capaian (dinamis, sejumlah $capaian_list)
    const CAPAIAN_LIST = <?= json_encode($capaian_list) ?>;
    const CAPAIAN_COUNT = CAPAIAN_LIST.length;
    const MIN_WIDTH = 5; // batas minimum persen per kolom, supaya tidak hilang jadi 0

    const defaults = {
      marginTop: 0.5,
      marginBottom: 0.9,
      marginLeft: 3,
      marginRight: 0.9,
      fontSize: 11,
      fontJudul: 12,
      lineHeight: 1.1,
      pointSpacing: 1,
      cellPadding: 3
    };

    let currentZoom = 0.8;

    function zoomIn() {
      if (currentZoom < 1.2) {
        currentZoom = Math.round((currentZoom + 0.1) * 10) / 10;
        updateZoom();
      }
    }

    function zoomOut() {
      if (currentZoom > 0.4) {
        currentZoom = Math.round((currentZoom - 0.1) * 10) / 10;
        updateZoom();
      }
    }

    function updateZoom() {
      document.getElementById('previewWrapper').style.transform = `scale(${currentZoom})`;
      document.getElementById('previewWrapper').style.transformOrigin = 'top center';
      document.getElementById('zoomLevel').innerHTML = `<strong>${Math.round(currentZoom * 100)}%</strong>`;
    }

    let updateTimeout;
    let currentPdfUrl = null;

    function updatePreview() {
      clearTimeout(updateTimeout);

      const loadingOverlay = document.getElementById('loadingOverlay');
      const pageCountBadge = document.getElementById('pageCountBadge');

      if (loadingOverlay) loadingOverlay.style.display = 'flex';
      if (pageCountBadge) {
        pageCountBadge.innerHTML = '⏳ Menghitung...';
        pageCountBadge.style.display = 'inline-block';
      }

      updateTimeout = setTimeout(() => {
        const formData = new FormData();
        formData.append('laporan_id', LAPORAN_ID);
        if (PRINT_MODE === 'single') formData.append('santri_id', SANTRI_ID);
        formData.append('margin_top', document.getElementById('marginTopInput').value);
        formData.append('margin_bottom', document.getElementById('marginBottomInput').value);
        formData.append('margin_left', document.getElementById('marginLeftInput').value);
        formData.append('margin_right', document.getElementById('marginRightInput').value);
        formData.append('font_size', document.getElementById('fontSizeInput').value);
        formData.append('font_judul', document.getElementById('fontJudulInput').value);
        formData.append('line_height', document.getElementById('lineHeightInput').value);
        formData.append('point_spacing', document.getElementById('pointSpacingInput').value);
        formData.append('cell_padding', document.getElementById('cellPaddingInput').value);
        formData.append('column_widths_json', document.getElementById('columnWidthsJson').value);

        fetch(PREVIEW_URL, {
            method: 'POST',
            body: formData
          })
          .then(response => {
            const totalPages = response.headers.get('X-Total-Pages');
            if (totalPages && pageCountBadge) {
              pageCountBadge.innerHTML = `📄 ${totalPages} Halaman`;
            }
            return response.blob();
          })
          .then(blob => {
            if (currentPdfUrl) URL.revokeObjectURL(currentPdfUrl);
            currentPdfUrl = URL.createObjectURL(blob);
            const iframe = document.getElementById('previewFrame');
            iframe.src = currentPdfUrl;
            iframe.onload = function() {
              setTimeout(() => {
                if (loadingOverlay) loadingOverlay.style.display = 'none';
              }, 500);
            };
          })
          .catch(error => {
            console.error('Error:', error);
            if (loadingOverlay) loadingOverlay.style.display = 'none';
          });
      }, 600);
    }

    window.addEventListener('beforeunload', function() {
      if (currentPdfUrl) URL.revokeObjectURL(currentPdfUrl);
    });

    // ===================== TAB SETTING KERTAS =====================
    const ranges = [{
        id: 'marginTop',
        valueId: 'marginTopValue',
        inputId: 'marginTopInput',
        suffix: 'cm'
      },
      {
        id: 'marginBottom',
        valueId: 'marginBottomValue',
        inputId: 'marginBottomInput',
        suffix: 'cm'
      },
      {
        id: 'marginLeft',
        valueId: 'marginLeftValue',
        inputId: 'marginLeftInput',
        suffix: 'cm'
      },
      {
        id: 'marginRight',
        valueId: 'marginRightValue',
        inputId: 'marginRightInput',
        suffix: 'cm'
      },
      {
        id: 'fontSize',
        valueId: 'fontSizeValue',
        inputId: 'fontSizeInput',
        suffix: 'pt'
      },
      {
        id: 'fontJudul',
        valueId: 'fontJudulValue',
        inputId: 'fontJudulInput',
        suffix: 'pt'
      },
      {
        id: 'lineHeight',
        valueId: 'lineHeightValue',
        inputId: 'lineHeightInput',
        suffix: ''
      },
      {
        id: 'pointSpacing',
        valueId: 'pointSpacingValue',
        inputId: 'pointSpacingInput',
        suffix: 'px'
      },
      {
        id: 'cellPadding',
        valueId: 'cellPaddingValue',
        inputId: 'cellPaddingInput',
        suffix: 'px 5px'
      }
    ];

    ranges.forEach(range => {
      const element = document.getElementById(range.id);
      const valueDisplay = document.getElementById(range.valueId);
      const hiddenInput = document.getElementById(range.inputId);

      element.addEventListener('input', function() {
        valueDisplay.textContent = this.value;
        hiddenInput.value = this.value + range.suffix;
        updatePreview();
      });
    });

    document.getElementById('resetBtn').addEventListener('click', function() {
      document.getElementById('marginTop').value = defaults.marginTop;
      document.getElementById('marginBottom').value = defaults.marginBottom;
      document.getElementById('marginLeft').value = defaults.marginLeft;
      document.getElementById('marginRight').value = defaults.marginRight;
      document.getElementById('fontSize').value = defaults.fontSize;
      document.getElementById('fontJudul').value = defaults.fontJudul;
      document.getElementById('lineHeight').value = defaults.lineHeight;
      document.getElementById('pointSpacing').value = defaults.pointSpacing;
      document.getElementById('cellPadding').value = defaults.cellPadding;

      ranges.forEach(range => {
        document.getElementById(range.id).dispatchEvent(new Event('input'));
      });
    });

    // ===================== TAB SETTING KOLOM =====================

    // Menyimpan setting kolom per santri: { santri_id: [w1, w2, ...] }
    // Santri yang belum ada di sini pakai default (equal split)
    let columnSettings = {};

    function defaultWidths() {
      if (CAPAIAN_COUNT === 0) return [];
      const equal = Math.floor((100 / CAPAIAN_COUNT) * 10) / 10;
      const widths = new Array(CAPAIAN_COUNT).fill(equal);
      // koreksi pembulatan supaya total tetap 100
      const total = widths.reduce((a, b) => a + b, 0);
      widths[widths.length - 1] += Math.round((100 - total) * 10) / 10;
      return widths;
    }

    function getCurrentSantriId() {
      return document.getElementById('santriSelector').value;
    }

    function getWidthsForSantri(santriId) {
      return columnSettings[santriId] ? [...columnSettings[santriId]] : defaultWidths();
    }

    let activeDrag = null;

    function renderKolomBar() {
      const santriId = getCurrentSantriId();
      const widths = getWidthsForSantri(santriId);
      const bar = document.getElementById('kolomBar');
      bar.innerHTML = '';

      CAPAIAN_LIST.forEach((nama, idx) => {
        const segment = document.createElement('div');
        segment.className = 'kolom-segment';
        segment.style.width = `${widths[idx]}%`;
        segment.innerHTML = `<span title="${nama}">${nama}<br>${widths[idx].toFixed(1)}%</span>`;
        if (idx < CAPAIAN_COUNT - 1) {
          const handle = document.createElement('div');
          handle.className = 'kolom-handle';
          handle.dataset.index = idx;
          handle.addEventListener('pointerdown', startDrag);
          segment.appendChild(handle);
        }
        bar.appendChild(segment);
      });
      updateStatusBadge(santriId);
      updateTotalIndicator(widths);
    }

    function startDrag(event) {
      event.preventDefault();
      const handle = event.currentTarget;
      activeDrag = {
        santriId: getCurrentSantriId(),
        index: Number(handle.dataset.index),
        startX: event.clientX,
        widths: getWidthsForSantri(getCurrentSantriId())
      };
      handle.classList.add('dragging');
      handle.setPointerCapture(event.pointerId);
      handle.addEventListener('pointermove', onDrag);
      handle.addEventListener('pointerup', endDrag, {
        once: true
      });
      handle.addEventListener('pointercancel', endDrag, {
        once: true
      });
    }

    function onDrag(event) {
      if (!activeDrag) return;
      const bar = document.getElementById('kolomBar');
      const delta = (event.clientX - activeDrag.startX) / bar.getBoundingClientRect().width * 100;
      const left = activeDrag.index;
      const right = left + 1;
      const pairTotal = activeDrag.widths[left] + activeDrag.widths[right];
      const nextLeft = Math.max(MIN_WIDTH, Math.min(pairTotal - MIN_WIDTH, activeDrag.widths[left] + delta));
      const widths = [...activeDrag.widths];
      widths[left] = Math.round(nextLeft * 10) / 10;
      widths[right] = Math.round((pairTotal - widths[left]) * 10) / 10;
      columnSettings[activeDrag.santriId] = widths;

      // Update lebar langsung di DOM — jangan rebuild, nanti pointer capture & listener handle hilang
      bar.querySelectorAll('.kolom-segment').forEach((seg, i) => {
        seg.style.width = widths[i] + '%';
        const span = seg.querySelector('span');
        if (span) span.innerHTML = `${CAPAIAN_LIST[i]}<br>${widths[i].toFixed(1)}%`;
      });
      updateTotalIndicator(widths);
    }

    function endDrag(event) {
      if (!activeDrag) return;
      activeDrag = null;
      if (event.currentTarget) event.currentTarget.classList.remove('dragging');
      syncColumnWidthsJson();
      updatePreview();
    }

    function updateStatusBadge(santriId) {
      const badge = document.getElementById('santriStatusBadge');
      if (columnSettings[santriId]) {
        badge.textContent = 'Sudah dikustom';
        badge.className = 'santri-badge-custom';
      } else {
        badge.textContent = 'Default (equal split)';
        badge.className = 'santri-badge-default';
      }
    }

    function updateTotalIndicator(widths) {
      const total = Math.round(widths.reduce((a, b) => a + b, 0) * 10) / 10;
      const el = document.getElementById('totalWidthIndicator');
      el.textContent = `Total: ${total}%`;
      el.style.background = Math.abs(total - 100) < 0.5 ? '#dcfce7' : '#fee2e2';
      el.style.color = Math.abs(total - 100) < 0.5 ? '#15803d' : '#b91c1c';
    }

    function syncColumnWidthsJson() {
      document.getElementById('columnWidthsJson').value = JSON.stringify(columnSettings);
    }

    document.getElementById('santriSelector').addEventListener('change', function() {
      renderKolomBar();
    });

    document.getElementById('btnResetKolomSantri').addEventListener('click', function() {
      const santriId = getCurrentSantriId();
      delete columnSettings[santriId];
      renderKolomBar();
      syncColumnWidthsJson();
      updatePreview();
    });

    // Inisialisasi sliders kolom saat halaman load (kalau ada santri)
    if (SANTRI_LIST.length > 0 && CAPAIAN_COUNT > 0) {
      renderKolomBar();
    }

    window.addEventListener('load', function() {
      updatePreview();
    });
  </script>
</body>

</html>