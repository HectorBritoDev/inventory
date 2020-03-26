<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categories', 'Category\CategoryController')->except('create', 'edit');
Route::resource('products', 'Product\ProductController')->except('create', 'edit');
Route::resource('sales', 'Sale\SaleController')->except('create', 'edit');
Route::resource('purchases', 'Purchase\PurchaseController')->except('create', 'edit');
