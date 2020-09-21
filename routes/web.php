<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$segment = request()->segment(1);
$controllar = ucfirst($segment);
// Dynamic Routes
Route::resource('/'.$segment,$controllar.'Controller');
// END Dynamic Routes

//For Login Controller
Route::GET('/','LoginController@index');
Route::POST('/admin-login-check','LoginController@adminLoginCheck' );
Route::GET('/logout','DashboardController@logout' );
//End Login Controller

// AJAX LIST API
Route::POST('/all-data-list','ListController@all_data');
Route::POST('/all-data-user_type','User_typeController@all_data');
Route::POST('/all-data-user_roles','User_rolesController@all_data');
Route::POST('/all-data-division','DivisionController@all_data');
Route::POST('/all-data-district','DistrictController@all_data');
Route::POST('/all-data-upazila','UpazilaController@all_data');
Route::POST('/all-data-zone','ZoneController@all_data');
Route::POST('/all-data-area','AreaController@all_data');
Route::POST('/all-data-branch','BranchController@all_data');
Route::POST('/all-data-samity_working_day','Samity_working_dayController@all_data');
Route::POST('/all-data-samity','SamityController@all_data');
Route::POST('/all-data-samity_fo','Samity_foController@all_data');
Route::POST('/all-data-samity_day','Samity_dayController@all_data');
Route::POST('/all-data-users','UsersController@all_data');
Route::POST('/all-data-nav_menu','Nav_menuController@all_data');
Route::POST('/all-data-menu','MenuController@all_data');
Route::POST('/all-data-sub_menu','sub_menuController@all_data');
Route::POST('/all-data-loan_config','loan_configController@all_data');
Route::POST('/all-data-samity_config','samity_configController@all_data');
//
Route::POST('/all-data-voucher_config','voucher_configController@all_data');
//
Route::POST('/all-data-member_closing','Member_closingController@all_data');
Route::POST('/all-data-pass_book_sale','Pass_book_saleController@all_data');
Route::POST('/all-data-member_samity_transfer','Member_samity_transferController@all_data');
Route::POST('/all-data-members','MembersController@all_data');


