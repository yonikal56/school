<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['gallery/(:any)'] = "home/gallery/$1";
$route['calendar'] = "home/calendar";
$route['page/(:any)'] = "home/page/$1";
$route['admin'] = 'admin/dashboard';
$route['admin/login'] = 'admin/dashboard/login';
$route['admin/logout'] = 'admin/dashboard/logout';
$route['admin/updatePass'] = 'admin/dashboard/updatePass';
$route['admin/(:any)/(:num)'] = 'admin/$1/index/$2';
$route['admin/(:any)/(:num)/(:any)'] = 'admin/$1/index/$2/$3';