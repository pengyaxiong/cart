<?php


//二维码登录
Route::get('/code_login','IndexController@code_login');
//授权
Route::post('/auth', 'IndexController@auth');


//搜索
Route::get('/search', 'ProductController@search');

Route::group(['prefix' => 'product'], function () {
    //品牌
    Route::get('brand', 'ProductController@brand');
    
     Route::get('year', 'ProductController@year');
     
      Route::get('price', 'ProductController@price');
      
       Route::get('type', 'ProductController@type');

    //商品详情
    Route::get('{id}', 'ProductController@show');

    //商品列表
    Route::get('/', 'ProductController@index');
});

//系统设置
Route::get('config', 'IndexController@config');

//上传图片
Route::post('upload_img', 'IndexController@upload_img');

Route::post('upload_ocr', 'IndexController@upload_ocr');

//个人中心
Route::group(['prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@index');
    Route::post('/', 'CustomerController@update');

    Route::post('product', 'CustomerController@product');
    Route::get('products', 'CustomerController@products');
    
    Route::get('product_show', 'CustomerController@product_show');
    Route::post('product_update', 'CustomerController@product_update');
    
    Route::delete('product_destroy', 'CustomerController@product_destroy');
});











