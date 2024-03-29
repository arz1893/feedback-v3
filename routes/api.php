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
Route::get('tag/{tag_id}/get-tag', 'MasterData\TagController@getTag');
Route::get('tag/{tenant_id}/generate-select-tag', 'MasterData\TagController@generateSelectTag');
Route::post('tag/add-tag', 'MasterData\TagController@addTag');
Route::post('tag/update-tag', 'MasterData\TagController@updateTag');
Route::post('tag/delete-tag', 'MasterData\TagController@deleteTag');

/* Product Category */
Route::get('product_category/{product_id}/get-root-nodes', 'MasterData\ProductCategoryController@getRootNodes');
Route::get('product_category/{node_id}/get-parent-nodes', 'MasterData\ProductCategoryController@getParentNodes');
Route::get('product_category/{parent_id}/get-child-nodes', 'MasterData\ProductCategoryController@getChildNodes');

/* Feedback Product */
Route::get('feedback_product/{tenant_id}/get-feedback-product-list', 'Feedback\Product\FeedbackProductController@getFeedbackProductList');
Route::get('feedback_product/{feedback_id}/get-feedback-product', 'Feedback\Product\FeedbackProductController@getFeedbackProduct');
Route::get('feedback_product/{tenant_id}/filter-by-product/{date_start}/{date_end}/{product_id}', 'Feedback\Product\FeedbackProductController@filterByProduct');
Route::get('feedback_product/{tenant_id}/filter-by-date/{date_start}/{date_end}', 'Feedback\Product\FeedbackProductController@filterByDate');
Route::get('feedback_product/{feedback_id}/generate-selected-customer', 'Feedback\Product\FeedbackProductController@generateSelectedCustomer');
Route::get('feedback_product/{product_id}/get-customer-feedback/yearly/{customer_rating}/{year}', 'Feedback\Product\FeedbackProductController@getProductCustomerFeedbackYearly');
Route::get('feedback_product/{product_id}/get-customer-feedback/monthly/{customer_rating}/{month}/{year}', 'Feedback\Product\FeedbackProductController@getProductCustomerFeedbackMonthly');
Route::post('feedback_product/{tenant_id}/add-feedback-product', 'Feedback\Product\FeedbackProductController@addFeedbackProduct');
Route::post('feedback_product/update-feedback-product', 'Feedback\Product\FeedbackProductController@updateFeedbackProduct');
Route::post('feedback_product/delete-feedback-product', 'Feedback\Product\FeedbackProductController@deleteFeedbackProduct');

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
Route::get('feedback_service/{tenant_id}/filter-by-service/{date_start}/{date_end}/{service_id}', 'Feedback\Service\FeedbackServiceController@filterByService');
Route::get('feedback_service/{tenant_id}/filter-by-date/{date_start}/{date_end}', 'Feedback\Service\FeedbackServiceController@filterByDate');
Route::get('feedback_service/{feedback_id}/generate-selected-customer', 'Feedback\Service\FeedbackServiceController@generateSelectedCustomer');
Route::get('feedback_service/{service_id}/get-customer-feedback/yearly/{customer_rating}/{year}', 'Feedback\Service\FeedbackServiceController@getServiceCustomerFeedbackYearly');
Route::get('feedback_service/{service_id}/get-customer-feedback/monthly/{customer_rating}/{month}/{year}', 'Feedback\Service\FeedbackServiceController@getServiceCustomerFeedbackMonthly');
Route::post('feedback_service/{tenant_id}/add-feedback-service', 'Feedback\Service\FeedbackServiceController@addFeedbackService');
Route::post('feedback_service/update-feedback-service', 'Feedback\Service\FeedbackServiceController@updateFeedbackService');
Route::post('feedback_service/delete-feedback-service', 'Feedback\Service\FeedbackServiceController@deleteFeedbackService');

/* Feedback Service Reply */
Route::get('feedback_service_reply/{feedback_service_id}/get-feedback-service-replies', 'Feedback\Service\FeedbackServiceReplyController@getFeedbackServiceReplies');
Route::post('feedback_service_reply/add-feedback-service-reply', 'Feedback\Service\FeedbackServiceReplyController@addFeedbackServiceReply');
Route::post('feedback_service_reply/{reply_id}/delete-feedback-service-reply', 'Feedback\Service\FeedbackServiceReplyController@deleteFeedbackServiceReply');

