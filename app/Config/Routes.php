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
$routes->get('/admin/account/create', 'Admin::createAccountAdmin');
$routes->post('/admin/account/add', 'Admin::addAccount');
$routes->get('/admin/account/update/(:num)', 'Admin::updateAccountAdmin/$1');
$routes->post('/admin/account/edit/(:num)', 'Admin::editAccount/$1');
$routes->get('/admin/account/delete/(:num)', 'Admin::deleteAccount/$1');
