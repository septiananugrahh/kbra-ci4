<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');


$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth', ['filter' => 'csrf']);
$routes->get('logout', 'Login::logout');
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->post('dashboard/set_kelas', 'Dashboard::setKelas');
$routes->get('/akses-ditolak', 'Dashboard::aksesDitolak');

$routes->get('dashboard/get_enhanced_class_info', 'Dashboard::get_enhanced_class_info');

$routes->get('dashboard/debug_logs', 'Dashboard::debug_logs');
$routes->get('dashboard/debug_system', 'Dashboard::debug_system');
$routes->get('dashboard/force_enable_logs', 'Dashboard::force_enable_logs');
$routes->get('dashboard/test_dashboard_errors', 'Dashboard::test_dashboard_errors');
// return $this->render('admin/v_dashboard', $data);
// $routes->post('proses-pilih-kelas', 'Dashboard::prosesPilihKelas');



// start pegawai  
// start pegawai  
$routes->get('pegawai', 'Pegawai::index', ['filter' => 'auth']);
$routes->post('pegawai/ambil_data_pegawai', 'Pegawai::ambil_data_pegawai', ['filter' => 'auth']);
$routes->post('pegawai/simpandata', 'Pegawai::simpandata', ['filter' => 'auth']);
$routes->post('pegawai/ubahdata', 'Pegawai::ubahdata', ['filter' => 'auth']);
$routes->post('pegawai/hapusdata_soft', 'Pegawai::hapusdata_soft', ['filter' => 'auth']);
$routes->get('pegawai/get_roles_by_user/(:num)', 'Pegawai::get_roles_by_user/$1', ['filter' => 'auth']);
$routes->get('pegawai/get_all_roles', 'Pegawai::get_all_roles', ['filter' => 'auth']);
$routes->post('pegawai/tambah_role', 'Pegawai::tambah_role', ['filter' => 'auth']);
$routes->post('pegawai/hapus_role', 'Pegawai::hapus_role', ['filter' => 'auth']);
// end pegawai  
// end pegawai  


// start role
// start role
$routes->get('role', 'Role::index', ['filter' => 'auth']);
$routes->post('role/ambil_data_role', 'Role::ambil_data_role', ['filter' => 'auth']);
$routes->post('role/simpandata', 'Role::simpandata', ['filter' => 'auth']);
$routes->post('role/ubahdata', 'Role::ubahdata', ['filter' => 'auth']);
$routes->post('role/hapusdata_soft', 'Role::hapusdata_soft', ['filter' => 'auth']);
// end role
// end role


// start semester  
// start semester  
$routes->get('semester', 'Semester::index', ['filter' => 'auth']);
$routes->post('semester/ambil_data_semester', 'Semester::ambil_data_semester', ['filter' => 'auth']);
$routes->post('semester/simpandata', 'Semester::simpandata', ['filter' => 'auth']);
$routes->post('semester/ubahdata', 'Semester::ubahdata', ['filter' => 'auth']);
// end semester  
// end semester  


// start santri  
// start santri  
$routes->get('santri', 'Santri::index', ['filter' => 'auth']);
$routes->post('santri/ambil_data_santri', 'Santri::ambil_data_santri', ['filter' => 'auth']);
$routes->post('santri/ambil_data_santri_by_kelas/(:num)', 'Santri::ambil_data_santri_by_kelas/$1', ['filter' => ['auth', 'role:4']]);
$routes->post('santri/simpandata', 'Santri::simpandata', ['filter' => ['auth', 'role:3']]);
$routes->post('santri/ubahdata', 'Santri::ubahdata', ['filter' => 'auth']);
$routes->post('santri/hapusdata_soft', 'Santri::hapusdata_soft', ['filter' => ['auth', 'role:3']]);
$routes->post('santri/import_excel', 'Santri::importExcel', ['filter' => ['auth', 'role:3']]);
// end santri  
// end santri


