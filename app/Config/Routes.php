<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');


$routes->group('api', [ 'namespace' => 'App\Controllers\Api' ], function($routes){

	// USERS
	$routes->get('users', 'Users::index');
	$routes->get('users/show/(:num)', 'Users::show/$1');

	$routes->post('users', 'Users::store');
	$routes->post('users/update', 'Users::update');

	$routes->post('users/(:num)/delete', 'Users::delete/$1');
	$routes->post('users/destroy', 'Users::destroy');
	$routes->post('users/change-password', 'Users::changePassword');

	// Survey
	$routes->get('survey', 'Survey::index');
	$routes->get('survey/show/(:num)', 'Survey::show/$1');

	$routes->post('survey', 'Survey::store');
	$routes->post('survey/update', 'Survey::update');

	$routes->post('survey/(:num)/delete', 'Survey::delete/$1');
	$routes->post('survey/destroy', 'Survey::destroy');

	
	$routes->post('survey/item/add', 'Survey::addItem');
	$routes->post('survey/items/add', 'Survey::addItems');
	$routes->get('survey/item/load', 'Survey::loadItems');
	$routes->post('survey/item/delete/(:num)', 'Survey::deleteItem/$1');
	$routes->post('survey/item/update', 'Survey::updateItem');



	// Permintaan
	$routes->get('permintaan', 'Permintaan::index');
	$routes->get('permintaan/show/(:num)', 'Permintaan::show/$1');

	$routes->post('permintaan', 'Permintaan::store');
	$routes->post('permintaan/update', 'Permintaan::update');
	$routes->post('permintaan/penunjukan/(:num)', 'Permintaan::accPenunjukan/$1');
	$routes->post('permintaan/hasil-survey/(:num)', 'Permintaan::accHasilSurvey/$1');

	$routes->post('permintaan/(:num)/delete', 'Permintaan::delete/$1');
	$routes->post('permintaan/destroy', 'Permintaan::destroy');

	//Nego
	$routes->get('negosiasi', 'Negosiasi::index');
	$routes->get('negosiasi/show/(:num)', 'Negosiasi::show/$1');

	$routes->post('negosiasi', 'Negosiasi::store');
	$routes->post('negosiasi/update', 'Negosiasi::update');
	$routes->post('negosiasi/harga', 'Negosiasi::updateNegosiasi');

	$routes->post('negosiasi/(:num)/delete', 'Negosiasi::delete/$1');
	$routes->post('negosiasi/destroy', 'Negosiasi::destroy');

	// Permintaan Item
	$routes->get('permintaan-item', 'PermintaanItem::index');
	$routes->get('permintaan-item/show/(:num)', 'PermintaanItem::show/$1');
	$routes->post('permintaan-item/add', 'PermintaanItem::store');
	$routes->post('permintaan-item/update', 'PermintaanItem::update');
	$routes->post('permintaan-item/update-estimasi', 'PermintaanItem::updateEstimasi');
	$routes->post('permintaan-item/update-boq', 'PermintaanItem::updateBoq');
	$routes->post('permintaan-item/(:num)/delete', 'PermintaanItem::delete/$1');

	
	//Anggaran
	$routes->get('anggaran', 'Anggaran::index');
	$routes->get('anggaran/show/(:num)', 'Anggaran::show/$1');

	$routes->post('anggaran', 'Anggaran::store');
	$routes->post('anggaran/update', 'Anggaran::update');

	$routes->post('anggaran/(:num)/delete', 'Anggaran::delete/$1');


	// Permintaan Item
	$routes->get('anggaran-item', 'AnggaranItem::index');
	$routes->get('anggaran-item/show/(:num)', 'AnggaranItem::show/$1');
	$routes->post('anggaran-item/add', 'AnggaranItem::store');
	$routes->post('anggaran-item/update', 'AnggaranItem::update');
	$routes->post('anggaran-item/(:num)/delete', 'AnggaranItem::delete/$1');
	
	// Penawaran
	$routes->get('penawaran', 'Penawaran::index');
	$routes->get('penawaran/show/(:num)', 'Penawaran::show/$1');

	$routes->post('penawaran', 'Penawaran::store');
	$routes->post('penawaran/update', 'Penawaran::update');

	$routes->post('penawaran/(:num)/delete', 'Penawaran::delete/$1');
	$routes->post('penawaran/destroy', 'Penawaran::destroy');
	$routes->get('penawaran/no-penawaran/(:num)', 'Penawaran::noPenawaran/$1');

	// Roles
	$routes->get('roles', 'Roles::index');
	$routes->get('roles/show/(:num)', 'Roles::show/$1');

	$routes->post('roles', 'Roles::store');
	$routes->post('roles/update', 'Roles::update');

	$routes->post('roles/(:num)/delete', 'Roles::delete/$1');
	$routes->post('roles/destroy', 'Roles::destroy');

	//CUSTOMER
	$routes->get('customer', 'Customer::index');
	$routes->get('customer/show/(:num)', 'Customer::show/$1');

	$routes->post('customer', 'Customer::store');
	$routes->post('customer/update', 'Customer::update');

	$routes->post('customer/(:num)/delete', 'Customer::delete/$1');
	$routes->post('customer/destroy', 'Customer::destroy');

	//PIC
	$routes->get('pic', 'Pic::index');
	$routes->get('pic/show/(:num)', 'Pic::show/$1');

	$routes->post('pic', 'Pic::store');
	$routes->post('pic/update', 'Pic::update');

	$routes->post('pic/(:num)/delete', 'Pic::delete/$1');
	$routes->post('pic/destroy', 'Pic::destroy');

	//Jenis Pengajuan
	$routes->get('jenis-pengajuan', 'JenisPengajuan::index');
	$routes->get('jenis-pengajuan/show/(:num)', 'JenisPengajuan::show/$1');

	$routes->post('jenis-pengajuan', 'JenisPengajuan::store');
	$routes->post('jenis-pengajuan/update', 'JenisPengajuan::update');

	$routes->post('jenis-pengajuan/(:num)/delete', 'JenisPengajuan::delete/$1');
	$routes->post('jenis-pengajuan/destroy', 'JenisPengajuan::destroy');

	//Penanggung Jawab
	$routes->get('penanggung-jawab', 'PenanggungJawab::index');
	$routes->get('penanggung-jawab/show/(:num)', 'PenanggungJawab::show/$1');

	$routes->post('penanggung-jawab', 'PenanggungJawab::store');
	$routes->post('penanggung-jawab/update', 'PenanggungJawab::update');

	$routes->post('penanggung-jawab/(:num)/delete', 'PenanggungJawab::delete/$1');
	$routes->post('penanggung-jawab/destroy', 'PenanggungJawab::destroy');

	//Pengajuan Proyek
	$routes->get('pengajuan-proyek', 'PengajuanProyek::index');
	$routes->get('pengajuan-proyek/show/(:num)', 'PengajuanProyek::show/$1');

	$routes->post('pengajuan-proyek', 'PengajuanProyek::store');
	$routes->post('pengajuan-proyek/update', 'PengajuanProyek::update');

	$routes->post('pengajuan-proyek/(:num)/delete', 'PengajuanProyek::delete/$1');
	$routes->post('pengajuan-proyek/destroy', 'PengajuanProyek::destroy');

	// Pengajuan Proyek Item
	$routes->get('pengajuan-proyek-item', 'PengajuanProyekItem::index');
	$routes->get('pengajuan-proyek-item/show/(:num)', 'PengajuanProyekItem::show/$1');

	$routes->post('pengajuan-proyek-item', 'PengajuanProyekItem::store');
	$routes->post('pengajuan-proyek-item/update', 'PengajuanProyekItem::update');

	$routes->post('pengajuan-proyek-item/(:num)/delete', 'PengajuanProyekItem::delete/$1');
	$routes->post('pengajuan-proyek-item/destroy', 'PengajuanProyekItem::destroy');


	
	

});


