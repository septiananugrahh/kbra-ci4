<style>
  /* Konsisten dengan styling modul ajar */
  .card {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: none;
  }

  .card-body {
    padding: 2rem;
  }

  .page-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
  }

  .page-header h4 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .modul-info {
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    color: #4a5568;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
  }

  .modul-info strong {
    font-weight: 600;
    color: #2d3748;
  }

  .action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
  }

  .table-container {
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  }

  .table {
    margin-bottom: 0;
  }

  .table thead {
    background: linear-gradient(to right, #f7fafc, #edf2f7);
  }

  .table thead th {
    font-weight: 600;
    color: #4a5568;
    border-bottom: 2px solid #e2e8f0;
    padding: 1rem;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
  }

  .table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f7fafc;
  }

  .table tbody tr:hover {
    background-color: #f7fafc;
  }

  .table tbody td {
    padding: 1rem;
    vertical-align: middle;
  }

  .tanggal-link {
    color: #8b9dc3;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
  }

  .tanggal-link:hover {
    color: #667eea;
  }

  .tanggal-link::before {
    content: '📅';
    margin-right: 0.5rem;
  }

  .btn-download-main {
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    border: none;
    color: #4a5568;
    padding: 0.625rem 1.5rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    transition: all 0.2s ease;
  }

  .btn-download-main:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    color: #2d3748;
  }

  .dropdown-menu {
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    padding: 0.5rem;
    z-index: 1050;
    min-width: 200px;
  }

  .dropdown-item {
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    white-space: nowrap;
  }

  .dropdown-item:hover {
    background-color: #eef2ff;
    color: #667eea;
  }

  .dropdown-item i {
    font-size: 1.1rem;
  }

  .badge-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    color: #4a5568;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.875rem;
  }

  .action-cell {
    text-align: center;
  }

  .btn-outline-secondary {
    border: 1.5px solid #e2e8f0;
    color: #718096;
    transition: all 0.2s ease;
    background: white;
  }

  .btn-outline-secondary:hover {
    background-color: #eef2ff;
    border-color: #b8c5f5;
    color: #667eea;
  }

  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #a0aec0;
  }

  .empty-state i {
    font-size: 4rem;
    opacity: 0.3;
    margin-bottom: 1rem;
  }

  .download-type-icon {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #b8c5f5 0%, #d4c5e8 100%);
    color: #4a5568;
    border-radius: 6px;
    margin-right: 0.75rem;
    flex-shrink: 0;
  }

  .stats-info {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
  }

  .stat-item {
    background: rgba(255, 255, 255, 0.9);
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  }

  .stat-item i {
    font-size: 1.25rem;
    color: #8b9dc3;
  }

  .stat-item span {
    font-weight: 600;
    color: #2d3748;
  }

  /* Fix z-index issues */
  .dropdown {
    position: relative;
    z-index: 1;
  }

  .dropdown.show {
    z-index: 1060;
  }

  .dropdown-toggle::after {
    margin-left: 0.5rem;
  }

  /* Mobile Responsive */
  @media (max-width: 768px) {
    .card-body {
      padding: 1rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .modul-info {
      padding: 1rem;
    }

    .modul-info strong {
      font-size: 1rem;
    }

    .action-bar {
      flex-direction: column;
      align-items: stretch;
      gap: 1rem;
    }

    .action-bar>div:first-child {
      text-align: center;
    }

    .btn-download-main {
      width: 100%;
      justify-content: center;
      display: flex;
      align-items: center;
    }

    .stats-info {
      justify-content: center;
      flex-wrap: wrap;
    }

    /* Mobile Table Redesign */
    .table-container {
      overflow-x: visible;
    }

    .table thead {
      display: none;
    }

    .table tbody {
      display: block;
    }

    .table tbody tr {
      display: block;
      margin-bottom: 1rem;
      border: 1px solid #e2e8f0;
      border-radius: 0.5rem;
      padding: 1rem;
      background: white;
    }

    .table tbody tr:hover {
      background: #f7fafc;
    }

    .table tbody td {
      display: block;
      text-align: left !important;
      padding: 0.75rem 0;
      border: none;
    }

    .table tbody td:first-child {
      padding-top: 0;
    }

    .table tbody td:last-child {
      padding-bottom: 0;
    }

    .table tbody td::before {
      content: attr(data-label);
      font-weight: 600;
      display: block;
      margin-bottom: 0.5rem;
      color: #718096;
      font-size: 0.875rem;
      text-transform: uppercase;
    }

    .badge-number {
      margin-bottom: 0.5rem;
    }

    .tanggal-link {
      font-size: 1rem;
      padding: 0.5rem 0;
      display: block;
    }

    .action-cell {
      text-align: left !important;
      margin-top: 0.5rem;
    }

    .action-cell .dropdown {
      width: 100%;
    }

    .action-cell .btn {
      width: 100%;
      justify-content: center;
    }

    .dropdown-menu {
      width: 100%;
      left: 0 !important;
      right: 0 !important;
      transform: none !important;
      margin-top: 0.5rem;
      position: absolute !important;
    }

    .dropdown-item {
      padding: 1rem;
      font-size: 1rem;
    }

    .download-type-icon {
      width: 32px;
      height: 32px;
    }
  }

  /* Tablet adjustments */
  @media (min-width: 769px) and (max-width: 1024px) {
    .card-body {
      padding: 1.5rem;
    }

    .action-bar {
      gap: 1.5rem;
    }

    .table tbody td {
      padding: 0.875rem;
    }
  }

  /* Prevent body scroll when dropdown is open on mobile */
  @media (max-width: 768px) {
    body.dropdown-open {
      overflow: hidden;
    }
  }
</style>

<script>
  // Handle dropdown on mobile to prevent scroll issues
  document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) {
      const dropdowns = document.querySelectorAll('.dropdown-toggle');
      dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function() {
          document.body.classList.toggle('dropdown-open');
        });
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
          document.body.classList.remove('dropdown-open');
        }
      });
    }
  });
