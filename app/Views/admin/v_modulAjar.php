<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css" />

<style>
  canvas {
    position: relative;
    z-index: 0 !important;
  }

  /* ============================================
           LOADING OVERLAY
        ============================================ */
  #loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    z-index: 9999;
    display: none;
  }

  /* ============================================
     MODAL TEMPLATE PEMANTIK
============================================ */
  #modalTemplatePemantik {
    z-index: 1200;
    /* Lebih tinggi dari modal tujuan */
  }

  .template-pemantik-item {
    cursor: pointer;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
    padding: 1rem;
  }

  .template-pemantik-item:hover {
    background-color: #f8f9fa;
    border-left-color: #17a2b8;
    transform: translateX(5px);
  }

  .template-pemantik-item .template-text {
    font-size: 0.95rem;
    color: #2d3748;
    line-height: 1.5;
  }

  .btn-template-pemantik {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
  }

  .btn-template-pemantik:hover {
    background-color: #17a2b8;
    color: white;
    border-color: #17a2b8;
  }

  /* ============================================
     MODAL TUJUAN PEMBELAJARAN
============================================ */
  #modalPilihTujuan {
    /* z-index: 1300; */
    /* Lebih tinggi dari offcanvas */
  }

  #modalPilihTujuan .modal-backdrop {
    /* z-index: 5000; */
  }


  /* Backdrop modal lebih tinggi dari offcanvas */
  .modal-backdrop.show {
    position: fixed !important;
    z-index: 2000 !important;
    transform: translateZ(0);
  }

  /* Modal di atas backdrop */
  .modal.show {
    z-index: 2050 !important;
  }

  /* Offcanvas dan backdrop-nya tetap di bawah modal */
  .offcanvas {
    z-index: 1090 !important;
  }

  .offcanvas-backdrop.show {
    z-index: 1080 !important;
  }

  .tujuan-list-item {
    cursor: pointer;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
  }

  .tujuan-list-item:hover {
    background-color: #f8f9fa;
    border-left-color: #0d6efd;
    transform: translateX(5px);
  }

  .tujuan-list-item.selected {
    background-color: #e7f3ff;
    border-left-color: #0d6efd;
  }

  .tujuan-badge {
    background-color: #e9ecef;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    color: #6c757d;
  }

  /* Custom input untuk tujuan pembelajaran */
  .tujuan-custom-input {
    position: relative;
  }

  .tujuan-custom-input .form-control {
    cursor: pointer;
    background-color: #fff;
    padding-right: 40px;
  }

  .tujuan-custom-input .clear-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #dc3545;
    display: none;
  }

  .tujuan-custom-input.has-value .clear-btn {
    display: block;
  }

  /* ============================================
           SELECT2 CUSTOMIZATION
        ============================================ */
  .select2-container .select2-selection--single {
    height: calc(1.5em + .75rem + 2px) !important;
    padding: .375rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    border: 1px solid #ced4da;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: calc(1.5em + .75rem + 2px);
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5;
  }


  /* ============================================
           PROGRESS BAR
        ============================================ */
  #progressContainer {
    width: 100%;
    background: #e9ecef;
    margin-top: 10px;
    border-radius: 4px;
    overflow: hidden;
  }

  #progressBar {
    width: 0%;
    height: 24px;
    background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    text-align: center;
    color: white;
    line-height: 24px;
    transition: width 0.3s ease;
  }

  /* ============================================
           OFFCANVAS OPTIMIZATION
        ============================================ */
  .offcanvas-floating-submit-container {
    position: fixed !important;
    bottom: 0 !important;
    left: auto !important;
    right: 0 !important;
    width: calc(700px - 15px) !important;
    /* Kurangi width untuk scrollbar */
    max-width: calc(100vw - 15px) !important;
    /* Responsive juga dikurangi */
    margin-right: 15px !important;
    /* Atau bisa pakai margin */
    padding: 1rem 1.5rem 0.75rem 1.5rem !important;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(197, 197, 255, 1) 20%) !important;
    border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
    display: flex !important;
    justify-content: flex-end !important;
    align-items: center !important;
    z-index: 1100 !important;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.08) !important;
    gap: 0.75rem !important;
    border-radius: 0 !important;
  }

  /* Pastikan offcanvas body ada ruang */
  .offcanvas-body {
    overflow-y: auto !important;
    padding-bottom: 100px !important;
    /* Beri ruang untuk button */
    position: relative !important;
  }

  /* Button styles tetap sama */
  .offcanvas-floating-submit-container .btn {
    min-width: 100px !important;
    padding: 0.625rem 1.25rem !important;
    border-radius: 0.5rem !important;
    font-weight: 600 !important;
    transition: all 0.2s ease-in-out !important;
  }

  .offcanvas-floating-submit-container .btn-primary:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3) !important;
  }

  .offcanvas-floating-submit-container .btn-label-secondary {
    margin-right: auto !important;
    background-color: #fff !important;
    border: 1px solid #6c757d !important;
  }

  .offcanvas-floating-submit-container .btn-label-secondary:hover {
    background-color: #f8f9fa !important;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .offcanvas-floating-submit-container {
      width: 100vw !important;
      left: 0 !important;
      right: 0 !important;
      padding: 1rem !important;
    }

    .offcanvas-body {
      padding-bottom: 120px !important;
    }
  }

  /* ============================================
     SWEETALERT Z-INDEX FIX
============================================ */
  .swal2-container {
    z-index: 1100 !important;
    /* Lebih tinggi dari offcanvas (1090) */
  }

  .swal2-backdrop-show {
    z-index: 1095 !important;
  }


  /* ============================================
           FORM SECTIONS
        ============================================ */
  .form-section {
    margin-bottom: 2rem;
  }

  .divider {
    margin: 2rem 0 1.5rem;
  }

  .divider-text {
    font-weight: 600;
    font-size: 1.1rem;
    color: #495057;
  }

  /* ============================================
           DYNAMIC INPUT GROUPS
        ============================================ */
  .input-group {
    margin-bottom: 0.75rem;
  }

  .input-group .btn {
    border-radius: 0.25rem;
  }

  .input-group .form-control {
    border-right: none;
  }

  /* ============================================
           BADGE & LABELS
        ============================================ */
  .selected-info {
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  .badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
  }

  /* ============================================
           RESPONSIVE ADJUSTMENTS
        ============================================ */
  @media (max-width: 768px) {
    .offcanvas-end {
      width: 100% !important;
    }

    .col-sm-10,
    .col-sm-2 {
      flex: 0 0 100%;
      max-width: 100%;
    }

    .input-group {
      flex-wrap: wrap;
    }
  }

  /* ============================================
           CARD IMPROVEMENTS
        ============================================ */
  .card {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .card-body {
    padding: 1.5rem;
  }

  /* ============================================
           TABLE IMPROVEMENTS
        ============================================ */
  .table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
  }

  #table-modulajar {
    font-size: 0.925rem;
  }

  #table-modulajar thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
  }

  /* ============================================
           BUTTON IMPROVEMENTS
        ============================================ */
  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
  }

  .btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
  }

  .btn-success {
    background-color: #28a745;
    border-color: #28a745;
  }

  .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
  }

  /* ============================================
           DYNAMIC INPUT CARD STYLING
        ============================================ */
  .card.border {
    border: 1px solid #dee2e6 !important;
    transition: all 0.2s ease;
  }

  .card.border:hover {
    border-color: #adb5bd !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .selected-display .alert-info {
    background-color: #e7f3ff;
    border-color: #b6d4fe;
    color: #084298;
  }

  .btn-edit-select {
    text-decoration: none !important;
  }

  .btn-edit-select:hover {
    transform: scale(1.1);
  }

  /* Improve select dropdown in cards */
  .card .form-select-sm {
    font-size: 0.875rem;
  }

  /* Better label spacing */
  .card-body .form-label.small {
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
  }
</style>
<!-- ============================================
     DOWNLOAD SECTION
============================================ -->
<!-- <div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body"> -->

<!-- <form id="generate-pdf-form" action="<?= base_url('asesmen/downloadlaporan') ?>" method="get" class="row g-3 align-items-center">
          <div class="col-auto">
            <label for="bulan" class="col-form-label fw-semibold">
              Download Penilaian Bulanan:
            </label>
          </div>
          <div class="col-auto">
            <select name="bulan" id="bulan" class="form-select">
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary" id="download-button">
              <i class="ri-download-line"></i> Download Laporan
              <span id="loading-spinner" class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true" style="display: none;"></span>
            </button>
          </div>
        </form> -->

<!-- <li class="menu-item <?= ($nav == 'laporan_bulanan') ? 'active' : '' ?>">
          <a href="<?= base_url('laporan-bulanan') ?>" class="menu-link">
            <i class="menu-icon tf-icons ri-file-list-line"></i>
            <div>Laporan Bulanan</div>
          </a>
        </li> -->

<!-- </div>
    </div>
  </div>
</div> -->

<!-- Loading Overlay -->
<div id="loading-overlay">
  <div class="d-flex justify-content-center align-items-center h-100">
    <div class="text-center">
      <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted">Sedang memproses...</p>
    </div>
  </div>
</div>

<!-- ============================================
     DATA TABLE SECTION
============================================ -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <?php if ((array_intersect(['4'], session('roles')) && !empty(session('kelas_id'))) ||
          (array_intersect(['3'], session('roles')))
        ) : ?>

          <!-- Header Actions -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Data Modul Ajar</h5>
            <button type="button" id="btn-tambah-modulajar" class="btn btn-success">
              <i class="ri-add-line"></i> Tambah Data
            </button>
          </div>

          <!-- DataTable -->
          <div class="table-responsive">
            <table id="table-modulajar" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tanggal</th>
                  <th>Semester</th>
                  <th>Pekan</th>
                  <th>Tema</th>
                  <th>Topik</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-warning text-center" role="alert">
            <i class="ri-information-line"></i> Silakan pilih kelas terlebih dahulu
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- ============================================
     DELETE MODAL
============================================ -->
<div class="modal fade" id="Delmodalmodulajar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-delete-bin-line text-danger"></i> Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="delmodulajar">
          <input type="hidden" id="delID" name="delIdmodulajar">

          <div class="alert alert-warning" role="alert">
            <p class="mb-2">Apakah Anda yakin ingin menghapus data ini?</p>
            <h6 id="delNama" class="mb-0 fw-bold"></h6>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="ri-close-line"></i> Batal
            </button>
            <button type="button" class="btn btn-danger" id="btn-hapus-modulajar">
              <i class="ri-delete-bin-line"></i> Ya, Hapus!
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- ============================================
     MODAL PILIH TUJUAN PEMBELAJARAN
