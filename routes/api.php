<?php

use Illuminate\Http\Request;

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

/* Tag List API */
Route::get('tag/{tenant_id}/get-tag-list', 'MasterData\TagController@getTagList');
Route::get('tag/{tenant_id}/generate-select-tag', 'MasterData\TagController@generateSelectTag');

/* Master Product */
Route::get('product/{tenantId}/get-all-product', 'MasterData\ProductController@getProductList');
Route::get('product/{tenant_id}/filter-product-list/{tags}', 'MasterData\ProductController@filterProductList');
Route::get('product/{tenant_id}/filter-by-name/{searchString}', 'MasterData\ProductController@filterByName');
Route::get('product/{product_id}/get-product', 'MasterData\ProductController@getProduct');
Route::post('product/add-product', 'MasterData\ProductController@addProduct');
Route::post('product/{product_id}/change-picture', 'MasterData\ProductController@changePicture');
Route::post('product/update-product', 'MasterData\ProductController@updateProduct');
Route::post('product/delete-product', 'MasterData\ProductController@deleteProduct');

/* Master Service */
Route::get('service/{tenantId}/get-all-service', 'MasterData\ServiceController@getServiceList');
Route::post('service/add-service', 'MasterData\ServiceController@addService');