$routes->group('dashboard', [ 'namespace' => 'App\Controllers\Admin' ], function($routes){

	$routes->get('users', 'Users::index');
	$routes->get('roles', 'Roles::index');
	$routes->get('permintaan', 'Permintaan::index');
	$routes->get('survey', 'Survey::index');
	$routes->get('jenis-pengajuan', 'Home::dashboardJenisPengajuan');

	$routes->group('pemasaran', function($routes) {

		$routes->get('customer', 'Home::pemasaranCustomer');
		$routes->get('permintaan', 'Home::pemasaranPermintaan');
		$routes->get('penawaran', 'Home::pemasaranPenawaran');
		$routes->get('negosiasi', 'Home::pemasaranNegoisasi');

		$routes->group('pengajuan', function($routes) { 

			$routes->get('operasional', 'Home::pemasaranPengajuanOperasional');

		});

	});

	$routes->group('teknik', function($routes) {

		$routes->get('permintaan', 'Home::teknikPermintaan');
		$routes->get('survey', 'Home::teknikSurvey');
		$routes->get('anggaran', 'Home::teknikAnggaran');

		$routes->group('pengajuan', function($routes) {
			$routes->get('operasional', function(){

			});
		});

	});

	$routes->get('laporan/lampiran-boq', 'Laporan::lampiranBoq');

	$routes->group('laporan', function($routes) {
		$routes->get('estimasi', 'Laporan::hasilEstimasi');
		$routes->get('lampiran-penawaran', 'Laporan::lampiranPenawaran');
		$routes->get('nego', 'Laporan::lampiranNego');
		$routes->get('anggaran', 'Laporan::lampiranAnggaran');
	});

	 


});

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
