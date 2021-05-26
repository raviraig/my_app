<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Route::group(['middleware' => ['auth', 'twofactor', 'acl']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/list_user', 'UserController@index')->name('list_user');
	Route::get('/add_user', 'UserController@create')->name('add_user');
	Route::post('/save_user', 'UserController@store')->name('save_user');
	Route::get('/edit_user/{id}', 'UserController@edit')->name('edit_user');
	Route::post('/update_user', 'UserController@update' )->name('update_user');
	Route::get('/delete_user/{id}', 'UserController@destroy')->name('delete_user');
	Route::get('/export_user', 'UserController@exportCsv')->name('export_user');

	Route::get('/list_category', 'CategoryController@index')->name('list_category');
	Route::get('/add_category', 'CategoryController@create')->name('add_category');
	Route::post('/save_category', 'CategoryController@store')->name('save_category');
	Route::get('/edit_category/{id}', 'CategoryController@edit')->name('edit_category');
	Route::post('/update_category', 'CategoryController@update' )->name('update_category');
	Route::get('/delete_category/{id}', 'CategoryController@destroy')->name('delete_category');

	Route::get('/list_product', 'ProductController@index')->name('list_product');
	Route::get('/add_product', 'ProductController@create')->name('add_product');
	Route::post('/save_product', 'ProductController@store')->name('save_product');
	Route::get('/edit_product/{id}', 'ProductController@edit')->name('edit_product');
	Route::post('/update_product', 'ProductController@update' )->name('update_product');
	Route::get('/delete_product/{id}', 'ProductController@destroy')->name('delete_product');
});



