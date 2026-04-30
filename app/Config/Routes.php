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
$routes->post('ingresos/eliminar', 'C_Ingreso::eliminarIngreso');
$routes->get('ingresos/new/(:num)', 'C_Ingreso::nuevoIngreso/$1');
$routes->post('ingresos/crear', 'C_Ingreso::crearIngreso');

/**
 * Gastos
 */
$routes->get('gastos', 'C_Gasto::index');
$routes->post('gastos/eliminar', 'C_Gasto::eliminarGasto');
$routes->get('gastos/new/(:num)', 'C_Gasto::nuevoGasto/$1');
$routes->post('gastos/crear', 'C_Gasto::crearGasto');

/**
 * Movimientos
 */
$routes->get('movimientos', 'C_Movimiento::index');

/**
 * Traducciones
 */
$routes->get('jsoncontroller/traducciones', 'C_Json::traducciones');

/**
 * Configuración
 */
$routes->get('configuracion', 'C_Configuracion::index');
$routes->post('configuracion/cambiarContrasenia', 'C_Configuracion::cambiarContrasenia');
$routes->get('logout', 'C_Login::logout');
$routes->get('usuario/foto/(:any)', 'C_Usuario::foto/$1');
