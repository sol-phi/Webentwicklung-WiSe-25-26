<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::tasks');
$routes->get('/boards', 'Home::boards');
$routes->get('/spalten', 'Home::spalten');
$routes->get('/spalten_erstellen', 'Home::spalten_erstellen');
