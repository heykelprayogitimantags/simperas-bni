<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Auth::login');

// Auth routes
$routes->group('', ['filter' => 'csrf'], function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
});

$routes->get('logout', 'Auth::logout');

// Protected routes (require login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard routes
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/admin', 'Dashboard::admin', ['filter' => 'auth:admin']);
    $routes->get('dashboard/teknisi', 'Dashboard::teknisi', ['filter' => 'auth:teknisi']);
    $routes->get('dashboard/pegawai', 'Dashboard::pegawai', ['filter' => 'auth:pegawai']);
    
    // Asset Management (Admin only)
    $routes->group('asset', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/', 'Asset::index');
        $routes->get('create', 'Asset::create');
        $routes->post('store', 'Asset::store');
        $routes->get('edit/(:num)', 'Asset::edit/$1');
        $routes->post('update/(:num)', 'Asset::update/$1');
        $routes->get('delete/(:num)', 'Asset::delete/$1');
        $routes->get('detail/(:num)', 'Asset::detail/$1');
    });
    
    // Ticket Management
    $routes->group('ticket', function($routes) {
        $routes->get('/', 'Ticket::index');
        $routes->get('create', 'Ticket::create');
        $routes->post('store', 'Ticket::store');
        $routes->get('detail/(:num)', 'Ticket::detail/$1');
        $routes->get('my-tickets', 'Ticket::myTickets'); // For pegawai
    });
    
    // Maintenance (Teknisi only)
    $routes->group('maintenance', ['filter' => 'auth:teknisi,admin'], function($routes) {
        $routes->get('/', 'Maintenance::index');
        $routes->get('update/(:num)', 'Maintenance::update/$1');
        $routes->post('save/(:num)', 'Maintenance::save/$1');
    });
    
    // Schedule Management (Admin only)
    $routes->group('schedule', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/', 'Schedule::index');
        $routes->get('create', 'Schedule::create');
        $routes->post('store', 'Schedule::store');
        $routes->get('edit/(:num)', 'Schedule::edit/$1');
        $routes->post('update/(:num)', 'Schedule::update/$1');
        $routes->get('delete/(:num)', 'Schedule::delete/$1');
    });
    
    // Report (Admin only)
    $routes->group('report', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/', 'Report::index');
        $routes->post('generate', 'Report::generate');
        $routes->get('export/(:any)', 'Report::export/$1');
    });
    
    // User Management (Admin only)
    $routes->group('user', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/', 'User::index');
        $routes->get('create', 'User::create');
        $routes->post('store', 'User::store');
        $routes->get('edit/(:num)', 'User::edit/$1');
        $routes->post('update/(:num)', 'User::update/$1');
        $routes->get('toggle-status/(:num)', 'User::toggleStatus/$1');
    });
    
    // Profile
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->post('profile/change-password', 'Profile::changePassword');

    $routes->group('report', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Report::index');
    $routes->get('assets', 'Report::assets');
    $routes->get('maintenance', 'Report::maintenance');
    $routes->get('tickets', 'Report::tickets');
});

});