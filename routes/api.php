<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['domain' => env('ADMIN_DOMAIN'), 'namespace' => 'Api'], function () {

        //会员性别统计
        Route::get('sex_count', 'VisualizationController@sex_count');
        //会员统计
        Route::get('statistics_customer', 'VisualizationController@statistics_customer');
        //省份统计
        Route::get('customer_province', 'VisualizationController@customer_province');
        //商品浏览量统计
        Route::get('statistics_product', 'VisualizationController@statistics_product');
        //本月热销商品Top
        Route::get('top', 'VisualizationController@top');
        //本周销售额
        Route::get('sales_amount', 'VisualizationController@sales_amount');
        //本周订单数
        Route::get('sales_count', 'VisualizationController@sales_count');

        //用户管理
        require 'api/user.php';
        //消息管理
        require 'api/information.php';
        //系统管理
        require 'api/system.php';

    //微信接口
    Route::group(['domain' => env('WECHAT_DOMAIN')], function () {
        Route::any('/easywechat/{account}', 'WechatController@serve');
        Route::any('/oauth_callback/{account}', 'WechatController@oauth_callback');
    });


});

Route::group(['namespace' => 'Wechat', 'prefix' => 'wechat', 'as' => 'wechat.'], function () {
    //付款回调
    Route::any('paid', 'OrderController@paid');
});