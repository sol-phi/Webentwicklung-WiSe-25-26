<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Tasks ist hardcoded damit public/*Nichts* keinen 404 Fehler wirft, der Rest wird über AutoRouting gesteuert
$routes->get('/', 'Tasks::getIndex');
$routes->get('/tasks', 'Tasks::getIndex');
