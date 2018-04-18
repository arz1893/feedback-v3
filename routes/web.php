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
})->name('landing_page');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/faq', function () {
    return view('faq.faq_selection');
});

Route::get('/feedback_report_selection', function () {
    return view('report.feedback_report_selection');
});

/* Authentication Routes */
Auth::routes();
Route::get('/company-login', 'Auth\LoginController@companyLogin')->name('company_login');
Route::post('/check-tenant', 'Auth\LoginController@checkTenant')->name('check_tenant');
/* end of authentication routes */

/* Password Reset Routes */
//Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password_reset');
//Route::post('password/email', 'Auth\ResetPasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');
/* end of password reset routes */

/* Product Routes */
Route::resource('product', 'MasterData\ProductController');
/* end of product routes */

/* Product Category Routes */
Route::post('product_category/get-category', 'MasterData\ProductCategoryController@getProductCategory');
Route::post('product_category/update-category', 'MasterData\ProductCategoryController@updateProductCategory');
Route::post('product_category/get-childs', 'MasterData\ProductCategoryController@getChilds');
Route::post('product_category/get-trees', 'MasterData\ProductCategoryController@getTrees');
Route::post('product_category/get-category', 'MasterData\ProductCategoryController@getCategory');
Route::post('product_category/add-parent-node', 'MasterData\ProductCategoryController@addParentNode');
Route::post('product_category/add-child-node', 'MasterData\ProductCategoryController@addChildNode');
Route::post('product_category/rename-node', 'MasterData\ProductCategoryController@renameNode');
Route::post('product_category/delete-node', 'MasterData\ProductCategoryController@removeNode');
Route::post('product_category/delete-product-category', 'MasterData\ProductCategoryController@deleteProductCategory');
Route::resource('product_category', 'MasterData\ProductCategoryController');
/* end of product category route */

/* Service Routes */
Route::resource('service', 'MasterData\ServiceController');
/* end of service routes */

/* Service Category Routes */
Route::post('service_category/get-trees', 'MasterData\ServiceCategoryController@getTrees');
Route::post('service_category/get-childs', 'MasterData\ServiceCategoryController@getChilds');
Route::post('service_category/get-category', 'MasterData\ServiceCategoryController@getCategory');
Route::post('service_category/rename-category', 'MasterData\ServiceCategoryController@renameServiceCategory');
Route::post('service_category/delete-category', 'MasterData\ServiceCategoryController@deleteServiceCategory');
Route::post('service_category/add-parent-node', 'MasterData\ServiceCategoryController@addParentNode');
Route::post('service_category/add-child-node', 'MasterData\ServiceCategoryController@addChildNode');
Route::post('service_category/rename-node', 'MasterData\ServiceCategoryController@renameNode');
Route::post('service_category/delete-node', 'MasterData\ServiceCategoryController@deleteNode');
Route::resource('service_category', 'MasterData\ServiceCategoryController');
/* end of service category route */

/* Tag Routes */
Route::resource('tag', 'MasterData\TagController');
Route::post('tag/delete-tag', 'MasterData\TagController@deleteTag');
/* end of tag routes */

/* Faq Product Routes */
Route::resource('faq_product', 'Faq\FaqProductController');
Route::post('faq_product/delete-faq-product', 'Faq\FaqProductController@deleteFaqProduct')->name('delete_faq_product');
/* end of faq product routes */

/* Faq Service Routes */
Route::resource('faq_service', 'Faq\FaqServiceController');
Route::post('faq_service/delete-faq-service', 'Faq\FaqServiceController@deleteFaqService')->name('delete_faq_service');
/* end of faq service routes */

/* Feedback Routes */
Route::resource('feedback', 'Feedback\FeedbackController');
/* end of feedback routes */

/* Feedback Product Routes */
Route::resource('feedback_product', 'Feedback\Product\FeedbackProductController');
/* end of feedback product routes */

/* Feedback Service Routes */
Route::resource('feedback_service', 'Feedback\Service\FeedbackServiceController');
/* end of feedback service routes */

/* Feedback Product List Routes */
Route::resource('feedback_product_list', 'Feedback\Product\FeedbackProductListController');
/* end of feedback product list routes */

/* Feedback Service List Routes */
Route::resource('feedback_service_list', 'Feedback\Service\FeedbackServiceListController');
/* end of feedback service list routes */

/* Question Routes */
Route::resource('question', 'Question\QuestionController');
/* end of question routes */

/* Question List Routes */
Route::resource('question_list', 'Question\QuestionListController');
/* end of question list routes */

/* Customer Routes */
Route::resource('customer', 'Customer\CustomerController');
/* end of customer routes */

/* User Management Routes */
Route::resource('user', 'User\UserController');
Route::post('user/invite', 'User\UserController@sendInvitation');
Route::get('register/accept/{token}', 'Auth\RegisterController@acceptInvitation');
Route::post('register/via-invitation/{id}', 'Auth\RegisterController@registerViaEmail')->name('register_via_invitation');
/* end of user management */

/* Feedback Product Report */
Route::resource('feedback_product_report', 'Report\FeedbackProduct\FeedbackProductReportController');