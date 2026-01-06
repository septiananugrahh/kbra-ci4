<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?= $title ?? 'KBRA' ?></title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url() ?>/assets/img/favicon/favicon.ico" />


  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/fonts/iconify-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />


  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- Material Design Theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

  <!-- Core CSS -->
  <!-- build:css assets/vendor/css/theme.css  -->

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />


  <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/css/core.css" />
  <link rel="stylesheet" href="<?= base_url('') ?>/assets/css/demo.css" />

  <!-- Vendors CSS -->

  <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- endbuild -->

  <link rel="stylesheet" href="<?= base_url('') ?>/assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- styling datatable -->
  <!-- styling datatable -->
  <style>
    /* Custom DataTables Theme: Pale Blue-Purple */

    /* --- General Table Styling --- */
    .dataTables_wrapper .table {
      border-collapse: collapse !important;
      width: 100%;
      margin-bottom: 1rem;
      color: #343a40;
      /* Warna teks umum */
    }

    /* Table Borders */
    .dataTables_wrapper .table th,
    .dataTables_wrapper .table td {
      border: 1px solid #e0e0f0;
      /* Border pucat */
      padding: 0.75rem;
      vertical-align: top;
    }

    /* Striped Rows (Optional, for better readability) */
    .dataTables_wrapper .table.table-striped tbody tr:nth-of-type(odd) {
      background-color: #f9f9ff;
      /* Background pucat untuk baris ganjil */
    }

    /* Hover Rows */
    .dataTables_wrapper .table.table-hover tbody tr:hover {
      background-color: #f0f0ff;
      /* Background lebih terang saat hover */
    }

    /* --- Table Header (thead) --- */
    .dataTables_wrapper .table thead th {
      background-color: #b1b2ff;
      /* Warna utama pucat untuk header */
      color: #ffffff;
      /* Teks putih di header */
      border-color: #b1b2ff;
      /* Border sesuai warna header */
      font-weight: 600;
      text-align: left;
      padding-top: 0.75rem;
      padding-bottom: 0.75rem;
    }

    /* Sorting Icons */
    .dataTables_wrapper .table thead .sorting,
    .dataTables_wrapper .table thead .sorting_asc,
    .dataTables_wrapper .table thead .sorting_desc {
      background-color: #b1b2ff;
      /* Pastikan background tetap saat sort */
      color: #ffffff;
    }

    .dataTables_wrapper .table thead .sorting:after,
    .dataTables_wrapper .table thead .sorting_asc:after,
    .dataTables_wrapper .table thead .sorting_desc:after {
      color: rgba(255, 255, 255, 0.7);
      /* Warna ikon sorting lebih terang */
    }

    /* --- Table Footer (tfoot) --- */
    .dataTables_wrapper .table tfoot th,
    .dataTables_wrapper .table tfoot td {
      background-color: #e0e0f0;
      /* Warna background footer, lebih terang dari header */
      color: #343a40;
      /* Warna teks umum */
      font-weight: 500;
    }

    /* --- Pagination Styling --- */
    .dataTables_wrapper .dataTables_paginate .pagination {
      justify-content: flex-end;
      /* Pindahkan pagination ke kanan */
      margin-top: 1rem;
      margin-bottom: 0;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item .page-link {
      color: #696cff;
      /* Teks link pagination warna utama */
      background-color: #ffffff;
      border: 1px solid #e0e0f0;
      /* Border link pagination */
      margin: 0 2px;
      border-radius: 0.25rem;
      /* Sudut sedikit membulat */
      transition: all 0.2s ease-in-out;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item .page-link:hover {
      background-color: #f0f0ff;
      /* Background pucat saat hover */
      border-color: #c8c8ff;
      color: #696cff;
      /* Tetap warna utama */
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
      background-color: #b1b2ff;
      /* Warna utama pucat saat aktif */
      border-color: #b1b2ff;
      color: #ffffff;
      /* Teks putih saat aktif */
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link {
      color: #adb5bd;
      /* Warna teks abu-abu untuk disabled */
      background-color: #ffffff;
      border-color: #e0e0f0;
    }

    /* --- Search Input & Length Select --- */
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      color: #495057;
      background-color: #ffffff;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
      border-color: #b1b2ff;
      /* Border highlight saat fokus */
      outline: 0;
      box-shadow: 0 0 0 0.25rem rgba(177, 178, 255, 0.25);
      /* Glow yang pucat */
    }

    /* --- Info Text (Showing X of Y entries) --- */
    .dataTables_wrapper .dataTables_info {
      padding-top: 0.85em;
      color: #6c757d;
      /* Warna teks abu-abu */
    }

    /* --- Spacing and Layout Adjustments (Optional) --- */
    .dataTables_wrapper .row {
      margin-left: 0;
      margin-right: 0;
    }

    .dataTables_wrapper .col-sm-12 {
      padding-left: 0;
      padding-right: 0;
    }

    /* Adjust margin for DataTables elements */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
      margin-bottom: 1rem;
      /* Tambahkan margin bawah untuk pemisah */
    }
  </style>
  <!-- styling datatable -->
  <!-- styling datatable -->

  <!-- Helpers -->
  <script src="<?= base_url('') ?>/assets/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

  <script src="<?= base_url('') ?>/assets/js/config.js"></script>
</head>

<body>
  <?php if (session('semester') == 0) { ?>
    <center>
      <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
          <h1 class="mb-2 mx-2" style="line-height: 6rem; font-size: 6rem">404</h1>
          <h4 class="mb-2 mx-2">Semester Yang Anda Pilih Belum Tersedia</h4>
          <p class="mb-6 mx-2">we couldn't find the page you are looking for</p>
          <a href="<?= base_url('/logout') ?>" class="btn btn-primary">Logout</a>
          <div class="mt-6">
            <img
              src="../assets/img/konstruksi.png"
              alt="page-misc-error-light"
              width="500"
              class="img-fluid" />
          </div>
        </div>
      </div>
    </center>
  <?php } else { ?>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span class="text-primary">
                  <svg
                    width="25"
                    viewBox="0 0 25 42"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                      <path
                        d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                        id="path-1"></path>
                      <path
                        d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                        id="path-3"></path>
                      <path
                        d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                        id="path-4"></path>
                      <path
                        d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                        id="path-5"></path>
                    </defs>
                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                        <g id="Icon" transform="translate(27.000000, 15.000000)">
                          <g id="Mask" transform="translate(0.000000, 8.000000)">
                            <mask id="mask-2" fill="white">
                              <use xlink:href="#path-1"></use>
                            </mask>
                            <use fill="currentColor" xlink:href="#path-1"></use>
                            <g id="Path-3" mask="url(#mask-2)">
                              <use fill="currentColor" xlink:href="#path-3"></use>
                              <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                            </g>
                            <g id="Path-4" mask="url(#mask-2)">
                              <use fill="currentColor" xlink:href="#path-4"></use>
                              <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                            </g>
                          </g>
                          <g
                            id="Triangle"
                            transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                            <use fill="currentColor" xlink:href="#path-5"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                          </g>
                        </g>
                      </g>
                    </g>
                  </svg>
                </span>
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2">Sneat</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
            </a>
          </div>

          <div class="menu-divider mt-0"></div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Beranda</span></li>

            <li class="menu-item <?= ($nav == 'dashboard') ? 'active' : '' ?>">
              <a href="<?= base_url('/dashboard') ?>" class="menu-link">
                <i class="ri-home-smile-line fs-3 me-2"></i>
                <div class="text-truncate">Beranda</div>
              </a>
            </li>

            <li class="menu-item <?= ($nav == 'santri') ? 'active' : '' ?>">
              <a href="<?= base_url('/santri') ?>" class="menu-link">
                <i class="ri-team-line fs-3 me-2"></i>
                <div class="text-truncate">Santri</div>
              </a>
            </li>

            <?php if (array_intersect(['3'], session('roles'))) : ?>
              <li class="menu-item <?= ($nav == 'ptk') ? 'active' : '' ?>">
                <a href="<?= base_url('/pegawai') ?>" class="menu-link">
                  <i class="ri-user-2-fill fs-3 me-2"></i>
                  <div class="text-truncate">PTK</div>
                </a>
              </li>

              <li class="menu-item <?= ($nav == 'semester') ? 'active' : '' ?>">
                <a href="<?= base_url('/semester') ?>" class="menu-link">
                  <i class="ri-calendar-2-line fs-3 me-2"></i>
                  <div class="text-truncate">Semester</div>
                </a>
              </li>

              <li class="menu-item <?= ($nav == 'kelas') ? 'active' : '' ?>">
                <a href="<?= base_url('/kelas') ?>" class="menu-link">
                  <i class="ri-layout-grid-line fs-3 me-2"></i>
                  <div class="text-truncate">Kelas</div>
                </a>
              </li>

              <li class="menu-item <?= ($nav == 'tujuanpembelajaran') ? 'active' : '' ?>">
                <a href="<?= base_url('/tujuanpembelajaran') ?>" class="menu-link">
                  <i class="ri-checkbox-multiple-line fs-3 me-2"></i>
                  <div class="text-truncate">Tujuan Pembelajaran</div>
                </a>
              </li>

              <li class="menu-item <?= ($nav == 'dimensiprofil') ? 'active' : '' ?>">
                <a href="<?= base_url('/dimensiprofil') ?>" class="menu-link">
                  <i class="ri-graduation-cap-line fs-3 me-2"></i>
                  <div class="text-truncate">Dimensi Profil Lulusan</div>
                </a>
              </li>

              <li class="menu-item <?= ($nav == 'kurikulumcinta') ? 'active' : '' ?>">
                <a href="<?= base_url('/kurikulumcinta') ?>" class="menu-link">
                  <i class="ri-heart-2-line fs-3 me-2"></i>
                  <div class="text-truncate">Kurikulum Berbasis Cinta</div>
                </a>
              </li>

            <?php endif ?>

            <?php if (array_intersect(['5'], session('roles'))) : ?>
              <li class="menu-item <?= ($nav == 'role') ? 'active' : '' ?>">
                <a href="<?= base_url('/role') ?>" class="menu-link">
                  <i class="ri-chat-check-line fs-3 me-2"></i>
                  <div class="text-truncate">Role List</div>
                </a>
              </li>
            <?php endif ?>

            <?php if (array_intersect(['4'], session('roles'))) : ?>
              <li class="menu-item <?= ($nav == 'modul_ajar') ? 'active' : '' ?>">
                <a href="<?= base_url('/modulajar') ?>" class="menu-link">
                  <i class="ri-file-chart-line fs-3 me-2"></i>
                  <div class="text-truncate">Modul Ajar</div>
                </a>
              </li>

              <li class="menu-item <?= ($nav == 'laporan_bulanan') ? 'active' : '' ?>">
                <a href="<?= base_url('/laporan-bulanan') ?>" class="menu-link">
                  <i class="ri-file-list-line fs-3 me-2"></i>
                  <div class="text-truncate">Laporan Bulanan</div>
                </a>
              </li>

              <?php //print_r(session('roles'));
              ?>

            <?php endif ?>

          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base bx bx-menu icon-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center me-auto">
                <div class="nav-item d-flex align-items-center">
                  <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                    placeholder="Search..."
                    aria-label="Search..." />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-md-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?= base_url() ?>/assets/img/avatars/5.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?= base_url() ?>/assets/img/avatars/5.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"><?= session('nama') ?></h6>
                            <small class="text-body-secondary"><?= session('username') ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?= base_url('profil') ?>">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="icon-base bx bx-cog icon-md me-3"></i><span class="flex-grow-1 align-middle">Settings</span>
                          <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?= base_url('/logout') ?>">
                        <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">


            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <?= $this->include($content) ?>
            </div>

            <!-- Bottom Navigation Bar (Mobile Only) -->
            <nav class="d-block d-md-none bg-light border-top shadow-sm fixed-bottom">
              <div class="d-flex justify-content-around text-center py-2">
                <a href="<?= base_url('dashboard') ?>" class="text-decoration-none <?= uri_string() == 'dashboard' ? 'text-primary' : 'text-dark' ?>">
                  <i class="ri-home-line" style="font-size: 24px;"></i><br>
                  <small>Home</small>
                </a>
                <?php if (array_intersect(['4'], session('roles'))) : ?>
                  <a href="<?= base_url('santri') ?>" class="text-decoration-none <?= uri_string() == 'santri' ? 'text-primary' : 'text-dark' ?>">
                    <i class="ri-book-2-line" style="font-size: 24px;"></i><br>
                    <small>Santri</small>
                  </a>
                <?php else : ?>
                  <a href="<?= base_url('kelas') ?>" class="text-decoration-none <?= uri_string() == 'kelas' ? 'text-primary' : 'text-dark' ?>">
                    <i class="ri-book-2-line" style="font-size: 24px;"></i><br>
                    <small>Kelas</small>
                  </a>
                <?php endif; ?>
                <a href="<?= base_url('modulajar') ?>" class="text-decoration-none <?= uri_string() == 'modulajar' ? 'text-primary' : 'text-dark' ?>">
                  <i class="ri-booklet-line" style="font-size: 24px;"></i><br>
                  <small>Modul Ajar</small>
                </a>
                <a href="<?= base_url('profil') ?>" class="text-decoration-none <?= uri_string() == 'profil' ? 'text-primary' : 'text-dark' ?>">
                  <i class="ri-user-line" style="font-size: 24px;"></i><br>
                  <small>Profil</small>
                </a>
              </div>
            </nav>


            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">
                    &#169;
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by
                    <a href="#" target="_blank" class="footer-link">Unnamed</a>
                  </div>

                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
  <?php } ?>
  <!-- / Layout wrapper -->

  <!-- Core JS -->


  <!-- <script src="../assets/vendor/libs/jquery/jquery.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script src="<?= base_url('') ?>/assets/vendor/libs/popper/popper.js"></script>
  <script src="<?= base_url('') ?>/assets/vendor/js/bootstrap.js"></script>

  <script src="<?= base_url('') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="<?= base_url('') ?>/assets/vendor/js/menu.js"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="<?= base_url('') ?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->

  <script src="<?= base_url('') ?>/assets/js/main.js"></script>

  <!-- Flatpickr JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- Bahasa Indonesia -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>


  <!-- Page JS -->
  <script src="<?= base_url('') ?>/assets/js/dashboards-analytics.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>