<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public home route
$routes->get('/', 'Home::index');

// API Routes Group
// All API routes are prefixed with 'api' and use the 'App\Controllers\Api' namespace
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function($routes) {

    // --- WORKING USER ROUTES (Example) ---
    $routes->match(['options', 'post'], 'login', 'Users::login');
    $routes->post('register', 'Users::register');
    // ... (rest of the user routes and other resource routes) ...

    // Other API endpoints for CRUD operations (assuming these are correct)
    $routes->get('users', 'Users::index');
    $routes->post('users', 'Users::create');
    $routes->put('users/(:num)', 'Users::update/$1');
    $routes->delete('users/(:num)', 'Users::delete/$1');

    $routes->get('bins', 'Bins::index');
    $routes->post('bins', 'Bins::create');
    $routes->put('bins/(:num)', 'Bins::update/$1');
    $routes->delete('bins/(:num)', 'Bins::delete/$1');

    $routes->get('items/search-names', 'Items::searchNames');
    $routes->get('items/(:num)', 'Items::resultP/$1');
    $routes->get('items', 'Items::index');
    $routes->post('items', 'Items::create');
    $routes->put('items/(:num)', 'Items::update/$1');
    $routes->delete('items/(:num)', 'Items::delete/$1');

    $routes->get('steps', 'Steps::index');
    $routes->post('steps', 'Steps::create');
    $routes->put('steps/(:num)', 'Steps::update/$1');
    $routes->delete('steps/(:num)', 'Steps::delete/$1');

    $routes->get('itembin', 'ItemBin::index');
    $routes->post('itembin', 'ItemBin::create');
    $routes->put('itembin/(:num)/(:num)', 'ItemBin::update/$1');
    $routes->delete('itembin/(:num)/(:num)', 'ItemBin::delete/$1');

    // --- CRITICAL ADMIN LOGIN ROUTE FIX ---
    // Endpoint: /api/admin/login
    // Uses the full namespace (\App\Controllers\Api\Admin) to ensure the router finds the controller.
    $routes->match(['options', 'post'], 'admin/login', '\App\Controllers\Api\Admin::login');
});