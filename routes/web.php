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

Route::resource('/', 'FrontPagesController');
Route::get('/{value}', 'FrontPagesController@show');
//Route::post('/checkEmail', 'FrontPagesController@checkEmailValid');
//Route::get('/verify/{email}/{verify_token}', 'FrontPagesController@sendEmailDone')->name('sendEmailDone');
//Route::get('/verify?email={email}&verify_token={verify_token}', 'FrontPagesController@sendEmailDone')->name('sendEmailDone');

//login
//Route::get('/login', function() {
 //   return view('auth.login');
//});

// Authentication routes...
Auth::routes();

//Dashboard

/*Super Admin, Admin, Developer*/
Route::get('system/admin', 'AdminController@index');
Route::get('system/admin/firstGlance', 'AdminController@firstGlance');
Route::get('system/admin/curlresultAjax', 'AdminController@curlresultAjax');

/*Support*/
Route::get('system/support', 'EditorController@index');
Route::get('system/support/firstGlance', 'EditorController@firstGlance');
Route::get('system/support/curlresultAjax', 'EditorController@curlresultAjax');

// Profile
Route::resource('system/profile', 'ProfileController');

//Pages
Route::get('system/pages/pageslang', 'PagesController@pageslang');
Route::resource('system/pages', 'PagesController');

//Constentant
Route::resource('system/contest', 'ContestController');
//Route::get('system/contest/excel', 'ContestController@getExportExcel');

//winner
Route::get('system/winner/merchantfilter', 'WinController@merchantfilter');
Route::get('system/winner/searchname', 'WinController@searchname');
Route::resource('system/winner', 'WinController');

//Media
Route::resource('system/media', 'MediaController');

//*Banner

//*Category
Route::resource('system/banner/category', 'CategoryController'); 

//*Banner
Route::get('system/banner/pageslang', 'BannerController@pageslang');
Route::resource('system/banner', 'BannerController'); 

//Appearance

//*Theme Settings
Route::get('system/theme-settings/pageslang', 'CseoThemeOptionsController@pageslang');
// Route::get('system/theme-settings', 'CseoThemeOptionsController@index');
// Route::get('system/theme-settings/{id}/edit', 'CseoThemeOptionsController@edit');
// Route::post('system/theme-settings/{id}/update', 'CseoThemeOptionsController@update');
Route::resource('system/theme-settings', 'CseoThemeOptionsController');

//*Menu
Route::get('system/menu/pageslang', 'MenuController@pageslang'); 
Route::resource('system/menu', 'MenuController'); 
Route::post('system/menu/Nestable', 'MenuController@Nestable'); 

//*Reward
Route::get('system/reward/pageslang', 'RewardController@pageslang'); 
Route::resource('system/reward', 'RewardController'); 

//Accounts
Route::resource('system/account', 'AccountsController'); 

//Settings
//*Merchant
Route::resource('system/merchant', 'MerchantController');
Route::resource('system/bank', 'BankController');

//*General Setting 
Route::get('/system/settings-general', 'cseo_general_settings@index');
Route::post('/system/settings-general/store', 'cseo_general_settings@store');
Route::post('/system/settings-general/update/{id}', 'cseo_general_settings@update');


/*Access Denied*/
Route::get('403', 'ErrorPagesController@accessdenied');
Route::get('404', ['as'=>'notfound','uses' => 'ErrorPagesController@pagenotfound']);
Route::get('500', ['as'=>'interalserver','uses' => 'ErrorPagesController@internalserver']);