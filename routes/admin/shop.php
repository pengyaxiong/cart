<?php
Route::group(['prefix' => 'shop', 'namespace' => 'Shop', 'as' => 'shop.'], function () {
    Route::get('/', 'HomeController@mobile')->name('mobile');

    //商品品牌，除去show方法
    Route::group(['prefix' => 'brand'], function () {
        Route::patch('update_mysql', 'BrandController@update_mysql')->name('brand.update_mysql');
        Route::patch('post_test', 'BrandController@post_test')->name('brand.post_test');
        Route::patch('sort_order', 'BrandController@sort_order')->name('brand.sort_order');
        Route::patch('is_something', 'BrandController@is_something')->name('brand.is_something');
    });
    Route::resource('brand', 'BrandController', ['except' => ['show']]);
    //年限
    Route::group(['prefix' => 'year'], function () {
        Route::patch('sort_order', 'YearController@sort_order')->name('year.sort_order');
        Route::patch('is_something', 'YearController@is_something')->name('year.is_something');
    });
    Route::resource('year', 'YearController', ['except' => ['show']]);
    //价格
    Route::group(['prefix' => 'price'], function () {
        Route::patch('sort_order', 'PriceController@sort_order')->name('price.sort_order');
        Route::patch('is_something', 'PriceController@is_something')->name('price.is_something');
    });
    Route::resource('price', 'PriceController', ['except' => ['show']]);
    //类型
    Route::group(['prefix' => 'type'], function () {
        Route::patch('sort_order', 'TypeController@sort_order')->name('type.sort_order');
        Route::patch('is_something', 'TypeController@is_something')->name('type.is_something');
    });
    Route::resource('type', 'TypeController', ['except' => ['show']]);


    //栏目管理
    Route::group(['prefix' => 'category'], function () {
        Route::patch('sort_order', 'CategoryController@sort_order')->name('category.sort_order');
        Route::patch('is_something', 'CategoryController@is_something')->name('category.is_something');
    });
    Route::resource('category', 'CategoryController', ['except' => ['show']]);

    //商品管理
    Route::group(['prefix' => 'product'], function () {
        Route::patch('change_stock', 'ProductController@change_stock')->name('product.change_stock');
        Route::patch('sort_order', 'ProductController@sort_order')->name('product.sort_order');
        Route::delete('destroy_checked', 'ProductController@destroy_checked')->name('product.destroy_checked');
        Route::delete('destroy_gallery', 'ProductController@destroy_gallery')->name('product.destroy_gallery');
        Route::patch('is_something', 'ProductController@is_something')->name('product.is_something');

        //回收站
        Route::get('trash', 'ProductController@trash')->name('product.trash');
        Route::get('/{product}/restore', 'ProductController@restore')->name('product.restore');
        Route::delete('/{product}/force_destroy', 'ProductController@force_destroy')->name('product.force_destroy');
        Route::delete('force_destroy_checked', 'ProductController@force_destroy_checked')->name('product.force_destroy_checked');
        Route::post('restore_checked', 'ProductController@restore_checked')->name('product.restore_checked');
    });
    Route::resource('product', 'ProductController');

    //会员管理
    Route::group(['prefix' => 'customer'], function () {
        Route::patch('send_money', 'CustomerController@send_money')->name('customer.send_money');
    });
    Route::resource('customer', 'CustomerController');

});