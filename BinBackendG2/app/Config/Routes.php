<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public home route (not inside API group)
$routes->get('/', 'Home::index');

// API Routes Group
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function($routes) {

    // Bin routes
    $routes->get('bins', 'Bins::index');
    $routes->post('bins', 'Bins::create');
    $routes->put('bins/(:num)', 'Bins::update/$1');
    $routes->delete('bins/(:num)', 'Bins::delete/$1');


    // Item routes
    $routes->get('items', 'Items::index');
    $routes->post('items', 'Items::create');
    $routes->put('items/(:num)', 'Items::update/$1');
    $routes->delete('items/(:num)', 'Items::delete/$1');

// User CRUD routes
    $routes->get('users', 'Users::index');
    $routes->post('users', 'Users::create');
    $routes->put('users/(:num)', 'Users::update/$1');
    $routes->delete('users/(:num)', 'Users::delete/$1');



    // User registration
    $routes->post('register', 'Users::register');
    $routes->post('login', 'Users::login');
});
