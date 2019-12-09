<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user')->uses('\App\Http\Controllers\Api\User\UserController@me');

Route::group([
    'prefix' => 'admin',
    'namespace' => '\App\Http\Controllers\Api',
    'middleware' => ['auth:api', 'role:admin'],
], function () {

    Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {
        Route::get('/', ['uses' => 'UserController@all']);
        Route::get('/paginate', ['uses' => 'UserController@paginate']);
        Route::post('/', ['uses' => 'UserController@store']);
        Route::get('/{id}', ['uses' => 'UserController@get']);
        Route::get('/{id}/edit', ['uses' => 'UserController@get']);
        Route::put('/{id}', ['uses' => 'UserController@update']);
        Route::delete('/{id}', ['uses' => 'UserController@delete']);
    });

    Route::group(['prefix' => 'departments', 'namespace' => 'Department'], function () {
        Route::get('/', ['uses' => 'DepartmentController@list']);
        Route::post('/', ['uses' => 'DepartmentController@store']);
        Route::get('/{id}', ['uses' => 'DepartmentController@get']);
        Route::get('/{id}/edit', ['uses' => 'DepartmentController@get']);
        Route::put('/{id}', ['uses' => 'DepartmentController@update']);
        Route::delete('/{id}', ['uses' => 'DepartmentController@delete']);
    });

    Route::group(['prefix' => 'upload', 'namespace' => 'Upload'], function () {
        Route::post('/images', ['uses' => 'UploadController@uploadImage']);
    });
});
