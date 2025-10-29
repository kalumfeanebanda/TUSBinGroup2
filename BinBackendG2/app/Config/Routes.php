<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function($routes) {
    $routes->get('bins', 'Bins::index');
    $routes->post('bins', 'Bins::create');
    $routes->delete('bins/(:num)', 'Bins::delete/$1');

    // ✅ This will now correctly map to App\Controllers\Api\Users
    $routes->post('register', 'Users::register');
});

