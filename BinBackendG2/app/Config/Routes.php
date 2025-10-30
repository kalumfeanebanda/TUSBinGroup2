<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function($routes) {
    $routes->get('bins', 'Bins::index');
    $routes->post('bins', 'Bins::create');
    $routes->delete('bins/(:num)', 'Bins::delete/$1');

$routes->get('/', 'Home::index');


$routes->group('api', static function($routes) {

$routes->get('bins', 'Api\Bins::index');
$routes->post('bins', 'Api\Bins::create');
$routes->put('bins/(:num)', 'Api\Bins::update/$1');
$routes->delete('bins/(:num)', 'Api\Bins::delete/$1');


    // map to App\Controllers\Api\Users
    $routes->post('register', 'Users::register');
});