============================================ -->
<div class="modal fade" id="modalPilihTujuan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-target-line"></i> Pilih Tujuan Pembelajaran
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Search Box -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text">
              <i class="ri-search-line"></i>
            </span>
            <input type="text"
              id="searchTujuanInput"
              class="form-control"
              placeholder="Cari tujuan pembelajaran...">
          </div>
        </div>

        <!-- Loading Indicator -->
        <div id="tujuanLoadingIndicator" class="text-center py-4" style="display: none;">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="text-muted mt-2">Memuat data...</p>
        </div>

        <!-- List Tujuan Pembelajaran -->
        <div id="tujuanListContainer" class="list-group" style="max-height: 400px; overflow-y: auto;">
          <!-- Items akan di-generate via JavaScript -->
        </div>

        <!-- No Results -->
        <div id="tujuanNoResults" class="alert alert-info text-center" style="display: none;">
          <i class="ri-information-line"></i> Tidak ada hasil ditemukan
        </div>

        <!-- Pagination -->
        <div id="tujuanPagination" class="d-flex justify-content-between align-items-center mt-3" style="display: none !important;">
          <button type="button" class="btn btn-sm btn-outline-secondary" id="btnPrevTujuan">
            <i class="ri-arrow-left-line"></i> Sebelumnya
          </button>
          <span id="tujuanPageInfo" class="text-muted">Halaman 1</span>
          <button type="button" class="btn btn-sm btn-outline-secondary" id="btnNextTujuan">
            Selanjutnya <i class="ri-arrow-right-line"></i>
          </button>
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

<!-- ============================================
     MODAL TEMPLATE KATA PEMANTIK
============================================ -->
<div class="modal fade" id="modalTemplatePemantik" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-question-line"></i> Pilih Template Kata Pemantik
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Search Box -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text">
              <i class="ri-search-line"></i>
            </span>
            <input type="text"
              id="searchTemplatePemantikInput"
              class="form-control"
              placeholder="Cari template...">
          </div>
        </div>

        <!-- List Template -->
        <div id="templatePemantikListContainer" class="list-group" style="max-height: 450px; overflow-y: auto;">
          <!-- Items generated by JavaScript -->
        </div>

        <!-- No Results -->
        <div id="templatePemantikNoResults" class="alert alert-info text-center" style="display: none;">
          <i class="ri-information-line"></i> Tidak ada template ditemukan
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


<!-- ============================================
     OFFCANVAS FORM
============================================ -->
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" style="max-width: 100vw; width: 700px; z-index: 1090;" tabindex="-1" id="modalmodulajar">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="modalTitle-modulajar">Tambah Modul Ajar</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body" style="--bs-offcanvas-padding-x: 0rem">
    <form id="dataForm-modulajar" enctype="multipart/form-data">
      <div style="padding: 1.5rem">

        <!-- Hidden ID -->
        <input type="hidden" id="id" name="id">

        <!-- ============================================
                     BASIC INFORMATION
                ============================================ -->
        <div class="form-section">
          <div class="row g-3">
            <div class="col-12">
              <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
              <input type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Pilih tanggal">
            </div>

            <div class="col-md-6">
              <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
              <input type="text" id="semester" name="semester" class="form-control" value="<?= session('semester') ?>" readonly>
            </div>

            <div class="col-md-6">
              <label for="pekan" class="form-label">Pekan <span class="text-danger">*</span></label>
              <select id="pekan" name="pekan" class="form-select">
                <?php for ($i = 1; $i <= 17; $i++) : ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="col-12">
              <label for="model_pembelajaran" class="form-label">Model Pembelajaran <span class="text-danger">*</span></label>
              <select id="model_pembelajaran" name="model_pembelajaran" class="form-select">
                <option value="Luring" selected>Luring</option>
                <option value="Daring">Daring</option>
              </select>
            </div>

            <div class="col-12">
              <label for="topik_pembelajaran" class="form-label">Topik Pembelajaran <span class="text-danger">*</span></label>
              <input type="text" id="topik_pembelajaran" name="topik_pembelajaran" class="form-control" placeholder="Masukkan topik pembelajaran">
            </div>

            <div class="col-12">
              <label for="subtopik_pembelajaran" class="form-label">Sub Topik Pembelajaran <span class="text-danger">*</span></label>
              <input type="text" id="subtopik_pembelajaran" name="subtopik_pembelajaran" class="form-control" placeholder="Masukkan sub topik">
            </div>
          </div>
        </div>

        <!-- ============================================
                     TUJUAN PEMBELAJARAN
                ============================================ -->
        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-target-line"></i> Tujuan Pembelajaran
          </div>
        </div>

        <input type="hidden" name="tujuan_pembelajaran_json" id="tujuan_pembelajaran_json">

        <div id="tujuan-container" class="mb-3">
          <!-- Items akan di-generate dinamis -->
        </div>

        <button type="button" id="add-tujuan" class="btn btn-outline-primary w-100">
          <i class="ri-add-line"></i> Tambah Tujuan Pembelajaran
        </button>

        <!-- ============================================
                     DIMENSI PROFIL LULUSAN
                ============================================ -->
        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-user-star-line"></i> Dimensi Profil Lulusan
          </div>
        </div>

        <input type="hidden" name="dimensi_profil_lulusan_json" id="dimensi_profil_lulusan_json">

        <div id="dimensi-container" class="mb-3">
          <div class="row mb-2 dimensi-item">
            <div class="col-sm-10">
              <select id="dimensi" name="dimensi_profil_lulusan[]" class="form-control dimensi-select">
                <option value="">Loading...</option>
              </select>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-danger w-100 btn-remove">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
          </div>
        </div>
        <button type="button" id="add-dimensi" class="btn btn-outline-primary w-100">
          <i class="ri-add-line"></i> Tambah Dimensi
        </button>

        <!-- ============================================
                     KURIKULUM BERBASIS CINTA
                ============================================ -->
        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-heart-line"></i> Kurikulum Berbasis Cinta
          </div>
        </div>

        <input type="hidden" name="kurikulum_cinta_json" id="kurikulum_cinta_json">

        <div id="kurikulumcinta-container" class="mb-3">
          <div class="row mb-2 kurikulumcinta-item">
            <div class="col-sm-10">
              <select id="kurikulumcinta" name="kurikulum_cinta[]" class="form-control kurikulumcinta-select">
                <option value="">Loading...</option>
              </select>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-danger w-100 btn-remove">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
          </div>
        </div>
        <button type="button" id="add-kurikulumcinta" class="btn btn-outline-primary w-100">
          <i class="ri-add-line"></i> Tambah Kurikulum
        </button>

        <!-- ============================================
                     PRAKTIK PEDAGOGIK
                ============================================ -->
        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-book-open-line"></i> Praktik Pedagogik
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12">
            <label for="model_praktik_pedagogik" class="form-label">Model</label>
            <input type="text" id="model_praktik_pedagogik" name="model_praktik_pedagogik" class="form-control" placeholder="Masukkan model pedagogik">
          </div>
          <div class="col-12">
            <label for="strategi_praktik_pedagogik" class="form-label">Strategi</label>
            <input type="text" id="strategi_praktik_pedagogik" name="strategi_praktik_pedagogik" class="form-control" placeholder="Masukkan strategi">
          </div>
          <div class="col-12">
            <label for="metode_praktik_pedagogik" class="form-label">Metode</label>
            <input type="text" id="metode_praktik_pedagogik" name="metode_praktik_pedagogik" class="form-control" placeholder="Masukkan metode">
          </div>
        </div>

        <!-- ============================================
                     KEMITRAAN & LINGKUNGAN
                ============================================ -->
        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-team-line"></i> Kemitraan
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12">
            <label for="kemitraaan_pembelajaran" class="form-label">Kemitraan Pembelajaran</label>
            <textarea id="kemitraaan_pembelajaran"
              name="kemitraaan_pembelajaran"
              class="form-control"
              rows="3"
              placeholder="Masukkan kemitraan pembelajaran&#10;Tekan Enter untuk baris baru"></textarea>
            <small class="text-muted">
              <i class="ri-information-line"></i> Tekan Enter untuk membuat baris baru
            </small>
          </div>

        </div>

        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-team-line"></i> Lingkungan Pembelajaran
          </div>
        </div>

        <div class="row g-3">
          <div class="col-12">
            <label for="lingkungan_pembelajaran_ruang_fisik" class="form-label">Ruang Fisik</label>
            <input type="text" id="lingkungan_pembelajaran_ruang_fisik" name="lingkungan_pembelajaran_ruang_fisik" class="form-control" placeholder="Contoh: Kelas, Lab">
          </div>
          <div class="col-12">
            <label for="lingkungan_pembelajaran_ruang_virtual" class="form-label">Ruang Virtual</label>
            <input type="text" id="lingkungan_pembelajaran_ruang_virtual" name="lingkungan_pembelajaran_ruang_virtual" class="form-control" placeholder="Contoh: Google Classroom">
          </div>
        </div>

        <!-- ============================================
                     PEMANFAATAN DIGITAL
                ============================================ -->
        <div class="divider divider-primary">
          <div class="divider-text">
            <i class="ri-smartphone-line"></i> Pemanfaatan Digital
          </div>
        </div>

        <div class="mb-3">
          <label for="pemanfaatan_digital" class="form-label">Platform/Aplikasi Digital</label>
          <textarea id="pemanfaatan_digital"
            name="pemanfaatan_digital"
            class="form-control"
            rows="3"
            placeholder="Contoh: Kahoot, Quizizz&#10;Tekan Enter untuk baris baru"></textarea>
          <small class="text-muted">
            <i class="ri-information-line"></i> Tekan Enter untuk membuat baris baru
          </small>
        </div>

        <!-- ============================================
                     KEGIATAN HARIAN (5 HARI)
                ============================================ -->
        <?php
        $days = 5;
        $sections = ['pemantik', 'pembukaan', 'inti'];
        $maxValues = [
          'pemantik' => 9,
          'pembukaan' => 9,
          'inti' => 9,
          // 'merefleksi' => 9
        ];

        for ($day = 1; $day <= $days; $day++) :
        ?>
          <div class="divider divider-primary">
            <div class="divider-text">
              <i class="ri-calendar-line"></i> Hari Ke-<?= $day ?>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-12">
              <label for="subsubtopik<?= $day ?>" class="form-label">Sub Sub Topik <span class="text-danger">*</span></label>
              <input type="text" id="subsubtopik<?= $day ?>" name="subsubtopik<?= $day ?>" class="form-control" placeholder="Masukkan sub sub topik">
            </div>
            <div class="col-12">
              <label for="tgl_subsubtopik<?= $day ?>" class="form-label">Tanggal <span class="text-danger">*</span></label>
              <input type="text" id="tgl_subsubtopik<?= $day ?>" name="tgl_subsubtopik<?= $day ?>" class="form-control" placeholder="Pilih tanggal">
            </div>
            <div class="col-12">
              <label for="alatbahan<?= $day ?>" class="form-label">Alat dan Bahan</label>
              <input type="text" id="alatbahan<?= $day ?>" name="alatbahan<?= $day ?>" class="form-control" placeholder="Contoh: Papan tulis, spidol">
            </div>
          </div>

          <?php foreach ($sections as $section) : ?>
            <div class="mb-4">
              <h6 class="text-uppercase fw-semibold text-muted mb-2">
                <?= ucfirst($section) ?>
                <small class="text-muted">(Maks. <?= $maxValues[$section] ?>)</small>
              </h6>
              <div id="<?= $section ?>-wrapper-<?= $day ?>" class="mb-2"></div>
              <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="add-<?= $section ?>-<?= $day ?>">
                <i class="ri-add-line"></i> Tambah <?= ucfirst($section) ?>
              </button>
            </div>

            <input type="hidden" name="<?= $section ?>_json_<?= $day ?>" id="<?= $section ?>_json_<?= $day ?>">
          <?php endforeach; ?>

          <?php foreach (['pembukaan', 'inti', 'merefleksi'] as $section) : ?>
            <input type="hidden" name="<?= $section ?>_select_json_<?= $day ?>" id="<?= $section ?>_select_json_<?= $day ?>">
          <?php endforeach; ?>
        <?php endfor; ?>

      </div>

      <!-- Floating Submit Buttons -->
      <!-- Update floating submit container -->
      <!-- Floating Submit Buttons - TETAP SEPERTI ASLI -->
      <div class="offcanvas-floating-submit-container" style="bottom: 0px; position: fixed;">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">
          <i class="ri-close-line"></i> Tutup
        </button>
        <button type="submit" class="btn btn-primary" id="btn-simpan-modulajar">
          <i class="ri-save-line"></i> Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Progress Bar Container (Hidden by default) -->
