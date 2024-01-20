<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'home/notfound';
$route['translate_uri_dashes'] = FALSE;

$route['404'] = 'home/notfound';
$route['login/admin'] = 'home/login';
$route['c/(:any)'] = 'categories/index/$1';
$route['p/(:any)'] = 'products/detail_product/$1';
$route['products'] = 'products/index';
$route['products/getgrosir'] = 'products/getgrosir';
$route['cart'] = 'cart/index';
$route['register'] = 'auth/register';
$route['kontak'] = 'kontak';
$route['about'] = 'about';
$route['login'] = 'auth/login';
$route['logout'] = 'home/logout';
$route['profile'] = 'profile';
$route['profile/riwayat-transaksi'] = 'profile/riwayat_transaksi';
$route['profile/edit-profile'] = 'profile/edit_profile';
$route['profile/change-password'] = 'profile/change_password';
$route['administrator'] = 'administrator/index';
$route['administrator/product/add'] = 'administrator/add_product';
$route['administrator/product/add-img/(:num)'] = 'administrator/add_img_product/$1';
$route['administrator/product/grosir/(:num)'] = 'administrator/add_grosir_product/$1';
$route['administrator/product/(:num)/edit'] = 'administrator/edit_product/$1';
$route['administrator/setting/navmenu'] = 'administrator/navmenu_setting';
$route['administrator/setting/navmenu/add'] = 'administrator/add_navmenu_setting';
$route['administrator/setting/navmenu/(:num)'] = 'administrator/edit_navmenu_setting/$1';
$route['administrator/setting/banner'] = 'administrator/banner_setting';
$route['administrator/setting/banner/add'] = 'administrator/add_banner_setting';
$route['(:any)'] = 'page/index/$1';
