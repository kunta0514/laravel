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

//prefix表示URL前缀

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::get('/', 'AdminHomeController@index');
    Route::resource('pages', 'PagesController');
});

Route::group(['prefix' => 'mywork', 'namespace' => 'Mywork'], function()
{
    Route::get('/', 'ProjectController@index');
    Route::resource('project', 'ProjectController');
});

Route::group(['prefix' => 'task', 'namespace' => 'Task'], function()
{
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'TaskController@index');
    Route::get('get_details/{id}','TaskController@get_details');
    Route::get('aa','TaskController@aa');
    Route::post('store', 'TaskController@store');
    Route::resource('details/{id}', 'TaskController@details');
    Route::resource('show/{id}','TaskController@show');

});




