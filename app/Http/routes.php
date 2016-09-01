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

Route::group(['middleware' => ['web'] , 'namespace' => 'Wechat'], function () {
    Route::any('wechat/token' , 'WechatController@token');
    Route::any('wechat/menu/set' , 'WechatController@setMenu');
    Route::any('wechat/login' , 'WechatController@login');
    Route::any('wechat/call-back/login' , 'WechatController@callbackLogin');
});
