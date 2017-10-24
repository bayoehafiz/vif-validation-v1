<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route[LOGIN_PAGE] = 'auth/login';
$route['recover'] = 'auth/recover';
$route['logout'] = 'auth/logout';

// Datatable Ajax
$route['chart-ajax/(:any)/(:any)'] = 'ajax/chart_ajax/$1/$2';
$route['table-ajax/(:any)/(:any)'] = 'ajax/table_ajax/$1/$2';

// Datatable lists
$route['all-forms'] = 'ajax/all_forms';
$route['unvalidated-forms'] = 'ajax/unvalidated_forms';
$route['verified-forms'] = 'ajax/verified_forms';
$route['rejected-forms'] = 'ajax/rejected_forms';
$route['unpaid-forms'] = 'ajax/unpaid_forms';
$route['paid-forms'] = 'ajax/paid_forms';
$route['unclosed-forms'] = 'ajax/unclosed_forms';
$route['closed-forms'] = 'ajax/closed_forms';

$route['active-forms'] = 'submission/active_form';
$route['event-form'] = 'submission/event_form';
$route['verify-form'] = 'submission/verify_form';
$route['pay-form'] = 'submission/pay_form';

$route['new-form'] = 'submission/submit_form';
$route['view-form/(:any)'] = 'submission/view_form/$1';
$route['update_form'] = 'submission/update_form';
$route['/edit_form/(:any)'] = 'index.php/submission/edit_form/$1';

$route['history'] = 'history';
$route['history/view-form/(:any)'] = 'submission/view_form/$1';
$route['/details/(:any)'] = 'history_details/$1';

$route['branch/new'] = 'branchadmin/new_branch';
$route['branch/edit/(:any)'] = 'branchadmin/edit_branch/$1';
$route['delete-branch/(:any)'] = 'branchadmin/delete_branch/$1';
$route['branch'] = 'branchadmin/branch_management';

// User management
$route['user'] = 'users';
$route['user/edit/password/(:any)'] = 'users/password_user/$1';
$route['user/new'] = 'users/new_user';
$route['get-position'] = 'users/get_position';
$route['user/edit/(:any)'] = 'users/edit_user/$1';
$route['user/edit/permissions/(:any)'] = 'users/edit_permissions/$1';
$route['delete-user/(:any)'] = 'users/delete_user/$1';
$route['position/new'] = 'users/new_position';
$route['position/edit/(:any)'] = 'users/edit_position/$1';
$route['delete-position/(:any)'] = 'users/delete_position/$1';
$route['position'] = 'users/position_management';

// User profile
$route['profile'] = 'profile';
$route['profile/update-password'] = 'profile/update_password';
$route['profile/update-photo'] = 'profile/update_photo';
$route['profile/submission'] = 'profile/submission';

// View form
$route['all-forms/view/(:any)'] = 'submission/view_form/$1';
$route['verified-forms/view/(:any)'] = 'submission/view_form/$1';
$route['rejected-forms/view/(:any)'] = 'submission/view_form/$1';
$route['unvalidated-forms/view/(:any)'] = 'submission/view_form/$1';
$route['unpaid-forms/view/(:any)'] = 'submission/view_form/$1';
$route['unclosed-forms/view/(:any)'] = 'submission/view_form/$1';
$route['paid-forms/view/(:any)'] = 'submission/view_form/$1';
$route['closed-forms/view/(:any)'] = 'submission/view_form/$1';

$route['user/import-data'] = 'users/import_data';
$route['branch/import-data'] = 'users/import_data';
$route['position/import-data'] = 'users/import_data';

$route['print-form/(:any)'] = 'view_report/print_form/$1';

$route['connection'] = 'connection';
$route['connection/list'] = 'connection/list_users';
$route['connection/sync'] = 'connection/sync_users';
$route['connection/delete/all'] = 'connection/del_all';
$route['connection/delete/(:any)'] = 'connection/del_user/$1';

$route['get-code'] = 'submission/get_code_ajax';

$route['api'] = 'api';
