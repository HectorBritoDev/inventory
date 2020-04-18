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

Route::apiResource('categories', 'Category\CategoryController');
Route::apiResource('products', 'Product\ProductController');
Route::apiResource('sales', 'Sale\SaleController')->only('index', 'show', 'store');
Route::apiResource('sales.items', 'Sale\SaleItemController')->only('index');
Route::apiResource('purchases', 'Purchase\PurchaseController')->only('index', 'show', 'store');
Route::apiResource('purchases.items', 'Purchase\PurchaseItemController')->only('index');

Route::post('login', 'Auth\Passport\PassportAuthController@login');
Route::post('logout', 'Auth\Passport\PassportAuthController@logout')->middleware('auth:api');
Route::post('refresh-token', 'Auth\Passport\PassportAuthController@refresh')->middleware('auth:api');
// Auth::routes(['register' => false]);
