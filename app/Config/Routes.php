<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/**
 * Login y registro
 */
$routes->get('/login', 'C_Login::index');
$routes->post('/login', 'C_Login::index');
$routes->post('/registro', 'C_Login::registroIndex');


/**
 * Modo Desarrollo
 */
$routes->get('/registro', 'C_Login::registroIndex');

/**
 * Traducciones
 */
$routes->get('jsoncontroller/traducciones', 'C_Json::traducciones');
