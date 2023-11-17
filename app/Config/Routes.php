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
