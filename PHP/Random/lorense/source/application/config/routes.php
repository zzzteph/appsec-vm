<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'main';

$route['registration'] = 'user/registration';
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['user'] = 'user/index';
$route['user/change/password'] = 'user/PasswordSettings';
$route['user/change/settings'] = 'user/UserSettings';
$route['user/(:num)'] = 'user/userpage/$1';
$route['edit/(:any)'] = 'main/edit/$1';
$route['delete/(:any)'] = 'main/delete/$1';




$route['admin'] = 'main/admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
