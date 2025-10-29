<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('api', static function($routes) {

$routes->get('bins', 'Api\Bins::index');
$routes->post('bins', 'Api\Bins::create');
$routes->put('bins/(:num)', 'Api\Bins::update/$1');
$routes->delete('bins/(:num)', 'Api\Bins::delete/$1');

});
