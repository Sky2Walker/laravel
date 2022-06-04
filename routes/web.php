<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
        'prefix'=>'blog']
    ,function(){
        Route::get('/{blog_id}', 'App\Http\Controllers\BlogDetailController@getBlog');
        Route::get('','App\Http\Controllers\BlogController@blog');
    }
);
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/{cat}/{prod_id}', 'App\Http\Controllers\ProductController@getProduct');
Route::get('/store', 'App\Http\Controllers\StoreController@store');
Route::get('/about','App\Http\Controllers\AboutUsController@about');
Route::get('/contact','App\Http\Controllers\ContactUsController@contact');
Route::get('/cart','App\Http\Controllers\CartController@cart');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');









