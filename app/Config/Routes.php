<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('Home', 'Home::new_home');
$routes->get('Kegiatan', 'Home::kegiatan');
$routes->get('Kegiatan/(:num)', 'Home::kegiatan_detail/$1');

$routes->group('Login', function (RouteCollection $routes) {
  $routes->get('Guru', 'GuruLogin::index');
  $routes->get('Guru/Keluar', 'GuruLogin::logoff');
  $routes->post('Guru', 'GuruLogin::auth');

  $routes->get('Operator', 'OperatorLogin::index');
  $routes->post('Operator', 'OperatorLogin::auth');
  $routes->get('Operator/Keluar', 'OperatorLogin::logoff');
});

$routes->group('GuruPanel', function (RouteCollection $routes) {
  $routes->post('Foto', 'GuruController::edit_foto');
  $routes->post('Password', 'GuruController::edit_password');
  $routes->post('Guru', 'GuruController::edit_biodata');
  $routes->get('/', 'GuruController::index');
  $routes->get('(:num)', 'GuruController::hafalan/$1');
  $routes->get('HafalanPDF/(:num)', 'GuruController::hafalan_detail/$1');
  $routes->get('Hafalan/(:num)', 'GuruController::hafalan_/$1');
  $routes->get('Hafalan/Delete/(:num)', 'GuruController::hafalan_delete/$1');
  $routes->post('HafalanPDF/(:num)', 'GuruController::hafalan_pdf/$1');
  $routes->post('/', 'GuruController::hafalan_insert');
  $routes->get('HafalanSiswa/(:num)', 'GuruController::hafalan_siswa/$1');
  $routes->post('HafalanSiswa/Tahsin', 'GuruController::hafalan_tahsin_insert');
  $routes->post('HafalanSiswa/Murojaah', 'GuruController::hafalan_murojaah_insert');
  $routes->post('HafalanSiswa/HafalanBaru', 'GuruController::hafalan_baru_insert');
  $routes->get('HafalanSiswa/Rekap/(:num)', 'GuruController::hafalan_siswa_detail/$1');
  $routes->get('HafalanSiswa/Detail/(:num)', 'GuruController::hafalan_siswa_/$1');
  $routes->get('HafalanSiswa/(:segment)/(:num)', 'GuruController::hafalan_siswa_delete/$1/$2');

  $routes->get('Absensi/(:num)', 'GuruController::absen/$1');
  $routes->post('Absensi', 'GuruController::absensi_proses');
  $routes->post('Absensi/Update', 'GuruController::absensi_proses_edit');
  $routes->get('Absensi/PDF/(:num)', 'GuruController::absensi_detail/$1');
  $routes->get('Absensi/Delete/(:num)', 'GuruController::absensi_delete/$1');
  $routes->get('Absensi/Detail/(:num)', 'GuruController::absensi_/$1');

  $routes->get('Guru', 'GuruController::biodata_guru');
  $routes->post('Guru', 'GuruController::edit_biodata');
  $routes->post('Guru/Password', 'GuruController::edit_password');
  $routes->post('Guru/Foto', 'GuruController::edit_foto');

  $routes->get('RekapNilai', 'GuruController::rekap_nilai');
  $routes->get('Al-Quran', 'GuruController::alquran');

  $routes->get('Chart', 'GuruController::chart');
  $routes->get('Chart/Random', 'GuruController::getDataChart');
  $routes->get('Chart/Select/(:num)', 'GuruController::getDataChartSelect/$1');

  $routes->get('RekapNilai', 'GuruController::rekap');
  $routes->post('RekapNilai', 'GuruController::render_rekap');
  $routes->get('RekapNilai/Delete/(:num)', 'GuruController::rekap_delete/$1');
  $routes->post('GetBlobURI/(:num)', 'GuruController::getBlobPDF/$1');
  $routes->get('RekapNilai/(:num)', 'GuruController::see_blob_pdf/$1');
});

$routes->group('OperatorPanel', function (RouteCollection $routes) {
  $routes->get('/', 'OperatorController::index');
  $routes->post('/', 'OperatorController::guru_insert');
  $routes->post('Update', 'OperatorController::guru_update');
  $routes->get('Delete/(:num)', 'OperatorController::guru_delete/$1');

  $routes->get('Kelas', 'OperatorController::kelas');
  $routes->post('Kelas', 'OperatorController::kelas_insert');
  $routes->post('Kelas/Update', 'OperatorController::kelas_update');
  $routes->get('Kelas/(:num)', 'OperatorController::kelas_delete/$1');

  $routes->get('Siswa', 'OperatorController::siswa');
  $routes->post('Siswa', 'OperatorController::siswa_insert');
  $routes->post('Siswa/Update', 'OperatorController::siswa_update');
  $routes->get('Siswa/(:num)', 'OperatorController::siswa_delete/$1');

  $routes->get('Operator', 'OperatorController::operator');
  $routes->post('Operator', 'OperatorController::operator_insert');
  $routes->post('Operator/Update', 'OperatorController::operator_update');
  $routes->get('Operator/(:num)', 'OperatorController::operator_delete/$1');

  $routes->get('Al-Quran', 'OperatorController::alquran');

  $routes->get('Kegiatan', 'OperatorController::kegiatan');
  $routes->post('Kegiatan', 'OperatorController::kegiatan_insert');
  $routes->post('Kegiatan/Update', 'OperatorController::kegiatan_update');
  $routes->get('Kegiatan/(:num)', 'OperatorController::kegiatan_delete/$1');

  $routes->get('Corousel', 'OperatorController::corousel');
  $routes->post('Corousel', 'OperatorController::corousel_insert');
  $routes->post('Corousel/Update', 'OperatorController::corousel_update');
  $routes->get('Corousel/(:num)', 'OperatorController::corousel_delete/$1');

  $routes->get('Halaqoh', 'OperatorController::halaqoh');
  $routes->post('Halaqoh', 'OperatorController::halaqoh_insert');
  $routes->post('Halaqoh/Update', 'OperatorController::halaqoh_update');
  $routes->get('Halaqoh/(:num)', 'OperatorController::halaqoh_delete/$1');
});

$routes->group('API', function (RouteCollection $routes) {
  $routes->post('Login/OrangTua', 'API::login_orang_tua');
  $routes->get('InformasiSiswa/(:num)', 'API::informasi_siswa/$1');
  $routes->get('AbsenSiswa/(:num)', 'API::absensi_siswa/$1');
  $routes->get('InformasiGuru/(:num)', 'API::informasi_guru/$1');
  $routes->get('Hafalan/(:num)', 'API::hafalan/$1');
  $routes->get('PDF/(:num)', 'API::webview_blobpdf/$1');
  $routes->get('RekapNilai/(:num)', 'API::rekap_nilai/$1');
  $routes->post('Token', 'API::save_token_device');
  $routes->get('Notifikasi/(:num)', 'API::show_all_notifikasi/$1');
  $routes->post('Notfikasi', 'GuruController::test_notifikasi');
});
