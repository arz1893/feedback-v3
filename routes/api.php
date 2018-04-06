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
Route::get('service/{tenant_id}/get-all-service', 'MasterData\ServiceController@getServiceList');
Route::get('service/{tenant_id}/filter-service-list/{tags}', 'MasterData\ServiceController@filterServiceList');
Route::get('service/{tenant_id}/filter-by-name/{searchString}', 'MasterData\ServiceController@filterByName');
Route::get('service/{service_id}/get-service', 'MasterData\ServiceController@getService');
Route::post('service/add-service', 'MasterData\ServiceController@addService');
Route::post('service/{service_id}/change-picture', 'MasterData\ServiceController@changePicture');
Route::post('service/update-service', 'MasterData\ServiceController@updateService');
Route::post('service/delete-service', 'MasterData\ServiceController@deleteService');

/* Master Tag */
Route::get('tag/{tenant_id}/get-tag-list', 'MasterData\TagController@getTagList');
Route::get('tag/{tenant_id}/generate-select-tag', 'MasterData\TagController@generateSelectTag');

/* Product Category */
Route::get('product_category/{product_id}/get-root-nodes', 'MasterData\ProductCategoryController@getRootNodes');
Route::get('product_category/{node_id}/get-parent-nodes', 'MasterData\ProductCategoryController@getParentNodes');
Route::get('product_category/{parent_id}/get-child-nodes', 'MasterData\ProductCategoryController@getChildNodes');

/* Customer */
Route::get('customer/{tenant_id}/get-all-customer', 'Customer\CustomerController@getAllCustomer');
Route::get('customer/{tenant_id}/generate-select-customer', 'Customer\CustomerController@generateSelectCustomer');

/* Feedback Product */
Route::post('feedback_product/{tenant_id}/add-feedback-product', 'Feedback\Product\FeedbackProductController@addFeedbackProduct');