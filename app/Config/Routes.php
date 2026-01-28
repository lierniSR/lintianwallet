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
$routes->post('/autenticarRegistro', 'C_Login::autenticarRegistro');
$routes->post('/autenticar', 'C_Login::autenticar');


/**
 * Modo Desarrollo
 */
$routes->get('/registro', 'C_Login::registroIndex');

/**
 * Traducciones
 */
$routes->get('jsoncontroller/traducciones', 'C_Json::traducciones');
