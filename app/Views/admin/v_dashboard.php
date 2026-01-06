<div class="row">

  <div class="col-xxl-12 mb-6 order-0">
    <div class="card border-0 shadow-lg modern-welcome-card">
      <div class="d-flex align-items-center row">

        <!-- Left Content -->
        <div class="col-sm-8">
          <div class="card-body text-white p-4">

            <!-- Welcome Message - Lebih Clear -->
            <div class="welcome-section mb-4">
              <div class="greeting-badge">
                <i class="ri-sun-line me-2"></i>
                <span id="greetingTime">Selamat Pagi</span>
              </div>
              <h4 class="welcome-title mb-2">
                Selamat Datang, <strong><?= session('nama') ?></strong>
              </h4>
              <p class="welcome-subtitle mb-0">
                Mari kelola pembelajaran dengan mudah dan efektif
              </p>
            </div>

            <!-- Real-time info - Redesigned -->
            <div class="info-section mb-4">
              <div class="row g-3">
                <div class="col-sm-6">
                  <div class="info-card">
                    <div class="info-icon">
                      <i class="ri-calendar-2-line"></i>
                    </div>
                    <div class="info-content">
                      <div class="info-label">Hari ini</div>
                      <div class="info-value" id="currentDate"><?= date('l, d F Y') ?></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="info-card">
                    <div class="info-icon">
                      <i class="ri-time-line"></i>
                    </div>
                    <div class="info-content">
                      <div class="info-label">Waktu</div>
                      <div class="info-value" id="currentTime"><?= date('H:i:s') ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Kelas - Enhanced -->
            <div class="class-selection mb-0">
              <label for="kelas_id" class="form-label text-white mb-3">
                <i class="ri-school-line me-2"></i>
                <span class="selection-title">Pilih Kelas Pembelajaran</span>
              </label>
              <div class="select-wrapper">
                <select name="kelas_id" id="kelas_id" class="form-select enhanced-select" required>
                  <option value="">🎯 Pilih kelas untuk memulai...</option>
                  <?php if (isset($kelasList) && is_array($kelasList)): ?>
                    <?php foreach ($kelasList as $kelas): ?>
                      <option value="<?= $kelas['id'] ?? '' ?>"
                        data-nama="<?= ($kelas['jenjang'] ?? '') . ' - ' . ($kelas['tingkat'] ?? '') . ' - ' . ($kelas['nama'] ?? '') ?>"
                        data-jenjang="<?= $kelas['jenjang'] ?? '' ?>"
                        data-tingkat="<?= $kelas['tingkat'] ?? '' ?>"
                        data-nama-kelas="<?= $kelas['nama'] ?? '' ?>"
                        <?= session("kelas_id") == ($kelas['id'] ?? '') ? 'selected' : '' ?>>
                        📚 <?= ($kelas['jenjang'] ?? '') ?> • <?= ($kelas['tingkat'] ?? '') ?> • <?= ($kelas['nama'] ?? '') ?>
                      </option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option disabled>❌ Tidak ada kelas tersedia</option>
                  <?php endif; ?>
                </select>
                <div class="select-icon">
                  <i class="ri-arrow-down-s-line"></i>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Right Icon Section - Ganti Gambar dengan Icon -->
        <div class="col-sm-4 text-center">
          <div class="icon-section">

            <!-- Main Dashboard Icon -->
            <div class="main-icon-container">
              <div class="main-icon">
                <i class="ri-dashboard-3-line"></i>
              </div>
              <div class="icon-glow"></div>
            </div>

            <!-- Floating Icons -->
            <div class="floating-icons">
              <div class="float-icon float-1">
                <i class="ri-book-2-line"></i>
              </div>
              <div class="float-icon float-2">
                <i class="ri-group-line"></i>
              </div>
              <div class="float-icon float-3">
                <i class="ri-clipboard-line"></i>
              </div>
              <div class="float-icon float-4">
                <i class="ri-star-line"></i>
              </div>
              <div class="float-icon float-5">
                <i class="ri-award-line"></i>
              </div>
              <div class="float-icon float-6">
                <i class="ri-lightbulb-line"></i>
              </div>
            </div>

            <!-- Status Indicator -->
            <div class="status-indicator">
              <div class="status-dot"></div>
              <span class="status-text">Sistem Aktif</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Class Information Section dengan NULL SAFETY -->
