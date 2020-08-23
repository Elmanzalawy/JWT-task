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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//public routes
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

//protected routes (requires auth)
Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', 'UserController@getAuthenticatedUser');

        //product routes (work in progress)
        // Route::get('products/{id}', 'ProductController@show');
        // Route::get('products','ProductController@products');
        // Route::post('store','ProductController@store');
        // Route::delete('delete/{id}','ProductController@destroy');
        Route::apiResource('product','ProductController');

        //logout
        Route::get('logout', 'UserController@logout');

});