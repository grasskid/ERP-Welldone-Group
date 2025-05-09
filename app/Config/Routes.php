<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/template', 'Template::index');
$routes->get('/Login', 'Auth::login');
$routes->post('/proses_login', 'Auth::proses_login');
$routes->get('/Logout', 'Auth::proses_logout');


//Datamaster
//produk
$routes->group('produk', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Produk::index');
    $routes->get('export/produk', 'Produk::export_produk');
    $routes->post('import/produk', 'Produk::import_produk');
    $routes->post('insert_produk', 'Produk::insert_produk');
    $routes->post('update_produk', 'Produk::update_produk');
    $routes->post('delete_produk', 'Produk::delete_produk');
});

//supplier
$routes->get('/supplier', 'Supplier::index', ['filter' => 'auth']);
$routes->post('update_suplier', 'Supplier::update_suplier', ['filter' => 'auth']);
$routes->post('insert_suplier', 'Supplier::insert_suplier', ['filter' => 'auth']);
$routes->post('delete_suplier', 'Supplier::delete_suplier', ['filter' => 'auth']);

//kategori
$routes->get('/kategori', 'Kategori::index');
$routes->post('insert_kategori', 'Kategori::insert_kategori', ['filter' => 'auth']);
$routes->post('update_kategori', 'Kategori::update_kategori', ['filter' => 'auth']);
$routes->post('delete_kategori', 'Kategori::delete_kategori', ['filter' => 'auth']);

//phone
$routes->get('/phone', 'Phone::index', ['filter' => 'auth']);
$routes->post('insert_phone', 'Phone::insert_phone', ['filter' => 'auth']);
$routes->post('update_phone', 'Phone::update_phone', ['filter' => 'auth']);
$routes->post('delete_phone', 'Phone::delete_phone', ['filter' => 'auth']);
$routes->get('export/phone', 'Phone::export_phone', ['filter' => 'auth']);
$routes->post('import/phone', 'Phone::import_phone', ['filter' => 'auth']);

//pelanggan
$routes->get('/pelanggan', 'Pelanggan::index', ['filter' => 'auth']);
$routes->post('insert_pelanggan', 'Pelanggan::insert_pelanggan', ['filter' => 'auth']);
$routes->post('update_pelanggan', 'Pelanggan::update_pelanggan', ['filter' => 'auth']);
$routes->post('delete_pelanggan', 'Pelanggan::delete_pelanggan', ['filter' => 'auth']);
$routes->get('export/pelanggan', 'Pelanggan::export_pelanggan', ['filter' => 'auth']);
$routes->post('import/pelanggan', 'Pelanggan::import_pelanggan', ['filter' => 'auth']);

//Admin

//approval
$routes->get('/approval', 'Approval::index', ['filter' => 'auth']);
$routes->get('decline/phone/(:num)', 'Approval::decline/$1', ['filter' => 'auth']);
$routes->get('approve/phone/(:num)', 'Approval::approve/$1', ['filter' => 'auth']);

//Transaksi

//pembelian
$routes->get('/pembelian', 'Pembelian::index', ['filter' => 'auth']);
$routes->post('insert_pembelian', 'Pembelian::insert', ['filter' => 'auth']);



//penjualan
$routes->get('/penjualan', 'Penjualan::index', ['filter' => 'auth']);
$routes->post('insert_penjualan', 'Penjualan::insert_penjualan', ['filter' => 'auth']);
$routes->get('penjualan/search_by_hp', 'Penjualan::search_by_hp', ['filter' => 'auth']);

//stokawal
$routes->get('stok_awal', 'StokAwal::index', ['filter' => 'auth']);
$routes->post('insert/stokawal', 'StokAwal::insert', ['filter' => 'auth']);

//riwayat pembelian
$routes->get('riwayat_pembelian', 'Riwayat_pembelian::index', ['filter' => 'auth']);

//riwayat penjualan
$routes->get('riwayat_penjualan', 'Riwayat_Penjualan::index', ['filter' => 'auth']);
$routes->get('riwayat_penjualan/detail/(:segment)', 'Riwayat_Penjualan::detail/$1', ['filter' => 'auth']);

//riwayat retur pembelian
$routes->get('riwayat_retur_pembelian', 'Riwayat_ReturPembelian::index', ['filter' => 'auth']);

//riwayat retur pembelian
$routes->get('riwayat_retur_penjualan', 'Riwayat_ReturPenjualan::index', ['filter' => 'auth']);

//retur
$routes->get('retur_suplier', 'Retur_Suplier::index', ['filter' => 'auth']);
$routes->post('insert_retur_suplier', 'Retur_Suplier::insert', ['filter' => 'auth']);

//retur customer
$routes->get('retur_customer', 'Retur_Customer::index', ['filter' => 'auth']);
$routes->post('insert_retur_customer', 'Retur_Customer::insert', ['filter' => 'auth']);