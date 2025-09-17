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
$routes->post('auth/changePassword', 'Auth::changePassword');



//Datamaster


$routes->get('/bank', 'Bank::index', ['filter' => 'auth']);

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

$routes->post('pegawai/reset', 'Pegawai::reset_password', ['filter' => 'auth']);

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
$routes->post('insert-phone-ajax', 'Phone::insertnamahandphone', ['filter' => 'auth']);



//pelanggan
$routes->get('/pelanggan', 'Pelanggan::index', ['filter' => 'auth']);
$routes->post('insert_pelanggan', 'Pelanggan::insert_pelanggan', ['filter' => 'auth']);
$routes->post('update_pelanggan', 'Pelanggan::update_pelanggan', ['filter' => 'auth']);
$routes->post('delete_pelanggan', 'Pelanggan::delete_pelanggan', ['filter' => 'auth']);
$routes->get('export/pelanggan', 'Pelanggan::export_pelanggan', ['filter' => 'auth']);
$routes->post('import/pelanggan', 'Pelanggan::import_pelanggan', ['filter' => 'auth']);
$routes->post('simpan/pelanggan', 'Pelanggan::simpanPelanggan', ['filter' => 'auth']);
$routes->get('riwayat_transaksi_pelanggan/(:num)', 'Pelanggan::riwayat_transaksi_pelanggan/$1', ['filter' => 'auth']);

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
$routes->post('insert_produk', 'Pembelian::insert_produk');
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

$routes->get('proses_service', 'Riwayat_Service::proses_service', ['filter' => 'auth']);
$routes->post('update_status_proses', 'Riwayat_Service::update_status_proses', ['filter' => 'auth']);
$routes->post('service/bisa_diambil', 'Riwayat_Service::update_bisa_diambil', ['filter' => 'auth']);
$routes->get('bisa_diambil', 'Riwayat_Service::service_bisa_diambil', ['filter' => 'auth']);
$routes->post('service/sudah_diambil', 'Riwayat_Service::update_sudah_diambil', ['filter' => 'auth']);
$routes->get('sudah_diambil', 'Riwayat_Service::service_sudah_diambil', ['filter' => 'auth']);

//insertservice
$routes->post('service/saveKerusakan', 'Service::insert_kerusakan', ['filter' => 'auth']);
$routes->post('service/saveSparepart', 'Service::insert_sparepart', ['filter' => 'auth']);
$routes->post('insert/service/savePembayaran', 'Service::insert_pembayaran', ['filter' => 'auth']);

//updateservice
$routes->post('update/pelanggan_service', 'Riwayat_Service::update_service_pelanggan', ['filter' => 'auth']);
$routes->post('update_service/saveKerusakan', 'Riwayat_Service::insert_kerusakan', ['filter' => 'auth']);
$routes->post('update_service/saveSparepart', 'Riwayat_Service::insert_sparepart', ['filter' => 'auth']);
$routes->post('update_insert/service/savePembayaran', 'Riwayat_Service::insert_pembayaran', ['filter' => 'auth']);

//riwayat service garansi
$routes->get('riwayat_service_garansi', 'Riwayat_Service::index2', ['filter' => 'auth']);

//service_by_garansi
$routes->get('service_by_garansi/(:num)', 'StatusGaransi::service_by_garansi/$1', ['filter' => 'auth']);
$routes->post('update/pelanggan_service_garansi', 'StatusGaransi::update_service_pelanggan_garansi', ['filter' => 'auth']);
$routes->post('update_garansi_service/saveKerusakan', 'StatusGaransi::insert_kerusakan_garansi', ['filter' => 'auth']);
$routes->post('update_service_garansi/saveSparepart', 'StatusGaransi::insert_sparepart_garansi', ['filter' => 'auth']);
$routes->post('update_service_garansi/savePembayaran', 'StatusGaransi::insert_pembayaran_garansi', ['filter' => 'auth']);

//garansiservice
$routes->get('garansi_service', 'StatusGaransi::index', ['filter' => 'auth']);
$routes->post('claim_garansi', 'StatusGaransi::claim_garansi', ['filter' => 'auth']);

//status service
$routes->get('status_service/(:num)', 'Status_Service::index/$1');

