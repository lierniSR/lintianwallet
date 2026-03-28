<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * Login y registro
 */
$routes->get('/', 'C_Login::index');
$routes->get('/login', 'C_Login::index');
$routes->post('/login', 'C_Login::index');
$routes->post('/registro', 'C_Login::registroIndex');
$routes->get('/registro', 'C_Login::registroIndex');
$routes->post('/autenticarRegistro', 'C_Login::autenticarRegistro');
$routes->post('/autenticar', 'C_Login::autenticar');


/**
 * Tarjetas
 */
$routes->get('tarjetas', 'C_Tarjeta::index');
$routes->get('tarjetas/new', 'C_Tarjeta::nuevaCuenta');
$routes->post('tarjetas/crear', 'C_Tarjeta::crearCuenta');
$routes->get('tarjetas/modificar/(:num)', 'C_Tarjeta::modificarCuenta/$1');
$routes->post('tarjetas/modificar/(:num)', 'C_Tarjeta::modificarCuenta/$1');

/**
 * Ingresos
 */
$routes->get('ingresos', 'C_Ingreso::index');

/**
 * Traducciones
 */
$routes->get('jsoncontroller/traducciones', 'C_Json::traducciones');
