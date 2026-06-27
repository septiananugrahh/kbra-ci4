<style>
  .card {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: none;
  }

  .card-body {
    padding: 2rem;
  }

  /* ========================================
     HEADER
  ======================================== */
  .penilaian-header {
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    color: #4a5568;
  }

  .penilaian-header h3 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 1.4rem;
  }

  .penilaian-header p {
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
  }

  .penilaian-header strong {
    color: #2d3748;
    min-width: 70px;
  }

  .header-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
  }

  /* ========================================
     DOWNLOAD BUTTON
  ======================================== */
  .btn-download-main {
    background: rgba(255, 255, 255, 0.8);
    border: 1.5px solid rgba(255, 255, 255, 0.9);
    color: #4a5568;
    padding: 0.5rem 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    white-space: nowrap;
    transition: all 0.2s ease;
    font-size: 0.875rem;
  }

  .btn-download-main:hover {
    background: white;
    color: #2d3748;
  }

  .download-dropdown .dropdown-menu {
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    padding: 0.5rem;
    min-width: 220px;
  }

  .download-dropdown .dropdown-item {
    border-radius: 0.375rem;
    padding: 0.625rem 0.875rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
  }

  .download-dropdown .dropdown-item:hover {
    background-color: #eef2ff;
    color: #667eea;
  }

  .dropdown-divider-label {
    padding: 0.375rem 0.875rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #a0aec0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .download-type-icon {
    width: 26px;
    height: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    color: #4a5568;
    border-radius: 5px;
    flex-shrink: 0;
  }

  /* ========================================
     SANTRI SELECTOR
  ======================================== */
  .santri-selector {
    background: white;
    padding: 1.25rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    border: 2px solid #e2e8f0;
  }

  .santri-selector label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .santri-custom-input {
    position: relative;
    cursor: pointer;
  }

  .santri-custom-input .form-control {
    cursor: pointer;
    background-color: #fff;
    padding-right: 40px;
    border: 1.5px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
  }

  .santri-custom-input .clear-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #dc3545;
    display: none;
    z-index: 10;
  }

  .santri-custom-input.has-value .clear-btn {
    display: block;
  }

  /* ========================================
     ASESMEN TABS
  ======================================== */
  .asesmen-tabs-wrapper {
    margin-bottom: 1.5rem;
  }

  .asesmen-tabs {
    display: flex;
    gap: 0.5rem;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0;
    overflow-x: auto;
    scrollbar-width: none;
  }

  .asesmen-tabs::-webkit-scrollbar {
    display: none;
  }

  .asesmen-tab-btn {
    padding: 0.625rem 1.25rem;
    border: none;
    background: transparent;
    color: #718096;
    font-weight: 600;
    font-size: 0.875rem;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    border-radius: 0.375rem 0.375rem 0 0;
  }

  .asesmen-tab-btn:hover {
    color: #667eea;
    background: #f7fafc;
  }

  .asesmen-tab-btn.active {
    color: #667eea;
    border-bottom-color: #667eea;
    background: #f0f4ff;
  }

  .asesmen-tab-content {
    display: none;
  }

  .asesmen-tab-content.active {
    display: block;
  }

  /* ========================================
     TANGGAL SELECTOR PER TAB
  ======================================== */
  .tanggal-selector-bar {
    background: #f7fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .tanggal-selector-bar label {
    font-weight: 600;
    color: #4a5568;
    font-size: 0.875rem;
    white-space: nowrap;
    margin-bottom: 0;
  }

  .tanggal-selector-bar select {
    border: 1.5px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    color: #2d3748;
    flex: 1;
    min-width: 200px;
    transition: all 0.2s ease;
  }

  .tanggal-selector-bar select:focus {
    border-color: #b8c5f5;
    box-shadow: 0 0 0 3px rgba(184, 197, 245, 0.1);
    outline: none;
  }

  /* ========================================
     FORM ELEMENTS (sama seperti sebelumnya)
  ======================================== */
  .divider {
    margin: 2rem 0 1.5rem;
    position: relative;
  }

  .divider-text {
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    color: #2d3748;
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 2px 8px rgba(184, 197, 245, 0.3);
  }

  .form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .form-control,
  .form-select {
    border: 1.5px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #b8c5f5;
    box-shadow: 0 0 0 3px rgba(184, 197, 245, 0.1);
  }

  textarea.form-control {
    min-height: 100px;
    resize: vertical;
  }

  .checklist-item {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.2s ease;
  }

  .checklist-item:hover {
    border-color: #cbd5e0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .checklist-item h6 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f7fafc;
  }

  .form-check-inline {
    margin-right: 1.5rem;
  }

  .form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #cbd5e0;
  }

  .form-check-input:checked {
    background-color: #a8d5ba;
    border-color: #a8d5ba;
  }

  .form-check-label {
    margin-left: 0.5rem;
    color: #4a5568;
    font-weight: 500;
  }

  .capaian-wrapper {
    background: #f7fafc;
    border-left: 4px solid #b8c5f5;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
  }

  .capaian-wrapper .form-label {
    color: #2d3748;
    font-size: 1rem;
  }

  .image-upload-wrapper {
    background: #f7fafc;
    border: 2px dashed #cbd5e0;
    border-radius: 0.5rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .image-upload-wrapper:hover {
    border-color: #b8c5f5;
    background: #edf2f7;
  }

  .image-upload {
    display: none;
  }

  .upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    color: #718096;
  }

  .upload-label i {
    font-size: 2rem;
    color: #b8c5f5;
  }

  .preview-image {
    max-height: 200px;
    border-radius: 0.5rem;
    margin-top: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .preview-container {
    position: relative;
    display: inline-block;
    margin-top: 1rem;
  }

  .preview-container .preview-image {
    margin-top: 0;
  }

  .remove-preview-btn {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #ef4444;
    color: white;
    border: 2px solid white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }

  .remove-preview-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
  }

  .foto-series-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .foto-item {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1.5rem;
  }

  .foto-item h6 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f7fafc;
  }

  /* ========================================
     FLOATING ACTION BAR
  ======================================== */
  .form-floating-action-bar {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    z-index: 1030;
  }

  .form-floating-action-bar .btn {
    min-width: 60px;
    height: 60px;
    border-radius: 50%;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    padding: 0;
  }

  .form-floating-action-bar .btn i {
    font-size: 1.5rem;
  }

  .form-floating-action-bar .btn-success {
    background: linear-gradient(135deg, #a8d5ba 0%, #81c784 100%);
    color: white;
    width: 70px;
    height: 70px;
  }

  .form-floating-action-bar .btn-success:active {
    transform: scale(0.95);
  }

  #goToTopBtn {
    background: linear-gradient(135deg, #b8c5f5 0%, #8b9dc3 100%);
    color: white;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }

  #goToTopBtn.show {
    opacity: 1;
    visibility: visible;
  }

  #goToTopBtn:hover {
    transform: scale(1.1) translateY(-5px);
  }

  .auto-save-indicator {
    position: fixed;
    bottom: 110px;
    right: 20px;
    background: white;
    padding: 0.75rem 1rem;
    border-radius: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: none;
    align-items: center;
    gap: 0.5rem;
    z-index: 1025;
  }

  .auto-save-indicator.saving {
    display: flex;
    color: #8b9dc3;
  }

  .auto-save-indicator.success {
    display: flex;
    color: #81c784;
  }

  .auto-save-indicator.error {
    display: flex;
    color: #ef4444;
  }

  .auto-save-indicator .spinner-border {
    width: 1rem;
    height: 1rem;
    border-width: 2px;
  }

  .fab-wrapper {
    display: flex;
    justify-content: right;
  }

  /* ========================================
     MODAL SANTRI
  ======================================== */
  #modalPilihSantri {
    z-index: 1100;
  }

  .santri-list-item {
    cursor: pointer;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
    padding: 1rem;
  }

  .santri-list-item:hover {
    background-color: #f8f9fa;
    border-left-color: #28a745;
    transform: translateX(5px);
  }

  .santri-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #81c784 0%, #66bb6a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
    margin-right: 1rem;
    flex-shrink: 0;
  }

  .santri-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
  }

  .santri-badge {
    background-color: #e9ecef;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    color: #6c757d;
  }

  .modal-backdrop.show {
    z-index: 1095;
  }

  /* ========================================
     MOBILE
  ======================================== */
  @media (max-width: 768px) {
    .card-body {
      padding: 1rem;
    }

    .penilaian-header {
      padding: 1rem;
    }

    .penilaian-header h3 {
      font-size: 1.1rem;
    }

    .header-top {
      flex-direction: column;
    }

    .btn-download-main {
      width: 100%;
      text-align: center;
      justify-content: center;
      display: flex;
    }

    .asesmen-tab-btn {
      padding: 0.5rem 0.875rem;
      font-size: 0.8rem;
    }

    .tanggal-selector-bar {
      flex-direction: column;
      align-items: stretch;
    }

    .tanggal-selector-bar select {
      min-width: unset;
    }

    .form-floating-action-bar {
      bottom: 80px;
      right: 15px;
    }

    .form-floating-action-bar .btn-success {
      width: 60px;
      height: 60px;
    }

    .card-body {
      padding-bottom: 100px;
    }

    .foto-series-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (min-width: 768px) {
    .form-floating-action-bar .btn-success:hover {
      border-radius: 2rem;
      width: auto;
      padding: 0 1.5rem;
    }

    .form-floating-action-bar .btn-success:hover::after {
      content: " Simpan";
      margin-left: 0.5rem;
      font-size: 1rem;
    }

    #goToTopBtn:hover {
      border-radius: 2rem;
      width: auto;
      padding: 0 1.2rem;
    }

    #goToTopBtn:hover::after {
      content: " Ke Atas";
      margin-left: 0.5rem;
      font-size: 1rem;
    }
  }
