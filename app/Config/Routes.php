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
$routes->get('/user', 'User::index');
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/account', 'Admin::account');
$routes->get('/admin/create', 'Admin::create');
$routes->post('/admin/add', 'Admin::add');
$routes->get('/admin/update/(:num)', 'Admin::update/$1');
$routes->post('/admin/edit/(:num)', 'Admin::edit/$1');