</script>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <!-- Page Header -->
        <div class="page-header">
          <h4>
            <i class="ri-clipboard-line me-2"></i>
            Asesmen Pembelajaran
          </h4>
        </div>

        <!-- Modul Info Card -->
        <div class="modul-info">
          <div class="mb-1" style="opacity: 0.8; font-size: 0.875rem;">Modul Pembelajaran</div>
          <strong style="font-size: 1.1rem;">
            <?= esc($modul_ajar['subtopik_pembelajaran']) ?>
          </strong>
          <div class="stats-info">
            <div class="stat-item">
              <i class="ri-calendar-check-line"></i>
              <span><?= count($tanggalList) ?> Pertemuan</span>
            </div>
          </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
          <div>
            <h6 class="mb-1 text-muted">Pilih Tanggal Asesmen</h6>
            <small class="text-muted">Klik tanggal untuk mengisi asesmen</small>
          </div>

          <div class="dropdown">
            <button class="btn btn-primary btn-download-main dropdown-toggle" type="button" id="dropdownDownloadAll" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ri-download-cloud-line me-2"></i>
              Download Semua
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownDownloadAll">
              <li>
                <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/0/checklist') ?>">
                  <span class="download-type-icon">
                    <i class="ri-checkbox-multiple-line"></i>
                  </span>
                  Checklist
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/0/fotoseri') ?>">
                  <span class="download-type-icon">
                    <i class="ri-image-line"></i>
                  </span>
                  Foto Berseri
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/0/hastakarya') ?>">
                  <span class="download-type-icon">
                    <i class="ri-palette-line"></i>
                  </span>
                  Hasil Karya
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/0/anekdot') ?>">
                  <span class="download-type-icon">
                    <i class="ri-chat-quote-line"></i>
                  </span>
                  Anekdot
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Table -->
        <div class="table-container">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 80px;">No.</th>
                <th>Tanggal Asesmen</th>
                <th style="width: 200px;" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($tanggalList)): ?>
                <tr>
                  <td colspan="3" class="empty-state">
                    <i class="ri-calendar-close-line"></i>
                    <p class="mb-0">Belum ada jadwal asesmen</p>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($tanggalList as $key => $tanggal): ?>
                  <tr>
                    <td data-label="No.">
                      <span class="badge-number"><?= esc($key + 1) ?></span>
                    </td>
                    <td data-label="Tanggal Asesmen">
                      <a href="<?= site_url('asesmen/form/' . $modul_ajar['id'] . '/' . ($key + 1)) ?>" class="tanggal-link">
                        <?= esc($tanggal) ?>
                      </a>
                    </td>
                    <td data-label="Download" class="action-cell">
                      <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton<?= esc($key) ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ri-download-line me-1"></i>
                          Download
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= esc($key) ?>">
                          <li>
                            <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/' . ($key + 1) . '/checklist') ?>">
                              <span class="download-type-icon">
                                <i class="ri-checkbox-multiple-line"></i>
                              </span>
                              Checklist
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/' . ($key + 1) . '/fotoseri') ?>">
                              <span class="download-type-icon">
                                <i class="ri-image-line"></i>
                              </span>
                              Foto Berseri
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/' . ($key + 1) . '/hastakarya') ?>">
                              <span class="download-type-icon">
                                <i class="ri-palette-line"></i>
                              </span>
                              Hasil Karya
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="<?= site_url('asesmen/download/' . $modul_ajar['id'] . '/' . ($key + 1) . '/anekdot') ?>">
                              <span class="download-type-icon">
                                <i class="ri-chat-quote-line"></i>
                              </span>
                              Anekdot
                            </a>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>