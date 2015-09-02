<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('engineer', 'EngineerController@index');
Route::get('engineer/{engineer_id}/assignments', 'EngineerController@areasLeft');
Route::get('engineer/{engineer_id}/schedule', 'EngineerController@schedule');
Route::get('engineer/{engineer_id}', 'EngineerController@show');
Route::get('engineer/byiuser/{iuser}', 'EngineerController@getIdByIuser');

Route::get('customer/mm/', 'ScheduleController@getMM');
Route::get('customer/srm/', 'ScheduleController@getSRM');

Route::post('engineer', 'EngineerController@store');
Route::post('engineer/{engineer_id}', 'EngineerController@update');

Route::post('engineer/area/{engineer_id}', 'EngineerController@storeArea');
Route::post('engineer/schedule/{engineer_id}', 'EngineerController@storeSchedule');

Route::get('area', 'AreaController@index');

Route::post('area', 'AreaController@store');

Route::post('chat', 'ChatController@store');

Route::get('mail', 'ChatController@email');
