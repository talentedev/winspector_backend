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

Route::group(['middleware' => 'web'], function () {

    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');

    Route::namespace('Admin')->group( function () {

        // Dashboard
        Route::get('dashboard', 'DashboardController@index');

        // Users
        Route::resource('users', 'UserController');
        Route::get('owners', 'UserController@getOwners');
        Route::get('inspectors', 'UserController@getInspectors');

        // Tasks
        Route::resource('tasks', 'TaskController');
        Route::get('pending-jobs', 'TaskController@getPendingTasks');
        Route::get('finished-jobs', 'TaskController@getFinishedTasks');

        // Settings
        Route::get('settings', 'UserController@showSettings')->name('settings');
        Route::post('change-setting', 'UserController@changeSettings');

    });

});