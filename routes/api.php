<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('pesanan', 'Api\PesananController@index');
    Route::get('pesanan/{id}', 'Api\PesananController@show');
    Route::post('pesanan', 'Api\PesananController@store');
    Route::put('pesanan/{id}', 'Api\PesananController@update_status');
    Route::delete('pesanan/{id}', 'Api\PesananController@destroy');

    Route::get('user', 'Api\AuthController@index');
    Route::get('user/{id}', 'Api\AuthController@show');
    Route::put('user/{id}', 'Api\AuthController@update');
    Route::delete('user/{id}', 'Api\AuthController@destroy');

    Route::get('paketmakan', 'Api\PaketMakanController@index');
    Route::get('paketmakan/{id}', 'Api\PaketMakanController@show');
    Route::post('paketmakan', 'Api\PaketMakanController@store');
    Route::put('paketmakan/{id}', 'Api\PaketMakanController@update');
    Route::delete('paketmakan/{id}', 'Api\PaketMakanController@destroy');

    Route::get('promo', 'Api\PromoController@index');
    Route::get('promo/{id}', 'Api\PromoController@show');
    Route::post('promo', 'Api\PromoController@store');
    Route::put('promo/{id}', 'Api\PromoController@update');
    Route::delete('promo/{id}', 'Api\PromoController@destroy');

    Route::put('date/{id}','Api\AuthController@update_date');

    Route::get('logout','Api\AuthController@logout');

});