/* Customer */
Route::get('customer/{tenant_id}/get-all-customer', 'Customer\CustomerController@getAllCustomer');
Route::get('customer/{customer_id}/get-customer', 'Customer\CustomerController@getCustomer');
Route::get('customer/{tenant_id}/generate-select-customer', 'Customer\CustomerController@generateSelectCustomer');
Route::post('customer/add-customer', 'Customer\CustomerController@addCustomer');
Route::post('customer/update-customer', 'Customer\CustomerController@updateCustomer');
Route::post('customer/delete-customer', 'Customer\CustomerController@deleteCustomer');

/* Question */
Route::get('question/{tenant_id}/get-all-question', 'Question\QuestionController@getAllQuestion');
Route::get('question/{question_id}/get-question', 'Question\QuestionController@getQuestion');
Route::post('question/add-question', 'Question\QuestionController@addQuestion');
Route::post('question/update-question', 'Question\QuestionController@updateQuestion');
Route::post('question/answer-question', 'Question\QuestionController@answerQuestion');
Route::post('question/delete-question', 'Question\QuestionController@deleteQuestion');

/* FAQ Product */
Route::get('faq_product/{product_id}/get-faq-products', 'FAQ\FAQProductController@getFaqProducts');
Route::get('faq_product/{faq_id}/get-faq-product', 'FAQ\FAQProductController@getFaqProduct');
Route::post('faq_product/add-faq-product', 'FAQ\FAQProductController@addFaqProduct');
Route::post('faq_product/update-faq-product', 'FAQ\FAQProductController@updateFaqProduct');
Route::post('faq_product/delete-faq-product', 'FAQ\FAQProductController@deleteFaqProduct');

/* FAQ Service */
Route::get('faq_service/{service_id}/get-faq-services', 'FAQ\FAQServiceController@getFaqServices');
Route::get('faq_service/{faq_id}/get-faq-service', 'FAQ\FAQServiceController@getFaqService');
Route::post('faq_service/add-faq-service', 'FAQ\FAQServiceController@addFaqService');
Route::post('faq_service/update-faq-service', 'FAQ\FAQServiceController@updateFaqService');
Route::post('faq_service/delete-faq-service', 'FAQ\FAQServiceController@deleteFaqService');

/* Feedback Report All */
Route::get('feedback_report_all/{tenantId}/get-all-rating-yearly/{year}', 'Report\FeedbackReportAllController@getAllFeedbackRatingYearly');
Route::get('feedback_report_all/{tenantId}/get-all-rating-monthly/{year}/{month}', 'Report\FeedbackReportAllController@getAllFeedbackRatingMonthly');
Route::get('feedback_report_all/{tenantId}/get-all-global-feedback-yearly/{year}', 'Report\FeedbackReportAllController@getAllGlobalFeedbackYearly');
Route::get('feedback_report_all/{tenantId}/get-all-global-feedback-monthly/{year}/{month}', 'Report\FeedbackReportAllController@getAllGlobalFeedbackMonthly');
Route::get('feedback_report_all/{tenantId}/get-all-top-satisfaction-yearly/{customer_rating}/{year}/{count}', 'Report\FeedbackReportAllController@getAllTopSatisfactionYearly');
Route::get('feedback_report_all/{tenantId}/get-all-top-satisfaction-monthly/{customer_rating}/{year}/{month}/{count}', 'Report\FeedbackReportAllController@getAllTopSatisfactionMonthly');
Route::get('feedback_report_all/{tenantId}/get-global-summary-yearly/{year}', 'Report\FeedbackReportAllController@getGlobalSummaryYearly');
Route::get('feedback_report_all/{tenantId}/get-global-summary-monthly/{year}/{month}', 'Report\FeedbackReportAllController@getGlobalSummaryMonthly');

