<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Login and register routes
Route::post('/login', [
    'uses' => 'App\Http\Controllers\Auth\LoginController@login',
    'as' => 'login'
]);

// Public api routes
Route::group([], function () {
    // Brand group routes
    Route::group(['prefix' => 'brands'], function () {
        Route::get('/', 'App\Http\Controllers\BrandController@getAllBrandsWithImages');
    });

    // Category group routes
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'App\Http\Controllers\CategoryController@getAllCategories');
        Route::get('/{id}', 'App\Http\Controllers\CategoryController@getCategory');
    });

    // Product group routes
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'App\Http\Controllers\ProductController@getAllProducts');
        Route::get('/{id}', 'App\Http\Controllers\ProductController@getProduct');
    });
});

//Register user
Route::post('/register', [
    'uses' => 'App\Http\Controllers\Auth\RegisterController@register',
    'as' => 'register'
]);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Brand group routes
    Route::group(['prefix' => 'brands'], function () {
        Route::post('/', 'App\Http\Controllers\BrandController@store');
        Route::post('/{id}', 'App\Http\Controllers\BrandController@update');
        Route::delete('/{id}/image', 'App\Http\Controllers\BrandController@deleteImage');
        Route::delete('/{id}', 'App\Http\Controllers\BrandController@delete');
        Route::get('/all', 'App\Http\Controllers\BrandController@getAllBrands');
    });

    // Category group routes
    Route::group(['prefix' => 'categories'], function () {
        Route::post('/', 'App\Http\Controllers\CategoryController@store');
        Route::put('/{id}', 'App\Http\Controllers\CategoryController@update');
        Route::delete('/{id}', 'App\Http\Controllers\CategoryController@delete');
    });

    // Product group routes
    Route::group(['prefix' => 'products'], function () {
        Route::post('/', 'App\Http\Controllers\ProductController@store');
        Route::post('/with-photos', 'App\Http\Controllers\ProductController@storeWithPhotos');
        Route::post('/{id}', 'App\Http\Controllers\ProductController@update');
        Route::delete('/{id}', 'App\Http\Controllers\ProductController@delete');
        // delete photo
        Route::delete('/{id}/photos/{photoId}', 'App\Http\Controllers\ProductController@deletePhoto');
    });

    // User group routes
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'App\Http\Controllers\UserController@getAllUsers');
        Route::get('/roles', 'App\Http\Controllers\UserController@getAllRoles');
        Route::get('/{id}', 'App\Http\Controllers\UserController@getUser');
        Route::put('/{id}', 'App\Http\Controllers\UserController@update');
        Route::delete('/{id}', 'App\Http\Controllers\UserController@delete');
    });

});

