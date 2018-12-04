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
//Route::resource('template-products','TemplateProductController');
Route::get('template-products/{id}',["uses" => "TemplateProductController@index","as" => "template-products.index"]);
Route::post('template-products/{id}',["uses" => "TemplateProductController@actions","as" => "template-products.actions"]);
Route::get('template-products/{id}/add',["uses" => "TemplateProductController@add_product","as" => "template-products.add_product"]);
Route::post('template-products/{id}/add',["uses" => "TemplateProductController@post_add_product","as" => "template-products.post_add_product"]);
Route::get('/product/update-info',["uses" => "ProductController@update_multiple_product","as" => "update-info"]);
Route::post('/product/update-info',["uses" => "ProductController@post_update_multiple_product","as" => "update-info"]);
