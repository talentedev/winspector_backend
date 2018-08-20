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

Route::group(['middleware' => 'api'], function ($router) {

    $router->post('login', 'Api\ApiAuthController@login');
    $router->post('logout', 'Api\ApiAuthController@logout');
    $router->post('refresh', 'Api\ApiAuthController@refresh');
    $router->get('me', 'Api\ApiAuthController@me');
    $router->post('register', 'Api\ApiAuthController@register');
    $router->post('verify-email', 'Api\ApiAuthController@verifyEmail');

});

Route::namespace('Api')->middleware(['jwt.auth', 'isVerified'])->group(function($router) {

    $router->resource('tasks', 'TaskController');
    $router->get('accept-task/{task_id}', 'TaskController@acceptTask');

});