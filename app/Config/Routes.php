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
$routes->group('pegawai', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pegawai::index');
    $routes->post('search', 'Pegawai::search');
    $routes->post('insert', 'Pegawai::insert');
    $routes->post('update', 'Pegawai::update');
    $routes->post('delete', 'Pegawai::delete');
    $routes->get('jabatan', 'Pegawai::jabatan');
    $routes->post('insert_jabatan', 'Pegawai::insert_jabatan');
    $routes->post('update_jabatan', 'Pegawai::update_jabatan');
    $routes->post('delete_jabatan', 'Pegawai::delete_jabatan');
});

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
$routes->get('import_phone', 'Phone::menuimport_phone', ['filter' => 'auth']);



//pelanggan
$routes->get('/pelanggan', 'Pelanggan::index', ['filter' => 'auth']);
$routes->post('insert_pelanggan', 'Pelanggan::insert_pelanggan', ['filter' => 'auth']);
$routes->post('update_pelanggan', 'Pelanggan::update_pelanggan', ['filter' => 'auth']);
$routes->post('delete_pelanggan', 'Pelanggan::delete_pelanggan', ['filter' => 'auth']);
$routes->get('export/pelanggan', 'Pelanggan::export_pelanggan', ['filter' => 'auth']);
$routes->post('import/pelanggan', 'Pelanggan::import_pelanggan', ['filter' => 'auth']);
$routes->post('simpan/pelanggan', 'Pelanggan::simpanPelanggan', ['filter' => 'auth']);

//kerusakan
$routes->get('kerusakan', 'Kerusakan::index', ['filter' => 'auth']);
$routes->post('insert_kerusakan', 'Kerusakan::insert_kerusakan', ['filter' => 'auth']);
$routes->post('update_kerusakan', 'Kerusakan::update_kerusakan', ['filter' => 'auth']);
$routes->post('delete_kerusakan', 'Kerusakan::delete_kerusakan', ['filter' => 'auth']);

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

//service
$routes->get('service', 'Service::index', ['filter' => 'auth']);
$routes->get('service_kerusakan', 'Service::kerusakan_table', ['filter' => 'auth']);
$routes->get('service_sparepart', 'Service::sparepart_table', ['filter' => 'auth']);
$routes->post('insert/pelanggan_service', 'Service::insert_service', ['filter' => 'auth']);
$routes->post('insert_kelengkapan/service', 'Service::insert_kelengkapan_service', ['filter' => 'auth']);
$routes->post('update_kelengkapan/service', 'Riwayat_Service::update_kelengkapan_service', ['filter' => 'auth']);

//status service
$routes->get('status_service/(:num)', 'Status_Service::index/$1');

// $routes->post('insert/sparepart_service', 'Service::insert_sparepart', ['filter' => 'auth']);
//riwayat service
$routes->get('riwayat_service', 'Riwayat_Service::index', ['filter' => 'auth']);
$routes->get('detail/riwayat_service/(:num)', 'Riwayat_Service::detail_service/$1', ['filter' => 'auth']);
$routes->get('cetak/invoice_service/(:num)', 'Riwayat_Service::cetak_invoice/$1', ['filter' => 'auth']);
$routes->post('riwayat_service/export', 'Riwayat_Service::export', ['filter' => 'auth']);

//expired service
$routes->get('expired_service', 'Expired_service::index', ['filter' => 'auth']);
$routes->post('riwayat_expired_service/export', 'Expired_service::export', ['filter' => 'auth']);


//stokawal
$routes->get('stok_awal', 'StokAwal::index', ['filter' => 'auth']);
$routes->post('insert/stokawal', 'StokAwal::insert', ['filter' => 'auth']);

//stokopname
$routes->get('stok_opname', 'StokOpname::index', ['filter' => 'auth']);
$routes->post('insert/stokopname', 'StokOpname::simpan', ['filter' => 'auth']);
$routes->post('insert/stokopnamefix', 'StokOpname::simpanFix', ['filter' => 'auth']);
$routes->get('stokopname/loadtable', 'StokOpname::loadTable');


//kartu stok
$routes->get('kartu_stok', 'Kartu_Stok::index', ['filter' => 'auth']);
$routes->post('export/kartu_stock', 'Kartu_Stok::export', ['filter' => 'auth']);

//mutasi stok
$routes->get('mutasi_stok', 'MutasiStok::index', ['filter' => 'auth']);
$routes->post('insert_mutasi', 'MutasiStok::insert', ['filter' => 'auth']);

//riwayat pembelian
$routes->get('riwayat_pembelian', 'Riwayat_pembelian::index', ['filter' => 'auth']);
$routes->post('riwayat_pembelian/export', 'Riwayat_pembelian::export', ['filter' => 'auth']);

//riwayat penjualan
$routes->get('riwayat_penjualan', 'Riwayat_Penjualan::index', ['filter' => 'auth']);
$routes->get('riwayat_penjualan/detail/(:segment)', 'Riwayat_Penjualan::detail/$1', ['filter' => 'auth']);
$routes->post('riwayat_penjualan/export', 'Riwayat_Penjualan::export', ['filter' => 'auth']);
$routes->get('riwayat_penjualan/struk/(:segment)', 'Riwayat_Penjualan::cetak_struk/$1', ['filter' => 'auth']);

//riwayat retur pembelian 
$routes->get('riwayat_retur_pembelian', 'Riwayat_ReturPembelian::index', ['filter' => 'auth']);
$routes->post('riwayat_retur_pembelian/export', 'Riwayat_ReturPembelian::export', ['filter' => 'auth']);

//riwayat retur penjualan
$routes->get('riwayat_retur_penjualan', 'Riwayat_ReturPenjualan::index', ['filter' => 'auth']);
$routes->post('riwayat_retur_penjualan/export', 'Riwayat_ReturPenjualan::export', ['filter' => 'auth']);



//riwayat stok opname
$routes->get('riwayat_stok_opname', 'Riwayat_StokOpname::index', ['filter' => 'auth']);
$routes->post('riwayat_stok_opname/export', 'Riwayat_StokOpname::export', ['filter' => 'auth']);


//riwayat mutasi
$routes->get('riwayat_mutasi', 'Riwayat_MutasiStok::index', ['filter' => 'auth']);
$routes->post('riwayat_mutasi/export', 'Riwayat_MutasiStok::export', ['filter' => 'auth']);
//retur
$routes->get('retur_suplier', 'Retur_Suplier::index', ['filter' => 'auth']);
$routes->post('insert_retur_suplier', 'Retur_Suplier::insert', ['filter' => 'auth']);

//retur customer
$routes->get('retur_customer', 'Retur_Customer::index', ['filter' => 'auth']);
$routes->post('insert_retur_customer', 'Retur_Customer::insert', ['filter' => 'auth']);


//promosi whatsapp 
$routes->get('promosi_whatsapp', 'PromosiWhatsapp::index', ['filter' => 'auth']);

//stok minimum
$routes->get('stok_minimum', 'StokMinimum::index', ['filter' => 'auth']);
$routes->post('update_stokminimum', 'StokMinimum::update', ['filter' => 'auth']);


//notifikasi pengambilan service
$routes->get('notif_service', 'NotifikasiService::index', ['filter' => 'auth']);

//riwayat laba service
$routes->get('laba_service', 'RiwayatLabaService::index', ['fileter' => 'auth']);
$routes->post('laba_service/export', 'RiwayatLabaService::export', ['fileter' => 'auth']);
