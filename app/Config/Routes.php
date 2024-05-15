<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('Home', 'Home::new_home');

$routes->group('Login', function (RouteCollection $routes) {
  $routes->get('Guru', 'GuruLogin::index');
  $routes->get('Guru/Keluar', 'GuruLogin::logoff');
  $routes->post('Guru', 'GuruLogin::auth');

  $routes->get('Operator', 'OperatorLogin::index');
  $routes->post('Operator', 'OperatorLogin::auth');
  $routes->get('Operator/Keluar', 'OperatorLogin::logoff');
});

$routes->group('GuruPanel', function (RouteCollection $routes) {
  $routes->get('/', 'GuruController::index');
  $routes->get('(:num)', 'GuruController::hafalan/$1');
  $routes->get('Detail/(:num)', 'GuruController::hafalan_detail/$1');
  $routes->post('/', 'GuruController::hafalan_insert');
  $routes->get('Absensi/(:num)', 'GuruController::absen/$1');
  $routes->post('Absensi/(:num)', 'GuruController::absensi_proses/$1');
  $routes->post('Absensi/Update/(:num)', 'GuruController::absensi_proses_edit/$1');
  $routes->get('Absensi/Detail/(:num)', 'GuruController::absensi_detail/$1');

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
});

$routes->group('OperatorPanel', function (RouteCollection $routes) {
  $routes->get('/', 'OperatorController::index');
  $routes->post('/', 'OperatorController::guru_insert');
  $routes->post('/Update', 'OperatorController::guru_update');
  $routes->get('/Delete/(:num)', 'OperatorController::guru_delete/$1');

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
});

$routes->group('API', function (RouteCollection $routes) {
  $routes->post('Login/OrangTua', 'API::login_orang_tua');
  $routes->get('InformasiSiswa/(:num)', 'API::informasi_siswa/$1');
  $routes->get('AbsenSiswa/(:num)', 'API::absensi_siswa/$1');
  $routes->get('InformasiGuru/(:num)', 'API::informasi_guru/$1');
  $routes->get('Hafalan/(:num)', 'API::hafalan/$1');
});