// $routes->post('insert/sparepart_service', 'Service::insert_sparepart', ['filter' => 'auth']);
//riwayat service
$routes->get('riwayat_service', 'Riwayat_Service::index', ['filter' => 'auth']);
$routes->get('detail/riwayat_service/(:num)', 'Riwayat_Service::detail_service/$1', ['filter' => 'auth']);
$routes->get('cetak/invoice_service/(:num)', 'Riwayat_Service::cetak_invoice/$1', ['filter' => 'auth']);
$routes->post('riwayat_service/export', 'Riwayat_Service::export', ['filter' => 'auth']);
$routes->post('riwayat_service_garansi/export', 'Riwayat_Service::export2', ['filter' => 'auth']);

//expired service
$routes->get('expired_service', 'Expired_service::index', ['filter' => 'auth']);
$routes->post('riwayat_expired_service/export', 'Expired_service::export', ['filter' => 'auth']);


//stokawal
$routes->get('stok_awal', 'StokAwal::index', ['filter' => 'auth']);
$routes->post('insert/stokawal', 'StokAwal::insert', ['filter' => 'auth']);
$routes->get('/stok/getBarang', 'StokAwal::getBarang');


//stokopname
$routes->get('stok_opname', 'StokOpname::index', ['filter' => 'auth']);
$routes->post('insert/stokopname', 'StokOpname::simpan', ['filter' => 'auth']);
$routes->post('insert/stokopnamefix', 'StokOpname::simpanFix', ['filter' => 'auth']);
$routes->get('stokopname/loadtable', 'StokOpname::loadTable');


//kartu stok
$routes->get('kartu_stok', 'Kartu_Stok::index', ['filter' => 'auth']);
$routes->post('export/kartu_stock', 'Kartu_Stok::export', ['filter' => 'auth']);

//kartu stok
$routes->get('produk_terlaris', 'Produk_Terlaris::index', ['filter' => 'auth']);

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

//fee service
$routes->get('fee_service', 'Fee_Service::index', ['fileter' => 'auth']);

//tugas
$routes->get('tugas', 'Tugas::index', ['filter' => 'auth']);
$routes->get('alltugas', 'Tugas::index2', ['filter' => 'auth']);
$routes->post('add_tugas', 'Tugas::insert', ['filter' => 'auth']);
$routes->post('update_tugas', 'Tugas::update', ['filter' => 'auth']);
$routes->post('delete_tugas', 'Tugas::delete', ['filter' => 'auth']);
$routes->post('clear_all_tugas', 'Tugas::clear_all', ['filter' => 'auth']);

$routes->post('tugas/updateStatus', 'Tugas::updateStatus');


//tugas
$routes->get('riwayat_tugas', 'Riwayat_Tugas::index', ['filter' => 'auth']);

$routes->get('template_tugas', 'TemplateTugas::index');
$routes->post('insert_tugas_template', 'TemplateTugas::insert');
$routes->post('update_tugas_template', 'TemplateTugas::update');

//jadwal masuk
$routes->get('jadwal_masuk', 'JadwalMasuk::index', ['filter' => 'auth']);
$routes->get('/jadwalmasuk', 'JadwalMasuk::index');
$routes->post('/insert_jadwal', 'JadwalMasuk::insert_jadwal');
$routes->post('/update_jadwal', 'JadwalMasuk::update_jadwal');
$routes->post('/delete_jadwal', 'JadwalMasuk::delete_jadwal');


//absensi
$routes->get('absensi', 'Absensi::index', ['filter' => 'auth']);
$routes->post('kirim/lokasi_masuk', 'Absensi::kirim_lokasi_masuk', ['filter' => 'auth']);
$routes->post('kirim/lokasi_pulang', 'Absensi::kirim_lokasi_pulang', ['filter' => 'auth']);

//jenis payroll
$routes->get('jenis_payroll', 'Jenis_Payroll::index', ['filter' => 'auth']);
$routes->post('insert_payroll', 'Jenis_Payroll::insert_Payroll', ['filter' => 'auth']);

//riwayat presensi
$routes->get('riwayat_presensi', 'RiwayatPresensi::index', ['filter' => 'auth']);
$routes->get('semua_riwayat_presensi', 'RiwayatPresensi::semua_riwayat', ['filter' => 'auth']);
$routes->post('export/semua_presensi', 'RiwayatPresensi::export_semua_presensi', ['filter' => 'auth']);

//approval presensi
$routes->get('approval_presensi', 'RiwayatPresensi::approval_presensi', ['filter' => 'auth']);
$routes->post('presensi/update_status_kehadiran', 'RiwayatPresensi::submit_approval_presensi', ['filter' => 'auth']);

