<?php

namespace Config;

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}


$routes->get('admin/change-password', 'Admin/Profile::change_password');
$routes->post('admin/change-password', 'Admin/Profile::change_password');
$routes->get('admin/logout', 'Admin/Profile::logout');
$routes->get('admin/forgot-password', 'Admin/Login::forgot_password');
$routes->post('admin/forgot-password', 'Admin/Login::forgot_password');

$routes->get('owner/change-password', 'Owner/Profile::change_password');
$routes->post('owner/change-password', 'Owner/Profile::change_password');
$routes->get('owner/logout', 'Owner/Profile::logout');
$routes->get('owner/forgot-password', 'Owner/Login::forgot_password');
$routes->post('owner/forgot-password', 'Owner/Login::forgot_password');

$routes->get('/about-us', 'Pages::index');
$routes->get('/contact-us', 'Pages::contact_us');
$routes->post('/contact-us', 'Pages::contact_us');
$routes->get('/privacy-policy', 'Pages::privacy');
$routes->get('/term-and-condition', 'Pages::terms');
$routes->get('/refund-policy', 'Pages::refund_policy');
$routes->get('/categories', 'Home::categories');
$routes->get('/restaurant-detail/(:any)', 'Restaurants::details/$1');
$routes->get('/offers', 'Restaurants::offers');
$routes->get('/mealdeals', 'Restaurants::mealDeals');
$routes->get('/register', 'Login::register');
$routes->post('/register', 'Login::register');
$routes->get('/forget-password', 'Login::forget_password');
$routes->get('/logout', 'Customer::logout');


$routes->get('/checkout', 'Customer::checkout');
$routes->get('/my-orders', 'Customer::my_orders');
$routes->get('/my-profile', 'Customer::my_profile');
$routes->post('/my-profile', 'Customer::my_profile');
$routes->get('/change-password', 'Customer::change_password');
$routes->post('/change-password', 'Customer::change_password');
$routes->get('/order-details/(:any)', 'Customer::order_details/$1');
