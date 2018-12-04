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
    return view('products');
});
Route::resource('products','ProductController');
Route::resource('templates','TemplateController');
Route::get('/product/update-info',["uses" => "ProductController@update_multiple_product","as" => "update-info"]);
Route::post('/product/update-info',["uses" => "ProductController@post_update_multiple_product","as" => "update-info"]);
