<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['namespace' => 'Admin'], function () 
{
    Route::get('home','DashboardController@index');
    Route::get('industries','DashboardController@index');
    Route::get('companies','DashboardController@index');
    Route::get('manufacturers','DashboardController@index');
    Route::get('product-categories','DashboardController@index');
    Route::get('products','DashboardController@index');
    Route::get('products-brands','DashboardController@index');
    Route::get('subscribers','DashboardController@index');
    Route::get('skus','DashboardController@index');  
});

Route::group(['namespace' => 'Client','middleware'=>'visitor'], function () 
{
    Route::get('/','ClientController@index'); 
});


Route::get('reset', function () 
{
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return '<h1>Have cleared the env</h1>';
});
