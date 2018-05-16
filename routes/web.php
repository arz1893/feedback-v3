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
Route::resource('faq_product', 'FAQ\FAQProductController');
/* end of faq product routes */

/* Faq Service Routes */
Route::resource('faq_service', 'FAQ\FAQServiceController');
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
Route::post('user/invite', 'User\UserController@sendInvitation');
Route::get('register/accept/{token}', 'Auth\RegisterController@acceptInvitation');
Route::post('register/via-invitation/{id}', 'Auth\RegisterController@registerViaEmail')->name('register_via_invitation');
Route::resource('user', 'User\UserController');
/* end of user management */

/* Feedback Report All */
Route::get('feedback_report_all/all-rating-report/yearly', 'Report\FeedbackReportAllController@showAllRatingYearly')->name('all_feedback_rating_yearly');
Route::get('feedback_report_all/all-rating-report/monthly', 'Report\FeedbackReportAllController@showAllRatingMonthly')->name('all_feedback_rating_monthly');
Route::get('feedback_report_all/all-global-feedback-report/yearly', 'Report\FeedbackReportAllController@showAllGlobalFeedbackYearly')->name('all_global_feedback_yearly');
Route::get('feedback_report_all/all-global-feedback-report/monthly', 'Report\FeedbackReportAllController@showAllGlobalFeedbackMonthly')->name('all_global_feedback_monthly');
Route::get('feedback_report_all/all-top-satisfaction/yearly', 'Report\FeedbackReportAllController@showAllTopSatisfactionYearly')->name('all_top_satisfaction_yearly');
Route::get('feedback_report_all/all-top-satisfaction/monthly', 'Report\FeedbackReportAllController@showAllTopSatisfactionMonthly')->name('all_top_satisfaction_monthly');
Route::get('feedback_report_all/all-global-summary/monthly', 'Report\FeedbackReportAllController@showGlobalSummaryMonthly')->name('global_summary_monthly');
Route::get('feedback_report_all/all-global-summary/yearly', 'Report\FeedbackReportAllController@showGlobalSummaryYearly')->name('global_summary_yearly');
Route::resource('feedback_report_all', 'Report/FeedbackReportAllController');
/* end of feedback report all */

/* Feedback Product Report */
Route::get('feedback_product__report/top-product/yearly', 'Report\FeedbackProduct\FeedbackProductReportController@showTopProductReportYearly')->name('feedback_product_report_top_yearly');
Route::get('feedback_product_report/top-product/monthly', 'Report\FeedbackProduct\FeedbackProductReportController@showTopProductReportMonthly')->name('feedback_product_report_top_monthly');
Route::get('feedback_product_report/all/yearly', 'Report\FeedbackProduct\FeedbackProductReportController@showAllReportYearly')->name('feedback_product_report_all_yearly');
Route::get('feedback_product_report/all/monthly', 'Report\FeedbackProduct\FeedbackProductReportController@showAllReportMonthly')->name('feedback_product_report_all_monthly');
Route::get('feedback_product_report/{product_id}/show_detail/yearly', 'Report\FeedbackProduct\FeedbackProductReportController@showFeedbackProductReportYearly')->name('feedback_product_report_detail_yearly');
Route::get('feedback_product_report/{product_id}/show_detail/monthly', 'Report\FeedbackProduct\FeedbackProductReportController@showFeedbackProductReportMonthly')->name('feedback_product_report_detail_monthly');
Route::get('feedback_product_report/compare-satisfaction/yearly', 'Report\FeedbackProduct\FeedbackProductReportController@showFeedbackProductCompareYearly')->name('feedback_product_compare_yearly');
Route::get('feedback_product_report/compare-satisfaction/monthly', 'Report\FeedbackProduct\FeedbackProductReportController@showFeedbackProductCompareMonthly')->name('feedback_product_compare_monthly');
Route::resource('feedback_product_report', 'Report\FeedbackProduct\FeedbackProductReportController');
/* end of feedback product report */

/* Feedback Service Report */
Route::get('feedback_service_report/top-service/yearly', 'Report\FeedbackService\FeedbackServiceReportController@showTopServiceReportYearly')->name('feedback_service_report_top_yearly');
Route::get('feedback_service_report/top-service/monthly', 'Report\FeedbackService\FeedbackServiceReportController@showTopServiceReportMonthly')->name('feedback_service_report_top_monthly');
Route::get('feedback_service_report/all/yearly', 'Report\FeedbackService\FeedbackServiceReportController@showAllReportYearly')->name('feedback_service_report_all_yearly');
Route::get('feedback_service_report/all/monthly', 'Report\FeedbackService\FeedbackServiceReportController@showAllReportMonthly')->name('feedback_service_report_all_monthly');
Route::get('feedback_service_report/{service_id}/show_detail/yearly', 'Report\FeedbackService\FeedbackServiceReportController@showFeedbackServiceReportYearly')->name('feedback_service_report_detail_yearly');
Route::get('feedback_service_report/{service_id}/show_detail/monthly', 'Report\FeedbackService\FeedbackServiceReportController@showFeedbackServiceReportMonthly')->name('feedback_service_report_detail_monthly');
Route::get('feedback_service_report/compare-satisfaction/yearly', 'Report\FeedbackService\FeedbackServiceReportController@showFeedbackServiceCompareYearly')->name('feedback_service_compare_yearly');
Route::get('feedback_service_report/compare-satisfaction/monthly', 'Report\FeedbackService\FeedbackServiceReportController@showFeedbackServiceCompareMonthly')->name('feedback_service_compare_monthly');
Route::resource('feedback_service_report', 'Report\FeedbackService\FeedbackServiceReportController');
/* end of feedback service report */

/* Tag Report */
Route::get('tag_report/top-tag-rating/yearly', 'Report\Tag\TagReportController@showTopTagRatingYearly')->name('top_tag_rating_yearly');
Route::resource('tag_report', 'Report\Tag\TagReportController');
/* end of tag report */

/* User Management Route */
Route::resource('manage_user', 'User\UserController');
/* end of user management route */