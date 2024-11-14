<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/getAutoCompleteLocation','Home::getAutoCompleteLocation');
$routes->get('/getAutoCompleteLocationByGoogle','Home::getAutoCompleteLocationByGoogle');
$routes->get('/contact', 'Home::contact');
$routes->get('/location', 'Home::location');
$routes->get('/login', 'Home::login');
$routes->post('/toLogin', 'Home::toLogin');
$routes->get('/logout', 'Home::logout');
$routes->post('/toRegist', 'Home::toRegist');
$routes->get('/toMap', 'Home::toMap');

$routes->post('/savePlaces', 'Home::savePlaces');

$routes->post('/getPrice', 'Home::getPrice');