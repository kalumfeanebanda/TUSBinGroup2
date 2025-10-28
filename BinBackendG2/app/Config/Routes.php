<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('api', static function($routes) {

$routes->get('bins', 'Api\Bins::index');
    $routes->post('bins', 'Api\Bins::create');
$routes->delete('bins/(:num)', 'Api\Bins::delete/$1');

});
