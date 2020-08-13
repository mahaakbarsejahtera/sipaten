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

	
	$routes->post('survey/items/add', 'Survey::addItems');
	$routes->post('survey/item/add', 'Survey::addItem');

	// Permintaan
	$routes->get('permintaan', 'Permintaan::index');
	$routes->get('permintaan/show/(:num)', 'Permintaan::show/$1');

	$routes->post('permintaan', 'Permintaan::store');
	$routes->post('permintaan/update', 'Permintaan::update');

	$routes->post('permintaan/(:num)/delete', 'Permintaan::delete/$1');
	$routes->post('permintaan/destroy', 'Permintaan::destroy');

	// ROLES
	$routes->get('roles', 'Roles::index');
	$routes->get('roles/show/(:num)', 'Roles::show/$1');

	$routes->post('roles', 'Roles::store');
	$routes->post('roles/update', 'Roles::update');

	$routes->post('roles/(:num)/delete', 'Roles::delete/$1');
	$routes->post('roles/destroy', 'Roles::destroy');


});


$routes->group('dashboard', [ 'namespace' => 'App\Controllers\Admin' ], function($routes){

	$routes->get('users', 'Users::index');
	$routes->get('roles', 'Roles::index');
	$routes->get('permintaan', 'Permintaan::index');
	$routes->get('survey', 'Survey::index');

	// KAK NABILA

	
	$routes->get('pemasaran', 'Home::dashboardPemasaran');
	$routes->get('teknik', 'Home::dashboardTeknik');
	$routes->get('hirup', 'Home::dashboardTeknik');

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
