<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customize PDF - Modul Ajar</title>
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
      max-width: 900px;
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
      height: 1200px;
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

    /* Responsive */
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
        height: 1000px;
      }
    }

    @media (min-width: 992px) {
      .col-lg-3 {
        flex: 0 0 25%;
        max-width: 25%;
      }

      .col-lg-9 {
        flex: 0 0 75%;
        max-width: 75%;
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
          <h4 class="mb-4"> <i class="ri-settings-3-fill"></i> Pengaturan PDF</h4>

          <form id="pdfCustomForm" method="POST" action="<?= base_url('modulajar/generate-pdf') ?>">


            <input type="hidden" name="modul_id" value="<?= $modul_ajar_id ?>">
            <div class="d-flex align-items-center gap-1">
              <a href="<?= base_url('modulajar') ?>"
                class="btn btn-secondary reset-btn"
                data-bs-toggle="tooltip"
                title="Kembali">
                <i class="ri-arrow-left-line"></i>
              </a>

              <button type="button"
                class="btn btn-secondary reset-btn"
                id="resetBtn"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Reset">
                <i class="ri-reset-left-line"></i>
              </button>

              <button type="submit"
                class="btn btn-primary btn-download"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Download">
                <i class="ri-download-2-line"></i>
              </button>
            </div>

            <hr class="my-4">
            <!-- Margin Settings -->
            <h6 class="text-primary">Margin (cm)</h6>

            <div class="mb-3">
              <label class="form-label">Margin Atas: <span class="range-value" id="marginTopValue">1</span></label>
              <input type="range" class="form-range" name="margin_top_val" id="marginTop"
                min="0.5" max="5" step="0.1" value="1">
              <input type="hidden" name="margin_top" id="marginTopInput" value="1cm">
            </div>

            <div class="mb-3">
              <label class="form-label">Margin Bawah: <span class="range-value" id="marginBottomValue">1</span></label>
              <input type="range" class="form-range" name="margin_bottom_val" id="marginBottom"
                min="0.5" max="5" step="0.1" value="1">
              <input type="hidden" name="margin_bottom" id="marginBottomInput" value="1cm">
            </div>

            <div class="mb-3">
              <label class="form-label">Margin Kiri: <span class="range-value" id="marginLeftValue">3</span></label>
              <input type="range" class="form-range" name="margin_left_val" id="marginLeft"
                min="0.5" max="5" step="0.1" value="3">
              <input type="hidden" name="margin_left" id="marginLeftInput" value="3cm">
            </div>

            <div class="mb-3">
              <label class="form-label">Margin Kanan: <span class="range-value" id="marginRightValue">1</span></label>
              <input type="range" class="form-range" name="margin_right_val" id="marginRight"
                min="0.5" max="5" step="0.1" value="1">
              <input type="hidden" name="margin_right" id="marginRightInput" value="1cm">
            </div>

            <!-- Font Settings -->
            <h6 class="text-primary">Font</h6>

            <div class="mb-3">
              <label class="form-label">Ukuran Font: <span class="range-value" id="fontSizeValue">10</span>pt</label>
              <input type="range" class="form-range" name="font_size_val" id="fontSize"
                min="8" max="16" step="1" value="10">
              <input type="hidden" name="font_size" id="fontSizeInput" value="10pt">
            </div>

            <div class="mb-3">
              <label class="form-label">Ukuran Font Judul: <span class="range-value" id="fontJudulValue">14</span>px</label>
              <input type="range" class="form-range" name="font_judul_val" id="fontJudul"
                min="10" max="20" step="1" value="14">
              <input type="hidden" name="font_judul" id="fontJudulInput" value="14px">
            </div>

            <!-- Spacing Settings -->
            <h6 class="text-primary">Spasi</h6>

            <div class="mb-3">
              <label class="form-label">Tinggi Baris: <span class="range-value" id="lineHeightValue">1.08</span></label>
              <input type="range" class="form-range" name="line_height_val" id="lineHeight"
                min="1" max="2" step="0.01" value="1.08">
              <input type="hidden" name="line_height" id="lineHeightInput" value="1.08">
            </div>

            <div class="mb-3">
              <label class="form-label">Jarak Antar Poin: <span class="range-value" id="pointSpacingValue">5</span>px</label>
              <input type="range" class="form-range" name="point_spacing_val" id="pointSpacing"
                min="0" max="20" step="1" value="5">
              <input type="hidden" name="point_spacing" id="pointSpacingInput" value="5px">
            </div>

            <!-- Action Buttons -->

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
          <span id="zoomLevel" class="mx-3"><strong>90%</strong></span>
          <button type="button" class="btn btn-sm btn-outline-secondary" onclick="zoomIn()">
            <strong>+</strong> Zoom In
          </button>
        </div>

        <div class="preview-container">
          <div class="preview-iframe-wrapper" id="previewWrapper" style="transform: scale(0.9);">
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
    const defaults = {
      marginTop: 1,
      marginBottom: 1,
      marginLeft: 3,
      marginRight: 1,
      fontSize: 10,
      fontJudul: 14,
      lineHeight: 1.08,
      pointSpacing: 5
    };

    // Zoom functionality - Start at 90%
    let currentZoom = 0.9;

    function zoomIn() {
      if (currentZoom < 1.2) {
        currentZoom += 0.1;
        updateZoom();
      }
    }

    function zoomOut() {
      if (currentZoom > 0.5) {
        currentZoom -= 0.1;
        updateZoom();
      }
    }

    function updateZoom() {
      document.getElementById('previewWrapper').style.transform = `scale(${currentZoom})`;
      document.getElementById('zoomLevel').innerHTML = `<strong>${Math.round(currentZoom * 100)}%</strong>`;
    }

    // Update preview - Render PDF langsung
    let updateTimeout;
    let currentPdfUrl = null;

    function updatePreview() {
      clearTimeout(updateTimeout);

      const loadingOverlay = document.getElementById('loadingOverlay');
      const pageCountBadge = document.getElementById('pageCountBadge');

      if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
      }

      if (pageCountBadge) {
        pageCountBadge.innerHTML = '⏳ Menghitung...';
        pageCountBadge.style.display = 'inline-block';
      }

      updateTimeout = setTimeout(() => {
        const formData = new FormData();
        formData.append('modul_id', '<?= $modul_ajar_id ?>');
        formData.append('margin_top', document.getElementById('marginTopInput').value);
        formData.append('margin_bottom', document.getElementById('marginBottomInput').value);
        formData.append('margin_left', document.getElementById('marginLeftInput').value);
        formData.append('margin_right', document.getElementById('marginRightInput').value);
        formData.append('font_size', document.getElementById('fontSizeInput').value);
        formData.append('font_judul', document.getElementById('fontJudulInput').value);
        formData.append('line_height', document.getElementById('lineHeightInput').value);
        formData.append('point_spacing', document.getElementById('pointSpacingInput').value);

        fetch('<?= base_url('modulajar/render/preview-pdf-direct') ?>', {
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
            if (currentPdfUrl) {
              URL.revokeObjectURL(currentPdfUrl);
            }

            currentPdfUrl = URL.createObjectURL(blob);
            const iframe = document.getElementById('previewFrame');
            iframe.src = currentPdfUrl;

            iframe.onload = function() {
              setTimeout(() => {
                if (loadingOverlay) {
                  loadingOverlay.style.display = 'none';
                }
              }, 500);
            };
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
            if (loadingOverlay) {
              loadingOverlay.style.display = 'none';
            }
          });
      }, 500);
    }

    window.addEventListener('beforeunload', function() {
      if (currentPdfUrl) {
        URL.revokeObjectURL(currentPdfUrl);
      }
    });

    // Range input handlers
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
        suffix: 'px'
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

    // Reset button
    document.getElementById('resetBtn').addEventListener('click', function() {
      document.getElementById('marginTop').value = defaults.marginTop;
      document.getElementById('marginBottom').value = defaults.marginBottom;
      document.getElementById('marginLeft').value = defaults.marginLeft;
      document.getElementById('marginRight').value = defaults.marginRight;
      document.getElementById('fontSize').value = defaults.fontSize;
      document.getElementById('fontJudul').value = defaults.fontJudul;
      document.getElementById('lineHeight').value = defaults.lineHeight;
      document.getElementById('pointSpacing').value = defaults.pointSpacing;

      ranges.forEach(range => {
        document.getElementById(range.id).dispatchEvent(new Event('input'));
      });
    });

    // Initial load
    window.addEventListener('load', function() {
      updatePreview();
    });
  </script>
</body>

</html>