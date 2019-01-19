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
    return view('welcome');
});

Route::get('master', 'DataController@master');

Route::get('details', 'DataController@index');

Route::get('details/fetch','DataController@fetch')->name('details.fetch');

Route:: get('create', 'DataController@create');

Route:: post('details/postdata', 'DataController@postdata')->name('details.postdata');

Route::get('details/fetchAll','DataController@fetchAll')->name('details.fetchAll');

Route::get('details/deletedata','DataController@destroy')->name('details.deletedata');



