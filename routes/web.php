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

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard/drivers', 'HomeController@getDrivers')->name('dashboard.drivers');
Route::get('/dashboard/users', 'HomeController@getUsers')->name('dashboard.users');
Route::get('/dashboard/approve-driver/{id}', 'HomeController@approveDriver')->name('dashboard.approve.driver');
Route::get('/dashboard/block-driver/{id}', 'HomeController@blockDriver')->name('dashboard.block.driver');
