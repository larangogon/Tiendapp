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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::resource('users', 'App\Http\Controllers\UsersController');

Route::get('users/{user}/active', [App\Http\Controllers\UsersController::class, 'active'])
    ->name('users.active');

Route::resource('products', 'App\Http\Controllers\ProductController');
Route::get('products/{product}/active', [App\Http\Controllers\ProductController::class, 'active'])
    ->name('products.active');
Route::get('products/destroyimagen/{imagen_id}/{product_id}', [App\Http\Controllers\ProductController::class, 'destroyimagen'])
    ->name('products/destroyimagen');

Route::resource('trademarks', 'App\Http\Controllers\TrademarkController')
    ->only(['index', 'store', 'destroy', 'update', 'edit', 'create']);

Route::resource('sizes', 'App\Http\Controllers\SizeController')
    ->only(['index', 'store']);



