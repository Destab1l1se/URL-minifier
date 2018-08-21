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

Route::view('/', 'main_page')->name('main');
// todo: add readme and browscap requirement
Route::post('minify', 'MainController@minify')->name('minify');
Route::get('{path}', 'MainController@redirect');
Route::get('/info/{path}','MainController@info');
Route::get('/info/json/{path}','MainController@infoJson');
