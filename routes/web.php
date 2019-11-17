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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function(){return redirect()->route('users');});

Route::get('/users', 'UserController@index')->name('users')->middleware(['auth', 'canAct:admin']);
Route::post('/users', 'UserController@edit')->name('users.edit')->middleware(['auth', 'canAct:admin']);
Route::delete('/users/{id}', 'UserController@delete')->name('users.delete')->middleware(['auth', 'canAct:admin']);

Route::get('/roles', 'RolesController@index')->name('roles')->middleware(['auth', 'canAct:admin']);
Route::post('/roles', 'RolesController@store')->name('roles.store')->middleware(['auth', 'canAct:admin']);
Route::delete('/roles/{id}', 'RolesController@delete')->name('roles.delete')->middleware(['auth', 'canAct:admin']);

Route::get('/zones', 'ZonesController@index')->name('zones')->middleware(['auth', 'canAct:admin']);
Route::post('/zones', 'ZonesController@store')->name('zones.store')->middleware(['auth', 'canAct:admin']);
Route::delete('/zones/{id}', 'ZonesController@delete')->name('zones.delete')->middleware(['auth', 'canAct:admin']);

Route::get('/countries', 'CountriesController@index')->name('countries')->middleware(['auth', 'canAct:admin']);
Route::post('/countries', 'CountriesController@store')->name('countries.store')->middleware(['auth', 'canAct:admin']);
Route::delete('/countries/{id}', 'CountriesController@delete')->name('countries.delete')->middleware(['auth', 'canAct:admin']);

Route::get('/attractions', 'AttractionsController@index')->name('attractions')->middleware(['auth', 'canAct:admin']);
Route::post('/attractions', 'AttractionsController@store')->name('attractions.store')->middleware(['auth', 'canAct:admin']);
Route::delete('/attractions/{id}', 'AttractionsController@delete')->name('attractions.delete')->middleware(['auth', 'canAct:admin']);

Route::get('/awards', 'AwardsController@index')->name('awards')->middleware(['auth', 'canAct:admin']);
Route::post('/awards', 'AwardsController@store')->name('awards.store')->middleware(['auth', 'canAct:admin']);
Route::delete('/awards/{id}', 'AwardsController@delete')->name('awards.delete')->middleware(['auth', 'canAct:admin']);