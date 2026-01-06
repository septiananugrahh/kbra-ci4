<style>
  /* ========================================
     FLOATING ACTION BAR (BOTTOM RIGHT)
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

  .form-floating-action-bar .btn-success:hover {
    /* transform: scale(1.1) translateY(-5px); */
    box-shadow: 0 6px 20px rgba(129, 199, 132, 0.5);
  }

  .form-floating-action-bar .btn-success:active {
    transform: scale(0.95);
  }

  /* Go to Top Button */
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
    box-shadow: 0 6px 20px rgba(184, 197, 245, 0.5);
  }


  #goToAsessment {
    background: linear-gradient(135deg, #b8c5f5 0%, #8b9dc3 100%);
    color: white;
    opacity: 1;
    visibility: visible;
    transition: all 0.3s ease;
  }

  #goToAsessment.show {
    opacity: 1;
    visibility: visible;
  }

  #goToAsessment:hover {
    transform: scale(1.1) translateY(-5px);
    box-shadow: 0 6px 20px rgba(184, 197, 245, 0.5);
  }

  /* Back Button - Kembali ke posisi normal (bukan floating) */
  .btn-kembali-wrapper {
    margin-bottom: 2rem;
    padding-top: 1rem;
  }

  .btn-kembali-wrapper .btn {
    min-width: 120px;
    padding: 0.625rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 600;
    background-color: #f7fafc;
    border: 1.5px solid #e2e8f0;
    color: #718096;
    transition: all 0.2s ease;
  }

  .btn-kembali-wrapper .btn:hover {
    background-color: #edf2f7;
    border-color: #cbd5e0;
    color: #4a5568;
  }

  .spacer-for-fixed-bar {
    display: none;
  }

  /* Auto Save Indicator */
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
    animation: slideInRight 0.3s ease;
  }

  @keyframes slideInRight {
    from {
      transform: translateX(100px);
      opacity: 0;
    }

    to {
      transform: translateX(0);
      opacity: 1;
    }
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

  /* ========================================
     MOBILE RESPONSIVE
    ======================================== */
  @media (max-width: 767px) {
    .form-floating-action-bar {
      bottom: 15px;
      right: 15px;
    }

    .form-floating-action-bar .btn-success {
      width: 60px;
      height: 60px;
    }

    .form-floating-action-bar .btn i {
      font-size: 1.3rem;
    }

    #goToTopBtn {
      width: 50px;
      height: 50px;
    }

    #goToAsessment {
      width: 50px;
      height: 50px;
    }

    .auto-save-indicator {
      bottom: 90px;
      right: 15px;
      font-size: 0.875rem;
    }

    /* Tambah padding bottom untuk konten agar tidak tertutup floating button */
    .card-body {
      padding-bottom: 100px;
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
  }

  @media (min-width: 768px) {
    #goToAsessment:hover {
      border-radius: 2rem;
      width: auto;
      padding: 0 1.2rem;
    }

    #goToAsessment:hover::after {
      content: " Ke Asesmmen";
      margin-left: 0.5rem;
      font-size: 1rem;
    }
  }

  @media (min-width: 768px) {
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

  .fab-wrapper {
    display: flex;
    justify-content: right;
  }


  /* ========================================
           CARD & LAYOUT
        ======================================== */
  .card {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: none;
  }

  .card-body {
    padding: 2rem;
  }

  /* ========================================
           HEADER SECTION
        ======================================== */
  .penilaian-header {
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    color: #4a5568;
  }

  .penilaian-header h3 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.5rem;
  }

  .penilaian-header p {
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .penilaian-header strong {
    color: #2d3748;
    min-width: 80px;
  }

  /* ========================================
           SELECT SANTRI
        ======================================== */
  .santri-selector {
    background: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
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

  .santri-selector select {
    border: 1.5px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
  }

  .santri-selector select:focus {
    border-color: #b8c5f5;
    box-shadow: 0 0 0 3px rgba(184, 197, 245, 0.1);
  }

  /* ========================================
           DIVIDER
        ======================================== */
  .divider {
    margin: 2.5rem 0 1.5rem;
    position: relative;
  }

  .divider-text {
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    color: #2d3748;
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 2px 8px rgba(184, 197, 245, 0.3);
  }

  .divider-text::before {
    font-size: 1.3rem;
  }

  .divider-primary .divider-text::before {
    content: '✓';
  }

  /* ========================================
           FORM ELEMENTS
        ======================================== */
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

  /* ========================================
           CHECKLIST ITEMS
        ======================================== */
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

  /* ========================================
     MODAL SANTRI CUSTOM
    ======================================== */
  #modalPilihSantri {
    z-index: 1100;
  }

  .santri-custom-input {
    position: relative;
    cursor: pointer;
  }

  .santri-custom-input .form-control {
    cursor: pointer;
    background-color: #fff;
    padding-right: 40px;
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

  .santri-list-item.selected {
    background-color: #e8f5e9;
    border-left-color: #28a745;
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

  .santri-info {
    flex-grow: 1;
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
    display: inline-block;
  }

  .modal-backdrop.show {
    z-index: 1095;
  }

  /* ========================================
           IMAGE UPLOAD
        ======================================== */
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

  /* ========================================
           GROUPED FIELDS
        ======================================== */
  .field-group {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-top: 1rem;
  }

  /* ========================================
           MOBILE RESPONSIVE
        ======================================== */
  @media (max-width: 767px) {
    .card-body {
      padding: 1rem;
    }

    .penilaian-header {
      padding: 1rem;
    }

    .penilaian-header h3 {
      font-size: 1.25rem;
    }

    .santri-selector {
      padding: 1rem;
    }

    .checklist-item {
      padding: 1rem;
    }

    .form-floating-action-bar {
      position: fixed !important;
      bottom: 0 !important;
      left: 0 !important;
      right: 0 !important;
      width: 100%;
      padding: 1rem 1.5rem;
      background: white !important;
      border-top: 1px solid #e2e8f0;
      box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.08);
      z-index: 1020 !important;
      margin-top: 0;
    }

    .form-floating-action-bar .btn {
      flex-grow: 1;
    }

    .form-floating-action-bar .btn-secondary {
      margin-right: 0.75rem;
    }

    .form-floating-action-bar {
      justify-content: center;
    }

    .spacer-for-fixed-bar {
      display: block;
      height: 80px;
    }

    .divider-text {
      font-size: 1rem;
      padding: 0.625rem 1.25rem;
    }

    #form-penilaian .form-floating-action-bar {
      position: fixed !important;
      bottom: 0 !important;
      z-index: 9999 !important;
    }
  }

  /* ========================================
           FOTO SERIES GRID
        ======================================== */
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
           CAPAIAN SECTION
        ======================================== */
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
</style>


<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <!-- Header Penilaian -->
        <div class="penilaian-header">
          <h3><i class="ri-file-list-3-line me-2"></i>Penilaian Harian</h3>
          <p>
            <strong><i class="ri-book-2-line me-1"></i>Topik:</strong>
            <span><?= esc($modul['topik_pembelajaran']) ?></span>
          </p>
          <p>
            <strong><i class="ri-calendar-line me-1"></i>Tanggal:</strong>
            <span><?= esc($tanggal) ?> (SubSubtopik <?= esc($subtopik_ke) ?>)</span>
          </p>
        </div>

        <!-- Select Santri (Custom) -->
        <div class="santri-selector">
          <label>
            <i class="ri-user-search-line"></i>
            Pilih Santri
          </label>
          <div class="santri-custom-input">
            <input type="text"
              id="santri_display"
              class="form-control"
              readonly
              placeholder="Klik untuk memilih santri">
            <span class="clear-btn">
              <i class="ri-close-circle-fill"></i>
            </span>
            <input type="hidden" id="santri_id" name="santri_id">
          </div>
        </div>

        <!-- Form Penilaian -->
        <div id="form-penilaian" style="display: none;">
          <form action="<?= site_url('asesmen/simpan') ?>" method="post" enctype="multipart/form-data" id="form-penilaian-santri">
            <input type="hidden" id="modul_ajar_id" name="modul_ajar_id" value="<?= esc($modul['id']) ?>">
            <input type="hidden" id="tanggal" name="tanggal" value="<?= esc($tanggal) ?>">
            <input type="hidden" name="subtopik_ke" value="<?= esc($subtopik_ke) ?>">
            <input type="hidden" name="santri_id" id="hidden_santri_id">

            <!-- CHECKLIST SECTION -->
            <div class="divider divider-primary">
              <div class="divider-text">
                <i class="ri-checkbox-line"></i>
                Checklist Penilaian
              </div>
            </div>

            <div id="penilaian-checklist-container"></div>

            <!-- HASIL KARYA SECTION -->
            <div class="divider divider-primary">
              <div class="divider-text">
                <i class="ri-palette-line"></i>
                Hasil Karya
              </div>
            </div>

            <div class="mb-3">
              <label for="kegiatan_hasil_karya" class="form-label">
                <i class="ri-file-text-line me-1"></i>
                Kegiatan
              </label>
              <input type="text" name="kegiatan_hasil_karya" id="kegiatan_hasil_karya" class="form-control" placeholder="Masukkan nama kegiatan">
            </div>

            <div class="mb-3">
              <label class="form-label">
                <i class="ri-image-add-line me-1"></i>
                Upload Foto Hasil Karya
              </label>
              <div class="image-upload-wrapper">
                <label for="foto_hasil_karya_input" class="upload-label">
                  <i class="ri-upload-cloud-2-line"></i>
                  <span>Klik untuk upload foto</span>
                  <small>Format: JPG, PNG (Max: 9MB)</small>
                </label>
                <input type="file" name="foto_hasil_karya" id="foto_hasil_karya_input" class="image-upload" accept="image/*">
              </div>
              <!-- <img src="" class="preview-image" id="thumb_hk" style="display:none;"> -->
              <div class="preview-container" id="preview_container_hk" style="display:none;">
                <img src="" class="preview-image" id="thumb_hk">
                <button type="button" class="remove-preview-btn" onclick="removePreview('foto_hasil_karya_input', 'thumb_hk', 'preview_container_hk')">
                  <i class="ri-close-line"></i>
                </button>
              </div>
            </div>

            <?php foreach ($capaianPembelajaran as $capaian): ?>
              <div class="capaian-wrapper">
                <label class="form-label">
                  <i class="ri-edit-line me-1"></i>
                  Catatan: <?= esc($capaian['nama']) ?>
                </label>
                <input type="hidden" name="hasil_karya_catatan[<?= $capaian['id'] ?>][id_capaian]" value="<?= $capaian['id'] ?>">
                <textarea name="hasil_karya_catatan[<?= $capaian['id'] ?>][catatan]" id="hasil_karya_catatan_<?= $capaian['id'] ?>" class="form-control" rows="2" placeholder="Tulis catatan untuk capaian ini..."></textarea>
              </div>
            <?php endforeach; ?>

            <!-- FOTO BERSERI SECTION -->
            <div class="divider divider-primary">
              <div class="divider-text">
                <i class="ri-gallery-line"></i>
                Foto Berseri
              </div>
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
                <label class="form-label">
                  <i class="ri-edit-line me-1"></i>
                  Analisis: <?= esc($capaian['nama']) ?>
                </label>
                <input type="hidden" name="foto_analisis[<?= $capaian['id'] ?>][id_capaian]" value="<?= $capaian['id'] ?>">
                <textarea name="foto_analisis[<?= $capaian['id'] ?>][analisis]" id="foto_analisis_<?= $capaian['id'] ?>" class="form-control" rows="2" placeholder="Tulis analisis untuk capaian ini..."></textarea>
              </div>
            <?php endforeach; ?>

            <div class="mb-3">
              <label for="foto_umpan_balik" class="form-label">
                <i class="ri-feedback-line me-1"></i>
                Umpan Balik
              </label>
              <textarea name="foto_umpan_balik" id="foto_umpan_balik" class="form-control" rows="3" placeholder="Tulis umpan balik..."></textarea>
            </div>

            <!-- ANEKDOT SECTION -->
            <div class="divider divider-primary">
              <div class="divider-text">
                <i class="ri-chat-quote-line"></i>
                Anekdot
              </div>
            </div>

            <div class="mb-3">
              <label for="anekdot_tempat" class="form-label">
                <i class="ri-map-pin-line me-1"></i>
                Tempat
              </label>
              <input type="text" name="anekdot_tempat" id="anekdot_tempat" class="form-control" placeholder="Masukkan tempat kejadian">
            </div>

            <div class="mb-3">
              <label for="anekdot_peristiwa" class="form-label">
                <i class="ri-file-text-line me-1"></i>
                Peristiwa
              </label>
              <textarea name="anekdot_peristiwa" id="anekdot_peristiwa" class="form-control" rows="4" placeholder="Ceritakan peristiwa yang terjadi..."></textarea>
            </div>

            <?php foreach ($capaianPembelajaran as $capaian): ?>
              <div class="capaian-wrapper">
                <label class="form-label">
                  <i class="ri-edit-line me-1"></i>
                  Keterangan: <?= esc($capaian['nama']) ?>
                </label>
                <input type="hidden" name="anekdot_keterangan[<?= $capaian['id'] ?>][id_capaian]" value="<?= $capaian['id'] ?>">
                <textarea name="anekdot_keterangan[<?= $capaian['id'] ?>][keterangan]" id="anekdot_keterangan_<?= $capaian['id'] ?>" class="form-control" rows="2" placeholder="Tulis keterangan untuk capaian ini..."></textarea>
              </div>
            <?php endforeach; ?>

            <!-- FLOATING ACTION BUTTONS -->
            <div class="form-floating-action-bar">

              <!-- Go to Top Button -->
              <div class="fab-wrapper">
                <button type="button" class="btn" id="goToTopBtn" title="Kembali ke Atas">
                  <i class="ri-arrow-up-line"></i>
                </button>
              </div>

              <!-- tommbol kembali ke asesmen -->
              <div class="fab-wrapper">
                <button type="button" class="btn btn-success" id="goToAsessment" title="Kembali ke Asesmen" onclick="history.back()">
                  <i class="ri-arrow-left-line"></i>
                </button>
              </div>

              <!-- Tombol Simpan -->
              <div class="fab-wrapper">
                <button type="submit" class="btn btn-success" id="btnSimpanFloating" title="Simpan Penilaian">
                  <i class="ri-save-line"></i>
                </button>
              </div>
            </div>

            <!-- Auto Save Indicator -->
            <div class="auto-save-indicator" id="autoSaveIndicator">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <span id="autoSaveText">Menyimpan...</span>
            </div>

            <!-- Button Kembali (Non-floating) -->
            <div class="btn-kembali-wrapper">
              <a href="<?= site_url('asesmen/index/' . $modul['id']) ?>" class="btn btn-secondary">
                <i class="ri-arrow-left-line me-1"></i>
                Kembali
              </a>
            </div>

            <div class="spacer-for-fixed-bar"></div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ============================================
     MODAL PILIH SANTRI
============================================ -->
<div class="modal fade" id="modalPilihSantri" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-user-search-line"></i> Pilih Santri
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- Search Box -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text">
              <i class="ri-search-line"></i>
            </span>
            <input type="text"
              id="searchSantriInput"
              class="form-control"
              placeholder="Cari nama santri...">
          </div>
          <small class="text-muted mt-1 d-block">
            <i class="ri-information-line"></i> Urutan berdasarkan abjad
          </small>
        </div>

        <!-- Loading -->
        <div id="santriLoadingIndicator" class="text-center py-4" style="display: none;">
          <div class="spinner-border text-primary"></div>
          <p class="text-muted mt-2">Memuat daftar santri...</p>
        </div>

        <!-- List Santri -->
        <div id="santriListContainer" class="list-group" style="max-height: 450px; overflow-y: auto;">
          <!-- Generated by JavaScript -->
        </div>

        <!-- No Results -->
        <div id="santriNoResults" class="alert alert-info text-center" style="display: none;">
          <i class="ri-user-unfollow-line"></i> Tidak ada santri ditemukan
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="ri-close-line"></i> Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Data tujuan pembelajaran yang dikirim dari controller
  const tujuanPembelajaranData = <?= json_encode($tujuan_pembelajaran_detail); ?>;
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
  // =====================================================
  // CONFIGURATION
  // =====================================================
  const CONFIG = {
    baseUrl: '<?php echo base_url(); ?>',
    uploadPath: '<?php echo base_url("uploads/penilaian/"); ?>',
    endpoints: {
      getData: 'asesmen/getData',
      simpan: 'asesmen/simpan'
    },
    maxImageSize: 9 * 1024 * 1024, // 9MB
    allowedImageTypes: ['image/jpeg', 'image/jpg', 'image/png']
  };


  const SANTRI_DATA = <?= json_encode($santriList); ?>;

  // =====================================================
  // UTILITY FUNCTIONS
  // =====================================================
  const Utils = {
    // Safe JSON parser
    safeJsonParse(data, fallback = []) {
      if (!data || data === 'null' || (typeof data === 'string' && data.trim() === '')) {
        return fallback;
      }

      try {
        let parsed = typeof data === 'string' ? JSON.parse(data) : data;
        if (typeof parsed === 'string') parsed = JSON.parse(parsed);
        return Array.isArray(parsed) ? parsed : (parsed ? [parsed] : fallback);
      } catch (err) {
        console.warn('JSON parse error:', err);
        return fallback;
      }
    },

    // Validate image file
    validateImage(file) {
      if (!file) return {
        valid: false,
        message: 'Tidak ada file dipilih'
      };

      if (!CONFIG.allowedImageTypes.includes(file.type)) {
        return {
          valid: false,
          message: 'Format file harus JPG atau PNG'
        };
      }

      if (file.size > CONFIG.maxImageSize) {
        return {
          valid: false,
          message: 'Ukuran file maksimal 9MB'
        };
      }

      return {
        valid: true
      };
    },

    // Show loading overlay
    showLoading(title = 'Memuat...', text = 'Mohon tunggu sebentar') {
      Swal.fire({
        title,
        html: text,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });
    },

    // Close loading
    closeLoading() {
      Swal.close();
    },

    // Show success message
    showSuccess(message, detail = '') {
      let text = message;
      if (detail) {
        text += '\n\n' + detail;
      }

      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: text,
        timer: 2000,
        showConfirmButton: false
      });
    },

    // Show error message
    showError(message) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: message
      });
    }
  };

  // =====================================================
  // SANTRI MODAL MANAGER
  // =====================================================
  const SantriModalManager = {
    allData: [],
    filteredData: [],

    // Initialize
    init() {
      // Sort data berdasarkan nama (abjad)
      this.allData = SANTRI_DATA.sort((a, b) =>
        a.nama.localeCompare(b.nama, 'id')
      );
      this.filteredData = this.allData;

      this.bindEvents();
    },

    // Show modal
    show() {
      $('#modalPilihSantri').modal('show');
      this.renderList();
      setTimeout(() => $('#searchSantriInput').focus(), 300);
    },

    // Render list
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
        const $item = $(`
        <a href="#" class="list-group-item list-group-item-action santri-list-item" 
           data-id="${santri.id}" 
           data-nama="${santri.nama}">
          <div class="d-flex align-items-center">
            <div class="santri-avatar">${initial}</div>
            <div class="santri-info">
              <div class="santri-name">${santri.nama}</div>
              ${santri.kelas ? `<span class="santri-badge">Kelas: ${santri.kelas}</span>` : ''}
            </div>
            <i class="ri-arrow-right-s-line"></i>
          </div>
        </a>
      `);

        $container.append($item);
      });
    },

    // Search/filter
    search(query) {
      const searchTerm = query.toLowerCase().trim();

      if (!searchTerm) {
        this.filteredData = this.allData;
      } else {
        this.filteredData = this.allData.filter(santri =>
          santri.nama.toLowerCase().includes(searchTerm)
        );
      }

      this.renderList();
    },

    // Select santri
    selectSantri(id, nama) {
      $('#santri_display').val(nama);
      $('#santri_id').val(id);
      $('.santri-custom-input').addClass('has-value');

      $('#modalPilihSantri').modal('hide');

      // Trigger change event untuk load data
      $('#santri_id').trigger('change');
    },

    // Clear selection
    clearSelection() {
      $('#santri_display').val('');
      $('#santri_id').val('');
      $('.santri-custom-input').removeClass('has-value');

      // Trigger change untuk hide form
      $('#santri_id').trigger('change');
    },

    // Bind events
    bindEvents() {
      // Search input
      $('#searchSantriInput').on('input', (e) => {
        this.search(e.target.value);
      });

      // Click santri item
      $(document).on('click', '.santri-list-item', (e) => {
        e.preventDefault();
        const $item = $(e.currentTarget);
        this.selectSantri($item.data('id'), $item.data('nama'));
      });

      // Show modal when click input
      $(document).on('click', '#santri_display', () => {
        this.show();
      });

      // Clear button
      $(document).on('click', '.santri-custom-input .clear-btn', (e) => {
        e.stopPropagation();
        this.clearSelection();
      });

      // Reset search saat modal ditutup
      $('#modalPilihSantri').on('hidden.bs.modal', () => {
        $('#searchSantriInput').val('');
        this.filteredData = this.allData;
      });
    }
  };

  // =====================================================
  // AUTO SAVE MANAGER
  // =====================================================
  const AutoSaveManager = {
    saveTimeout: null,
    saveDelay: 2000, // 2 detik setelah user berhenti mengetik
    isSaving: false,
    lastSavedData: null,
    currentSantriId: null,

    // Initialize auto save
    init() {
      this.bindAutoSaveEvents();
      this.initGoToTop();
    },

    // Bind events untuk auto save
    bindAutoSaveEvents() {
      // Monitor perubahan pada form fields
      const fieldsToMonitor = [
        'input[type="text"]',
        'input[type="radio"]',
        'textarea',
        'select'
      ].join(', ');

      $(document).on('change input', '#form-penilaian-santri ' + fieldsToMonitor, (e) => {
        // Jangan auto save untuk input file
        if ($(e.target).attr('type') === 'file') return;

        this.scheduleAutoSave();
      });

      // Monitor upload foto
      $(document).on('change', '.image-upload', () => {
        this.scheduleAutoSave();
      });
    },

    // Schedule auto save dengan debounce
    scheduleAutoSave() {
      // Clear timeout sebelumnya
      if (this.saveTimeout) {
        clearTimeout(this.saveTimeout);
      }

      // Set timeout baru
      this.saveTimeout = setTimeout(() => {
        this.performAutoSave();
      }, this.saveDelay);
    },

    // Perform auto save
    async performAutoSave() {
      // Jangan auto save jika sedang menyimpan atau tidak ada santri dipilih
      if (this.isSaving || !DOM.hiddenSantriId.val()) return;

      // Jangan auto save jika santri ID tidak cocok (sedang ganti santri)
      if (this.currentSantriId && this.currentSantriId !== DOM.hiddenSantriId.val()) {
        return;
      }

      this.isSaving = true;
      this.showIndicator('saving');

      try {
        const collectedData = DataCollector.collectAll();
        const formData = new FormData(DOM.formElement[0]);

        formData.append('penilaian_data_json', JSON.stringify(collectedData.penilaian));
        formData.append('kejadian_teramati_json', JSON.stringify(collectedData.kejadian));
        formData.append('konteks_json', JSON.stringify(collectedData.konteks));
        formData.append('tempat_waktu_json', JSON.stringify(collectedData.tempatWaktu));
        formData.append('auto_save', 'true');

        const response = await fetch(CONFIG.baseUrl + CONFIG.endpoints.simpan, {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (response.ok && result.message) {
          this.showIndicator('success');
          this.lastSavedData = collectedData;
        } else {
          this.showIndicator('error');
          console.error('Auto save error:', result.message);
        }

      } catch (error) {
        console.error('Auto save error:', error);
        this.showIndicator('error');
      } finally {
        this.isSaving = false;
      }
    },

    // Show auto save indicator
    showIndicator(status) {
      const $indicator = $('#autoSaveIndicator');
      const $text = $('#autoSaveText');
      const $spinner = $indicator.find('.spinner-border');

      // Remove all status classes
      $indicator.removeClass('saving success error');

      if (status === 'saving') {
        $indicator.addClass('saving');
        $text.text('Menyimpan...');
        $spinner.show();
      } else if (status === 'success') {
        $indicator.addClass('success');
        $text.html('<i class="ri-check-line me-1"></i>Tersimpan');
        $spinner.hide();

        // Hide after 2 seconds
        setTimeout(() => {
          $indicator.fadeOut(300);
        }, 2000);
      } else if (status === 'error') {
        $indicator.addClass('error');
        $text.html('<i class="ri-error-warning-line me-1"></i>Gagal menyimpan');
        $spinner.hide();

        // Hide after 3 seconds
        setTimeout(() => {
          $indicator.fadeOut(300);
        }, 3000);
      }

      $indicator.fadeIn(300);
    },

    // Initialize Go to Top button
    initGoToTop() {
      const $goToTopBtn = $('#goToTopBtn');

      // Show/hide based on scroll position
      $(window).on('scroll', () => {
        if ($(window).scrollTop() > 300) {
          $goToTopBtn.addClass('show');
        } else {
          $goToTopBtn.removeClass('show');
        }
      });

      // Click handler
      $goToTopBtn.on('click', () => {
        $('html, body').animate({
          scrollTop: 0
        }, 600, 'swing');
      });
    },

    // Force save (untuk manual save button)
    async forceSave() {
      // Clear scheduled auto save
      if (this.saveTimeout) {
        clearTimeout(this.saveTimeout);
      }

      // Perform save immediately
      await this.performAutoSave();
    }
  };

  // =====================================================
  // DOM CACHE
  // =====================================================
  const DOM = {
    // Cache DOM elements
    init() {
      this.santriId = $('#santri_id');
      this.santriDisplay = $('#santri_display');
      this.formPenilaian = $('#form-penilaian');
      this.formElement = $('#form-penilaian-santri');
      this.hiddenSantriId = $('#hidden_santri_id');
      this.checklistContainer = $('#penilaian-checklist-container');
      this.modulAjarId = $('#modul_ajar_id');
      this.tanggal = $('#tanggal');

      // Cache preview images
      this.previews = {
        foto1: $('#thumb_1'),
        foto2: $('#thumb_2'),
        foto3: $('#thumb_3'),
        fotoHK: $('#thumb_hk')
      };
    }
  };

  // =====================================================
  // CHECKLIST RENDERER
  // =====================================================
  const ChecklistRenderer = {
    // Data tujuan pembelajaran dari controller (akan diisi saat init)
    data: [],

    // Initialize with data from PHP
    init(tujuanData) {
      this.data = tujuanData || [];
    },

    // Render checklist penilaian
    render() {
      if (!this.data || this.data.length === 0) {
        DOM.checklistContainer.html(
          '<div class="alert alert-info"><i class="ri-information-line me-2"></i>Tidak ada tujuan pembelajaran yang dipilih untuk penilaian.</div>'
        );
        return;
      }

      const fragment = document.createDocumentFragment();

      this.data.forEach((tujuan, index) => {
        const itemDiv = this.createChecklistItem(tujuan, index);
        fragment.appendChild(itemDiv);
      });

      DOM.checklistContainer[0].innerHTML = '';
      DOM.checklistContainer[0].appendChild(fragment);
    },

    // Create single checklist item
    createChecklistItem(tujuan, index) {
      const div = document.createElement('div');
      div.className = 'mb-3 p-3 border rounded checklist-item';

      div.innerHTML = `
            <h6>${index + 1}. ${tujuan.text}</h6>
            <input type="hidden" name="tujuan_pembelajaran_id[]" value="${tujuan.id}">
            
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="penilaian_tp_${tujuan.id}" 
                    id="tp_${tujuan.id}_muncul" value="sudah_muncul">
                <label class="form-check-label" for="tp_${tujuan.id}_muncul">Sudah Muncul</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="penilaian_tp_${tujuan.id}" 
                    id="tp_${tujuan.id}_belum" value="belum_muncul">
                <label class="form-check-label" for="tp_${tujuan.id}_belum">Belum Muncul</label>
            </div>

            <div class="kejadian-group mt-3">
                <input type="hidden" name="kejadian_teramati[][id_capaian]" value="${tujuan.capaian}">
                <div class="mb-3">
                    <label for="kejadian_teramati_${index}" class="form-label">Kejadian Teramati</label>
                    <textarea name="kejadian_teramati[][kejadian]" id="kejadian_teramati_${index}" 
                        class="form-control kejadian-input" rows="2"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="konteks-group">
                        <input type="hidden" name="konteks[][id_capaian]" value="${tujuan.capaian}">
                        <label for="konteks_${index}" class="form-label">Konteks</label>
                        <textarea name="konteks[][konteks]" id="konteks_${index}" 
                            class="form-control konteks-input" rows="2"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="tempat_waktu-group">
                        <input type="hidden" name="tempat_waktu[][id_capaian]" value="${tujuan.capaian}">
                        <label for="tempat_waktu_${index}" class="form-label">Tempat & Waktu</label>
                        <textarea name="tempat_waktu[][tempat_waktu]" id="tempat_waktu_${index}" 
                            class="form-control tempat_waktu-input" rows="2"></textarea>
                    </div>
                </div>
            </div>
        `;

      return div;
    }
  };

  // =====================================================
  // DATA COLLECTOR
  // =====================================================
  const DataCollector = {
    // Collect penilaian checklist
    collectChecklist() {
      const results = [];

      DOM.checklistContainer.find('.checklist-item').each(function() {
        const tpId = $(this).find('input[name="tujuan_pembelajaran_id[]"]').val();
        const status = $(this).find('input[type="radio"]:checked').val();

        if (tpId && status) {
          results.push({
            id: tpId,
            status: status
          });
        }
      });

      console.log('Checklist collected:', results);
      return results;
    },

    // Collect data by group class
    collectByGroup(groupClass, dataKey) {
      const results = [];

      $(`.${groupClass}`).each(function() {
        const idCapaian = $(this).find('input[type="hidden"][name$="[id_capaian]"]').val();
        const value = $(this).find(`textarea.${dataKey}-input`).val();

        results.push({
          id_capaian: idCapaian || '',
          [dataKey]: value ? value.trim() : ''
        });
      });

      return results;
    },

    // Collect all form data
    collectAll() {
      const data = {
        penilaian: this.collectChecklist(),
        kejadian: this.collectByGroup('kejadian-group', 'kejadian'),
        konteks: this.collectByGroup('konteks-group', 'konteks'),
        tempatWaktu: this.collectByGroup('tempat_waktu-group', 'tempat_waktu')
      };

      console.log('All data collected:', data);
      return data;
    }
  };

  // =====================================================
  // FORM MANAGER
  // =====================================================
  const FormManager = {
    // Reset form
    // Reset form
    reset() {
      DOM.formElement[0].reset();

      // Hide all preview containers
      $('.preview-container').hide();

      // Clear all preview images
      Object.values(DOM.previews).forEach($preview => {
        $preview.attr('src', '');
      });

      // Reset radio buttons
      $('input[name^="penilaian_tp_"]').prop('checked', false);

      // TAMBAHKAN INI: Reset lastSavedData
      AutoSaveManager.lastSavedData = null;
    },

    // Load data from server
    async loadData(santriId) {
      const modulAjarId = DOM.modulAjarId.val();
      const tanggal = DOM.tanggal.val();

      Utils.showLoading('Memuat Data Penilaian...', 'Mohon tunggu sebentar.');

      try {
        const response = await fetch(CONFIG.baseUrl + CONFIG.endpoints.getData, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            santri_id: santriId,
            modul_ajar_id: modulAjarId,
            tanggal: tanggal
          })
        });

        Utils.closeLoading();

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        const data = await response.json();
        this.populateForm(data);

      } catch (error) {
        Utils.closeLoading();
        console.error('Error loading data:', error);
        // Show form anyway for new entry
        DOM.formPenilaian.show();
        DOM.hiddenSantriId.val(santriId);
      }
    },

    // Populate form with data
    populateForm(data) {
      DOM.formPenilaian.show();

      if (!data) {
        // Form kosong, reset lastSavedData
        AutoSaveManager.lastSavedData = null;
        return;
      }
      // Populate checklist penilaian
      this.populateChecklist(data.hasil_penilaian_decoded);

      // Populate JSON fields
      this.populateJsonFields('hasil_karya_catatan', data.catatan_hasil_karya_json);
      this.populateJsonFields('foto_analisis', data.analisis_guru_json);
      this.populateJsonFields('anekdot_keterangan', data.keterangan_anekdot_json);

      // Populate checklist details
      this.populateChecklistDetails(data);

      // Populate foto berseri
      this.populateFotoBerseri(data);

      // Populate hasil karya
      this.populateHasilKarya(data);

      // Populate anekdot
      this.populateAnekdot(data);

      // TAMBAHKAN INI: Set lastSavedData dengan data yang baru di-load
      // Ini mencegah konfirmasi save saat kembali ke santri yang sama
      setTimeout(() => {
        AutoSaveManager.lastSavedData = DataCollector.collectAll();
      }, 500);
    },

    // Populate checklist radio buttons
    populateChecklist(decoded) {
      const data = Utils.safeJsonParse(decoded);

      // Reset all radio buttons
      $('input[name^="penilaian_tp_"]').prop('checked', false);

      data.forEach(item => {
        if (item.id && item.status) {
          $(`input[name="penilaian_tp_${item.id}"][value="${item.status}"]`).prop('checked', true);
        }
      });
    },

    // Populate JSON fields (hasil karya, foto analisis, anekdot)
    populateJsonFields(prefix, jsonData) {
      const data = Utils.safeJsonParse(jsonData);

      data.forEach(item => {
        const fieldId = `${prefix}_${item.id_capaian}`;
        const $field = $(`#${fieldId}`);

        if ($field.length) {
          const valueKey = prefix === 'hasil_karya_catatan' ? 'catatan' :
            prefix === 'foto_analisis' ? 'analisis' : 'keterangan';
          $field.val(item[valueKey] || '');
        }
      });
    },

    // Populate checklist details (kejadian, konteks, tempat_waktu)
    populateChecklistDetails(data) {
      const kejadian = Utils.safeJsonParse(data.kejadian_checklist_json);
      const tempatWaktu = Utils.safeJsonParse(data.tempat_waktu);
      const konteks = Utils.safeJsonParse(data.konteks);

      kejadian.forEach((item, index) => {
        $(`#kejadian_teramati_${index}`).val(item.kejadian || '');
      });

      tempatWaktu.forEach((item, index) => {
        $(`#tempat_waktu_${index}`).val(item.tempat_waktu || '');
      });

      konteks.forEach((item, index) => {
        $(`#konteks_${index}`).val(item.konteks || '');
      });
    },

    // Populate foto berseri
    populateFotoBerseri(data) {
      for (let i = 1; i <= 3; i++) {
        const fotoKey = `foto${i}`;
        const ketKey = `ket_foto${i}`;

        if (data[fotoKey]) {
          DOM.previews[fotoKey].attr('src', CONFIG.uploadPath + data[fotoKey]);
          $(`#preview_container_${i}`).show();
        }

        $(`#foto_ket${i}`).val(data[ketKey] || '');
      }

      $('#foto_umpan_balik').val(data.umpan_balik || '');
    },

    // Populate hasil karya
    populateHasilKarya(data) {
      $('#kegiatan_hasil_karya').val(data.kegiatan || '');

      if (data.foto_hk) {
        DOM.previews.fotoHK.attr('src', CONFIG.uploadPath + data.foto_hk);
        $('#preview_container_hk').show();
      }
    },

    // Populate anekdot
    populateAnekdot(data) {
      $('#anekdot_tempat').val(data.tempat || '');
      $('#anekdot_peristiwa').val(data.peristiwa || '');
    },

    // Submit form (manual)
    async submit(e) {
      e.preventDefault();

      // Cek apakah ada santri yang dipilih
      if (!DOM.hiddenSantriId.val()) {
        Utils.showError('Silakan pilih santri terlebih dahulu');
        return;
      }

      const collectedData = DataCollector.collectAll();
      const formData = new FormData(DOM.formElement[0]);

      console.log('=== SUBMIT DEBUG ===');
      console.log('Collected Data:', collectedData);
      console.log('Penilaian JSON:', JSON.stringify(collectedData.penilaian));
      console.log('Kejadian JSON:', JSON.stringify(collectedData.kejadian));
      console.log('Konteks JSON:', JSON.stringify(collectedData.konteks));
      console.log('Tempat Waktu JSON:', JSON.stringify(collectedData.tempatWaktu));

      // Append JSON data
      formData.append('penilaian_data_json', JSON.stringify(collectedData.penilaian));
      formData.append('kejadian_teramati_json', JSON.stringify(collectedData.kejadian));
      formData.append('konteks_json', JSON.stringify(collectedData.konteks));
      formData.append('tempat_waktu_json', JSON.stringify(collectedData.tempatWaktu));
      formData.append('manual_save', 'true'); // Flag untuk manual save

      const $btn = $('#btnSimpanFloating');
      const originalHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="ri-loader-4-line"></i>');

      try {
        const response = await fetch(CONFIG.baseUrl + CONFIG.endpoints.simpan, {
          method: 'POST',
          body: formData
        });

        const result = await response.json();
        console.log('Server response:', result);

        if (response.ok && result.message) {
          let detail = '';
          if (result.penilaianDisimpan && Array.isArray(result.penilaianDisimpan)) {
            detail = 'Bagian yang tersimpan: ' + result.penilaianDisimpan.join(' - ');
          }

          Utils.showSuccess(result.message, detail);

          // Update last saved data
          AutoSaveManager.lastSavedData = collectedData;
        } else {
          Utils.showError(result.message || 'Terjadi kesalahan saat menyimpan');
        }

      } catch (error) {
        console.error('Submit error:', error);
        Utils.showError('Terjadi kesalahan saat menyimpan data');
      } finally {
        $btn.prop('disabled', false).html(originalHtml);
      }
    }
  };

  // =====================================================
  // IMAGE PREVIEW HANDLER
  // =====================================================
  const ImagePreview = {
    // Initialize image preview handlers
    init() {
      $('.image-upload').off('change').on('change', this.handleImageChange);
    },

    // Handle image change
    handleImageChange(e) {
      const file = e.target.files[0];
      const inputId = e.target.id;

      // Ambil ID preview berdasarkan input ID
      let previewId, containerId;
      if (inputId === 'foto_hasil_karya_input') {
        previewId = 'thumb_hk';
        containerId = 'preview_container_hk';
      } else if (inputId.startsWith('foto_')) {
        const num = inputId.match(/\d+/)[0];
        previewId = `thumb_${num}`;
        containerId = `preview_container_${num}`;
      }

      const $preview = $(`#${previewId}`);
      const $container = $(`#${containerId}`);

      if (!file) {
        $container.hide();
        return;
      }

      // Validate image
      const validation = Utils.validateImage(file);
      if (!validation.valid) {
        Utils.showError(validation.message);
        e.target.value = '';
        $container.hide();
        return;
      }

      // Read and preview
      const reader = new FileReader();
      reader.onload = function(event) {
        $preview.attr('src', event.target.result);
        $container.show();
      };
      reader.readAsDataURL(file);
    }
  };

  // =====================================================
  // SANTRI SELECT HANDLER
  // =====================================================
  const SantriHandler = {
    // Initialize santri handler
    init() {
      // Change event untuk hidden input
      DOM.santriId.off('change').on('change', this.handleChange.bind(this));
    },



    // Handle santri selection change
    async handleChange() {
      const santriId = DOM.santriId.val();
      const previousSantriId = DOM.hiddenSantriId.val();

      // Jika ada santri sebelumnya dan berbeda dengan yang baru dipilih
      if (previousSantriId && previousSantriId !== santriId && previousSantriId !== '') {
        const hasChanges = this.checkForChanges();

        if (hasChanges) {
          // Konfirmasi auto save
          const result = await Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Ada perubahan data yang belum tersimpan untuk santri sebelumnya.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="ri-save-line me-1"></i>Ya, Simpan',
            cancelButtonText: 'Abaikan',
            confirmButtonColor: '#81c784',
            cancelButtonColor: '#718096',
            customClass: {
              container: 'swal-high-zindex'
            }
          });

          if (result.isConfirmed) {
            // Save data santri sebelumnya
            await AutoSaveManager.forceSave();
          }
        }
      }

      // Reset last saved data untuk santri baru
      AutoSaveManager.lastSavedData = null;
      AutoSaveManager.currentSantriId = santriId;

      // Reset form
      FormManager.reset();

      if (!santriId) {
        DOM.formPenilaian.hide();
        DOM.hiddenSantriId.val('');
        AutoSaveManager.currentSantriId = null;
        return;
      }

      // Set hidden santri ID
      DOM.hiddenSantriId.val(santriId);

      // Load data santri baru
      await FormManager.loadData(santriId);
    },

    // Check if there are unsaved changes
    checkForChanges() {
      // Collect current data
      const currentData = DataCollector.collectAll();

      // Check if any radio button is checked
      const hasRadioChecked = $('input[name^="penilaian_tp_"]:checked').length > 0;

      // Check if any text field has value
      const hasTextValue =
        $('.kejadian-input').filter(function() {
          return $(this).val().trim() !== '';
        }).length > 0 ||
        $('.konteks-input').filter(function() {
          return $(this).val().trim() !== '';
        }).length > 0 ||
        $('.tempat_waktu-input').filter(function() {
          return $(this).val().trim() !== '';
        }).length > 0 ||
        $('#kegiatan_hasil_karya').val().trim() !== '' ||
        $('#anekdot_tempat').val().trim() !== '' ||
        $('#anekdot_peristiwa').val().trim() !== '' ||
        $('#foto_umpan_balik').val().trim() !== '' ||
        $('#foto_ket1').val().trim() !== '' ||
        $('#foto_ket2').val().trim() !== '' ||
        $('#foto_ket3').val().trim() !== '';

      // Check if any file is uploaded
      const hasFileUploaded =
        $('#foto_hasil_karya_input').val() !== '' ||
        $('#foto_1_input').val() !== '' ||
        $('#foto_2_input').val() !== '' ||
        $('#foto_3_input').val() !== '';

      // Check hasil karya catatan
      let hasHasilKaryaCatatan = false;
      $('textarea[name^="hasil_karya_catatan"]').each(function() {
        if ($(this).val().trim() !== '') {
          hasHasilKaryaCatatan = true;
          return false; // break
        }
      });

      // Check foto analisis
      let hasFotoAnalisis = false;
      $('textarea[name^="foto_analisis"]').each(function() {
        if ($(this).val().trim() !== '') {
          hasFotoAnalisis = true;
          return false; // break
        }
      });

      // Check anekdot keterangan
      let hasAnekdotKeterangan = false;
      $('textarea[name^="anekdot_keterangan"]').each(function() {
        if ($(this).val().trim() !== '') {
          hasAnekdotKeterangan = true;
          return false; // break
        }
      });

      return hasRadioChecked || hasTextValue || hasFileUploaded ||
        hasHasilKaryaCatatan || hasFotoAnalisis || hasAnekdotKeterangan;
    }
  };


  // =====================================================
  // REMOVE PREVIEW HANDLER
  // =====================================================
  function removePreview(inputId, previewId, containerId) {
    // Reset input file
    $(`#${inputId}`).val('');

    // Hide preview container
    $(`#${containerId}`).hide();

    // Clear preview image src
    $(`#${previewId}`).attr('src', '');
  }

  // =====================================================
  // INITIALIZATION
  // =====================================================
  $(document).ready(function() {
    // Initialize DOM cache
    DOM.init();

    // Initialize Santri Modal Manager
    SantriModalManager.init();

    // Initialize Auto Save Manager
    AutoSaveManager.init();

    // PENTING: Ambil data dari PHP dan initialize ChecklistRenderer
    // Data ini harus sudah ada dari script tag di HTML sebelum script ini
    if (typeof tujuanPembelajaranData !== 'undefined') {
      ChecklistRenderer.init(tujuanPembelajaranData);
      ChecklistRenderer.render();
    } else {
      console.error('tujuanPembelajaranData is not defined. Make sure the data is loaded from PHP.');
      DOM.checklistContainer.html(
        '<div class="alert alert-danger"><i class="ri-error-warning-line me-2"></i>Gagal memuat data tujuan pembelajaran. Silakan refresh halaman.</div>'
      );
    }

    // Initialize handlers
    SantriHandler.init();
    ImagePreview.init();

    // Form submit handler
    DOM.formElement.off('submit').on('submit', FormManager.submit.bind(FormManager));

    console.log('Form Penilaian initialized successfully');
  });
</script>