// start kelas  
// start kelas  
$routes->get('kelas', 'Kelas::index', ['filter' => 'auth']);
$routes->post('kelas/getSemestersByJenjang', 'Kelas::getSemestersByJenjang'); // Untuk AJAX
$routes->get('kelas/get_tahun_list', 'Kelas::get_tahun_list');
$routes->get('kelas/get_tahun_by_kelas', 'Kelas::get_tahun_by_kelas');
$routes->post('kelas/ambil_data_kelas', 'Kelas::ambil_data_kelas', ['filter' => 'auth']);
$routes->post('kelas/simpandata', 'Kelas::simpandata', ['filter' => 'auth']);
$routes->post('kelas/ubahdata', 'Kelas::ubahdata', ['filter' => 'auth']);
$routes->post('kelas/hapusdata_soft', 'Kelas::hapusdata_soft', ['filter' => 'auth']);
$routes->post('kelas/simpandata_wali', 'Kelas::simpandata_wali', ['filter' => 'auth']);

$routes->group('kelas', function ($routes) {
  $routes->get('get_santri_by_kelas/(:num)', 'Kelas::get_santri_by_kelas/$1');
  $routes->get('get_guru_by_kelas/(:num)', 'Kelas::get_guru_by_kelas/$1');
  $routes->get('get_santri_tanpa_kelas/(:num)', 'Kelas::get_santri_tanpa_kelas/$1');
  $routes->get('get_guru/(:num)', 'Kelas::get_guru/$1');
  $routes->post('tambah_santri_ke_kelas', 'Kelas::tambah_santri_ke_kelas');
  $routes->post('tambah_santri_ke_kelas_batch', 'Kelas::tambah_santri_ke_kelas_batch');
  $routes->post('tambah_guru_ke_kelas', 'Kelas::tambah_guru_ke_kelas');

  $routes->post('hapus_santri', 'Kelas::hapus_santri_dari_kelas');
  $routes->post('hapus_guru', 'Kelas::hapus_guru_dari_kelas');

  $routes->post('tambah_santri', 'Kelas::tambah_santri');
  $routes->post('tambah_guru', 'Kelas::tambah_guru');
});
// end kelas  
// end kelas



// start modul ajar
// start modul ajar
$routes->get('modulajar', 'ModulAjar::index', ['filter' => 'auth']);

$routes->get('modulajar/ambil_data_tp', 'ModulAjar::ambil_data_tp', ['filter' => 'auth']);
$routes->get('modulajar/ambil_data_dimensi', 'ModulAjar::ambil_data_dimensi', ['filter' => 'auth']);
$routes->get('modulajar/ambil_data_kurikulum', 'ModulAjar::ambil_data_kurikulum', ['filter' => 'auth']);
$routes->get('modulajar/ambil_selected_texts', 'ModulAjar::ambil_selected_texts', ['filter' => 'auth']);

$routes->post('modulajar/ambil_data_modulajar', 'ModulAjar::ambil_data_modulajar', ['filter' => 'auth']);
$routes->post('modulajar/simpandata', 'ModulAjar::simpandata', ['filter' => 'auth']);
$routes->post('modulajar/ubahdata', 'ModulAjar::ubahdata', ['filter' => 'auth']);
$routes->post('modulajar/hapusdata_soft', 'ModulAjar::hapusdata_soft', ['filter' => 'auth']);

$routes->get('modulajar/download/(:num)', 'ModulAjar::download/$1'); // halaman daftar tanggal
$routes->get('modulajar/get_data_select_dpl_kbc/(:num)', 'ModulAjar::get_data_select_dpl_kbc/$1'); // halaman daftar tanggal

// end modul ajar
// end modul ajar



// start asesmen
// start asesmen
$routes->get('asesmen/index/(:num)', 'Asesmen::index/$1'); // halaman daftar tanggal
$routes->get('asesmen/form/(:num)/(:segment)', 'Asesmen::form/$1/$2'); // $1 = modulAjarId, $2 = tanggal
$routes->post('asesmen/simpan', 'Asesmen::simpan');
$routes->post('asesmen/getData', 'Asesmen::getData');
$routes->get('asesmen/downloadlaporan', 'Asesmen::downloadLaporan');
// start asesmen
// start asesmen


