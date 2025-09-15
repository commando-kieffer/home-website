<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->set404Override('App\Controllers\Home::not_found');

$routes->get('/', 'Home::index');
$routes->get('/caserne', 'Home::caserne');
$routes->get('/decorations', 'Home::decorations');
$routes->get('/noms', 'Home::noms');
$routes->get('/points', 'Home::points');
$routes->get('/metiers', 'Home::metiers');
$routes->get('/histoire', 'Home::history');
$routes->get('/galerie', 'Home::galerie');
$routes->get('/galerie/(:segment)', 'Home::galerie/$1');
$routes->get('/galerie/(:segment)/photo/(:num)', 'Home::galerie/$1/$2');