<div id="progressContainer" style="display: none;">
  <div id="progressBar">0%</div>
</div>



<!-- jQuery & DataTables JS -->

<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/just-validate@4.2.0/dist/just-validate.production.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

<script>
  const CURRENT_USER_ID = "<?= session('user_id'); ?>";
  // =====================================================
  // KONFIGURASI & KONSTANTA
  // =====================================================
  const CONFIG = {
    maxPembukaan: 9,
    maxInti: 9,
    maxPemantik: 9,
    maxRefleksi: 9,
    maxTujuan: 7,
    days: 5,
    baseUrl: '<?php echo base_url(); ?>',
    endpoints: {
      simpan: 'modulajar/simpandata',
      ubah: 'modulajar/ubahdata',
      hapus: 'modulajar/hapusdata_soft',
      ambilData: 'modulajar/ambil_data_modulajar',
      ambilTP: 'modulajar/ambil_data_tp',
      ambilTexts: 'modulajar/ambil_selected_texts',
      ambilDimensi: 'modulajar/ambil_data_dimensi',
      ambilKurikulum: 'modulajar/ambil_data_kurikulum',
      ambilSelect: 'modulajar/get_data_select_dpl_kbc',
      download: 'modulajar/download'
    }
  };

  // =====================================================
  // DEFAULT VALUES
  // =====================================================
  const DEFAULT_VALUES = {
    pembukaan: [
      'Baris dan murojaah Asmaul Husna',
      'Salam',
      'Doa dan Dzikir Pagi',
      "Muroja'ah",
      'Tahfidz QS. Ath-Thariq ayat 5–7',
      'Bercakap-cakap tentang bagian-bagian akar',
      'Menjelaskan aturan bermain sambil belajar'
    ]
  };

  const TEMPLATES = {
    kata_pemantik: [
      "Lihat, ada apa di luar sana?",
      "Apa saja yang bisa kamu lihat di kebun?",
      "Bagaimana suara burung?",
      "Apa yang bisa kamu lakukan untuk menjaga kebersihan?",
      "Apa yang bisa kamu lakukan untuk membantu teman?",
      "Benda apa ini? (menunjukkan suatu benda)",
      "Benda ini terbuat dari apa?",
      "Benda ini bisa digunakan untuk apa?",
      "Benda apa yang paling kamu suka?",
      "Benda apa yang bisa kita temukan di dapur?",
      "Apa yang sedang kamu lakukan?",
      "Bagaimana perasaanmu saat ini?",
      "Apa yang ingin kamu lakukan hari ini?",
      "Apa yang ingin kamu pelajari hari ini?",
      "Bisakah kamu ceritakan apa yang kamu lakukan tadi pagi?",
      "Lihatlah gambar/benda ini! Apa saja yang kamu temukan?",
      "Bagaimana bentuk bunga ini?",
      "Benda apa saja yang berwarna merah di sekitar kita?",
      "Bagaimana suara hewan ini?",
      "Menurutmu, mengapa sapi memiliki empat kaki?",
      "Apa yang akan terjadi jika kita tidak menyirami tanaman setiap hari?",
      "Mengapa ada bagian sedotan yang terlihat bengkok saat dimasukkan ke air?",
      "Bagaimana perasaanmu saat membuat sesuatu yang baru?",
      "Apa yang kamu rasakan saat bermain dengan teman?",
      "Pernahkah kamu melihat hal yang mirip dengan ini?",
      "Jika kamu bisa terbang, ke mana saja yang ingin kamu tuju?",
      "Bagaimana jika boneka ini bisa berbicara? Apa yang akan dia katakan?",
      "Bayangkan kamu adalah seorang pahlawan super, apa kekuatanmu dan untuk apa kamu gunakan?",
      "Apa gunanya benda ini dalam kegiatan sehari-hari kita?",
      "Bagaimana kita membantu Ibu di rumah?",
      "Apa yang kita lakukan saat makan bersama keluarga?"
    ]
  };

  // =====================================================
  // CACHE & STATE MANAGEMENT
  // =====================================================
  const Cache = {
    dimensi: null,
    kurikulum: null,
    selectedData: {}
  };

  const State = {
    isValidasi: false,
    currentAction: 'add',
    parsedData: {}
  };

  // =====================================================
  // UTILITY FUNCTIONS
  // =====================================================
  const Utils = {
    // Escape HTML untuk mencegah XSS
    escapeHtml(text) {
      if (!text) return '';
      const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      };
      return text.toString().replace(/[&<>"']/g, m => map[m]);
    },

    // Parse JSON dengan aman
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

    // Debounce function
    debounce(func, wait) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    },

    // Generate unique ID
    generateUniqueId(prefix = 'id') {
      return `${prefix}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    }
  };

  // =====================================================
  // SWAL HELPER
  // =====================================================
  const SwalHelper = {
    loading(title = 'Memuat data...', text = 'Mohon tunggu sebentar.') {
      Swal.fire({
        title,
        text,
        allowOutsideClick: false,
        customClass: {
          container: 'swal-high-zindex' // Tambahkan custom class
        },
        didOpen: () => Swal.showLoading()
      });
    },

    success(message, title = 'Berhasil') {
      Swal.fire({
        icon: 'success',
        title,
        text: message,
        timer: 2000,
        showConfirmButton: false
      });
    },

    error(message, title = 'Error') {
      Swal.fire({
        icon: 'error',
        title,
        text: message,
        customClass: {
          container: 'swal-high-zindex' // Tambahkan custom class
        },
      });
    },

    close() {
      Swal.close();
    }
  };

  // =====================================================
  // API SERVICE
  // =====================================================
  const ApiService = {
    async get(endpoint, data = {}) {
      try {
        const response = await $.ajax({
          url: CONFIG.baseUrl + endpoint,
          method: 'GET',
          data,
          dataType: 'json'
        });
        return {
          success: true,
          data: response
        };
      } catch (error) {
        console.error(`API Error [${endpoint}]:`, error);
        return {
          success: false,
          error
        };
      }
    },

    async post(endpoint, formData, options = {}) {
      try {
        const response = await $.ajax({
          url: CONFIG.baseUrl + endpoint,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          ...options
        });
        return {
          success: true,
          data: response
        };
      } catch (error) {
        console.error(`API Error [${endpoint}]:`, error);
        return {
          success: false,
          error
        };
      }
    },

    // Fetch dengan cache
    async getCached(key, endpoint, data = {}) {
      if (Cache[key]) {
        return {
          success: true,
          data: Cache[key]
        };
      }

      const result = await this.get(endpoint, data);
      if (result.success) {
        Cache[key] = result.data;
      }
      return result;
    }
  };

  // =====================================================
  // SELECT2 MANAGER
  // =====================================================
  const Select2Manager = {
    // Inisialisasi Select2 untuk Tujuan Pembelajaran
    initTujuanPembelajaran($element, initialId = null, initialText = null) {
      if (!$element || $element.length === 0) {
        console.error('Element not found:', $element);
        return;
      }

      // Destroy jika sudah ada
      if ($element.hasClass('select2-hidden-accessible')) {
        $element.select2('destroy');
        $element.empty();
      }

      const initialData = initialId ? [{
        id: initialId,
        text: initialText || 'Memuat teks...'
      }] : [];

      $element.select2({
        placeholder: 'Pilih Tujuan Pembelajaran',
        allowClear: true,
        dropdownParent: $element.parent(),
        data: initialData,
        ajax: {
          url: CONFIG.baseUrl + CONFIG.endpoints.ambilTP,
          dataType: 'json',
          delay: 250,
          data: params => ({
            q: params.term,
            page: params.page
          }),
          processResults: (data, params) => {
            params.page = params.page || 1;
            return {
              results: data.results,
              pagination: {
                more: (params.page * 10) < data.total_count
              }
            };
          },
          cache: true
        },
        minimumInputLength: 0
      });

      // Fetch text jika hanya ID yang tersedia
      if (initialId && !initialText) {
        this.fetchAndSetText($element, initialId);
      } else if (initialId && initialText) {
        $element.empty().append(new Option(initialText, initialId, true, true));
        $element.val(initialId).trigger('change');
      }
    },

    // Fetch text dari server
    async fetchAndSetText($element, id) {
      const result = await ApiService.get(CONFIG.endpoints.ambilTexts, {
        ids: [id]
      });

      if (result.success && result.data.length > 0) {
        const {
          id: fetchedId,
          text: fetchedText
        } = result.data[0];
        $element.empty().append(new Option(fetchedText, fetchedId, true, true));
        $element.val(fetchedId).trigger('change');
      } else {
        console.warn('Text not found for ID:', id);
        $element.empty().append(new Option(`Teks tidak ditemukan (${id})`, id, true, true));
        $element.val(id).trigger('change');
      }
    },

    // Load dimensi
    async loadDimensi($select, selectedId = null) {
      const result = await ApiService.getCached('dimensi', CONFIG.endpoints.ambilDimensi);

      if (!result.success) {
        $select.html('<option value="">Gagal memuat data</option>');
        return;
      }

      let options = '<option value="">Pilih Dimensi</option>';
      result.data.forEach(item => {
        const isSelected = String(item.id) === String(selectedId);
        options += `<option value="${item.id}" ${isSelected ? 'selected' : ''}>${item.text}</option>`;
      });

      $select.html(options);
      if (selectedId) $select.val(String(selectedId));
    },

    // Load kurikulum
    async loadKurikulum($select, selectedId = null) {
      const result = await ApiService.getCached('kurikulum', CONFIG.endpoints.ambilKurikulum);

      if (!result.success) {
        $select.html('<option value="">Gagal memuat data</option>');
        return;
      }

      let options = '<option value="">Pilih Kurikulum</option>';
      result.data.forEach(item => {
        const isSelected = String(item.id) === String(selectedId);
        options += `<option value="${item.id}" ${isSelected ? 'selected' : ''}>${item.text}</option>`;
      });

      $select.html(options);
      if (selectedId) $select.val(String(selectedId));
    }
  };

  // =====================================================
  // DYNAMIC INPUT MANAGER
  // =====================================================
  const DynamicInputManager = {

    // Generate default pembukaan items
    generateDefaultPembukaan(wrapperId, inputName, dayNumber) {
      const $wrapper = $(`#${wrapperId}`);

      // Clear dulu jika ada
      $wrapper.empty();

      // Generate semua default items
      DEFAULT_VALUES.pembukaan.forEach((defaultValue, index) => {
        const uniqueId = Utils.generateUniqueId(`${inputName}-default-${index}`);
        const html = this.createInputGroupHtml(
          uniqueId,
          inputName,
          defaultValue,
          1, // useSelect = 1 (ada dropdown DPL/KBC)
          `pembukaan ${dayNumber}`
        );
        $wrapper.append(html);
      });
    },

    // Template HTML untuk input group
    // Template HTML untuk input group
    createInputGroupHtml(uniqueId, inputName, value, useSelect, placeholder, labelValue = '') {
      const escapedValue = Utils.escapeHtml(value);

      // Detect apakah ini input pemantik
      const isPemantik = inputName.includes('pemantik');

      let html = `
    <div class="card mb-3 border" id="input-group-${uniqueId}">
        <div class="card-body p-3">
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label small mb-0">Kegiatan:</label>
                    ${isPemantik ? `
                        <button type="button" class="btn btn-sm btn-outline-info btn-template-pemantik" 
                                data-input-id="input-${uniqueId}" 
                                title="Pilih dari template">
                            <i class="ri-file-list-line"></i> Template
                        </button>
                    ` : ''}
                </div>
                <input type="text" name="${inputName}[]" id="input-${uniqueId}" 
                    class="form-control" placeholder="Isian ${placeholder.replace(/_/g, ' ')}"
                    value="${escapedValue}">
            </div>`;

      if (useSelect !== 0) {
        html += `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label small mb-0">Pilih DPL/KBC:</label>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm btn-toggle-selectbox" title="Pilih DPL/KBC">
                        <i class="ri-list-check"></i> Pilih
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm btn-reset-selectbox" style="display:none;" title="Reset pilihan">
                        <i class="ri-refresh-line"></i>
                    </button>
                </div>
            </div>
            
            <select name="${inputName}-select[]" class="form-control form-select-sm selectbox-options"
                style="display:none;" id="select-${uniqueId}">
            </select>
            
            <input type="hidden" name="selecthidden_${inputName}[]" class="hidden-selectbox" value="${labelValue || ''}">
            
            <div class="selected-display mt-2" style="display:none;">
                <div class="alert alert-info alert-sm mb-0 p-2 d-flex justify-content-between align-items-center">
                    <small class="mb-0 selected-text"></small>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2 btn-edit-select" title="Ubah pilihan">
                        <i class="ri-edit-line"></i>
                    </button>
                </div>
            </div>`;
      }

      html += `
            <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove-dynamic-input">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </div>
        </div>
    </div>`;

      return html;
    },

    // Populate select options dengan DPL/KBC
    populateSelectOptions(uniqueId, preselectedValue = null) {
      const $select = $(`#select-${uniqueId}`);
      $select.empty();
      $select.append(`<option value="" ${!preselectedValue ? 'selected' : ''}>-- Batal Pilihan --</option>`);

      // Ambil dimensi
      const dimensiOptions = [];
      $('select[name="dimensi_profil_lulusan[]"]').each(function() {
        const val = $(this).val();
        const text = $(this).find('option:selected').text();
        if (val) dimensiOptions.push({
          value: val,
          text
        });
      });

      // Ambil kurikulum
      const kurikulumOptions = [];
      $('select[name="kurikulum_cinta[]"]').each(function() {
        const val = $(this).val();
        const text = $(this).find('option:selected').text();
        if (val) kurikulumOptions.push({
          value: val,
          text
        });
      });

      // DPL group
      $select.append('<optgroup label="----- DPL -----">');
      dimensiOptions.forEach(item => {
        const dplValue = `dpl-${item.value}`;
        const isSelected = preselectedValue === dplValue ? 'selected' : '';
        $select.append(`<option value="${dplValue}" ${isSelected}>${item.text}</option>`);
      });
      $select.append('</optgroup>');

      // KBC group
      $select.append('<optgroup label="----- KBC -----">');
      kurikulumOptions.forEach(item => {
        const kbcValue = `kbc-${item.value}`;
        const isSelected = preselectedValue === kbcValue ? 'selected' : '';
        $select.append(`<option value="${kbcValue}" ${isSelected}>${item.text}</option>`);
      });
      $select.append('</optgroup>');
    },

    // Render dynamic inputs saat edit
    async renderInputsOnEdit(dataArray, wrapperId, inputName, className, maxAllowed, useSelect, selectDataArray = []) {
      const $wrapper = $(`#${wrapperId}`);

      // ✅ Jika data kosong atau semua value kosong, JANGAN render apapun
      // JANGAN generate default disini
      if (!dataArray.length || dataArray.every(val => !val || val === '')) {
        return; // Biarkan kosong
      }

      const count = Math.min(dataArray.length, maxAllowed);

      for (let i = 0; i < count; i++) {
        const value = dataArray[i] || '';
        const uniqueId = Utils.generateUniqueId(`${inputName}-${i}`);
        const labelValue = selectDataArray[i] || '';

        const html = this.createInputGroupHtml(uniqueId, inputName, value, useSelect, inputName, labelValue);
        $wrapper.append(html);

        // Jika ada select dropdown (untuk pembukaan, inti, merefleksi)
        if (useSelect !== 0) {
          await new Promise(resolve => setTimeout(resolve, 30));

          const $card = $(`#input-group-${uniqueId}`);
          const $select = $card.find('.selectbox-options');
          const $displayBox = $card.find('.selected-display');
          const $displayText = $card.find('.selected-text');
          const $resetBtn = $card.find('.btn-reset-selectbox');

          // Populate options terlebih dahulu
          this.populateSelectOptions(uniqueId, labelValue);

          // Jika ada nilai yang terpilih sebelumnya, tampilkan di display box
          if (labelValue) {
            // Set nilai select (hidden)
            $select.val(labelValue);

            // Get text dari option yang dipilih
            const selectedText = $select.find('option:selected').text();

            if (selectedText && selectedText !== '-- Batal Pilihan --') {
              // Tampilkan di display box
              $displayText.html(`<i class="ri-checkbox-circle-line text-success"></i> ${selectedText}`);
              $displayBox.show();
              $resetBtn.show();

              // Sembunyikan select dropdown
              $select.hide();
            }
          }
        }
      }
    },

    // Add new input
    addInput(wrapperId, inputName, className, maxAllowed, placeholder, useSelect, defaultValue = '') {
      const $wrapper = $(`#${wrapperId}`);
      const count = $wrapper.find('.card.border').length; // Hitung card yang ada

      if (count >= maxAllowed) {
        SwalHelper.error(`Maksimal ${maxAllowed} input.`);
        return;
      }

      const uniqueId = Utils.generateUniqueId(inputName);
      const html = this.createInputGroupHtml(uniqueId, inputName, defaultValue, useSelect, placeholder);

      $wrapper.append(html);
    }
  };

  // =====================================================
  // FORM MANAGER
  // =====================================================
  const FormManager = {
    // Reset form
    // Reset form
    reset() {
      // Reset form elements
      $('#dataForm-modulajar')[0].reset();
      $('#imagePreview').hide();

      // Clear containers - PENTING: Destroy Select2 dulu sebelum empty
      $('#tujuan-container .select2-tujuan').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
          $(this).select2('destroy');
        }
      });
      $('#tujuan-container').empty();

      $('#dimensi-container .dimensi-select').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
          $(this).select2('destroy');
        }
      });
      $('#dimensi-container').empty();

      $('#kurikulumcinta-container .kurikulumcinta-select').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
          $(this).select2('destroy');
        }
      });
      $('#kurikulumcinta-container').empty();

      // Clear dynamic inputs untuk setiap hari
      for (let i = 1; i <= CONFIG.days; i++) {
        // ✅ PEMBUKAAN - Generate default values
        DynamicInputManager.generateDefaultPembukaan(
          `pembukaan-wrapper-${i}`,
          `pembukaan_${i}`,
          i
        );

        // ✅ LAINNYA - Clear kosong
        $(`#inti-wrapper-${i}`).empty();
        $(`#pemantik-wrapper-${i}`).empty();
        $(`#merefleksi-wrapper-${i}`).empty();
      }

      // Reset hidden inputs
      $('#tujuan_pembelajaran_json').val('');
      $('#dimensi_profil_lulusan_json').val('');
      $('#kurikulum_cinta_json').val('');

      for (let i = 1; i <= CONFIG.days; i++) {
        $(`#pembukaan_json_${i}`).val('');
        $(`#inti_json_${i}`).val('');
        $(`#pemantik_json_${i}`).val('');
        $(`#merefleksi_json_${i}`).val('');
        $(`#pembukaan_select_json_${i}`).val('');
        $(`#inti_select_json_${i}`).val('');
        $(`#merefleksi_select_json_${i}`).val('');
      }

      // Re-initialize default tujuan, dimensi, kurikulum (1 item kosong)
      this.initializeDefaultSelects();
    },

    // Initialize default select elements
    initializeDefaultSelects() {
      // Add 1 tujuan pembelajaran (CUSTOM INPUT)
      const tujuanHtml = `
    <div class="row mb-2 tujuan-item">
      <div class="col-sm-10">
        <div class="tujuan-custom-input">
          <input type="text" 
                 class="form-control tujuan-text-input" 
                 readonly 
                 placeholder="Klik untuk memilih tujuan pembelajaran">
          <span class="clear-btn">
            <i class="ri-close-circle-fill"></i>
          </span>
          <input type="hidden" class="tujuan-hidden-id">
        </div>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-danger w-100 btn-remove">
          <i class="ri-delete-bin-line"></i>
        </button>
      </div>
    </div>`;
      $('#tujuan-container').append(tujuanHtml);

      // Add 1 dimensi
      const dimensiHtml = `
        <div class="row mb-2 dimensi-item">
            <div class="col-sm-10">
                <select name="dimensi_profil_lulusan[]" class="form-control dimensi-select">
                    <option value="">Pilih Dimensi</option>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger w-100 btn-remove">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </div>`;
      $('#dimensi-container').append(dimensiHtml);
      Select2Manager.loadDimensi($('#dimensi-container .dimensi-select'));

      // Add 1 kurikulum
      const kurikulumHtml = `
        <div class="row mb-2 kurikulumcinta-item">
            <div class="col-sm-10">
                <select name="kurikulum_cinta[]" class="form-control kurikulumcinta-select">
                    <option value="">Pilih Kurikulum</option>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger w-100 btn-remove">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </div>`;
      $('#kurikulumcinta-container').append(kurikulumHtml);
      Select2Manager.loadKurikulum($('#kurikulumcinta-container .kurikulumcinta-select'));
    },

    // Prepare JSON untuk semua set input
    prepareJsonAllSets() {
      const getValues = inputName => {
        return $(`input[name="${inputName}[]"]`).map(function() {
          return $(this).val().trim();
        }).get().filter(v => v !== '');
      };

      const getValuesSelect = inputName => {
        return $(`input[name="${inputName}[]"]`).map(function() {
          return $(this).val().trim();
        }).get();
      };

      for (let i = 1; i <= CONFIG.days; i++) {
        const pembukaan = getValues(`pembukaan_${i}`);
        const inti = getValues(`inti_${i}`);
        const pemantik = getValues(`pemantik_${i}`);
        const merefleksi = getValues(`merefleksi_${i}`);

        $(`#pembukaan_json_${i}`).val(JSON.stringify(pembukaan));
        $(`#inti_json_${i}`).val(JSON.stringify(inti));
        $(`#pemantik_json_${i}`).val(JSON.stringify(pemantik));
        $(`#merefleksi_json_${i}`).val(JSON.stringify(merefleksi));

        if (pembukaan.length > 0) {
          $(`#pembukaan_select_json_${i}`).val(JSON.stringify(getValuesSelect(`selecthidden_pembukaan_${i}`)));
        }
        if (inti.length > 0) {
          $(`#inti_select_json_${i}`).val(JSON.stringify(getValuesSelect(`selecthidden_inti_${i}`)));
        }
        if (merefleksi.length > 0) {
          $(`#merefleksi_select_json_${i}`).val(JSON.stringify(getValuesSelect(`selecthidden_merefleksi_${i}`)));
        }
      }
    },

    // Prepare tujuan pembelajaran JSON
    prepareTujuanJson() {
      const ids = [];
      $('.tujuan-hidden-id').each(function() {
        const val = $(this).val();
        if (val) ids.push(val);
      });
      $('#tujuan_pembelajaran_json').val(JSON.stringify(ids));
    },

    // Prepare dimensi JSON
    prepareDimensiJson() {
      const ids = [];
      $('.dimensi-select').each(function() {
        const val = $(this).val();
        if (val) ids.push(val);
      });
      $('#dimensi_profil_lulusan_json').val(JSON.stringify(ids));
    },

    // Prepare kurikulum JSON
    prepareKurikulumJson() {
      const ids = [];
      $('.kurikulumcinta-select').each(function() {
        const val = $(this).val();
        if (val) ids.push(val);
      });
      $('#kurikulum_cinta_json').val(JSON.stringify(ids));
    }
  };

  // =====================================================
  // MODAL MANAGER
  // =====================================================
  const ModalManager = {
    show(type = 'add') {
      const $modal = $('#modalmodulajar');
      const $title = $('#modalTitle-modulajar');
      const $btnSave = $('#btn-simpan-modulajar');

      if (type === 'add') {
        FormManager.reset();
        $title.text('Tambah Modul Ajar');
        $btnSave.text('Tambah modulajar');
        State.currentAction = 'add';
      }

      new bootstrap.Offcanvas($modal).show();
    },

    hide() {
      const $modal = $('#modalmodulajar');
      bootstrap.Offcanvas.getInstance($modal)?.hide();
    },

    showDelete(id, tema, topik) {
      $('#delID').val(id);
      $('#delNama').text(`${tema} - ${topik}`);
      $('#Delmodalmodulajar').modal('show');
    }
  };

  // =====================================================
  // TUJUAN PEMBELAJARAN MODAL MANAGER
  // =====================================================
  const TujuanModalManager = {
    currentPage: 1,
    perPage: 20,
    totalPages: 1,
    allData: [],
    filteredData: [],
    currentTargetInput: null,

    // Initialize modal
    init() {
      this.bindModalEvents();
    },

    // Load semua data tujuan pembelajaran
    async loadAllData() {
      $('#tujuanLoadingIndicator').show();
      $('#tujuanListContainer').hide();

      const result = await ApiService.get(CONFIG.endpoints.ambilTP, {
        q: '',
        all: true // Tambahkan parameter untuk ambil semua data
      });

      if (result.success && result.data.results) {
        this.allData = result.data.results;
        this.filteredData = this.allData;
        this.totalPages = Math.ceil(this.filteredData.length / this.perPage);
        this.renderList();
      } else {
        SwalHelper.error('Gagal memuat data tujuan pembelajaran');
      }

      $('#tujuanLoadingIndicator').hide();
      $('#tujuanListContainer').show();
    },

    // Render list items
    renderList() {
      const $container = $('#tujuanListContainer');
      $container.empty();

      if (this.filteredData.length === 0) {
        $('#tujuanNoResults').show();
        $('#tujuanPagination').hide();
        return;
      }

      $('#tujuanNoResults').hide();

      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      const pageData = this.filteredData.slice(start, end);

      pageData.forEach(item => {
        const $item = $(`
        <a href="#" class="list-group-item list-group-item-action tujuan-list-item" 
           data-id="${item.id}" 
           data-text="${Utils.escapeHtml(item.text)}">
          <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
              <h6 class="mb-1">${item.text}</h6>
              ${item.kode ? `<span class="tujuan-badge">${item.kode}</span>` : ''}
            </div>
            <i class="ri-arrow-right-s-line"></i>
          </div>
        </a>
      `);

        $container.append($item);
      });

      // Update pagination
      if (this.totalPages > 1) {
        $('#tujuanPagination').show();
        $('#tujuanPageInfo').text(`Halaman ${this.currentPage} dari ${this.totalPages}`);
        $('#btnPrevTujuan').prop('disabled', this.currentPage === 1);
        $('#btnNextTujuan').prop('disabled', this.currentPage === this.totalPages);
      } else {
        $('#tujuanPagination').hide();
      }
    },

    // Search/Filter
    search(query) {
      const searchTerm = query.toLowerCase().trim();

      if (!searchTerm) {
        this.filteredData = this.allData;
      } else {
        this.filteredData = this.allData.filter(item =>
          item.text.toLowerCase().includes(searchTerm) ||
          (item.kode && item.kode.toLowerCase().includes(searchTerm))
        );
      }

      this.currentPage = 1;
      this.totalPages = Math.ceil(this.filteredData.length / this.perPage);
      this.renderList();
    },

    // Show modal
    show($inputElement) {
      this.currentTargetInput = $inputElement;
      $('#modalPilihTujuan').modal('show');

      // Load data jika belum
      if (this.allData.length === 0) {
        this.loadAllData();
      } else {
        this.renderList();
      }

      // Focus search
      setTimeout(() => $('#searchTujuanInput').focus(), 300);
    },

    // Select item
    selectItem(id, text) {
      if (this.currentTargetInput) {
        // Set value ke input
        this.currentTargetInput.val(text);
        this.currentTargetInput.attr('data-id', id);

        // Update hidden input
        const $parent = this.currentTargetInput.closest('.tujuan-item');
        $parent.find('.tujuan-hidden-id').val(id);

        // Show clear button
        this.currentTargetInput.closest('.tujuan-custom-input').addClass('has-value');
      }

      $('#modalPilihTujuan').modal('hide');
    },

    // Bind events
    bindModalEvents() {
      // Search input
      $('#searchTujuanInput').on('input', Utils.debounce((e) => {
        this.search(e.target.value);
      }, 300));

      // Click item
      $(document).on('click', '.tujuan-list-item', (e) => {
        e.preventDefault();
        const $item = $(e.currentTarget);
        const id = $item.data('id');
        const text = $item.data('text');
        this.selectItem(id, text);
      });

      // Pagination
      $('#btnPrevTujuan').on('click', () => {
        if (this.currentPage > 1) {
          this.currentPage--;
          this.renderList();
        }
      });

      $('#btnNextTujuan').on('click', () => {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
          this.renderList();
        }
      });

      // Reset saat modal ditutup
      $('#modalPilihTujuan').on('hidden.bs.modal', () => {
        $('#searchTujuanInput').val('');
        this.currentPage = 1;
        this.filteredData = this.allData;
      });
    }
  };


  // =====================================================
  // TEMPLATE PEMANTIK MODAL MANAGER
  // =====================================================
  const TemplatePemantikManager = {
    allTemplates: TEMPLATES.kata_pemantik,
    filteredTemplates: [],
    currentTargetInputId: null,

    // Initialize
    init() {
      this.filteredTemplates = this.allTemplates;
      this.bindEvents();
    },

    // Show modal
    show(inputId) {
      this.currentTargetInputId = inputId;
      $('#modalTemplatePemantik').modal('show');
      this.renderList();
      setTimeout(() => $('#searchTemplatePemantikInput').focus(), 300);
    },

    // Render list
    renderList() {
      const $container = $('#templatePemantikListContainer');
      $container.empty();

      if (this.filteredTemplates.length === 0) {
        $('#templatePemantikNoResults').show();
        return;
      }

      $('#templatePemantikNoResults').hide();

      this.filteredTemplates.forEach((template, index) => {
        const $item = $(`
        <a href="#" class="list-group-item list-group-item-action template-pemantik-item" 
           data-template="${Utils.escapeHtml(template)}">
          <div class="d-flex align-items-center">
            <span class="badge bg-info me-2">${index + 1}</span>
            <div class="template-text flex-grow-1">${template}</div>
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
        this.filteredTemplates = this.allTemplates;
      } else {
        this.filteredTemplates = this.allTemplates.filter(template =>
          template.toLowerCase().includes(searchTerm)
        );
      }

      this.renderList();
    },

    // Select template
    selectTemplate(templateText) {
      if (this.currentTargetInputId) {
        const $input = $(`#${this.currentTargetInputId}`);

        // Set value ke input (user masih bisa edit setelah ini)
        $input.val(templateText);

        // Focus ke input untuk edit
        setTimeout(() => {
          $input.focus();
          // Set cursor ke akhir text
          const inputElement = $input[0];
          if (inputElement) {
            inputElement.setSelectionRange(templateText.length, templateText.length);
          }
        }, 300);
      }

      $('#modalTemplatePemantik').modal('hide');
    },

    // Bind events
    bindEvents() {
      // Search input
      $('#searchTemplatePemantikInput').on('input', Utils.debounce((e) => {
        this.search(e.target.value);
      }, 300));

      // ✅ TAMBAHKAN INI: Button template pemantik
      $(document).on('click', '.btn-template-pemantik', function() {
        const inputId = $(this).data('input-id');
        TemplatePemantikManager.show(inputId);
      });

      // Click template item
      $(document).on('click', '.template-pemantik-item', (e) => {
        e.preventDefault();
        const template = $(e.currentTarget).data('template');
        this.selectTemplate(template);
      });

      // Reset search saat modal ditutup
      $('#modalTemplatePemantik').on('hidden.bs.modal', () => {
        $('#searchTemplatePemantikInput').val('');
        this.filteredTemplates = this.allTemplates;
      });
    }
  };

  // =====================================================
  // DATA LOADER
  // =====================================================
  const DataLoader = {
    async loadEditData($trigger) {
      SwalHelper.loading('Memuat data...', 'Mohon tunggu sebentar.');

      try {
        // ✅ PENTING: Clear manual tanpa panggil reset()
        // Karena reset() akan generate default pembukaan

        // Reset form elements basic
        $('#dataForm-modulajar')[0].reset();
        $('#imagePreview').hide();

        // Clear tujuan
        $('#tujuan-container .select2-tujuan').each(function() {
          if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
          }
        });
        $('#tujuan-container').empty();

        // Clear dimensi
        $('#dimensi-container .dimensi-select').each(function() {
          if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
          }
        });
        $('#dimensi-container').empty();

        // Clear kurikulum
        $('#kurikulumcinta-container .kurikulumcinta-select').each(function() {
          if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
          }
        });
        $('#kurikulumcinta-container').empty();

        // ✅ Clear dynamic inputs untuk setiap hari (TANPA generate default)
        for (let i = 1; i <= CONFIG.days; i++) {
          $(`#pembukaan-wrapper-${i}`).empty();
          $(`#inti-wrapper-${i}`).empty();
          $(`#pemantik-wrapper-${i}`).empty();
          $(`#merefleksi-wrapper-${i}`).empty();
        }

        // Reset hidden inputs
        $('#tujuan_pembelajaran_json').val('');
        $('#dimensi_profil_lulusan_json').val('');
        $('#kurikulum_cinta_json').val('');

        for (let i = 1; i <= CONFIG.days; i++) {
          $(`#pembukaan_json_${i}`).val('');
          $(`#inti_json_${i}`).val('');
          $(`#pemantik_json_${i}`).val('');
          $(`#merefleksi_json_${i}`).val('');
          $(`#pembukaan_select_json_${i}`).val('');
          $(`#inti_select_json_${i}`).val('');
          $(`#merefleksi_select_json_${i}`).val('');
        }

        // ✅ Initialize default tujuan, dimensi, kurikulum (1 item kosong)
        // TAPI tidak generate pembukaan default
        FormManager.initializeDefaultSelects();

        // Load basic data
        $('#id').val($trigger.data('id'));
        $('#tanggal').val($trigger.data('tanggal'));
        $('#semester').val($trigger.data('semester'));
        $('#pekan').val($trigger.data('pekan'));
        $('#model_pembelajaran').val($trigger.data('model_pembelajaran'));
        $('#subtopik_pembelajaran').val($trigger.data('subtopik_pembelajaran'));
        $('#topik_pembelajaran').val($trigger.data('topik_pembelajaran'));

        // Load pedagogik data
        $('#model_praktik_pedagogik').val($trigger.data('pedagogik_model'));
        $('#strategi_praktik_pedagogik').val($trigger.data('pedagogik_strategi'));
        $('#metode_praktik_pedagogik').val($trigger.data('pedagogik_metode'));
        $('#kemitraaan_pembelajaran').val($trigger.data('kemitraan'));
        $('#lingkungan_pembelajaran_ruang_fisik').val($trigger.data('ruang_fisik'));
        $('#lingkungan_pembelajaran_ruang_virtual').val($trigger.data('ruang_virtual'));
        $('#pemanfaatan_digital').val($trigger.data('pemanfaatan_digital'));

        // Load alat bahan
        for (let i = 1; i <= CONFIG.days; i++) {
          $(`#alatbahan${i}`).val($trigger.data(`alatbahan${i}`));
        }

        // Load tujuan pembelajaran
        await this.loadTujuanPembelajaran($trigger);

        // Load dimensi & kurikulum
        await this.loadDimensiKurikulum($trigger);

        // ✅ Load daily inputs (ini akan load pembukaan dari database)
        await this.loadDailyInputs($trigger);

        // Load foto
        const foto = $trigger.data('foto_modulajar');
        if (foto) {
          $('#imagePreview').attr('src', '/kbra-ci/public/uploads/foto_modulajar/' + foto).show();
        }
        $('#desc_media_pembelajaran').val($trigger.data('desc_media_pembelajaran'));

        SwalHelper.close();

        // Set modal untuk edit
        $('#modalTitle-modulajar').text('Ubah Data Modul Ajar');
        $('#btn-simpan-modulajar').text('Perbarui').data('action', 'edit');
        State.currentAction = 'edit';

      } catch (error) {
        console.error('Error loading data:', error);
        SwalHelper.error('Gagal memuat data');
      }
    },

    async loadTujuanPembelajaran($trigger) {
      const raw = $trigger.attr('data-tujuan_pembelajaran');
      const tujuanArray = Utils.safeJsonParse(raw);

      $('#tujuan-container').empty();

      if (tujuanArray.length > 0) {
        // Fetch texts untuk semua IDs
        const ids = tujuanArray.map(item =>
          typeof item === 'object' ? item.id : item
        );

        const result = await ApiService.get(CONFIG.endpoints.ambilTexts, {
          ids
        });

        if (result.success) {
          result.data.forEach(item => {
            const html = `
          <div class="row mb-2 tujuan-item">
            <div class="col-sm-10">
              <div class="tujuan-custom-input has-value">
                <input type="text" 
                       class="form-control tujuan-text-input" 
                       readonly 
                       value="${Utils.escapeHtml(item.text)}"
                       data-id="${item.id}">
                <span class="clear-btn">
                  <i class="ri-close-circle-fill"></i>
                </span>
                <input type="hidden" class="tujuan-hidden-id" value="${item.id}">
              </div>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-danger w-100 btn-remove">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
          </div>`;
            $('#tujuan-container').append(html);
          });
        }
      } else {
        FormManager.initializeDefaultSelects();
      }
    },

    async loadDimensiKurikulum($trigger) {
      const rawDimensi = $trigger.attr('data-dimensi_profil_lulusan');
      const rawKurikulum = $trigger.attr('data-kurikulum_cinta');

      await Promise.all([
        this.renderDimensi(rawDimensi),
        this.renderKurikulum(rawKurikulum)
      ]);
    },

    async renderDimensi(rawData) {
      const dimensiArray = Utils.safeJsonParse(rawData);
      const result = await ApiService.getCached('dimensi', CONFIG.endpoints.ambilDimensi);

      $('#dimensi-container').empty();

      if (!result.success) {
        $('#dimensi-container').html('<p class="text-danger">Gagal memuat daftar dimensi.</p>');
        return;
      }

      const list = dimensiArray.length > 0 ? dimensiArray : [''];

      list.forEach(item => {
        let id = item;
        let labelType = '',
          labelClass = '';

        if (typeof item === 'string') {
          if (item.includes('dpl-')) {
            id = item.replace('dpl-', '');
            labelType = 'DPL';
            labelClass = 'badge bg-primary';
          } else if (item.includes('kbc-')) {
            id = item.replace('kbc-', '');
            labelType = 'KBC';
            labelClass = 'badge bg-info';
          }
        }

        const $row = $(`
            <div class="row mb-2 dimensi-item">
                <div class="col-sm-10">
                    <select name="dimensi_profil_lulusan[]" class="form-control dimensi-select"></select>
                    ${labelType ? `<div class="selected-info mt-1">
                        <span class="${labelClass}">${labelType} saat ini: ${id}</span>
                        <small class="text-muted ms-2">(Original: ${item})</small>
                    </div>` : ''}
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="ri-delete-bin-2-line"></i>
                    </button>
                </div>
            </div>`);

        const $select = $row.find('select');
        Select2Manager.loadDimensi($select, id);
        $('#dimensi-container').append($row);
      });
    },

    async renderKurikulum(rawData) {
      const kurikulumArray = Utils.safeJsonParse(rawData);
      const result = await ApiService.getCached('kurikulum', CONFIG.endpoints.ambilKurikulum);

      $('#kurikulumcinta-container').empty();

      if (!result.success) {
        $('#kurikulumcinta-container').html('<p class="text-danger">Gagal memuat daftar kurikulum.</p>');
        return;
      }

      const list = kurikulumArray.length > 0 ? kurikulumArray : [''];

      list.forEach(item => {
        let id = item;
        let labelType = '',
          labelClass = '';

        if (typeof item === 'string') {
          if (item.includes('kbc-')) {
            id = item.replace('kbc-', '');
            labelType = 'KBC';
            labelClass = 'badge bg-success';
          } else if (item.includes('dpl-')) {
            id = item.replace('dpl-', '');
            labelType = 'DPL';
            labelClass = 'badge bg-primary';
          }
        }

        const $row = $(`
            <div class="row mb-2 kurikulumcinta-item">
                <div class="col-sm-10">
                    <select name="kurikulum_cinta[]" class="form-control kurikulumcinta-select"></select>
                    ${labelType ? `<div class="selected-info mt-1">
                        <span class="${labelClass}">${labelType} saat ini: ${id}</span>
                        <small class="text-muted ms-2">(Original: ${item})</small>
                    </div>` : ''}
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="ri-delete-bin-2-line"></i>
                    </button>
                </div>
            </div>`);

        const $select = $row.find('select');
        Select2Manager.loadKurikulum($select, id);
        $('#kurikulumcinta-container').append($row);
      });
    },

    async loadDailyInputs($trigger) {
      const mojarId = $trigger.data('id');
      const result = await ApiService.get(CONFIG.endpoints.ambilSelect + '/' + mojarId);

      if (!result.success) {
        SwalHelper.error('Gagal mengambil data select');
        return;
      }

      // Parse select data
      for (let i = 1; i <= CONFIG.days; i++) {
        State.parsedData[`pembukaan_${i}_select`] = Utils.safeJsonParse(result.data[`pembukaan_${i}_select`]);
        State.parsedData[`inti_${i}_select`] = Utils.safeJsonParse(result.data[`inti_${i}_select`]);
        State.parsedData[`merefleksi_${i}_select`] = Utils.safeJsonParse(result.data[`merefleksi_${i}_select`]);
      }

      // Render inputs for each day
      for (let i = 1; i <= CONFIG.days; i++) {
        const pembukaanData = Utils.safeJsonParse($trigger.data(`pembukaan${i}`));
        const kegiatanData = Utils.safeJsonParse($trigger.data(`kegiatan${i}`));
        const pertanyaanData = Utils.safeJsonParse($trigger.data(`pertanyaan${i}`));
        const merefleksiData = Utils.safeJsonParse($trigger.data(`merefleksi${i}`));

        // ✅ Render pembukaan dari database
        // Jika pembukaan kosong di database, jangan render apa-apa (biarkan kosong)
        await Promise.all([
          DynamicInputManager.renderInputsOnEdit(
            pembukaanData,
            `pembukaan-wrapper-${i}`,
            `pembukaan_${i}`,
            'pembukaan-item',
            CONFIG.maxPembukaan,
            1,
            State.parsedData[`pembukaan_${i}_select`]
          ),
          DynamicInputManager.renderInputsOnEdit(
            kegiatanData,
            `inti-wrapper-${i}`,
            `inti_${i}`,
            'inti-item',
            CONFIG.maxInti,
            1,
            State.parsedData[`inti_${i}_select`]
          ),
          DynamicInputManager.renderInputsOnEdit(
            pertanyaanData,
            `pemantik-wrapper-${i}`,
            `pemantik_${i}`,
            'pemantik-item',
            CONFIG.maxPemantik,
            0,
            []
          ),
          DynamicInputManager.renderInputsOnEdit(
            merefleksiData,
            `merefleksi-wrapper-${i}`,
            `merefleksi_${i}`,
            'merefleksi-item',
            CONFIG.maxRefleksi,
            0,
            []
          )
        ]);

        // Load subtopik data
        $(`#tgl_subsubtopik${i}`).val($trigger.data(`tgl_subsubtopik${i}`));
        $(`#subsubtopik${i}`).val($trigger.data(`subsubtopik${i}`));
      }
    }
  };

  // =====================================================
  // EVENT HANDLERS
  // =====================================================
  const EventHandlers = {
    init() {
      this.initFlatpickr();
      this.initValidation();
      this.initDataTable();
      this.bindEvents();
    },

    initFlatpickr() {
      const config = {
        locale: "id",
        dateFormat: "l, d F Y",
        disableMobile: true,
        theme: "material_blue"
      };

      // Init untuk semua tanggal
      for (let i = 1; i <= CONFIG.days; i++) {
        flatpickr(`#tgl_subsubtopik${i}`, config);
      }
    },

    initValidation() {
      const validator = new JustValidate('#dataForm-modulajar');

      const requiredFields = [{
          selector: '#tanggal',
          message: 'Tanggal wajib diisi!'
        },
        {
          selector: '#semester',
          message: 'Semester wajib diisi!'
        },
        {
          selector: '#pekan',
          message: 'Pekan wajib diisi!'
        },
        {
          selector: '#model_pembelajaran',
          message: 'Model Pembelajaran wajib diisi!'
        },
        {
          selector: '#subtopik_pembelajaran',
          message: 'Tema Pembelajaran wajib diisi!'
        },
        {
          selector: '#topik_pembelajaran',
          message: 'Topik Pembelajaran wajib diisi!'
        }
      ];

      // Add validation untuk subsubtopik
      for (let i = 1; i <= CONFIG.days; i++) {
        requiredFields.push({
          selector: `#tgl_subsubtopik${i}`,
          message: 'Tanggal Topik Pembelajaran wajib diisi!'
        }, {
          selector: `#subsubtopik${i}`,
          message: 'Sub Topik Pembelajaran wajib diisi!'
        });
      }

      requiredFields.forEach(field => {
        validator.addField(field.selector, [{
          rule: 'required',
          errorMessage: field.message
        }]);
      });

      validator
        .onValidate(() => {
          State.isValidasi = true;
        })
        .onFail(() => {
          State.isValidasi = false;
        });
    },

    initDataTable() {
      const table = $('#table-modulajar').DataTable({
        processing: true,
        scrollX: true,
        serverSide: false,
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.childRowImmediate,
            type: 'column',
            renderer: (api, rowIdx, columns) => this.renderResponsiveCard(api, rowIdx, columns)
          }
        },
        ajax: {
          url: CONFIG.baseUrl + CONFIG.endpoints.ambilData,
          type: "POST"
        },
        columns: [{
            data: "id",
            visible: false,
            width: "50px" // bisa pakai px atau %
          },
          {
            data: "dibuat_tanggal",
            width: "120px"
          },
          {
            data: "nama_semester",
            width: "100px"
          },
          {
            data: "pekan",
            width: "80px"
          },
          {
            data: null,
            render: function(data, type, row) {
              return `
                <div>
                  ${row.subtopik_pembelajaran} <br>
                  <small><strong>(${row.pembuat_nama})</strong></small>
                </div>
              `;
            },
            width: "250px"
          },
          {
            data: "topik_pembelajaran",
            width: "150px"
          },
          {
            data: null,
            render: (data, type, row) => this.renderActionButtons(row),
            width: "220px"
          }
        ]

      });

      window.dataTable_modulajar = table;
    },

    renderActionButtons(row) {
      const escapeAttr = str => Utils.escapeHtml(str);
      const dataAttrs = this.buildDataAttributes(row);

      const isOwner = row.pembuat == CURRENT_USER_ID;

      let html = `<div class="action-grid" style="display:grid; grid-template-columns: repeat(2, 1fr); gap:6px;">`;

      if (isOwner) {
        // Row 1
        html += `
        <a href="${CONFIG.baseUrl}asesmen/index/${row.id}" class="btn btn-sm btn-primary" style="width:100%">Asesmen</a>
        <a href="${CONFIG.baseUrl}${CONFIG.endpoints.download}/${row.id}" class="btn btn-sm btn-success" style="width:100%">Download</a>
        `;

        // Row 2
        html += `
            <button class="btn btn-sm btn-info editBtn" style="width:100%" ${dataAttrs}>Edit</button>
            <button class="btn btn-sm btn-danger delBtn" 
                style="width:100%"
                data-id="${escapeAttr(row.id)}"
                data-tema_pembelajaran="${escapeAttr(row.subtopik_pembelajaran)}"
                data-topik_pembelajaran="${escapeAttr(row.topik_pembelajaran)}">
                Delete
            </button>
        `;
      } else {
        // Bukan owner → hanya 2 tombol, tetap 2 kolom
        html += `
            <a href="${CONFIG.baseUrl}asesmen/index/${row.id}" class="btn btn-sm btn-primary" style="width:100%">Asesmen</a>
            <a href="${CONFIG.baseUrl}${CONFIG.endpoints.download}/${row.id}" class="btn btn-sm btn-success" style="width:100%">Download</a>
        `;
      }

      html += `</div>`;

      return html;
    },

    buildDataAttributes(row) {
      const escapeAttr = str => Utils.escapeHtml(str);

      const attrs = {
        'id': row.id,
        'tanggal': row.dibuat_tanggal,
        'semester': row.nama_semester,
        'pekan': row.pekan,
        'model_pembelajaran': row.model_pembelajaran,
        'subtopik_pembelajaran': row.subtopik_pembelajaran,
        'topik_pembelajaran': row.topik_pembelajaran,
        'tujuan_pembelajaran': JSON.stringify(row.tujuan_pembelajaran || []),
        'dimensi_profil_lulusan': JSON.stringify(row.dimensi_profil_lulusan || []),
        'kurikulum_cinta': JSON.stringify(row.kurikulum_cinta || []),
        'foto_modulajar': row.foto_mediaPembelajaran || '',
        'desc_media_pembelajaran': row.deskripsi_mediaPembelajaran || '',
        'pedagogik_model': row.pedagogik_model || '',
        'pedagogik_strategi': row.pedagogik_strategi || '',
        'pedagogik_metode': row.pedagogik_metode || '',
        'kemitraan': row.kemitraan || '',
        'ruang_fisik': row.ruang_fisik || '',
        'ruang_virtual': row.ruang_virtual || '',
        'pemanfaatan_digital': row.pemanfaatan_digital || ''
      };

      // Add daily data
      for (let i = 1; i <= CONFIG.days; i++) {
        attrs[`alatbahan${i}`] = row[`mediapembelajaran_${i}`] || '';
        attrs[`tgl_subsubtopik${i}`] = row[`subsubTopik_tanggal${i}`] || '';
        attrs[`subsubtopik${i}`] = row[`subsubTopik_${i}`] || '';
        attrs[`pembukaan${i}`] = JSON.stringify(row[`pembukaan_${i}`] || []);
        attrs[`kegiatan${i}`] = JSON.stringify(row[`kegiatan_inti_${i}`] || []);
        attrs[`pertanyaan${i}`] = JSON.stringify(row[`pertanyaan_pemantik_${i}`] || []);
        attrs[`merefleksi${i}`] = JSON.stringify(row[`merefleksi_${i}`] || []);
        attrs[`select_pembukaan${i}`] = JSON.stringify(row[`pembukaan_${i}_select`] || []);
        attrs[`select_inti${i}`] = JSON.stringify(row[`inti_${i}_select`] || []);
        attrs[`select_merefleksi${i}`] = JSON.stringify(row[`merefleksi_${i}_select`] || []);
      }

      return Object.entries(attrs)
        .map(([key, value]) => `data-${key}="${escapeAttr(value)}"`)
        .join(' ');
    },

    renderResponsiveCard(api, rowIdx, columns) {
      const data = api.row(rowIdx).data();
      const isOwner = data.pembuat == CURRENT_USER_ID;

      let content = '<div class="card mb-3"><div class="card-body">';

      columns.forEach(col => {
        const header = window.dataTable_modulajar.column(col.columnIndex).header().textContent;
        const value = col.data;

        if (header && value && header !== 'Action') {
          content += `<p class="card-text"><strong>${header}:</strong> ${value}</p>`;
        }
      });

      //
      // Tombol bagian pertama (Edit jika pemilik, Asesmen selalu muncul)
      //
      content += `<div class="row mt-3">`;

      if (isOwner) {
        content += `
            <div class="col-6">
                <button class="btn btn-lg btn-info editBtn" style="width:100%" 
                    ${this.buildDataAttributes(data)}>Edit</button>
            </div>
            <div class="col-6">
                <a href="${CONFIG.baseUrl}asesmen/index/${data.id}" 
                   class="btn btn-lg btn-primary" style="width:100%">Asesmen</a>
            </div>`;
      } else {
        // Jika bukan pemilik, hanya tombol Asesmen yang tampil di row pertama
        content += `
            <div class="col-12">
                <a href="${CONFIG.baseUrl}asesmen/index/${data.id}" 
                   class="btn btn-lg btn-primary" style="width:100%">Asesmen</a>
            </div>`;
      }

      content += `</div>`;

      //
      // Tombol bagian kedua (Download untuk semua, Delete hanya jika pemilik)
      //
      content += `<div class="row mt-3">`;

      if (isOwner) {
        content += `
            <div class="col-6">
                <a href="${CONFIG.baseUrl}${CONFIG.endpoints.download}/${data.id}" 
                   class="btn btn-lg btn-success" style="width:100%">Download</a>
            </div>
            <div class="col-6">
                <button class="btn btn-lg btn-danger delBtn" style="width:100%"
                    data-id="${data.id}" 
                    data-tema_pembelajaran="${data.subtopik_pembelajaran}" 
                    data-topik_pembelajaran="${data.topik_pembelajaran}">
                        Delete
                </button>
            </div>`;
      } else {
        // Tidak ada tombol delete untuk non-user
        content += `
            <div class="col-12">
                <a href="${CONFIG.baseUrl}${CONFIG.endpoints.download}/${data.id}" 
                   class="btn btn-lg btn-success" style="width:100%">Download</a>
            </div>`;
      }

      content += `</div>`;

      content += '</div></div>';

      return content ? $('<div/>').append(content) : false;
    },


    bindEvents() {

      // Click input tujuan - show modal
      $(document).on('click', '.tujuan-text-input', function() {
        TujuanModalManager.show($(this));
      });

      // Clear tujuan selection
      $(document).on('click', '.tujuan-custom-input .clear-btn', function(e) {
        e.stopPropagation();
        const $parent = $(this).closest('.tujuan-custom-input');
        $parent.find('.tujuan-text-input').val('').removeAttr('data-id');
        $parent.find('.tujuan-hidden-id').val('');
        $parent.removeClass('has-value');
      });

      // Button tambah modul ajar
      $(document).off('click.modulajar', '#btn-tambah-modulajar')
        .on('click.modulajar', '#btn-tambah-modulajar', () => ModalManager.show('add'));

      // Button edit
      $(document).off('click.modulajar', '.editBtn')
        .on('click.modulajar', '.editBtn', function() {
          DataLoader.loadEditData($(this)).then(() => {
            ModalManager.show('edit');
          });
        });

      // Button delete
      $(document).off('click.modulajar', '.delBtn')
        .on('click.modulajar', '.delBtn', function() {
          ModalManager.showDelete(
            $(this).data('id'),
            $(this).data('tema_pembelajaran'),
            $(this).data('topik_pembelajaran')
          );
        });

      // Confirm delete
      $(document).off('click.modulajar', '#btn-hapus-modulajar')
        .on('click.modulajar', '#btn-hapus-modulajar', this.handleDelete);

      // Form submit
      $(document).off('submit.modulajar', '#dataForm-modulajar')
        .on('submit.modulajar', '#dataForm-modulajar', this.handleSubmit);

      // Add tujuan pembelajaran
      $(document).off('click.modulajar', '#add-tujuan')
        .on('click.modulajar', '#add-tujuan', this.handleAddTujuan);

      // Remove tujuan
      $(document).off('click.modulajar', '#tujuan-container .btn-remove')
        .on('click.modulajar', '#tujuan-container .btn-remove', function() {
          $(this).closest('.tujuan-item').remove();
        });

      // Add dimensi
      $(document).off('click.modulajar', '#add-dimensi')
        .on('click.modulajar', '#add-dimensi', this.handleAddDimensi);

      // Add kurikulum
      $(document).off('click.modulajar', '#add-kurikulumcinta')
        .on('click.modulajar', '#add-kurikulumcinta', this.handleAddKurikulum);

      // Remove dimensi/kurikulum
      $(document).off('click.modulajar', '#dimensi-container .btn-remove, #kurikulumcinta-container .btn-remove')
        .on('click.modulajar', '#dimensi-container .btn-remove, #kurikulumcinta-container .btn-remove', function() {
          const $parent = $(this).closest('.dimensi-item, .kurikulumcinta-item');
          const $container = $(this).closest('#dimensi-container, #kurikulumcinta-container');

          if ($container.find('.dimensi-item, .kurikulumcinta-item').length > 1) {
            $parent.fadeOut(300, function() {
              $(this).remove();
            });
          } else {
            SwalHelper.error('Minimal harus ada 1 item');
          }
        });

      // Add dynamic inputs untuk setiap hari
      for (let i = 1; i <= CONFIG.days; i++) {
        // ✅ PEMBUKAAN - Cek current count untuk default value
        $(`#add-pembukaan-${i}`).off('click.modulajar').on('click.modulajar', () => {
          const $wrapper = $(`#pembukaan-wrapper-${i}`);
          const currentCount = $wrapper.find('.card.border').length;

          if (currentCount >= CONFIG.maxPembukaan) {
            SwalHelper.error(`Maksimal ${CONFIG.maxPembukaan} input.`);
            return;
          }

          // Jika masih dalam range default (0-6), gunakan default value
          // Jika sudah lebih dari 7, biarkan kosong
          const defaultValue = currentCount < DEFAULT_VALUES.pembukaan.length ?
            DEFAULT_VALUES.pembukaan[currentCount] :
            '';

          const uniqueId = Utils.generateUniqueId(`pembukaan_${i}`);
          const html = DynamicInputManager.createInputGroupHtml(
            uniqueId,
            `pembukaan_${i}`,
            defaultValue,
            1,
            `pembukaan ${i}`
          );

          $wrapper.append(html);
        });

        // ✅ INTI, PEMANTIK, MEREFLEKSI - Tetap sama seperti sebelumnya
        $(`#add-inti-${i}`).off('click.modulajar').on('click.modulajar', () => {
          DynamicInputManager.addInput(
            `inti-wrapper-${i}`,
            `inti_${i}`,
            'inti-item',
            CONFIG.maxInti,
            `inti ${i}`,
            1
          );
        });

        $(`#add-pemantik-${i}`).off('click.modulajar').on('click.modulajar', () => {
          DynamicInputManager.addInput(
            `pemantik-wrapper-${i}`,
            `pemantik_${i}`,
            'pemantik-item',
            CONFIG.maxPemantik,
            `pertanyaan pemantik ${i}`,
            0
          );
        });

        $(`#add-merefleksi-${i}`).off('click.modulajar').on('click.modulajar', () => {
          DynamicInputManager.addInput(
            `merefleksi-wrapper-${i}`,
            `merefleksi_${i}`,
            'merefleksi-item',
            CONFIG.maxRefleksi,
            `merefleksi ${i}`,
            1
          );
        });
      }

      // Remove dynamic input
      $(document).off('click.modulajar', '.btn-remove-dynamic-input')
        .on('click.modulajar', '.btn-remove-dynamic-input', function() {
          const $card = $(this).closest('.card');

          // Optional: Konfirmasi sebelum hapus
          if (confirm('Hapus item ini?')) {
            $card.fadeOut(300, function() {
              $(this).remove();
            });
          }
        });

      // Toggle selectbox
      $(document).off('click.modulajar', '.btn-toggle-selectbox')
        .on('click.modulajar', '.btn-toggle-selectbox', function() {
          const $inputGroup = $(this).closest('.card');
          const $select = $inputGroup.find('.selectbox-options');
          const $displayBox = $inputGroup.find('.selected-display');

          // Hide display box, show select
          $displayBox.hide();
          $select.show();

          // Get uniqueId dari select element langsung
          const selectId = $select.attr('id');
          if (!selectId) {
            console.error('Select ID not found');
            return;
          }
          const uniqueId = selectId.replace('select-', '');

          // Populate select jika belum ada options (untuk add new)
          if ($select.find('option').length <= 1) {
            DynamicInputManager.populateSelectOptions(uniqueId);
          }
        });

      // Handle select change
      $(document).off('change.modulajar', '.selectbox-options')
        .on('change.modulajar', '.selectbox-options', function() {
          const $select = $(this);
          const $inputGroup = $select.closest('.card');
          const $displayBox = $inputGroup.find('.selected-display');
          const $displayText = $inputGroup.find('.selected-text');
          const $hiddenInput = $inputGroup.find('.hidden-selectbox');
          const $resetBtn = $inputGroup.find('.btn-reset-selectbox');

          const selectedValue = $select.val();
          const selectedText = $select.find('option:selected').text();

          if (selectedValue && selectedText !== '-- Batal Pilihan --') {
            // Update hidden input
            $hiddenInput.val(selectedValue);

            // Show in display box with icon
            $displayText.html(`<i class="ri-checkbox-circle-line text-success"></i> ${selectedText}`);
            $displayBox.show();
            $resetBtn.show();

            // Hide select
            $select.hide();
          } else {
            // Clear selection
            $hiddenInput.val('');
            $displayBox.hide();
            $resetBtn.hide();
            $select.hide();
          }
        });

      // Edit button - show select again
      $(document).off('click.modulajar', '.btn-edit-select')
        .on('click.modulajar', '.btn-edit-select', function() {
          const $inputGroup = $(this).closest('.card');
          const $select = $inputGroup.find('.selectbox-options');
          const $displayBox = $inputGroup.find('.selected-display');

          $displayBox.hide();
          $select.show();
        });

      // Reset selectbox
      $(document).off('click.modulajar', '.btn-reset-selectbox')
        .on('click.modulajar', '.btn-reset-selectbox', function() {
          const $inputGroup = $(this).closest('.card');
          const $select = $inputGroup.find('.selectbox-options');
          const $displayBox = $inputGroup.find('.selected-display');
          const $hiddenInput = $inputGroup.find('.hidden-selectbox');

          $select.val('');
          $hiddenInput.val('');
          $displayBox.hide();
          $(this).hide();
        });

      // Image preview
      $(document).off('change.modulajar', '#foto_modulajar')
        .on('change.modulajar', '#foto_modulajar', function(e) {
          const input = e.target;
          const reader = new FileReader();

          reader.onload = e => $('#imagePreview').attr('src', e.target.result).show();

          if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
          }
        });
    },

    handleAddTujuan() {
      const count = $('#tujuan-container .tujuan-item').length;

      if (count >= CONFIG.maxTujuan) {
        SwalHelper.error(`Maksimal ${CONFIG.maxTujuan} tujuan pembelajaran.`);
        return;
      }

      const html = `
        <div class="row mb-2 tujuan-item">
          <div class="col-sm-10">
            <div class="tujuan-custom-input">
              <input type="text" 
                    class="form-control tujuan-text-input" 
                    readonly 
                    placeholder="Klik untuk memilih tujuan pembelajaran">
              <span class="clear-btn">
                <i class="ri-close-circle-fill"></i>
              </span>
              <input type="hidden" class="tujuan-hidden-id">
            </div>
          </div>
          <div class="col-sm-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-remove">
              <i class="ri-delete-bin-2-line"></i>
            </button>
          </div>
        </div>`;

      $('#tujuan-container').append(html);
    },

    async handleAddDimensi() {
      const $clone = $('.dimensi-item:first').clone();
      $clone.find('select').val('').removeAttr('id');
      $clone.find('.selected-info').remove();
      $('#dimensi-container').append($clone);
      await Select2Manager.loadDimensi($clone.find('select'));
    },

    async handleAddKurikulum() {
      const $clone = $('.kurikulumcinta-item:first').clone();
      $clone.find('select').val('').removeAttr('id');
      $clone.find('.selected-info').remove();
      $('#kurikulumcinta-container').append($clone);
      await Select2Manager.loadKurikulum($clone.find('select'));
    },

    async handleDelete() {
      const $btn = $(this);
      const originalText = $btn.text();

      $btn.prop('disabled', true).text('Deleting...');

      const formData = new FormData($('#delmodulajar')[0]);
      const result = await ApiService.post(CONFIG.endpoints.hapus, formData);

      if (result.success) {
        window.dataTable_modulajar.ajax.reload(null, false);
        $('#Delmodalmodulajar').modal('hide');
        SwalHelper.success('Data berhasil dihapus');
      } else {
        SwalHelper.error('Gagal menghapus data');
      }

      $btn.prop('disabled', false).text(originalText);
    },

    async handleSubmit(e) {
      e.preventDefault();

      // Update hidden selectbox values
      $('.selectbox-options').each(function() {
        const $select = $(this);
        const $hidden = $select.siblings('.hidden-selectbox');
        $hidden.val($select.val() || '');
      });

      // Prepare all JSON data
      FormManager.prepareJsonAllSets();
      FormManager.prepareTujuanJson();
      FormManager.prepareDimensiJson();
      FormManager.prepareKurikulumJson();

      if (!State.isValidasi) {
        SwalHelper.error('Mohon lengkapi semua field yang wajib diisi');
        return;
      }

      const $btn = $('#btn-simpan-modulajar');
      const originalText = $btn.text();
      $btn.prop('disabled', true).text('Saving...');

      const formData = new FormData(document.getElementById('dataForm-modulajar'));
      const endpoint = State.currentAction === 'add' ? CONFIG.endpoints.simpan : CONFIG.endpoints.ubah;

      SwalHelper.loading('Memproses...', 'Mohon tunggu');

      const result = await ApiService.post(endpoint, formData, {
        xhr: function() {
          const xhr = $.ajaxSettings.xhr();
          if (xhr.upload) {
            xhr.upload.addEventListener('progress', e => {
              if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                $('#progressBar').css('width', percent + '%').text(Math.round(percent) + '%');
              }
            }, false);
          }
          return xhr;
        }
      });

      if (result.success) {
        ModalManager.hide();
        SwalHelper.success('Data tersimpan');
        $('#progressBar').css('width', '0%').text('0%');
        window.dataTable_modulajar.ajax.reload();

        // PENTING: Reset form setelah simpan berhasil
        FormManager.reset();
      } else {
        SwalHelper.error('Gagal menyimpan data');
      }

      $btn.prop('disabled', false).text(originalText);
    }
  };

  // =====================================================
  // INITIALIZATION
  // =====================================================
  $(document).ready(function() {
    // Initialize everything
    EventHandlers.init();

    // Initialize Tujuan Modal Manager
    TujuanModalManager.init();

    // ✅ Initialize Template Pemantik Manager
    TemplatePemantikManager.init();

    // Load initial dimensi & kurikulum
    Select2Manager.loadDimensi($('#dimensi'));
    Select2Manager.loadKurikulum($('#kurikulumcinta'));

    // Initialize first tujuan select
    Select2Manager.initTujuanPembelajaran($('.select2-tujuan'));

    // JANGAN INITIALIZE DEFAULT INPUTS DISINI
    // Biarkan kosong saat pertama kali load
    // Input hanya akan di-generate saat:
    // 1. User klik "Tambah" manual
    // 2. Saat edit, load dari data existing

    console.log('ModulAjar Optimized Script initialized successfully');
  });
</script>