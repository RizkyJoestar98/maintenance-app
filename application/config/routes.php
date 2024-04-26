<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller']            = 'auth_controller';
$route['auth/login']                    = 'auth_controller/login';
$route['auth/verify_login']             = 'auth_controller/verify_login';
$route['auth/registration']             = 'auth_controller/registration';
$route['auth/check_email']              = 'auth_controller/check_email';
$route['auth/validation_registration']  = 'auth_controller/save_registration';

//--------------------------------- Admin ---------------------------------\\
//--------------------------------- Dashboard ---------------------------------\\
$route['admin/dashboard']               = 'admin_controller/dashboard';
//--------------------------------- Dashboard ---------------------------------\\

//--------------------------------- Material ---------------------------------\\
$route['admin/material_list']           = 'admin_controller/material_list';
$route['generate_material_code']        = 'admin_controller/generate_material_code';
$route['admin/add_material_list']       = 'admin_controller/add_material_list';
$route['admin/save_material']           = 'admin_controller/save_material';
$route['admin/update_material']         = 'admin_controller/update_material';
$route['admin/delete_material']         = 'admin_controller/delete_material';
$route['admin/upload_material']         = 'admin_controller/upload_excel_material';
$route['admin/barcode']                 = 'admin_controller/barcode';
$route['select2/get_material']          = 'admin_controller/get_all_material';

$route['admin/category']                = 'admin_controller/category';
$route['select2/get_category']          = 'admin_controller/get_all_category';
$route['admin/add_category']            = 'admin_controller/add_category';
$route['admin/check_code_category']     = 'admin_controller/check_code_category';
$route['admin/save_category']           = 'admin_controller/save_category';
$route['admin/update_category']         = 'admin_controller/update_category';
$route['admin/delete_category']         = 'admin_controller/delete_category';
$route['admin/upload_category']         = 'admin_controller/upload_excel_category';

$route['admin/area']                    = 'admin_controller/area';
$route['select2/get_area']              = 'admin_controller/get_all_area';
$route['admin/add_area']                = 'admin_controller/add_area';
$route['admin/check_code_area']         = 'admin_controller/check_code_area';
$route['admin/save_area']               = 'admin_controller/save_area';
$route['admin/update_area']             = 'admin_controller/update_area';
$route['admin/delete_area']             = 'admin_controller/delete_area';

$route['admin/line']                    = 'admin_controller/line';
$route['admin/check_code_line']         = 'admin_controller/check_code_line';
$route['admin/add_line']                = 'admin_controller/add_line';
$route['admin/save_line']               = 'admin_controller/save_line';
$route['admin/update_line']             = 'admin_controller/update_line';
$route['admin/delete_line']             = 'admin_controller/delete_line';
$route['admin/upload_machine']          = 'admin_controller/upload_excel_machine';
$route['select2/get_machine_by_line']   = 'admin_controller/get_machine_by_line';

$route['admin/machine']                 = 'admin_controller/machine';
$route['admin/check_code_machine']      = 'admin_controller/check_code_machine';
$route['select2/get_line_by_area']      = 'admin_controller/get_line_by_area';
$route['admin/add_machine']             = 'admin_controller/add_machine';
$route['admin/save_machine']            = 'admin_controller/save_machine';
$route['admin/update_machine']          = 'admin_controller/update_machine';
$route['admin/delete_machine']          = 'admin_controller/delete_machine';

$route['admin/uom']                     = 'admin_controller/uom';
$route['admin/check_code_uom']          = 'admin_controller/check_code_uom';
$route['admin/add_uom']                 = 'admin_controller/add_uom';
$route['admin/save_uom']                = 'admin_controller/save_uom';
$route['admin/update_uom']              = 'admin_controller/update_uom';
$route['admin/delete_uom']              = 'admin_controller/delete_uom';
$route['select2/get_uom']               = 'admin_controller/get_all_uom';

$route['admin/location']                = 'admin_controller/location';
$route['admin/add_location']            = 'admin_controller/add_location';
$route['admin/check_code_location']     = 'admin_controller/check_code_location';
$route['admin/save_location']           = 'admin_controller/save_location';
$route['admin/update_location']         = 'admin_controller/update_location';
$route['admin/delete_location']         = 'admin_controller/delete_location';
$route['select2/get_location']          = 'admin_controller/get_all_location';
$route['admin/upload_location']         = 'admin_controller/upload_excel_location';

$route['admin/detail_material_list']    = 'admin_controller/detail_material_list';

$route['admin/posttopdf']               = 'admin_controller/post_to_pdf';
$route['admin/print_label_pdf']         = 'admin_controller/print_label_pdf';
$route['admin/material_list_pdf']       = 'admin_controller/material_list_pdf';


//--------------------------------- Material ---------------------------------\\