<div id="classInfoSection" style="display: <?= session('kelas_id') ? 'block' : 'none' ?>;">

  <!-- Quick Stats Row dengan NULL CHECKS -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="avatar avatar-md">
                <div class="avatar-initial bg-label-primary rounded">
                  <i class="ri-group-line ri-26px"></i>
                </div>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="small text-muted">Total Santri</div>
              <h5 class="mb-0" id="totalSantri">
                <?= isset($kelasInfo['total_santri']) ? $kelasInfo['total_santri'] : '0' ?>
              </h5>
              <small class="text-success" id="santriGrowth">
                <i class="ri-arrow-up-s-line"></i>
                <span>+<?= isset($kelasInfo['santri_growth']) ? $kelasInfo['santri_growth'] : '0' ?> bulan ini</span>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="avatar avatar-md">
                <div class="avatar-initial bg-label-success rounded">
                  <i class="ri-book-open-line ri-26px"></i>
                </div>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="small text-muted">Modul Ajar</div>
              <h5 class="mb-0" id="totalModul">
                <?= isset($kelasInfo['total_modul']) ? $kelasInfo['total_modul'] : '0' ?>
              </h5>
              <small class="text-info">
                <i class="ri-calendar-line"></i>
                <span>Semester ini</span>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="avatar avatar-md">
                <div class="avatar-initial bg-label-warning rounded">
                  <i class="ri-clipboard-line ri-26px"></i>
                </div>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="small text-muted">Asesmen</div>
              <h5 class="mb-0" id="totalAsesmen">
                <?= isset($kelasInfo['total_asesmen']) ? $kelasInfo['total_asesmen'] : '0' ?>
              </h5>
              <small class="text-warning">
                <i class="ri-time-line"></i>
                <span>Minggu ini</span>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="avatar avatar-md">
                <div class="avatar-initial bg-label-info rounded">
                  <i class="ri-trophy-line ri-26px"></i>
                </div>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="small text-muted">Progress</div>
              <h5 class="mb-0" id="progressRate">
                <?= isset($kelasInfo['progress_rate']) ? $kelasInfo['progress_rate'] : '0' ?>%
              </h5>
              <small class="text-primary">
                <i class="ri-trending-up-line"></i>
                <span>Capaian</span>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Row -->
  <div class="row">
    <!-- Class Details dengan ERROR HANDLING -->
    <div class="col-lg-8 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header border-0 pb-0">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
              <i class="ri-information-line me-2" style="color: #696cff;"></i>
              Informasi Kelas
            </h5>
            <!-- <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="ri-more-line"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= base_url('kelas') ?>">
                    <i class="ri-edit-line me-2"></i>Edit Kelas</a></li>
                <li><a class="dropdown-item" href="<?= base_url('santri') ?>">
                    <i class="ri-group-line me-2"></i>Kelola Santri</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?= base_url('modulajar') ?>">
                    <i class="ri-book-line me-2"></i>Modul Ajar</a></li>
                <li><a class="dropdown-item" href="<?= base_url('asesmen') ?>">
                    <i class="ri-clipboard-line me-2"></i>Asesmen</a></li>
              </ul>
            </div> -->
          </div>
        </div>

        <div class="card-body pt-2">
          <div class="row g-3">
            <!-- Basic Info dengan SAFE ACCESS -->
            <div class="col-md-6">
              <div class="d-flex align-items-start">
                <div class="avatar avatar-sm me-3">
                  <div class="avatar-initial rounded" style="background: #696cff20; color: #696cff;">
                    <i class="ri-school-line ri-20px"></i>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1" id="kelasNamaLengkap">
                    <?= isset($kelasInfo['nama_lengkap']) ? $kelasInfo['nama_lengkap'] : 'Pilih kelas' ?>
                  </h6>
                  <p class="text-muted small mb-0">Nama Kelas</p>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start">
                <div class="avatar avatar-sm me-3">
                  <div class="avatar-initial rounded" style="background: #696cff20; color: #696cff;">
                    <i class="ri-user-star-line ri-20px"></i>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1" id="waliKelas">
                    <?= isset($kelasInfo['wali_kelas']) ? $kelasInfo['wali_kelas'] : 'Belum ada wali' ?>
                  </h6>
                  <p class="text-muted small mb-0">Wali Kelas</p>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start">
                <div class="avatar avatar-sm me-3">
                  <div class="avatar-initial rounded" style="background: #28c76f20; color: #28c76f;">
                    <i class="ri-team-line ri-20px"></i>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1" id="partnerGuru">
                    <?= isset($kelasInfo['partner_guru']) ? $kelasInfo['partner_guru'] : 'Belum ada partner' ?>
                  </h6>
                  <p class="text-muted small mb-0">Partner Mengajar</p>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex align-items-start">
                <div class="avatar avatar-sm me-3">
                  <div class="avatar-initial rounded" style="background: #ff9f4320; color: #ff9f43;">
                    <i class="ri-calendar-check-line ri-20px"></i>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-1" id="tahunAjaran">
                    <?php if (isset($kelasInfo['tahun']) && isset($kelasInfo['semester'])): ?>
                      <?= $kelasInfo['tahun'] ?> - <?= $kelasInfo['semester'] ?>
                    <?php else: ?>
                      <?= session('tahun') ?> - <?= session('semester') ?>
                    <?php endif; ?>
                  </h6>
                  <p class="text-muted small mb-0">Tahun & Semester</p>
                </div>
              </div>
            </div>

            <!-- Additional Info dengan SAFE ACCESS -->
            <div class="col-12 mt-3">
              <div class="border-top pt-3">
                <div class="row g-2">
                  <div class="col-md-4 text-center">
                    <div class="border rounded p-2">
                      <h5 class="mb-1 text-primary" id="santriPutra">
                        <?= isset($kelasInfo['santri_putra']) ? $kelasInfo['santri_putra'] : '0' ?>
                      </h5>
                      <small class="text-muted">Santri Putra</small>
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="border rounded p-2">
                      <h5 class="mb-1 text-success" id="santriPutri">
                        <?= isset($kelasInfo['santri_putri']) ? $kelasInfo['santri_putri'] : '0' ?>
                      </h5>
                      <small class="text-muted">Santri Putri</small>
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="border rounded p-2">
                      <h5 class="mb-1 text-warning" id="santriAktif">
                        <?= isset($kelasInfo['santri_aktif']) ? $kelasInfo['santri_aktif'] : '0' ?>
                      </h5>
                      <small class="text-muted">Status Aktif</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activities & Quick Actions -->
    <div class="col-lg-4">
      <!-- Quick Actions -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header border-0 pb-0">
          <h6 class="card-title mb-0">
            <i class="ri-rocket-line me-2" style="color: #696cff;"></i>
            Quick Actions
          </h6>
        </div>
        <div class="card-body pt-2">
          <div class="d-grid gap-2">
            <a href="<?= base_url('modulajar/add') ?>" class="btn btn-outline-primary btn-sm">
              <i class="ri-add-line me-2"></i>Tambah Modul Ajar
            </a>
            <a href="<?= base_url('asesmen') ?>" class="btn btn-outline-success btn-sm">
              <i class="ri-clipboard-line me-2"></i>Input Asesmen
            </a>
            <a href="<?= base_url('santri') ?>" class="btn btn-outline-info btn-sm">
              <i class="ri-group-line me-2"></i>Kelola Santri
            </a>
          </div>
        </div>
      </div>

      <!-- Recent Activities dengan NULL SAFETY -->
      <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">
              <i class="ri-history-line me-2" style="color: #696cff;"></i>
              Aktivitas Terbaru
            </h6>
            <a href="<?= base_url('logs') ?>" class="btn btn-sm btn-link p-0">Lihat Semua</a>
          </div>
        </div>
        <div class="card-body pt-2">
          <div id="recentActivities">
            <?php if (isset($kelasInfo['recent_activities']) && !empty($kelasInfo['recent_activities'])): ?>
              <?php foreach ($kelasInfo['recent_activities'] as $activity): ?>
                <div class="d-flex align-items-start mb-3">
                  <div class="avatar avatar-xs me-2">
                    <div class="avatar-initial rounded-circle <?= getActivityBgClass($activity['type'] ?? 'default') ?>">
                      <i class="<?= getActivityIcon($activity['type'] ?? 'default') ?> ri-12px"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <p class="mb-0 small"><?= esc($activity['description'] ?? 'Aktivitas unknown') ?></p>
                    <small class="text-muted"><?= esc($activity['time_ago'] ?? 'Waktu unknown') ?></small>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-center text-muted">
                <i class="ri-inbox-line ri-24px mb-2"></i>
                <p class="small">Belum ada aktivitas atau pilih kelas dulu</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// Helper functions dengan ERROR HANDLING
