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
    Route::get('/{type?}', 'ReportController@index');
    Route::get('/task_report/{type}', 'ReportController@task_report');
});

Route::group(['prefix' => 'project', 'namespace' => 'Project'], function()
{
    Route::resource('project', 'ProjectController@index');
    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'ProjectController@index');

});

Route::group(['prefix' => 'task', 'namespace' => 'Task'], function()
{

    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'TaskController@index');
    Route::get('/get_todoList', 'TaskController@get_todo_taskList');
    Route::get('/detail/{id}','TaskController@detail');
    Route::get('/edit/{id}', 'TaskController@edit');
    Route::get('/mobile','TaskController@mobile');
    Route::get('/wonder4','TaskController@wonder4');
    Route::get('/fast_handle/{id}', 'TaskController@fast_handle');
    Route::get('/view_pd/{task_no}', 'TaskController@view_pd');
    Route::get('/tag', 'TaskController@tag');
    Route::get('/sync_task',function(){
        $result=Artisan::call('command:sync_task', []);
        return $result;
    });
    Route::get('/query', 'TaskController@query');
    Route::get('/query_task', 'TaskController@query_task');
    Route::get('/test', 'TaskController@test');
    Route::get('/test_page', 'TaskController@test_page');
    Route::get('/history/{type}', 'TaskController@history');
    Route::get('/export/{type}','TaskController@export');
    Route::get('/get_history_list/{type}','TaskController@get_history_list');

    Route::post('/update/{id}', 'TaskController@update');
    Route::post('/detail_edit','TaskController@detail_edit');
    Route::post('/get_todoList', 'TaskController@get_todo_taskList');

    Route::resource('task', 'TaskController@index');
});

Route::group(['prefix' => 'demand', 'namespace' => 'Demand'], function()
{

    //get、post等按顺序，按分组些，不能穿插写
    Route::get('/', 'DemandController@index');
    Route::get('/get_todoList','DemandController@get_todoList');
    Route::get('/create', 'DemandController@create');
    Route::get('/edit/{id}', 'DemandController@edit');
    Route::get('/test', 'DemandController@test');
    Route::post('/destroy/{id}', 'DemandController@destroy');
    Route::post('/store', 'DemandController@store');
    Route::post('/update/{id}', 'DemandController@update');

//    Route::resource('demand', 'DemandController@index');
});


Route::group(['prefix' => 'solution', 'namespace' => 'Solution'], function()
{
    Route::get('/', 'SolutionController@index');
    Route::get('show/{id}', 'SolutionController@show');
    Route::get('create', 'SolutionController@create');
    Route::get('mobile/{func?}/{key?}', 'SolutionController@mobile_tools');
    Route::get('markdown/{id?}', 'SolutionController@markdown');
    Route::get('faq','SolutionController@workflow_faq');
    //清理缓存
    Route::get('deleteC',function(){
        Cache::flush();
    });

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

Route::group(['prefix' => 'panel', 'namespace' => 'Panel'], function()
{
    Route::resource('panel', 'PanelController@index');

    //访问页面
    //get、post等按顺序，按分组写，不能穿插写
    Route::get('/', 'PanelController@index');
    Route::get('/personal','PanelController@get_personal_page');
    Route::get('/my_task','PanelController@get_my_task_page');
    //获取值
    Route::get('/get_detail/{id}','PanelController@get_detail');
    Route::post('/edit', 'PanelController@edit');
    Route::get('/fast_handle/{id}', 'PanelController@fast_handle');
    Route::get('/done/{id}','PanelController@done');
});

Route::group(['prefix' => 'excel', 'namespace' => 'Excel'], function()
{
//    echo "OK";
    Route::resource('excel', 'ExcelController@index');
//
    Route::get('/','ExcelController@index');
    Route::get('/task/{type}','ExcelController@task');
//    Route::get('excel/import','ExcelController@import');
});

Route::group(['prefix' => 'customer', 'namespace' => 'Customer'], function()
{
    Route::get('/','CustomerController@index');
    Route::get('/create', 'CustomerController@create');
    Route::get('/edit/{id}', 'CustomerController@edit');
    Route::get('/test', 'CustomerController@test');
    Route::post('/destroy/{id}', 'CustomerController@destroy');
    Route::post('/store', 'CustomerController@store');
    Route::post('/update/{id}', 'CustomerController@update');

});

