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

Route::get('/clear', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('config:clear');
    $exitCode1 = \Illuminate\Support\Facades\Artisan::call('config:cache');
    $exitCode1 = \Illuminate\Support\Facades\Artisan::call('route:clear');
    $exitCode3 = \Illuminate\Support\Facades\Artisan::call('view:clear');
    return '<h1>CLEARED All </h1>';
});
// Route::get('/storage-link', function () {
//     $exitCode2 = \Illuminate\Support\Facades\Artisan::call('storage:link');
//     return $exitCode2;
// });


Auth::routes();

Route::get('/', 'PagesFrontController@index');
Route::get('/home', 'PagesFrontController@index');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin_logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin_register');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');


    // ACTIVITY LOG
    Route::get('/activity-log', 'CMS\ActivityLogController@index')->name('activitylog.index');

    // PROFILE
    Route::get('/profile', 'CMS\ProfileController@edit')->name('admin.profile');
    Route::post('/profile/update', 'CMS\ProfileController@update')->name('admin.profile.update');

    // SYSTEM SETTINGS
    Route::get('/system-settings', 'CMS\SystemSettingsController@edit')->name('admin.system-settings');
    Route::post('/system-settings/update', 'CMS\SystemSettingsController@update')->name('admin.system-settings.update');

    // PAGES
    Route::get('pages/search', 'CMS\PagesController@search')->name('pages.search');
    Route::resource('pages', 'CMS\PagesController');

	// USERS ACCOUNT
	Route::get('users/search', 'CMS\UsersAccountController@search')->name('users.search');
    Route::get('users', 'CMS\UsersAccountController@index')->name('users.index');
	Route::get('users/destroy', 'CMS\UsersAccountController@destroy')->name('users.destroy');
	Route::get('users/create', 'CMS\UsersAccountController@create')->name('users.create');
	Route::get('users/edit', 'CMS\UsersAccountController@edit')->name('users.edit');

    // MENU
    Route::get('menu/search', 'CMS\MenuController@search')->name('menu.search');
    Route::resource('menu', 'CMS\MenuController');

    // MENU LIST
    Route::get('menu-list/{menu}/search', 'CMS\MenuListController@search')->name('menu-list.search');
    Route::get('menu-list/{menu}', 'CMS\MenuListController@index')->name('menu-list.index');
    Route::get('menu-list/{menu}/create', 'CMS\MenuListController@create')->name('menu-list.create');
    Route::post('menu-list/{menu}/create', 'CMS\MenuListController@store')->name('menu-list.store');
    Route::get('menu-list/{menu}/{id}', 'CMS\MenuListController@show')->name('menu-list.show');
    Route::get('menu-list/{menu}/{id}/edit', 'CMS\MenuListController@edit')->name('menu-list.edit');
    Route::post('menu-list/{menu}/{id}/edit', 'CMS\MenuListController@update')->name('menu-list.update');
    Route::post('menu-list/{menu}/{id}', 'CMS\MenuListController@destroy')->name('menu-list.destroy');

    // EMAIL TEMPLATE
    Route::get('email-template/search', 'CMS\EmailTemplateController@search')->name('email-template.search');
    Route::resource('email-template', 'CMS\EmailTemplateController');

    // BANNER
    Route::get('banner/search', 'CMS\BannerController@search')->name('banner.search');
    Route::resource('banner', 'CMS\BannerController');

    // SLIDER
    Route::get('slider/search', 'CMS\SliderController@search')->name('slider.search');
    Route::resource('slider', 'CMS\SliderController');

    // USER ACCOUNT
    Route::get('user-account/search', 'CMS\UserAccountController@search')->name('user-account.search');
    Route::resource('user-account', 'CMS\UserAccountController');

    // ROLES AND PERMISSION
    Route::get('roles-and-permission/search', 'CMS\RolesPermissionController@search')->name('roles-and-permission.search');
    Route::get('/access-not-allowed', 'CMS\RolesPermissionController@access_not_allowed')->name('access-not-allowed');
    Route::resource('roles-and-permission', 'CMS\RolesPermissionController');
});


// **************************************** FRONTEND *******************************************************//

Route::get('{slug}', 'PagesFrontController@pages');
