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
Route::get('product/{tenant_id}/get-all-product', 'MasterData\ProductController@getProductList');
Route::get('product/{tenant_id}/filter-product-list/{tags}', 'MasterData\ProductController@filterProductList');
Route::get('product/{tenant_id}/filter-by-name/{searchString}', 'MasterData\ProductController@filterByName');
Route::get('product/{product_id}/get-product', 'MasterData\ProductController@getProduct');
Route::get('product/{tenant_id}/generate-select-product', 'MasterData\ProductController@generateSelectProduct');
Route::post('product/add-product', 'MasterData\ProductController@addProduct');
Route::post('product/{product_id}/change-picture', 'MasterData\ProductController@changePicture');
Route::post('product/update-product', 'MasterData\ProductController@updateProduct');
Route::post('product/delete-product', 'MasterData\ProductController@deleteProduct');

/* Master Tag */
Route::get('tag/{tenant_id}/get-tag-list', 'MasterData\TagController@getTagList');
Route::get('tag/{tenant_id}/generate-select-tag', 'MasterData\TagController@generateSelectTag');

/* Product Category */
Route::get('product_category/{product_id}/get-root-nodes', 'MasterData\ProductCategoryController@getRootNodes');
Route::get('product_category/{node_id}/get-parent-nodes', 'MasterData\ProductCategoryController@getParentNodes');
Route::get('product_category/{parent_id}/get-child-nodes', 'MasterData\ProductCategoryController@getChildNodes');

/* Feedback Product */
Route::get('feedback_product/{tenant_id}/get-feedback-product-list', 'Feedback\Product\FeedbackProductController@getFeedbackProductList');
Route::get('feedback_product/{feedback_id}/get-feedback-product', 'Feedback\Product\FeedbackProductController@getFeedbackProduct');
Route::get('feedback_product/{tenant_id}/filter-by-product/{product_id}', 'Feedback\Product\FeedbackProductController@filterByProduct');
Route::get('feedback_product/{tenant_id}/filter-by-date/{date_start}/{date_end}', 'Feedback\Product\FeedbackProductController@filterByDate');
Route::post('feedback_product/{tenant_id}/add-feedback-product', 'Feedback\Product\FeedbackProductController@addFeedbackProduct');

/* Feedback Product Reply */
Route::get('feedback_product_reply/{feedback_product_id}/get-feedback-product-replies', 'Feedback\Product\FeedbackProductReplyController@getFeedbackProductReplies');
Route::post('feedback_product_reply/add-feedback-product-reply', 'Feedback\Product\FeedbackProductReplyController@addFeedbackProductReply');
Route::post('feedback_product_reply/{reply_id}/delete-feedback-product-reply', 'Feedback\Product\FeedbackProductReplyController@deleteFeedbackProductReply');

/* Master Service */
Route::get('service/{tenant_id}/get-all-service', 'MasterData\ServiceController@getServiceList');
Route::get('service/{tenant_id}/filter-service-list/{tags}', 'MasterData\ServiceController@filterServiceList');
Route::get('service/{tenant_id}/filter-by-name/{searchString}', 'MasterData\ServiceController@filterByName');
Route::get('service/{service_id}/get-service', 'MasterData\ServiceController@getService');
Route::get('service/{tenant_id}/generate-select-service', 'MasterData\ServiceController@generateSelectService');
Route::post('service/add-service', 'MasterData\ServiceController@addService');
Route::post('service/{service_id}/change-picture', 'MasterData\ServiceController@changePicture');
Route::post('service/update-service', 'MasterData\ServiceController@updateService');
Route::post('service/delete-service', 'MasterData\ServiceController@deleteService');

/* Service Category */
Route::get('service_category/{service_id}/get-root-nodes', 'MasterData\ServiceCategoryController@getRootNodes');
Route::get('service_category/{node_id}/get-parent-nodes', 'MasterData\ServiceCategoryController@getParentNodes');
Route::get('service_category/{parent_id}/get-child-nodes', 'MasterData\ServiceCategoryController@getChildNodes');

/* Feedback Service */
Route::get('feedback_service/{tenant_id}/get-feedback-service-list', 'Feedback\Service\FeedbackServiceController@getFeedbackServiceList');
Route::get('feedback_service/{feedback_id}/get-feedback-service', 'Feedback\Service\FeedbackServiceController@getFeedbackService');
Route::get('feedback_service/{tenant_id}/filter-by-service/{service_id}', 'Feedback\Service\FeedbackServiceController@filterByService');
Route::get('feedback_service/{tenant_id}/filter-by-date/{date_start}/{date_end}', 'Feedback\Service\FeedbackServiceController@filterByDate');
Route::post('feedback_service/{tenant_id}/add-feedback-service', 'Feedback\Service\FeedbackServiceController@addFeedbackService');

/* Feedback Service Reply */
Route::get('feedback_service_reply/{feedback_service_id}/get-feedback-service-replies', 'Feedback\Service\FeedbackServiceReplyController@getFeedbackServiceReplies');
Route::post('feedback_service_reply/add-feedback-service-reply', 'Feedback\Service\FeedbackServiceReplyController@addFeedbackServiceReply');
Route::post('feedback_service_reply/{reply_id}/delete-feedback-service-reply', 'Feedback\Service\FeedbackServiceReplyController@deleteFeedbackServiceReply');

/* Customer */
Route::get('customer/{tenant_id}/get-all-customer', 'Customer\CustomerController@getAllCustomer');
Route::get('customer/{tenant_id}/generate-select-customer', 'Customer\CustomerController@generateSelectCustomer');