</style>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <!-- Header -->
        <div class="penilaian-header">
          <div class="header-top">
            <div>
              <h3><i class="ri-file-list-3-line me-2"></i>Asesmen Pembelajaran</h3>
              <p>
                <strong><i class="ri-book-2-line me-1"></i>Topik:</strong>
                <span><?= esc($modul['topik_pembelajaran']) ?></span>
              </p>
              <p>
                <strong><i class="ri-bookmark-line me-1"></i>Subtopik:</strong>
                <span><?= esc($modul['subtopik_pembelajaran']) ?></span>
              </p>
            </div>

            <!-- Tombol Download -->
            <div class="download-dropdown dropdown">
              <button class="btn btn-download-main dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-download-cloud-line me-2"></i>Download
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <div class="dropdown-divider-label">Download Semua</div>
                </li>
                <?php foreach (['checklist' => ['ri-checkbox-multiple-line', 'Checklist'], 'fotoseri' => ['ri-image-line', 'Foto Berseri'], 'hastakarya' => ['ri-palette-line', 'Hasil Karya'], 'anekdot' => ['ri-chat-quote-line', 'Anekdot']] as $jenis => $info): ?>
                  <li>
                    <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul['id'] . '/0/' . $jenis) ?>">
                      <span class="download-type-icon"><i class="<?= $info[0] ?>"></i></span>
                      <?= $info[1] ?> — Semua
                    </a>
                  </li>
                <?php endforeach; ?>

                <?php if (!empty($tanggalList)): ?>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <div class="dropdown-divider-label">Download Per Tanggal</div>
                  </li>
                  <?php foreach ($tanggalList as $tgl): ?>
                    <?php foreach (['checklist' => ['ri-checkbox-multiple-line', 'Checklist'], 'fotoseri' => ['ri-image-line', 'Foto Berseri'], 'hastakarya' => ['ri-palette-line', 'Hasil Karya'], 'anekdot' => ['ri-chat-quote-line', 'Anekdot']] as $jenis => $info): ?>
                      <li>
                        <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul['id'] . '/' . $tgl['index'] . '/' . $jenis) ?>">
                          <span class="download-type-icon"><i class="<?= $info[0] ?>"></i></span>
                          <?= $info[1] ?> — <?= esc($tgl['tanggal']) ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                    <?php if (!($tgl === end($tanggalList))): ?>
                      <li>
                        <hr class="dropdown-divider my-1">
                      </li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>

        <!-- Pilih Santri -->
        <div class="santri-selector">
          <label><i class="ri-user-search-line"></i> Pilih Santri</label>
          <div class="santri-custom-input">
            <input type="text" id="santri_display" class="form-control" readonly placeholder="Klik untuk memilih santri">
            <span class="clear-btn"><i class="ri-close-circle-fill"></i></span>
            <input type="hidden" id="santri_id" name="santri_id">
          </div>
        </div>

        <!-- Tab Jenis Asesmen -->
        <div class="asesmen-tabs-wrapper">
          <div class="asesmen-tabs">
            <button class="asesmen-tab-btn active" data-tab="checklist">
              <i class="ri-checkbox-line"></i> Checklist
            </button>
            <button class="asesmen-tab-btn" data-tab="hasilkarya">
              <i class="ri-palette-line"></i> Hasil Karya
            </button>
            <button class="asesmen-tab-btn" data-tab="fotoberseri">
              <i class="ri-gallery-line"></i> Foto Berseri
            </button>
            <button class="asesmen-tab-btn" data-tab="anekdot">
              <i class="ri-chat-quote-line"></i> Anekdot
            </button>
          </div>
        </div>

        <!-- Form Container (tersembunyi sampai santri dipilih) -->
        <div id="form-penilaian" style="display: none;">

          <!-- ===================== TAB CHECKLIST ===================== -->
          <div class="asesmen-tab-content active" id="tab-checklist">
            <form action="<?= site_url('asesmen/simpan') ?>" method="post" enctype="multipart/form-data" id="form-checklist">
              <input type="hidden" name="modul_ajar_id" value="<?= esc($modul['id']) ?>">
              <input type="hidden" name="santri_id" id="hidden_santri_id_checklist">

              <!-- Pilih Tanggal -->
              <div class="tanggal-selector-bar">
                <label><i class="ri-calendar-line me-1"></i>Tanggal Asesmen:</label>
                <select name="tanggal" id="tanggal_checklist" class="form-select">
                  <?php foreach ($tanggalList as $tgl): ?>
                    <option value="<?= esc($tgl['tanggal']) ?>"><?= esc($tgl['tanggal']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div id="penilaian-checklist-container"></div>

              <button type="submit" class="d-none" id="btn-submit-checklist"></button>
            </form>
          </div>

          <!-- ===================== TAB HASIL KARYA ===================== -->
          <div class="asesmen-tab-content" id="tab-hasilkarya">
            <form action="<?= site_url('asesmen/simpan') ?>" method="post" enctype="multipart/form-data" id="form-hasilkarya">
              <input type="hidden" name="modul_ajar_id" value="<?= esc($modul['id']) ?>">
              <input type="hidden" name="santri_id" id="hidden_santri_id_hasilkarya">

              <!-- Pilih Tanggal -->
              <div class="tanggal-selector-bar">
                <label><i class="ri-calendar-line me-1"></i>Tanggal Asesmen:</label>
                <select name="tanggal" id="tanggal_hasilkarya" class="form-select">
                  <?php foreach ($tanggalList as $tgl): ?>
                    <option value="<?= esc($tgl['tanggal']) ?>"><?= esc($tgl['tanggal']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="kegiatan_hasil_karya" class="form-label"><i class="ri-file-text-line me-1"></i>Kegiatan</label>
                <input type="text" name="kegiatan_hasil_karya" id="kegiatan_hasil_karya" class="form-control" placeholder="Masukkan nama kegiatan">
              </div>

              <div class="mb-3">
                <label class="form-label"><i class="ri-image-add-line me-1"></i>Upload Foto Hasil Karya</label>
                <div class="image-upload-wrapper">
                  <label for="foto_hasil_karya_input" class="upload-label">
                    <i class="ri-upload-cloud-2-line"></i>
                    <span>Klik untuk upload foto</span>
                    <small>Format: JPG, PNG (Max: 9MB)</small>
                  </label>
                  <input type="file" name="foto_hasil_karya" id="foto_hasil_karya_input" class="image-upload" accept="image/*">
                </div>
                <div class="preview-container" id="preview_container_hk" style="display:none;">
                  <img src="" class="preview-image" id="thumb_hk">
                  <button type="button" class="remove-preview-btn" onclick="removePreview('foto_hasil_karya_input', 'thumb_hk', 'preview_container_hk')">
                    <i class="ri-close-line"></i>
                  </button>
                </div>
              </div>

              <?php foreach ($capaianPembelajaran as $capaian): ?>
                <div class="capaian-wrapper">
                  <label class="form-label"><i class="ri-edit-line me-1"></i>Catatan: <?= esc($capaian['nama']) ?></label>
                  <input type="hidden" name="hasil_karya_catatan[<?= $capaian['id'] ?>][id_capaian]" value="<?= $capaian['id'] ?>">
                  <textarea name="hasil_karya_catatan[<?= $capaian['id'] ?>][catatan]" id="hasil_karya_catatan_<?= $capaian['id'] ?>" class="form-control" rows="2" placeholder="Tulis catatan..."></textarea>
                </div>
              <?php endforeach; ?>

              <button type="submit" class="d-none" id="btn-submit-hasilkarya"></button>
            </form>
          </div>

          <!-- ===================== TAB FOTO BERSERI ===================== -->
          <div class="asesmen-tab-content" id="tab-fotoberseri">
            <form action="<?= site_url('asesmen/simpan') ?>" method="post" enctype="multipart/form-data" id="form-fotoberseri">
              <input type="hidden" name="modul_ajar_id" value="<?= esc($modul['id']) ?>">
              <input type="hidden" name="santri_id" id="hidden_santri_id_fotoberseri">

              <!-- Pilih Tanggal -->
              <div class="tanggal-selector-bar">
                <label><i class="ri-calendar-line me-1"></i>Tanggal Asesmen:</label>
                <select name="tanggal" id="tanggal_fotoberseri" class="form-select">
                  <?php foreach ($tanggalList as $tgl): ?>
                    <option value="<?= esc($tgl['tanggal']) ?>"><?= esc($tgl['tanggal']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="foto-series-grid">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                  <div class="foto-item">
                    <h6><i class="ri-image-line me-2"></i>Foto <?= $i ?></h6>
                    <div class="mb-3">
                      <div class="image-upload-wrapper">
                        <label for="foto_<?= $i ?>_input" class="upload-label">
                          <i class="ri-upload-cloud-2-line"></i>
                          <span>Upload Foto <?= $i ?></span>
                        </label>
                        <input type="file" name="foto_<?= $i ?>" id="foto_<?= $i ?>_input" class="image-upload" accept="image/*">
                      </div>
                      <div class="preview-container" id="preview_container_<?= $i ?>" style="display:none;">
                        <img src="" class="preview-image" id="thumb_<?= $i ?>">
                        <button type="button" class="remove-preview-btn" onclick="removePreview('foto_<?= $i ?>_input', 'thumb_<?= $i ?>', 'preview_container_<?= $i ?>')">
                          <i class="ri-close-line"></i>
                        </button>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="foto_ket<?= $i ?>" class="form-label">Keterangan</label>
                      <textarea name="foto_ket<?= $i ?>" id="foto_ket<?= $i ?>" class="form-control" rows="3" placeholder="Tulis keterangan foto..."></textarea>
                    </div>
                  </div>
                <?php endfor; ?>
              </div>

              <?php foreach ($capaianPembelajaran as $capaian): ?>
                <div class="capaian-wrapper">
                  <label class="form-label"><i class="ri-edit-line me-1"></i>Analisis: <?= esc($capaian['nama']) ?></label>
                  <input type="hidden" name="foto_analisis[<?= $capaian['id'] ?>][id_capaian]" value="<?= $capaian['id'] ?>">
                  <textarea name="foto_analisis[<?= $capaian['id'] ?>][analisis]" id="foto_analisis_<?= $capaian['id'] ?>" class="form-control" rows="2" placeholder="Tulis analisis..."></textarea>
                </div>
              <?php endforeach; ?>

              <div class="mb-3">
                <label for="foto_umpan_balik" class="form-label"><i class="ri-feedback-line me-1"></i>Umpan Balik</label>
                <textarea name="foto_umpan_balik" id="foto_umpan_balik" class="form-control" rows="3" placeholder="Tulis umpan balik..."></textarea>
              </div>

              <button type="submit" class="d-none" id="btn-submit-fotoberseri"></button>
            </form>
          </div>

          <!-- ===================== TAB ANEKDOT ===================== -->
          <div class="asesmen-tab-content" id="tab-anekdot">
            <form action="<?= site_url('asesmen/simpan') ?>" method="post" enctype="multipart/form-data" id="form-anekdot">
              <input type="hidden" name="modul_ajar_id" value="<?= esc($modul['id']) ?>">
              <input type="hidden" name="santri_id" id="hidden_santri_id_anekdot">

              <!-- Pilih Tanggal -->
              <div class="tanggal-selector-bar">
                <label><i class="ri-calendar-line me-1"></i>Tanggal Asesmen:</label>
                <select name="tanggal" id="tanggal_anekdot" class="form-select">
                  <?php foreach ($tanggalList as $tgl): ?>
                    <option value="<?= esc($tgl['tanggal']) ?>"><?= esc($tgl['tanggal']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="anekdot_tempat" class="form-label"><i class="ri-map-pin-line me-1"></i>Tempat</label>
                <input type="text" name="anekdot_tempat" id="anekdot_tempat" class="form-control" placeholder="Masukkan tempat kejadian">
              </div>

              <div class="mb-3">
                <label for="anekdot_peristiwa" class="form-label"><i class="ri-file-text-line me-1"></i>Peristiwa</label>
                <textarea name="anekdot_peristiwa" id="anekdot_peristiwa" class="form-control" rows="4" placeholder="Ceritakan peristiwa..."></textarea>
              </div>

              <?php foreach ($capaianPembelajaran as $capaian): ?>
                <div class="capaian-wrapper">
                  <label class="form-label"><i class="ri-edit-line me-1"></i>Keterangan: <?= esc($capaian['nama']) ?></label>
                  <input type="hidden" name="anekdot_keterangan[<?= $capaian['id'] ?>][id_capaian]" value="<?= $capaian['id'] ?>">
                  <textarea name="anekdot_keterangan[<?= $capaian['id'] ?>][keterangan]" id="anekdot_keterangan_<?= $capaian['id'] ?>" class="form-control" rows="2" placeholder="Tulis keterangan..."></textarea>
                </div>
              <?php endforeach; ?>

              <button type="submit" class="d-none" id="btn-submit-anekdot"></button>
            </form>
          </div>

          <!-- Floating Action Bar -->
          <div class="form-floating-action-bar">
            <div class="fab-wrapper">
              <button type="button" class="btn" id="goToTopBtn" title="Ke Atas">
                <i class="ri-arrow-up-line"></i>
              </button>
            </div>
            <div class="fab-wrapper">
              <button type="button" class="btn btn-success" id="btnSimpanFloating" title="Simpan Penilaian">
                <i class="ri-save-line"></i>
              </button>
            </div>
          </div>

          <!-- Auto Save Indicator -->
          <div class="auto-save-indicator" id="autoSaveIndicator">
            <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
            <span id="autoSaveText">Menyimpan...</span>
          </div>

          <!-- Kembali -->
          <div class="mt-4 pt-2">
            <a href="<?= site_url('modul_ajar') ?>" class="btn btn-secondary">
              <i class="ri-arrow-left-line me-1"></i>Kembali
            </a>
          </div>

        </div><!-- end #form-penilaian -->

      </div>
    </div>
  </div>
</div>

<!-- Modal Pilih Santri -->
<div class="modal fade" id="modalPilihSantri" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="ri-user-search-line"></i> Pilih Santri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="ri-search-line"></i></span>
            <input type="text" id="searchSantriInput" class="form-control" placeholder="Cari nama santri...">
          </div>
        </div>
        <div id="santriListContainer" class="list-group" style="max-height: 450px; overflow-y: auto;"></div>
        <div id="santriNoResults" class="alert alert-info text-center" style="display: none;">
          <i class="ri-user-unfollow-line"></i> Tidak ada santri ditemukan
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-line"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  const tujuanPembelajaranData = <?= json_encode($tujuan_pembelajaran_detail) ?>;
  const TANGGAL_LIST = <?= json_encode($tanggalList) ?>;
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  const CONFIG = {
    baseUrl: '<?= base_url() ?>',
    uploadPath: '<?= base_url('uploads/penilaian/') ?>',
    endpoints: {
      getData: 'asesmen/getData',
      simpan: 'asesmen/simpan'
    },
    maxImageSize: 9 * 1024 * 1024,
    allowedImageTypes: ['image/jpeg', 'image/jpg', 'image/png']
  };

  const SANTRI_DATA = <?= json_encode($santriList) ?>;

  // Tanggal default = index 0 (terkecil)
  const DEFAULT_TANGGAL = TANGGAL_LIST.length > 0 ? TANGGAL_LIST[0].tanggal : '';

  // State tanggal per tab (dipertahankan saat ganti santri)
  const tabTanggal = {
    checklist: DEFAULT_TANGGAL,
    hasilkarya: DEFAULT_TANGGAL,
    fotoberseri: DEFAULT_TANGGAL,
    anekdot: DEFAULT_TANGGAL
  };

  let activeTab = 'checklist';

  // =====================================================
  // UTILS
  // =====================================================
  const Utils = {
    safeJsonParse(data, fallback = []) {
      if (!data || data === 'null' || (typeof data === 'string' && data.trim() === '')) return fallback;
      try {
        let parsed = typeof data === 'string' ? JSON.parse(data) : data;
        if (typeof parsed === 'string') parsed = JSON.parse(parsed);
        return Array.isArray(parsed) ? parsed : (parsed ? [parsed] : fallback);
      } catch (e) {
        return fallback;
      }
    },
    validateImage(file) {
      if (!file) return {
        valid: false,
        message: 'Tidak ada file dipilih'
      };
      if (!CONFIG.allowedImageTypes.includes(file.type)) return {
        valid: false,
        message: 'Format file harus JPG atau PNG'
      };
      if (file.size > CONFIG.maxImageSize) return {
        valid: false,
        message: 'Ukuran file maksimal 9MB'
      };
      return {
        valid: true
      };
    },
    showLoading(title = 'Memuat...', text = 'Mohon tunggu') {
      Swal.fire({
        title,
        html: text,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });
    },
    closeLoading() {
      Swal.close();
    },
    showSuccess(msg) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: msg,
        timer: 2000,
        showConfirmButton: false
      });
    },
    showError(msg) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: msg
      });
    }
  };

  // =====================================================
  // TAB MANAGER
  // =====================================================
  const TabManager = {
    init() {
      document.querySelectorAll('.asesmen-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => this.switchTab(btn.dataset.tab));
      });

      // Simpan tanggal saat diubah
      ['checklist', 'hasilkarya', 'fotoberseri', 'anekdot'].forEach(tab => {
        const sel = document.getElementById('tanggal_' + tab);
        if (sel) sel.addEventListener('change', () => {
          tabTanggal[tab] = sel.value;
        });
      });
    },

    switchTab(tabName) {
      activeTab = tabName;

      document.querySelectorAll('.asesmen-tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.asesmen-tab-content').forEach(c => c.classList.remove('active'));

      document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
      document.getElementById('tab-' + tabName).classList.add('active');
    }
  };

  // =====================================================
  // SANTRI MODAL MANAGER
  // =====================================================
  const SantriModalManager = {
    allData: [],
    filteredData: [],

    init() {
      this.allData = SANTRI_DATA.sort((a, b) => a.nama.localeCompare(b.nama, 'id'));
      this.filteredData = this.allData;
      this.bindEvents();
    },

    show() {
      $('#modalPilihSantri').modal('show');
      this.renderList();
      setTimeout(() => $('#searchSantriInput').focus(), 300);
    },

    renderList() {
      const $container = $('#santriListContainer');
      $container.empty();

      if (this.filteredData.length === 0) {
        $('#santriNoResults').show();
        return;
      }
      $('#santriNoResults').hide();

      this.filteredData.forEach(santri => {
        const initial = santri.nama.charAt(0).toUpperCase();
        $container.append(`
        <a href="#" class="list-group-item list-group-item-action santri-list-item" data-id="${santri.id}" data-nama="${santri.nama}">
          <div class="d-flex align-items-center">
            <div class="santri-avatar">${initial}</div>
            <div>
              <div class="santri-name">${santri.nama}</div>
              ${santri.kelas ? `<span class="santri-badge">Kelas: ${santri.kelas}</span>` : ''}
            </div>
          </div>
        </a>
      `);
      });
    },

    search(query) {
      const q = query.toLowerCase().trim();
      this.filteredData = q ? this.allData.filter(s => s.nama.toLowerCase().includes(q)) : this.allData;
      this.renderList();
    },

    selectSantri(id, nama) {
      $('#santri_display').val(nama);
      $('#santri_id').val(id);
      $('.santri-custom-input').addClass('has-value');
      $('#modalPilihSantri').modal('hide');
      $('#santri_id').trigger('change');
    },

    clearSelection() {
      $('#santri_display').val('');
      $('#santri_id').val('');
      $('.santri-custom-input').removeClass('has-value');
      $('#santri_id').trigger('change');
    },

    bindEvents() {
      $('#searchSantriInput').on('input', e => this.search(e.target.value));
      $(document).on('click', '.santri-list-item', e => {
        e.preventDefault();
        const $item = $(e.currentTarget);
        this.selectSantri($item.data('id'), $item.data('nama'));
      });
      $(document).on('click', '#santri_display', () => this.show());
      $(document).on('click', '.santri-custom-input .clear-btn', e => {
        e.stopPropagation();
        this.clearSelection();
      });
      $('#modalPilihSantri').on('hidden.bs.modal', () => {
        $('#searchSantriInput').val('');
        this.filteredData = this.allData;
      });
    }
  };

  // =====================================================
  // CHECKLIST RENDERER
  // =====================================================
  const ChecklistRenderer = {
    data: [],
    init(data) {
      this.data = data || [];
    },
    render() {
      const container = document.getElementById('penilaian-checklist-container');
      if (!this.data.length) {
        container.innerHTML = '<div class="alert alert-info">Tidak ada tujuan pembelajaran.</div>';
        return;
      }
      container.innerHTML = '';
      this.data.forEach((tujuan, index) => {
        const div = document.createElement('div');
        div.className = 'mb-3 p-3 border rounded checklist-item';
        div.innerHTML = `
        <h6>${index + 1}. ${tujuan.text}</h6>
        <input type="hidden" name="tujuan_pembelajaran_id[]" value="${tujuan.id}">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="penilaian_tp_${tujuan.id}" id="tp_${tujuan.id}_muncul" value="sudah_muncul">
          <label class="form-check-label" for="tp_${tujuan.id}_muncul">Sudah Muncul</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="penilaian_tp_${tujuan.id}" id="tp_${tujuan.id}_belum" value="belum_muncul">
          <label class="form-check-label" for="tp_${tujuan.id}_belum">Belum Muncul</label>
        </div>
        <div class="kejadian-group mt-3">
          <input type="hidden" name="kejadian_teramati[][id_capaian]" value="${tujuan.capaian}">
          <div class="mb-3">
            <label class="form-label">Kejadian Teramati</label>
            <textarea name="kejadian_teramati[][kejadian]" id="kejadian_teramati_${index}" class="form-control kejadian-input" rows="2"></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="konteks-group">
              <input type="hidden" name="konteks[][id_capaian]" value="${tujuan.capaian}">
              <label class="form-label">Konteks</label>
              <textarea name="konteks[][konteks]" id="konteks_${index}" class="form-control konteks-input" rows="2"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="tempat_waktu-group">
              <input type="hidden" name="tempat_waktu[][id_capaian]" value="${tujuan.capaian}">
              <label class="form-label">Tempat & Waktu</label>
              <textarea name="tempat_waktu[][tempat_waktu]" id="tempat_waktu_${index}" class="form-control tempat_waktu-input" rows="2"></textarea>
            </div>
          </div>
        </div>
      `;
        container.appendChild(div);
      });
    }
  };

  // =====================================================
  // DATA COLLECTOR
  // =====================================================
  const DataCollector = {
    collectChecklist() {
      const results = [];
      document.querySelectorAll('#penilaian-checklist-container .checklist-item').forEach(item => {
        const tpId = item.querySelector('input[name="tujuan_pembelajaran_id[]"]')?.value;
        const status = item.querySelector('input[type="radio"]:checked')?.value || '';
        if (tpId) results.push({
          id: tpId,
          status
        });
      });
      return results;
    },
    collectByGroup(groupClass, dataKey) {
      const results = [];
      document.querySelectorAll('.' + groupClass).forEach(group => {
        const idCapaian = group.querySelector('input[type="hidden"][name$="[id_capaian]"]')?.value || '';
        const value = group.querySelector(`textarea.${dataKey}-input`)?.value?.trim() || '';
        results.push({
          id_capaian: idCapaian,
          [dataKey]: value
        });
      });
      return results;
    }
  };

  // =====================================================
  // FORM MANAGER
  // =====================================================
  const FormManager = {
    currentSantriId: null,

    reset() {
      ['checklist', 'hasilkarya', 'fotoberseri', 'anekdot'].forEach(tab => {
        document.getElementById('form-' + tab)?.reset();
      });
      document.querySelectorAll('.preview-container').forEach(el => el.style.display = 'none');
      document.querySelectorAll('.preview-image').forEach(el => el.src = '');
      document.querySelectorAll('input[name^="penilaian_tp_"]').forEach(el => el.checked = false);
    },

    async loadData(santriId) {
      const modulAjarId = '<?= esc($modul['id']) ?>';

      Utils.showLoading('Memuat Data...', 'Mohon tunggu sebentar.');
      try {
        const res = await fetch(CONFIG.baseUrl + CONFIG.endpoints.getData, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            santri_id: santriId,
            modul_ajar_id: modulAjarId,
            tanggal: ''
          })
        });
        Utils.closeLoading();
        if (!res.ok) throw new Error('Network error');
        const data = await res.json();
        this.populateForm(data);
      } catch (e) {
        Utils.closeLoading();
        $('#form-penilaian').show();
        this.setSantriIdAllForms(santriId);
      }
    },

    setSantriIdAllForms(santriId) {
      ['checklist', 'hasilkarya', 'fotoberseri', 'anekdot'].forEach(tab => {
        const el = document.getElementById('hidden_santri_id_' + tab);
        if (el) el.value = santriId;
      });
    },

    populateForm(data) {
      $('#form-penilaian').show();
      if (!data) return;

      const santriId = data.santri || $('#santri_id').val();
      this.setSantriIdAllForms(santriId);

      const tanggalMap = {
        checklist: data.tanggal_checklist || tabTanggal.checklist,
        hasilkarya: data.tanggal_hasilkarya || tabTanggal.hasilkarya,
        fotoberseri: data.tanggal_fotoberseri || tabTanggal.fotoberseri,
        anekdot: data.tanggal_anekdot || tabTanggal.anekdot,
      };

      ['checklist', 'hasilkarya', 'fotoberseri', 'anekdot'].forEach(tab => {
        const sel = document.getElementById('tanggal_' + tab);
        if (sel && tanggalMap[tab]) {
          sel.value = tanggalMap[tab];
          tabTanggal[tab] = tanggalMap[tab]; // update state juga
        }
      });

      // Checklist
      if (data.hasil_penilaian_decoded) {
        const decoded = Utils.safeJsonParse(data.hasil_penilaian_decoded);
        document.querySelectorAll('input[name^="penilaian_tp_"]').forEach(el => el.checked = false);
        decoded.forEach(item => {
          if (item.id && item.status) {
            const radio = document.querySelector(`input[name="penilaian_tp_${item.id}"][value="${item.status}"]`);
            if (radio) radio.checked = true;
          }
        });
      }

      // Kejadian, konteks, tempat_waktu
      Utils.safeJsonParse(data.kejadian_checklist_json).forEach((item, i) => {
        const el = document.getElementById('kejadian_teramati_' + i);
        if (el) el.value = item.kejadian || '';
      });
      Utils.safeJsonParse(data.tempat_waktu).forEach((item, i) => {
        const el = document.getElementById('tempat_waktu_' + i);
        if (el) el.value = item.tempat_waktu || '';
      });
      Utils.safeJsonParse(data.konteks).forEach((item, i) => {
        const el = document.getElementById('konteks_' + i);
        if (el) el.value = item.konteks || '';
      });

      // Hasil karya
      const hkKegiatan = document.getElementById('kegiatan_hasil_karya');
      if (hkKegiatan) hkKegiatan.value = data.kegiatan || '';
      if (data.foto_hk) {
        document.getElementById('thumb_hk').src = CONFIG.uploadPath + data.foto_hk;
        document.getElementById('preview_container_hk').style.display = 'inline-block';
      }
      Utils.safeJsonParse(data.catatan_hasil_karya_json).forEach(item => {
        const el = document.getElementById('hasil_karya_catatan_' + item.id_capaian);
        if (el) el.value = item.catatan || '';
      });

      // Foto berseri
      for (let i = 1; i <= 3; i++) {
        if (data['foto' + i]) {
          document.getElementById('thumb_' + i).src = CONFIG.uploadPath + data['foto' + i];
          document.getElementById('preview_container_' + i).style.display = 'inline-block';
        }
        const ket = document.getElementById('foto_ket' + i);
        if (ket) ket.value = data['ket_foto' + i] || '';
      }
      Utils.safeJsonParse(data.analisis_guru_json).forEach(item => {
        const el = document.getElementById('foto_analisis_' + item.id_capaian);
        if (el) el.value = item.analisis || '';
      });
      const umpan = document.getElementById('foto_umpan_balik');
      if (umpan) umpan.value = data.umpan_balik || '';

      // Anekdot
      const tempat = document.getElementById('anekdot_tempat');
      if (tempat) tempat.value = data.tempat || '';
      const peristiwa = document.getElementById('anekdot_peristiwa');
      if (peristiwa) peristiwa.value = data.peristiwa || '';
      Utils.safeJsonParse(data.keterangan_anekdot_json).forEach(item => {
        const el = document.getElementById('anekdot_keterangan_' + item.id_capaian);
        if (el) el.value = item.keterangan || '';
      });
    },

    async submitActiveTab() {
      const santriId = $('#santri_id').val();
      if (!santriId) {
        Utils.showError('Silakan pilih santri terlebih dahulu');
        return;
      }

      const formEl = document.getElementById('form-' + activeTab);
      if (!formEl) return;

      const formData = new FormData(formEl);

      // Untuk checklist, tambahkan JSON data
      if (activeTab === 'checklist') {
        const penilaian = DataCollector.collectChecklist();
        const kejadian = DataCollector.collectByGroup('kejadian-group', 'kejadian');
        const konteks = DataCollector.collectByGroup('konteks-group', 'konteks');
        const tempatWaktu = DataCollector.collectByGroup('tempat_waktu-group', 'tempat_waktu');
        formData.append('penilaian_data_json', JSON.stringify(penilaian));
        formData.append('kejadian_teramati_json', JSON.stringify(kejadian));
        formData.append('konteks_json', JSON.stringify(konteks));
        formData.append('tempat_waktu_json', JSON.stringify(tempatWaktu));
      }

      const $btn = $('#btnSimpanFloating');
      $btn.prop('disabled', true).find('i').attr('class', 'ri-loader-4-line');

      try {
        const res = await fetch(CONFIG.baseUrl + CONFIG.endpoints.simpan, {
          method: 'POST',
          body: formData
        });
        const result = await res.json();
        if (res.ok && result.message) {
          Utils.showSuccess(result.message);
        } else {
          Utils.showError(result.message || 'Terjadi kesalahan');
        }
      } catch (e) {
        Utils.showError('Terjadi kesalahan saat menyimpan');
      } finally {
        $btn.prop('disabled', false).find('i').attr('class', 'ri-save-line');
      }
    }
  };

  // =====================================================
  // SANTRI HANDLER
  // =====================================================
  const SantriHandler = {
    init() {
      $('#santri_id').on('change', async function() {
        const santriId = $(this).val();
        FormManager.currentSantriId = santriId;
        FormManager.reset();

        if (!santriId) {
          $('#form-penilaian').hide();
          return;
        }

        // Set tanggal dari state per tab
        ['checklist', 'hasilkarya', 'fotoberseri', 'anekdot'].forEach(tab => {
          const sel = document.getElementById('tanggal_' + tab);
          if (sel) sel.value = tabTanggal[tab];
        });

        await FormManager.loadData(santriId);
      });
    }
  };

  // =====================================================
  // IMAGE PREVIEW
  // =====================================================
  function removePreview(inputId, previewId, containerId) {
    document.getElementById(inputId).value = '';
    document.getElementById(containerId).style.display = 'none';
    document.getElementById(previewId).src = '';
  }

  function initImagePreviews() {
    document.querySelectorAll('.image-upload').forEach(input => {
      input.addEventListener('change', function() {
        const file = this.files[0];
        const inputId = this.id;

        let previewId, containerId;
        if (inputId === 'foto_hasil_karya_input') {
          previewId = 'thumb_hk';
          containerId = 'preview_container_hk';
        } else if (inputId.match(/^foto_(\d+)_input$/)) {
          const num = inputId.match(/\d+/)[0];
          previewId = 'thumb_' + num;
          containerId = 'preview_container_' + num;
        } else return;

        if (!file) {
          document.getElementById(containerId).style.display = 'none';
          return;
        }

        const validation = Utils.validateImage(file);
        if (!validation.valid) {
          Utils.showError(validation.message);
          this.value = '';
          document.getElementById(containerId).style.display = 'none';
          return;
        }

        const reader = new FileReader();
        reader.onload = e => {
          document.getElementById(previewId).src = e.target.result;
          document.getElementById(containerId).style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
      });
    });
  }

  // =====================================================
  // GO TO TOP
  // =====================================================
  function initGoToTop() {
    const btn = document.getElementById('goToTopBtn');
    window.addEventListener('scroll', () => {
      btn.classList.toggle('show', window.scrollY > 300);
    });
    btn.addEventListener('click', () => window.scrollTo({
      top: 0,
      behavior: 'smooth'
    }));
  }

  // =====================================================
  // INIT
  // =====================================================
  $(document).ready(function() {
    TabManager.init();
    SantriModalManager.init();
    SantriHandler.init();
    ChecklistRenderer.init(tujuanPembelajaranData);
    ChecklistRenderer.render();
    initImagePreviews();
    initGoToTop();

    $('#btnSimpanFloating').on('click', () => FormManager.submitActiveTab());
  });
</script>