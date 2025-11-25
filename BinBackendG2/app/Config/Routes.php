<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public home route (not inside API group)
$routes->get('/', 'Home::index');

// API Routes Group
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function($routes) {

    // User registration
    $routes->match(['options', 'post'], 'login', 'Users::login');
    $routes->post('register', 'Users::register');

    // User CRUD routes
    $routes->get('users', 'Users::index');
    $routes->post('users', 'Users::create');
    $routes->put('users/(:num)', 'Users::update/$1');
    $routes->delete('users/(:num)', 'Users::delete/$1');

    // Bin routes
    $routes->get('bins', 'Bins::index');
    $routes->post('bins', 'Bins::create');
    $routes->put('bins/(:num)', 'Bins::update/$1');
    $routes->delete('bins/(:num)', 'Bins::delete/$1');


    //search + result routes
    $routes->get('items/search-names', 'Items::searchNames');
    $routes->get('items/(:num)', 'Items::resultP/$1');
    $routes->get('items/search-barcode', 'Items::searchBarcode');


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


    //ItemBin Routes
    $routes->get('itembin', 'ItemBin::index');                           // Get all
    $routes->post('itembin', 'ItemBin::create');                         // Create new
    $routes->put('itembin/(:num)/(:num)', 'ItemBin::update/$1');      // Update
    $routes->delete('itembin/(:num)/(:num)', 'ItemBin::delete/$1');   // Delete


    //itemcodes Routes
    $routes->get('itemcodes', 'ItemCodes::index');
    $routes->post('itemcodes', 'ItemCodes::create');
    $routes->put('itemcodes/(:num)', 'ItemCodes::update/$1');
    $routes->delete('itemcodes/(:num)', 'ItemCodes::delete/$1');



    //For admin

    $routes->group('admin', static function($routes) {
        $routes->post('login', 'Admin::login');
    });
});
