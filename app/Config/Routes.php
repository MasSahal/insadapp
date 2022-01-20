<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Home::index'); // halaman login
$routes->get('/register', 'Home::register'); // halaman daftar
$routes->get('/logout', 'Home::logout'); // logout
$routes->post('/auth', 'Home::auth'); // proses auth

// $routes->get('/user', 'Home::index'); // halaman daftar
// $routes->get('/admin', 'Home::login_admin');
// $routes->get('/admin/home', 'AdminController::index');

//jalur admin
$routes->group('admin', function ($routes) {
	$routes->post('/auth', 'AdminController::index');
	$routes->get('home', 'AdminController::index');

	//bagian produk
	$routes->get('penyewaan', 'AdminController::penyewaan');
	$routes->get('penyewaan/generate-penyewaan', 'AdminController::generate_penyewaan');
	$routes->get('penyewaan/form-penyewaan', 'AdminController::form_penyewaan');
	$routes->post('penyewaan/tambah-penyewaan', 'AdminController::tambah_penyewaan');
	$routes->post('penyewaan/kembalikan_penyewaan', 'AdminController::kembalikan_penyewaan');


	$routes->post('penyewaan/add-cart', 'AdminController::add_cart');
	$routes->get('penyewaan/del-cart/(:num)', 'AdminController::del_cart/$1');
	$routes->post('penyewaan/get-cart', 'AdminController::get_cart');
	$routes->post('penyewaan/insert-penyewaan', 'AdminController::insert_penyewaan');

	//bagian pelanggan
	$routes->get('account/pelanggan', 'AdminController::pelanggan');
	$routes->post('account/pelanggan/get-pelanggan', 'AdminController::get_pelanggan');
	$routes->get('account/pelanggan/(:num)/delete', 'AdminController::delete_pelanggan/$1');
	$routes->post('account/pelanggan/insert', 'AdminController::insert_pelanggan');
	$routes->post('account/pelanggan/insert-edit', 'AdminController::insert_edit_pelanggan');
	$routes->post('account/pelanggan/insert-edit-pw', 'AdminController::insert_edit_pw_pelanggan');


	//bagian produk
	$routes->get('produk', 'AdminController::produk');
	$routes->get('produk/(:num)/delete', 'AdminController::delete_produk/$1');
	$routes->post('insert-produk', 'AdminController::insert_produk');
	$routes->post('insert-edit-produk', 'AdminController::insert_edit_produk');
	$routes->post('add-stock-produk', 'AdminController::add_stock_produk');
	$routes->post('edit-image-produk', 'AdminController::edit_image_produk');





















	//bagian jenis
	$routes->get('jenis', 'AdminController::jenis');
	$routes->get('jenis/generate-jenis', 'AdminController::generate_jenis');
	$routes->get('jenis/(:num)/delete', 'AdminController::delete_jenis/$1');
	$routes->post('insert-jenis', 'AdminController::insert_jenis');
	$routes->post('insert-edit-jenis', 'AdminController::insert_edit_jenis');

	//bagian ruangan
	$routes->get('ruangan', 'AdminController::ruangan');
	$routes->get('ruangan/generate-ruangan', 'AdminController::generate_ruangan');
	$routes->get('ruangan/(:num)/delete', 'AdminController::delete_ruangan/$1');
	$routes->post('insert-ruangan', 'AdminController::insert_ruangan');
	$routes->post('insert-edit-ruangan', 'AdminController::insert_edit_ruangan');

	//bagian akun admin
	$routes->get('account/administrator', 'AdminController::administrator');
	$routes->get('account/generate-administrator', 'AdminController::generate_administrator');
	$routes->get('account/administrator/(:num)/delete', 'AdminController::delete_administrator/$1');
	$routes->post('account/administrator/insert', 'AdminController::insert_administrator');
	$routes->post('account/administrator/insert-edit', 'AdminController::insert_edit_administrator');
	$routes->post('account/administrator/insert-edit-pw', 'AdminController::insert_edit_pw_administrator');

	//bagian akun operator
	$routes->get('account/operator', 'AdminController::operator');
	$routes->get('account/generate-operator', 'AdminController::generate_operator');
	$routes->get('account/operator/(:num)/delete', 'AdminController::delete_operator/$1');
	$routes->post('account/operator/insert', 'AdminController::insert_operator');
	$routes->post('account/operator/insert-edit', 'AdminController::insert_edit_operator');
	$routes->post('account/operator/insert-edit-pw', 'AdminController::insert_edit_pw_operator');

	//bagian akun pegawai
	$routes->get('account/pegawai', 'AdminController::pegawai');
	$routes->get('account/generate-pegawai', 'AdminController::generate_pegawai');
	$routes->get('account/pegawai/(:num)/delete', 'AdminController::delete_pegawai/$1');
	$routes->post('account/pegawai/insert', 'AdminController::insert_pegawai');
	$routes->post('account/pegawai/insert-edit', 'AdminController::insert_edit_pegawai');
	$routes->post('account/pegawai/insert-edit-pw', 'AdminController::insert_edit_pw_pegawai');
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
