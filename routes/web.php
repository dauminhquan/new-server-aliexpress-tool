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

Route::group(['middleware' => 'check.login'],function(){
    Route::get('/',["uses" => "HomeController@index",'as' => 'home']);
    Route::resource('products','ProductController');
    Route::resource('templates','TemplateController');
    Route::resource('keywords','KeywordController');
    Route::resource('servers','ServerController');
    Route::resource('upcs','UpcController');
    Route::resource('users','UserController');
    Route::get('keywords/done/{id}','KeywordController@done');
    Route::get('keywords/{id}/page/{page}','KeywordController@page');
//Route::resource('template-products','TemplateProductController');
    Route::get('template-products/{id}',["uses" => "TemplateProductController@index","as" => "template-products.index"]);
    Route::post('template-products/{id}',["uses" => "TemplateProductController@actions","as" => "template-products.actions"]);
    Route::get('template-products/{id}/add',["uses" => "TemplateProductController@add_product","as" => "template-products.add_product"]);
    Route::post('template-products/{id}/add',["uses" => "TemplateProductController@post_add_product","as" => "template-products.post_add_product"]);
    Route::get('/product/update-info',["uses" => "ProductController@update_multiple_product","as" => "update-info"]);
    Route::post('/product/update-info',["uses" => "ProductController@post_update_multiple_product","as" => "update-info"]);
});

Route::get('/login',['uses' => 'AuthController@login','as' => 'login']);
Route::post('/login',['uses' => 'AuthController@post_login','as' => 'login']);
