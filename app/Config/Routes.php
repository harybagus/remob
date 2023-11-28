<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
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

$routes->get('/renter', 'Renter::index');