//--------------------------------- Transaction ---------------------------------\\
$route['admin/goods_receive']           = 'admin_controller/goods_receive';
$route['admin/add_goods_receive']       = 'admin_controller/add_goods_receive';
$route['admin/update_goods_receive']    = 'admin_controller/update_goods_receive';
$route['admin/save_good_receive']       = 'admin_controller/save_good_receive';
$route['admin/delete_transaction']      = 'admin_controller/delete_transaction';
$route['admin/goods_issue']             = 'admin_controller/goods_issue';
$route['admin/add_goods_issue']         = 'admin_controller/add_goods_issue';
$route['admin/update_goods_issue']      = 'admin_controller/update_goods_issue';
$route['admin/save_good_issue']         = 'admin_controller/save_goods_issue';
$route['admin/history_transaction']     = 'admin_controller/history_transaction';
$route['admin/search_filter']           = 'admin_controller/search_filter';

//--------------------------------- Transaction ---------------------------------\\

//--------------------------------- Manage User ---------------------------------\\
$route['admin/manage_user']             = 'admin_controller/manage_user';
$route['admin/update_manage_user']      = 'admin_controller/update_manage_user';
//--------------------------------- Manage User ---------------------------------\\

//--------------------------------- Change Password ---------------------------------\\
$route['admin/change_password']         = 'admin_controller/change_password';
$route['admin/save_change_password']    = 'admin_controller/save_change_password';
$route['users/change_password']         = 'users_controller/change_password';
$route['users/save_change_password']    = 'users_controller/save_change_password';
//--------------------------------- Change Password ---------------------------------\\

//--------------------------------- Guide Book ---------------------------------\\

//--------------------------------- Guide Book ---------------------------------\\

//--------------------------------- Logout ---------------------------------\\
$route['admin/logout']                  = 'admin_controller/logout';
//--------------------------------- Logout ---------------------------------\\
//--------------------------------- Admin ---------------------------------\\



//--------------------------------- Users ---------------------------------\\
$route['users/dashboard']               = 'users_controller/dashboard';
$route['users/material_list']           = 'users_controller/material_list';
$route['users/add_material_list']       = 'users_controller/add_material_list';
$route['users/save_material']           = 'users_controller/save_material';
$route['users/upload_material']         = 'users_controller/upload_excel_material';

$route['users/category']                = 'users_controller/category';
$route['users/add_category']            = 'users_controller/add_category';
$route['users/check_code_category']     = 'users_controller/check_code_category';
$route['users/save_category']           = 'users_controller/save_category';
$route['users/upload_category']         = 'users_controller/upload_excel_category';

$route['users/area']                    = 'users_controller/area';
$route['users/add_area']                = 'users_controller/add_area';
$route['users/check_code_area']         = 'users_controller/check_code_area';
$route['users/save_area']               = 'users_controller/save_area';

$route['users/line']                    = 'users_controller/line';
$route['users/check_code_line']         = 'users_controller/check_code_line';
$route['users/add_line']                = 'users_controller/add_line';
$route['users/save_line']               = 'users_controller/save_line';

$route['users/machine']                 = 'users_controller/machine';
$route['users/check_code_machine']      = 'users_controller/check_code_machine';
$route['users/add_machine']             = 'users_controller/add_machine';
$route['users/save_machine']            = 'users_controller/save_machine';
$route['users/upload_machine']          = 'users_controller/upload_excel_machine';

$route['users/uom']                     = 'users_controller/uom';
$route['users/check_code_uom']          = 'users_controller/check_code_uom';
$route['users/add_uom']                 = 'users_controller/add_uom';
$route['users/save_uom']                = 'users_controller/save_uom';

$route['users/location']                = 'users_controller/location';
$route['users/add_location']            = 'users_controller/add_location';
$route['users/check_code_location']     = 'users_controller/check_code_location';
$route['users/save_location']           = 'users_controller/save_location';
$route['users/upload_location']         = 'users_controller/upload_excel_location';

$route['users/goods_receive']           = 'users_controller/goods_receive';
$route['cek_scan_barcode']              = 'users_controller/cek_scan_barcode';
$route['users/add_goods_receive']       = 'users_controller/add_goods_receive';
$route['users/save_good_receive']       = 'users_controller/save_good_receive';
$route['users/goods_issue']             = 'users_controller/goods_issue';
$route['users/add_goods_issue']         = 'users_controller/add_goods_issue';
$route['users/save_good_issue']         = 'users_controller/save_goods_issue';
$route['users/history_transaction']     = 'users_controller/history_transaction';
$route['users/search_filter']           = 'users_controller/search_filter';

$route['users/detail_material_list']    = 'users_controller/detail_material_list';

$route['users/posttopdf']               = 'users_controller/post_to_pdf';
$route['users/print_label_pdf']         = 'users_controller/print_label_pdf';
$route['users/material_list_pdf']       = 'users_controller/material_list_pdf';
// $route['users/generate_pdf/(:any)']     = 'users_controller/generate_pdf/$1';

$route['users/logout']                  = 'users_controller/logout';
//--------------------------------- Users ---------------------------------\\



$route['404_override']                  = '';
$route['translate_uri_dashes']          = FALSE;