//absen manual
$routes->post('kirim/lokasi_masuk_manual', 'RiwayatPresensi::submit_absen_manual', ['filter' => 'auth']);
$routes->post('kirim/lokasi_pulang_manual', 'RiwayatPresensi::kirim_lokasi_pulang_manual', ['filter' => 'auth']);


//Noakun data master
$routes->get('datamaster_akun', 'NoAkun::index', ['filter' => 'auth']);
$routes->post('insert_noakun', 'NoAkun::insert', ['filter' => 'auth']);
$routes->post('update_noakun', 'NoAkun::update', ['filter' => 'auth']);


//laporan jurnal
$routes->get('laporan_jurnal', 'Jurnal::index', ['filter' => 'auth']);
$routes->post('export_jurnal', 'Jurnal::export_jurnal', ['filter' => 'auth']);

//sisikeuangan
$routes->get('sisi_keuangan', 'SisiKeuangan::index', ['filter' => 'auth']);
$routes->get('cetak/posisi_keuangan', 'SisiKeuangan::export_pdf', ['filter' => 'auth']);

$routes->get('sisi_keuangan/export_excel', 'SisiKeuangan::export_excel', ['filter' => 'auth']);
//kategorikas
$routes->get('/kategori_kas', 'Kategori_Kas::index');
$routes->post('insert_kategori', 'Kategori_Kas::insert_kategori', ['filter' => 'auth']);
$routes->post('update_kategori', 'Kategori_Kas::update_kategori', ['filter' => 'auth']);
$routes->post('delete_kategori', 'Kategori_Kas::delete_kategori', ['filter' => 'auth']);

//kas keluar
$routes->get('/kas_keluar', 'Kas_Keluar::index');
$routes->post('insert_kas_keluar', 'Kas_Keluar::insert_kas_keluar', ['filter' => 'auth']);
$routes->post('update_kas_keluar', 'Kas_Keluar::update_kas_keluar', ['filter' => 'auth']);
$routes->post('delete_kas_keluar', 'Kas_Keluar::delete_kas_keluar', ['filter' => 'auth']);
$routes->post('export_kas_keluar', 'Kas_Keluar::export', ['filter' => 'auth']);

//kas masuk
$routes->get('/kas_masuk', 'Kas_Masuk::index');
$routes->post('insert_kas_masuk', 'Kas_Masuk::insert_kas_Masuk', ['filter' => 'auth']);
$routes->post('update_kas_masuk', 'Kas_Masuk::update_kas_Masuk', ['filter' => 'auth']);
$routes->post('delete_kas_masuk', 'Kas_Masuk::delete_kas_Masuk', ['filter' => 'auth']);
$routes->post('export_kas_masuk', 'Kas_Masuk::export', ['filter' => 'auth']);

$routes->get('asset', 'Asset::index', ['filter' => 'auth']);
$routes->post('insert_asset', 'Asset::insert_asset', ['filter' => 'auth']);
$routes->post('update_asset', 'Asset::update_asset', ['filter' => 'auth']);
$routes->post('delete_asset', 'Asset::delete_asset', ['filter' => 'auth']);
$routes->get('export/asset', 'Asset::export_asset', ['filter' => 'auth']);
$routes->get('pulihkan_asset/(:num)', 'Asset::pulihkan_asset/$1', ['filter' => 'auth']);


//template_penilaian
$routes->get('template_penilaian', 'TemplatePenilaian::index', ['filter' => 'auth']);
$routes->post('insert_template_penilaian', 'TemplatePenilaian::insert', ['filter' => 'auth']);
$routes->post('update_template_penilaian', 'TemplatePenilaian::update', ['filter' => 'auth']);
$routes->post('delete_template_penilaian', 'TemplatePenilaian::delete', ['filter' => 'auth']);

//template_kpi
$routes->get('template_kpi', 'TemplateKPI::index', ['filter' => 'auth']);
$routes->post('templatekpi/insert', 'TemplateKPI::insert', ['filter' => 'auth']);
$routes->post('templatekpi/update', 'TemplateKPI::update', ['filter' => 'auth']);
$routes->post('templatekpi/delete', 'TemplateKPI::delete', ['filter' => 'auth']);


