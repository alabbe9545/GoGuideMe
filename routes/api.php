<?php

use Illuminate\Http\Request;
use App\Country;
use App\Zone;
use App\Attraction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function(){
	Route::get('countries', function(){return Country::all();});
	Route::get('zones/{country}', function($country){return Zone::where('country_id', $country)->get();});
	Route::get('attractions/{zone}', function($zone){return Attraction::where('zone_id', $zone)->get();});
	Route::post('getNearestsAttractions', 'UserController@getNearestsAttractions');
	Route::get('awards', 'UserController@awards');
	Route::get('logout', 'UserController@logout');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
