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
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/test', 'LeankitController@test')->name('test');

Route::group(
    [
        'middleware'    => ['leankit'],
        'prefix'        => 'leankit'
    ],function (){

    Route::post('login','LeankitController@login');
    Route::get('boards','LeankitController@boards');
    Route::post('board','LeankitController@board');
    Route::get('juls','LeankitController@juls');
});