/* Feedback Product Report */
Route::get('feedback_product_report/{tenant_id}/get-top-product-report-yearly/{customer_rating}/{yearly}/{count}', 'Report\FeedbackProduct\FeedbackProductReportController@getTopProductReportYearly');
Route::get('feedback_product_report/{tenant_id}/get-top-product-report-monthly/{customer_rating}/{yearly}/{month}/{count}', 'Report\FeedbackProduct\FeedbackProductReportController@getTopProductReportMonthly');
Route::get('feedback_product_report/{tenant_id}/get-all-report-yearly/{year}', 'Report\FeedbackProduct\FeedbackProductReportController@getAllReportYearly');
Route::get('feedback_product_report/{tenant_id}/get-all-report-monthly/{year}/{month}', 'Report\FeedbackProduct\FeedbackProductReportController@getAllReportMonthly');
Route::get('feedback_product_report/{product_id}/get-report-detail-yearly/{year}', 'Report\FeedbackProduct\FeedbackProductReportController@getReportDetailYearly');
Route::get('feedback_product_report/{product_id}/get-report-detail-monthly/{year}/{month}', 'Report\FeedbackProduct\FeedbackProductReportController@getReportDetailMonthly');
Route::get('feedback_product_report/{tenant_id}/get-feedback-product-compare-yearly/{year}', 'Report\FeedbackProduct\FeedbackProductReportController@getFeedbackProductCompareYearly');
Route::get('feedback_product_report/{tenant_id}/get-feedback-product-compare-monthly/{year}/{month}', 'Report\FeedbackProduct\FeedbackProductReportController@getFeedbackProductCompareMonthly');

/* Feedback Service Report */
Route::get('feedback_service_report/{tenant_id}/get-top-service-report-yearly/{customer_rating}/{yearly}/{count}', 'Report\FeedbackService\FeedbackServiceReportController@getTopServiceReportYearly');
Route::get('feedback_service_report/{tenant_id}/get-top-service-report-monthly/{customer_rating}/{yearly}/{month}/{count}', 'Report\FeedbackService\FeedbackServiceReportController@getTopServiceReportMonthly');
Route::get('feedback_service_report/{tenant_id}/get-all-report-yearly/{year}', 'Report\FeedbackService\FeedbackServiceReportController@getAllReportYearly');
Route::get('feedback_service_report/{tenant_id}/get-all-report-monthly/{year}/{month}', 'Report\FeedbackService\FeedbackServiceReportController@getAllReportMonthly');
Route::get('feedback_service_report/{service_id}/get-report-detail-yearly/{year}', 'Report\FeedbackService\FeedbackServiceReportController@getReportDetailYearly');
Route::get('feedback_service_report/{service_id}/get-report-detail-monthly/{year}/{month}', 'Report\FeedbackService\FeedbackServiceReportController@getReportDetailMonthly');
Route::get('feedback_service_report/{tenant_id}/get-feedback-service-compare-yearly/{year}', 'Report\FeedbackService\FeedbackServiceReportController@getFeedbackServiceCompareYearly');
Route::get('feedback_service_report/{tenant_id}/get-feedback-service-compare-monthly/{year}/{month}', 'Report\FeedbackService\FeedbackServiceReportController@getFeedbackServiceCompareMonthly');

/* Tag Report */
Route::get('tag_report/{tenant_id}/get-tag-top-satisfaction-yearly/{customer_rating}/{year}/{count}', 'Report\Tag\TagReportController@getTopSatisfactionYearly');
Route::get('tag_report/{tenant_id}/get-tag-top-satisfaction-monthly/{customer_rating}/{year}/{month}/{count}', 'Report\Tag\TagReportController@getTopSatisfactionMonthly');
Route::get('tag_report/{tag_id}/get-report-detail-yearly/{year}', 'Report\Tag\TagReportController@getTagReportDetailYearly');
Route::get('tag_report/{tag_id}/get-report-detail-monthly/{month}/{year}', 'Report\Tag\TagReportController@getTagReportDetailMonthly');

/* User Group */
Route::get('user_group/{tenant_id}/get-all-user-group', 'User\UserGroupController@getTenantUserRoles');

/* User Management */
Route::get('user_management/{tenant_id}/get-all-user', 'User\UserController@getAllUser');
Route::post('user_management/add-user', 'User\UserController@addUser');
Route::post('user_management/delete-user', 'User\UserController@deleteUser');