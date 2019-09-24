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
    return view('/');
	})->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::resource ('projects', 'ProjectsController');

Route::post('/projects/{projects}/task', 'TasksController@store');
Route::get ('projects/tasks/{task}', 'TasksController@edit');
Route::get ('projects/tasks/{task}/show', 'TasksController@show');
Route::patch ('projects/tasks/{task}', 'TasksController@update');
Route::delete ('projects/tasks/{task}/delete', 'TasksController@destroy');

Route::patch('user/{user}/edit', 'UsersController@update');
