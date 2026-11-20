<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'inicio';

$route['inventario'] = 'inventario/index';
$route['inventario/crear'] = 'inventario/crear';
$route['inventario/guardar'] = 'inventario/guardar';
$route['inventario/editar/(:num)'] = 'inventario/editar/$1';
$route['inventario/actualizar/(:num)'] = 'inventario/actualizar/$1';
$route['inventario/eliminar/(:num)'] = 'inventario/eliminar/$1';

$route['proveedores'] = 'proveedores/index';
$route['proveedores/crear'] = 'proveedores/crear';
$route['proveedores/guardar'] = 'proveedores/guardar';
$route['proveedores/editar/(:num)'] = 'proveedores/editar/$1';
$route['proveedores/actualizar/(:num)'] = 'proveedores/actualizar/$1';
$route['proveedores/cambiar_estado/(:num)'] = 'proveedores/cambiar_estado/$1';

$route['portal'] = 'portal/index';
$route['portal/administrativo'] = 'portal/administrativo';

$route['auth/cliente'] = 'auth/cliente';
$route['auth/administrativo/(:num)'] = 'auth/administrativo/$1';
$route['auth/validar_cliente'] = 'auth/validar_cliente';
$route['auth/validar_admin/(:num)'] = 'auth/validar_admin/$1';
$route['auth/cerrar_sesion'] = 'auth/cerrar_sesion';
$route['auth/logout'] = 'auth/cerrar_sesion';
$route['auth/registro'] = 'auth/registro';
$route['auth/guardar_registro'] = 'auth/guardar_registro';

$route['admin/dashboard'] = 'admin/dashboard';
$route['vendedor/dashboard'] = 'ventas/index';
$route['tecnico/dashboard'] = 'servicio_tecnico/index';
$route['404_override'] = '';

$route['clientes'] = 'clientes/index';
$route['clientes/crear'] = 'clientes/crear';
$route['clientes/guardar'] = 'clientes/guardar';
$route['clientes/editar/(:num)'] = 'clientes/editar/$1';
$route['clientes/actualizar/(:num)'] = 'clientes/actualizar/$1';

$route['compras'] = 'compras/index';
$route['compras/crear'] = 'compras/crear';
$route['compras/guardar'] = 'compras/guardar';
$route['compras/detalle/(:num)'] = 'compras/detalle/$1';
$route['compras/recibir/(:num)'] = 'compras/recibir/$1';
$route['compras/cancelar/(:num)'] = 'compras/cancelar/$1';

$route['ventas/guardar'] = 'ventas/guardar';
$route['ventas'] = 'ventas/index';
$route['ventas/crear'] = 'ventas/crear';
$route['ventas/guardar'] = 'ventas/guardar';
$route['ventas/detalle/(:num)'] = 'ventas/detalle/$1';
$route['ventas/cupones/(:num)'] = 'ventas/cupones/$1';

$route['garantias'] = 'garantias/index';
$route['garantias/detalle/(:num)'] = 'garantias/detalle/$1';
$route['garantias/actualizar'] = 'garantias/actualizar';

$route['creditos'] = 'creditos/index';
$route['creditos/detalle/(:num)'] = 'creditos/detalle/$1';

$route['pagos'] = 'pagos/index';
$route['pagos/crear'] = 'pagos/crear';
$route['pagos/guardar'] = 'pagos/guardar';
$route['pagos/detalle/(:num)'] = 'pagos/detalle/$1';
$route['pagos/aprobar/(:num)'] = 'pagos/aprobar/$1';

$route['usuarios'] = 'usuarios/index';
$route['usuarios/crear'] = 'usuarios/crear';
$route['usuarios/guardar'] = 'usuarios/guardar';
$route['usuarios/editar/(:num)'] = 'usuarios/editar/$1';
$route['usuarios/actualizar/(:num)'] = 'usuarios/actualizar/$1';


$route['descuentos'] = 'descuentos/index';
$route['descuentos/crear'] = 'descuentos/crear';
$route['descuentos/guardar'] = 'descuentos/guardar';
$route['descuentos/editar/(:num)'] = 'descuentos/editar/$1';
$route['descuentos/actualizar/(:num)'] = 'descuentos/actualizar/$1';

// Servicio Técnico
$route['servicio_tecnico'] = 'Servicio_tecnico/index';
$route['servicio_tecnico/crear'] = 'Servicio_tecnico/crear';
$route['servicio_tecnico/guardar'] = 'Servicio_tecnico/guardar';
$route['servicio_tecnico/detalle/(:num)'] = 'Servicio_tecnico/detalle/$1';
$route['servicio_tecnico/asignar_tecnico'] = 'Servicio_tecnico/asignar_tecnico';
$route['servicio_tecnico/actualizar_diagnostico'] = 'Servicio_tecnico/actualizar_diagnostico';
$route['servicio_tecnico/actualizar_estado'] = 'Servicio_tecnico/actualizar_estado';
$route['servicio_tecnico/tecnicos'] = 'Servicio_tecnico/tecnicos';

$route['contabilidad'] = 'Contabilidad/index';
$route['contabilidad/registrar_egreso'] = 'Contabilidad/registrar_egreso';
$route['contabilidad/guardar_egreso'] = 'Contabilidad/guardar_egreso';
$route['contabilidad/eliminar_egreso/(:num)'] = 'Contabilidad/eliminar_egreso/$1';
$route['contabilidad/egresos'] = 'Contabilidad/egresos';

$route['reportes'] = 'Reportes/index';

$route['cliente'] = 'Cliente/index';
$route['cliente/dashboard'] = 'Cliente/index';

$route['cliente/productos'] = 'Cliente_productos/index';
$route['cliente/productos/detalle/(:num)'] = 'Cliente_productos/detalle/$1';

$route['cliente/carrito'] = 'Cliente_carrito/index';
$route['cliente/carrito/agregar'] = 'Cliente_carrito/agregar';
$route['cliente/carrito/actualizar'] = 'Cliente_carrito/actualizar';
$route['cliente/carrito/eliminar'] = 'Cliente_carrito/eliminar';
$route['cliente/carrito/confirmar'] = 'Cliente_carrito/confirmar';

$route['cliente/pedidos'] = 'Cliente_pedidos/index';
$route['cliente/pedidos/detalle/(:num)'] = 'Cliente_pedidos/detalle/$1';

$route['cliente/pagos'] = 'Cliente_pagos/index';
$route['cliente/pagos/detalle/(:num)'] = 'Cliente_pagos/detalle/$1';

$route['cliente/creditos'] = 'Cliente_creditos/index';
$route['cliente/creditos/detalle/(:num)'] = 'Cliente_creditos/detalle/$1';
$route['cliente/garantias'] = 'Cliente_garantias/index';
$route['cliente/garantias/detalle/(:num)'] = 'Cliente_garantias/detalle/$1';
$route['cliente/servicio_tecnico'] = 'Cliente_servicio/index';
$route['cliente/servicio_tecnico/solicitar'] = 'Cliente_servicio/solicitar';
$route['cliente/servicio_tecnico/guardar'] = 'Cliente_servicio/guardar';
$route['cliente/servicio_tecnico/detalle/(:num)'] = 'Cliente_servicio/detalle/$1';
$route['cliente/perfil'] = 'Cliente_perfil/index';
$route['cliente/perfil/actualizar'] = 'Cliente_perfil/actualizar';

$route['translate_uri_dashes'] = FALSE;
