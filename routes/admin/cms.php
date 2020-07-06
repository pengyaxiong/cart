<?php
Route::group(['prefix' => 'cms', 'namespace' => 'Cms', 'as' => 'cms.'], function () {

//    //栏目设置
//    Route::resource('category', 'CategoryController');
//    // 文章设置
//    Route::group(['prefix' => 'article'], function () {
//        Route::delete('destroy_checked', 'ArticleController@destroy_checked')->name('article.destroy_checked');
//        Route::patch('is_something', 'ArticleController@is_something')->name('article.is_something');
//
//        //回收站
//        Route::get('trash', 'ArticleController@trash')->name('article.trash');
//        Route::get('{article}/restore', 'ArticleController@restore')->name('article.restore');
//        Route::delete('{article}/force_destroy', 'ArticleController@force_destroy')->name('article.force_destroy');
//        Route::delete('force_destroy_checked', 'ArticleController@force_destroy_checked')->name('article.force_destroy_checked');
//        Route::post('restore_checked', 'ArticleController@restore_checked')->name('article.restore_checked');
//    });
//    Route::resource('article', 'ArticleController');

    //日进一
    Route::resource('daily', 'DailyController', ['except' => ['show']]);

    //头脑风暴
    Route::resource('storm', 'StormController', ['except' => ['show']]);

    //资源
    Route::group(['prefix' => 'resource'], function () {
        Route::patch('sort_order', 'ResourceController@sort_order')->name('resource.sort_order');
        Route::patch('is_something', 'ResourceController@is_something')->name('resource.is_something');
    });
    Route::resource('resource', 'ResourceController', ['except' => ['show']]);
});