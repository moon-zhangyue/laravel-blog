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

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        //读取配置-app.php下面的timezone
        echo Config::get('app.timezone');
        return view('welcome');
    });


    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
    Route::get('admin/crypt', 'Admin\LoginController@crypt');
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {

    Route::get('index','IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeorder', 'CategoryController@changeOrder');
    Route::resource('category', 'CategoryController');

    Route::resource('article', 'ArticleController');
    Route::resource('links', 'LinksController');
    Route::post('links/changeorder', 'LinksController@changeOrder');




    Route::resource('navs', 'NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder');

    Route::get('config/putfile', 'ConfigController@putFile');
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    Route::resource('config', 'ConfigController');

    Route::any('upload', 'CommonController@upload');
});
