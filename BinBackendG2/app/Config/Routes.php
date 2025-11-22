<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// Group all API routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function($routes) {

    // USER LOGIN + REGISTER
    $routes->match(['options', 'post'], 'login', 'Users::login');
    $routes->post('register', 'Users::register');

    // USERS CRUD
    $routes->get('users', 'Users::index');
    $routes->post('users', 'Users::create');
    $routes->put('users/(:num)', 'Users::update/$1');
    $routes->delete('users/(:num)', 'Users::delete/$1');

    // BINS CRUD
    $routes->get('bins', 'Bins::index');
    $routes->post('bins', 'Bins::create');
    $routes->put('bins/(:num)', 'Bins::update/$1');
    $routes->delete('bins/(:num)', 'Bins::delete/$1');

    // ITEMS CRUD
    $routes->get('items/search-names', 'Items::searchNames');
    $routes->get('items/(:num)', 'Items::resultP/$1');
    $routes->get('items', 'Items::index');
    $routes->post('items', 'Items::create');
    $routes->put('items/(:num)', 'Items::update/$1');
    $routes->delete('items/(:num)', 'Items::delete/$1');

    // STEPS CRUD
    $routes->get('steps', 'Steps::index');
    $routes->post('steps', 'Steps::create');
    $routes->put('steps/(:num)', 'Steps::update/$1');
    $routes->delete('steps/(:num)', 'Steps::delete/$1');

    // ITEMBIN
    $routes->get('itembin', 'ItemBin::index');
    $routes->post('itembin', 'ItemBin::create');
    $routes->put('itembin/(:num)/(:num)', 'ItemBin::update/$1');
    $routes->delete('itembin/(:num)/(:num)', 'ItemBin::delete/$1');

    // ADMIN LOGIN (FIXED)
    $routes->match(['options', 'post'], 'admin/login', 'Admin::login');
});

