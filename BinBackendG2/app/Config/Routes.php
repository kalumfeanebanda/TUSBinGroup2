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



    // Step routes (The Steps Controller handles CRUD for /api/steps)
    $routes->get('steps', 'Steps::index');
    $routes->post('steps', 'Steps::create'); // FIXES YOUR 404 ERROR
    $routes->put('steps/(:num)', 'Steps::update/$1');
    $routes->delete('steps/(:num)', 'Steps::delete/$1');

    // User registration
    $routes->match(['options', 'post'], 'login', 'Users::login');

    $routes->post('register', 'Users::register');

});