function getActivityIcon($type)
{
  $icons = [
    'modul_add' => 'ri-add-line',
    'asesmen_update' => 'ri-edit-line',
    'foto_upload' => 'ri-camera-line',
    'santri_add' => 'ri-group-line',
    'default' => 'ri-circle-line'
  ];
  return isset($icons[$type]) ? $icons[$type] : $icons['default'];
}

function getActivityBgClass($type)
{
  $classes = [
    'modul_add' => 'bg-success',
    'asesmen_update' => 'bg-primary',
    'foto_upload' => 'bg-warning',
    'santri_add' => 'bg-info',
    'default' => 'bg-secondary'
  ];
  return isset($classes[$type]) ? $classes[$type] : $classes['default'];
}
?>

<!-- Enhanced CSS tetap sama -->
<style>
  .card {
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(105, 108, 255, 0.15) !important;
  }

  .avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
  }

  .text-white-50 {
    color: rgba(255, 255, 255, 0.5) !important;
  }

  .btn-outline-primary:hover {
    background-color: #696cff !important;
    border-color: #696cff !important;
  }

  .form-select:focus {
    border-color: #696cff;
    box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
  }

  .card-title {
    font-weight: 600;
  }

  #recentActivities .avatar-xs {
    width: 24px;
    height: 24px;
  }

  #recentActivities .avatar-xs .avatar-initial {
    font-size: 10px;
    width: 24px;
    height: 24px;
  }

  .bg-label-primary {
    background-color: rgba(105, 108, 255, 0.1) !important;
    color: #696cff !important;
  }

  .bg-label-success {
    background-color: rgba(40, 199, 111, 0.1) !important;
    color: #28c76f !important;
  }

  .bg-label-warning {
    background-color: rgba(255, 159, 67, 0.1) !important;
    color: #ff9f43 !important;
  }

  .bg-label-info {
    background-color: rgba(0, 207, 232, 0.1) !important;
    color: #00cfe8 !important;
  }

  .border {
    border-color: #e9ecef !important;
  }

  /* ✅ FIX UNTUK COMPATIBILITY */
  .dashboard-safe {
    min-height: 1px;
  }

  .card-safe {
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, .125);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
  }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  // Enhanced JavaScript dengan ERROR HANDLING
  $(document).ready(function() {
    console.log('Dashboard loading...');
    console.log('kelasInfo:', <?= json_encode($kelasInfo ?? []) ?>);

    // Real-time clock dengan error handling
    function updateTime() {
      try {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        $('#currentTime').text(timeString);
      } catch (e) {
        console.error('Time update error:', e);
      }
    }
    setInterval(updateTime, 1000);

    // Load class info jika sudah ada kelas terpilih
    const currentKelasId = $('#kelas_id').val();
    console.log('Current kelas ID:', currentKelasId);

    if (currentKelasId) {
      loadEnhancedClassInfo(currentKelasId);
      $('#classInfoSection').show();
    }

    // Event handler dengan error handling
    $('#kelas_id').on('change', function() {
      const kelasId = $(this).val();
      const kelasNama = $(this).find(':selected').data('nama') || 'Kelas';

      console.log('Kelas changed:', kelasId, kelasNama);

      if (kelasId) {
        Swal.fire({
          title: 'Memproses...',
          text: 'Mohon tunggu',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          url: '<?= site_url('dashboard/set_kelas') ?>',
          method: 'POST',
          data: {
            kelas_id: kelasId
          },
          timeout: 10000, // 10 second timeout
          success: function(res) {
            console.log('Set kelas response:', res);

            if (res && res.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Kelas Terpilih',
                text: `Kelas "${kelasNama}" berhasil dipilih.`,
                timer: 2000,
                showConfirmButton: false
              });

              // Load enhanced info
              loadEnhancedClassInfo(kelasId);
              $('#classInfoSection').fadeIn();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res ? res.message || 'Gagal memilih kelas.' : 'Response tidak valid',
              });
            }
          },
          error: function(xhr, status, error) {
            console.error('Set kelas error:', xhr, status, error);
            Swal.fire({
              icon: 'error',
              title: 'Terjadi Kesalahan',
              text: `Tidak dapat terhubung ke server: ${error}`,
            });
          }
        });
      } else {
        $('#classInfoSection').fadeOut();
      }
    });

    // Load enhanced class info dengan error handling
    function loadEnhancedClassInfo(kelasId) {
      console.log('Loading enhanced class info for:', kelasId);

      $.ajax({
        url: '<?= site_url('dashboard/get_enhanced_class_info') ?>',
        method: 'GET',
        data: {
          kelas_id: kelasId
        },
        timeout: 10000,
        success: function(res) {
          console.log('Enhanced class info response:', res);

          if (res && res.status === 'success' && res.data) {
            updateClassDisplay(res.data);
          } else {
            console.warn('Enhanced class info: Invalid response or no data');
            setDefaultClassInfo();
          }
        },
        error: function(xhr, status, error) {
          console.error('Enhanced class info error:', xhr.status, error);
          setDefaultClassInfo();
        }
      });
    }

    // Update class display dengan NULL SAFETY
    function updateClassDisplay(data) {
      try {
        $('#kelasNamaLengkap').text(data.nama_lengkap || 'Kelas tidak diketahui');
        $('#waliKelas').text(data.wali_kelas || 'Belum ada wali');
        $('#partnerGuru').text(data.partner_guru || 'Belum ada partner');
        $('#totalSantri').text(data.total_santri || '0');
        $('#santriPutra').text(data.santri_putra || '0');
        $('#santriPutri').text(data.santri_putri || '0');
        $('#santriAktif').text(data.santri_aktif || '0');
        $('#totalModul').text(data.total_modul || '0');
        $('#totalAsesmen').text(data.total_asesmen || '0');
        $('#progressRate').text((data.progress_rate || '0') + '%');
        $('#santriGrowth span').text('+' + (data.santri_growth || '0') + ' bulan ini');
        $('#tahunAjaran').text((data.tahun || '') + ' - ' + (data.semester || ''));

        // Update recent activities
        if (data.recent_activities && Array.isArray(data.recent_activities)) {
          updateRecentActivities(data.recent_activities);
        }

        // Animate counters
        animateCounters();

        console.log('Class display updated successfully');
      } catch (e) {
        console.error('Error updating class display:', e);
        setDefaultClassInfo();
      }
    }

    // Set default info jika error
    function setDefaultClassInfo() {
      $('#kelasNamaLengkap').text('Pilih kelas untuk melihat info');
      $('#waliKelas').text('Belum ada wali');
      $('#partnerGuru').text('Belum ada partner');
      $('#totalSantri').text('0');
      $('#santriPutra').text('0');
      $('#santriPutri').text('0');
      $('#santriAktif').text('0');
      $('#totalModul').text('0');
      $('#totalAsesmen').text('0');
      $('#progressRate').text('0%');
      $('#santriGrowth span').text('+0 bulan ini');

      $('#recentActivities').html(`
      <div class="text-center text-muted">
        <i class="ri-inbox-line ri-24px mb-2"></i>
        <p class="small">Pilih kelas untuk melihat aktivitas</p>
      </div>
    `);
    }

    // Update recent activities dengan error handling
    function updateRecentActivities(activities) {
      let html = '';
      try {
        if (activities && activities.length > 0) {
          activities.forEach(activity => {
            const iconClass = getActivityIcon(activity.type || 'default');
            const bgClass = getActivityBgClass(activity.type || 'default');

            html += `
            <div class="d-flex align-items-start mb-3">
              <div class="avatar avatar-xs me-2">
                <div class="avatar-initial rounded-circle ${bgClass}">
                  <i class="${iconClass} ri-12px"></i>
                </div>
              </div>
              <div class="flex-grow-1">
                <p class="mb-0 small">${activity.description || 'Aktivitas tidak diketahui'}</p>
                <small class="text-muted">${activity.time_ago || 'Waktu tidak diketahui'}</small>
              </div>
            </div>
          `;
          });
        } else {
          html = `
          <div class="text-center text-muted">
            <i class="ri-inbox-line ri-24px mb-2"></i>
            <p class="small">Belum ada aktivitas</p>
          </div>
        `;
        }

        $('#recentActivities').html(html);
      } catch (e) {
        console.error('Error updating activities:', e);
        $('#recentActivities').html('<div class="text-center text-muted"><p class="small">Error loading activities</p></div>');
      }
    }

    // Animate counters dengan error handling
    function animateCounters() {
      try {
        $('.card h5').each(function() {
          const $this = $(this);
          const text = $this.text();
          const countTo = parseInt(text.replace(/[^\d]/g, ''));

          if (countTo > 0 && !isNaN(countTo)) {
            $({
              countNum: 0
            }).animate({
              countNum: countTo
            }, {
              duration: 1000,
              easing: 'linear',
              step: function() {
                const suffix = text.replace(/[\d]/g, '');
                $this.text(Math.floor(this.countNum) + suffix);
              },
              complete: function() {
                $this.text(text);
              }
            });
          }
        });
      } catch (e) {
        console.error('Error animating counters:', e);
      }
    }

    // Activity helper functions
    function getActivityIcon(type) {
      const icons = {
        'modul_add': 'ri-add-line',
        'asesmen_update': 'ri-edit-line',
        'foto_upload': 'ri-camera-line',
        'santri_add': 'ri-group-line',
        'default': 'ri-circle-line'
      };
      return icons[type] || icons['default'];
    }

    function getActivityBgClass(type) {
      const classes = {
        'modul_add': 'bg-success',
        'asesmen_update': 'bg-primary',
        'foto_upload': 'bg-warning',
        'santri_add': 'bg-info',
        'default': 'bg-secondary'
      };
      return classes[type] || classes['default'];
    }

    console.log('Dashboard initialized successfully');
  });
