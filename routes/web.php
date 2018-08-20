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

Route::get('/', 'MainController@mainPage')->name('main');
// todo: temp
// todo: add readme and browscap requirement
Route::post('minify', 'MainController@minify')->name('minify');
Route::get('{id}', 'MainController@redirect');
Route::get('/info/{id}','MainController@info');
