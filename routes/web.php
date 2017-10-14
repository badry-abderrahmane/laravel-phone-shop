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
    return view('welcome');
});

Route::get('dash', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('products', 'ProductController');
Route::resource('series', 'SerieController');
Route::resource('galleries', 'GalleryController');
Route::resource('colors', 'ColorController');
Route::resource('productcolors', 'ProductcolorController');
Route::resource('productoptions', 'ProductoptionController');
Route::resource('categories', 'CategoryController');
Route::resource('accessories', 'AccessoryController');
Route::resource('optiongroups', 'OptiongroupController');
Route::resource('options', 'OptionController');
