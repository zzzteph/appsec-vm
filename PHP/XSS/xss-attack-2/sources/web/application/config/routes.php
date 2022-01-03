<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'main';

$route['registration'] = 'user/registration';
$route['login'] = 'user/login';
$route['logout'] = 'user/logout';
$route['user'] = 'user/index';
//messages block
$route['messages'] = 'messages/index';
$route['write/(:num)'] = 'messages/writemessage/$1';
//messages end
$route['user/changepassword'] = 'user/setting_page';


$route['user/(:num)'] = 'user/userpage/$1';



$route['latest'] = 'messages/latestMessage';



$route['SuperSecret'] = 'user/DragHU8t27C6n9ff';




$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
