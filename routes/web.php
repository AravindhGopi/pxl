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
    return view('auth\login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('users_view');
Route::post('/users', 'UserController@store')->name('users_add');
Route::put('/users/{id}', 'UserController@update')->name('users_update');
Route::get('/users/{id}', 'UserController@edit')->name('users_edit');

Route::get('/projects', 'ProjectController@index')->name('projects_view');
Route::post('/projects', 'ProjectController@store')->name('projects_add');
Route::put('/projects/{id}', 'ProjectController@update')->name('projects_update');
Route::delete('/projects/{id}', 'ProjectController@delete')->name('projects_delete');
Route::get('/projects/{id}', 'ProjectController@edit')->name('projects_edit');

Route::resource('holiday_calendar', 'HolidayCalendarController');
Route::resource('daily_reports','DailyReportController');