</script>

<!-- Enhanced CSS for Modern Look -->
<style>
  /* ===== MODERN WELCOME CARD STYLES ===== */
  .modern-welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6B73FF 100%);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    min-height: 320px;
  }

  .modern-welcome-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    pointer-events: none;
  }

  .card-body {
    position: relative;
    z-index: 2;
  }

  /* Welcome Section */
  .welcome-section {
    position: relative;
  }

  .greeting-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  .welcome-title {
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    color: white;
  }

  .welcome-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 400;
    line-height: 1.4;
    color: white
  }

  /* Info Section */
  .info-section {
    margin: 1.5rem 0;
  }

  .info-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
  }

  .info-card:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
  }

  .info-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    font-size: 1.2rem;
    color: white;
  }

  .info-content {
    flex: 1;
  }

  .info-label {
    font-size: 0.75rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 2px;
  }

  .info-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: white;
  }

  /* Class Selection */
  .class-selection {
    position: relative;
  }

  .selection-title {
    font-size: 1rem;
    font-weight: 600;
  }

  .select-wrapper {
    position: relative;
  }

  .enhanced-select {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    border-radius: 12px;
    padding: 1rem 3rem 1rem 1rem;
    font-size: 0.95rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
    appearance: none;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .enhanced-select:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
    color: white;
  }

  .enhanced-select option {
    background: #2d3748;
    color: white;
    padding: 10px;
  }

  .select-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    pointer-events: none;
    font-size: 1.2rem;
    opacity: 0.8;
  }

  /* Icon Section - Pengganti Gambar */
  .icon-section {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
  }

  .main-icon-container {
    position: relative;
    margin-bottom: 2rem;
  }

  .main-icon {
    width: 120px;
    height: 120px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 2;
    animation: mainIconPulse 3s ease-in-out infinite;
  }

  .icon-glow {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
    border-radius: 50%;
    filter: blur(20px);
    animation: glowPulse 2s ease-in-out infinite alternate;
  }

  /* Floating Icons */
  .floating-icons {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }

  .float-icon {
    position: absolute;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: floatAnim 4s ease-in-out infinite;
  }

  .float-1 {
    top: 10%;
    left: 10%;
    animation-delay: 0s;
  }

  .float-2 {
    top: 15%;
    right: 15%;
    animation-delay: 0.5s;
  }

  .float-3 {
    top: 60%;
    left: 5%;
    animation-delay: 1s;
  }

  .float-4 {
    bottom: 20%;
    right: 10%;
    animation-delay: 1.5s;
  }

  .float-5 {
    top: 45%;
    left: 80%;
    animation-delay: 2s;
  }

  .float-6 {
    bottom: 40%;
    left: 20%;
    animation-delay: 2.5s;
  }

  /* Status Indicator */
  .status-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
  }

  .status-dot {
    width: 8px;
    height: 8px;
    background: #28a745;
    border-radius: 50%;
    animation: statusBlink 2s ease-in-out infinite;
  }

  .status-text {
    font-size: 0.8rem;
    color: white;
    opacity: 0.9;
    font-weight: 500;
  }

  /* Animations */
  @keyframes mainIconPulse {

    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.05);
    }
  }

  @keyframes glowPulse {
    0% {
      opacity: 0.5;
    }

    100% {
      opacity: 0.8;
    }
  }

  @keyframes floatAnim {

    0%,
    100% {
      transform: translateY(0px) rotate(0deg);
    }

    33% {
      transform: translateY(-10px) rotate(5deg);
    }

    66% {
      transform: translateY(5px) rotate(-3deg);
    }
  }

  @keyframes statusBlink {

    0%,
    100% {
      opacity: 1;
    }

    50% {
      opacity: 0.3;
    }
  }

  /* Responsive */
  @media (max-width: 768px) {
    .modern-welcome-card {
      min-height: 280px;
    }

    .welcome-title {
      font-size: 1.5rem;
    }

    .info-card {
      padding: 0.75rem;
    }

    .info-icon {
      width: 35px;
      height: 35px;
      font-size: 1rem;
    }

    .main-icon {
      width: 80px;
      height: 80px;
      font-size: 2.5rem;
    }

    .float-icon {
      width: 30px;
      height: 30px;
      font-size: 1rem;
    }
  }

  @media (max-width: 576px) {
    .card-body {
      padding: 1.5rem !important;
    }

    .welcome-title {
      font-size: 1.3rem;
    }

    .info-section .row {
      --bs-gutter-x: 0.5rem;
    }

    .enhanced-select {
      padding: 0.875rem 2.5rem 0.875rem 0.875rem;
      font-size: 0.9rem;
    }

    .main-icon {
      width: 70px;
      height: 70px;
      font-size: 2rem;
    }

    .icon-section {
      padding: 1rem 0.5rem;
    }
  }

  /* Enhanced focus states for accessibility */
  .enhanced-select:focus-visible {
    outline: 2px solid rgba(255, 255, 255, 0.6);
    outline-offset: 2px;
  }

  /* Smooth entrance animation */
  .modern-welcome-card {
    animation: slideInUp 0.6s ease-out;
  }

  @keyframes slideInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<script>
  // Enhanced JavaScript untuk welcome card
  $(document).ready(function() {
    console.log('Modern welcome card loaded...');

    // Dynamic greeting berdasarkan waktu
    function updateGreeting() {
      const hour = new Date().getHours();
      let greeting = 'Selamat Malam';

      if (hour >= 5 && hour < 12) greeting = 'Selamat Pagi';
      else if (hour >= 12 && hour < 15) greeting = 'Selamat Siang';
      else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';

      $('#greetingTime').text(greeting);
    }

    // Real-time clock dengan format Indonesia
    function updateTime() {
      try {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        const dateString = now.toLocaleDateString('id-ID', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });

        $('#currentTime').text(timeString);
        $('#currentDate').text(dateString);
      } catch (e) {
        console.error('Time update error:', e);
      }
    }

    // Initialize
    updateGreeting();
    updateTime();

    // Update setiap menit untuk greeting, setiap detik untuk waktu
    setInterval(updateGreeting, 60000);
    setInterval(updateTime, 1000);

    // Enhanced select interaction
    $('#kelas_id').on('change focus', function() {
      const $select = $(this);
      const $wrapper = $select.closest('.select-wrapper');

      if ($select.val()) {
        $wrapper.addClass('has-selection');
      } else {
        $wrapper.removeClass('has-selection');
      }
    });

    // Set initial state
    if ($('#kelas_id').val()) {
      $('.select-wrapper').addClass('has-selection');
    }

    // Add hover effects to info cards
    $('.info-card').on('mouseenter', function() {
      $(this).find('.info-icon').css('transform', 'scale(1.1)');
    }).on('mouseleave', function() {
      $(this).find('.info-icon').css('transform', 'scale(1)');
    });

    // Interactive main icon click
    $('.main-icon').on('click', function() {
      $(this).css('animation', 'none');
      setTimeout(() => {
        $(this).css('animation', 'mainIconPulse 3s ease-in-out infinite');
      }, 100);

      // Show fun message
      const messages = [
        '🎯 Dashboard siap melayani!',
        '📚 Sistem pembelajaran aktif!',
        '⭐ Semangat mengajar hari ini!',
        '🚀 Mari kelola kelas dengan efektif!'
      ];

      const randomMessage = messages[Math.floor(Math.random() * messages.length)];

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: randomMessage,
          timer: 1500,
          showConfirmButton: false,
          position: 'top-end',
          toast: true,
          background: '#667eea',
          color: 'white'
        });
      }
    });

    console.log('Modern welcome card initialized successfully');
  });

  // CSS enhancement untuk has-selection state
  $('<style>').text(`
    .select-wrapper.has-selection .enhanced-select {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(40, 167, 69, 0.8);
    }
    
    .info-icon {
        transition: transform 0.3s ease;
    }
    
    .main-icon {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    
    .main-icon:hover {
        transform: scale(1.05);
    }
    
    .main-icon:active {
        transform: scale(0.98);
    }
`).appendTo('head');
</script>