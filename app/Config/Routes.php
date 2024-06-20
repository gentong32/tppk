<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('');
$routes->setDefaultMethod('');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/demo', 'Home::demo');
$routes->get('/home', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/actionLoginsso', 'Login::actionLoginsso');
$routes->get('/login/login_dummy', 'Login::login_dummy');
$routes->post('/login/cek_dummy', 'Login::cek_dummy');
$routes->get('/Home/set_pilihan/(:any)', 'Home::set_pilihan/$1');
$routes->get('/tppk/anggota/(:any)', 'TPPK::anggota/$1');
$routes->get('/tppk/anggota2/(:any)', 'TPPK::anggota2/$1');
$routes->get('/tppk/wilayah', 'TPPK::wilayah');
$routes->get('/tppk/getBentukKementerian/(:any)', 'TPPK::getBentukKementerian/$1');
$routes->get('/informasi', 'Informasi::index');
$routes->get('/tppk/wilayah/(:any)', 'TPPK::wilayah/$1');
$routes->get('/inputdata', 'InputData::index');
$routes->get('/inputdata/getNamaWilayah', 'InputData::getNamaWilayah');
$routes->get('/inputdata/padankandata', 'InputData::padankandata');
$routes->post('/inputdata/padankandata', 'InputData::padankandata');
$routes->post('/inputdata/upload_sk', 'InputData::upload_sk');
$routes->post('/inputdata/simpansatgas', 'InputData::simpansatgas');
$routes->post('/inputdata/simpansatgastes', 'InputData::simpansatgastes');
$routes->post('/inputdata/sksesuai', 'InputData::sksesuai');
$routes->get('/inputdata/download_sk/(:any)', 'InputData::download_sk/$1');
$routes->get('/login/logout', 'Login::logout');
$routes->get('/tppk/viewer', 'TPPK::viewer');
$routes->get('/tppk/viewer/(:segment)', 'TPPK::viewer/$1');

$routes->get('/statistik_user', 'InputData::statistik_user');

$routes->get('/residu', 'InputData::daftarsekolahnontppk');

$routes->get('/loginevent', 'Login::loginevent');
$routes->post('/login/ceklogin', 'Login::ceklogin');
$routes->get('/ubah_password', 'Login::ubahpassword');
$routes->get('/lupa_password', 'Login::lupa_password');
$routes->get('/info_password', 'Login::info_password');
$routes->post('/add_operator_satgas_password', 'Login::add_operator_satgas_password');
$routes->post('/update_operator_satgas', 'Login::update_operator_satgas');

$routes->get('/login/sebagai/(:any)', 'Login::sebagai/$1');
$routes->get('/login/sebagai/(:any)/(:any)', 'Login::sebagai/$1/$2');

$routes->get('/inputdata/get_data_p', 'InputData::get_data_p');
$routes->get('/inputdata/pelaporan', 'InputData::pelaporan');
$routes->post('/inputdata/get_data_siswa', 'InputData::get_data_siswa');
$routes->post('/inputdata/get_ortu', 'InputData::get_ortu');
$routes->post('/inputdata/simpan_kasus', 'InputData::simpan_kasus');
$routes->get('/inputdata/cari_sekolah', 'InputData::cari_sekolah');
$routes->get('/inputdata/ajaxGetDaftarNonTPPK', 'InputData::ajaxGetDaftarNonTPPK');
$routes->post('/inputdata/ajaxGetDaftarNonTPPK', 'InputData::ajaxGetDaftarNonTPPK');
$routes->get('/get_daf_kota', 'InputData::get_daf_kota');

$routes->post('/inputdata/nik_siswa', 'InputData::nik_siswa');

$routes->get('/inputdata/tes', 'InputData::tes');
$routes->get('/login_dapodik', 'InputData::daftar_laporan');
$routes->get('/login_dapodik/(:any)', 'Login::login_dapodik/$1');

$routes->get('/login_satgas', 'Login::login_satgas');
$routes->post('/cek_login', 'Login::loginUser');
$routes->get('/reset_password', 'Login::reset_password');
$routes->get('/info_reset_password', 'Login::info_reset_password');
$routes->post('/updatekodereset', 'Login::updatekodereset');
$routes->get('/register_satgas', 'Login::register_satgas');
$routes->post('/add_operator_satgas', 'Login::add_operator_satgas');
$routes->post('/cek_nik', 'Login::cek_nik');
$routes->post('/cek_email', 'Login::cek_email');
$routes->get('/cek_sk', 'Login::cek_sk');
$routes->get('/unggah_sk', 'InputData::unggah_sk');
$routes->post('/unggah_sk_op_satgas', 'InputData::unggah_sk_op_satgas');
$routes->get('/status_approval', 'Login::status_approval');
$routes->get('/inputdata/operatorsesuai', 'Inputdata::operatorsesuai');
// $routes->get('/login_dapodik/(:any)', 'Login::login_dapodik/$1');

$routes->get('/cek_sk_gagal_upload', 'InputData::cek_sk_gagal_upload');

$routes->get('/softdel/(:any)/(:any)', 'InputData::softdel/$1/$2');

$routes->get('/daftar_laporan_kekerasan', 'InputData::daftar_laporan');
$routes->get('/status_laporan_kekerasan', 'InputData::status_laporan');

$routes->get('/webinar', 'Webinar::index');

$routes->get('/authorize', 'OAuthController::authorize');
$routes->get('/callback', 'OAuthController::oauth2callback');
$routes->get('/email', 'Login::sendEmail');


// $routes->get('/pesertadidik', 'PesertaDidik::index');
// $routes->get('/pesertadidik/wilayah', 'PesertaDidik::wilayah');
// $routes->get('/pesertadidik/wilayah/(:any)', 'PesertaDidik::wilayah/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
