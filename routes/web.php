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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/wechat/token','WechatController@returnToken');

Route::any('/wechat', 'WechatController@serve');
Route::get('/wechat/menu','WechatController@menu');

Route::any('weixin/api', 'WeixinController@api');