//penilaian
$routes->get('penilaian', 'Penilaian::index', ['filter' => 'auth']);
$routes->post('insert_penilaian', 'Penilaian::insert_penilaian', ['filter' => 'auth']);
$routes->post('update_penilaian', 'Penilaian::update_penilaian', ['filter' => 'auth']);
$routes->post('delete_penilaian', 'Penilaian::delete_penilaian', ['filter' => 'auth']);
$routes->post('export_penilaian', 'Penilaian::export_penilaian', ['filter' => 'auth']);
$routes->get('penilaian/get_template_by_jabatan/(:num)', 'Penilaian::get_template_by_jabatan/$1');



//penilaian kpi
$routes->get('penilaian_kpi', 'PenilaianKPI::index', ['filter' => 'auth']);
$routes->post('insert_penilaian', 'PenilaianKPI::insert_penilaian', ['filter' => 'auth']);
$routes->post('update_penilaian', 'PenilaianKPI::update_penilaian', ['filter' => 'auth']);
$routes->post('delete_penilaian', 'PenilaianKPI::delete_penilaian', ['filter' => 'auth']);
$routes->post('export_penilaian', 'PenilaianKPI::export_penilaian', ['filter' => 'auth']);


//riwayat penyusutan asset
$routes->get('riwayat_penyusutan_asset', 'RiwayatPenyusutanAsset::index', ['filter' => 'auth']);

//cronjob
$routes->get('penyusutan_cronjob', 'Asset::prosesPenyusutan');

//kategori asset
$routes->get('kategori_asset', 'KategoriAsset::index', ['filter' => 'auth']);
$routes->post('insert_kategori_asset', 'KategoriAsset::insert', ['filter' => 'auth']);
$routes->post('update_kategori_asset', 'KategoriAsset::udpatekategori', ['filter' => 'auth']);
$routes->post('delete_kategori_asset', 'KategoriAsset::deletekategori', ['filter' => 'auth']);

//template Jurnal Asset
$routes->get('template_jurnal_asset', 'TemplateJurnalAsset::index', ['filter => auth']);
$routes->post('insert_template_jurnal_asset', 'TemplateJurnalAsset::insert', ['filter => auth']);
$routes->post('delete_template_jurnal', 'TemplateJurnalAsset::delete', ['filter => auth']);

//pembayaran hutang
$routes->get('riwayat_pembayaran_hutang', 'PembayaranHutang::riwayat_pembayaran', ['filter => auth']);
$routes->get('daftar_tagihan', 'PembayaranHutang::daftar_tagihan', ['filter => auth']);
$routes->get('umur_hutang', 'PembayaranHutang::umur_hutang', ['filter => auth']);
$routes->post('update_cicilan_hutang', 'PembayaranHutang::insert_cicilan', ['filter => auth']);
$routes->post('export_riwayat_cicilan', 'PembayaranHutang::export_riwayat_cicilan', ['filter => auth']);
$routes->post('export_umur_hutang', 'PembayaranHutang::export_umur_hutang', ['filter => auth']);
$routes->post('export_daftar_hutang', 'PembayaranHutang::export_daftar_hutang', ['filter => auth']);


//bundle
$routes->get('bundle', 'Bundle::index',  ['filter => auth']);
$routes->get('input_bundle', 'Bundle::input',  ['filter => auth']);
$routes->post('insert_bundle', 'Bundle::insert',  ['filter => auth']);
$routes->get('edit_bundle/(:num)', 'Bundle::edit/$1',  ['filter => auth']);
$routes->post('update_bundle', 'Bundle::update',  ['filter => auth']);
$routes->post('delete_bundle', 'Bundle::delete',  ['filter => auth']);

//Piutang
$routes->get('piutang', 'Piutang::index',  ['filter => auth']);
$routes->post('input_piutang', 'Piutang::insert',  ['filter => auth']);
$routes->get('riwayat_pembayaran_piutang', 'Piutang::riwayat_pembayaran_piutang',  ['filter => auth']);
$routes->get('daftar_piutang', 'Piutang::daftar_tagihan',  ['filter => auth']);
$routes->post('update_cicilan_piutang', 'Piutang::bayar_piutang',  ['filter => auth']);
$routes->post('export_riwayat_ciputang', 'Piutang::export_riwayat_piutang',  ['filter => auth']);
$routes->post('export_daftar_piutang', 'Piutang::export_daftar_piutang',  ['filter => auth']);
$routes->get('umur_piutang', 'Piutang::umur_piutang',  ['filter => auth']);
$routes->post('export_aging_piutang', 'Piutang::export_aging_piutang',  ['filter => auth']);