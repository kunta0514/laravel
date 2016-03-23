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

Route::group(['prefix' => 'report', 'namespace' => 'Report'], function()
{
    Route::resource('report', 'ReportController@index');
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'ReportController@index');

});

Route::group(['prefix' => 'project', 'namespace' => 'Project'], function()
{
    Route::resource('project', 'ProjectController@index');
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'ProjectController@index');

});

Route::group(['prefix' => 'task', 'namespace' => 'Task'], function()
{
    Route::resource('task', 'TaskController@index');
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'TaskController@index');
    Route::get('/get_details/{id}','TaskController@get_details');
    Route::get('/wonder4/{id}','TaskController@wonder4');
    Route::get('/edit/{id}', 'TaskController@edit');
    Route::get('/fast_handle/{id}', 'TaskController@fast_handle');
    Route::get('/view_pd/{task_no}', 'TaskController@view_pd');
    Route::get('/sync_task',function(){
        $result=Artisan::call('command:sync_task', []);
        return $result;
    });

    Route::post('edit', 'TaskController@edit');

});

Route::group(['prefix' => 'solution', 'namespace' => 'Solution'], function()
{
    Route::get('/', 'SolutionController@index');
    Route::get('show/{id}', 'SolutionController@show');
    Route::get('create', 'SolutionController@create');
    Route::get('mobile/{func?}/{key?}', 'SolutionController@mobile_tools');
    Route::get('markdown/{id?}', 'SolutionController@markdown');
    Route::post('mobile', 'SolutionController@mobile_tools');
    Route::post('upload', 'SolutionController@upload');
    Route::post('markdown_save', 'SolutionController@markdown_save');
    Route::resource('solution', 'SolutionController');
});

Route::group(['prefix' => 'wx', 'namespace' => 'Wx'], function()
{
    Route::resource('wx', 'WxController@index');
    Route::resource('qy', 'QyController@index');
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'WxController@index');


});


Route::group(['prefix' => 'task_panel', 'namespace' => 'TaskPanel'], function()
{
    Route::resource('task_panel', 'TaskPanelController@index');
    //get、post等按顺序，按分组写，不能穿插写
    Route::get('/', 'TaskPanelController@index');
    Route::get('/personal','TaskPanelController@get_personal_page');

    //获取值
    Route::get('/get_all_info','TaskPanelController@get_all_info');
    Route::get('/get_personal_info/{id}','TaskPanelController@get_personal_info');
});




