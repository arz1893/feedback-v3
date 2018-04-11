<?php

namespace App\Http\Controllers\Feedback\Product;

use App\ComplaintProduct;
use App\Customer;
use App\FeedbackProduct;
use App\Http\Resources\Feedback\FeedbackProductCollection;
use App\Http\Resources\Feedback\FeedbackProduct as FeedbackProductResource;
use App\Product;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Intervention\Image\ImageManagerStatic as InterventionImage;

class FeedbackProductController extends Controller
{
    public function index() {
        return view('feedback.product.feedback_product_index');
    }

    public function show($systemId) {
        $product = Product::findOrFail($systemId);
        return view('feedback.product.feedback_product_show', compact('product'));
    }

    public function edit($id) {

    }

    /* API Section */
    public function addFeedbackProduct(Request $request, $tenant_id) {
        $id = Uuid::generate(4);
        $tenant = Tenant::findOrFail($tenant_id);

        if($request->feedbackProduct['image'] != '') {
            $file_name = $id . '_' . $request->feedbackProduct['fileName'];
            if(!file_exists(public_path('attachment/' . $tenant->email . '/feedback_product/' . $id . '/'))) {
                mkdir(public_path('attachment/' . $tenant->email . '/feedback_product/' . $id . '/'), 0775, true);
            }
            InterventionImage::make($request->feedbackProduct['image'])->save(public_path('attachment/' . $tenant->email . '/feedback_product/' . $id . '/' . $file_name));
            FeedbackProduct::create([
                'systemId' => $id,
                'customer_rating' => $request->feedbackProduct['rating'],
                'customer_feedback' => $request->feedbackProduct['feedback'],
                'is_need_call' => $request->feedbackProduct['need_call'],
                'is_urgent' => $request->feedbackProduct['is_urgent'],
                'customerId' => $request->feedbackProduct['customer']['systemId'],
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $tenant_id,
                'attachment' => 'attachment/' . $tenant->email . '/feedback_product/' . $id . '/' . $file_name,
                'syscreator' => $request->creator
            ]);
        } else {
            FeedbackProduct::create([
                'systemId' => $id,
                'customer_rating' => $request->feedbackProduct['rating'],
                'customer_feedback' => $request->feedbackProduct['feedback'],
                'is_need_call' => $request->feedbackProduct['need_call'],
                'is_urgent' => $request->feedbackProduct['is_urgent'],
                'customerId' => $request->feedbackProduct['customer']['systemId'],
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $tenant_id,
                'syscreator' => $request->creator
            ]);
        }

        return ['message' => 'success'];
    }

    public function getFeedbackProductList($tenant_id){
        $from = date('Y-m-d 00:00:00');
        $to = date('Y-m-d H:i:s');
        $feedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($feedbackProducts);
    }

    public function getFeedbackProduct($feedback_id) {
        $feedbackProduct = FeedbackProduct::findOrFail($feedback_id);
        return new FeedbackProductResource($feedbackProduct);
    }

    public function generateSelectedCustomer($feedback_id) {
        $selectOption = array();
        $feedbackProduct = FeedbackProduct::findOrFail($feedback_id);
        if($feedbackProduct->customer != null) {
            $selectedCustomer = $feedbackProduct->customer;
            array_push($selectOption, ['systemId' => $selectedCustomer->systemId, 'name' => $selectedCustomer->name]);
            return $selectOption;
        } else {
            return null;
        }
    }

    public function filterByProduct(Request $request, $tenant_id, $product_id) {
        $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->where('productId', $product_id)->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($filteredFeedbackProducts);
    }

    public function filterByDate($tenant_id, $start_date, $end_date) {
        $from = date('Y-m-d H:i:s', strtotime($start_date . ' 00:00:00'));
        $to = date('Y-m-d H:i:s', strtotime($end_date . ' 23:59:59'));

        if($from > $to) {
            $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereDate('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(15);
            return new FeedbackProductCollection($filteredFeedbackProducts);
        }

        $filteredFeedbackProducts = FeedbackProduct::where('tenantId', $tenant_id)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(15);
        return new FeedbackProductCollection($filteredFeedbackProducts);
    }

    public function deleteFeedbackProduct(Request $request) {
        $feedbackProduct = FeedbackProduct::findOrFail($request->feedback_id);
        if($feedbackProduct->attachment != null) {
            if(file_exists(public_path($feedbackProduct->attachment))) {
                unlink(public_path($feedbackProduct->attachment));
            }
        }
        $feedbackProduct->delete();

        return ['message' => 'success'];
    }
}
