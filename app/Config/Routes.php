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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
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
$routes->post('/inputdata/upload_sk', 'InputData::upload_sk');
$routes->post('/inputdata/simpansatgas', 'InputData::simpansatgas');
$routes->post('/inputdata/sksesuai', 'InputData::sksesuai');
$routes->get('/inputdata/download_sk/(:any)', 'InputData::download_sk/$1');
$routes->get('/login/logout', 'Login::logout');
$routes->get('/tppk/viewer', 'TPPK::viewer');
$routes->get('/tppk/viewer/(:segment)', 'TPPK::viewer/$1');

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
