<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
#$routes->get('/', 'Home::index');





$routes->get('/', 'PizzaController::order');
$routes->get('checkout', 'PizzaController::checkout');
$routes->post('submitData', 'PizzaController::submitData');
$routes->post('finalSubmit', 'PizzaController::finalSubmit');
$routes->post('getPizzaSize', 'PizzaController::getPizzaSize');

