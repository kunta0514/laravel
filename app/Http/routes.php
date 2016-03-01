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

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//prefix表示URL前缀
Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware' => 'auth'], function()
{
    Route::get('/', 'AdminHomeController@index');
    Route::resource('pages', 'PagesController');
});

Route::group(['prefix' => 'home', 'namespace' => 'Admin','middleware' => 'auth'], function()
{
    Route::get('/', 'AdminHomeController@index');
    Route::get('get_user', 'UserController@get_all');
    Route::resource('pages', 'PagesController');
});

Route::group(['prefix' => 'mywork', 'namespace' => 'Mywork'], function()
{
    Route::get('/', 'ProjectController@index');
    Route::resource('project', 'ProjectController');
});

Route::group(['prefix' => 'task', 'namespace' => 'Task'], function()
{
    Route::resource('task', 'TaskController@index');
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'TaskController@index');
    Route::get('/{status}', 'TaskController@index');
    Route::get('/get_details/{id}','TaskController@get_details');
    Route::get('/wonder4/{id}','TaskController@wonder4');
    Route::get('/edit/{id}', 'TaskController@edit');
    Route::get('/fast_handle/{id}', 'TaskController@fast_handle');

    Route::post('edit', 'TaskController@edit');



});




