<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 * Menentukan url dan method yang akan digunakan.
 */
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/registration', 'Auth::registration');
$routes->post('/auth/create', 'Auth::create');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/admin', 'Admin::index');
$routes->get('/admin/account', 'Admin::account');
$routes->get('/admin/renter', 'Admin::renterData');
$routes->get('/admin/car', 'Admin::carData');
$routes->get('/admin/rental', 'Admin::rentalData');
$routes->get('/admin/change-password', 'Admin::changePassword');
$routes->post('/admin/change', 'Admin::change');

$routes->get('/admin/account/create', 'AdminAccount::index');
$routes->post('/admin/account/add', 'AdminAccount::add');
$routes->get('/admin/account/update/(:num)', 'AdminAccount::update/$1');
$routes->post('/admin/account/edit/(:num)', 'AdminAccount::edit/$1');
$routes->get('/admin/account/delete/(:num)', 'AdminAccount::delete/$1');

$routes->get('/admin/renter/create', 'RenterAccount::index');
$routes->post('/admin/renter/add', 'RenterAccount::add');
$routes->get('/admin/renter/update/(:num)', 'RenterAccount::update/$1');
$routes->post('/admin/renter/edit/(:num)', 'RenterAccount::edit/$1');
$routes->get('/admin/renter/delete/(:num)', 'RenterAccount::delete/$1');

$routes->get('/admin/car/create', 'Car::index');
$routes->post('/admin/car/add', 'Car::add');
$routes->get('/admin/car/update/(:num)', 'Car::update/$1');
$routes->post('/admin/car/edit/(:num)', 'Car::edit/$1');
$routes->get('/admin/car/delete/(:num)', 'Car::delete/$1');
$routes->get('/admin/car-return/(:num)', 'Car::carReturn/$1');
$routes->post('/admin/return/(:num)', 'Car::return/$1');

$routes->get('/renter', 'Renter::index');
$routes->post('/renter/save/(:num)', 'Renter::save/$1');
$routes->post('/renter/change-password', 'Renter::changePassword');
$routes->get('/renter/car', 'Renter::carData');
$routes->get('/renter/car-rental/(:num)', 'Renter::carRental/$1');
$routes->post('/renter/rental/(:num)', 'Car::rental/$1');
$routes->get('/renter/rental-data', 'Renter::rentalData');
$routes->post('/renter/add-balance/(:num)', 'Renter::addBalance/$1');
$routes->get('/renter/payment/(:num)', 'Renter::payment/$1');
$routes->post('/renter/pay/(:num)', 'Renter::pay/$1');
