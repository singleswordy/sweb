<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']    = "Rank";
$route['404_override']          = '';
$route['test']                  = 'rank/test';

// rank list
$route['list']                  = "rank/show_list/0"; 
$route['list/(:num)']           = "rank/show_list/$1"; 

// rank detail
$route['detail/(:any)']         = "rank/show_detail/$1";

// adv_add detail
$route['add/(:any)']            = "rank/show_add_adv/$1";
$route['add']                   = "rank/show_add_adv/0";
$route['doadd']                 = "rank/do_add";

// register
$route['register']              = "login/show_register";
$route['activate']              = "login/do_activate";
$route['doregister']            = "login/do_register";
$route['checkexist']            = "login/check_is_exist";

// login
$route['login']                 = "login/show_login";
$route['adminlogin']            = "login/show_admin_login";
$route['captcha']               = "login/show_captcha_img";
$route['logout']                = "login/do_logout";
$route['adminlogout']           = "login/do_admin_logout";
$route['dologin']               = "login/do_login";
$route['doadminlogin']          = "login/do_admin_login";

// admin orders
$route['admin']                 = "login/show_admin_login";
$route['orders/(1|2|3|4)']      = "admin/show_orders_list/$1";
$route['uporderstatus']         = "admin/update_order_status";
$route['order/(:num)']          = "admin/get_order_detail/$1";



/* End of file routes.php */
/* Location: ./application/config/routes.php */