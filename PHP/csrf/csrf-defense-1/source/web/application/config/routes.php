<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Main';
$route['auth'] = 'Main/auth';
$route['login'] = 'Main/login';
$route['posts/(:num)'] = 'Main/post/$1';
$route['addcomment'] = 'Main/addcomment';
$route['logout'] = 'Main/logout';
$route['like/(:num)'] = 'Main/addlike/$1';
$route['dislike/(:num)'] = 'Main/dislike/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
