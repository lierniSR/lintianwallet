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

/**
 * Traducciones
 */
$routes->get('jsoncontroller/traducciones', 'C_Json::traducciones');