// start tujuan pembelajaran
// start tujuan pembelajaran
$routes->get('tujuanpembelajaran', 'TujuanPembelajaran::index', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/ambil_data_capaianpembelajaran', 'TujuanPembelajaran::ambil_data_capaianpembelajaran', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/simpandata', 'TujuanPembelajaran::simpandata', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/ubahdata', 'TujuanPembelajaran::ubahdata', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/hapusdata_soft', 'TujuanPembelajaran::hapusdata_soft', ['filter' => 'auth']);

$routes->get('tujuanpembelajaran/tp/(:num)', 'TujuanPembelajaran::indexTP/$1'); // halaman daftar tanggal
$routes->post('tujuanpembelajaran/ambil_data_tujuanpembelajaran/(:num)', 'TujuanPembelajaran::ambil_data_tujuanpembelajaran/$1', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/tp/simpandata', 'TujuanPembelajaran::simpandataTP', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/tp/ubahdata', 'TujuanPembelajaran::ubahdataTP', ['filter' => 'auth']);
$routes->post('tujuanpembelajaran/tp/hapusdata_soft', 'TujuanPembelajaran::hapusdata_softTP', ['filter' => 'auth']);
// end tujuan pembelajaran
// end tujuan pembelajaran



// start dimensi profil lulusan
// start dimensi profil lulusan
$routes->get('dimensiprofil', 'DimensiProfilLulusan::index', ['filter' => 'auth']);
$routes->post('dimensiprofil/ambil_data', 'DimensiProfilLulusan::ambil_data', ['filter' => 'auth']);
$routes->post('dimensiprofil/simpandata', 'DimensiProfilLulusan::simpandata', ['filter' => 'auth']);
$routes->post('dimensiprofil/ubahdata', 'DimensiProfilLulusan::ubahdata', ['filter' => 'auth']);
$routes->post('dimensiprofil/hapusdata_soft', 'DimensiProfilLulusan::hapusdata_soft', ['filter' => 'auth']);
// end dimensi profil lulusan
// end dimensi profil lulusan


// start kurikulum cinta
// start kurikulum cinta
$routes->get('kurikulumcinta', 'KurikulumCinta::index', ['filter' => 'auth']);
$routes->post('kurikulumcinta/ambil_data', 'KurikulumCinta::ambil_data', ['filter' => 'auth']);
$routes->post('kurikulumcinta/simpandata', 'KurikulumCinta::simpandata', ['filter' => 'auth']);
$routes->post('kurikulumcinta/ubahdata', 'KurikulumCinta::ubahdata', ['filter' => 'auth']);
$routes->post('kurikulumcinta/hapusdata_soft', 'KurikulumCinta::hapusdata_soft', ['filter' => 'auth']);
// end kurikulum cinta
// end kurikulum cinta

// start profile
// start profile
$routes->get('profil', 'Profile::index', ['filter' => 'auth']); // halaman daftar tanggal
$routes->post('profil/simpan', 'Profile::simpan');
// start profile
// start profile


// start laporan bulanan
// start laporan bulanan
$routes->group('laporan-bulanan', ['filter' => 'auth'], function ($routes) {
  $routes->get('/', 'LaporanBulanan::index');
  $routes->post('generate', 'LaporanBulanan::generate');
  $routes->get('edit/(:num)', 'LaporanBulanan::edit/$1');
  $routes->post('update-detail', 'LaporanBulanan::updateDetail');
  $routes->delete('delete/(:num)', 'LaporanBulanan::delete/$1');
  $routes->get('download-pdf/(:num)', 'LaporanBulanan::downloadPDF/$1');
});

// end laporan bulanan
// end laporan bulanan


// start download
// start download
$routes->get('asesmen/download/(:num)/(:num)/(:segment)', 'Asesmen::download/$1/$2/$3');
// end download
// end download
$routes->setAutoRoute(false);
