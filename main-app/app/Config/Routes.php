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
$routes->get('/', 'Home::index', ['as' => 'Home']);
$routes->post('/process', 'Home::process');
$routes->get('/request-submitted', 'Home::submitted');

// Admin routes
$routes->get('/admin', 'Admin::index', ['as' => 'admin-login']);
$routes->match(['get', 'post'], '/admin/auth', 'Admin::auth', ['as' => 'admin-auth']);
$routes->get('/admin/logout', 'Admin::logout', ['as' => 'admin-logout']);
$routes->get('/dashboard', 'Dashboard::index', ['as' => 'admin-dashboard']);
$routes->get('/dashboard/user/(:num)', 'Dashboard::user/$1', ['as' => 'view-user']);
$routes->get('/dashboard/user/edit/(:num)', 'Dashboard::edit/$1', ['as' => 'edit-user']);
$routes->post('/dashboard/user/update/(:num)', 'Dashboard::updateUsersInfo/$1', ['as' => 'update-user']);
$routes->post('/dashboard/user/reject/(:num)', 'Dashboard::reject/$1', ['as' => 'reject-user']);
$routes->post('/dashboard/user/approve/(:num)', 'Dashboard::approve/$1', ['as' => 'approve-user']);
$routes->post('/dashboard/user/delete/(:num)', 'Dashboard::delete/$1', ['as' => 'delete-user']);
$routes->post('/dashboard/user/process-additional-info/(:num)', 'Dashboard::processAdditionalInformation/$1', ['as' => 'process-additional-info']);
$routes->get('/dashboard/document/delete/(:num)', 'Dashboard::deleteDocument/$1', ['as' => 'delete-document']);

$routes->get('/dashboard/services', 'Dashboard::services', ['as' => 'services']);
$routes->post('/dashboard/add-service', 'Dashboard::addNewService', ['as' => 'add-service']);
$routes->get('/dashboard/service/delete/(:num)', 'Dashboard::deleteService/$1', ['as' => 'delete-service']);

// $routes->post('/fetch', 'Search::index', ['as' => 'search']);
$routes->post('/fetch-all', 'Search::fetchAll', ['as' => 'search-all']);
$routes->post('/fetch-by-search', 'Search::fetchBySearchTerms', ['as' => 'search-by-input']);
$routes->post('/fetch-by-ids', 'Search::fetchByIds', ['as' => 'search-by-ids']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
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
